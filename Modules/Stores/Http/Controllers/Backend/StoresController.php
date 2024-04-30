<?php

namespace Modules\Stores\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\Userprofile;
use Modules\Stores\Entities\Store; // Import the Store model
use Modules\Coupons\Entities\Coupon; // Import the Coupon model
use Modules\Advertisements\Entities\Advertisement; // Import the Coupon model
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use App\Notifications\UserAccountCreated;
use App\Events\Backend\UserCreated;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Log;
use App\Events\Backend\UserProfileUpdated;
use Illuminate\Support\HtmlString;
use App\Events\Backend\UserUpdated;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class StoresController extends BackendBaseController
{
    use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Stores';

        // Module name
        $this->module_name = 'stores';

        // Directory path of the module
        $this->module_path = 'stores::backend'; // or 'stores::frontend' depending on where your views are located

        // Module icon
        $this->module_icon = 'fa-solid fa-store';

        // Module model name, path
        $this->module_model = "Modules\Stores\Entities\Store";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $$module_name = $module_model::paginate();

        logUserAccess($module_title.' '.$module_action);

        return view(
            "{$module_path}.{$module_name}.index_datatable",
            compact('module_title', 'module_name', "{$module_name}", 'module_icon', 'module_name_singular', 'module_action')
        );
    }

    public function index_data()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $page_heading = label_case($module_title);
        $title = $page_heading.' '.label_case($module_action);

        $loggedInUserRoleNames = Auth::user()->roles->pluck('name')->toArray();

        // Fetch users with the specified roles and join with userprofiles and store_qrcodes tables
        $$module_name = User::select('users.*','store_qrcodes.step_completed')
        ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
        ->join('userprofiles', 'users.id', '=', 'userprofiles.user_id')
        ->join('store_qrcodes', 'userprofiles.user_id', '=', 'store_qrcodes.user_id');

        if (in_array('store', $loggedInUserRoleNames)) {
            $$module_name->where('users.id', Auth::id());
        } 

        $$module_name = $$module_name->get();    

        return Datatables::of($$module_name)
        ->addColumn('action', function ($data) {
            $module_name = $this->module_name;

            return view('backend.includes.action_column', compact('module_name', 'data'));
        })
        ->addColumn('add_compaign', function ($data) use ($module_name) {
            $storeId = $data->id;
            $route = route("backend.{$module_name}.add-campaign", ['storeId' => $storeId]);
            $button = '<div class="d-flex justify-content-center">
                            <a href="' . $route . '" class="btn btn-primary">Add</a>
                       </div>';
            return new HtmlString($button);
        })          
        ->editColumn('name', '<strong>{{$name}}</strong>')
        ->editColumn('email', '{{$email}}')
        ->editColumn('mobile', '{{$mobile}}')
        ->editColumn('status', '@if($status == 1) <span style="color:green;">Active</span> @else <span style="color:red;">Inactive</span> @endif')
        ->editColumn('step_completed', function ($data) {
            $step1Badge = '';
            $step2Badge = '';
            $allStepsBadge = '';
        
            // Step 1 badge
            if ($data->step_completed >= 1) {
                $step1Badge = '<span class="badge bg-success">Step 1 Completed</span>';
            } else {
                $step1Badge = '<span class="badge bg-warning">Step 1 Pending</span>';
            }
        
            // Step 2 badge
            if ($data->step_completed >= 2) {
                $step2Badge = '<span class="badge bg-success">Step 2 Completed</span>';
            } else {
                $step2Badge = '<span class="badge bg-warning">Step 2 Pending</span>';
            }
        
            // All steps badge
            if ($data->step_completed == 3) {
                $allStepsBadge = '<span class="badge bg-success">All Steps Completed</span>';
            } elseif ($data->step_completed >= 1 && $data->step_completed < 3) {
                $allStepsBadge = '<span class="badge bg-warning">Qr Code Pending</span>';
            }
        
            return $step1Badge . ' ' . $step2Badge . ' ' . $allStepsBadge;
        })                           
        ->editColumn('created_at', function ($data) {
            $module_name = $this->module_name;

            $diff = Carbon::now()->diffInHours($data->created_at);

            if ($diff < 25) {
                return $data->created_at->diffForHumans();
            }

            return $data->created_at->isoFormat('llll');
        })
        ->editColumn('updated_at', function ($data) {
            $module_name = $this->module_name;

            $diff = Carbon::now()->diffInHours($data->updated_at);

            if ($diff < 25) {
                return $data->updated_at->diffForHumans();
            }

            return $data->updated_at->isoFormat('llll');
        })
        ->rawColumns(['name', 'email', 'mobile','status','step_completed','created_at','updated_at','action'])
        ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function store(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Details';

        $request->validate([
            'first_name' => 'required|min:3|max:191',
            'last_name' => 'required|min:3|max:191',
            'email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i|max:191|unique:users',
            'password' => 'required|confirmed|min:4',
        ]);

        $data_array = $request->except('_token', 'roles', 'permissions', 'password_confirmation');
        $data_array['name'] = $request->first_name.' '.$request->last_name;
        $data_array['password'] = Hash::make($request->password);

        if ($request->confirmed === 1) {
            $data_array = Arr::add($data_array, 'email_verified_at', Carbon::now());
        } else {
            $data_array = Arr::add($data_array, 'email_verified_at', null);
        }

        $$module_name_singular = User::create($data_array);

        $$module_name_singular->assignRole('store');

        // Insert entry into store_qrcodes
        Store::create([
            'user_id' => $$module_name_singular->id,
            'status' => '1',
            'created_by' => '1',
            'adv_video_id' => '0',
            'adv_primary_image_id' => '0',
            'step_completed' => '2'
            // Add other fields here as needed
        ]);
        
        // Username
        $id = $$module_name_singular->id;
        $username = config('app.initial_username') + $id;
        $$module_name_singular->username = $username;
        $$module_name_singular->save();

        event(new UserCreated($$module_name_singular));

        $userprofile = Userprofile::where('user_id', $$module_name_singular->id)->first();
   
        if ($userprofile) {
            $userprofile->address = $request->address; 
            $userprofile->bio = $request->bio;
            $userprofile->url_website = $request->url_website; 
            $userprofile->url_facebook = $request->url_facebook; 
            $userprofile->url_instagram = $request->url_instagram; 
            $userprofile->url_twitter = $request->url_twitter; 
            $userprofile->url_linkedin = $request->url_linkedin; 
            $userprofile->avatar = $request->file('avatar'); // Store the uploaded avatar
            $userprofile->save();
        }

        Flash::success("<i class='fas fa-check'></i> New '".Str::singular($module_title)."' Created")->important();

        if ($request->email_credentials === 1) {
            $data = [
                'password' => $request->password,
            ];
            $$module_name_singular->notify(new UserAccountCreated($data));

            Flash::success(icon('fas fa-envelope').' Account Credentials Sent to User.')->important();
        }

        Log::info(label_case($module_title.' '.$module_action)." | '".$$module_name_singular->name.'(ID:'.$$module_name_singular->id.") ' by User:".auth()->user()->name.'(ID:'.auth()->user()->id.')');

        return redirect("admin/{$module_name}");
    }

     /**
     * Edit a record in the database.
     *
     * @param  int  $id  The ID of the record to be edited.
     * @return \Illuminate\View\View The view for editing the record.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException If the user does not have the permission to edit users.
     */
    public function edit($id)
    {
        $module_name_user = 'users';
        $module_model_user =  "App\Models\User";
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_name_singular = Str::singular($module_name_user);

        $module_action = 'Edit Profile';

        if (! auth()->user()->can('edit_users')) {
            $id = auth()->user()->id;
        }

        $$module_name_singular = $module_model_user::findOrFail($id);
        $userprofile = Userprofile::where('user_id', $$module_name_singular->id)->first();

        return view(
            "{$module_path}.{$module_name}.edit",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular', "{$module_name_singular}", 'userprofile')
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $module_title = $this->module_title;
        $module_name_user = 'users';
        $module_name = $this->module_name;
        $module_path_store = $this->module_path;
        $module_path = 'users';
        $module_icon = $this->module_icon;
        $module_model =  "App\Models\User";
        $module_name_singular = Str::singular($module_name_user);
        $module_action = 'Show';
        $$module_name_singular = $module_model::findOrFail($id);
        $userprofile = Userprofile::where('user_id', $$module_name_singular->id)->first();

        Log::info(label_case($module_title.' '.$module_action).' | User:'.auth()->user()->name.'(ID:'.auth()->user()->id.')');

        return view(
            "{$module_path_store}.{$module_name}.show",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular', "{$module_name_singular}", 'userprofile')
        );
    }


       /**
     * Updates the user profile.
     *
     * @param  Request  $request  The request object.
     * @param  int  $id  The ID of the user.
     * @return RedirectResponse The response redirecting to the user's profile page.
     */
    public function update(Request $request, $id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_model_user =  "App\Models\User";
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_model_user);

        $module_action = 'Edit Profile';

        $this->validate($request, [
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'first_name' => 'required|min:3|max:191',
            'last_name' => 'required|min:3|max:191',
            'email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i|max:191|unique:'.$module_model_user.',email,'.$id,
        ]);

        if (! auth()->user()->can('edit_users')) {
            $id = auth()->user()->id;
        }

        $$module_name_singular = User::findOrFail($id);

        // Handle Avatar upload
        if ($request->hasFile('avatar')) {
            if ($$module_name_singular->getMedia($module_model_user)->first()) {
                $$module_name_singular->getMedia($module_model_user)->first()->delete();
            }

            $media = $$module_name_singular->addMedia($request->file('avatar'))->toMediaCollection($module_model_user);

            $$module_name_singular->avatar = $media->getUrl();

            $$module_name_singular->save();
        }

        $data_array = $request->except('avatar');
        $data_array['avatar'] = $$module_name_singular->avatar;
        $data_array['name'] = $request->first_name.' '.$request->last_name;

        $user_profile = Userprofile::where('user_id', '=', $$module_name_singular->id)->first();
        $user_profile->update($data_array);

        event(new UserProfileUpdated($user_profile));

        Flash::success(icon().'Store Updated Successfully!')->important();

        Log::info(label_case($module_title.' '.$module_action).' | User:'.auth()->user()->name.'(ID:'.auth()->user()->id.')');

        return redirect()->route("backend.{$module_name}.show", $$module_name_singular->id);
    }

    /**
     * Deletes a user by their ID.
     *
     * @param  int  $id  The ID of the user to be deleted.
     * @return Illuminate\Http\RedirectResponse
     *
     * @throws Illuminate\Database\Eloquent\ModelNotFoundException If the user with the given ID is not found.
     */
    public function destroy($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_model_user =  "App\Models\User";
        $module_name_singular = Str::singular($module_name);

        $module_action = 'destroy';

        if (auth()->user()->id === $id || $id === 1) {
            Flash::warning("<i class='fas fa-exclamation-triangle'></i> You can not delete this user!")->important();

            Log::notice(label_case($module_title.' '.$module_action).' Failed | User:'.auth()->user()->name.'(ID:'.auth()->user()->id.')');

            return redirect()->back();
        }

        $$module_name_singular = $module_model_user::findOrFail($id);

        $$module_name_singular->delete();

        event(new UserUpdated($$module_name_singular));

        flash('<i class="fas fa-check"></i> '.$$module_name_singular->name.' User Successfully Deleted!')->success();

        Log::info(label_case($module_action)." '{$module_name}': '".$$module_name_singular->name.', ID:'.$$module_name_singular->id." ' by User:".auth()->user()->name);

        return redirect("admin/{$module_name}");
    }

    /**
     * Retrieves and displays a list of deleted records for the specified module.
     *
     * @return \Illuminate\View\View the view for the list of deleted records
     */
    public function trashed()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_model_user =  "App\Models\User";
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Deleted List';
        $page_heading = $module_title;

        $$module_name = $module_model_user::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate();

        Log::info(label_case($module_action).' '.label_case($module_name).' by User:'.auth()->user()->name);

        return view(
            "backend.{$module_name}.trash",
            compact('module_name', 'module_title', "{$module_name}", 'module_icon', 'page_heading', 'module_action')
        );
    }

    /**
     * Restores a record in the database.
     *
     * @param  int  $id  The ID of the record to be restored.
     * @return Illuminate\Http\RedirectResponse The redirect response to the admin module page.
     */
    public function restore($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_model_user =  "App\Models\User";
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Restore';

        $$module_name_singular = $module_model_user::withTrashed()->find($id);

        $$module_name_singular->restore();

        $$module_name_singular->userprofile()->withTrashed()->restore();

        event(new UserUpdated($$module_name_singular));

        flash('<i class="fas fa-check"></i> '.$$module_name_singular->name.' Successfully Restoreded!')->success();

        Log::info(label_case($module_action)." '{$module_name}': '".$$module_name_singular->name.', ID:'.$$module_name_singular->id." ' by User:".auth()->user()->name);

        return redirect("admin/{$module_name}");
    }

    /**
     * Show form to add campaign for a store.
     *
     * @param  int  $storeId
     * @return \Illuminate\Contracts\View\View
     */
    public function addCampaign($storeId)
    {
        $module_title = 'Qr Code';
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Create';

        // Find the store by ID
        $store = User::findOrFail($storeId);
        $coupons = Coupon::where('status', 1)
        ->where('deleted_at', null) // Assuming 'isdeleted' is a boolean column
        ->get();

        $adv_videos = Advertisement::where('status', 1)
        ->where('deleted_at', null) 
        ->where('media_type', 'Video') 
        ->get();

        $adv_images = Advertisement::where('status', 1)
        ->where('deleted_at', null) 
        ->where('media_type', 'Image') 
        ->get();

        // dd($coupons);

        logUserAccess($module_title.' '.$module_action);

        return view(
            "{$module_path}.{$module_name}.add_campaign",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_name_singular', 'module_action', 'store','coupons','adv_videos','adv_images')
        );

    }


    public function editCampaign($storeId,$campaignId)
    {
        $module_title = 'Qr Code';
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        // $module_model = $this->module_model;
        $module_model = 'Modules\Stores\Entities\Campaign';
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Edit';

        // Find the store by ID
        $store = User::findOrFail($storeId);

        $campaign = $module_model::findOrFail($campaignId);

        $coupons = Coupon::where('status', 1)
        ->where('deleted_at', null)
        ->get();

        $adv_videos = Advertisement::where('status', 1)
        ->where('deleted_at', null) 
        ->where('media_type', 'Video') 
        ->get();

        $adv_images = Advertisement::where('status', 1)
        ->where('deleted_at', null) 
        ->where('media_type', 'Image') 
        ->get();

        // dd($coupons);

        logUserAccess($module_title.' '.$module_action);

        return view(
            "{$module_path}.{$module_name}.edit_campaign",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_name_singular', 'module_action', 'store','coupons','adv_videos','adv_images','campaign')
        );

    }

    //  /**
    //  * Generate a QR code image based on the provided URL.
    //  *
    //  * @param string $url The URL to encode in the QR code.
    //  * @return \BaconQrCode\Common\QRCode The generated QR code object.
    //  */
    // private function generateQrCode($url)
    // {
    //     // Create a RendererStyle with the desired width
    //     $rendererStyle = new RendererStyle(400);

    //     // Create an instance of ImageRenderer with the style
    //     $renderer = new ImageRenderer($rendererStyle,null);

    //     // Create a Writer with the renderer
    //     $writer = new Writer($renderer);

    //     // Generate the QR code image
    //     $qrCode = $writer->writeString($url);

    //     return $qrCode;
    // }

    /**
     * Store a new campaign in the database.
     *
     * @param  \Illuminate\Http\Request  $request  The request object containing the campaign data.
     * @return \Illuminate\Http\RedirectResponse  The response object that redirects to the index page of the module.
     *
     * @throws \Exception If there is an error during the creation of the campaign.
     */
    public function storeCampaign(Request $request)
    {
        $module_title = 'Campaign';
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = 'Modules\Stores\Entities\Campaign';
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Store';

        // Validate the incoming request data
        $request->validate([
            'campaign_name' => 'required',
           // 'qr_code_url' => 'required|url',
             'coupons_id' => 'required',
        ]);

        // dd($request);

        $campaignId = $module_model::latest()->value('id') + 1;
        $storeId = $request->store_id;
        //$url = $request->qr_code_url;
        // $hostname = url('/store/1/campaign/'. $nextId);
        $url = url('/store/' . $storeId . '/campaign/' . $campaignId);
        $qrCode = QrCode::format('png')->size(200)->generate($url);
        $qr_code_image = base64_encode($qrCode);

        // Create a new campaign record
        $$module_name_singular = $module_model::create([
        'campaign_name' => $request->campaign_name,
        'coupon_id' => '1',
        'user_id'  => $storeId,
        'total_no_of_coupons' => '1',
        'no_of_winned_coupons' => '1',
        'qr_code_url' => $url,
        'qr_code_image' => $qr_code_image,
        'adv_video_id' => $request->video_id,
        'primary_image_id' => $request->primary_image_id,
        'secondary_images_id' => $request->secondary_images_id,
        'coupons_id' => $request->coupons_id,
        'lock_time' => $request->lock_time,
        'winning_ratio' => $request->winning_ratio,
        ]);


        flash(icon()."New '".Str::singular($module_title)."' Added")->success()->important();

        // Log the successful creation of the campaign
        Log::info('Campaign created successfully | Id: ' . $$module_name_singular->id);

        return back();
    }

    public function updateCampaign(Request $request)
    {
        $module_title = 'Campaign';
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = 'Modules\Stores\Entities\Campaign';
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Update';

        // Validate the incoming request data
        $request->validate([
            'campaign_name' => 'required',
           // 'qr_code_url' => 'required|url',
             'coupons_id' => 'required',
        ]);

        $campaign = $module_model::find($request->campaign_id); // $id is the id of the record you want to update
        // Check if the model instance exists
        if ($campaign) {
            // Update the attributes
            $campaign->campaign_name = $request->campaign_name;
            $campaign->adv_video_id = $request->video_id;
            $campaign->primary_image_id = $request->primary_image_id;
            $campaign->secondary_images_id = $request->secondary_images_id;
            $campaign->coupons_id = $request->coupons_id;
            $campaign->lock_time = $request->lock_time;
            $campaign->winning_ratio = $request->winning_ratio;

            $campaign->save();

            flash(icon().Str::singular($module_title)." Updated")->success()->important();

        } else {
            flash("Failed to update " . Str::singular($module_title))->error()->important();
        }

        return back();
    }


    /**
     * Retrieves the data for the index page of the module.
     *
     * @param  int  $storeId
     * @return Illuminate\Http\JsonResponse
     */
    public function campaignIndex($storeId)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = 'Modules\Stores\Entities\Campaign';
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $page_heading = label_case($module_title);
        $title = $page_heading.' '.label_case($module_action);

        $$module_name = $module_model::select('store_coupons_assign.*');

        $$module_name = $$module_name->get();    

        return Datatables::of($$module_name)
        ->addColumn('edit_compaign', function ($data) use ($module_name) {
            $storeId = $data->user_id;
            $campaignId = $data->id;
            $route = route("backend.{$module_name}.edit-campaign", ['storeId' => $storeId,'campaignId'=>$campaignId]);
            $button = '<div class="d-flex justify-content-center">
                            <a href="' . $route . '" class="btn btn-primary">Edit</a>
                       </div>';
            return new HtmlString($button);
        })     
        ->editColumn('user_id', '{{$user_id}}', '{{$qr_code_image}}', '{{$capmaign_name}}',)
        ->rawColumns(['user_id','action'])
        ->make(true);
    }

}