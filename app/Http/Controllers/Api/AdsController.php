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
use Modules\Stores\Entities\Campaign; 
use Modules\Stores\Entities\Advertisement; 
use Modules\Mobilesettings\Entities\CampaignAdsMeta; 


class AdsController extends Controller
{
    public function trendingAds()
    {
        $user = Auth::user(); // or JWTAuth::parseToken()->authenticate();

        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
        $trending_ads = CampaignAdsMeta::where('is_trending_ad', 1)->with(['advertisement', 'campaign'])->get();
        $new_ads = CampaignAdsMeta::where('is_new_ad', 1)->with(['advertisement', 'campaign'])->get();
        return response()->json([
            'message' => 'Trending Ads get successfully.',
            'trending_ads' => $trending_ads,
            'new_ads' => $new_ads,
        ],200);
    }

    // public function adsOfTheDay()
    // {
    //     $user = Auth::user(); // or JWTAuth::parseToken()->authenticate();

    //     if (!$user) {
    //         return response()->json(['error' => 'User not authenticated'], 401);
    //     }
    //     $ads_of_the_day = CampaignAdsMeta::where('is_ad_of_the_day', 1)->with(['advertisement', 'campaign'])->get();
    //     return response()->json([
    //         'message' => 'Ads of the day get successfully.',
    //         'data' => $ads_of_the_day
    //     ],200);
    // }

    // public function newAds()
    // {
    //     $user = Auth::user(); // or JWTAuth::parseToken()->authenticate();

    //     if (!$user) {
    //         return response()->json(['error' => 'User not authenticated'], 401);
    //     }
    //     $new_ads = CampaignAdsMeta::where('is_new_ad', 1)->with(['advertisement', 'campaign'])->get();
    //     return response()->json([
    //         'message' => 'New Ads get successfully.',
    //         'data' => $new_ads
    //     ],200);
    // }

}
