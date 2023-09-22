<?php

namespace App\Livewire;

use App\Models\Project;
use LivewireUI\Modal\ModalComponent;

class EditProject extends ModalComponent
{
    use CanToast;

    public Project $project;

    protected $rules = [
        'project.name' => 'required',
        'project.description' => 'required',
        'project.showing' => 'boolean',
        'project.tech_stack' => 'required',
        'project.other_tech' => 'required',
        'project.year_created' => 'required'
    ];

    protected $validationAttributes = [
        'project.name' => 'name',
        'project.description' => 'description',
        'project.tech_stack' => 'tech stack',
        'project.other_tech' => 'other tech',
        'project.year_created' => 'year created'
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
            'description' => $this->project->description,
            'showing' => $this->project->showing,
            'tech_stack' => $this->project->tech_stack,
            'other_tech' => $this->project->other_tech,
            'year_created' => $this->project->year_created
        ]);

        $this->toast('Project updated successfully!', type: 'success');

        $this->dispatch('refreshProjects')->to(ProjectsList::class);

        $this->closeModal();
    }
}
