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
use Illuminate\Support\Facades\Auth;

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
        $$module_name = User::select('users.*')
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
        ->editColumn('name', '<strong>{{$name}}</strong>')
        ->editColumn('email', '{{$email}}')
        ->editColumn('mobile', '{{$mobile}}')
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
        ->rawColumns(['name', 'email', 'mobile', 'created_at', 'action'])
        ->make(true);
    }
    // You may have other methods related to store_qrcodes here
}