<?php

namespace App\Livewire;

use App\Models\HeroCard;
use App\Models\Project;
use App\Models\Resume;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Home extends Component
{
    #[Computed]
    public function projects()
    {
        return Project::get();
    }

    #[Computed]
    public function heroCards()
    {
        return HeroCard::query()
            ->with('project')
            ->orderBy('order')
            ->get();
    }

    public function render()
    {
        return view('livewire.home', [
            'projects' => $this->projects,
            'heroCards' => $this->heroCards,
        ]);
    }

    #[Computed]
    public function resume()
    {
        return Resume::where('is_active', true)->first();
    }

    public function downloadResume()
    {
        $media = $this->resume?->getFirstMedia('file');

        if ($media && Storage::disk($media->disk)->exists($media->getPathRelativeToRoot())) {
            return Storage::disk($media->disk)->download($media->getPathRelativeToRoot(), $media->file_name);
        }
    }
}
