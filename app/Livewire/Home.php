<?php

namespace App\Livewire;

use App\Models\Resume;
use App\Models\Project;
use Livewire\Component;
use App\Models\HeroCard;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Storage;

class Home extends Component
{

    public function getProjectsProperty()
    {
        $cacheKey = 'project-' . $this->__id;

        return cache()->remember($cacheKey, 120, function () {
            return Project::get();
        });
    }

    public function getHeroCardsProperty()
    {
        $cacheKey = 'hero-' . $this->__id;

        return cache()->remember($cacheKey, 120, function () {
            return HeroCard::query()
                ->with('project')
                ->orderBy('order')
                ->get();
        });
    }

    public function render()
    {
        return view('livewire.home', [
            'projects' => $this->projects,
            'heroCards' => $this->heroCards
        ]);
    }

    #[Computed]
    public function resume()
    {
        return Resume::where('is_active', true)->first();
    }

    public function downloadResume()
    {
        $path = $this->resume->getFirstMedia("file")->getPath();
        $fileName = $this->resume->getFirstMedia("file")->file_name;

        if (Storage::cloud()->exists($path)) {
            return Storage::disk("do")->download($path, $fileName);
        }
    }
}
