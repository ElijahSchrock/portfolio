<?php

namespace App\Livewire;

use App\Models\Project;
use LivewireUI\Modal\ModalComponent;

class EditProject extends ModalComponent
{
    use CanToast;
    use RequiresOwner;

    public Project $project;

    protected $rules = [
        'project.name' => 'required',
        'project.site' => 'nullable|url:http,https|max:2048',
        'project.repository_url' => 'nullable|url:http,https|max:2048',
        'project.description' => 'required',
        'project.showing' => 'boolean',
        'project.tech_stack' => 'required',
        'project.other_tech' => 'nullable|string|max:255',
        'project.year_created' => 'nullable|string|max:255',
    ];

    protected $validationAttributes = [
        'project.name' => 'name',
        'project.site' => 'site',
        'project.repository_url' => 'repository URL',
        'project.description' => 'description',
        'project.tech_stack' => 'tech stack',
        'project.other_tech' => 'other tech',
        'project.year_created' => 'year created',
    ];

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function render()
    {
        return view('livewire.edit-project');
    }

    public function save()
    {
        $this->validate();

        $this->project->update([
            'name' => $this->project->name,
            'site' => filled($this->project->site) ? $this->project->site : null,
            'repository_url' => filled($this->project->repository_url) ? $this->project->repository_url : null,
            'description' => $this->project->description,
            'showing' => $this->project->showing,
            'tech_stack' => $this->project->tech_stack,
            'other_tech' => $this->project->other_tech,
            'year_created' => $this->project->year_created,
        ]);

        $this->toast('Project updated successfully!', type: 'success');

        $this->dispatch('refreshProjects')->to(ProjectsList::class);

        $this->closeModal();
    }
}
