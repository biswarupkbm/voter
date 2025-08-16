<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SubscriberController;

Route::get('/', function () {
    return view('home');
});

Route::get('/auth', function () {
    return view('auth');
})->name('login.page');

Route::get('/student', function () {
    return view('admin.students');
});
// Route::get('/index', function () {
//     return view('admin.index');
// });

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/register', [AuthController::class, 'showForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/subscribe', [SubscriberController::class, 'store'])->name('subscribe');


// Dashboards (protected by middleware)
Route::middleware('role:admin')->get('/admin/dashboard', [AuthController::class, 'adminDashboard'])->name('admin.dashboard');
Route::middleware('role:user')->get('/user/dashboard', [AuthController::class, 'userDashboard'])->name('user.dashboard');

// Admin Dashboard (session-based role check in route closure)
Route::get('/index', function () {
    if (session('user_role') === 'admin') {
        return view('admin.index');
    }
    abort(403, 'Unauthorized access');
})->name('admin.index');

// User Dashboard (session-based role check in route closure)
Route::get('/index', function () {
  if (session('user_role') === 'user') {
        return view('admin.index');
    }
    abort(403, 'Unauthorized access');
})->name('admin.index');
    
// OTP verification routes
Route::get('/verify-otp', [AuthController::class, 'showOtpForm'])->name('verify.otp.form');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.otp.submit');



// Route::resource('members', MemberController::class);
// Route::get('/members', [MemberController::class, 'index'])->name('members.index');
// Route::get('/members/create', [MemberController::class, 'create'])->name('members.create');
// Route::post('/members', [MemberController::class, 'store'])->name('members.store');
// Route::get('/members/{member}/edit', [MemberController::class, 'edit'])->name('members.edit');
// Route::put('/members/{member}', [MemberController::class, 'update'])->name('members.update');
// Route::delete('/members/{member}', [MemberController::class, 'destroy'])->name('members.destroy');

// // Extra endpoints
// Route::post('members/import', [MemberController::class, 'import'])->name('members.import');
// Route::post('/members/{id}/upload-card', [MemberController::class, 'uploadCard']);
// Route::post('members/bulk-upsert', [MemberController::class, 'bulkUpsert'])->name('members.bulkUpsert');
// Route::post('/members/download', [MemberController::class, 'download']);



// -------------------------------
// Members CRUD (without 'show')
// -------------------------------
Route::resource('members', MemberController::class)->except(['show']);

// -------------------------------
// Extra endpoints
// -------------------------------
Route::post('members/import', [MemberController::class, 'import'])->name('members.import');
Route::post('/members/{id}/upload-card', [MemberController::class, 'uploadCard'])->name('members.uploadCard');
Route::post('members/bulk-upsert', [MemberController::class, 'bulkUpsert'])->name('members.bulkUpsert');
// Route::post('/members/download', [MemberController::class, 'download'])->name('members.download');
Route::get('/members/download', [MemberController::class, 'download'])->name('members.download');


// -------------------------------
// Delete all members + images
// -------------------------------
Route::delete('members/delete-all', [MemberController::class, 'deleteAllMembers'])->name('members.deleteAll');
