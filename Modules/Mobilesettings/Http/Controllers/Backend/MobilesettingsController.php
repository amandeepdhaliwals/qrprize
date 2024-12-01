<?php

namespace Modules\Mobilesettings\Http\Controllers\Backend;

use App\Http\Controllers\Backend\BackendBaseController;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Modules\Mobilesettings\Entities\Coin;
use Modules\Mobilesettings\Entities\Appinformation; 
use Modules\Stores\Entities\Campaign; 
use Modules\Stores\Entities\Advertisement; 
use Modules\Mobilesettings\Entities\CampaignAdsMeta; 


class MobilesettingsController extends BackendBaseController
{
    /**
     * Display a list of coins.
     */
    public function coins()
    {
        $coins = Coin::paginate(10); // Fetch paginated coins
        $module_title = 'Coins';
        $module_action = 'List';
        $module_icon = 'fas fa-coins'; // Adjust as needed
        $module_name = 'coins';

        return view('mobilesettings::mobilesettings.coins.index', compact(
            'coins',
            'module_title',
            'module_action',
            'module_icon',
            'module_name'
        ));
    }

    /**
     * Show the form for editing the specified coin.
     */
    public function editCoin($id)
     {
        $coin = Coin::findOrFail($id);

        $module_title = 'Coins';
        $module_action = 'Edit';
        $module_icon = 'fas fa-coins'; // Adjust as needed
        $module_name = 'coins';
        $module_path = 'mobilesettings.coins'; // Adjust based on the module's path

        return view('mobilesettings::mobilesettings.coins.edit', compact(
            'coin',
            'module_title',
            'module_action',
            'module_icon',
            'module_name',
            'module_path'
        ));
    }

    /**
     * Update the specified coin in storage.
     */
    public function updateCoin(Request $request, $id): RedirectResponse
    {
        $validated = $request->validate([
            // 'category' => 'required|string|max:255',
            'coins_per_category' => 'required|integer',
        ]);

        $coin = Coin::findOrFail($id); // Find the coin by ID
        $coin->update($validated); // Update the coin with validated data

        return redirect()->route('backend.mobilesettings.coins')->with('success', 'Coin updated successfully!');
    }


    /**
     * Manage site information.
     */
    public function manageSiteInfo()
    {
        $aboutUs = Appinformation::where('type', 'about_us')->first();
        $privacyPolicy = Appinformation::where('type', 'privacy_policy')->first();
        $helpSupport = Appinformation::where('type', 'help_support')->first();

        $module_title = 'Manage Site Information'; // Title name
        $module_icon = 'fa fa-cogs'; // Example icon class
    
        return view('mobilesettings::mobilesettings.manage_site_info.index', compact('aboutUs', 'privacyPolicy', 'helpSupport', 'module_title', 'module_icon'));
    }

    
     /**
     * Update mobile site information.
     */
    public function updateSiteInfo(Request $request)
    {
            $request->validate([
                'about_us' => 'required|string',
                'privacy_policy' => 'required|string',
                'mobile' => 'nullable|string|max:255',
                'email' => 'nullable|email|max:255',
            ]);

            // Update About Us
            Appinformation::updateOrCreate(
                ['type' => 'about_us'],
                ['content' => $request->input('about_us')]
            );

            // Update Privacy Policy
            Appinformation::updateOrCreate(
                ['type' => 'privacy_policy'],
                ['content' => $request->input('privacy_policy')]
            );

            // Update Help & Support
            Appinformation::updateOrCreate(
                ['type' => 'help_support'],
                [
                    'mobile' => $request->input('mobile'),
                    'email' => $request->input('email'),
                ]
            );

            return redirect()->route('backend.mobilesettings.site_info')->with('success', 'Site Information updated successfully.');
      
    }


    /**
     * Manage advertisement selection.
     */                                                
    public function manageAds(Request $request)
    {
        // Paginate campaigns
        $campaigns = Campaign::paginate(5);
    
        // Attach paginated advertisements to each campaign
        foreach ($campaigns as $campaign) {
            $campaign->advertisements = Advertisement::whereIn('id', $campaign->advertisement_ids)
                                                     ->with('video') // eager load the associated video
                                                     ->get();
        }
    
        // Fetch CampaignAdsMeta data, eager load the related advertisement and campaign
        $campaignAdsMeta = CampaignAdsMeta::with(['advertisement', 'campaign'])->get();
    
        // Pass campaigns and campaignAdsMeta to the view
        return view('mobilesettings::mobilesettings.manage_ads.index', compact('campaigns', 'campaignAdsMeta'));
    }
    
    public function updateAdStatus(Request $request)
    {
        $validated = $request->validate([
            'adId' => 'required|integer|exists:advertisement,id', // Ensure advertisement_id exists
            'type' => 'required|string|in:is_new_ad,is_trending_ad,is_ad_of_the_day', // Ensure valid types
             'status' => 'required', // Ensure status is true/false (0 or 1)
            'cmId' => 'required|integer|exists:campaign,id', // Ensure campaign_id exists
        ]);
    
        // Find the CampaignAdsMeta record using advertisement_id and campaign_id
        $campaignAdMeta = CampaignAdsMeta::where('advertisement_id', $validated['adId'])
                                         ->where('campaign_id', $validated['cmId'])
                                         ->first();
    
        $type = $validated['type'];
        $status = $validated['status']; 
       
        if ($status == "1") {
            // If status is true, create or update the entry
            if (!$campaignAdMeta) {
                $campaignAdMeta = new CampaignAdsMeta();
                $campaignAdMeta->advertisement_id = $validated['adId'];
                $campaignAdMeta->campaign_id = $validated['cmId'];
            }
    
            // Update the status for the specific type
            $campaignAdMeta->{$type} = true; 
            $campaignAdMeta->save();
        } else {
            // If status is false, remove the specific type or delete the entry
            if ($campaignAdMeta) {
                $campaignAdMeta->{$type} = false; // Set the field to false
                
                // Check if all type fields are false; if so, delete the record
                if (!$campaignAdMeta->is_new_ad && !$campaignAdMeta->is_trending_ad && !$campaignAdMeta->is_ad_of_the_day) {
                    $campaignAdMeta->delete();
                } else {
                    $campaignAdMeta->save();
                }
            }
        }
    
        return response()->json(['success' => true, 'message' => 'Campaign advertisement meta updated successfully']);
    }
    
}
