<?php

namespace App\Http\Controllers\Frontend;

use App\Authorizable;
use App\Events\Frontend\UserProfileUpdated;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\Userprofile;
use App\Models\UserProvider;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Events\Backend\UserCreated;
use Illuminate\Support\Arr;
use Laracasts\Flash\Flash;
use Modules\Customers\Entities\Customer;
use Modules\Customers\Entities\OtpVerification;
use Modules\Customers\Entities\CustomerResult;
use Carbon\Carbon;
use App\Notifications\OTPNotification;
use Illuminate\Support\Facades\Notification;


class UserController extends Controller
{
    use Authorizable;

    public $module_title;

    public $module_name;

    public $module_path;

    public $module_icon;

    public $module_model;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Users';

        // module name
        $this->module_name = 'users';

        // directory path of the module
        $this->module_path = 'users';

        // module icon
        $this->module_icon = 'fas fa-users';

        // module model name, path
        $this->module_model = "App\Models\User";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param  string  $username  The username of the resource to be displayed.
     * @return Response
     * @return \Illuminate\Contracts\View\View Returns a view of the specified resource.
     *
     * @throws \Exception If the resource is not found.
     */
    public function show($username)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Show';

        $$module_name_singular = $module_model::where('username', 'LIKE', $username)->first();

        $body_class = 'profile-page';

        $meta_page_type = 'profile';

        return view(
            "frontend.{$module_name}.show",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular', "{$module_name_singular}", 'body_class', 'meta_page_type')
        );
    }

    /**
     * Retrieves the profile information for a given user ID.
     *
     * @param  int  $id
     * @param  int  $id  The ID of the user.
     * @return \Illuminate\Http\Response
     * @return Illuminate\View\View The view containing the user profile information.
     *
     * @throws ModelNotFoundException If the user profile is not found.
     */
    public function profile($id)
    {
        $id = decode_id($id);

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Profile';

        $$module_name_singular = $module_model::findOrFail($id);

        if ($$module_name_singular) {
            $userprofile = Userprofile::where('user_id', $id)->first();
        } else {
            Log::error('UserProfile Exception for Username: '.$username);
            abort(404);
        }

        $body_class = 'profile-page';

        $meta_page_type = 'profile';

        return view("frontend.{$module_name}.profile", compact('module_name', 'module_name_singular', "{$module_name_singular}", 'module_icon', 'module_action', 'module_title', 'body_class', 'userprofile', 'meta_page_type'));
    }

    /**
     * Edit a user profile.
     *
     * @param  int  $id
     * @param  int  $id  the ID of the user profile to edit
     * @return \Illuminate\Http\Response
     * @return \Illuminate\View\View the view for editing the user profile
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException if the user profile is not found
     */
    public function profileEdit($id)
    {
        $id = decode_id($id);

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Edit Profile';

        $page_heading = ucfirst($module_title);
        $title = $page_heading.' '.ucfirst($module_action);

        if (! auth()->user()->can('edit_users')) {
            $id = auth()->user()->id;
        }

        if ($id !== auth()->user()->id) {
            return redirect()->route('frontend.users.profile', encode_id($id));
        }

        $$module_name_singular = $module_model::findOrFail($id);
        $userprofile = Userprofile::where('user_id', $id)->first();

        $body_class = 'profile-page';

        return view(
            "frontend.{$module_name}.profileEdit",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular', "{$module_name_singular}", 'userprofile', 'body_class')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profileUpdate(Request $request, $id)
    {
        $id = decode_id($id);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Profile Update';

        if ($id !== auth()->user()->id) {
            return redirect()->route('frontend.users.profile', encode_id($id));
        }

        $this->validate($request, [
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $module_name = $this->module_name;
        $module_name_singular = Str::singular($this->module_name);

        if (! auth()->user()->can('edit_users')) {
            $id = auth()->user()->id;
            $username = auth()->user()->username;
        }

        $$module_name_singular = $module_model::findOrFail($id);

        // Handle Avatar upload
        if ($request->hasFile('avatar')) {
            if ($$module_name_singular->getMedia($module_name)->first()) {
                $$module_name_singular->getMedia($module_name)->first()->delete();
            }

            $media = $$module_name_singular->addMedia($request->file('avatar'))->toMediaCollection($module_name);

            $$module_name_singular->avatar = $media->getUrl();

            $$module_name_singular->save();
        }

        $data_array = $request->except('avatar');
        $data_array['avatar'] = $$module_name_singular->avatar;
        $data_array['name'] = $request->first_name.' '.$request->last_name;

        $user_profile = Userprofile::where('user_id', '=', $$module_name_singular->id)->first();
        $user_profile->update($data_array);

        event(new UserProfileUpdated($user_profile));

        return redirect()->route('frontend.users.profile', encode_id($$module_name_singular->id))->with('flash_success', 'Update successful!');
    }

    /**
     * Change password for a user.
     *
     * @param  int  $id
     * @param  int  $id  The ID of the user.
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View The redirect response if the user ID is not the same as the authenticated user's ID, otherwise the view with the change password form.
     *
     * @throws \Exception If the user ID cannot be decoded or if the user is not authenticated.
     */
    public function changePassword($id)
    {
        $id = decode_id($id);

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'change Password';

        $body_class = 'profile-page';

        if ($id !== auth()->user()->id) {
            return redirect()->route('frontend.users.profile', encode_id($id));
        }

        $id = auth()->user()->id;

        $$module_name_singular = $module_model::findOrFail($id);

        $body_class = 'profile-page';

        return view("frontend.{$module_name}.changePassword", compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular', "{$module_name_singular}", 'body_class'));
    }

    /**
     * Updates the password for a user.
     *
     * @param  int  $id
     * @param  Request  $request  The HTTP request object.
     * @param  mixed  $id  The ID of the user.
     * @return \Illuminate\Http\Response
     * @return mixed The updated user object.
     */
    public function changePasswordUpdate(Request $request, $id)
    {
        $id = decode_id($id);

        if ($id !== auth()->user()->id) {
            return redirect()->route('frontend.users.profile', encode_id(auth()->user()->id));
        }

        $this->validate($request, [
            'password' => 'required|confirmed|min:6',
        ]);

        $module_name = $this->module_name;
        $module_name_singular = Str::singular($this->module_name);

        $$module_name_singular = auth()->user();

        $request_data = $request->only('password');
        $request_data['password'] = Hash::make($request_data['password']);

        $$module_name_singular->update($request_data);

        return redirect()->route('frontend.users.profile', encode_id(auth()->user()->id))->with('flash_success', 'Update successful!');
    }

    /**
     * Edit a record in the database.
     *
     * @param  int  $id
     * @param  int  $id  The ID of the record to be edited.
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\Factory|\Illuminate\View\View The response or view after editing the record.
     *
     * @throws \Exception If the user is not authorized to edit the record.
     */
    public function edit($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Edit';

        if ($id !== auth()->user()->id) {
            return redirect()->route('frontend.users.profile', encode_id($id));
        }

        $roles = Role::get();
        $permissions = Permission::select('name', 'id')->get();

        $$module_name_singular = User::findOrFail($id);

        $body_class = 'profile-page';

        $userRoles = $$module_name_singular->roles->pluck('name')->all();
        $userPermissions = $$module_name_singular->permissions->pluck('name')->all();

        return view("frontend.{$module_name}.edit", compact('userRoles', 'userPermissions', 'module_name', "{$module_name_singular}", 'module_icon', 'module_action', 'title', 'roles', 'permissions', 'body_class'));
    }

    /**
     * Updates a record in the database.
     *
     * @param  int  $id
     * @param  Request  $request  The HTTP request object.
     * @param  int  $id  The ID of the record to update.
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Http\RedirectResponse The redirect response.
     */
    public function update(Request $request, $id)
    {
        $module_name = $this->module_name;
        $module_name_singular = Str::singular($this->module_name);

        if ($id !== auth()->user()->id) {
            return redirect()->route('frontend.users.profile', encode_id($id));
        }

        $$module_name_singular = User::findOrFail($id);

        $$module_name_singular->update($request->except(['roles', 'permissions']));

        if ($id === 1) {
            $user->syncRoles(['administrator']);

            return redirect("admin/{$module_name}")->with('flash_success', 'Update successful!');
        }

        $roles = $request['roles'];
        $permissions = $request['permissions'];

        // Sync Roles
        if (isset($roles)) {
            $$module_name_singular->syncRoles($roles);
        } else {
            $roles = [];
            $$module_name_singular->syncRoles($roles);
        }

        // Sync Permissions
        if (isset($permissions)) {
            $$module_name_singular->syncPermissions($permissions);
        } else {
            $permissions = [];
            $$module_name_singular->syncPermissions($permissions);
        }

        return redirect("admin/{$module_name}")->with('flash_success', 'Update successful!');
    }

    /**
     * Destroy a user provider.
     *
     * @param  Request  $request  The request object.
     * @return RedirectResponse The redirect response.
     *
     * @throws Exception There was a problem updating this user. Please try again.
     */
    public function userProviderDestroy(Request $request)
    {
        $user_provider_id = $request->user_provider_id;
        $user_id = $request->user_id;

        if (! $user_provider_id > 0 || ! $user_id > 0) {
            flash('Invalid Request. Please try again.')->error();

            return redirect()->back();
        }
        $user_provider = UserProvider::findOrFail($user_provider_id);

        if ($user_id === $user_provider->user->id) {
            $user_provider->delete();

            flash('<i class="fas fa-exclamation-triangle"></i> Unlinked from User, "'.$user_provider->user->name.'"!')->success();

            return redirect()->back();
        }
        flash('<i class="fas fa-exclamation-triangle"></i> Request rejected. Please contact the Administrator!')->warning();

        throw new Exception('There was a problem updating this user. Please try again.');
    }

    /**
     * Resends the email confirmation for a user.
     *
     * @param [type] $hashid [description]
     * @param  int  $id  The decoded ID of the user.
     * @return [type] [description]
     * @return RedirectResponse The redirect response.
     *
     * @throws Exception If the user is not authorized to resend the email confirmation.
     */
    public function emailConfirmationResend($id)
    {
        $id = decode_id($id);

        if ($id !== auth()->user()->id) {
            if (auth()->user()->hasAnyRole(['administrator', 'super admin'])) {
                Log::info(auth()->user()->name.' ('.auth()->user()->id.') - User Requested for Email Verification.');
            } else {
                Log::warning(auth()->user()->name.' ('.auth()->user()->id.') - User trying to confirm another users email.');

                abort('404');
            }
        }

        $user = User::where('id', 'LIKE', $id)->first();

        if ($user) {
            if ($user->email_verified_at === null) {
                Log::info($user->name.' ('.$user->id.') - User Requested for Email Verification.');

                // Send Email To Registered User
                $user->sendEmailVerificationNotification();

                flash('Email Sent! Please Check Your Inbox.')->success()->important();

                return redirect()->back();
            }
            Log::info($user->name.' ('.$user->id.') - User Requested but Email already verified at.'.$user->email_verified_at);

            flash($user->name.', You already confirmed your email address at '.$user->email_verified_at->isoFormat('LL'))->success()->important();

            return redirect()->back();
        }
    }


    public function create_user(Request $request)
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
            'phone_number' => 'required|max:15|unique:users'
        ]);

        $data_array = $request->except('_token', 'roles', 'permissions', 'password_confirmation');
        $data_array['name'] = $request->first_name.' '.$request->last_name;
        $data_array['mobile'] = $request->phone_number;
        $password = Str::random(8);
        $data_array['password'] = Hash::make($password);

        $data_array = Arr::add($data_array, 'email_verified_at', null);

        $$module_name_singular = User::create($data_array);

        $$module_name_singular->assignRole("user");

        $id = $$module_name_singular->id;
        $username = config('app.initial_username') + $id;
        Userprofile::create([
            "user_id" => $$module_name_singular->id,
            "name" => $request->first_name.' '.$request->last_name,
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "username" => $username,
            "email" => $request->email,
            "mobile" => $request->phone_number
        ]);
         // Insert entry into store_qrcodes
         Customer::create([
            "user_id" => $$module_name_singular->id,
            "store_id" => $request->store_id,
        ]);

        $updateUser = User::where(
            "id",
            $$module_name_singular->id
        )->first();

        if ($updateUser) {
            $updateUser->username = $username;
            $updateUser->save();
        }

        //////////////for email //////////////////////

        $otpCodeEmail = rand(100000, 999999); // Generate a 6-digit OTP code
        OtpVerification::create([
            'user_id' => $$module_name_singular->id,
            'otp_code' => $otpCodeEmail,
            'type' => 'email', // 'email' or 'mobile'
            'expires_at' => Carbon::now()->addMinutes(10) // Set expiration time (e.g., 10 minutes)
        ]);

        //////////////////for mobile///////////////
        $otpCodeMobile = rand(100000, 999999); // Generate a 6-digit OTP code
        OtpVerification::create([
            'user_id' => $$module_name_singular->id,
            'otp_code' => $otpCodeMobile,
            'type' => 'mobile', // 'email' or 'mobile'
            'expires_at' => Carbon::now()->addMinutes(10) // Set expiration time (e.g., 10 minutes)
        ]);
        ///////////////////////////////////////////////

           // Send the OTP via email
        Notification::send($user, new OTPNotification($otpCodeEmail));


        return response()->json([
            'user_id' => $$module_name_singular->id,
            'storeId' => $request->store_id,
            'campaign_id' => $request->campaign_id,
            'adverisement_id' => $request->advertisement_id,
            'response_type' => 'success',
            'email_otp' => $otpCodeEmail, /// will remove
            'mobile_otp' => $otpCodeMobile,  /// will remove
        ]);
    }

    public function otp_verify(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Details';
        $win =false;

        if ($this->verifyOtp($request->user_id, $request->email_otp, $request->phone_number_otp)) {
            //////////////////win or lose user///////////
            $random_no = rand(0, 100);
            if($random_no == 7){
                $win = true;
            }

            if($win){
                CustomerResult::create([
                    'customer_id' => $request->user_id,
                    'store_id' => $request->store_id,
                    'campaign_id' => $request->campaign_id,
                    'advertisement_id' => $request->advertisement_id,
                    'win' => 1
                ]);
            }else{
                CustomerResult::create([
                    'customer_id' => $request->user_id,
                    'store_id' => $request->store_id,
                    'campaign_id' => $request->campaign_id,
                    'advertisement_id' => $request->advertisement_id,
                    'win' => 0
                ]);
            }
            //////////////////////////////////////////
            return response()->json([
                'response_type' => 'success',
                'result' => $win,
                'store_id'=>$request->store_id,
                'campaign_id'=> $request->campaign_id

            ]);
        }

                // if ($request->email_credentials === 1) {
        //     $data = [
        //         'password' => $password,
        //     ];
        //    $$module_name_singular->notify(new UserAccountCreated($data));

        //     Flash::success(icon('fas fa-envelope').' Account Credentials Sent to User.')->important();
        // }

        // Log::info(label_case($module_title.' '.$module_action)." | '".$$module_name_singular->name.'(ID:'.$$module_name_singular->id.") ' by User:".auth()->user()->name.'(ID:'.auth()->user()->id.')');

        //return redirect("admin/{$module_name}");

        return response()->json([
            'response_type' => 'failed',
            'result' => $win
        ]);
    }


    public function verifyOtp($userId, $otpCodeEmail, $otpCodeMobile) {
        $otp_email = OtpVerification::where('user_id', $userId)
                    ->where('otp_code', $otpCodeEmail)
                    ->where('type', 'email')
                    ->where('expires_at', '>', Carbon::now())
                    ->first();

        $otp_mobile = OtpVerification::where('user_id', $userId)
                    ->where('otp_code', $otpCodeMobile)
                    ->where('type', 'mobile')
                    ->where('expires_at', '>', Carbon::now())
                    ->first();
    
        if ($otp_email && $otp_mobile) {
            $otp_email->is_verified = 1;
            $otp_email->save();

            $otp_mobile->is_verified = 1;
            $otp_mobile->save();
            return true; // OTP is valid
        }else{
            return false;
        }
    }
}
