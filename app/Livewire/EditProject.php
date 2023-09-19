<?php

namespace App\Livewire;

use App\Models\Project;
use LivewireUI\Modal\ModalComponent;

class EditProject extends ModalComponent
{
    use CanToast;

    public Project $project;
    public $name;
    public $description;
    public $showing = true;

    protected $rules = [
        'name' => 'required',
        'description' => 'required',
        'showing' => 'boolean'
    ];

    protected $validationAttributes = [
        'name' => 'name',
        'description' => 'description'
    ];

    public function mount(Project $project)
    {
        $this->project = $project;
        $this->name = $project->name;
        $this->description = $project->description;
        $this->showing = $project->showing;
    }

    public function render()
    {
        return view('livewire.edit-project');
    }

    public function save()
    {
        $this->validate();

        $this->project->update([
            'name' => $this->name,
            'description' => $this->description,
            'showing' => $this->showing
        ]);

        $this->toast('Project updated successfully!', type: 'success');

        $this->dispatch('refreshProjects')->to(ProjectsList::class);

        $this->closeModal();
    }
}
