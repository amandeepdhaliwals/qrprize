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
use Illuminate\Support\Facades\Auth;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;


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

        $rolesId = [5];
     
        $role_id=auth()->user()->roles->pluck('id')->toArray();
        $login_role_id = $role_id[0];
        $login_user_id = Auth::id();


        if($login_role_id == 1 ){
            $$module_name = User::select('users.id', 'users.name', 'users.email', 'users.mobile', 'store_users.name as store_name', 'users.created_at', 'users.updated_at') 
            ->join('customers', 'users.id', '=', 'customers.user_id')
            ->join('users as store_users', 'customers.store_id', '=', 'store_users.id') 
            ->whereHas('roles', function ($query) use ($rolesId) {
                $query->whereIn('id', $rolesId);
            })->get();
        }else{
            $$module_name = User::select('users.id', 'users.name', 'users.email', 'users.mobile', 'store_users.name as store_name', 'users.created_at', 'users.updated_at')
            ->join('customers', 'users.id', '=', 'customers.user_id')
            ->join('users as store_users', 'customers.store_id', '=', 'store_users.id') 
            ->where('customers.store_id', '=' , $login_user_id) // Replace $storeId with the desired store_id value
            ->whereHas('roles', function ($query) use ($rolesId) {
                $query->whereIn('id', $rolesId);
            })->get();
        }

        //dd($login_role_id);


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

    public function exportToExcel(Request $request)
    {
        $data = $request->input('filteredData');
        
       return Excel::download(new CustomerExport($data), 'customers.xlsx');

    }

    public function stats(Request $request)
    {
        
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_action = 'Stats';
         // Fetching customer data grouped by month
        //  $customers = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
        //  ->groupBy('month')
        //  ->pluck('count', 'month')
        //  ->all();

         $rolesId = [5];
     
         $role_id=auth()->user()->roles->pluck('id')->toArray();
         $login_role_id = $role_id[0];
         $login_user_id = Auth::id();
 
 
         if($login_role_id == 1 ){
             $customers = User::selectRaw('MONTH(users.created_at) as month, COUNT(*) as count')
             ->join('customers', 'users.id', '=', 'customers.user_id')
             ->join('users as store_users', 'customers.store_id', '=', 'store_users.id')
             ->whereHas('roles', function ($query) use ($rolesId) {
                 $query->whereIn('roles.id', $rolesId);
             })
             ->groupByRaw('MONTH(users.created_at)')
             ->pluck('count', 'month')
             ->all();

             $winCustomers = User::selectRaw('MONTH(users.created_at) as month, COUNT(*) as count')
            ->join('customers', 'users.id', '=', 'customers.user_id')
            ->join('users as store_users', 'customers.store_id', '=', 'store_users.id')
            ->join('customer_statistics as cs', 'customers.user_id', '=', 'cs.customer_id')
            ->where('cs.win_count','>',0)
            ->whereHas('roles', function ($query) use ($rolesId) {
                $query->whereIn('roles.id', $rolesId);
            })
            ->groupByRaw('MONTH(users.created_at)')
            ->pluck('count', 'month')
            ->all();

            $loseCustomers = User::selectRaw('MONTH(users.created_at) as month, COUNT(*) as count')
            ->join('customers', 'users.id', '=', 'customers.user_id')
            ->join('users as store_users', 'customers.store_id', '=', 'store_users.id')
            ->join('customer_statistics as cs', 'customers.user_id', '=', 'cs.customer_id')
            ->where('cs.lose_count','>',0 )
            ->where('cs.win_count','=',0 )
            ->whereHas('roles', function ($query) use ($rolesId) {
                $query->whereIn('roles.id', $rolesId);
            })
            ->groupByRaw('MONTH(users.created_at)')
            ->pluck('count', 'month')
            ->all();


         }else{
            $customers = User::selectRaw('MONTH(users.created_at) as month, COUNT(*) as count')
            ->join('customers', 'users.id', '=', 'customers.user_id')
            ->join('users as store_users', 'customers.store_id', '=', 'store_users.id')
            ->where('customers.store_id', '=' , $login_user_id) // Replace $storeId with the desired store_id value
            ->whereHas('roles', function ($query) use ($rolesId) {
                $query->whereIn('roles.id', $rolesId);
            })
            ->groupByRaw('MONTH(users.created_at)')
            ->pluck('count', 'month')
            ->all();

            $winCustomers = User::selectRaw('MONTH(users.created_at) as month, COUNT(*) as count')
            ->join('customers', 'users.id', '=', 'customers.user_id')
            ->join('users as store_users', 'customers.store_id', '=', 'store_users.id')
            ->join('customer_statistics as cs', 'customers.user_id', '=', 'cs.customer_id')
            ->where('cs.win_count','>',0)
            ->where('customers.store_id', '=' , $login_user_id) // Replace $storeId with the desired store_id value
            ->whereHas('roles', function ($query) use ($rolesId) {
                $query->whereIn('roles.id', $rolesId);
            })
            ->groupByRaw('MONTH(users.created_at)')
            ->pluck('count', 'month')
            ->all();

            $loseCustomers = User::selectRaw('MONTH(users.created_at) as month, COUNT(*) as count')
            ->join('customers', 'users.id', '=', 'customers.user_id')
            ->join('users as store_users', 'customers.store_id', '=', 'store_users.id')
            ->join('customer_statistics as cs', 'customers.user_id', '=', 'cs.customer_id')
            ->where('cs.lose_count','>',0 )
            ->where('cs.win_count','=',0 )
            ->where('customers.store_id', '=' , $login_user_id) // Replace $storeId with the desired store_id value
            ->whereHas('roles', function ($query) use ($rolesId) {
                $query->whereIn('roles.id', $rolesId);
            })
            ->groupByRaw('MONTH(users.created_at)')
            ->pluck('count', 'month')
            ->all();
           
         }

     // Define month labels
     $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
     
      // Initialize data arrays with zeros
      $totalData = array_fill(0, 12, 0);
      $winData = array_fill(0, 12, 0);
      $loseData = array_fill(0, 12, 0);
      
      // Populate data arrays with customer counts
      foreach ($customers as $month => $count) {
          $totalData[$month - 1] = $count;  // $month - 1 to convert 1-based month to 0-based index
      }
      foreach ($winCustomers as $month => $count) {
          $winData[$month - 1] = $count;
      }
      foreach ($loseCustomers as $month => $count) {
          $loseData[$month - 1] = $count;
      }

      // Create chart
      $chart = new Chart;
      $chart->labels($months);
      $chart->dataset('Total Customers', 'bar', $totalData)
            ->backgroundColor('rgba(0, 123, 255, 0.7)');
      $chart->dataset('Win Customers', 'bar', $winData)
            ->backgroundColor('rgba(40, 167, 69, 0.7)');
      $chart->dataset('Lose Customers', 'bar', $loseData)
            ->backgroundColor('rgba(220, 53, 69, 0.7)');


     return view("{$module_path}.{$module_name}.stats", compact('module_title', 'module_name', 'module_path', 'module_action','module_icon', 'chart'));
    }

}

