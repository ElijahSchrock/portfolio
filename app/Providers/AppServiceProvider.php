<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('manage-portfolio', fn (User $user) => $user->is_owner);

        Relation::morphMap([
            'project' => 'App\Models\Project',
            'hero_card' => 'App\Models\HeroCard',
            'resume' => 'App\Models\Resume',
        ]);
    }
}
