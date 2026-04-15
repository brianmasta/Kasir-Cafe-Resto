<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class PinLogin extends Component
{
    public $selectedUser = null; // ID, bukan object
    public $pin = '';

    public function selectUser($id)
    {
        $this->selectedUser = $id;
        $this->pin = '';
    }

    public function login()
    {
    if (!$this->selectedUser) {
        $this->addError('pin', 'Pilih kasir dulu');
        return;
    }

    $user = User::find($this->selectedUser);

    if (!$user || !Hash::check($this->pin, $user->pin)) {
        $this->addError('pin', 'PIN salah');
        $this->pin = '';
        return;
    }

    Auth::login($user);
    return redirect('/tables');
    }

    public function render()
    {
        $users = User::all();
        return view('livewire.auth.pin-login', compact('users'))->layout('layouts.guest');
    }
}
