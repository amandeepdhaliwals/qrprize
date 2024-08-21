<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\URL;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Notifications\UserAccountCreated;
use Illuminate\Support\Str;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        if (!hash_equals($hash, sha1($user->getEmailForVerification()))) {
            return redirect('/')->withErrors(['email' => 'Invalid verification link.']);
        }

        if ($user->hasVerifiedEmail()) {
            return redirect('/')->with('status', 'Email already verified.');
        }

        $user->markEmailAsVerified();
        event(new Verified($user));

        ///////////////////////otp verify//////////////////////////// 
        $otpCodeEmail = rand(100000, 999999);
        OtpVerification::create([
            'user_id' => $id,
            'otp_code' => $otpCodeEmail,
            'type' => 'email',
            'is_verified' => 1,
            'expires_at' => Carbon::now()->addMinutes(5)
        ]);
        ////////////////////////////////////////////////////////////////////

        /////////////////generate new password and send on mail/////////////

        // Generate a new random password
        $newPassword = Str::random(8);

        // Update user's password
        $user->password = Hash::make($newPassword);
        $user->save();

        $data = ['password' => $newPassword];
        $user->notify(new UserAccountCreated($data));
        /////////////////////////////////////////////////////////////////////

        return redirect('/login')->with('status', 'Your email has been verified. Credentials sent on your email to login.');
    }
    // public function __invoke(EmailVerificationRequest $request)
    // {

    //     if ($request->user()->hasVerifiedEmail()) {
    //         return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
    //     }

    //     if ($request->user()->markEmailAsVerified()) {
    //         event(new Verified($request->user()));
    //     }

    //     return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
    // }
}
