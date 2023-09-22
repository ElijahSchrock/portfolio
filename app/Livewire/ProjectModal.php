<?php

namespace App\Livewire;

use App\Models\Project;
use LivewireUI\Modal\ModalComponent;

class ProjectModal extends ModalComponent
{
    public Project $project;

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function getTechStacksProperty()
    {
        return explode(', ', $this->project->tech_stack);
    }

    public function render()
    {
        return view('livewire.project-modal',[
            'techStacks' => $this->techStacks
        ]);
    }

    public static function modalMaxWidth(): string
    {
        return '5xl';
    }

}
