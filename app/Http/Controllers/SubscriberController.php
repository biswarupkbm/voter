<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;

class SubscriberController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscribers,email',
        ]);

        Subscriber::create([
            'email' => $request->email,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Thank you for subscribing!'
            ]);
        }

        return back()->with('success', 'Thank you for subscribing!');
    }
}
