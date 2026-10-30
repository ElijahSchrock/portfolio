<?php

namespace Tests\Feature;

use App\Livewire\AdminDashboard;
use App\Livewire\EditHeroCard;
use App\Livewire\EditProject;
use App\Livewire\HeroCardsList;
use App\Livewire\ProjectsList;
use App\Livewire\ResumeUpload;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class OwnerAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_existing_non_owner_sessions_cannot_access_admin_pages(): void
    {
        $this->actingAs(User::factory()->create());

        foreach (['/dashboard', '/projects', '/hero-cards', '/resume'] as $path) {
            $this->get($path)->assertForbidden();
        }
    }

    public static function restrictedComponents(): array
    {
        $cases = [];

        foreach ([AdminDashboard::class, EditProject::class, EditHeroCard::class, ProjectsList::class, HeroCardsList::class, ResumeUpload::class] as $component) {
            $cases[$component.' as guest'] = [$component, false];
            $cases[$component.' as non-owner'] = [$component, true];
        }

        return $cases;
    }

    #[DataProvider('restrictedComponents')]
    public function test_admin_components_cannot_be_mounted_without_owner_access(string $component, bool $authenticated): void
    {
        if ($authenticated) {
            $this->actingAs(User::factory()->create());
        }

        Livewire::test($component)->assertForbidden();
        $this->assertDatabaseCount('hero_cards', 0);
    }

    public function test_public_modal_handler_cannot_open_an_admin_editor_for_a_guest(): void
    {
        $project = $this->project();

        Livewire::test('wire-elements-modal')
            ->dispatch('openModal', modalComponent: 'edit-project', arguments: ['project' => $project->id])
            ->assertForbidden();
    }

    public function test_revoking_owner_access_blocks_subsequent_livewire_actions(): void
    {
        $owner = User::factory()->owner()->create();
        $this->actingAs($owner);
        $project = $this->project();
        $component = Livewire::test(ProjectsList::class);

        $owner->forceFill(['is_owner' => false])->save();

        $component->call('deleteProject', $project->id)->assertForbidden();
        $this->assertModelExists($project);
    }

    public function test_owner_status_cannot_be_mass_assigned(): void
    {
        $user = User::create([
            'name' => 'Ordinary user',
            'email' => 'ordinary@example.test',
            'password' => 'irrelevant-test-value',
            'is_owner' => true,
        ]);

        $this->assertFalse($user->fresh()->is_owner);
    }

    private function project(): Project
    {
        return Project::create([
            'name' => 'Protected project',
            'description' => 'Only the owner can edit this.',
            'tech_stack' => 'Laravel',
        ]);
    }
}
