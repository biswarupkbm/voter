<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactQuery;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // validate form
        $request->validate([
            'name'    => 'required|max:255',
            'email'   => 'required|email',
            'message' => 'required',
        ]);

        // store in database
        ContactQuery::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Your query has been submitted successfully!');
    }
}
