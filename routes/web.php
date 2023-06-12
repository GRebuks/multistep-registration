<?php

use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
   return view('login');
})->name('login');

Route::get('/register', function () {
   return view('register');
})->name('register');

Route::post('/register', [RegistrationController::class, 'store'])->name('register');
