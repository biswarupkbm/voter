<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;

class RegisterController
{
    public function showForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'contact' => 'required|string',
            'role' => 'required|in:user,admin',
            'password' => 'required|min:6',
            'otp_method' => 'required|in:email,contact',
        ]);

        $otp = rand(100000, 999999);

        // Store user data and OTP in session
        Session::put('otp_user', [
            'name' => $request->name,
            'email' => $request->email,
            'contact' => $request->contact,
            'role' => $request->role,
            'password' => bcrypt($request->password),
            'plain_password' => $request->password, // optional: if needed for editing later
            'otp' => $otp,
            'otp_method' => $request->otp_method,
        ]);

        // Send OTP via email or contact (SMS)
        if ($request->otp_method === 'email') {
            // ✅ Send OTP email with name included
            Mail::to($request->email)->send(new SendOtpMail($otp, $request->name));
        } else {
            // Simulate SMS (log only)
            logger("Send SMS OTP $otp to " . $request->contact);
            // In production, replace with real SMS API
        }

        return redirect()->route('verify.otp.form')->with('success', 'OTP sent to your ' . $request->otp_method);
    }

    public function showOtpForm()
    {
        return view('verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        // Validate OTP input
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $data = Session::get('otp_user');

        if (!$data || $request->otp != $data['otp']) {
            return back()->with('error', 'Invalid or expired OTP.');
        }

        // Create user account
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'contact' => $data['contact'],
            'role' => $data['role'],
            'password' => $data['password'], // already hashed
        ]);

        Session::forget('otp_user');

        return redirect()->route('login.form')->with('success', 'Registration complete! You may now log in.');
    }
}
