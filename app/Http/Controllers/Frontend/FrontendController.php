<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Modules\Stores\Entities\Campaign; 
use Modules\Videos\Entities\Advertisement; 
use Modules\Coupons\Entities\Coupon; 
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
        $campaign = Campaign::where('id',$campaignId)->where('user_id',$storeId)->first();

        if($campaign){
            $advertisement_video = Advertisement::where('id',$campaign->adv_video_id)->select('media')->first();
            $primary_image = Advertisement::where('id',$campaign->primary_image_id)->select('media','free_services')->first();
            $secondary_images = Advertisement::whereIn('id',$campaign->secondary_images_id)->select('media','free_services')->get();
            $lock_time = $campaign->lock_time;
//dd($secondary_images);
            return view('frontend.campaign',compact('advertisement_video','primary_image','secondary_images','lock_time'));

        }else{
            return abort(Response::HTTP_NOT_FOUND);
        }
    }
}
