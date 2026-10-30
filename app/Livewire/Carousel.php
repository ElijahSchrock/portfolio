<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

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
        if (count($this->heroCards) < 2) {
            return;
        }

        $this->activeIndex = ($this->activeIndex + 1) % count($this->heroCards);
    }

    public function prev()
    {
        if (count($this->heroCards) < 2) {
            return;
        }

        $this->activeIndex = ($this->activeIndex - 1 + count($this->heroCards)) % count($this->heroCards);
    }

    public function render()
    {
        return view('livewire.carousel');
    }
}
