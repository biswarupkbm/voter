<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;

class AuthController extends Controller
{
    // Register & Send OTP
    public function registerSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'contact' => 'required|string|max:20',
            'password' => 'required|min:6',
            'otp_method' => 'required|in:email'
        ]);

        // Create user but mark as unverified
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'contact' => $request->contact,
            'password' => Hash::make($request->password),
            'role' => 'user', // Default role
            'email_verified_at' => null
        ]);

        // Generate OTP
        $otp = rand(100000, 999999);

        // Store OTP & user ID in session
        session([
            'otp' => $otp,
            'temp_user_id' => $user->id
        ]);

        // Send OTP via email
        if ($request->otp_method === 'email') {
            Mail::to($user->email)->send(new SendOtpMail($otp));
        }

        // Redirect to OTP verification form
        return redirect()->route('verify.otp.form')->with('success', 'OTP sent to your email!');
    }

    // Show OTP Verification Form
    public function showVerifyOtpForm()
    {
        return view('verify_otp');
    }

    // Verify OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric'
        ]);

        if ($request->otp == session('otp')) {
            // Mark user as verified
            $user = User::find(session('temp_user_id'));
            if ($user) {
                $user->email_verified_at = now();
                $user->save();
            }

            // Clear OTP from session
            session()->forget(['otp', 'temp_user_id']);

            return redirect()->route('login')->with('success', 'Email verified successfully! You can now log in.');
        } else {
            return back()->withErrors(['otp' => 'Invalid OTP, please try again.']);
        }
    }

    // Login
    public function loginSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return redirect()->back()->withErrors(['Invalid email or password'])->with('form', 'login');
        }

        // Block login if email is not verified
        if (is_null($user->email_verified_at)) {
            return redirect()->back()->withErrors(['Your email is not verified!'])->with('form', 'login');
        }

        session([
            'user_id' => $user->id,
            'role' => $user->role
        ]);

        return redirect()->route('index');
    }
}
