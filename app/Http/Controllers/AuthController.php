<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\SendOtpMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    // Show combined Sign Up / Sign In form
    public function showForm()
    {
        return view('auth');
    }

    // Handle registration and send email OTP
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'contact' => 'required|string',
            'password' => 'required|min:6',
        ]);

        $otp = rand(100000, 999999);

        // Store user data and OTP in session
        Session::put('otp_user', [
            'name' => $request->name,
            'email' => $request->email,
            'contact' => $request->contact,
            'role' => 'user', // default role
            'password' => bcrypt($request->password),
            'plain_password' => $request->password,
            'otp' => $otp,
        ]);

        // Send OTP email
        Mail::to($request->email)->send(new SendOtpMail($otp, $request->name));


        return redirect()->route('verify.otp.form')
            ->with('success', 'OTP sent to your email')
            ->with('form', 'register');
    }

    // Show OTP verification form
    public function showOtpForm()
    {
        return view('verify-otp');
    }

    // Verify OTP and create user account
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $data = Session::get('otp_user');

        if (!$data || $request->otp != $data['otp']) {
            return back()->with('error', 'Invalid or expired OTP.')->with('form', 'register');
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

        return redirect()->route('login.form')
            ->with('success', 'Registration complete! You may now log in.');
    }

    // Show login form
    public function showLogin()
    {
        return view('auth');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Store session data
            session([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_role' => $user->role,  // Ensure this is set correctly
            ]);

            // Redirect based on role
            if ($user->role === 'admin') {
                return redirect()->route('admin.index');
            } else {
                return redirect()->route('user.index');
            }
        }

        return back()->withErrors(['email' => 'Invalid email or password'])->with('form', 'login');
    }



    // Optional: Admin dashboard (session-based check)
    public function adminDashboard()
    {
        if (session('user_role') === 'admin') {
            return view('admin.index');
        }
        abort(403, 'Unauthorized access');
    }

    // Optional: User dashboard (session-based check)
    public function userDashboard()
    {
        if (session('user_role') === 'user') {
            return view('user.index');
        }
        abort(403, 'Unauthorized access');
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('auth.page')->with('success', 'Logged out successfully.');
    }

}
