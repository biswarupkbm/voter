<?php

namespace App\Http\Controllers;

use App\Models\Member;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch live statistics from the database
        $totalVoters = Member::count();
        $totalVillages = Member::distinct('village')->count('village');
        $totalPosts = Member::distinct('post')->count('post');
        $totalPanchayats = Member::distinct('panchayath')->count('panchayath');

        // Pass data to the 'home' view
        return view('home', compact('totalVoters', 'totalVillages', 'totalPosts', 'totalPanchayats'));
    }
}

