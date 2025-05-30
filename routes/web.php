<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Utilisateur;
use App\Http\Livewire\Dashboard;
use App\Http\Controllers\PDFController;


Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::view('users', 'users')
    ->middleware(['auth', 'verified'])
    ->name('users'); 

Route::view('workstation', 'workstation')
    ->middleware(['auth', 'verified'])
    ->name('workstation');

Route::view('people', 'people')
    ->middleware(['auth', 'verified'])
    ->name('people');

Route::get('/imprimer-etats-programme', [PDFController::class, 'generatePDF_Programme'])->name('imprimer_programme.etats');


require __DIR__.'/auth.php';
