<?php

namespace Modules\Mobilesettings\Http\Controllers\Backend;

use App\Http\Controllers\Backend\BackendBaseController;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Modules\Mobilesettings\Entities\Coin;
use Modules\MobileSettings\Entities\Appsiteinformation;

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


    public function manageSiteInfo()
    {
        $aboutUs = Appsiteinformation::where('type', 'about_us')->first();
        $privacyPolicy = Appsiteinformation::where('type', 'privacy_policy')->first();
        $helpSupport = Appsiteinformation::where('type', 'help_support')->first();

        $module_title = 'Manage Site Information'; // Title name
        $module_icon = 'fa fa-cogs'; // Example icon class
    
        return view('mobilesettings::mobilesettings.manage_site_info.index', compact('aboutUs', 'privacyPolicy', 'helpSupport', 'module_title', 'module_icon'));
    }

    
    public function updateSiteInfo(Request $request)
    {
            $request->validate([
                'about_us' => 'required|string',
                'privacy_policy' => 'required|string',
                'mobile' => 'nullable|string|max:255',
                'email' => 'nullable|email|max:255',
            ]);

            // Update About Us
            AppSiteInformation::updateOrCreate(
                ['type' => 'about_us'],
                ['content' => $request->input('about_us')]
            );

            // Update Privacy Policy
            AppSiteInformation::updateOrCreate(
                ['type' => 'privacy_policy'],
                ['content' => $request->input('privacy_policy')]
            );

            // Update Help & Support
            AppSiteInformation::updateOrCreate(
                ['type' => 'help_support'],
                [
                    'mobile' => $request->input('mobile'),
                    'email' => $request->input('email'),
                ]
            );

            return redirect()->route('backend.mobilesettings.site_info')->with('success', 'Site Information updated successfully.');
      
    }

}
