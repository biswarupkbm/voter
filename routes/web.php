<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;

Route::get('/', function () {
    return view('home');
});
Route::get('/contact', function () {
    return view('contact');
});

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

