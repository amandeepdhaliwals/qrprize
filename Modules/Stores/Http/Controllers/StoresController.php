<?php

namespace Modules\Stores\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Modules\Stores\Entities\Store; // Make sure to import your Store entity

class StoresController extends Controller
{
    public $module_title;

    public $module_name;

    public $module_path;

    public $module_icon;

    public $module_model;

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
     * @return Response
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

        $stores = $module_model::latest()->paginate();

        return view(
            "{$module_path}.index",
            compact('module_title', 'module_name', 'stores', 'module_icon', 'module_action', 'module_name_singular')
        );
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('stores::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('stores::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('stores::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
