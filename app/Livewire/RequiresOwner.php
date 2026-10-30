<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Gate;

trait RequiresOwner
{
    public function bootRequiresOwner(): void
    {
        Gate::authorize('manage-portfolio');
    }
}
