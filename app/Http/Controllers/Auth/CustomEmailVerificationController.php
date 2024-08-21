<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;

class CustomEmailVerificationController extends Controller
{
    public function showVerifyEmailForm()
    {
        return view('auth.verify-email');
    }

    public function verifyEmail(EmailVerificationRequest $request)
    {
        dd('hhjfhfh');
        $request->fulfill();

        return redirect('/login')->with('status', 'Your email has been verified. You can now log in.');
    }

    public function resendVerificationEmail(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'Verification link sent!');
    }

    public function checkEmailVerification()
    {
        if (!Auth::user()->hasVerifiedEmail()) {
            Auth::logout();
            return redirect()->route('login')->withErrors(['email' => 'You need to verify your email address before logging in.']);
        }

        return redirect()->intended('dashboard');
    }
}
