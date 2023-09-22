<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class Carousel extends Component
{
    public $heroCards;
    public $activeIndex = 0;

    public function mount($heroCards)
    {
        $this->heroCards = $heroCards;
    }

    #[On('next')]
    public function next()
    {
        $this->activeIndex = ($this->activeIndex + 1) % count($this->heroCards);
    }
    
    public function prev()
    {
        $this->activeIndex = ($this->activeIndex - 1 + count($this->heroCards)) % count($this->heroCards);
    }

    public function render()
    {
        return view('livewire.carousel');
    }
}

