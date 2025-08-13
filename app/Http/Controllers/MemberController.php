<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::latest()->get();
        return view('members.index', compact('members'));
    }
public function create()
{
    return view('create'); // Make sure you have this blade file
}

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required',
            'father_name' => 'required',
            'voter_id'    => 'required',
            'gender'      => 'required',
            'village'     => 'required',
            'post'        => 'required',
            'panchayath'  => 'required',
            'mandal'      => 'required',
            'state'       => 'required',
        ]);

        Member::create($request->all());

        return redirect()->route('members.index')->with('success', 'Member added successfully.');
    }

    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        $request->validate([
            'name'        => 'required',
            'father_name' => 'required',
            'voter_id'    => 'required',
            'gender'      => 'required',
            'village'     => 'required',
            'post'        => 'required',
            'panchayath'  => 'required',
            'mandal'      => 'required',
            'state'       => 'required',
        ]);

        $member->update($request->all());

        return redirect()->route('members.index')->with('success', 'Member updated successfully.');
    }

    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $member->delete();

        return redirect()->route('members.index')->with('success', 'Member deleted successfully.');
    }
}
