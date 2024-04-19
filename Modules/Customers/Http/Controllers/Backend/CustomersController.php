<?php

namespace Modules\Customers\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

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

}

