<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthCheck
{
    public function handle(Request $request, Closure $next, $role)
    {
        Log::info('Middleware authCheck invoked. Session role: ' . session('role') . ', required role: ' . $role);
        if (!session()->has('user_id')) {
            return redirect()->route('auth.page')->with('error', 'Please login first.');
        }

        if (session('role') !== $role) {
            return redirect()->route('auth.page')->with('error', 'Unauthorized access.');
        }

    // if (!session()->has('user_id') || session('role') !== $role) {
    //     return redirect()->route('auth.page')->with('error', 'Unauthorized access.');
    // }
   



        return $next($request);
    }
}
