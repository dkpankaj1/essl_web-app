<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }
    public function loginProcess(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->remember)) {
            $request->session()->regenerate();
            $notification = ['message' => "Login Success!!", 'alert-type' => 'success'];
            return redirect()->route('home')->with($notification);
        } else {
            throw ValidationException::withMessages([
                'email' => "invalid login detail.",
            ]);
        }
    }
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
    public function profile(Request $request)
    {
        return view('profile',['user' => Auth::user()]);
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'email' => $request->email,
            'password' => Hash::make($validated['password']),
        ]);
        $notification = ['message' => 'Profile update success', 'alert-type' => 'success'];

        return back()->with('status', $notification);
    }
}
