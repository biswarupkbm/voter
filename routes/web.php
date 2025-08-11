<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index3');
});
Route::get('/contact', function () {
    return view('contact');
});

Route::get('/login', function () {
    return view('contact');
});
