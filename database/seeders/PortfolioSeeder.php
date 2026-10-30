<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RuntimeException;
use Spatie\MediaLibrary\HasMedia;

class PortfolioSeeder extends Seeder
{
    public function run(?array $projects = null): void
    {
        $projects ??= require database_path('seeders/data/portfolio.php');

        Validator::make(['projects' => $projects], [
            'projects' => ['array'],
            'projects.*.key' => ['required', 'string', 'alpha_dash:ascii', 'max:100', 'distinct:strict'],
            'projects.*.repository_url' => ['nullable', 'url:http,https', 'max:2048'],
            'projects.*.site' => ['nullable', 'url:http,https', 'max:2048'],
            'projects.*.name' => ['required', 'string', 'max:255'],
            'projects.*.description' => ['required', 'string'],
            'projects.*.tech_stack' => ['required', 'string', 'max:255'],
            'projects.*.other_tech' => ['nullable', 'string', 'max:255'],
            'projects.*.year_created' => ['nullable', 'string', 'max:255'],
            'projects.*.showing' => ['sometimes', 'boolean'],
            'projects.*.image' => ['sometimes', 'nullable', 'string'],
            'projects.*.hero' => ['sometimes', 'array'],
            'projects.*.hero.banner' => ['required_with:projects.*.hero', 'string'],
            'projects.*.hero.logo' => ['required_with:projects.*.hero', 'string'],
            'projects.*.hero.order' => ['sometimes', 'integer', 'min:0'],
        ])->validate();

        if ($projects === []) {
            $this->command?->info('No portfolio seed entries configured in database/seeders/data/portfolio.php.');

            return;
        }

        $destinationDisk = config('filesystems.cloud');

        if ($destinationDisk === 'do' && blank(trim((string) config('media-library.prefix'), '/'))) {
            throw new RuntimeException('Set MEDIA_PREFIX to a new folder, such as portfolio, before importing into Spaces.');
        }

        if ($destinationDisk === 'do') {
            $destinationPrefix = trim(config('media-library.prefix'), '/').'/';

            foreach ($projects as $entry) {
                foreach ([$entry['image'] ?? '', $entry['hero']['banner'] ?? '', $entry['hero']['logo'] ?? ''] as $sourceKey) {
                    if (str_starts_with($sourceKey ?? '', $destinationPrefix)) {
                        throw new RuntimeException('MEDIA_PREFIX overlaps the seed source files. Choose a new destination folder.');
                    }
                }
            }
        }

        foreach ($projects as $entry) {
            $project = Project::firstOrCreate(['seed_key' => $entry['key']], [
                'name' => $entry['name'],
                'site' => $entry['site'] ?? null,
                'repository_url' => $entry['repository_url'] ?? null,
                'description' => $entry['description'],
                'tech_stack' => $entry['tech_stack'],
                'other_tech' => $entry['other_tech'] ?? null,
                'year_created' => $entry['year_created'] ?? null,
                'showing' => $entry['showing'] ?? true,
            ]);

            $this->attachMissingMedia($project, 'images', $entry['image'] ?? null, $destinationDisk);

            if (isset($entry['hero'])) {
                $hero = $project->heroCard()->firstOrCreate([], [
                    'order' => $entry['hero']['order'] ?? 0,
                ]);

                $this->attachMissingMedia($hero, 'heroCard', $entry['hero']['banner'], $destinationDisk);
                $this->attachMissingMedia($hero, 'logo', $entry['hero']['logo'], $destinationDisk);
            }
        }
    }

    private function attachMissingMedia(Model&HasMedia $model, string $collection, ?string $sourceKey, string $destinationDisk): void
    {
        if (blank($sourceKey) || $model->hasMedia($collection)) {
            return;
        }

        if (! Storage::disk('do')->exists($sourceKey)) {
            throw new RuntimeException("Spaces seed file does not exist: {$sourceKey}");
        }

        // The bucket originals remain available for other sites and subsequent imports.
        $model->addMediaFromDisk($sourceKey, 'do')
            ->preservingOriginal()
            ->withCustomProperties(['seed_source' => $sourceKey])
            ->toMediaCollection($collection, $destinationDisk);
    }
}
