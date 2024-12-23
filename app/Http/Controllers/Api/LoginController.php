<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Userprofile;
use Modules\Customers\Entities\Customer;
use Illuminate\Support\Str;
use App\Notifications\CustomVerifyEmail;
use App\Notifications\MobileAppNotification;
use Modules\Mobilesettings\Entities\Appinformation; 

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
            'device_token' => 'required|min:6',
            'platform' => 'required|in:android,ios',
        ]);
        if ($validator->fails()) {
            $errorMessage = $validator->errors()->first();
            $response = [
                'status'  => false,
                'message' => $errorMessage,
            ];
        return response()->json($response, 401);
        }
     
        $credentials = $request->only('email', 'password');

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'Either the email or password is incorrect'], 401);
        }

        $user = Auth::guard('api')->user();
        //return response()->json(['user' => $user->hasRole('user')], 401);

         // Check if the user's email is verified
         if (!$user->hasVerifiedEmail()) {
            Auth::guard('api')->logout();
            return response()->json(['error' => 'Unauthorized - Email not verified'], 401);
        }

        // Check if the user has the 'user' role
        if (!$user->hasRole('user')) {
            Auth::guard('api')->logout();
            return response()->json(['error' => 'Unauthorized - Invalid Role'], 401);
        }

        // Update device_token and platform in the user record
        $user->device_token = $request->device_token;
        $user->platform = $request->platform;
        $user->save();

        $notificationData = [
            'title' => 'Login Activity Detected',
            'body' => 'We have detected login activity on your account.',
            'additional_data' => [],
        ];

        $user->notify(new MobileAppNotification($notificationData));

        return $this->respondWithToken($token,'Successfully logged in.', $user->first_time_login);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
        ]);
        if ($validator->fails()) {
            $errorMessage = $validator->errors()->first();
            $response = [
                'status'  => false,
                'message' => $errorMessage,
            ];
        return response()->json($response, 401);
        }
        // Check if the email already exists manually (not required since 'unique' validation will handle it)
        if (User::where('email', $request->email)->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Email already exists.'
            ], 409); // Conflict status code
        }
        $password = Str::random(12);
        do {
            $referral_code = strtoupper(Str::random(5));
        } while (User::where('referral_code', $referral_code)->exists()); // Ensure uniqueness
        
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($password),
            "name" => $request->first_name . ' ' . $request->last_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'referral_code' => $referral_code,
            // other user attributes here
        ]);
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

        $user->notify(new CustomVerifyEmail($referral_code));
    
    
        return response()->json(['message' => 'Please check your email to verify your account.']);
    }

    protected function respondWithToken($token,$message = null,$new_user=null)
    {
        return response()->json([
            'message' => $message,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
            'first_time_login' => $new_user,
        ]);
    }

    public function logout()
    {
        Auth::guard('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(Auth::guard('api')->refresh(),'Token successfully refreshed.');
    }

    public function me()
    {
        return response()->json(Auth::guard('api')->user());
    }

    public function changePassword(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            $errorMessage = $validator->errors()->first();
            $response = [
                'status'  => false,
                'message' => $errorMessage,
            ];
        return response()->json($response, 401);
        }

        $user = Auth::guard('api')->user();
        
        // Check if the current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['error' => 'Unauthorized - The current password is incorrect'], 401);
        }

        // Update the password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password successfully changed']);
    }

    public function setUpNewPassword(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'new_password' => 'required|min:6',
            'confirm_new_password' => 'required|same:new_password|min:6',
        ]);
        if ($validator->fails()) {
            $errorMessage = $validator->errors()->first();
            $response = [
                'status'  => false,
                'message' => $errorMessage,
            ];
        return response()->json($response, 401);
        }

        $user = Auth::guard('api')->user();   
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }     
        // Check if the new password is the same as the current password
        if (Hash::check($request->new_password, $user->password)) {
            return response()->json(['error' => 'New password cannot be the same as the current password'], 400);
        }

        // Update the password
        $user->password = Hash::make($request->new_password);
        $user->first_time_login = false;
        $user->save();

        return response()->json(['message' => 'Password changed successfully']);
    }

    public function AboutUs(Request $request)
    {
        $aboutUs = Appinformation::where('type', 'about_us')->first();
        return response()->json(['message' => 'Data get successfully', 'data'=>$aboutUs]);
    }

    public function privacyPolicy(Request $request)
    {
        $privacyPolicy = Appinformation::where('type', 'privacy_policy')->first();
        return response()->json(['message' => 'Data get successfully', 'data'=>$privacyPolicy]);
    }

    public function helpSupport(Request $request)
    {
        $helpSupport = Appinformation::where('type', 'help_support')->first();
        return response()->json(['message' => 'Data get successfully', 'data'=>$helpSupport]);
    }

}
