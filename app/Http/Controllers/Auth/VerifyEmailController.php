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
use Modules\Customers\Entities\OtpVerification;
use Carbon\Carbon;
use App\Notifications\MobileAppNotification;
use App\Models\Referral;
use App\Models\ReferralMilestone;

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
        /////////////////////////Check referal//////////////////////////
        // Extract the referral code from the request
        dd($request->query('referral_code'));
    $referralCode = $request->query('referral_code');
    if ($referralCode) {
            $referrer = User::where('referral_code', $referralCode)->first();

            if ($referrer) {
                $referral = Referral::create([
                    'referrer_id' => $referrer->id,
                    'referred_id' => $user->id,
                    'referral_code' => $referralCode,
                ]);
    
                // Call the reward function
                $this->rewardReferral($referral);
            }
        }
        /////////////////////////////////////////////////////////////

        return redirect('/login')->with('status', 'Your email has been verified. Credentials sent on your email to login.');
    }

    protected function rewardReferral(Referral $referral)
    {
        $referrer = $referral->referrer;
        $referred = $referral->referred;
    
        $referrer->increment('qr_coins', 5);
        $referred->increment('qr_coins', 5);

        // Update the rewarded_at column
        $referral->rewarded_at = now(); // Set the current timestamp
        $referral->save(); // Save the updated record

        // Assuming $referrer and $referee are the User instances involved in the referral
        $notification = new MobileAppNotification([
            'title' => 'Referral Reward!',
            'body' => 'You have received 5 Qr Coins as referral reward.',
            'additional_data' => [
                // Add any additional data needed for the notification
            ],
        ]);

        // Send notifications to both users
        $notification->sendReferralNotifications($referrer, $referred);
    
        // // Notify the referrer and referred user
        // $referrer->notify(new ReferralRewardNotification($referrer, $referred));
        // $referred->notify(new ReferralRewardNotification($referrer, $referred));
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
