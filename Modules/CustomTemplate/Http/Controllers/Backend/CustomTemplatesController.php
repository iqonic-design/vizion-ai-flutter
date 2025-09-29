<?php

namespace Modules\CustomTemplate\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use Modules\CustomTemplate\Models\CustomTemplate;
use Modules\CustomField\Models\CustomField;
use Modules\CustomField\Models\CustomFieldGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use App\Models\User;
use Carbon\Carbon;

class CustomTemplatesController extends Controller
{
    // use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'customtemplate.singular_title';

        // module name
        $this->module_name = 'custom-templates';

        // directory path of the module
        $this->module_path = 'customtemplate::backend';

        view()->share([
          'module_title' => $this->module_title,
          'module_icon' => 'fa-regular fa-sun',
          'module_name' => $this->module_name,
          'module_path' => $this->module_path,
      ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $module_action = 'List';
        
        $columns = CustomFieldGroup::columnJsonValues(new User());
        $customefield = CustomField::exportCustomFields(new User());

        return view('customtemplate::backend.customtemplates.index_datatable',  compact('module_action','columns','customefield'));
    }

    /**
     * Select Options for Select 2 Request/ Response.
     *
     * @return Response
     */
    public function index_list(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return response()->json([]);
        }

        $query_data = CustomTemplate::where('name', 'LIKE', "%$term%")->orWhere('slug', 'LIKE', "%$term%")->limit(7)->get();

        $data = [];

        foreach ($query_data as $row) {
            $data[] = [
                'id' => $row->id,
                'text' => $row->name.' (Slug: '.$row->slug.')',
            ];
        }
        return response()->json($data);
    }

    public function index_data()
    {
        // $query = CustomTemplate::query()->with(['category']);
        $query = CustomTemplate::query()->with(['category'])->orderBy('updated_at', 'desc'); 


        return Datatables::of($query)

                        ->addColumn('check', function ($data) {
                            return '<input type="checkbox" class="form-check-input select-table-row"  id="datatable-row-'.$data->id.'"  name="datatable_ids[]" value="'.$data->id.'" onclick="dataTableRowCheck('.$data->id.')">';
                        })
                        ->addColumn('image', function ($data) {
                            return '<img src='.$data->feature_image." class='avatar avatar-50 rounded-pill'>";
                        })

                        ->addColumn('action', function ($data) {
                            return view('customtemplate::backend.customtemplates.action_column', compact('data'));
                        })
                        ->editColumn('status', function ($row) {
                            $checked = '';
                            if ($row->status) {
                                $checked = 'checked="checked"';
                            }

                            return '
                                <div class="form-check form-switch ">
                                    <input type="checkbox" data-url="'.route('backend.custom-templates.update_status', $row->id).'" data-token="'.csrf_token().'" class="switch-status-change form-check-input"  id="datatable-row-'.$row->id.'"  name="status" value="'.$row->id.'" '.$checked.'>
                                </div>
                            ';
                        })
                        ->editColumn('category_id', function ($data) {
                            $category = isset($data->category->name) ? $data->category->name : '-';

                            return $category;
                        })
                        ->editColumn('updated_at', function ($data) {
                            $module_name = $this->module_name;

                            $diff = Carbon::now()->diffInHours($data->updated_at);

                            if ($diff < 25) {
                                return $data->updated_at->diffForHumans();
                            } else {
                                return $data->updated_at->isoFormat('llll');
                            }
                        })
                        ->rawColumns(['action', 'image', 'status', 'check'])
                        ->orderColumns(['id'], '-:column $1')
                        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $module_action = 'Create';

        return view('customtemplate::backend.customtemplates.create', compact('module_action'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */


    public function store(Request $request)
    {
         $data = $request->except('feature_image');

          $query = CustomTemplate::create($data);

          storeMediaFile($query, $request->file('feature_image'));

         $message = __('messages.create_form', ['form' => __('customtemplate.singular_title')]);

        return response()->json(['message' => $message, 'status' => true], 200);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $module_action = 'Show';

        $data = CustomTemplate::findOrFail($id);

        return view('customtemplate::backend.customtemplates.show', compact('module_action', "$data"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $module_action = 'Edit';

        $data = CustomTemplate::findOrFail($id);

        $data['feature_image'] = $data->feature_image;

        $data['userinput_list']=json_decode($data->userinput_list);

        return response()->json(['data' => $data, 'status' => true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $data = CustomTemplate::findOrFail($id);

        $request_data = $request->except('feature_image');

        $data->update($request_data);

        storeMediaFile($data, $request->file('feature_image'), 'feature_image');

        $message = __('messages.update_form', ['form' => __('customtemplate.singular_title')]);

        return response()->json(['message' => $message, 'status' => true], 200);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $data = CustomTemplate::findOrFail($id);

        $data->delete();

        $message = __('customtemplate.customtemplate_delete');

       return response()->json(['message' => $message, 'status' => true], 200);

    }

    /**
     * List of trashed ertries
     * works if the softdelete is enabled.
     *
     * @return Response
     */
    public function trashed()
    {
        $module_name = $this->module_name;

        $module_name_singular = Str::singular($module_name);

        $module_action = 'Trash List';

        $data = CustomTemplate::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate();

        return view('customtemplate::backend.customtemplates.trash', compact("$data", 'module_name_singular', 'module_action'));
    }

    /**
     * Restore a soft deleted entry.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function restore($id)
    {
        $module_action = 'Restore';

        $data = CustomTemplate::withTrashed()->find($id);
        $data->restore();

        $message = Str::singular(CustomTemplates).'Data Restoreded Successfully !';

        return response()->json(['message' => $message, 'status' => true], 200);
    }

    public function bulk_action(Request $request)
    {
        $ids = explode(',', $request->rowIds);

        $actionType = $request->action_type;

        $message = __('messages.bulk_update');

        switch ($actionType) {
            case 'change-status':
                $services = CustomTemplate::whereIn('id', $ids)->update(['status' => $request->status]);
                $message = __('messages.bulk_service_update');
                break;

            case 'delete':

                if (env('IS_DEMO')) {
                    return response()->json(['message' => __('messages.permission_denied'), 'status' => false], 200);
                }

                CustomTemplate::whereIn('id', $ids)->delete();
                $message = __('messages.bulk_service_delete');
                break;

            default:
                return response()->json(['status' => false, 'message' => __('branch.invalid_action')]);
                break;
        }

        return response()->json(['status' => true, 'message' => __('messages.bulk_update')]);
    }


    public function update_status(Request $request, CustomTemplate $id)
    {
        $id->update(['status' => $request->status]);

        return response()->json(['status' => true, 'message' => __('customtemplate.status_update')]);
    }


}
