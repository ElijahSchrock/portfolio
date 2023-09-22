<?php

namespace App\Livewire;

use App\Models\HeroCard;
use LivewireUI\Modal\ModalComponent;
use Livewire\WithFileUploads;

class EditHeroCard extends ModalComponent
{
    use CanToast;
    use WithFileUploads;

    public HeroCard $heroCard;

    public $bannerUpload;
    public $logoUpload;

    protected $listeners = [
        '$refresh'
    ];

    protected $rules = [
        'heroCard.order' => 'required|integer'
    ];

    protected $validationAttributes = [
        'heroCard.order' => 'order'
    ];
    
    public function mount(HeroCard $heroCard)
    {
        $this->heroCard = $heroCard;

        if (! $this->heroCard->getKey())
        {
            $this->heroCard = HeroCard::create([
                'order' => 0
            ]);
        }
    }

    public function render()
    {
        return view('livewire.edit-hero-card');
    }

    public function editImage($value)
    {
        $this->heroCard->getFirstMedia($value)->delete();

        $this->dispatch('$refresh');
        $this->dispatch('refreshHeroCards')->to(HeroCardsList::class);
    }

    public function updatedBannerUpload()
    {
        $this->heroCard->addMedia($this->bannerUpload->path())
            ->usingName($this->bannerUpload->getClientOriginalName())
            ->usingFileName($this->bannerUpload->getClientOriginalName())
            ->toMediaCollectionOnCloudDisk('heroCard');

        $this->dispatch('$refresh');
    }

    public function updatedLogoUpload()
    {
        $this->heroCard->addMedia($this->logoUpload->path())
            ->usingName($this->logoUpload->getClientOriginalName())
            ->usingFileName($this->logoUpload->getClientOriginalName())
            ->toMediaCollectionOnCloudDisk('logo');

        $this->dispatch('$refresh');
    }

    public function save()
    {
        $this->validate();

        $this->heroCard->update([
            'order' => $this->heroCard->order
        ]);

        $this->closeModalWithEvents([
            \App\Livewire\HeroCardsList::class => 'refreshHeroCards'
        ]);

        return $this->toast('Hero card updated successfully!', type: 'success');
    }
}
