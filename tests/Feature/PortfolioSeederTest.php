<?php

namespace Tests\Feature;

use App\Models\HeroCard;
use App\Models\Project;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\PortfolioSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use RuntimeException;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Tests\TestCase;

class PortfolioSeederTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('do');
        Storage::fake('public');
        config([
            'filesystems.cloud' => 'public',
            'media-library.prefix' => 'portfolio',
            'media-library.queue_conversions_by_default' => false,
        ]);
    }

    public function test_seed_imports_projects_hero_cards_and_media_while_preserving_source_files(): void
    {
        $this->putSourceImages();
        $this->seedPortfolio();

        $project = Project::sole();
        $hero = HeroCard::sole();
        $cover = $project->getFirstMedia('images');

        $this->assertSame('example-project', $project->seed_key);
        $this->assertSame('Example Project', $project->name);
        $this->assertSame($project->id, $hero->project_id);
        $this->assertSame(2, $hero->order);
        $this->assertTrue($cover->hasGeneratedConversion('thumb'));
        $this->assertSame('legacy/cover.jpg', $cover->getCustomProperty('seed_source'));
        $this->assertSame(3, Media::count());

        foreach (Media::all() as $media) {
            Storage::disk('public')->assertExists($media->getPathRelativeToRoot());
        }

        foreach (['cover', 'banner', 'logo'] as $name) {
            $this->assertSame(
                file_get_contents(public_path('headshot.jpeg')),
                Storage::disk('do')->get("legacy/{$name}.jpg"),
            );
        }
    }

    public function test_repeated_seeding_preserves_admin_edits_and_does_not_duplicate_media(): void
    {
        $this->putSourceImages();
        $this->seedPortfolio();

        Project::sole()->update(['name' => 'Edited in admin', 'showing' => false]);
        HeroCard::sole()->update(['order' => 7]);
        $originalMediaIds = Media::orderBy('id')->pluck('id')->all();

        // Existing attachments no longer depend on the source objects staying available.
        Storage::disk('do')->delete(['legacy/cover.jpg', 'legacy/banner.jpg', 'legacy/logo.jpg']);
        $this->seedPortfolio();

        $this->assertDatabaseCount('projects', 1);
        $this->assertDatabaseCount('hero_cards', 1);
        $this->assertDatabaseCount('media', 3);
        $this->assertSame('Edited in admin', Project::sole()->name);
        $this->assertFalse((bool) Project::sole()->showing);
        $this->assertSame(7, HeroCard::sole()->order);
        $this->assertSame($originalMediaIds, Media::orderBy('id')->pluck('id')->all());
    }

    public function test_import_can_resume_after_a_missing_file_is_supplied(): void
    {
        $this->putSourceImages();
        Storage::disk('do')->delete('legacy/logo.jpg');

        try {
            $this->seedPortfolio();
            $this->fail('A missing Spaces object should stop the import.');
        } catch (RuntimeException $exception) {
            $this->assertStringContainsString('legacy/logo.jpg', $exception->getMessage());
        }

        $this->assertDatabaseCount('media', 2);
        $this->putSourceImages();
        $this->seedPortfolio();

        $this->assertDatabaseCount('projects', 1);
        $this->assertDatabaseCount('hero_cards', 1);
        $this->assertDatabaseCount('media', 3);
    }

    public function test_same_bucket_import_uses_a_separate_prefix_and_preserves_originals(): void
    {
        config(['filesystems.cloud' => 'do']);
        $this->putSourceImages();
        $this->seedPortfolio();

        foreach (Media::all() as $media) {
            $this->assertSame('do', $media->disk);
            $this->assertStringStartsWith('portfolio/', $media->getPathRelativeToRoot());
            Storage::disk('do')->assertExists($media->getPathRelativeToRoot());
        }

        Storage::disk('do')->assertExists(['legacy/cover.jpg', 'legacy/banner.jpg', 'legacy/logo.jpg']);
    }

    public function test_spaces_destination_requires_an_explicit_prefix_before_creating_records(): void
    {
        config(['filesystems.cloud' => 'do', 'media-library.prefix' => '']);

        try {
            $this->seedPortfolio();
            $this->fail('A Spaces import should require a separate destination prefix.');
        } catch (RuntimeException $exception) {
            $this->assertStringContainsString('MEDIA_PREFIX', $exception->getMessage());
        }

        $this->assertDatabaseCount('projects', 0);
        $this->assertDatabaseCount('media', 0);
    }

    public function test_duplicate_seed_keys_are_rejected_before_creating_records(): void
    {
        try {
            app(PortfolioSeeder::class)->run([$this->entry(), $this->entry()]);
            $this->fail('Duplicate project keys should fail validation.');
        } catch (ValidationException $exception) {
            $this->assertArrayHasKey('projects.0.key', $exception->errors());
        }

        $this->assertDatabaseCount('projects', 0);
    }

    public function test_spaces_import_rejects_overlapping_source_and_destination_folders(): void
    {
        config(['filesystems.cloud' => 'do', 'media-library.prefix' => 'legacy']);

        try {
            $this->seedPortfolio();
            $this->fail('A Spaces import should require separate source and destination folders.');
        } catch (RuntimeException $exception) {
            $this->assertStringContainsString('overlaps', $exception->getMessage());
        }

        $this->assertDatabaseCount('projects', 0);
    }

    public function test_spaces_listing_returns_only_images_under_the_requested_prefix(): void
    {
        $this->putSourceImages();
        Storage::disk('do')->put('legacy/notes.txt', 'Not an image');
        Storage::disk('do')->put('elsewhere/photo.png', 'Other image');

        $this->artisan('portfolio:spaces-files', ['--prefix' => 'legacy', '--limit' => '1', '--json' => true])
            ->expectsOutputToContain('legacy/')
            ->doesntExpectOutputToContain('notes.txt')
            ->doesntExpectOutputToContain('elsewhere/')
            ->assertSuccessful();

        Storage::disk('do')->assertExists(['legacy/cover.jpg', 'legacy/banner.jpg', 'legacy/logo.jpg']);
    }

    public function test_spaces_listing_rejects_invalid_limits(): void
    {
        $this->artisan('portfolio:spaces-files', ['--limit' => '0'])
            ->expectsOutput('The limit must be an integer from 1 to 500.')
            ->assertFailed();
    }

    public function test_incomplete_hero_metadata_is_rejected_before_creating_records(): void
    {
        $entry = $this->entry();
        unset($entry['hero']['logo']);

        try {
            app(PortfolioSeeder::class)->run([$entry]);
            $this->fail('A hero card should require both its banner and logo keys.');
        } catch (ValidationException $exception) {
            $this->assertArrayHasKey('projects.0.hero.logo', $exception->errors());
        }

        $this->assertDatabaseCount('projects', 0);
    }

    public function test_empty_manifest_can_be_seeded_without_spaces_credentials(): void
    {
        app(PortfolioSeeder::class)->run([]);

        $this->assertDatabaseCount('projects', 0);
        $this->assertDatabaseCount('media', 0);
    }

    public function test_recovered_manifest_imports_all_projects_and_artwork_without_inventing_years(): void
    {
        $entries = require database_path('seeders/data/portfolio.php');

        foreach ($entries as $entry) {
            foreach ([$entry['image'], $entry['hero']['banner'], $entry['hero']['logo']] as $key) {
                Storage::disk('do')->put($key, file_get_contents(public_path('headshot.jpeg')));
            }
        }

        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseCount('projects', 8);
        $this->assertDatabaseCount('hero_cards', 8);
        $this->assertDatabaseCount('media', 24);
        $this->assertSame(0, Project::whereNotNull('year_created')->count());
        $this->assertSame('Laravel, Livewire, Alpine.js', Project::where('seed_key', 'phantom-portrait-poltergeist')->sole()->tech_stack);

        foreach (Project::with('heroCard')->get() as $project) {
            $this->assertTrue($project->hasMedia('images'));
            $this->assertTrue($project->heroCard->hasMedia('heroCard'));
            $this->assertTrue($project->heroCard->hasMedia('logo'));
        }
    }

    public function test_unknown_optional_metadata_can_be_omitted_from_seed_entries(): void
    {
        $this->putSourceImages();
        $entry = $this->entry();
        unset($entry['year_created'], $entry['other_tech']);

        app(PortfolioSeeder::class)->run([$entry]);

        $this->assertNull(Project::sole()->year_created);
        $this->assertNull(Project::sole()->other_tech);
    }

    public function test_database_seeder_runs_the_portfolio_seeder(): void
    {
        $this->partialMock(PortfolioSeeder::class, function ($mock) {
            $mock->shouldReceive('run')->once()->andReturnNull();
        });

        $this->seed(DatabaseSeeder::class);
    }

    private function seedPortfolio(): void
    {
        app(PortfolioSeeder::class)->run([$this->entry()]);
    }

    private function putSourceImages(): void
    {
        foreach (['cover', 'banner', 'logo'] as $name) {
            Storage::disk('do')->put("legacy/{$name}.jpg", file_get_contents(public_path('headshot.jpeg')));
        }
    }

    private function entry(): array
    {
        return [
            'key' => 'example-project',
            'name' => 'Example Project',
            'description' => 'A seeded portfolio project.',
            'tech_stack' => 'Laravel, Livewire',
            'other_tech' => 'SQLite',
            'year_created' => '2026',
            'image' => 'legacy/cover.jpg',
            'hero' => [
                'banner' => 'legacy/banner.jpg',
                'logo' => 'legacy/logo.jpg',
                'order' => 2,
            ],
        ];
    }
}
