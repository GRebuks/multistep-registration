<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Allows access to the app/assets folder
Route::get('assets/{path}', function ($path) {
    return response()->file(storage_path('app/assets/' . $path));
})->where('path', '.*');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');

    Route::get('/shooter', function () {
        return view('shooter');
    })->name('shooter');
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

//logout
Route::get('/logout', function () {
    session_start();
    session_unset();
    session_destroy();
    Auth::guard('web')->logout();
    return redirect('/');
})->name('logout');

Route::post('/register', [RegistrationController::class, 'store'])->name('register');
Route::post('/register/pstep1', [RegistrationController::class, 'validate1'])->name('register.postStep1');
Route::post('/register/pstep2', [RegistrationController::class, 'validate2'])->name('register.postStep2');
Route::post('/register/pstep3', [RegistrationController::class, 'validate3'])->name('register.postStep3');

Route::post('/login', [LoginController::class, 'store'])->name('login.post');

