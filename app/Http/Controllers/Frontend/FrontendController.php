<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Modules\Stores\Entities\Campaign; 
use Modules\Stores\Entities\Advertisement; 
use Modules\Coupons\Entities\Coupon; // Import the Coupon model
use Modules\Videos\Entities\Video; // Import the Video model
use Modules\Gallery\Entities\Gallery; // Import the gallery(images) model
use Modules\Otherprizes\Entities\Otherprize; // Import the other prize images model

use Illuminate\Http\Response;

class FrontendController extends Controller
{
    /**
     * Retrieves the view for the index page of the frontend.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
       // return view('frontend.index');
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

    public function campaign($storeId,$campaignId)
    {
        $campaign = Campaign::where('id',$campaignId)->where('store_id',$storeId)->first();
//dd($campaign->advertisement_ids[0]);
        if($campaign){
            $advertisement_id = $campaign->advertisement_ids[0];
            if($advertisement_id){
                $advertisement_detail = Advertisement::where('id',$advertisement_id)->first();
                //dd($advertisement_detail);
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
                return view('frontend.campaign',compact('advertisement_detail','advertisement_video','primary_image','secondary_images','other_images','coupons','lock_time'));
            }


            // $advertisement_video = Advertisement::where('id',$campaign->adv_video_id)->select('media')->first();
            // $primary_image = Advertisement::where('id',$campaign->primary_image_id)->select('media','free_services')->first();
            // $secondary_images = Advertisement::whereIn('id',$campaign->secondary_images_id)->select('media','free_services')->get();
            // $lock_time = $campaign->lock_time;
//dd($secondary_images);
            // return view('frontend.campaign',compact('advertisement_video','primary_image','secondary_images','lock_time'));

        }else{
            return abort(Response::HTTP_NOT_FOUND);
        }
    }
}
