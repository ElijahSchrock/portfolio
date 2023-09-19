<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class HeroCardsList extends Component
{
    use WithFileUploads;
    
    public $heroCard;
    public $logo;
    public $description;

    protected $rules = [
        'description' => 'required'
    ];

    protected $validationAttributes = [
        'description' => 'description'
    ];

    public function render()
    {
        return view('livewire.hero-cards-list');
    }

    public function removeFile($toRemove)
    {
        ray($toRemove);
        $toRemove = null;
    }
}
