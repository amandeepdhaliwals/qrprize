<?php

namespace Modules\Otherprizes\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Modules\Otherprizes\Entities\Otherprize;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class OtherprizesController extends BackendBaseController
{

    public function __construct()
    {
       
        // Page Title
        $this->module_title = 'Otherprizes';

        // module name
        $this->module_name = 'otherprizes';

        // directory path of the module
        $this->module_path = 'otherprizes::backend'; // or 'coupons::frontend' depending on where your views are located

        // module icon
        $this->module_icon = 'fa-regular fa-sun';

        // module model name, path
        $this->module_model = "Modules\Otherprizes\Entities\Otherprize";
        
    }

    // public function index(){
    //     dd('sss');
    // }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
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

        $$module_name = $module_model::select('id', 'title', 'description','media','status','created_at','updated_at');

        $data = $$module_name;

        return Datatables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;

                return view('backend.includes.action_column', compact('module_name', 'data'));
            })
            ->editColumn('title', '<strong>{{$title}}</strong>')
            ->editColumn('description', '{{$description}}')
            ->editColumn('media', '<img src="{{ Storage::url($media) }}" alt="media Image" class="img-fluid" style="max-width: 100px;">')
            ->editColumn('status', '@if($status == 1) <span style="color:green;">Active</span> @else <span style="color:red;">Inactive</span> @endif')
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
            ->rawColumns(['title','description','media','status','created_at','action'])
            ->orderColumns(['id'], '-:column $1')
            ->make(true);
    }
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     return view('otherprizes::index');
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Create';




        logUserAccess($module_title.' '.$module_action);

        return view(
            "{$module_path}.{$module_name}.create",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_name_singular', 'module_action')
        );
    }

    public function edit($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Edit';

        $$module_name_singular = $module_model::findOrFail($id);


        logUserAccess($module_title.' '.$module_action.' | Id: '.$$module_name_singular->id);

        return view(
            "{$module_path}.{$module_name}.edit",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular', "{$module_name_singular}")
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       //  dd($request->all());
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Store';
        $requestData = $request->all();
   
            $file = $request->file('image_file');
            if ($file) {
                $request->validate([
                    'image_file' => 'required|file|max:20480', // Maximum file size in kilobytes (20 MB in this example)
                ]);
                // Store the file in the storage directory
                $path = Storage::disk('public')->putFile('uploads/advertisements', $file, 'public');
                $requestData['media'] = $path;
            
            }

      

       // dd($requestData);

        $$module_name_singular = $module_model::create($requestData);
       
        flash(icon()."New '".Str::singular($module_title)."' Added")->success()->important();

        logUserAccess($module_title.' '.$module_action.' | Id: '.$$module_name_singular->id);

        return redirect("admin/{$module_name}");
    }

    public function update(Request $request, $id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Update';

        $requestData = $request->all();
   
            $file = $request->file('image_file');
            if ($file) {
                $request->validate([
                    'image_file' => 'required|file|max:20480', // Maximum file size in kilobytes (20 MB in this example)
                ]);
                // Store the file in the storage directory
                $path = Storage::disk('public')->putFile('uploads/advertisements', $file, 'public');
                $requestData['media'] = $path;
            
            }
      

     //   dd($requestData);

        $$module_name_singular = $module_model::findOrFail($id);

        $$module_name_singular->update($requestData);

        flash(icon().' '.Str::singular($module_title)."' Updated Successfully")->success()->important();

        logUserAccess($module_title.' '.$module_action.' | Id: '.$$module_name_singular->id);

        return redirect()->route("backend.{$module_name}.show", $$module_name_singular->id);
    }


    /**
     * Show the specified resource.
     */

    public function show($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Show';

        //$$module_name_singular = $module_model::findOrFail($id);
        $$module_name_singular = $module_model::selectRaw('*, CASE WHEN status = 1 THEN "Active" ELSE "Inactive" END AS status')->findOrFail($id);

        logUserAccess($module_title.' '.$module_action.' | Id: '.$$module_name_singular->id);

        return view(
            "{$module_path}.{$module_name}.show",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_name_singular', 'module_action', "{$module_name_singular}")
        );
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
   

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy($id)
    // {
    //     //
    // }
}
