<?php

namespace App\Http\Controllers\Backend\API;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\BranchGallery;
use App\Models\User;
use Illuminate\Http\Request;
use Modules\Service\Models\SystemService;
use App\Models\Setting;
use Modules\Service\Transformers\SystemServiceResource;
use Modules\Tax\Models\Tax;
use Modules\Constant\Models\Constant;
use Modules\Slider\Transformers\SliderResource;
use Modules\Tax\Transformers\TaxResource;
use Modules\Subscriptions\Models\Plan;
use Modules\Subscriptions\Transformers\PlanResource;
use Modules\Category\Transformers\CategoryResource;
use Modules\Category\Models\Category;
use Carbon\Carbon;
use App\Models\History;
use App\Http\Resources\HistoryResource;
use Modules\CustomTemplate\Models\CustomTemplate;
use Modules\CustomTemplate\Transformers\CustomTemplateResource;
use Modules\Subscriptions\Models\Subscription;
use App\Models\IPAddress;
use App\Trait\DashboardTrait;

use Auth;

class DashboardController extends Controller
{
    use DashboardTrait;

    public function dashboardDetail(Request $request)
    {

        $perPage = $request->input('per_page', 6);

        $user_id = $request->user_id;
        $user = User::find($user_id);

        $system_service = SystemService::where('status', 1)->with('categories')->paginate($perPage);

        $system_service = SystemServiceResource::collection($system_service);

        $category = Category::where('status', 1)->with('customTemplate')->get();

        $subscription_plan = Plan::where('status', 1)->with('planLimitation')->paginate($perPage);

        $subscription_plan = PlanResource::collection($subscription_plan);

        $category_list = CategoryResource::collection($category);

        $custom_template = CustomTemplate::where('status', 1)->get();

        $custom_template = CustomTemplateResource::collection($custom_template);
        $recent_history = null;
        $user_subscription_plan = null;
        if (!empty($request->user_id)) {
            $user = User::find($request->user_id);
            $recent_history = History::where('user_id', $user_id)->whereIn('id', function ($query) use ($user_id): void {$query->selectRaw('MAX(id)')->from('history')->where('user_id', $user_id)->groupBy('type');})->orderByDesc('id')->take(9)->get();

            $recent_history = HistoryResource::collection($recent_history);

            $user_subscription_plan = Subscription::where('user_id', $user_id)->where('status', config('constant.SUBSCRIPTION_STATUS.ACTIVE'))->first();
            if (!empty($user_subscription_plan->planlimits)) {
                $planlimits = is_string($user_subscription_plan->planlimits) ? json_decode($user_subscription_plan->planlimits) : $user_subscription_plan->planlimits;
                if (is_array($planlimits)) {
                    foreach ($planlimits as $planLimitation) {
                        $remainingCount = $this->checkRemaining($user, $planLimitation->type);

                        $planLimitation->remaining = $planLimitation->limit - $remainingCount;
                    }
                    $user_subscription_plan->planlimits = $planlimits;
                }
            }
        }
        
        
        $responseData = [
            'system_service' => $system_service,
            'subscription_plan' => $subscription_plan,
            // 'category_list'=>$category_list,
            'custom_template' => $custom_template,
            'recent_history' => $recent_history,
            'current_subscription' => $user_subscription_plan
        ];

        return response()->json([
            'status' => true,
            'data' => $responseData,
            'message' => __('messages.dashboard_detail'),
        ], 200);
    }

    public function CheckDailyLimits()
    {

        if (request()->headers->has('ipaddress')) {

            $ip_address = request()->header('ipaddress');
            $currentDate = Carbon::now()->toDateString();

            $ipAddresses_count = IPAddress::where('ip_address', $ip_address)
                ->whereDate('created_at', $currentDate)
                ->count();

            $daily_limit = Setting::where('type', 'daily_limit')->value('val');

            if ($ipAddresses_count >= $daily_limit) {

                return response()->json([
                    'status' => false,
                    'data' => $ipAddresses_count,
                    'message' => __('messages.daily_limit_over'),
                ], 200);
            } else {

                return response()->json([
                    'status' => true,
                    'data' => $ipAddresses_count,
                    'message' => __('messages.daily_limit', ['limit' => $daily_limit]),
                ], 200);
            }
        }
    }


    public function rechargeReminder(Request $request)
    {


        $type = $request->has('type') ? $request->input('type') : null;

        if ($type == null) {

            return response()->json([
                'status' => true,
                'message' => __('messages.type is required'),
            ], 200);
        }


        $setting = Setting::where('type', $type . '_mail_send')->first();

        if (isset($setting) && $setting['val'] == 1) {

            return response()->json([
                'status' => true,
                'message' => __('messages.notification_already_sent'),
            ], 200);
        }

        $data = [];
        $setting_data = [];
        $service_name = '';

        if ($type == 'cutout_pro') {

            $setting_data = [

                [
                    'name' => 'cutout_pro_mail_send',
                    'val' => 1,
                    'type' => 'cutout_pro_mail_send'
                ],
                [
                    'name' => 'cutout_pro_limit_over',
                    'val' => 1,
                    'type' => 'cutout_pro_limit_over',
                ],

            ];

            $service_name = 'cutout.pro';
        } else if ($type == 'open_ai') {



            $setting_data = [

                [
                    'name' => 'open_ai_mail_send',
                    'val' => 1,
                    'type' => 'open_ai_mail_send'
                ],
                [
                    'name' => 'open_ai_limit_over',
                    'val' => 1,
                    'type' => 'open_ai_limit_over',
                ],

            ];

            $service_name = 'openAI';
        } else if ($type == 'picsart') {


            $setting_data = [

                [
                    'name' => 'picsart_mail_send',
                    'val' => 1,
                    'type' => 'picsart_mail_send'
                ],
                [
                    'name' => 'picsart_limit_over',
                    'val' => 1,
                    'type' => 'picsart_limit_over',
                ],

            ];

            $service_name = 'Picsart';
        }

        $response = [

            'notification_type' => 'recharge_reminder',
            'notification_group' => 'recharge_reminder',
            'service_name' => $service_name,

        ];
        $type = 'recharge_reminder';
        $notify_message = 'Recharge Reminder: Maintain Connectivity.';
        $this->sendNotificationOnrechargeReminder($type, $notify_message, $response);

        foreach ($setting_data as $key => $value) {

            $service = [
                'name' => $value['name'],
                'val' => $value['val'],
                'type' => $value['type']
            ];

            Setting::updateOrCreate(['type' => $value['type']], $service);
        }

        return response()->json([
            'status' => true,
            'message' => __('messages.notification_sent'),
        ], 200);
    }



    public function CheckLimits(Request $request)
    {
        $user = $request->user_id ? User::find($request->user_id) : $request->user();


        if (!$user || !$user->subscriptionPackage || empty($user->subscriptionPackage->planlimits)) {
            if (!$user) {

                return response()->json([
                    'status' => false,
                    'message' => __('messages.user_not_found'),
                ], 404);
            }
            if (!$user->subscriptionPackage) {

                return response()->json([
                    'status' => false,
                    'message' => __('messages.subscription_not_found'),
                ], 404);
            }

            if (empty($user->subscriptionPackage->limits)) {

                return response()->json([
                    'status' => false,
                    'message' => __('messages.no_limitation'),
                ], 404);
            }
        }

        $category = $request->category;
        $system_service = $request->system_service;


        if ($category != null && $system_service != null) {

            return $this->checkBothLimit($user, $category, $system_service);
        } elseif ($category) {


            return $this->checkCategoryLimit($user, $category);
        } elseif ($system_service) {

            return $this->checkSystemServiceLimit($user, $system_service);
        }
    }

    protected function checkBothLimit($user, $category, $system_service)
    {

        $categoryData = Category::where('slug', $category)->first();

        if ($categoryData) {

            $customTemplateIds = CustomTemplate::where('category_id', $categoryData->id)->pluck('id');
            $totalUsedWord = History::where('user_id', $user->id)->whereIn('template_id', $customTemplateIds)->sum('word_count');
            $totalUsedwordCount = History::where('user_id', $user->id)->where('type', $system_service)->sum('word_count');

            foreach (json_decode($user->subscriptionPackage->planlimits) as $limit) {

                if (($limit->limit_type == 'category' && $limit->type == $category && $totalUsedWord >= $limit->limit) || ($limit->limit_type == 'system_service' && $limit->type == $system_service && $totalUsedwordCount >= $limit->limit)) {
                    return response()->json([
                        'status' => false,
                        'message' => __('messages.limit_over'),
                    ], 200);
                }
            }

            return response()->json([
                'message' => __('messages.limit_available'),
                'status' => true,
            ], 200);
        } else {

            return response()->json([
                'status' => false,
                'message' => __('messages.category_not_found'),
            ], 404);
        }
    }



    protected function checkCategoryLimit($user, $category)
    {
        $categoryData = Category::where('slug', $category)->first();

        if (!$categoryData) {
            return response()->json([
                'status' => false,
                'message' => __('messages.category_not_found'),
            ], 404);
        }

        $customTemplateIds = CustomTemplate::where('category_id', $categoryData->id)->pluck('id');

        $totalUsedWord = History::where('user_id', $user->id)->whereIn('template_id', $customTemplateIds)->sum('word_count');

        return $this->checkLimit($user, $totalUsedWord, 'category', $category);
    }

    protected function checkSystemServiceLimit($user, $system_service)
    {

        if ($system_service == 'ai_art_generator' || $system_service == 'ai_image') {

            $totalUsedCount = History::where('user_id', $user->id)->where('type', $system_service)->sum('image_count');
        } else {

            $totalUsedCount = History::where('user_id', $user->id)->where('type', $system_service)->sum('word_count');
        }

        return $this->checkLimit($user, $totalUsedCount, 'system_service', $system_service);
    }

    protected function checkLimit($user, $totalUsedCount, $limitType, $limitTypeValue)
    {
        foreach (json_decode($user->subscriptionPackage->planlimits) as $limit) {
            if ($limit->limit_type == $limitType && $limit->type == $limitTypeValue && $totalUsedCount >= $limit->limit) {
                return response()->json([
                    'status' => false,
                    'message' => __('messages.limit_over'),
                ], 200);
            }
        }

        return response()->json([
            'status' => true,
            'message' => __('messages.limit_available'),
        ], 200);
    }

    protected function checkRemaining($user, $system_service)
    {

        if ($system_service == 'ai_art_generator' || $system_service == 'ai_image') {

            $totalUsedCount = History::where('user_id', $user->id)->where('type', $system_service)->sum('image_count');
        } else {

            $totalUsedCount = History::where('user_id', $user->id)->where('type', $system_service)->sum('word_count');
        }

        return $totalUsedCount;
    }
    function firebaseDetails(Request $request)
    {
        $otherSetting = \App\Models\Setting::where('type', 'notification')->where('name', 'firebase_project_id')->first();

        $firebase_token = getAccessToken();

        $data = [
            'project_id' => $otherSetting->val ?? null,
            'firebase_token' => $firebase_token,
        ];

        $message = trans('messages.firebase_data');

        return response()->json(['status' => true, 'data' => $data, 'message' => $message]);
    }
}
