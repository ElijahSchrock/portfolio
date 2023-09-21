<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\HeroCard;
use Livewire\WithFileUploads;

class HeroCardsList extends Component
{
    use WithFileUploads;
    use CanToast;

    protected $listeners = [
        'refreshHeroCards' => 'onRefreshHeroCards'
    ];

    public function getHeroCardsProperty()
    {
        $cacheKey = 'heroCard-'.$this->__id;

        return cache()->remember($cacheKey, 120, function () {
            return HeroCard::get();
        });
    }

    public function onRefreshHeroCards()
    {
        cache()->forget('heroCard-'.$this->__id);
    }

    public function render()
    {
        return view('livewire.hero-cards-list',[
            'heroCards' => $this->heroCards
        ]);
    }

    public function deleteCard(HeroCard $heroCard)
    {
        $heroCard->delete();

        $this->dispatch('refreshHeroCards');
    }
}
