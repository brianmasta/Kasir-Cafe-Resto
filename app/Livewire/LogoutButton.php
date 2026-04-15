<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LogoutButton extends Component
{
    public function logout()
    {
        Auth::logout();

        session()->forget('table_id');
        session()->forget('table_name');
        session()->invalidate();
        session()->regenerateToken();
        session()->flash('message', 'Berhasil logout');
        
        return redirect('/');
    }

    public function render()
    {
        return view('livewire.logout-button');
    }
}
