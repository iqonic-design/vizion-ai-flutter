<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\History;
use App\Models\User;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Booking\Models\Booking;
use Modules\Booking\Models\BookingService;
use Modules\Booking\Models\BookingTransaction;
use Modules\Employee\Models\EmployeeRating;
use Modules\Product\Models\ProductCategory;
use Modules\Booking\Models\BookingGroomingMapping;
use Modules\Booking\Models\BookingVeterinaryMapping;
use DB;
use DateTimeZone;
use Currency;
use Modules\Subscriptions\Models\Subscription;
use Modules\Subscriptions\Models\SubscriptionTransactions;

class BackendController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users_count = User::where('status', 1)->count();
        $MonthsAgo = Carbon::now()->subMonths(1);

        $sixMonthsAgo = Carbon::now()->subMonths(6);


        $startOfLastMonth = now()->subMonth()->startOfMonth();
        $endOfLastMonth = now()->subMonth()->endOfMonth();

        //user count 

        $percentageActiveUsersLastMonth = round((User::whereBetween('created_at', [$startOfLastMonth->toDateString(), $endOfLastMonth->toDateString()])
            ->where('status', 1)
            ->count() / max(User::count(), 1)) * 100, 2);

        //word Count

        $total_word_count = History::sum('word_count');
        $total_word_count_last_months = History::whereBetween('created_at', [$startOfLastMonth->toDateString(), $endOfLastMonth->toDateString()])->sum('word_count');
        $percentageWordCountLastMonth = round((($total_word_count_last_months) / max($total_word_count, 1)) * 100, 2);

        //active subscription 

        $active_subscription = Subscription::where('status', 'active')->count();
    
        $percentageastMonthsubscription = round((Subscription::whereBetween('created_at', [$startOfLastMonth->toDateString(), $endOfLastMonth->toDateString()])->
            where('status', 'active')->where('identifier', 'premium')->count() / max($active_subscription, 1)) * 100, 2);

        // Total image Count

        $total_image_count = History::sum('image_count');
        $total_image_count_last_months = History::whereBetween('created_at', [$startOfLastMonth->toDateString(), $endOfLastMonth->toDateString()])->sum('image_count');
        $percentageImageCountLastMonth = round(($total_image_count_last_months / max($total_image_count, 1)) * 100);


        // total usese of AI Writer

        $total_ai_writer = History::where('type', 'ai_writer')->count();
        $total_ai_writer_last_months = History::whereBetween('created_at', [$startOfLastMonth->toDateString(), $endOfLastMonth->toDateString()])->where('type', 'ai_writer')->count();
        $percentageAIwriterLastMonth = round((($total_ai_writer_last_months) / max($total_ai_writer, 1)) * 100, 2);


        // total usese of AI Art

        $total_ai_art = History::where('type', 'ai_art_generator')->count();
        $total_ai_art_last_months = History::whereBetween('created_at', [$startOfLastMonth->toDateString(), $endOfLastMonth->toDateString()])->where('type', 'ai_art_generator')->count();
        $percentageAIartLastMonth = round((($total_ai_art_last_months) / max($total_ai_art, 1)) * 100, 2);

        // total usese of AI code

        $total_ai_code = History::where('type', 'ai_code')->count();
        $total_ai_code_last_months = History::whereBetween('created_at', [$startOfLastMonth->toDateString(), $endOfLastMonth->toDateString()])->where('type', 'ai_code')->count();
        $percentageAIcodeLastMonth = round((($total_ai_code_last_months) / max($total_ai_code, 1)) * 100, 2);


        // total uses of AI Image


        $total_ai_image = History::where('type', 'ai_image')->count();
        $total_ai_image_last_months = History::whereBetween('created_at', [$startOfLastMonth->toDateString(), $endOfLastMonth->toDateString()])->where('type', 'ai_image')->count();
        $percentageAIimageLastMonth = round((($total_ai_image_last_months) / max($total_ai_image, 1)) * 100, 2);


        // total uses of AI chat

        $total_ai_chat = History::where('type', 'ai_chat')->count();
        $total_ai_chat_last_months = History::whereBetween('created_at', [$startOfLastMonth->toDateString(), $endOfLastMonth->toDateString()])->where('type', 'ai_chat')->count();
        $percentageAIchatLastMonth = round((($total_ai_chat_last_months) / max($total_ai_chat, 1)) * 100, 2);


        // Calculate the total revenue and percentage change for the last 6 months
        $total_revenue = (float) Subscription::sum('amount');
        $total_revenue_last_months = Subscription::whereBetween('created_at', [$startOfLastMonth->toDateString(), $endOfLastMonth->toDateString()])->sum('amount');
        $percentage_change_total_revenue = round(($total_revenue_last_months / max($total_revenue, 1)) * 100, 2);


        // Calculate the total word count and percentage change for the last 6 months

        // Get transaction history
        // $transaction_history = SubscriptionTransactions::with('subscription')->take(5)->get();
        
        $transaction_history = SubscriptionTransactions::with('subscription')
            ->orderBy('created_at', 'desc') 
            ->take(5) 
            ->get();


        // Calculate the number of new users in the last 7 days
        $new_users_count = User::where('status', 1)->whereDate('created_at', '>=', now()->subDays(7))->count();
        $activeUsers = User::where('is_subscribe', 1)->count();
        // $totalUsers = User::where('status', 1)->count();
        $totalUsers = User::where('status', 1)->where('user_type', 'user')->count();






        $weeksInLastMonth = ceil($startOfLastMonth->copy()->endOfMonth()->day / 7);

        $last_month_user_graph_data = [];
        $last_month_word_count_graph_data = [];
        $last_month_subscription_graph_data = [];
        $last_month_image_count_graph_data = [];
        $last_month_ai_writer_graph_data = [];
        $last_month_ai_art_graph_data = [];
        $last_month_ai_code_graph_data = [];
        $last_month_ai_image_graph_data = [];
        $last_month_ai_chat_graph_data = [];
        $last_month_revenue_graph_data = [];

        for ($week = 1; $week <= $weeksInLastMonth; $week++) {

            $startDate = $startOfLastMonth->copy()->addWeeks($week - 1)->startOfWeek();
            $endDate = $startOfLastMonth->copy()->addWeeks($week - 1)->endOfWeek();

            $activeUsers = User::where('created_at', '>=', $startDate)
                ->where('created_at', '<=', $endDate)
                ->where('status', '=', 1)
                ->count();

            $wordCount = History::where('created_at', '>=', $startDate)
                ->where('created_at', '<=', $endDate)
                ->sum('word_count');

            $active_subcription = Subscription::where('created_at', '>=', $startDate)
                ->where('created_at', '<=', $endDate)
                ->where('status', 'active')
                ->where('identifier', 'premium')
                ->count();

            $imageCount = History::where('created_at', '>=', $startDate)
                ->where('created_at', '<=', $endDate)
                ->sum('image_count');

            $use_ai_writer = History::where('created_at', '>=', $startDate)
                ->where('created_at', '<=', $endDate)
                ->where('type', 'ai_writer')
                ->count();

            $use_ai_code = History::where('created_at', '>=', $startDate)
                ->where('created_at', '<=', $endDate)
                ->where('type', 'ai_code')
                ->count();

            $use_ai_art = History::where('created_at', '>=', $startDate)
                ->where('created_at', '<=', $endDate)
                ->where('type', 'ai_art_generator')
                ->count();

            $use_ai_image = History::where('created_at', '>=', $startDate)
                ->where('created_at', '<=', $endDate)
                ->where('type', 'ai_image')
                ->count();
            $use_ai_chat = History::where('created_at', '>=', $startDate)
                ->where('created_at', '<=', $endDate)
                ->where('type', 'ai_chat')
                ->count();

            $revenue_chart = Subscription::where('created_at', '>=', $startDate)
                ->where('created_at', '<=', $endDate)
                ->sum('amount');

            $last_month_user_graph_data[] = $activeUsers;
            $last_month_word_count_graph_data[] = $wordCount;
            $last_month_subscription_graph_data[] = $active_subcription;
            $last_month_image_count_graph_data[] = $imageCount;
            $last_month_ai_writer_graph_data[] = $use_ai_writer;
            $last_month_ai_art_graph_data[] = $use_ai_art;
            $last_month_ai_code_graph_data[] = $use_ai_code;
            $last_month_ai_image_graph_data[] = $use_ai_image;
            $last_month_ai_chat_graph_data[] = $use_ai_chat;
            $last_month_revenue_graph_data[] = $revenue_chart;

        }


        $data = [
            'totalUsersCount' => $totalUsers,
            'percentageUsers' => $percentageActiveUsersLastMonth,
            'last_month_user_graph_data' => $last_month_user_graph_data,

            'totalWordCount' => formatCount($total_word_count),
            'percentageWordCountLastMonth' => $percentageWordCountLastMonth,
            'last_month_word_count_graph_data' => $last_month_word_count_graph_data,

            'activeSubscriptionCount' => formatCount($active_subscription),
            'lastMothsubsctiption' => $percentageastMonthsubscription,
            'last_month_subscription_graph_data' => $last_month_subscription_graph_data,

            'totalImageCount' => formatCount($total_image_count),
            'percentageImageCountLastMonth' => $percentageImageCountLastMonth,
            'last_month_image_count_graph_data' => $last_month_image_count_graph_data,

            'totalAIwriter' => formatCount($total_ai_writer),
            'percentageAIwriterLastMonth' => $percentageAIwriterLastMonth,
            'last_month_ai_writer_graph_data' => $last_month_ai_writer_graph_data,

            'totalAIart' => formatCount($total_ai_art),
            'percentageAIartLastMonth' => $percentageAIartLastMonth,
            'last_month_ai_art_graph_data' => $last_month_ai_art_graph_data,

            'totalAIcode' => formatCount($total_ai_code),
            'percentageAIcodeLastMonth' => $percentageAIcodeLastMonth,
            'last_month_ai_code_graph_data' => $last_month_ai_code_graph_data,

            'totalAIimage' => formatCount($total_ai_image),
            'percentageAIimageLastMonth' => $percentageAIimageLastMonth,
            'last_month_ai_image_graph_data' => $last_month_ai_image_graph_data,

            'totalAIchat' => formatCount($total_ai_chat),
            'percentageAIchatLastMonth' => $percentageAIchatLastMonth,
            'last_month_ai_chat_graph_data' => $last_month_ai_chat_graph_data,

            'totalRevenue' => $total_revenue,
            'percentagerevenueLastMonth' => $percentage_change_total_revenue,
            'last_month_revenue_graph_data' => $last_month_revenue_graph_data,

            'transactionHistory' => $transaction_history ,

            'newUsers' => $new_users_count,
            'activeUsers' => $users_count,
            'chart_activeUsers' => $activeUsers,
            'chart_newUsers' => $totalUsers,
            'cutout_pro_limit_over' => Setting::where('type', 'cutout_pro_limit_over')->value('val') ?? 0,
            'open_ai_limit_over' => Setting::where('type', 'open_ai_limit_over')->value('val') ?? 0,
            'picsart_limit_over' => Setting::where('type', 'picsart_limit_over')->value('val') ?? 0,
        ];
        



        return view('backend.index', compact('data'));
    }

    public function UpgaradeAccount(Request $request)
    {

        $type = $request->has('type') ? $request->input('type') : null;

        if ($type == null) {

            return response()->json([
                'status' => false,
                'message' => __('messages.type_is_required'),
            ], 200);


        }

        $setting = Setting::where('type', $type . '_mail_send')->first();

        if (isset($setting) && $setting['val'] == 1) {

            $setting->update(['val' => 0]);

        }

        $settingdata = Setting::where('type', $type . '_limit_over')->first();

        if (isset($settingdata) && $settingdata['val'] == 1) {

            $settingdata->update(['val' => 0]);

        }


        return response()->json([
            'status' => true,
            'message' => __('messages.data_updated'),
        ], 200);

    }


    public function setUserSetting(Request $request)
    {
        auth()->user()->update(['user_setting' => $request->settings]);

        return response()->json(['status' => true]);
    }

    public function getUserschart(Request $request, $type)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $date_range_string = $startDate . ' to ' . $endDate;

        $chartData = ['active_user' => [], 'all_user' => []];
        $category = [];

        $total_activeUsers_count = 0;
        $total_Users_count = 0;

        $request->session()->put('date_range', '');

        if ($type == 'year') {

            for ($month = 1; $month <= 12; $month++) {
                $activeUsers = User::whereYear('created_at', '=', Carbon::now()->year)
                    ->whereMonth('created_at', '=', $month)
                    ->where('is_subscribe', '=', 1)
                    ->count();

                $allUsers = User::whereYear('created_at', '=', Carbon::now()->year)
                    ->whereMonth('created_at', '=', $month)
                    ->where('user_type','user')
                    ->count();

                $chartData['active_user'][] = $activeUsers;
                $chartData['all_user'][] = $allUsers;

                $category[] = date('M', mktime(0, 0, 0, $month, 1)); // Month name abbreviation (e.g., Jan)
            }

            $total_activeUsers_count = User::whereYear('created_at', '=', Carbon::now()->year)
                ->where('is_subscribe', '=', 1)
                ->where('user_type','user')
                ->count();

            $total_Users_count = User::whereYear('created_at', '=', Carbon::now()->year)
            ->where('user_type','user')
                ->count();





        } elseif ($type == 'month') {

            $firstDayOfMonth = Carbon::now()->startOfMonth();
            $lastDayOfMonth = Carbon::now()->endOfMonth();

            $weeksInMonth = ceil($firstDayOfMonth->copy()->endOfMonth()->day / 7);

            for ($week = 1; $week <= $weeksInMonth; $week++) {
                $startDate = $firstDayOfMonth->copy()->addWeeks($week - 1)->startOfWeek();
                $endDate = $firstDayOfMonth->copy()->addWeeks($week - 1)->endOfWeek();


                $activeUsers = User::where('created_at', '>=', $startDate)
                    ->where('created_at', '<=', $endDate)
                    ->where('is_subscribe', '=', 1)
                    ->where('user_type','user')
                    ->count();

                $allUsers = User::where('created_at', '>=', $startDate)
                    ->where('created_at', '<=', $endDate)
                    ->where('user_type','user')
                    ->count();

                $chartData['active_user'][] = $activeUsers;
                $chartData['all_user'][] = $allUsers;

                $category[] = 'Week ' . $week;
            }


            $total_activeUsers_count = User::whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])
                ->where('is_subscribe', '=', 1)
                ->where('user_type','user')
                ->count();

            $total_Users_count = User::whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])
            ->where('user_type','user')
                ->count();


        } elseif ($type == 'week') {

            $weekStart = Carbon::now()->startOfWeek();
            $weekEnd = Carbon::now()->endOfWeek();

            $weekStartdate = Carbon::now()->startOfWeek()->toDateString();
            $weekEnddate = Carbon::now()->endOfWeek()->toDateString();

            while ($weekStart->lte($weekEnd)) {
                $activeUsers = User::whereDate('created_at', '=', $weekStart->toDateString())
                    ->where('is_subscribe', '=', 1)
                    ->where('user_type','user')
                    ->count();

                $allUsers = User::whereDate('created_at', '=', $weekStart->toDateString())
                ->where('user_type','user')
                    ->count();

                $chartData['active_user'][] = $activeUsers;
                $chartData['all_user'][] = $allUsers;
                $category[] = $weekStart->format('l'); // Day of the week (e.g., Monday)
                $weekStart->addDay();
            }

            $total_activeUsers_count = User::whereBetween('created_at', [$weekStartdate, $weekEnddate])
                ->where('is_subscribe', '=', 1)
                ->where('user_type','user')
                ->count();


            $total_Users_count = User::where('created_at', '>=', $weekStartdate)
                ->where('created_at', '<=', $weekEnddate)
                ->where('user_type','user')
                ->count();

        } else {

            $request->session()->put('date_range', $date_range_string);

            $currentDate = $startDate;
            while (strtotime($currentDate) <= strtotime($endDate)) {
                $activeUsers = User::whereDate('created_at', '=', $currentDate)
                    ->where('is_subscribe', '=', 1)
                    ->where('user_type','user')
                    ->count();

                $newUsers = User::whereDate('created_at', '=', $currentDate)
                ->where('user_type','user')
                    ->count();

                $chartData['active_user'][] = $activeUsers;
                $chartData['all_user'][] = $newUsers;
                $category[] = '';

                $currentDate = date('Y-m-d', strtotime("+1 day", strtotime($currentDate)));
            }

            $total_activeUsers_count = User::whereBetween('created_at', [$startDate, $endDate])
                ->where('is_subscribe', '=', 1)
                ->where('user_type','user')
                ->count();


            $total_Users_count = User::where('created_at', '>=', $startDate)
                ->where('created_at', '<=', $endDate)
                ->where('user_type','user')
                ->count();
        }


        $data = [

            'chartData' => $chartData,
            'category' => $category,
            'chart_activeUsers' => $total_activeUsers_count,
            'chart_allUsers' => $total_Users_count,

        ];
        // dd($data['chart_activeUsers']);

        return response()->json(['data' => $data, 'status' => true]);
    }

    public function getPopularContentChart(Request $request, $type)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $date_range_string = $startDate . ' to ' . $endDate;

        $chartData = [];
        $category = [];
        $service_count = 0;

        $services = DB::table('history')->distinct()->pluck('type');
        $request->session()->put('content_date_range', '');

        if ($type == 'year') {

            for ($month = 1; $month <= 12; $month++) {

                $category[] = date('M', mktime(0, 0, 0, $month, 1));

            }

            foreach ($services as $service) {
                $formattedData = []; // Initialize formattedData array for each service

                for ($month = 1; $month <= 12; $month++) {
                    $startDate = Carbon::now()->startOfMonth()->month($month);
                    $endDate = Carbon::now()->endOfMonth()->month($month);

                    $data = DB::table('history')
                        ->where('type', $service)
                        ->whereBetween('created_at', [$startDate, $endDate])
                        ->count();

                    $monthName = date('M', mktime(0, 0, 0, $month, 1));
                    $formattedData[] = ['x' => $monthName, 'y' => [0, $data]];

                    $service_count += $data;
                }

                $chartData[] = ['name' => ucwords(str_replace('_', ' ', $service)), 'data' => $formattedData];

            }
        } elseif ($type == 'month') {

            $firstDayOfMonth = Carbon::now()->startOfMonth();
            $lastDayOfMonth = Carbon::now()->endOfMonth();

            $weeksInMonth = ceil($firstDayOfMonth->copy()->endOfMonth()->day / 7);

            for ($week = 1; $week <= $weeksInMonth; $week++) {
                $category[] = 'Week ' . $week;
            }

            foreach ($services as $service) {
                $formattedData = [];

                for ($week = 1; $week <= $weeksInMonth; $week++) {
                    $startDate = $firstDayOfMonth->copy()->addWeeks($week - 1)->startOfWeek();
                    $endDate = $firstDayOfMonth->copy()->addWeeks($week - 1)->endOfWeek();

                    $data = DB::table('history')
                        ->where('created_at', '>=', $startDate)
                        ->where('created_at', '<=', $endDate)
                        ->where('type', $service)
                        ->count();

                    $weekname = 'Week ' . $week;
                    $formattedData[] = ['x' => $weekname, 'y' => [0, $data]];

                    $service_count += $data;
                }


                $chartData[] = ['name' => ucwords(str_replace('_', ' ', $service)), 'data' => $formattedData];
            }

        } else if ($type == 'week') {

            $weekStart = Carbon::now()->startOfWeek();
            $weekEnd = Carbon::now()->endOfWeek();

            $weekStartdate = Carbon::now()->startOfWeek()->toDateString();

            while ($weekStart->lte($weekEnd)) {
                $category[] = $weekStart->format('l');
                $weekStart->addDay();
            }

            foreach ($services as $service) {
                $weekStart = Carbon::now()->startOfWeek();
                $formattedData = [];

                while ($weekStart->lte($weekEnd)) {
                    $data = DB::table('history')
                        ->whereDate('created_at', '=', $weekStart->toDateString())
                        ->where('type', $service)
                        ->count();

                    $dayname = $weekStart->format('l');
                    $formattedData[] = ['x' => $dayname, 'y' => [0, $data]];

                    $weekStart->addDay();
                    $service_count += $data;
                }



                $chartData[] = ['name' => ucwords(str_replace('_', ' ', $service)), 'data' => $formattedData];
            }

        } else if ($type == 'free') {

            $currentDate = $startDate;

            $request->session()->put('content_date_range', $date_range_string);

            while (strtotime($currentDate) <= strtotime($endDate)) {
                $category[] = '';
                $currentDate = date('Y-m-d', strtotime("+1 day", strtotime($currentDate)));
            }

            foreach ($services as $service) {
                $formattedData = [];

                $currentDate = $startDate;

                while (strtotime($currentDate) <= strtotime($endDate)) {
                    $data = DB::table('history')
                        ->whereDate('created_at', '=', $currentDate)
                        ->where('type', $service)
                        ->count();

                    $formattedData[] = ['x' => $currentDate, 'y' => [0, $data]];
                    $currentDate = date('Y-m-d', strtotime("+1 day", strtotime($currentDate)));
                    $service_count += $data;
                }

                $chartData[] = ['name' => ucwords(str_replace('_', ' ', $service)), 'data' => $formattedData];
            }

        }

        return response()->json(['chartData' => $chartData, 'category' => $category, 'service_count' => $service_count, 'status' => true]);
    }

    public function getRevenuechartData(Request $request, $type)
    {

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');


        $date_range_string = $startDate . ' to ' . $endDate;

        $chartData = [];


        $request->session()->put('revenue_date_range', '');

        if ($type == 'year') {

            $monthlyTotals = DB::table('subscriptions')
                ->select(DB::raw('YEAR(start_date) as year, MONTH(start_date) as month, SUM(amount) as amount'))
                ->where('status', 'active')
                ->groupBy(DB::raw('YEAR(start_date), MONTH(start_date)'))
                ->orderBy(DB::raw('YEAR(start_date), MONTH(start_date)'))
                ->get();

            for ($month = 1; $month <= 12; $month++) {
                $found = false;
                foreach ($monthlyTotals as $total) {
                    if ((int) $total->month === $month) {
                        $chartData[] = (float) $total->amount;
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $chartData[] = 0;
                }
            }
            ;

            $category = [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
                "Dec"
            ];
        } else if ($type == 'month') {
            $currentMonth = Carbon::now()->month; // Get the current month
            $currentYear = Carbon::now()->year; // Get the current year

            $firstWeek = Carbon::now()->startOfMonth()->week;

            $monthlyWeekTotals = DB::table('subscriptions')
                ->select(DB::raw('YEAR(start_date) as year, MONTH(start_date) as month, WEEK(start_date) as week, COALESCE(SUM(amount), 0) as amount'))
                ->where('status', 'active')
                ->where(DB::raw('YEAR(start_date)'), '=', $currentYear)
                ->where(DB::raw('MONTH(start_date)'), '=', $currentMonth)
                ->groupBy(DB::raw('YEAR(start_date), MONTH(start_date), WEEK(start_date)'))
                ->orderBy(DB::raw('YEAR(start_date), MONTH(start_date), WEEK(start_date)'))
                ->get();


            for ($i = $firstWeek; $i <= $firstWeek + 4; $i++) {
                $found = false;

                foreach ($monthlyWeekTotals as $total) {

                    if ((int) $total->month === $currentMonth && (int) $total->week === $i) {
                        $chartData[] = (float) $total->amount;
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $chartData[] = 0;
                }
            }
            $category = ["Week 1", "Week 2", "Week 3", "Week 4", 'Week 5'];
        } else if ($type == 'week') {

            $currentMonth = Carbon::now()->month;

            $currentWeekStartDate = Carbon::now()->startOfWeek();
            $lastDayOfWeek = Carbon::now()->endOfWeek();

            $weeklyDayTotals = DB::table('subscriptions')
                ->select(DB::raw('DAY(start_date) as day, COALESCE(SUM(amount), 0) as amount'))
                ->where('status', 'active')
                ->where(DB::raw('YEAR(start_date)'), '=', Carbon::now()->year)
                ->where(DB::raw('MONTH(start_date)'), '=', $currentMonth)
                ->whereBetween('start_date', [$currentWeekStartDate, $currentWeekStartDate->copy()->addDays(6)])
                ->groupBy(DB::raw('DAY(start_date)'))
                ->orderBy(DB::raw('DAY(start_date)'))
                ->get();

            for ($day = $currentWeekStartDate; $day <= $lastDayOfWeek; $day->addDay()) {
                $found = false;

                foreach ($weeklyDayTotals as $total) {
                    if ((int) $total->day === $day->day) {
                        $chartData[] = (float) $total->amount;
                        $found = true;
                        break;
                    }
                }

                if (!$found) {
                    $chartData[] = 0;
                }
            }
            ;

            $category = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        } else {

            $request->session()->put('revenue_date_range', $date_range_string);

            $currentDate = $startDate;
            while (strtotime($currentDate) <= strtotime($endDate)) {
                $revenue_data = DB::table('subscriptions')
                    ->whereDate('created_at', '=', $currentDate)
                    ->where('status', 'active')
                    ->sum('amount');

                $chartData[] = (float) $revenue_data;

                $category[] = '';

                $currentDate = date('Y-m-d', strtotime("+1 day", strtotime($currentDate)));
            }

        }
        $data = [

            'chartData' => $chartData,
            'category' => $category

        ];

        return response()->json(['data' => $data, 'status' => true]);
    }

    public function getSubscriptionchart(Request $request, $type)
    {
        $currentMonth = Carbon::now()->month;
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $date_range_string = $startDate . ' to ' . $endDate;

        $request->session()->put('subscription_range', '');

        $sumFreeUsers = 0;
        $sumPaidUsers = 0;

        $chartData['free'] = [];
        $chartData['paid'] = [];


        if ($type == 'year') {

            for ($month = 1; $month <= 12; $month++) {
                $freeUsers = DB::table('subscriptions')
                    ->whereYear('created_at', '=', Carbon::now()->year)
                    ->whereMonth('created_at', '=', $month)
                    ->where('status', 'active')
                    ->where('identifier', 'free')
                    ->count();

                $premiumUsers = DB::table('subscriptions')
                    ->whereYear('created_at', '=', Carbon::now()->year)
                    ->whereMonth('created_at', '=', $month)
                    ->where('status', 'active')
                    ->where('identifier', 'premium')
                    ->count();


                $chartData['free'][] = $freeUsers;
                $chartData['paid'][] = $premiumUsers;

                $category[] = date('M', mktime(0, 0, 0, $month, 1)); // Month name abbreviation (e.g., Jan)
            }

        } else if ($type == 'month') {

            $firstDayOfMonth = Carbon::now()->startOfMonth();
            $lastDayOfMonth = Carbon::now()->endOfMonth();

            $weeksInMonth = ceil($firstDayOfMonth->copy()->endOfMonth()->day / 7);

            for ($week = 1; $week <= $weeksInMonth; $week++) {
                $startDate = $firstDayOfMonth->copy()->addWeeks($week - 1)->startOfWeek();
                $endDate = $firstDayOfMonth->copy()->addWeeks($week - 1)->endOfWeek();

                $freeUsers = DB::table('subscriptions')
                    ->where('created_at', '>=', $startDate)
                    ->where('created_at', '<=', $endDate)
                    ->where('status', 'active')
                    ->where('identifier', 'free')
                    ->count();

                $premiumUsers = DB::table('subscriptions')
                    ->where('created_at', '>=', $startDate)
                    ->where('created_at', '<=', $endDate)
                    ->where('status', 'active')
                    ->where('identifier', 'premium')
                    ->count();

                $chartData['free'][] = $freeUsers;
                $chartData['paid'][] = $premiumUsers;

                $category[] = 'Week ' . $week;
            }


        } elseif ($type == 'week') {


            $weekStart = Carbon::now()->startOfWeek();
            $weekEnd = Carbon::now()->endOfWeek();

            $weekStartdate = Carbon::now()->startOfWeek()->toDateString();
            $weekEnddate = Carbon::now()->endOfWeek()->toDateString();

            while ($weekStart->lte($weekEnd)) {
                $freeUsers = DB::table('subscriptions')
                    ->whereDate('created_at', '=', $weekStart->toDateString())
                    ->where('status', 'active')
                    ->where('identifier', 'free')
                    ->count();

                $premiumUsers = DB::table('subscriptions')
                    ->whereDate('created_at', '=', $weekStart->toDateString())
                    ->where('status', 'active')
                    ->where('identifier', 'premium')
                    ->count();

                $chartData['free'][] = $freeUsers;
                $chartData['paid'][] = $premiumUsers;

                $category[] = $weekStart->format('l'); // Day of the week (e.g., Monday)
                $weekStart->addDay();
            }
        } else {

            $request->session()->put('subscription_range', $date_range_string);

            $currentDate = $startDate;
            while (strtotime($currentDate) <= strtotime($endDate)) {
                $freeUsers = DB::table('subscriptions')
                    ->whereDate('created_at', '=', $currentDate)
                    ->where('status', 'active')
                    ->where('identifier', 'free')
                    ->count();

                $premiumUsers = DB::table('subscriptions')
                    ->whereDate('created_at', '=', $currentDate)
                    ->where('status', 'active')
                    ->where('identifier', 'premium')
                    ->count();

                $chartData['free'][] = $freeUsers;
                $chartData['paid'][] = $premiumUsers;
                //  $category[] = date('d', strtotime($currentDate));

                $category[] = '';

                $currentDate = date('Y-m-d', strtotime("+1 day", strtotime($currentDate)));
            }

        }

        foreach ($chartData['free'] as $freeUsersCount) {
            $sumFreeUsers += $freeUsersCount;
        }

        foreach ($chartData['paid'] as $paidUsersCount) {
            $sumPaidUsers += $paidUsersCount;
        }

        $data = [
            'chartData' => $chartData,
            'category' => $category,
            'free_user' => $sumFreeUsers,
            'paid_user' => $sumPaidUsers,
        ];


        return response()->json(['data' => $data, 'status' => true]);
    }


    //------------------------- Chart data ---------------------------------------------------------//



    public function getUserChartData()
    {

    }
}
