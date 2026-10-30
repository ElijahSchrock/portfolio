<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ProjectsList extends Component
{
    use RequiresOwner;

    protected $listeners = [
        '$refresh',
        'refreshProjects' => 'onRefreshProjects',
    ];

    #[Computed]
    public function projects()
    {
        return Project::get();
    }

    public function onRefreshProjects()
    {
        unset($this->projects);
    }

    public function render()
    {
        return view('livewire.projects-list', [
            'projects' => $this->projects,
        ]);
    }

    public function deleteProject(Project $project)
    {
        $project->delete();

        $this->dispatch('refreshProjects');
    }
}
