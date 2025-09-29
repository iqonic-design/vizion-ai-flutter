<?php

namespace Modules\Service\Http\Controllers\Backend;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Service\Models\SystemService;
use Yajra\DataTables\DataTables;

class SystemServiceController extends Controller
{
    
    public function __construct()
    {
        // Page Title
        $this->module_title = 'service.system_services';
        // module name
        $this->module_name = 'services';

        // module icon
        $this->module_icon = 'fa-solid fa-clipboard-list';

        view()->share([
            'module_title' => $this->module_title,
            'module_icon' => $this->module_icon,
            'module_name' => $this->module_name,
        ]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        
        $craete_title = 'service.system_services';
        $filter = [
            'status' => $request->status,
        ];
        $module_action = 'List';
      

        return view('service::backend.systemservice.index_datatable', compact('module_action', 'filter','craete_title'));
    }

    public function index_list(Request $request)
    {
       
        $query_data = SystemService::where('status',1 )->get();

        $data = [];

        foreach ($query_data as $row) {
            $data[] = [
                'id' => $row->type,
                'name' => $row->name,
            ];
        }
        return response()->json($data);
    }


    public function index_data(Datatables $datatable, Request $request)
    {
        
        $module_name = $this->module_name;
        $query = SystemService::query()->orderBy('status', 'desc');

        $datatable = $datatable->eloquent($query)
            ->addColumn('check', function ($data) {
                return '<input type="checkbox" class="form-check-input select-table-row"  id="datatable-row-'.$data->id.'"  name="datatable_ids[]" value="'.$data->id.'" onclick="dataTableRowCheck('.$data->id.')">';
            })
            ->addColumn('image', function ($data) {
                return '<img src='.$data->feature_image." class='avatar avatar-50 rounded-pill'>";
            })
            ->addColumn('action', function ($data) use ($module_name) {
                return view('service::backend.systemservice.action_column', compact('module_name', 'data'));
            })

            ->editColumn('description', function ($data){
                return '<span class="description">'.$data->description.'</span>';
            })
            ->editColumn('status', function ($row) {
                $checked = '';
                if ($row->status) {
                    $checked = 'checked="checked"';
                }

                return '
                    <div class="form-check form-switch ">
                        <input type="checkbox" data-url="'.route('backend.services.systemservice.update_status', $row->id).'" data-token="'.csrf_token().'" class="switch-status-change form-check-input"  id="datatable-row-'.$row->id.'"  name="status" value="'.$row->id.'" '.$checked.'>
                    </div>
                ';
            });

      
        return $datatable->rawColumns(array_merge(['action', 'image', 'status', 'check','description']))
            ->toJson();
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('service::create');
    }





    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('service::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $data = SystemService::findOrFail($id);

        if (!is_null($data)) {
            $custom_field_data = $data->withCustomFields();
            $data['custom_field_data'] = collect($custom_field_data->custom_fields_data)
                ->filter(function ($value) {
                    return $value !== null;
                })
                ->toArray();

            // Set feature_image and feature_image_name
            $data['feature_image'] = $data->feature_image;
            $data['feature_image_name'] = $data->feature_image ? basename($data->feature_image) : null;
        }

        return response()->json(['data' => $data, 'status' => true]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $data = SystemService::findOrFail($id);

        $request_data = $request->except('feature_image');

        $data->update($request_data);

        if ($request->custom_fields_data) {

            $data->updateCustomFieldData(json_decode($request->custom_fields_data));
        }

        storeMediaFile($data, $request->file('feature_image'), 'feature_image');

        $message = __('messages.update_form', ['form' => __('service.singular_title')]);

        return response()->json(['message' => $message, 'status' => true], 200);
    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    public function update_status(Request $request, SystemService $id)
    {
        $id->update(['status' => $request->status]);

        return response()->json(['status' => true, 'message' => __('service.status_update')]);
    }


    public function bulk_action(Request $request)
    {
        $ids = explode(',', $request->rowIds);

        $actionType = $request->action_type;

        $message = __('messages.bulk_update');

        switch ($actionType) {
            case 'change-status':
                $services = SystemService::whereIn('id', $ids)->update(['status' => $request->status]);
                $message = __('messages.bulk_service_update');
                break;

    
            default:
                return response()->json(['status' => false, 'message' => __('branch.invalid_action')]);
                break;
        }

        return response()->json(['status' => true, 'message' => __('messages.bulk_update')]);
    }
}
