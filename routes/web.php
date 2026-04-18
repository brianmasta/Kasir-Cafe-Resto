<?php

use App\Livewire\Auth\PinLogin;
use App\Livewire\Dashboard;
use App\Livewire\KitchenDrink;
use App\Livewire\KitchenFood;
use App\Livewire\MenuManager;
use App\Livewire\SelectTable;
use App\Livewire\TransactionList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', PinLogin::class);

Route::get('/kitchen-food', KitchenFood::class);
Route::get('/kitchen-drink', KitchenDrink::class);

Route::get('/tables', SelectTable::class)
    ->middleware('auth');

Route::get('/dashboard/{tableId}', Dashboard::class)
    ->middleware('auth');

Route::get('/menu', MenuManager::class)->middleware('auth');

Route::get('/transaksi', TransactionList::class)->middleware('auth');

require __DIR__.'/auth.php';
