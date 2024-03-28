<?php

namespace App\Livewire;

use LivewireUI\Modal\ModalComponent;

class AboutMeModal extends ModalComponent
{
    public function render()
    {
        return view('livewire.about-me-modal');
    }
}
