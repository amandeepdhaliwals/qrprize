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
use Modules\Customers\Entities\Visitor;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\Userprofile;
use App\Modules\Customers\Entities\Customer;
use Illuminate\Support\Facades\Auth;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Illuminate\Support\Facades\Log;
use Modules\Stores\Entities\Advertisement; // Import the advertisement model
use Modules\Stores\Entities\Campaign;
use Modules\Coupons\Entities\Claim; // Import the Claim model
use Illuminate\Support\HtmlString;
use Laracasts\Flash\Flash;
use App\Notifications\ShippingStatusUpdated;
use Illuminate\Support\Facades\DB;



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

        $rolesId = [5];

        $stores = User::select('id','name')->whereNull('deleted_at')
        ->whereHas('roles', function ($query) use ($rolesId) {
            $query->where('id', 2);
        })
        ->get();

        $campaigns = Campaign::select('id','campaign_name')->whereNull('deleted_at')
        ->get();

        $advertisements = Advertisement::select('id','advertisement_name')->whereNull('deleted_at')
        ->get();

        return view(
            "{$module_path}.{$module_name}.index_datatable",
            compact('module_title', 'module_name', "{$module_name}", 'module_icon', 'module_name_singular', 'module_action','stores','campaigns','advertisements')
        );
    }

    public function index_data_cust(Request $request)
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
        $role_id = auth()->user()->roles->pluck('id')->toArray();
        $login_role_id = $role_id[0];
        $login_user_id = Auth::id();

        $store_id = $request->input('store');
        $campaign_id = $request->input('campaign');
        $advertisement_id = $request->input('adv');
        $win_lose = $request->input('win_lose');
        if ($login_role_id == 1) {
            $query = User::select('users.id', 'users.name', 'users.email', 'users.mobile',
                'users.created_at', 'users.updated_at', 'customer_statistics.win_count', 'customer_statistics.lose_count')
                // 'customers.campaign_id', 'customers.advertisement_id', 'campaign.campaign_name',
                // 'advertisement.advertisement_name','store_users.name as store_name',)
                // ->join('campaign', 'campaign.id', '=', 'customers.campaign_id')
                // ->join('advertisement', 'advertisement.id', '=', 'customers.advertisement_id')
                //->join('users as store_users', 'customers.store_id', '=', 'store_users.id')
                ->join('customers', 'users.id', '=', 'customers.user_id')
                ->join('customer_statistics', 'users.id', '=', 'customer_statistics.customer_id')
                // ->when($store_id, function ($query) use ($store_id) {
                //     $query->where('customers.store_id', $store_id);
                // })
                // ->when($campaign_id, function ($query) use ($campaign_id) {
                //     $query->where('customers.campaign_id', $campaign_id);
                // })
                // ->when($advertisement_id, function ($query) use ($advertisement_id) {
                //     $query->where('customers.advertisement_id', $advertisement_id);
                // })
                ->when($win_lose === '1', function ($query) {
                    $query->where('customer_statistics.win_count', '>', 0);
                })
                ->when($win_lose === '0', function ($query) {
                    $query->where('customer_statistics.win_count', '=', 0)
                        ->where('customer_statistics.lose_count', '>', 0);
                })
                ->whereHas('roles', function ($query) use ($rolesId) {
                    $query->whereIn('id', $rolesId);
                });
        } else {
            $query = User::select('users.id', 'users.name', 'users.email', 'users.mobile',
                'users.created_at', 'users.updated_at', 'customer_statistics.win_count', 'customer_statistics.lose_count')
                // 'customers.campaign_id', 'customers.advertisement_id', 'campaign.campaign_name',
                // 'advertisement.advertisement_name','store_users.name as store_name',)
                // ->join('campaign', 'campaign.id', '=', 'customers.campaign_id')
                // ->join('advertisement', 'advertisement.id', '=', 'customers.advertisement_id')
                //->join('users as store_users', 'customers.store_id', '=', 'store_users.id')
                ->join('customers', 'users.id', '=', 'customers.user_id')
                ->join('customer_statistics', 'users.id', '=', 'customer_statistics.customer_id')
                ->where('customers.store_id', '=', $login_user_id)
                // ->when($campaign_id, function ($query) use ($campaign_id) {
                //     $query->where('customers.campaign_id', $campaign_id);
                // })
                // ->when($advertisement_id, function ($query) use ($advertisement_id) {
                //     $query->where('customers.advertisement_id', $advertisement_id);
                // })
                ->when($win_lose === '1', function ($query) {
                    $query->where('customer_statistics.win_count', '>', 0);
                })
                ->when($win_lose === '0', function ($query) {
                    $query->where('customer_statistics.win_count', '=', 0)
                        ->where('customer_statistics.lose_count', '>', 0);
                })
                ->whereHas('roles', function ($query) use ($rolesId) {
                    $query->whereIn('id', $rolesId);
                });
        }

        $users = $query->get();

        foreach ($users as $user) {
            // Fetch campaigns based on customer_results table
            $user->campaigns = DB::table('campaign')
                ->join('customer_results', 'campaign.id', '=', 'customer_results.campaign_id')
                ->where('customer_results.customer_id', $user->id)
                ->when($campaign_id, function ($query) use ($campaign_id) {
                    $query->where('customer_results.campaign_id', $campaign_id);
                })
                ->when($advertisement_id, function ($query, $advertisement_id) {
                    // Filter by advertisement_id if provided
                    $query->where('customer_results.advertisement_id', $advertisement_id);
                })
                ->when($store_id, function ($query) use ($store_id) {
                    $query->where('customer_results.store_id', $store_id);
                })
                ->distinct()
                ->pluck('campaign.campaign_name');
    
            // Fetch advertisements based on customer_results table
            $user->advertisements = DB::table('advertisement')
                ->join('customer_results', 'advertisement.id', '=', 'customer_results.advertisement_id')
                ->where('customer_results.customer_id', $user->id)
                ->when($campaign_id, function ($query) use ($campaign_id) {
                    $query->where('customer_results.campaign_id', $campaign_id);
                })
                ->when($advertisement_id, function ($query, $advertisement_id) {
                    // Filter by advertisement_id if provided
                    $query->where('customer_results.advertisement_id', $advertisement_id);
                })
                ->when($store_id, function ($query) use ($store_id) {
                    $query->where('customer_results.store_id', $store_id);
                })
                ->distinct()
                ->pluck('advertisement.advertisement_name');

              // Fetch advertisements based on customer_results table
              if ($login_role_id == 1) {
                $user->stores = DB::table('users')
                    ->join('customer_results', 'users.id', '=', 'customer_results.store_id')
                    ->where('customer_results.customer_id', $user->id) // Assuming customer_id relates to the user ID
                    ->when($campaign_id, function ($query) use ($campaign_id) {
                        $query->where('customer_results.campaign_id', $campaign_id);
                    })
                    ->when($advertisement_id, function ($query, $advertisement_id) {
                        // Filter by advertisement_id if provided
                        $query->where('customer_results.advertisement_id', $advertisement_id);
                    })
                    ->when($store_id, function ($query) use ($store_id) {
                        $query->where('customer_results.store_id', $store_id);
                    })
                    ->distinct()
                    ->pluck('users.name');
            }
        }

        // Remove users without campaigns and advertisements but with stores
        $users = $users->reject(function ($user) {
            return !$user->campaigns->count() && !$user->advertisements->count() && !$user->stores->count();
        });
        
        return DataTables::of($users)
            ->editColumn('name', '<strong>{{$name}}</strong>')
            ->editColumn('email', '{{$email}}')
            ->editColumn('mobile', '{{$mobile}}')
            ->editColumn('store_name', function ($data) {
                $storesList = implode(', ', $data->stores->toArray());
                return '<div data-list="' . $storesList . '">' . $storesList . '</div>';
            })

            ->editColumn('campaign', function ($data) {
                $campaignList = implode(', ', $data->campaigns->toArray());
                return '<div data-list="' . $campaignList . '">' . $campaignList . '</div>';
            })
            
            ->editColumn('advertisement', function ($data) {
                $advertisementsList = implode(', ', $data->advertisements->toArray());
                return '<div data-list="' . $advertisementsList . '">' . $advertisementsList . '</div>';
            })
            ->editColumn('win_count', '{{$win_count}}')
            ->editColumn('lose_count', '{{$lose_count}}')
            ->editColumn('created_at', function ($data) {
                $diff = Carbon::now()->diffInHours($data->created_at);

                if ($diff < 25) {
                    return $data->created_at->diffForHumans();
                }

                return $data->created_at->isoFormat('llll');
            })
            ->editColumn('updated_at', function ($data) {
                $diff = Carbon::now()->diffInHours($data->updated_at);

                if ($diff < 25) {
                    return $data->updated_at->diffForHumans();
                }

                return $data->updated_at->isoFormat('llll');
            })
            ->rawColumns(['name', 'email', 'mobile', 'store_name', 'campaign', 'advertisement', 'win_count', 'lose_count', 'created_at'])
            ->make(true);
    }


    public function exportToExcel(Request $request)
    {
        $data = $request->input('filteredData');
        
       return Excel::download(new CustomerExport($data), 'customers.xlsx');

    }

    public function stats(Request $request)
    {
        if ($request->isMethod('post')) {
            // The request is a POST request
            // dd($request->all());
            if($request->year == null){
                $year = date('Y');
                $selectedYear = false;
            }else{
                $year = $request->year;
                $selectedYear = true; 
            }
            $store_id = $request->store;
        }else{
            $year = $request->input('year', date('Y')); 
            $store_id = null;
            $selectedYear = false;
        }
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_action = 'Stats';
 
         $rolesId = [5];
     
         $role_id=auth()->user()->roles->pluck('id')->toArray();
         $login_role_id = $role_id[0];
         $login_user_id = Auth::id();
 
 
         if($login_role_id == 1 ){
             $customers = User::selectRaw('MONTH(users.created_at) as month, COUNT(*) as count')
             ->join('customers', 'users.id', '=', 'customers.user_id')
             ->join('users as store_users', 'customers.store_id', '=', 'store_users.id')
             ->whereYear('users.created_at', $year)
             ->when($store_id, function ($query) use ($store_id) {
                $query->where('customers.store_id', $store_id);
            })
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
            ->whereYear('users.created_at', $year)
            ->when($store_id, function ($query) use ($store_id) {
                $query->where('customers.store_id', $store_id);
            })
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
            ->whereYear('users.created_at', $year)
            ->when($store_id, function ($query) use ($store_id) {
                $query->where('customers.store_id', $store_id);
            })
            ->whereHas('roles', function ($query) use ($rolesId) {
                $query->whereIn('roles.id', $rolesId);
            })
            ->groupByRaw('MONTH(users.created_at)')
            ->pluck('count', 'month')
            ->all();

            $visitors = Visitor::selectRaw('MONTH(visitors.created_at) as month, COUNT(DISTINCT user_id_cookie) as count')
            ->when($store_id, function ($query) use ($store_id) {
                $query->where('visitors.store_id', $store_id);
            })
            ->whereYear('visitors.created_at', $year)
            ->groupByRaw('MONTH(visitors.created_at)')
            ->pluck('count', 'month')
            ->all();

            $totalVisitors = Visitor::selectRaw('COUNT(DISTINCT user_id_cookie) as count')
            ->when($store_id, function ($query) use ($store_id) {
                $query->where('visitors.store_id', $store_id);
            });
            if ($request->isMethod('post')) {
                $totalVisitors->whereYear('visitors.created_at', $year);
            }
            $totalVisitors = $totalVisitors->value('count'); // Use value() to directly get the count


            $totalRegistered = User::selectRaw('COUNT(DISTINCT users.id) as count')
             ->join('customers', 'users.id', '=', 'customers.user_id')
                ->when($store_id, function ($query) use ($store_id) {
                    $query->where('customers.store_id', $store_id);
                });
            if ($request->isMethod('post')) {
                $totalRegistered->whereYear('users.created_at', $year);
            }
            $totalRegistered->whereHas('roles', function ($query) use ($rolesId) {
                $query->whereIn('roles.id', $rolesId);
            });
            $totalRegistered = $totalRegistered->value('count'); // Use value() to directly get the count

            
         }else{
    
            $customers = User::selectRaw('MONTH(users.created_at) as month, COUNT(*) as count')
            ->join('customers', 'users.id', '=', 'customers.user_id')
            ->join('users as store_users', 'customers.store_id', '=', 'store_users.id')
            ->where('customers.store_id', '=' , $login_user_id) // Replace $storeId with the desired store_id value
            ->whereYear('users.created_at', $year)
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
            ->whereYear('users.created_at', $year)
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
            ->whereYear('users.created_at', $year)
            ->whereHas('roles', function ($query) use ($rolesId) {
                $query->whereIn('roles.id', $rolesId);
            })
            ->groupByRaw('MONTH(users.created_at)')
            ->pluck('count', 'month')
            ->all();

            $visitors = Visitor::selectRaw('MONTH(visitors.created_at) as month, COUNT(DISTINCT user_id_cookie) as count')
            ->where('visitors.store_id', '=' , $login_user_id) // Replace $storeId with the desired store_id value
            ->whereYear('visitors.created_at', $year)
            ->groupByRaw('MONTH(visitors.created_at)')
            ->pluck('count', 'month')
            ->all();

            $totalVisitors = Visitor::selectRaw('COUNT(DISTINCT user_id_cookie) as count')
            ->where('visitors.store_id', '=' , $login_user_id);
            if ($request->isMethod('post')) {
                $totalVisitors->whereYear('visitors.created_at', $year);
            }
            $totalVisitors = $totalVisitors->value('count'); // Use value() to directly get the count
            

            $totalRegistered = User::selectRaw('COUNT(DISTINCT users.id) as count')
            ->join('customers', 'users.id', '=', 'customers.user_id')
            ->where('customers.store_id', '=' , $login_user_id);

            if ($request->isMethod('post')) {
                $totalRegistered->whereYear('users.created_at', $year);
            }
            $totalRegistered->whereHas('roles', function ($query) use ($rolesId) {
                $query->whereIn('roles.id', $rolesId);
            });
            $totalRegistered = $totalRegistered->value('count'); // Use value() to directly get the count
      
         }

         $stores = User::select('id','name')->whereNull('deleted_at')
         ->whereHas('roles', function ($query) use ($rolesId) {
             $query->where('id', 2);
         })
         ->get();

         $selected_year = $year;

         //dd($stores);

     // Define month labels
     $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
     
      // Initialize data arrays with zeros

      $totalVisiterData = array_fill(0, 12, 0);
      $totalRegisterUserData = array_fill(0, 12, 0);
    //  $totalUnregisteredUserData = array_fill(0, 12, 0);
      $winData = array_fill(0, 12, 0);
      $loseData = array_fill(0, 12, 0);
      
 
       // Now $totalCounts array contains the total count for each month

      foreach ($visitors as $month => $count) {
        $totalVisiterData[$month - 1] = $count;  // $month - 1 to convert 1-based month to 0-based index
      }
      foreach ($customers as $month => $count) {
          $totalRegisterUserData[$month - 1] = $count;  // $month - 1 to convert 1-based month to 0-based index
      }
      foreach ($winCustomers as $month => $count) {
          $winData[$month - 1] = $count;
      }
      foreach ($loseCustomers as $month => $count) {
          $loseData[$month - 1] = $count;
      }

    //   $totalUnregisteredUserData = [];
    //     for ($i = 0; $i < 12; $i++) {
    //         $totalUnregisteredUserData[$i] = ($totalVisiterData[$i] ?? 0) - ($totalRegisterUserData[$i] ?? 0);
    //     }

      // Create chart
      $chart = new Chart;
      $chart->labels($months);
      $chart->dataset('Total Visitors', 'bar', $totalVisiterData)
      ->backgroundColor('rgba(44, 255, 0, 1)');

        $chart->dataset('Total registered Customers', 'bar', $totalRegisterUserData)
            ->backgroundColor('rgba(0, 123, 255, 0.7)');

        // $chart->dataset('Total Not registered Customers', 'bar', $totalUnregisteredUserData)
        //     ->backgroundColor('rgba(255, 99, 132, 0.7)'); // Assuming you want a different color for unregistered customers

      $chart->dataset('Win Customers', 'bar', $winData)
            ->backgroundColor('rgba(40, 167, 69, 0.7)');
      $chart->dataset('Lose Customers', 'bar', $loseData)
            ->backgroundColor('rgba(220, 53, 69, 0.7)');

     return view("{$module_path}.{$module_name}.stats", compact('stores','store_id','selected_year','selectedYear','module_title',
      'module_name', 'module_path', 'module_action','module_icon', 'chart','totalVisitors','totalRegistered'));
    }

    public function claimed(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_action = 'Claimed';
        $claims = Claim::all();
        return view("{$module_path}.{$module_name}.claimed",compact('module_title', 'module_name', 'module_path', 'module_action','module_icon','claims'));
    
    }

    public function visitor()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_action = 'Visitors'; 

        $role_id = auth()->user()->roles->pluck('id')->toArray();
        $login_role_id = $role_id[0];
        $login_user_id = Auth::id();

        $role_id = auth()->user()->roles->pluck('id')->toArray();
        $login_role_id = $role_id[0];
        $login_user_id = Auth::id();

        // Fetch visitor data based on the login role
        if ($login_role_id == 1) {
            $totalViews = Visitor::where('view', 1)->count();
            $totalUnviews = Visitor::where('view', 0)->count();
            $distinctUserCount = Visitor::distinct('user_id_cookie')->count('user_id_cookie');
        } else {
            $totalViews = Visitor::where('view', 1)
                ->where('store_id', '=', $login_user_id)
                ->count();
            $totalUnviews = Visitor::where('view', 0)
                ->where('store_id', '=', $login_user_id)
                ->count();
            $distinctUserCount = Visitor::where('store_id', '=', $login_user_id)
                ->distinct('user_id_cookie')
                ->count('user_id_cookie');
        }

        return view("{$module_path}.{$module_name}.visitor",compact('module_title', 'module_name', 'module_path', 
        'module_action','module_icon','totalViews', 'totalUnviews', 'distinctUserCount'));
    }

    public function visitor_data(Request $request)
    {
        $role_id = auth()->user()->roles->pluck('id')->toArray();
        $login_role_id = $role_id[0];
        $login_user_id = Auth::id();

        // Fetch visitor data based on the login role
        if ($login_role_id == 1) {
            $visitorsData = Visitor::select('visitors.user_id_cookie', 'visitors.view', 'advertisement.advertisement_name')
                ->join('advertisement', 'visitors.advertisement_id', '=', 'advertisement.id')
                ->get();
        } else {
            $visitorsData = Visitor::select('visitors.user_id_cookie', 'visitors.view', 'advertisement.advertisement_name')
                ->join('advertisement', 'visitors.advertisement_id', '=', 'advertisement.id')
                ->where('visitors.store_id', '=', $login_user_id)
                ->get();
        }

        $organizedData = [];

        foreach ($visitorsData as $visitor) {
            $userID = $visitor['user_id_cookie'];
            $advertisementID = $visitor['advertisement_name'];
            $viewCount = $visitor['view'] == 1 ? 1 : 0;
            $unviewCount = $visitor['view'] == 0 ? 1 : 0;

            if (!isset($organizedData[$userID])) {
                $organizedData[$userID] = [
                    'advertisements' => [],
                    'count' => 0
                ];
            }

            if (!isset($organizedData[$userID]['advertisements'][$advertisementID])) {
                $organizedData[$userID]['advertisements'][$advertisementID] = [
                    'view' => 0,
                    'unview' => 0,
                ];
            }

            $organizedData[$userID]['advertisements'][$advertisementID]['view'] += $viewCount;
            $organizedData[$userID]['advertisements'][$advertisementID]['unview'] += $unviewCount;
        }

        // Flatten the organized data for DataTables
        $flattenedData = [];
        $count = 1; // Initialize count for users
        foreach ($organizedData as $userID => $data) {
            $details = '';
            foreach ($data['advertisements'] as $advertisementID => $views) {
                $detailParts = [];
                if ($views['view'] > 0) {
                    $detailParts[] = "View:{$views['view']}";
                }
                if ($views['unview'] > 0) {
                    $detailParts[] = "Unview:{$views['unview']}";
                }
                if (!empty($detailParts)) {
                    $details .= "<div class='advertisement'><span class='advertisement-name'>{$advertisementID}</span>: " . implode(', ', $detailParts) . "</div>";
                }
            }

            $flattenedData[] = [
                'user' => "User{$count}",
                'details' => $details
            ];
            $count++;
        }

        return Datatables::of($flattenedData)
            ->editColumn('user', function ($data) {
                return "<strong>{$data['user']}</strong>";
            })
            ->editColumn('details', function ($data) {
                return $data['details'];
            })
            ->rawColumns(['user', 'details'])
            ->make(true);
    }
    
    public function claimed_data()
    {
        $module_name = $this->module_name;
        $claims = Claim::select([
            'claims.id',
            'claims.customer_id', 
            'users.name as customer_name', 
            'claims.advertisement_id', 
            'advertisement.advertisement_name', 
            'claims.name', 
            'claims.address', 
            'claims.coupon_id',
            'coupons.title',
            'claims.request_claim', 
            'claims.is_claimed',
            'claims.email_sent', 
            'claims.shipping_status',
            'claims.updated_at', 
        ])
        ->join('users', 'claims.customer_id', '=', 'users.id')
        ->join('coupons', 'claims.coupon_id', '=', 'coupons.id')
        ->join('advertisement', 'claims.advertisement_id', '=', 'advertisement.id')
        ->get();

        return DataTables::of($claims)

            ->addColumn("change_shipping_status", function ($data) use ($module_name) {
                $claimId = $data->id;
                $route = route("backend.{$module_name}.update_claim", [
                    "claimId" => $claimId,
                ]);
                $content =
                    '<div class="d-flex justify-content-center">
                        <a href="' . $route . '" class="btn btn-primary">Update</a>
                    </div>';
                return new HtmlString($content);
            })
            ->editColumn('request_claim', function ($data) {
                return $data->request_claim ? 'Yes' : 'No';
            })
            ->editColumn('shipping_status', function ($data) {
                $status_text = [
                    0 => 'Pending',
                    1 => 'Packed',
                    2 => 'In transit',
                    3 => 'Shipped',
                    4 => 'Completed'
                ];
            
                return isset($status_text[$data->shipping_status]) ? $status_text[$data->shipping_status] : 'Unknown';
            })
            // ->editColumn('is_claimed', function ($data) {
            //     return $data->is_claimed ? 'Completed' : 'Pending';
            // })
            ->editColumn('email_sent', function ($data) {
                return $data->email_sent ? 'Sent to admin' : 'Not Sent';
            })
            ->editColumn('updated_at', function ($data) {
                $diff = Carbon::now()->diffInHours($data->updated_at);
                return $diff < 25 ? $data->updated_at->diffForHumans() : $data->updated_at->isoFormat('llll');
            })
            ->rawColumns(['customer_name','request_claim','change_shipping_status','created_at', 'updated_at'])
            ->make(true);
    }

    public function update_claim(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_action = 'Update Shipping Status - Claim'; 

        $claim = Claim::select([
            'claims.id',
            'claims.customer_id', 
            'users.name as customer_name', 
            'claims.advertisement_id', 
            'advertisement.advertisement_name', 
            'claims.name', 
            'claims.address', 
            'claims.coupon_id',
            'coupons.title',
            'claims.request_claim', 
            'claims.is_claimed',
            'claims.email_sent', 
            'claims.shipping_status',
            'claims.updated_at', 
        ])
        ->join('users', 'claims.customer_id', '=', 'users.id')
        ->join('coupons', 'claims.coupon_id', '=', 'coupons.id')
        ->join('advertisement', 'claims.advertisement_id', '=', 'advertisement.id')
        ->where('claims.id', $request->claimId)
        ->first(); // Using first() to retrieve a single claim
        
        if (!$claim) {
            return redirect()->route("backend.{$module_name}.claimed")->with('error', 'Claim not found.');
        }
    
        $shipping_status = $claim->shipping_status;
    
        return view("{$module_path}.{$module_name}.update_claim", compact('module_title', 'module_name', 'module_path', 
        'module_action', 'module_icon', 'shipping_status','claim'));

    }

    public function update_shipping_status(Request $request)
    {
        $request->validate([
            'status' => 'required|in:0,1,2,3,4', // Ensure the status is one of the valid values
        ]);
    
        $claim = Claim::find($request->claim_id);
    
        if (!$claim) {
            return redirect()->route("backend.{$this->module_name}.claimed")->with('error', 'Claim not found.');
        }
    
        // Update the shipping status
        $claim->shipping_status = $request->input('status');
        $claim->save();
    
        $customer = User::find($claim->customer_id);
        $statusText = [
            0 => 'Pending',
            1 => 'Packed',
            2 => 'In transit',
            3 => 'Shipped',
            4 => 'Completed',
        ];
    
        // Get the shipping status text
        $shippingStatusText = $statusText[$request->input('status')];
        $customer->notify(new ShippingStatusUpdated($shippingStatusText));

        Flash::success("<i class='fas fa-check'></i> Claim Updated Successfully")->important();

        return redirect()->route("backend.{$this->module_name}.claimed")->with('success', 'Shipping status updated successfully.');
    }
    
}

