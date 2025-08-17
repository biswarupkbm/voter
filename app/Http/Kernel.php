<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use App\Http\Middleware\AuthCheck;


class Kernel extends HttpKernel
{
    protected $routeMiddleware = [

        // Your middleware alias
        'authCheck' => \App\Http\Middleware\AuthCheck::class,
    ];
}

