<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;
use Yajra\DataTables\DataTables;

class ReportController extends Controller
{

    public function __construct()
    {
        // Page Title
        $this->module_title = 'messages.report';

        // module name
        $this->module_name = 'reports';

        view()->share([
            'module_title' => $this->module_title,
            'module_icon' => 'fa-regular fa-sun',
            'module_name' => $this->module_name,
        ]);
    }


    public function index(Request $request)
    {

        $module_name = $this->module_name;
        $module_action = 'List';

        return view('backend.report.index_datatable', compact('module_name', 'module_action'));
    }


    public function index_data(Datatables $datatable, Request $request)
    {
        $module_name = $this->module_name;

        // Base query with the user relationship
        $query = Report::with('user')->orderBy('id', 'desc');

        $datatable = $datatable->eloquent($query)
            ->addColumn('check', function ($data) {
                return '<input type="checkbox" class="form-check-input select-table-row" id="datatable-row-' . $data->id . '" name="datatable_ids[]" value="' . $data->id . '" onclick="dataTableRowCheck(' . $data->id . ')">';
            })

            ->editColumn('user_id', function ($data) {
                return view('backend.report.user_id', compact('data'));
            })

            ->addColumn('action', function ($data) use ($module_name) {
                return view('backend.report.action_column', compact('module_name', 'data'));
            })


            ->filterColumn('user_id', function ($query, $keyword) {
                if (!empty($keyword)) {
                    $query->whereHas('user', function ($subQuery) use ($keyword) {
                        $subQuery->where('first_name', 'like', '%' . $keyword . '%')
                            ->orWhere('last_name', 'like', '%' . $keyword . '%')
                            ->orWhere('email', 'like', '%' . $keyword . '%');
                    });
                }
            })

            ->editColumn('description', function ($data) {
                return '<span class="description">' . $data->description . '</span>';
            });

        return $datatable->rawColumns(['action', 'check', 'description'])
            ->toJson();
    }



    public function  DeleteReport($id){

       Report::where('id', $id)->forceDelete();

        return response()->json(['message' => __('message.report_delete'), 'status' => true]);
    }


    public function bulk_action(Request $request)
    {
        $ids = explode(',', $request->rowIds);

        $actionType = $request->action_type;

        $message = __('messages.bulk_update');

        switch ($actionType) {
            case 'change-status':
                $branches = Report::whereIn('id', $ids)->update(['status' => $request->status]);
                $message = __('messages.bulk_plan_update');
                break;

            case 'delete':
                Report::whereIn('id', $ids)->delete();
                $message = __('messages.bulk_plan_delete');
                break;

            default:
                return response()->json(['status' => false, 'message' => __('branch.invalid_action')]);
                break;
        }

        return response()->json(['status' => true, 'message' => __('messages.bulk_update')]);
    }



}
