<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Component;

class ProjectsList extends Component
{
    protected $listeners = [
        '$refresh',
        'refreshProjects' => 'onRefreshProjects'
    ];

    public function getProjectsProperty()
    {
        $cacheKey = 'project-'.$this->__id;

        return cache()->remember($cacheKey, 120, function () {
            return Project::get();
        });
    }
    
    public function onRefreshProjects()
    {
        cache()->forget('project-'.$this->__id);
    }

    public function render()
    {
        return view('livewire.projects-list', [
            'projects' => $this->projects
        ]);
    }

    public function deleteProject(Project $project)
    {
        $project->delete();

        $this->dispatch('refreshProjects');
    }
}
