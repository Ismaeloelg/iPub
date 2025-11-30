<?php

use App\Livewire\ComandaComponent;
use App\Livewire\EditStockComponent;
use App\Livewire\RemoveStockComponent;
use App\Models\Stock;
use Illuminate\Support\Facades\Route;

Route::view('/', 'user')->name('welcome');

Route::view('/home', 'home')
    ->middleware('auth')
    ->name('home');

Route::view('/stock', 'stock')
    ->middleware('auth', 'role:admin')
    ->name('stock');

Route::view('/show/stock', 'showStock')
    ->middleware('auth', 'role:admin')
    ->name('showStock');

Route::get('/edit/{productoId}/stock', EditStockComponent::class)
    ->middleware('auth', 'role:admin')
    ->name('editStock');

Route::view('/categoria', 'categoria')
    ->middleware('auth', 'role:admin')
    ->name('categoria');

Route::view('/profile', 'profile')
    ->middleware('auth')
    ->name('profile');

Route::view('/createUser', 'create-user')
    ->middleware('auth', 'role:admin')
    ->name('createUser');

Route::view('/managerProfile', 'manager-profiles')
    ->middleware('auth', 'role:admin')
    ->name('manager-profile');

Route::get('/comanda/{mesa}', ComandaComponent::class)
    ->middleware('auth')
    ->name('comanda');

Route::get('/logout', function () {
    session()->forget('logged_user_id');
    return redirect()->route('welcome');
})->name('logout');
