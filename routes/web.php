<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', \App\Livewire\AdminDashboard::class)->name('dashboard');
    Route::get('/projects', \App\Livewire\ProjectsList::class)->name('projects');
    Route::get('/hero-cards', \App\Livewire\HeroCardsList::class)->name('hero-cards');
    Route::get('/resume', \App\Livewire\ResumeUpload::class)->name('resume');
});
