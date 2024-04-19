<?php

namespace Modules\Advertisements\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Modules\Advertisements\Entities\Advertisement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AdvertisementsController extends BackendBaseController
{
    use Authorizable;

    public function __construct()
    {
       
        // Page Title
        $this->module_title = 'Advertisements';

        // module name
        $this->module_name = 'advertisements';

        // directory path of the module
        $this->module_path = 'advertisements::backend'; // or 'coupons::frontend' depending on where your views are located

        // module icon
        $this->module_icon = 'fa-regular fa-sun';

        // module model name, path
        $this->module_model = "Modules\Advertisements\Entities\Advertisement";
        
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

        $$module_name = $module_model::select('id', 'title', 'description','media','media_type','status','created_at','updated_at');

        $data = $$module_name;

        return Datatables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;

                return view('backend.includes.action_column', compact('module_name', 'data'));
            })
            ->editColumn('title', '<strong>{{$title}}</strong>')
            ->editColumn('description', '{{$description}}')
            ->editColumn('media', '@if($media_type == "Image")<img src="{{ Storage::url($media) }}" alt="media Image" class="img-fluid" style="max-width: 100px;">@elseif($media_type == "Video") <video width="150" height="140" controls>
            <source src="{{ Storage::url($media) }}" type="video/mp4">
          Your browser does not support the video tag.
      </video>@else <span> No Media </span> @endif')
            ->editColumn('media_type', '{{$media_type}}')
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
            ->rawColumns(['title','description','media','media_type','status','created_at','action'])
            ->orderColumns(['id'], '-:column $1')
            ->make(true);
    }


    /**
     * Store a new resource in the database.
     *
     * @param  Request  $request  The request object containing the data to be stored.
     * @return RedirectResponse The response object that redirects to the index page of the module.
     *
     * @throws Exception If there is an error during the creation of the resource.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Store';
   
        $file = $request->file('media');
        if ($file) {
            // Store the file in the storage directory
            $path = Storage::disk('public')->putFile('uploads/advertisements', $file, 'public');
           
        }
        $requestData = $request->all();
        if ($file) {
            $image_type = 'Image';
            $video_type = 'Video';

            $extension = $file->extension();

            $media_type = $extension === 'jpg' || $extension === 'jpeg' || $extension === 'png' || $extension === 'gif' ? $image_type : $video_type;
            $requestData['media'] = $path;
            $requestData['media_type'] = $media_type;
        }
        if($request->free_services){
            $requestData['free_services'] = implode(',', $request->free_services);
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

        $file = $request->file('media');
        if ($file) {
            // Store the file in the storage directory
            $path = Storage::disk('public')->putFile('uploads/advertisements', $file, 'public');
           
        }
        $requestData = $request->all();
        if ($file) {
            $image_type = 'Image';
            $video_type = 'Video';

            $extension = $file->extension();

            $media_type = $extension === 'jpg' || $extension === 'jpeg' || $extension === 'png' || $extension === 'gif' ? $image_type : $video_type;
            $requestData['media'] = $path;
            $requestData['media_type'] = $media_type;
        }
        $requestData['free_services'] = implode(',', $request->free_services);

        $$module_name_singular = $module_model::findOrFail($id);

        $$module_name_singular->update($requestData);

        flash(icon().' '.Str::singular($module_title)."' Updated Successfully")->success()->important();

        logUserAccess($module_title.' '.$module_action.' | Id: '.$$module_name_singular->id);

        return redirect()->route("backend.{$module_name}.show", $$module_name_singular->id);
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


}
