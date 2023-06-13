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
Route::post('/register/pstep1', [RegistrationController::class, 'validate1'])->name('register.postStep1');
Route::post('/register/pstep2', [RegistrationController::class, 'validate2'])->name('register.postStep2');
Route::post('/register/pstep3', [RegistrationController::class, 'validate3'])->name('register.postStep3');