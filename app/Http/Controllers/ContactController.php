<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactQuery;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // Validate form data
        $request->validate([
            'name'    => 'required|max:255',
            'email'   => 'required|email',
            'message' => 'required',
        ]);

        // Store in the database
        ContactQuery::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'message' => $request->message,
        ]);

        // Redirect back with success message
        return redirect('/contact')->with('success', 'Your query has been submitted successfully!');
    }
}
