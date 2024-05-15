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
use Modules\Stores\Entities\Advertisement; // Import the advertisement model
use Modules\Stores\Entities\Previewadvertisement; // Import the preview advertisement model
use Modules\Coupons\Entities\Coupon; // Import the Coupon model
use Modules\Videos\Entities\Video; // Import the Video model
use Modules\Gallery\Entities\Gallery; // Import the gallery(images) model
use Modules\Otherprizes\Entities\Otherprize; // Import the other prize images model
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
        $this->module_title = "Stores";

        // Module name
        $this->module_name = "stores";

        // Directory path of the module
        $this->module_path = "stores::backend"; // or 'stores::frontend' depending on where your views are located

        // Module icon
        $this->module_icon = "fa-solid fa-store";

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

        $module_action = "List";

        $$module_name = $module_model::paginate();

        logUserAccess($module_title . " " . $module_action);

        return view(
            "{$module_path}.{$module_name}.index_datatable",
            compact(
                "module_title",
                "module_name",
                "{$module_name}",
                "module_icon",
                "module_name_singular",
                "module_action"
            )
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

        $module_action = "List";

        $page_heading = label_case($module_title);
        $title = $page_heading . " " . label_case($module_action);

        $loggedInUserRoleNames = Auth::user()
            ->roles->pluck("name")
            ->toArray();

        // Fetch users with the specified roles and join with userprofiles and store_qrcodes tables
        $$module_name = User::select("users.*", "store_qrcodes.step_completed","store_qrcodes.store_name")
            ->join(
                "model_has_roles",
                "users.id",
                "=",
                "model_has_roles.model_id"
            )
            ->join("roles", "model_has_roles.role_id", "=", "roles.id")
            ->join("userprofiles", "users.id", "=", "userprofiles.user_id")
            ->join(
                "store_qrcodes",
                "userprofiles.user_id",
                "=",
                "store_qrcodes.user_id"
            );

        if (in_array("store", $loggedInUserRoleNames)) {
            $$module_name->where("users.id", Auth::id());
        }

        $$module_name = $$module_name->get();

        return Datatables::of($$module_name)
            ->addColumn("action", function ($data) {
                $module_name = $this->module_name;

                return view(
                    "backend.includes.action_column",
                    compact("module_name", "data")
                );
            })
            ->addColumn("add_compaign", function ($data) use ($module_name) {
                $storeId = $data->id;
                $route = route("backend.{$module_name}.add-campaign", [
                    "storeId" => $storeId,
                ]);
                // Check if step_completed is equal to 2
                if ($data->step_completed >= 2) {
                    $content =
                        '<div class="d-flex justify-content-center">
                            <a href="' . $route . '" class="btn btn-primary">Add</a>
                        </div>';
                } else {
                    // If step_completed is not equal to 2, do not display the button
                    $content = '<span class="badge bg-warning">Update profile to add campaign</span>';
                }
                return new HtmlString($content);
            })
            ->editColumn("store_name", '<strong>{{$store_name}}</strong>')
            ->editColumn("name", '<strong>{{$name}}</strong>')
            ->editColumn("email", '{{$email}}')
            ->editColumn("mobile", '{{$mobile}}')
            ->editColumn(
                "status",
                '@if($status == 1) <span style="color:green;">Active</span> @else <span style="color:red;">Inactive</span> @endif'
            )
            ->editColumn("step_completed", function ($data) {
                $step1Badge = "";
                $step2Badge = "";
                $allStepsBadge = "";

                // Step 1 badge
                if ($data->step_completed >= 1) {
                    $step1Badge =
                        '<span class="badge bg-success">Login Detail Completed</span>';
                } else {
                    $step1Badge =
                        '<span class="badge bg-warning">Login Detail Pending</span>';
                }

                // Step 2 badge
                if ($data->step_completed >= 2) {
                    $step2Badge =
                        '<span class="badge bg-success">Profile Completed</span>';
                } else {
                    $step2Badge =
                        '<span class="badge bg-warning">Profile Pending</span>';
                }

                // Step 3 badge

                if ($data->step_completed >= 3) {
                    $step3Badge = '<span class="badge bg-success">Advertisement Added</span>';
                } else {
                    $step3Badge = '<span class="badge bg-warning">Advertisement Pending</span>';
                }

                // All steps badge
                if ($data->step_completed == 4) {
                    $allStepsBadge = '<span class="badge bg-success">Campaign Added</span>';
                } elseif ($data->step_completed < 4) {
                    $allStepsBadge = '<span class="badge bg-warning">Campaign Pending</span>';
                }

                return $step1Badge . " " . $step2Badge . " " . $step3Badge . " " . $allStepsBadge;
            })
            ->editColumn("created_at", function ($data) {
                $module_name = $this->module_name;

                $diff = Carbon::now()->diffInHours($data->created_at);

                if ($diff < 25) {
                    return $data->created_at->diffForHumans();
                }

                return $data->created_at->isoFormat("llll");
            })
            ->editColumn("updated_at", function ($data) {
                $module_name = $this->module_name;

                $diff = Carbon::now()->diffInHours($data->updated_at);

                if ($diff < 25) {
                    return $data->updated_at->diffForHumans();
                }

                return $data->updated_at->isoFormat("llll");
            })
            ->rawColumns([
                "store_name",
                "name",
                "email",
                "mobile",
                "status",
                "step_completed",
                "created_at",
                "updated_at",
                "action",
            ])
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
        $module_name_user = "users";
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = "Details";

        $request->validate([
            "first_name" => "required|min:3|max:191",
            "last_name" => "required|min:3|max:191",
            "store_name" => "required|min:3|max:191",
            "mobile" => "required",
            "email" =>
                "required|email|regex:/(.+)@(.+)\.(.+)/i|max:191|unique:users",
            // "password" => "required|confirmed|min:4",
        ]);

        $data_array = $request->except(
            "_token",
            "roles",
            "permissions",
            "password_confirmation"
        );
        $data_array["name"] = $request->first_name . " " . $request->last_name;
        $password = Str::random(8); // Generate a random string with 8 characters
        $data_array["password"] = Hash::make($password);

        $confirmed = 1; /// on adding store - email is always confirmed
        if ($confirmed === 1) {
        //if ($request->confirmed === 1) {
            $data_array = Arr::add(
                $data_array,
                "email_verified_at",
                Carbon::now()
            );
        } else {
            $data_array = Arr::add($data_array, "email_verified_at", null);
        }

        $$module_name_singular = User::create($data_array);

        $$module_name_singular->assignRole("store");

        // Check if any of the specified fields are present in the request
        $fields = ['address', 'bio', 'url_website', 'url_facebook', 'url_instagram', 'url_twitter', 'url_linkedin', 'avatar','mobile'];
        $allEmpty = true;
        
        foreach ($fields as $field) {
            if (!empty($request->{$field})) {
                // If any field is not empty, set $allEmpty to false
                $allEmpty = false;
                break; // Exit the loop since we found a non-empty field
            }
        }
        $stepCompleted = $allEmpty ? 1 : 2;
        
        // Insert entry into store_qrcodes
        Store::create([
            "user_id" => $$module_name_singular->id,
            "store_name" => $request->store_name,
            "status" => "1",
            "created_by" => "1",
            "step_completed" => $stepCompleted
            // Add other fields here as needed
        ]);

        // Username
        $id = $$module_name_singular->id;
        $username = config("app.initial_username") + $id;
        $$module_name_singular->username = $username;
        if ($request->hasFile('avatar')) {
            if ($$module_name_singular->getMedia($module_name)->first()) {
                $$module_name_singular->getMedia($module_name)->first()->delete();
            }
            $media = $$module_name_singular->addMedia($request->file('avatar'))->toMediaCollection($module_name);
            $$module_name_singular->avatar = $media->getUrl();
        }
        $$module_name_singular->save();

        event(new UserCreated($$module_name_singular));

        $userprofile = Userprofile::where(
            "user_id",
            $$module_name_singular->id
        )->first();

        if ($userprofile) {
            $userprofile->address = $request->address;
            $userprofile->bio = $request->bio;
            $userprofile->url_website = $request->url_website;
            $userprofile->url_facebook = $request->url_facebook;
            $userprofile->url_instagram = $request->url_instagram;
            $userprofile->url_twitter = $request->url_twitter;
            $userprofile->url_linkedin = $request->url_linkedin;
             // Handle Avatar upload
            if ($request->hasFile("avatar")) {
                $userprofile->avatar = $$module_name_singular->avatar;
            }
            $userprofile->save();
        }

        Flash::success(
            "<i class='fas fa-check'></i> New '" .
                Str::singular($module_title) .
                "' Created"
        )->important();

        if ($request->email_credentials === 1) {
            $data = [
                "password" => $password,
            ];
            $$module_name_singular->notify(new UserAccountCreated($data));

            Flash::success(
                icon("fas fa-envelope") . " Account Credentials Sent to User."
            )->important();
        }

        Log::info(
            label_case($module_title . " " . $module_action) .
                " | '" .
                $$module_name_singular->name .
                "(ID:" .
                $$module_name_singular->id .
                ") ' by User:" .
                auth()->user()->name .
                "(ID:" .
                auth()->user()->id .
                ")"
        );

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
        $module_name_user = "users";
        $module_model_user = "App\Models\User";
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_name_singular = Str::singular($module_name_user);

        $module_action = "Edit Profile";

        if (
            !auth()
                ->user()
                ->can("edit_users")
        ) {
            $id = auth()->user()->id;
        }

        $$module_name_singular = $module_model_user::findOrFail($id);
        $userprofile = Userprofile::where(
            "user_id",
            $$module_name_singular->id
        )->first();

        return view(
            "{$module_path}.{$module_name}.edit",
            compact(
                "module_title",
                "module_name",
                "module_path",
                "module_icon",
                "module_action",
                "module_name_singular",
                "{$module_name_singular}",
                "userprofile"
            )
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
        $module_name_user = "users";
        $module_name = $this->module_name;
        $module_path_store = $this->module_path;
        $module_path = "users";
        $module_icon = $this->module_icon;
        $module_model = "App\Models\User";
        $module_name_singular = Str::singular($module_name_user);
        $module_action = "Show";
        $$module_name_singular = $module_model::findOrFail($id);
        $userprofile = Userprofile::where(
            "user_id",
            $$module_name_singular->id
        )->first();

        Log::info(
            label_case($module_title . " " . $module_action) .
                " | User:" .
                auth()->user()->name .
                "(ID:" .
                auth()->user()->id .
                ")"
        );

        return view(
            "{$module_path_store}.{$module_name}.show",
            compact(
                "module_title",
                "module_name",
                "module_path",
                "module_icon",
                "module_action",
                "module_name_singular",
                "{$module_name_singular}",
                "userprofile"
            )
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
        $module_model_user = "App\Models\User";
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_model_user);

        $module_action = "Edit Profile";

        $this->validate($request, [
            "avatar" => "image|mimes:jpeg,png,jpg,gif,svg|max:2048",
            "first_name" => "required|min:3|max:191",
            "last_name" => "required|min:3|max:191",
            "email" =>
                "required|email|regex:/(.+)@(.+)\.(.+)/i|max:191|unique:" .
                $module_model_user .
                ",email," .
                $id,
        ]);

        if (
            !auth()
                ->user()
                ->can("edit_users")
        ) {
            $id = auth()->user()->id;
        }

        $$module_name_singular = User::findOrFail($id);

        $store = Store::where('user_id', $id)->first();
        if ($store && $store->step_completed < 3) {
            $store->step_completed = 2;
            $store->save();
        }

        // Handle Avatar upload
        if ($request->hasFile("avatar")) {
            if ($$module_name_singular->getMedia($module_model_user)->first()) {
                $$module_name_singular
                    ->getMedia($module_model_user)
                    ->first()
                    ->delete();
            }

            $media = $$module_name_singular
                ->addMedia($request->file("avatar"))
                ->toMediaCollection($module_model_user);

            $$module_name_singular->avatar = $media->getUrl();

            $$module_name_singular->save();
        }

        $data_array = $request->except("avatar");
        $data_array["avatar"] = $$module_name_singular->avatar;
        $data_array["name"] = $request->first_name . " " . $request->last_name;

        $user_profile = Userprofile::where(
            "user_id",
            "=",
            $$module_name_singular->id
        )->first();
        $user_profile->update($data_array);

        event(new UserProfileUpdated($user_profile));

        Flash::success(icon() . "Store Updated Successfully!")->important();

        Log::info(
            label_case($module_title . " " . $module_action) .
                " | User:" .
                auth()->user()->name .
                "(ID:" .
                auth()->user()->id .
                ")"
        );

        return redirect()->route(
            "backend.{$module_name}.show",
            $$module_name_singular->id
        );
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
        $module_model_user = "App\Models\User";
        $module_name_singular = Str::singular($module_name);

        $module_action = "destroy";

        if (auth()->user()->id === $id || $id === 1) {
            Flash::warning(
                "<i class='fas fa-exclamation-triangle'></i> You can not delete this user!"
            )->important();

            Log::notice(
                label_case($module_title . " " . $module_action) .
                    " Failed | User:" .
                    auth()->user()->name .
                    "(ID:" .
                    auth()->user()->id .
                    ")"
            );

            return redirect()->back();
        }

        $$module_name_singular = $module_model_user::findOrFail($id);

        $$module_name_singular->delete();

        event(new UserUpdated($$module_name_singular));

        flash(
            '<i class="fas fa-check"></i> ' .
                $$module_name_singular->name .
                " User Successfully Deleted!"
        )->success();

        Log::info(
            label_case($module_action) .
                " '{$module_name}': '" .
                $$module_name_singular->name .
                ", ID:" .
                $$module_name_singular->id .
                " ' by User:" .
                auth()->user()->name
        );

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
        $module_model_user = "App\Models\User";
        $module_name_singular = Str::singular($module_name);

        $module_action = "Deleted List";
        $page_heading = $module_title;

        $$module_name = $module_model_user
            ::onlyTrashed()
            ->orderBy("deleted_at", "desc")
            ->paginate();

        Log::info(
            label_case($module_action) .
                " " .
                label_case($module_name) .
                " by User:" .
                auth()->user()->name
        );

        return view(
            "backend.{$module_name}.trash",
            compact(
                "module_name",
                "module_title",
                "{$module_name}",
                "module_icon",
                "page_heading",
                "module_action"
            )
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
        $module_model_user = "App\Models\User";
        $module_name_singular = Str::singular($module_name);

        $module_action = "Restore";

        $$module_name_singular = $module_model_user::withTrashed()->find($id);

        $$module_name_singular->restore();

        $$module_name_singular
            ->userprofile()
            ->withTrashed()
            ->restore();

        event(new UserUpdated($$module_name_singular));

        flash(
            '<i class="fas fa-check"></i> ' .
                $$module_name_singular->name .
                " Successfully Restoreded!"
        )->success();

        Log::info(
            label_case($module_action) .
                " '{$module_name}': '" .
                $$module_name_singular->name .
                ", ID:" .
                $$module_name_singular->id .
                " ' by User:" .
                auth()->user()->name
        );

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
        $module_title = "Qr Code";
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = "Create";

        // Find the store by ID
        $store = Store::where("user_id", $storeId)->first();

        $advertisements = Advertisement::where("status", 1)
            ->where("store_id",$storeId)
            ->where("deleted_at", null) // Assuming 'isdeleted' is a boolean column
            ->get();

        logUserAccess($module_title . " " . $module_action);

        return view(
            "{$module_path}.{$module_name}.add_campaign",
            compact(
                "module_title",
                "module_name",
                "module_path",
                "module_icon",
                "module_name_singular",
                "module_action",
                "store",
                "store",
                "storeId",
                "advertisements"
            )
        );
    }

    public function editCampaign($storeId, $campaignId)
    {
        $module_title = "Qr Code";
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        // $module_model = $this->module_model;
        $module_model = "Modules\Stores\Entities\Campaign";
        $module_name_singular = Str::singular($module_name);

        $module_action = "Edit";

        // Find the store by ID
        $store = User::findOrFail($storeId);

        $campaign = $module_model::findOrFail($campaignId);

        $coupons = Coupon::where("status", 1)
            ->where("deleted_at", null)
            ->get();

        $adv_videos = Advertisement::where("status", 1)
            ->where("deleted_at", null)
            ->where("media_type", "Video")
            ->get();

        $adv_images = Advertisement::where("status", 1)
            ->where("deleted_at", null)
            ->where("media_type", "Image")
            ->get();

        logUserAccess($module_title . " " . $module_action);

        return view(
            "{$module_path}.{$module_name}.edit_campaign",
            compact(
                "module_title",
                "module_name",
                "module_path",
                "module_icon",
                "module_name_singular",
                "module_action",
                "store",
                "coupons",
                "adv_videos",
                "adv_images",
                "campaign"
            )
        );
    }

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
        $module_title = "Campaign";
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = "Modules\Stores\Entities\Campaign";
        $module_name_singular = Str::singular($module_name);

        $module_action = "Store";

        // Validate the incoming request data
        $request->validate([
            "campaign_name" => "required",
            "advertisement_ids" => "required",
        ]);

        $campaignId = $module_model::latest()->value("id") + 1;
        $storeId = $request->store_id;
        $url = url("/store/" . $storeId . "/campaign/" . $campaignId);
        $qrCode = QrCode::format("png")
            ->size(200)
            ->generate($url);
        $qr_code_image = base64_encode($qrCode);

        // Create a new campaign record
        $$module_name_singular = $module_model::create([
            "campaign_name" => $request->campaign_name,
            "store_id" => $storeId,
            "qr_code_url" => $url,
            "qr_code_image" => $qr_code_image,
            "advertisement_ids" => $request->advertisement_ids,
        ]);

        flash(icon() . "New '" . Str::singular($module_title) . "' Added")
            ->success()
            ->important();

        // Log the successful creation of the campaign
        Log::info(
            "Campaign created successfully | Id: " . $$module_name_singular->id
        );

        return back();
    }

    public function updateCampaign(Request $request)
    {
        $module_title = "Campaign";
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = "Modules\Stores\Entities\Campaign";
        $module_name_singular = Str::singular($module_name);

        $module_action = "Update";

        // Validate the incoming request data
        $request->validate([
            "campaign_name" => "required",
            // 'qr_code_url' => 'required|url',
            "coupons_id" => "required",
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

            flash(icon() . Str::singular($module_title) . " Updated")
                ->success()
                ->important();
        } else {
            flash("Failed to update " . Str::singular($module_title))
                ->error()
                ->important();
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
        $module_model = "Modules\Stores\Entities\Campaign";
        $module_name_singular = Str::singular($module_name);
    
        $module_action = "List";
    
        $page_heading = label_case($module_title);
        $title = $page_heading . " " . label_case($module_action);
    
        $campaigns = $module_model::select("campaign.*")->where('store_id', $storeId)->get();
    
        return Datatables::of($campaigns)
            ->addColumn("edit_campaign", function ($data) use ($module_name) {
                $storeId = $data->store_id;
                $campaignId = $data->id;
                $route = route("backend.{$module_name}.edit-campaign", [
                    "storeId" => $storeId,
                    "campaignId" => $campaignId,
                ]);
                $button = '<div class="d-flex justify-content-center">
                                <a href="' . $route . '" class="btn btn-primary">Edit</a>
                           </div>';
                return new HtmlString($button);
            })
            ->editColumn("store_id", function ($data) {
                return $data->store_id; // Assuming 'store_id' is a valid column in the 'campaigns' table
            })
            ->editColumn("qr_code_image", function ($data) {
                return '<img src="data:image/png;base64,' . $data->qr_code_image . '" alt="QR Code" />';
            })
            ->rawColumns(["qr_code_image", "edit_campaign"])
            ->make(true);
    }
    

           /**
     * Show form to add advertisment for a store.
     *
     * @param  int  $storeId
     * @return \Illuminate\Contracts\View\View
     */
    public function addAdvertisement($storeId)
    {
        $module_title = "Advertisement";
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = "Create";

        // Find the store by ID
        $store = Store::where("user_id", $storeId)->first();
       
        // // Find the user details by ID
        // $userDetails = User::where("id", $storeId)->first();

        $coupons = Coupon::where("status", 1)
            ->where("deleted_at", null) // Assuming 'isdeleted' is a boolean column
            ->get();

        $adv_videos = Video::where("status", 1)
            ->where("deleted_at", null)
            ->get();
        
        $adv_images = Gallery::where("status", 1)
            ->where("deleted_at", null)
            ->get();

        $other_images = Otherprize::where("status", 1)
        ->where("deleted_at", null)
        ->get();    

        $advertisement_count= Advertisement::where("store_id", $storeId)
        ->count(); 
        $advertisement_count_for_name =  $advertisement_count + 1;  

        logUserAccess($module_title . " " . $module_action);

        return view(
            "{$module_path}.{$module_name}.add_advertisement",
            compact(
                "module_title",
                "module_name",
                "module_path",
                "module_icon",
                "module_name_singular",
                "module_action",
                "store",
                "coupons",
                "adv_videos",
                "adv_images",
                "store",
                "advertisement_count_for_name",
                "other_images"
            )
        );
    }

       /**
     * Store a new advertisement in the database.
     *
     * @param  \Illuminate\Http\Request  $request  The request object containing the campaign data.
     * @return \Illuminate\Http\RedirectResponse  The response object that redirects to the index page of the module.
     *
     * @throws \Exception If there is an error during the creation of the campaign.
     */
    public function storeAdvertisement(Request $requestData)
    {
        $module_title = "Advertisement";
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_action = "Store";

       // Validate the incoming request data
        $requestData->validate([
            "advertisement_name" => "required",
            "coupon_id" => "required",
        ]);

        $couponIdArray = $requestData['coupon_id'];
        $noOfCouponArray = array_filter($requestData['no_of_coupon']); // Remove null values
        $noOfCouponSum = array_sum($requestData['no_of_coupon']);

        $combinedDataCoupon = [];

        // Combine coupon_id with no_of_coupon
        foreach ($couponIdArray as $index => $couponId) {
            if (isset($noOfCouponArray[$index])) {
                $combinedDataCoupon[$couponId] = $noOfCouponArray[$index];
            }
        }

        // Convert combined data to JSON format
        $jsonDataCoupon = json_encode($combinedDataCoupon);

        if (empty($couponIdArray) || empty($noOfCouponArray)) {
            // Return an error response
            return response()->json(['error' => 'Coupon ID or number of coupons is missing.'], 400);
        }

        $advertisement_name = $requestData['advertisement_name_hid'].$requestData['advertisement_name'];
        $secondaryImageIdsString = implode(',', $requestData['secondary_image_id']);
        $otherCouponImageIdsString = implode(',', $requestData['other_coupon_image_ids']);

        $data = [
            "advertisement_name" => $advertisement_name,
            "store_id" => $requestData['user_id'],
            "adv_video_id" => $requestData['video_id'],
            "heading" => $requestData['heading'],
            "primary_image_id" => $requestData['primary_image_id'],
            "secondary_images_id" => $secondaryImageIdsString,
            "other_coupon_prize_heading" => $requestData['heading_other_prize'],
            "other_coupon_images_id" => $otherCouponImageIdsString,
            "coupons_id" => $jsonDataCoupon,
            "total_no_of_coupons" => $noOfCouponSum,
            "lock_time" => $requestData['lock_time'],
            "winning_ratio" => $requestData['winning_ratio'],
            "status" => 1
        ];

        $request_type='';
       
        if($requestData['action'] == "preview_winning" || $requestData['action'] == "preview_lose")
        {
            $module_name = 'Modules\Stores\Entities\Previewadvertisement';
            $data["winning_type"] = $requestData['action'] == "preview_winning" ? 'winning' : 'lose';
            $store_id =  $requestData['user_id'];
            $request_type='1';


            $tableName = (new $module_name)->getTable();
            // Delete records based on criteria
            \DB::table($tableName)
                ->where('store_id', $store_id)
                ->where('winning_type', $data["winning_type"])
                ->delete(); 
        }
        else{
            $module_name = 'Modules\Stores\Entities\Advertisement';
            $request_type='2';
        }
 
        $request_action = $requestData['action'] == "preview_winning" ? '1' : '2';

        $module_name_singular = Str::singular($module_name);
        $$module_name_singular = $module_name::create($data);

        $store = Store::where("user_id", $requestData['user_id'])->first();
        // Check if the model instance exists

        if($request_type == '2'){  //// preview advertisement
            $module_name_pr_adv = 'Modules\Stores\Entities\Previewadvertisement';
            $tableName = (new $module_name_pr_adv)->getTable();
            // Truncate the table
            \DB::table($tableName)->truncate();

            if ($store && $store->step_completed < 3) {
                // Update the attributes
                $store->step_completed = 3;
                $store->save();
            }
            flash(icon() . "New '" . Str::singular($module_title) . "' Added")
            ->success()
            ->important();

            // Log the successful creation of the campaign
            Log::info(
                "Advertisement created successfully | Id: " . $$module_name_singular->id
            );
            // return back();
            return response()->json([
                'response_type' => 'store'
            ]);
        }
        else {
            return response()->json([
                'storeId' => $store_id,
                'request_action' => $request_action,
                'response_type' => 'preview'
            ]);
        }        
       
    }


     /**
     * Retrieves the data for the index page of the module.
     *
     * @param  int  $storeId
     * @return Illuminate\Http\JsonResponse
     */
    public function advertisementIndex($storeId)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = "Modules\Stores\Entities\Advertisement";
        $module_name_singular = Str::singular($module_name);
    
        $module_action = "List";
    
        $page_heading = label_case($module_title);
        $title = $page_heading . " " . label_case($module_action);
    
        $advertisements = $module_model::select("advertisement.*","videos.media","videos.media_type")
        ->join('videos', 'advertisement.adv_video_id', '=', 'videos.id')
        ->where('advertisement.store_id', $storeId)
        ->get();
     
        return Datatables::of($advertisements)
            ->addColumn("edit_advertisement", function ($data) use ($module_name) {
                $storeId = $data->store_id;
                $advertisementId = $data->id;
                $media_type =  $data->media_type;
                $media = $data->media;

                $route = route("backend.{$module_name}.edit-campaign", [
                    "storeId" => $storeId,
                    "campaignId" => $advertisementId,
                ]);
                $button = '<div class="d-flex justify-content-center">
                                <a href="' . $route . '" class="btn btn-primary">Edit</a>
                           </div>';
                return new HtmlString($button);
            })
            ->editColumn("id", '{{$id}}')
            ->editColumn("advertisement_name", '{{$advertisement_name}}')
            ->editColumn('media', '@if($media_type == "Video" || $media_type == "video") <video width="150" height="140" controls>
                <source src="{{ Storage::url($media) }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            @elseif($media_type == "Youtube" || $media_type == "youtube") 
                <iframe width="150" height="140" src="{{ $media }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            @elseif($media_type == "Vimeo" || $media_type == "vimeo") 
                <iframe src="{{ $media }}" width="150" height="140" frameborder="0" allowfullscreen></iframe>
            @else <span> No Media </span> @endif')
            ->rawColumns(["edit_advertisement","media"])
            ->make(true);
    }


    /**
     * Show form to show preview adv for a store.
     *
     * @param  int  $storeId
     * @return \Illuminate\Contracts\View\View
     */
    public function previewAdvertisement($storeId,$request_action)
    {
        $module_title = "Preview Advertisement";
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = "Show";

        $winning_type = $request_action == '1' ? 'winning' : 'lose'; 
        $preview_advertisements = Previewadvertisement::where("store_id", $storeId)
        ->where("winning_type",$winning_type)
        ->first();
        // Find the store by ID
        $store = Store::where("user_id", $storeId)->first();

        $adv_videos = Video::where("status", 1)
            ->where("id",$preview_advertisements->adv_video_id)
            ->where("deleted_at", null)
            ->first();

        $primary_image = Gallery::where("status", 1)
        ->where("id", $preview_advertisements->primary_image_id)
        ->where("deleted_at", null)
        ->first();


        $secondary_image_ids = explode(',', $preview_advertisements->secondary_images_id);

        $secondary_images = Gallery::whereIn("id", $secondary_image_ids)
            ->where("status", 1)
            ->whereNull("deleted_at")
            ->get();

        $other_image_ids = explode(',', $preview_advertisements->other_coupon_images_id);

        $other_images = Otherprize::whereIn("id", $other_image_ids)
            ->where("status", 1)
            ->whereNull("deleted_at")
            ->get();    

        
        // Decode the JSON data into an associative array
        $coupon_data = json_decode($preview_advertisements->coupons_id, true);
        
        // Extract the keys (coupon IDs)
        $coupon_ids = array_keys($coupon_data);
        
        // Fetch the coupons based on the extracted IDs
        $coupons = Coupon::whereIn('id', $coupon_ids)->get();   
        // $advertisement_count= Advertisement::where("store_id", $storeId)
        // ->count(); 
        // $advertisement_count_for_name =  $advertisement_count + 1;  

        logUserAccess($module_title . " " . $module_action);

        return view(
            "{$module_path}.{$module_name}.preview_advertisement",
            compact(
                "module_title",
                "module_name",
                "module_path",
                "module_icon",
                "module_name_singular",
                "module_action",
                "store",
                "adv_videos",
                "primary_image",
                // "advertisement_count_for_name",
                "other_images",
                "preview_advertisements",
                "secondary_images",
                "request_action",
                "coupons"
            )
        );
    }
    

}
