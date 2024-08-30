<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Userprofile;
use Modules\Stores\Entities\Store; // Import the Store model
use Modules\Stores\Entities\Advertisement; // Import the advertisement model
use Modules\Stores\Entities\Previewadvertisement; // Import the preview advertisement model
use Modules\Coupons\Entities\Coupon; // Import the Coupon model
use Modules\Videos\Entities\Video; // Import the Video model
use Modules\Gallery\Entities\Gallery; // Import the gallery(images) model
use Modules\Otherprizes\Entities\Otherprize; // Import the other prize images model
use Modules\Stores\Entities\Campaign;

class CustomerBackendController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('customerbackend.index');
    }

    public function campaign_index()
    {
        return view('customerbackend.campaigns.current_campaigns');
    }

    public function currentCampaigns2()
    {
     
        $campaigns = Campaign::whereNull('campaign.deleted_at')
            ->leftJoin('customer_results as cr1', function($join) {
                $join->on('campaign.id', '=', 'cr1.campaign_id')
                    ->where('cr1.customer_id', '=', Auth::id());
            })
            ->select('campaign.*', 'cr1.created_at as customer_result_created_at',
                        DB::raw('CASE 
                        WHEN TIMESTAMPDIFF(SECOND, cr1.created_at, NOW()) <= (campaign.lock_time * 3600)
                        THEN SEC_TO_TIME((campaign.lock_time * 3600) - TIMESTAMPDIFF(SECOND, cr1.created_at, NOW()))
                        ELSE NULL 
                    END as countdown_time'))
                    ->where(function($query) {
                        $query->whereRaw('cr1.created_at = (select max(cr2.created_at) from customer_results as cr2 where cr2.campaign_id = cr1.campaign_id and cr2.customer_id = cr1.customer_id)')
                        ->orWhereNull('cr1.created_at');
                    })->get();


        return Datatables::of($campaigns)
        ->editColumn('play', function ($data) {
            if (is_null($data->countdown_time)) {
                return '<button type="button"><a href="">Play</a></button>';
            } else {
                $countdownId = 'timer-' . $data->id;
                $lockTimeInSeconds = strtotime($data->customer_result_created_at) + ($data->lock_time * 3600) - time();
                $lockTimeInSeconds = max($lockTimeInSeconds, 0);
        
                return '<span style="color:red;" id="' . $countdownId . '">Loading...</span>
                        <script>
                            $(document).ready(function() {
                                var countdownTime = ' . $lockTimeInSeconds . ';
                                var countdownElement = $("#' . $countdownId . '");
        
                                var countdownInterval = setInterval(function() {
                                    if (countdownTime <= 0) {
                                        clearInterval(countdownInterval);
                                        countdownElement.html("<button type=\"button\"><a href=\"\">Play</a></button>");
                                    } else {
                                        var hours = Math.floor(countdownTime / 3600);
                                        var minutes = Math.floor((countdownTime % 3600) / 60);
                                        var seconds = countdownTime % 60;
                                        countdownElement.html((hours < 10 ? "0" : "") + hours + ":" + 
                                                               (minutes < 10 ? "0" : "") + minutes + ":" + 
                                                               (seconds < 10 ? "0" : "") + seconds);
                                        countdownTime--;
                                    }
                                }, 1000);
                            });
                        </script>';
            }
        })
        ->rawColumns(['play'])
        ->make(true);  
    }

    public function currentCampaigns()
    {
     
        $campaigns = Campaign::where("deleted_at", null)->get();
        // $campaigns = Campaign::whereNull('campaign.deleted_at')
        //     ->leftJoin('customer_results as cr1', function($join) {
        //         $join->on('campaign.id', '=', 'cr1.campaign_id')
        //             ->where('cr1.customer_id', '=', Auth::id());
        //     })
        //     ->select('campaign.*', 'cr1.created_at as customer_result_created_at',
        //                 DB::raw('CASE 
        //                 WHEN TIMESTAMPDIFF(SECOND, cr1.created_at, NOW()) <= (campaign.lock_time * 3600)
        //                 THEN SEC_TO_TIME((campaign.lock_time * 3600) - TIMESTAMPDIFF(SECOND, cr1.created_at, NOW()))
        //                 ELSE NULL 
        //             END as countdown_time'))
        //             ->where(function($query) {
        //                 $query->whereRaw('cr1.created_at = (select max(cr2.created_at) from customer_results as cr2 where cr2.campaign_id = cr1.campaign_id and cr2.customer_id = cr1.customer_id)')
        //                 ->orWhereNull('cr1.created_at');
        //             })->get();


        return Datatables::of($campaigns)
        ->editColumn('play', function ($data) {
            // if (is_null($data->countdown_time)) {
                 return '<button type="button"><a href="">Play</a></button>';
            // }
        })
        ->rawColumns(['play'])
        ->make(true);  
    }
}
