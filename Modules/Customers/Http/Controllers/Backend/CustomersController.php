<?php

namespace Modules\Customers\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CustomerExport;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\Userprofile;
use App\Modules\Customers\Entities\Customer;


class CustomersController extends BackendBaseController
{
    use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Customers';

        // Module name
        $this->module_name = 'customers';

        // Directory path of the module
        $this->module_path = 'customers::backend'; 

        // Module icon
        $this->module_icon = 'fa-solid fa-user';

        // Module model name, path
        $this->module_model = "Modules\Customers\Entities\Customer";
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

        $roleNames = ['user'];
     
        $role_id=auth()->user()->roles->pluck('id')->toArray();
        $login_role_id = $role_id[0];


        if($login_role_id == 1 ){
            $$module_name = User::select('users.id', 'users.name', 'users.email', 'users.mobile', 'store_users.name as store_name', 'users.created_at', 'users.updated_at') 
            ->join('customers', 'users.id', '=', 'customers.user_id')
            ->join('users as store_users', 'customers.store_id', '=', 'store_users.id') 
            ->whereHas('roles', function ($query) use ($roleNames) {
                $query->whereIn('name', $roleNames);
            })->get();
        }else{
            $$module_name = User::select('users.id', 'users.name', 'users.email', 'users.mobile', 'store_users.name as store_name', 'users.created_at', 'users.updated_at')
            ->join('customers', 'users.id', '=', 'customers.user_id')
            ->join('users as store_users', 'customers.store_id', '=', 'store_users.id') 
            ->where('customers.store_id', $login_role_id) // Replace $storeId with the desired store_id value
            ->whereHas('roles', function ($query) use ($roleNames) {
                $query->whereIn('name', $roleNames);
            })->get();
        }

        //dd($$module_name);


        $data = $$module_name;

       // dd($data);

        return Datatables::of($$module_name)
            // ->addColumn('action', function ($data) {
            //     $module_name = $this->module_name;

            //     return view('backend.includes.action_column', compact('module_name', 'data'));
            // })
            ->editColumn('name', '<strong>{{$name}}</strong>')
            ->editColumn('email', '{{$email}}')
            ->editColumn('mobile', '{{$mobile}}')
            ->editColumn('store_name', '{{$store_name}}')
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
            ->rawColumns(['name','email','mobile','store_name','created_at'])
           // ->orderColumns(['id'], '-:column $1')
            ->make(true);
    }

    public function exportToExcel()
    {

        $roleNames = ['user'];
     
        $role_id=auth()->user()->roles->pluck('id')->toArray();
        $login_role_id = $role_id[0];

        if($login_role_id == 1 ){
           $data = User::select('users.name', 'users.email', 'users.mobile', 'store_users.name as store_name') 
            ->join('customers', 'users.id', '=', 'customers.user_id')
            ->join('users as store_users', 'customers.store_id', '=', 'store_users.id') 
            ->whereHas('roles', function ($query) use ($roleNames) {
                $query->whereIn('name', $roleNames);
            })->get();
        }else{
            $data = User::select('users.name', 'users.email', 'users.mobile', 'store_users.name as store_name')
            ->join('customers', 'users.id', '=', 'customers.user_id')
            ->join('users as store_users', 'customers.store_id', '=', 'store_users.id') 
            ->where('customers.store_id', $login_role_id) // Replace $storeId with the desired store_id value
            ->whereHas('roles', function ($query) use ($roleNames) {
                $query->whereIn('name', $roleNames);
            })->get();
        }

        // Transform data if necessary

        // Export data to Excel
        return Excel::download(new CustomerExport($data), 'customers.xlsx');
    }

}

