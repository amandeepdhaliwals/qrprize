<?php

namespace Modules\Stores\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

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

}
