<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Component;

class Home extends Component
{

    public function getProjectsProperty()
    {
        $cacheKey = 'project-'.$this->__id;

        return cache()->remember($cacheKey, 120, function () {
            return Project::get();
        });
    }
    
    public function render()
    {
        return view('livewire.home',[
            'projects' => $this->projects
        ]);
    }
}
