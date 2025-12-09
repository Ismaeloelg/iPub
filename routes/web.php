<?php

use App\Livewire\ComandaComponent;
use App\Livewire\EditStockComponent;
use App\Livewire\RemoveStockComponent;
use App\Livewire\VentasComponent;
use Illuminate\Support\Facades\Route;

// Rutas públicas
Route::view('/', 'user')->name('welcome');



// RUTAS AUTENTIFICADAS
Route::middleware(['auth', 'conectar.cliente'])->group(function () {

    Route::view('/home', 'home')->name('home');
    // RUTAS ADMIN
    Route::middleware(['role:admin'])->group(function () {
        Route::view('/stock', 'stock')->name('stock');
        Route::view('/show/stock', 'showStock')->name('showStock');
        Route::get('/edit/{productoId}/stock', EditStockComponent::class)->name('editStock');
        Route::view('/categoria', 'categoria')->name('categoria');
        Route::view('/createUser', 'create-user')->name('createUser');
        Route::view('/managerProfile', 'manager-profiles')->name('manager-profile');
        Route::get('/ventas', VentasComponent::class)->name('ventas');
        Route::get('/logout', function () {
            session()->forget('logged_user_id');
            return redirect('/home');
        })->name('logout');


    });

    // Comandas (clientes normales)
    Route::get('/comanda/{mesa}', ComandaComponent::class)->name('comanda');

    // Perfil de usuario
    Route::view('/profile', 'profile')->name('profile');

});
