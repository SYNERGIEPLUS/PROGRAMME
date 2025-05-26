<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Utilisateur;
use App\Http\Livewire\Dashboard;


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

require __DIR__.'/auth.php';
