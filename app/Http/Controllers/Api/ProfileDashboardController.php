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


class profileDashboardController extends Controller
{
    public function getProfileCompletion()
    {
        $user = Auth::user(); // or JWTAuth::parseToken()->authenticate();

        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
        $userProfile = UserProfile::where('user_id', $user->id)->first();
        
        if (!$userProfile) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $completion = $userProfile->calculateCompletion();

        return response()->json($completion);
    }


    public function updateProfile(Request $request)
    {
        $user = Auth::user(); // or JWTAuth::parseToken()->authenticate();

        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
        $id = $user->id;
        // Find the user profile by ID
        $userProfile = UserProfile::where('user_id', $id)->first();
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,' . $id, // Exclude current user's email
            'mobile' => 'nullable|numeric|unique:users,mobile,' . $id, // Exclude current user's mobile
            'gender' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'interests' => 'nullable|array',
            'hobbies' => 'nullable|array',
            'occupation_name' => 'nullable|string|max:255',
            'college_name' => 'nullable|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'url_facebook' => 'nullable|url',
            'url_youtube' => 'nullable|url',
            'url_instagram' => 'nullable|url',
            'url_linkedin' => 'nullable|url',
            'url_website' => 'nullable|url',
        ]);

        // If validation fails, return the errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        // Update the fields in the user profile
        if ($request->has('name')) {
            $name = $request->name;
            $nameParts = explode(' ', $name); // Split name by space

            // If there's only one word in the name, use it for both first and last name
            if (count($nameParts) == 1) {
                $user->first_name = $nameParts[0]; // Set both first_name and last_name to the same value
                $user->last_name = $nameParts[0];

                $userProfile->first_name = $nameParts[0]; // Set both first_name and last_name to the same value
                $userProfile->last_name = $nameParts[0];
            } else {
                $user->first_name = $nameParts[0]; // First word as first name
                $user->last_name = implode(' ', array_slice($nameParts, 1)); // Remaining words as last name
                // If there are more than one words, set first_name and last_name accordingly
                $userProfile->first_name = $nameParts[0]; // First word as first name
                $userProfile->last_name = implode(' ', array_slice($nameParts, 1)); // Remaining words as last name
            }
            $user->name = $request->name;
            $userProfile->name = $request->name;
        }
        if ($request->has('email')) {
            $user->email = $request->email;
            $userProfile->email = $request->email;
        }
        if ($request->has('mobile')) {
            $user->mobile = $request->mobile;
            $userProfile->mobile = $request->mobile;
        }
        if ($request->has('gender')) {
            $user->gender = $request->gender;
            $userProfile->gender = $request->gender;
        }
        if ($request->has('address')) {
            $userProfile->address = $request->address;
        }
        if ($request->has('interests')) {
            $userProfile->interests = $request->interests; // JSON array
        }
        if ($request->has('hobbies')) {
            $userProfile->hobbies = $request->hobbies; // JSON array
        }
        if ($request->has('occupation_name')) {
            $userProfile->occupation_name = $request->occupation_name;
        }
        if ($request->has('college_name')) {
            $userProfile->college_name = $request->college_name;
        }
        if ($request->has('specialization')) {
            $userProfile->specialization = $request->specialization;
        }
        if ($request->has('url_facebook')) {
            $userProfile->url_facebook = $request->url_facebook;
        }
        if ($request->has('url_youtube')) {
            $userProfile->url_youtube = $request->url_youtube;
        }
        if ($request->has('url_instagram')) {
            $userProfile->url_instagram = $request->url_instagram;
        }
        if ($request->has('url_linkedin')) {
            $userProfile->url_linkedin = $request->url_linkedin;
        }
        if ($request->has('linkedin')) {
            $userProfile->url_website = $request->url_website;
        }

        // Save the updated profile
        $user->save();
        $userProfile->save();

        // Return a response
        return response()->json([
            'message' => 'Profile updated successfully.',
            'data' => $userProfile
        ]);
    }

    public function dashboard(Request $request)
    {
         // Retrieve the authenticated user from the JWT token
         $user = Auth::user(); // or JWTAuth::parseToken()->authenticate();

         if (!$user) {
             return response()->json(['error' => 'User not authenticated'], 401);
         }

         $ads =[];
         $offers=[];
         $rewards=[];
 
         return response()->json(['ads' => $ads, 'offers'=> $offers, 'rewards'=> $rewards ], 200);
    }


   

}
