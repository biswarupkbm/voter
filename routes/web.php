<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;

Route::get('/', function () {
  return view('home');
});
Route::get('/hm', function () {
  return view('admin.index');
});
Route::get('/hj', function () {
  return view('user.index');
});


Route::get('/auth', function () {
    return view('auth');
})->name('auth.page');

Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::get('/verify-otp', [AuthController::class, 'showOtpForm'])->name('verify.otp.form');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.otp.submit');

Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['authCheck:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.index');
    })->name('admin.dashboard');
});

Route::middleware(['authCheck:user'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('user.index');
    })->name('user.dashboard');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');






// Route::view('/auth', 'auth')->name('auth');
// Route::post('/register', [AuthController::class, 'registerSubmit'])->name('register.submit');
// Route::post('/login', [AuthController::class, 'loginSubmit'])->name('login.submit');
// Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
// Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);



// // OTP verification routes
// Route::get('/verify-otp', [AuthController::class, 'showVerifyOtpForm'])->name('verify.otp.form');
// Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.otp');


// Route::get('/dashboard', function () {
//     if (session('role') === 'admin' || session('role') === 'user') {
//         return view('admin.index');
//     };
// })->name('index');

// Route::get('/login', function () {
//     return view('contact');
// });


// Route::get('/create', [MemberController::class, 'create'])->name('members.create');
// Route::post('/members', [MemberController::class, 'store'])->name('members.store');
// Route::get('/members', [MemberController::class, 'index'])->name('members.index');


// Route::get('/student', function () {
//     return view('admin.students');
// });
// Route::get('/index', function () {
//     return view('admin.index');
// });



