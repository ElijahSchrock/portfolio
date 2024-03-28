<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\HeroCard;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Livewire\Attributes\Computed;

class HeroCardsList extends Component
{
    use WithFileUploads;
    use CanToast;

    #[Computed]
    public function heroCards()
    {
        $cacheKey = 'heroCard-'.$this->__id;

        return cache()->remember($cacheKey, 120, function () {
            return HeroCard::query()
                ->orderBy('order')
                ->get();
        });
    }

    #[On('refreshHeroCards')]
    public function onRefreshHeroCards()
    {
        cache()->forget('heroCard-'.$this->__id);
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
