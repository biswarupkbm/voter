<?php

namespace App\Http\Controllers;

use App\Mail\SendOtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users',
            'contact'    => 'required',
            'otp_method' => 'required|in:email',
            'password'   => 'required|min:6',
        ]);

        // Create user but set as unverified
        $user = new User();
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->contact  = $request->contact;
        $user->role     = 'user'; // default
        $user->password = Hash::make($request->password);
        $user->is_verified = false; // you need this column
        $user->save();

        // Generate OTP
        $otp = rand(100000, 999999);

        // Store OTP in session
        Session::put('otp', $otp);
        Session::put('otp_email', $request->email);

        // Send OTP Email
        Mail::to($request->email)->send(new SendOtpMail($otp));

        return redirect()->route('verify.otp.form')->with('success', 'OTP sent to your email.');
    }

    public function showOtpForm()
    {
        return view('verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        if ($request->otp != Session::get('otp')) {
            return back()->with('error', 'Invalid OTP.');
        }

        // Mark user as verified
        $email = Session::get('otp_email');
        $user = User::where('email', $email)->first();
        if ($user) {
            $user->is_verified = true;
            $user->save();
        }

        // Clear OTP from session
        Session::forget(['otp', 'otp_email']);

        return redirect()->route('auth.page')->with('form', 'login')->with('success', 'Email verified! You can now log in.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Invalid email or password.');
        }

        if (!$user->is_verified) {
            return back()->with('error', 'Please verify your email first.');
        }

        session([
            'user_id' => $user->id,
            'role' => $user->role,
            'is_verified' => $user->is_verified,
        ]);

        // Redirect based on role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('auth.page')->with('success', 'Logged out successfully.');
    }

}
