<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Support\Facades\Hash;

class ShowDataController extends Controller
{
    // Show both Users and Contacts
    public function index()
    {
        $users = User::all();
        $contacts = Contact::all();
        return view('showdata', compact('users', 'contacts'));
    }

    // Store new User
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'contact' => 'required',
            'role' => 'required|in:user,admin',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'contact' => $request->contact,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        session(['edit_mode' => true]);
        return redirect()->back()->with('success', 'User added successfully!');
    }

    // Update User
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'contact' => 'required',
            'role' => 'required|in:user,admin',
            'password' => 'nullable|min:6',
        ]);

        $data = $request->only(['name', 'email', 'contact', 'role']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        session(['edit_mode' => true]);
        return redirect()->back()->with('success', 'User updated successfully!');
    }

    // Delete single User
    public function destroy($id)
    {
        User::destroy($id);
        session(['edit_mode' => true]);
        return redirect()->back()->with('success', 'User deleted!');
    }

    // Delete all Users
    public function deleteAll()
    {
        User::truncate();
        session(['edit_mode' => true]);
        return redirect()->back()->with('success', 'All users deleted!');
    }

    // =================== CONTACT METHODS ===================

    // Update Contact
    public function updateContact(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'subject' => 'nullable|string',
            'message' => 'required',
        ]);

        $contact->update($request->only(['name', 'email', 'phone', 'subject', 'message']));

        session(['edit_mode' => true]);
        return redirect()->back()->with('success', 'Contact updated!');
    }

    // Delete single Contact
    public function destroyContact($id)
    {
        Contact::destroy($id);
        session(['edit_mode' => true]);
        return redirect()->back()->with('success', 'Contact deleted!');
    }

    // Delete all Contacts
    public function deleteAllContacts()
    {
        Contact::truncate();
        session(['edit_mode' => true]);
        return redirect()->back()->with('success', 'All contacts deleted!');
    }
}
