<?php

namespace Tests\Feature;

use App\Livewire\AdminDashboard;
use App\Livewire\EditProject;
use App\Livewire\Home;
use App\Livewire\ResumeUpload;
use App\Models\Project;
use App\Models\Resume;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class PortfolioTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_pages_require_authentication(): void
    {
        foreach (['/dashboard', '/projects', '/hero-cards', '/resume'] as $path) {
            $this->get($path)->assertRedirect('/login');
        }
    }

    public function test_authenticated_users_can_render_all_admin_pages(): void
    {
        $this->actingAs(User::factory()->owner()->create());

        foreach (['/dashboard', '/projects', '/hero-cards', '/resume'] as $path) {
            $this->get($path)->assertOk();
        }
    }

    public function test_projects_can_be_uploaded_with_a_generated_thumbnail(): void
    {
        $this->actingAs(User::factory()->owner()->create());

        Storage::fake('public');
        config([
            'filesystems.cloud' => 'public',
            'media-library.queue_conversions_by_default' => false,
        ]);

        Livewire::test(AdminDashboard::class)
            ->set('name', 'Local project')
            ->set('site', 'https://example.com/play')
            ->set('repositoryUrl', 'https://github.com/example/project')
            ->set('description', 'Project description')
            ->set('techStack', 'Laravel, Livewire')
            ->set('otherTech', 'SQLite')
            ->set('yearCreated', '2026')
            ->set('fileUpload', UploadedFile::fake()->image('project.jpg', 80, 100))
            ->call('save')
            ->assertHasNoErrors();

        $project = Project::sole();
        $media = $project->getFirstMedia('images');

        $this->assertSame('Local project', $project->name);
        $this->assertSame('https://example.com/play', $project->site);
        $this->assertSame('https://github.com/example/project', $project->repository_url);
        $this->assertSame('public', $media->disk);
        $this->assertTrue($media->hasGeneratedConversion('thumb'));
        Storage::disk('public')->assertExists($media->getPathRelativeToRoot());
        $this->get('/')->assertOk();
    }

    public function test_project_modals_resolve_models_and_save_edits(): void
    {
        $this->actingAs(User::factory()->owner()->create());

        $project = Project::create([
            'name' => 'Original name',
            'description' => 'Project description',
            'tech_stack' => 'Laravel, Livewire',
            'other_tech' => 'SQLite',
            'year_created' => '2026',
        ]);

        Livewire::test('wire-elements-modal')
            ->dispatch('openModal', modalComponent: 'project-modal', arguments: ['project' => $project->id])
            ->assertSee('Project description');

        Livewire::test(EditProject::class, ['project' => $project->fresh()])
            ->set('project.name', 'Updated name')
            ->set('project.showing', false)
            ->call('save')
            ->assertHasNoErrors();

        $this->assertSame('Updated name', $project->fresh()->name);
        $this->assertFalse((bool) $project->fresh()->showing);
    }

    public function test_about_modal_opens_from_the_existing_event(): void
    {
        Livewire::test('wire-elements-modal')
            ->dispatch('openModal', modalComponent: 'about-me-modal')
            ->assertSee('About Me');
    }

    public function test_unknown_year_and_other_technologies_can_stay_blank_in_the_admin_and_public_details(): void
    {
        $this->actingAs(User::factory()->owner()->create());

        Storage::fake('public');
        config([
            'filesystems.cloud' => 'public',
            'media-library.queue_conversions_by_default' => false,
        ]);

        Livewire::test(AdminDashboard::class)
            ->set('name', 'Recovered project')
            ->set('description', 'Recovered description')
            ->set('techStack', 'Laravel, Livewire')
            ->set('fileUpload', UploadedFile::fake()->image('project.jpg', 80, 100))
            ->call('save')
            ->assertHasNoErrors();

        $project = Project::sole();
        $this->assertNull($project->year_created);
        $this->assertNull($project->other_tech);

        Livewire::test(EditProject::class, ['project' => $project])
            ->set('project.name', 'Updated recovered project')
            ->call('save')
            ->assertHasNoErrors();

        Livewire::test('wire-elements-modal')
            ->dispatch('openModal', modalComponent: 'project-modal', arguments: ['project' => $project->id])
            ->assertSee('Updated recovered project')
            ->assertDontSee('Other Technologies:');
    }

    public function test_project_site_can_be_added_changed_and_removed(): void
    {
        $this->actingAs(User::factory()->owner()->create());
        $project = Project::create([
            'name' => 'Playable project',
            'description' => 'Project description',
            'tech_stack' => 'JavaScript',
        ]);

        Livewire::test('project-modal', ['project' => $project])
            ->assertDontSee('Visit live site');

        foreach (['https://example.com/play', 'http://example.com/updated', ''] as $site) {
            Livewire::test(EditProject::class, ['project' => $project->fresh()])
                ->set('project.site', $site)
                ->call('save')
                ->assertHasNoErrors();

            $this->assertSame($site === '' ? null : $site, $project->fresh()->site);
            $modal = Livewire::test('project-modal', ['project' => $project->fresh()]);
            if ($site === '') {
                $modal->assertDontSee('Visit live site');
            } else {
                $modal->assertSee('Visit live site')
                    ->assertSee('href="'.$site.'"', false)
                    ->assertSee('target="_blank"', false);
            }
        }
    }

    public function test_repository_url_can_be_added_changed_and_removed(): void
    {
        $this->actingAs(User::factory()->owner()->create());
        $project = Project::create([
            'name' => 'Playable project',
            'description' => 'Project description',
            'tech_stack' => 'JavaScript',
        ]);

        Livewire::test('project-modal', ['project' => $project])
            ->assertDontSee('View source');

        foreach (['https://example.com/play', 'http://example.com/updated', ''] as $site) {
            Livewire::test(EditProject::class, ['project' => $project->fresh()])
                ->set('project.repository_url', $site)
                ->call('save')
                ->assertHasNoErrors();

            $this->assertSame($site === '' ? null : $site, $project->fresh()->repository_url);
            $modal = Livewire::test('project-modal', ['project' => $project->fresh()]);
            if ($site === '') {
                $modal->assertDontSee('View source');
            } else {
                $modal->assertSee('View source')
                    ->assertSee('href="'.$site.'"', false)
                    ->assertSee('target="_blank"', false);
            }
        }
    }

    public function test_admin_rejects_invalid_or_unsafe_site_urls(): void
    {
        $this->actingAs(User::factory()->owner()->create());
        $project = Project::create([
            'name' => 'Project',
            'description' => 'Project description',
            'tech_stack' => 'JavaScript',
        ]);

        foreach (['javascript:alert(1)', 'ftp://example.com', 'example.com', 'https://example.com/'.str_repeat('a', 2048)] as $site) {
            Livewire::test(AdminDashboard::class)
                ->set('site', $site)
                ->set('repositoryUrl', $site)
                ->call('save')
                ->assertHasErrors(['site', 'repositoryUrl']);

            Livewire::test(EditProject::class, ['project' => $project->fresh()])
                ->set('project.site', $site)
                ->set('project.repository_url', $site)
                ->call('save')
                ->assertHasErrors(['project.site', 'project.repository_url']);
        }

        $this->assertNull($project->fresh()->site);
    }

    public function test_uploaded_resumes_download_from_their_own_storage_disk(): void
    {
        $this->actingAs(User::factory()->owner()->create());

        Storage::fake('public');
        config(['filesystems.cloud' => 'public']);

        Livewire::test(ResumeUpload::class)
            ->set('name', 'Local resume')
            ->set('fileUpload', UploadedFile::fake()->create('resume.pdf', 10, 'application/pdf'))
            ->call('save')
            ->assertHasNoErrors();

        $this->assertSame(1, Resume::where('is_active', true)->count());
        config(['filesystems.cloud' => 'do']);

        Livewire::test(Home::class)
            ->call('downloadResume')
            ->assertFileDownloaded('resume.pdf');
    }

    public function test_resume_link_handles_a_new_database_without_a_resume(): void
    {
        Livewire::test(Home::class)
            ->call('downloadResume')
            ->assertSuccessful();
    }
}
