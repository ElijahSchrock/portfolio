<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\HeroCard;
use Livewire\WithFileUploads;

class HeroCardsList extends Component
{
    use WithFileUploads;
    use CanToast;
    
    public $heroCard;
    public $logo;
    public $description;

    protected $rules = [
        'description' => 'required'
    ];

    protected $validationAttributes = [
        'description' => 'description'
    ];

    public function getHeroCardsProperty()
    {
        $cacheKey = 'heroCard-'.$this->__id;

        return cache()->remember($cacheKey, 120, function () {
            return HeroCard::get();
        });
    }

    public function render()
    {
        return view('livewire.hero-cards-list',[
            'heroCards' => $this->heroCards
        ]);
    }

    public function removeFile($toRemove)
    {
        if ($toRemove == 'logo') {
            $this->logo = null;
        } else {
            $this->heroCard = null;
        }
    }

    public function save()
    {
        $this->validate();

        $hero = HeroCard::create([
            'description' => $this->description
        ]);

        $hero->addMedia($this->heroCard->path())
            ->usingName($this->heroCard->getClientOriginalName())
            ->usingFileName($this->heroCard->getClientOriginalName())
            ->toMediaCollectionOnCloudDisk('heroCard');

        $hero->addMedia($this->logo->path())
            ->usingName($this->logo->getClientOriginalName())
            ->usingFileName($this->logo->getClientOriginalName())
            ->toMediaCollectionOnCloudDisk('logo');

        $this->reset();

        return $this->toast('Hero Card Created Successfully!', type:'success');
    }
}
