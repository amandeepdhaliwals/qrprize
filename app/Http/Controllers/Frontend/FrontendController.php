<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Modules\Stores\Entities\Campaign; 
use Modules\Stores\Entities\Advertisement; 
use Modules\Coupons\Entities\Coupon; // Import the Coupon model
use Modules\Coupons\Entities\Claim; // Import the Claim model
use Modules\Videos\Entities\Video; // Import the Video model
use Modules\Gallery\Entities\Gallery; // Import the gallery(images) model
use Modules\Otherprizes\Entities\Otherprize; // Import the other prize images model
use Modules\Customers\Entities\Visitor;
use Modules\Customers\Entities\CustomerWin;
use Modules\Customers\Entities\CustomerResult;
use Illuminate\Http\Response;
use App\Notifications\CouponWinNotification;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\ClaimRequestNotification;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;

class FrontendController extends Controller
{
    /**
     * Retrieves the view for the index page of the frontend.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        //return view('frontend.index');
        return redirect()->route('login');
    }

    /**
     * Privacy Policy Page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function privacy()
    {
        return view('frontend.privacy');
    }

    /**
     * Terms & Conditions Page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function terms()
    {
        return view('frontend.terms');
    }

    public function campaign(Request $request,$storeId,$campaignId,)
    {
        $campaign = Campaign::where('id',$campaignId)->where('store_id',$storeId)->first();

        if($campaign){
            //$advertisement_id = $campaign->advertisement_ids[0];
            $advertisementIds = $campaign->advertisement_ids;
            $hour = now()->hour;
            // Calculate the advertisement index
            $advertisementIndex = ($hour - 1) % count($advertisementIds);
            $advertisement_id = $advertisementIds[$advertisementIndex];

            if($advertisement_id){
                $advertisement_detail = Advertisement::where('id',$advertisement_id)->first();
                $advertisement_video = Video::where('id',$advertisement_detail->adv_video_id)->where("deleted_at", null)->first();
                $primary_image = Gallery::where('id',$advertisement_detail->primary_image_id)->where("deleted_at", null)->first();
                $secondary_image_ids = explode(',', $advertisement_detail->secondary_images_id);
                $secondary_images = Gallery::whereIn("id", $secondary_image_ids)->where("status", 1)->whereNull("deleted_at")->get();
                $other_image_ids = explode(',', $advertisement_detail->other_coupon_images_id);
                $other_images = Otherprize::whereIn("id", $other_image_ids)->where("status", 1)->whereNull("deleted_at")->get();  

                 // Decode the JSON data into an associative array
                $coupon_data = json_decode($advertisement_detail->coupons_id, true);
                // Extract the keys (coupon IDs)
                $coupon_ids = array_keys($coupon_data);

                $coupons = Coupon::whereIn('id', $coupon_ids)->get(); 
                $lock_time = $advertisement_detail->lock_time;
                if ($request->cookie('user_id') === null) {
                    // Generate a unique user ID
                    $userId = Str::random(32);
                    // Set the cookie to expire in 20 years
                    $expiryDate = Carbon::now()->addYears(20);
                    Cookie::queue(Cookie::make('user_id', $userId, $expiryDate->diffInMinutes(), null, null, false, true));
                } else {
                    // Retrieve the existing user ID from the cookie
                    $userId = $request->cookie('user_id');
                }
                $visitor_id = $this->createVisitor($userId, $storeId, $campaignId, $advertisement_id);
                return view('frontend.campaign',compact('campaignId','advertisement_detail','advertisement_video',
                'primary_image','secondary_images','other_images','coupons','lock_time','visitor_id'));
            }

        }else{
            return abort(Response::HTTP_NOT_FOUND);
        }
    }

    private function createVisitor($userId, $storeId, $campaignId, $advertisementId)
    {
        $visitor = Visitor::create([
            'user_id_cookie' => $userId,
            'store_id' => $storeId,
            'campaign_id' => $campaignId,
            'advertisement_id' => $advertisementId,
            'view' => 0, 
        ]);
        
        return $visitor->id;
    }   
    
    public function updateVisitor(Request $request)
    {
        // Find the visitor by ID
        $visitor = Visitor::find($request->visitorId);
        
        // If visitor found, update the view column
        if ($visitor) {
            $visitor->view = 1;
            $visitor->save();
            return response()->json(['success' => true, 'message' => 'Visitor view updated successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Visitor not found.']);
        }
    }   

    public function better_luck($storeId,$campaignId)
    {
        $campaign = Campaign::where('id',$campaignId)->where('store_id',$storeId)->first();
        if(!$campaign){
        return abort(Response::HTTP_NOT_FOUND);
        }
        return view('frontend.betterluck',compact('storeId','campaign','campaignId'));
    }

    public function win($cust_result_id)
    {
        $res = CustomerWin::select('customer_wins.*', 'customer_results.*')
        ->join('customer_results', 'customer_wins.customer_results_id', '=', 'customer_results.id')
        ->where('customer_wins.customer_results_id', $cust_result_id)
        ->first();
    
        if (!$res) {
            return abort(Response::HTTP_NOT_FOUND);
        } else {
            $coupon = Coupon::where('id', $res->coupon_id)->first();
            if (!$coupon) {
                return abort(Response::HTTP_NOT_FOUND);
            }
        
            $customer_id = $res->customer_id;
    
            // Retrieve the user instance
            $user = User::find($customer_id);
            if (!$user) {
                return abort(Response::HTTP_NOT_FOUND);
            }
    
            // Email send to customer (coupon details)
            $couponDetails = [
                'coupon_code' => $coupon->code,
                'title' => $coupon->title,
                'description' => $coupon->description,
            ];

            $advertisement_id = $res->advertisement_id;
            $storeId = $res->store_id;
            $campaignId = $res->campaign_id;
            $coupon_category =  $coupon->category;
            $claim = Claim::where('customer_id', $res->customer_id)
            ->where('advertisement_id', $advertisement_id)
            ->where('coupon_id', $res->coupon_id)
            ->first();
            $claim_request_claim = $claim ? $claim->request_claim : null;

            if($coupon_category == 'service'){
                $claim_request_claim = '1';   
            }
    
            $user->notify(new CouponWinNotification($couponDetails));
        }
    
        return view('frontend.win', compact('cust_result_id',
         'customer_id','coupon','claim','claim_request_claim','advertisement_id','storeId','campaignId'));
    }

    public function claim(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

       // Find the coupon by code
        $coupon = Coupon::where('id', $request->coupon_id)->first();

        if (!$coupon) {
            return abort(Response::HTTP_NOT_FOUND);
        }

        $claim = Claim::where('customer_id', $request->customer_id)
        ->where('advertisement_id', $request->advertisement_id)
        ->where('coupon_id', $request->coupon_id)
        ->first();

        // Check if the coupon is already claimed
        if ($claim) {
            $claim->request_claim = 1;
            $claim->email_sent = 1;
            $claim->name = $request->name;
            $claim->address = $request->address;
            $claim->save();
        }
    
        $adminUsers = User::whereHas('roles', function($query) {
            $query->where('name', 'super admin');
        })->get();

        if ($adminUsers->isNotEmpty()) {
            $adminUser = $adminUsers->first();
            $adminUser->notify(new ClaimRequestNotification($request->name, $request->address, $coupon->code));
        }

        // Redirect to the desired URL
        return redirect()->back()->with('success', 'Coupon claimed successfully!');
    }

}
