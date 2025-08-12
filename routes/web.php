<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('index3');
});
Route::get('/auth', function () {
    return view('auth');
});


Route::view('/auth', 'auth')->name('auth');
Route::post('/register', [AuthController::class, 'registerSubmit'])->name('register.submit');
Route::post('/login', [AuthController::class, 'loginSubmit'])->name('login.submit');

Route::get('/dashboard', function () {
    if (session('role') === 'admin') {
        return 'Welcome, Admin!';
    }
    return 'Welcome, User!';
})->name('dashboard');
