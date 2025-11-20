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
    ->middleware('auth')
    ->name('stock');

Route::view('/show/stock', 'showStock')
    ->middleware('auth')
    ->name('showStock');

Route::get('/edit/{productoId}/stock', EditStockComponent::class)
    ->middleware('auth')
    ->name('editStock');

Route::view('/categoria', 'categoria')
    ->middleware('auth')
    ->name('categoria');

Route::get('/comanda/{mesa}', ComandaComponent::class)
    ->middleware('auth')
    ->name('comanda');
