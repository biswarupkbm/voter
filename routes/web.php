<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;

Route::get('/', function () {
  return view('home');
});

Route::view('/auth', 'auth')->name('auth');
Route::post('/register', [AuthController::class, 'registerSubmit'])->name('register.submit');
Route::post('/login', [AuthController::class, 'loginSubmit'])->name('login.submit');


// OTP verification routes
Route::get('/verify-otp', [AuthController::class, 'showVerifyOtpForm'])->name('verify.otp.form');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.otp');


Route::get('/dashboard', function () {
    if (session('role') === 'admin' || session('role') === 'user') {
        return view('admin.index');
    };
})->name('index');

Route::get('/login', function () {
    return view('contact');
});


Route::get('/create', [MemberController::class, 'create'])->name('members.create');
Route::post('/members', [MemberController::class, 'store'])->name('members.store');
Route::get('/members', [MemberController::class, 'index'])->name('members.index');


Route::get('/student', function () {
    return view('admin.students');
});
Route::get('/index', function () {
    return view('admin.index');
});



