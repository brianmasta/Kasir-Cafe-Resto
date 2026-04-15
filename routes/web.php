<?php

use App\Livewire\Auth\PinLogin;
use App\Livewire\Dashboard;
use App\Livewire\SelectTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', PinLogin::class);

Route::get('/tables', SelectTable::class)
    ->middleware('auth');

Route::get('/dashboard', Dashboard::class)
    ->middleware('auth');

require __DIR__.'/auth.php';
