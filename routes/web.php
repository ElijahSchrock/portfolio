<?php

use App\Livewire\AdminDashboard;
use App\Livewire\HeroCardsList;
use App\Livewire\ProjectsList;
use App\Livewire\ResumeUpload;
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
    'can:manage-portfolio',
])->group(function () {
    Route::get('/dashboard', AdminDashboard::class)->name('dashboard');
    Route::get('/projects', ProjectsList::class)->name('projects');
    Route::get('/hero-cards', HeroCardsList::class)->name('hero-cards');
    Route::get('/resume', ResumeUpload::class)->name('resume');
});
