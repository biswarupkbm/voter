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
        return view('create');
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
            'voter_card'  => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('voter_card')) {
            $filePath = $request->file('voter_card')->store('uploads/voter_cards', 'public');
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
            'voter_card'  => $filePath,
        ]);

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
            'voter_card'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $updatedData = $request->only([
            'name',
            'father_name',
            'voter_id',
            'gender',
            'village',
            'post',
            'panchayath',
            'mandal',
            'state'
        ]);

        if ($request->hasFile('voter_card')) {
            $path = $request->file('voter_card')->store('uploads/voter_cards', 'public');
            $updatedData['voter_card'] = $path;
        }

        $changes = array_diff_assoc($updatedData, $member->only(array_keys($updatedData)));

        if (empty($changes)) {
            return response()->json([
                'success'    => true,
                'no_changes' => true
            ]);
        }

        $member->update($updatedData);

        return response()->json([
            'success' => true,
            'message' => 'Member updated successfully.'
        ]);
    }

    public function destroy($id)
    {
        $member = Member::find($id);
        if (!$member) {
            return response()->json(['success' => false, 'message' => 'Member not found'], 404);
        }

        // Optional: delete image from storage if exists
        if ($member->voter_card && \Storage::disk('public')->exists($member->voter_card)) {
            \Storage::disk('public')->delete($member->voter_card);
        }

        $member->delete();

        return response()->json(['success' => true]);
    }
}
