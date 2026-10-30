<?php

namespace App\Livewire;

use App\Models\HeroCard;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class HeroCardsList extends Component
{
    use CanToast;
    use RequiresOwner;
    use WithFileUploads;

    #[Computed]
    public function heroCards()
    {
        return HeroCard::query()
            ->orderBy('order')
            ->get();
    }

    #[On('refreshHeroCards')]
    public function onRefreshHeroCards()
    {
        unset($this->heroCards);
    }

    public function render()
    {
        return view('livewire.hero-cards-list');
    }

    public function deleteCard(HeroCard $heroCard)
    {
        $heroCard->delete();

        $this->dispatch('refreshHeroCards');
    }
}
