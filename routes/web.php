<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');

    Route::get('/shooter', function () {
        return view('shooter');
    })->name('shooter');

    Route::get('/home', function () {
        return view('home');
    })->name('home');
    Route::get('/logout', function () {
        session_start();
        session_unset();
        session_destroy();
        Auth::guard('web')->logout();
        return redirect('/');
    })->name('logout');

    // Inventory
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/edit/{id}', [InventoryController::class, 'edit'])->name('inventory.edit');
    Route::post('/inventory/delete/{id}', [InventoryController::class, 'destroy'])->name('inventory.delete');
    Route::get('/inventory/create', [InventoryController::class, 'create'])->name('inventory.create');
    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
    Route::post('/inventory/{id}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::get('/inventory/search/{search}', [InventoryController::class, 'search'])->name('inventory.search');
    Route::get('inventory/get/{search}/{sort}/{direction}', [InventoryController::class, 'get'])->name('inventory.get');

    // Profile
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.post');
    Route::post('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.password.post');
    Route::post('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.delete.post');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    session_start();
    session_unset();
    session_destroy();
    return view('register');
})->name('register');

Route::post('/register', [RegistrationController::class, 'store'])->name('register');
Route::post('/register/pstep1', [RegistrationController::class, 'validate1'])->name('register.postStep1');
Route::post('/register/pstep2', [RegistrationController::class, 'validate2'])->name('register.postStep2');
Route::post('/register/pstep3', [RegistrationController::class, 'validate3'])->name('register.postStep3');

Route::post('/login', [LoginController::class, 'store'])->name('login.post');
