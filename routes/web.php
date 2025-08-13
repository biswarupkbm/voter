<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;

Route::get('/', function () {
  return view('home');
});


// Auth routes
Route::get('/auth', function () {
  return view('auth');
})->name('login.page');

Route::get('/register', [AuthController::class, 'showForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');


Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboards (protected by middleware)
Route::middleware('role:admin')->get('/admin/dashboard', [AuthController::class, 'adminDashboard'])->name('admin.dashboard');
Route::middleware('role:user')->get('/user/dashboard', [AuthController::class, 'userDashboard'])->name('user.dashboard');

// Admin Dashboard (session-based role check in route closure)
Route::get('/admin/dashboard', function () {
    if (session('user_role') === 'admin') {
        return view('admin.index');
    }
    abort(403, 'Unauthorized access');
})->name('admin.dashboard');

// User Dashboard (session-based role check in route closure)
Route::get('/user/dashboard', function () {
      if (session('user_role') === 'user') {
            return view('dashboard.user');
        }
        abort(403, 'Unauthorized access');
    })->name('user.dashboard');
    

    // OTP verification routes
    Route::get('/verify-otp', [AuthController::class, 'showOtpForm'])->name('verify.otp.form');
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.otp.submit');

Route::get('/create', [MemberController::class, 'create'])->name('members.create');
Route::post('/members', [MemberController::class, 'store'])->name('members.store');
Route::get('/members', [MemberController::class, 'index'])->name('members.index');


Route::get('/student', function () {
    return view('admin.students');
});
Route::get('/index', function () {
    return view('admin.index');
});
