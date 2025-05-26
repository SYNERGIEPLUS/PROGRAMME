<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;

class LogoutButton extends Component
{
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function render()
    {
        return view('livewire.logout-button');
    }
}
