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
        'project.showing' => 'boolean'
    ];

    protected $validationAttributes = [
        'project.name' => 'name',
        'project.description' => 'description'
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
            'showing' => $this->project->showing
        ]);

        $this->toast('Project updated successfully!', type: 'success');

        $this->dispatch('refreshProjects')->to(ProjectsList::class);

        $this->closeModal();
    }
}
