<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Show all members.
     */
    public function index()
    {
        $members = Member::latest()->get();
        return view('index', compact('members'));
    }

    /**
     * Show the form to create a new member.
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a new member in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'voter_id'    => 'required|string|max:50|unique:members,voter_id',
            'gender'      => 'required|in:Male,Female',
            'village'     => 'required|string|max:255',
            'post'        => 'required|string|max:255',
            'panchayath'  => 'required|string|max:255',
            'mandal'      => 'required|string|max:255',
            'state'       => 'required|string|max:255',
            'voter_card'  => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        // Handle file upload
        $filePath = null;
        if ($request->hasFile('voter_card')) {
            $filePath = $request->file('voter_card')->store('voter_cards', 'public');
        }

        Member::create([
            'name'        => $request->name,
            'father_name' => $request->father_name,
            'voter_id'    => $request->voter_id,
            'gender'      => $request->gender,
            'village'     => $request->village,
            'post'        => $request->post,
            'panchayath'  => $request->panchayath,
            'mandal'      => $request->mandal,
            'state'       => $request->state,
            'voter_card'  => $filePath
        ]);

        return redirect()->back()->with('success', 'Member added successfully!');
    }

    /**
     * Show the form to edit a member.
     */
    public function edit($id)
    {
        $member = Member::findOrFail($id);
        return view('edit', compact('member'));
    }

    /**
     * Update an existing member in the database.
     */
    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'voter_id'    => 'required|string|max:50|unique:members,voter_id,' . $id,
            'gender'      => 'required|in:Male,Female',
            'village'     => 'required|string|max:255',
            'post'        => 'required|string|max:255',
            'panchayath'  => 'required|string|max:255',
            'mandal'      => 'required|string|max:255',
            'state'       => 'required|string|max:255',
            'voter_card'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        // Handle file upload if new file provided
        if ($request->hasFile('voter_card')) {
            $filePath = $request->file('voter_card')->store('voter_cards', 'public');
            $member->voter_card = $filePath;
        }

        $member->update([
            'name'        => $request->name,
            'father_name' => $request->father_name,
            'voter_id'    => $request->voter_id,
            'gender'      => $request->gender,
            'village'     => $request->village,
            'post'        => $request->post,
            'panchayath'  => $request->panchayath,
            'mandal'      => $request->mandal,
            'state'       => $request->state,
            'voter_card'  => $member->voter_card
        ]);

        return redirect()->back()->with('success', 'Member updated successfully!');
    }

    /**
     * Delete a member from the database.
     */
    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $member->delete();

        return redirect()->back()->with('success', 'Member deleted successfully!');
    }
    
}
