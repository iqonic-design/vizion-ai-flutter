<?php

namespace Modules\Subscriptions\Http\Controllers\Backend;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Modules\Plan\Models\Plan;
use Modules\Subscriptions\Models\Subscription;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Currency;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        // Page Title
        $this->module_title = 'Subscriptions';

        // module name
        $this->module_name = 'subscriptions';

        // module icon
        $this->module_icon = 'fa-solid fa-clipboard-list';

        view()->share([
            'module_title' => $this->module_title,
            'module_icon' => $this->module_icon,
            'module_name' => $this->module_name,
        ]);
    }

    public function bulk_action(Request $request)
    {
        $ids = explode(',', $request->rowIds);

        $actionType = $request->action_type;

        $message = __('messages.bulk_update');

        switch ($actionType) {
            case 'change-status':
                $branches = Subscription::whereIn('id', $ids)->update(['status' => $request->status]);
                $message = __('messages.bulk_plan_update');
                break;

            case 'delete':
                Subscription::whereIn('id', $ids)->delete();
                $message = __('messages.bulk_plan_delete');
                break;

            default:
                return response()->json(['status' => false, 'message' => __('branch.invalid_action')]);
                break;
        }

        return response()->json(['status' => true, 'message' => __('messages.bulk_update')]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index(Request $request)
    {
        $filter = $request->status;
        $module_action = 'User List';
        if ($filter) {
            $module_action = 'User List';
        }
        return view('subscriptions::backend.subscriptions.index', compact('module_action', 'filter'));
    }

    public function index_data(Datatables $datatable, Request $request)
    {
        $filterParts = explode("==", $request->filter);
        $filterValue = isset($filterParts[0]) ? $filterParts[0] : null;

        if ($filterValue == 'subscription_user') {
            $query = Subscription::query()->with('user')->where('identifier', '!=', 'free');
        } else {
            $query = Subscription::query()->with('user')->where('status', 'active');
        }

        $query->orderBy('updated_at', 'desc');

        // Now also include 'start_date' and 'end_date' in the query
        $datatable = $datatable->eloquent($query)
            ->addColumn('check', function ($row) {
                return '<input type="checkbox" class="form-check-input select-table-row" id="datatable-row-' . $row->id . '" name="datatable_ids[]" value="' . $row->id . '" onclick="dataTableRowCheck(' . $row->id . ')">';
            })
            ->editColumn('user_id', function ($row) {
                return view('subscriptions::backend.subscriptions.user_id', compact('row'));
            })
            ->editColumn('amount', function ($row) {
                return Currency::format($row->amount);
            })
            ->editColumn('plan_type', function ($row) {
                return $row->plan_type ? $row->plan_type : '-';
            })
            ->editColumn('plan', function ($row) {
                return $row->duration . ($row->type == 'Monthly' ? ' Month' : ($row->type == 'Yearly' ? ' Year' : ''));
            })
            ->editColumn('date', function ($row) {
                return \Carbon\Carbon::parse($row->start_date)->format('d-m-Y');
            })
            ->editColumn('end_date', function ($row) {
                return \Carbon\Carbon::parse($row->end_date)->format('d-m-Y');
            })
            ->editColumn('status', function ($row) {

                if ($row->type == 'Monthly') {
                    return '<span class="badge bg-success">Active</span>';
                } elseif ($row->type == 'Yearly') {
                    return '<span class="badge bg-warning">Cancel</span>';
                } else {
                    return '<span class="badge bg-danger">Inactive</span>';
                }
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
            ->editColumn('updated_at', function ($data) {
                $diff = Carbon::now()->diffInHours($data->updated_at);

                if ($diff < 25) {
                    return $data->updated_at->diffForHumans();
                } else {
                    return $data->updated_at->isoFormat('llll');
                }
            })
            ->orderColumns(['id'], '-:column $1');

        return $datatable->rawColumns(array_merge(['check', 'user_id', 'date', 'end_date', 'plan_type', 'plan', 'status']))
            ->toJson();
    }


}
