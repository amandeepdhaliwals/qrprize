<?php

namespace App\Http\Controllers\Auth;

use App\Events\Frontend\UserRegistered;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Models\Userprofile;
use Modules\Customers\Entities\Customer;
use Illuminate\Support\Str;
use Modules\Customers\Entities\OtpVerification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'first_name' => ['required', 'string', 'max:191'],
    //         'last_name' => ['required', 'string', 'max:191'],
    //         'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
    //         'password' => ['required', 'confirmed', Rules\Password::defaults()],
    //     ]);

    //     $user = User::create([
    //         'first_name' => $request->first_name,
    //         'last_name' => $request->last_name,
    //         'name' => $request->first_name.' '.$request->last_name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //     ]);

    //     // username
    //     $username = intval(config('app.initial_username')) + $user->id;
    //     $user->username = strval($username);
    //     $user->save();

    //     event(new Registered($user));
    //     event(new UserRegistered($user));

    //     Auth::login($user);

    //     return redirect(RouteServiceProvider::HOME);
    // }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'mobile' => 'required|numeric|digits_between:10,12|unique:users',
        ]);
    
        // Create the user and customer profiles
        $data = $request->except('_token');
        $data['name'] = $request->first_name . ' ' . $request->last_name;
        $data['password'] = Hash::make(Str::random(8)); // Generate random password
        $user = User::create($data);
        $user->assignRole('user');
    
        // Create user profile and customer records
        Userprofile::create([
            'user_id' => $user->id,
            "name" => $request->first_name . ' ' . $request->last_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => config('app.initial_username') + $user->id,
            'email' => $request->email,
            'mobile' => $request->mobile,
        ]);
    
        Customer::create([
            'user_id' => $user->id,
            'store_id' => 0, 
            'campaign_id' => 0, 
            'advertisement_id' => 0, 
        ]);

        event(new Registered($user));
        // event(new UserRegistered($user));

        // Auth::login($user);

        // return redirect(RouteServiceProvider::HOME);
        return redirect()->route('register')->with('status', 'Please check your email to verify your account.');
    
        // $updateUser = User::where("id", $user->id)->first();
        // if ($updateUser) {
        //     $updateUser->username = $username;
        //     $updateUser->save();
        // }


       // Log::info(label_case($module_title.' '.$module_action).' - New user created.');
       // $this->storeAuditTrail($id, 'user_created', ['user_id' => $$module_name_singular->id]);

        // $otpCodes = $this->generateAndSendOtp($user->id);
        // return response()->json([
        //     'response_type' => 'success',
        //     'user_id' => Crypt::encryptString($user->id),
        //     'status' => 'otp_send',
        // ]);
    }

    private function generateAndSendOtp($userId)
    {
        $module_title = 'Otp';
        $module_action = 'generate and send otp';
        // Check if there are any OTP verification records for the user
        $existingRecords = OtpVerification::where('user_id', $userId)->exists();
        // If OTP verification records exist for the user, delete them
        if ($existingRecords) {
            OtpVerification::where('user_id', $userId)->delete();
        }
    
        // Generate new OTP code for email
        $otpCodeEmail = rand(100000, 999999);
        OtpVerification::create([
            'user_id' => $userId,
            'otp_code' => $otpCodeEmail,
            'type' => 'email',
            'is_verified' => 0,
            'expires_at' => Carbon::now()->addMinutes(5)
        ]);
    
        // Send the OTP via email or mobile
        $user = User::find($userId);
       // Notification::send($user, new OTPNotification($otpCodeEmail));
    
        //  Log::info(label_case($module_title.' '.$module_action). ' - OTP generated and sent.');
        //  $this->storeAuditTrail($userId, 'otp_generated', ['user_id' => $userId]);
    
        return [
            'email_otp' => $otpCodeEmail,
        ];
    }
    
}
