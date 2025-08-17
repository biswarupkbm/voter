<?php

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthCheck
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Log the session role for debugging
        Log::info('Middleware authCheck invoked. Session role: ' . session('user_role') . ', required role: ' . $role);

        // Check if user is logged in and role matches
        if (!session()->has('user_id')) {
            return redirect()->route('auth.page')->with('error', 'Please login first.');
        }

        // Verify the user role in session
        if (session('user_role') !== $role) {
            return redirect()->route('auth.page')->with('error', 'Unauthorized access.');
        }

        return $next($request);
    }
}
