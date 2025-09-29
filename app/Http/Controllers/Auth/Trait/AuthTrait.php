<?php

namespace App\Http\Controllers\Auth\Trait;

use App\Events\Auth\UserLoginSuccess;
use App\Events\Frontend\UserRegistered;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Modules\Service\Models\SystemService;
use Modules\Commission\Models\EmployeeCommission;
use Modules\Commission\Models\Commission;
use App\Events\Backend\UserCreated;
use Modules\Employee\Models\BranchEmployee;
use Modules\Subscriptions\Models\Plan;
use Modules\Subscriptions\Models\Subscription;
use Modules\Subscriptions\Models\SubscriptionTransactions;


trait AuthTrait
{
    protected function loginTrait($request)
    {
        $email = $request->email;
        $password = $request->password;
        $remember = $request->remember_me;


        if (Auth::attempt(['email' => $email, 'password' => $password, 'status' => 1], $remember)) {
            $user = auth()->user();
            if ($user->roles()->count() == 1) {
                if ($user->hasRole('user')) {
                    Auth::logout();
                    return ['status' => 406, 'message' => __('auth.Unauthorized_role')];
                }

                event(new UserLoginSuccess($request, auth()->user()));

                return ['status' => 200, 'message' => 'Login successful!'];
            }
        }

        return ['status' => 401, 'error' => __('auth.failed')];
    }


    protected function registerTrait($request, $model = null)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:191'],
            'last_name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
            'password' => ['required', Rules\Password::defaults()],
        ]);


        $arr = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'user_type' => $request->user_type
        ];

        if (isset($model)) {
            $user = $model::create($arr);
        } else {
            $user = User::create($arr);
        }
        $usertype = $user->user_type;

        $user->assignRole($usertype);

        $user->save();

        $plan = Plan::where('identifier', 'free')->first();

        if ($plan) {

            $start_date = date('Y-m-d H:i:s');

            $end_date = $this->get_plan_expiration_date($start_date, $plan['type'], 0, $plan['duration']);

            $status = config('constant.SUBSCRIPTION_STATUS.PENDING');

            $subscribed_plan_data = [

                'plan_id' => $plan->id,
                'user_id' => $user->id,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'status' => $status,
                'amount' => $plan['amount'],
                'name' => $plan['name'],
                'identifier' => $plan['identifier'],
                'type' => $plan['type'],
                'duration' => $plan['duration'],
                'plan_type' => $plan['planlimitation'],

            ];


            $result = Subscription::create($subscribed_plan_data);

            if ($result) {
                $payment_data = [
                    'subscriptions_id' => $result->id,
                    'user_id' => $result->user_id,
                    'amount' => $result->amount,
                    'payment_status' => 'paid',
                    'payment_type' => 'free',
                    'transaction_id' => null,
                ];
                $payment = SubscriptionTransactions::create($payment_data);
            }

            if ($payment->payment_status == 'paid') {
                $result->status = config('constant.SUBSCRIPTION_STATUS.ACTIVE');
                $result->payment_id = $payment->id;
                $result->save();

                $user->is_subscribe = 1;

                $user->save();

            }
        }



        \Illuminate\Support\Facades\Artisan::call('view:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        \Illuminate\Support\Facades\Artisan::call('route:clear');
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        \Illuminate\Support\Facades\Artisan::call('config:cache');

        event(new Registered($user));
        event(new UserRegistered($user));

        return $user;
    }

    protected function get_plan_expiration_date($plan_start_date = '', $plan_type = '', $left_days = 0, $plan_duration = 1)
    {
        $start_at = new \Carbon\Carbon($plan_start_date);
        $end_date = '';

        if ($plan_type === 'Monthly') {

            $end_date = $start_at->addMonths($plan_duration)->addDays($left_days);
        }
        if ($plan_type == 'Yearly') {

            $end_date = $start_at->addYears($plan_duration)->addDays($left_days);

        }
        if ($plan_type == 'Weekly') {

            $getdays = Plan::where('identifier', 'free')->first();
            $getdays = $getdays->trial_period;
            $days = $left_days + $getdays;
            $end_date = $start_at->addDays($days);
        }

        return $end_date->format('Y-m-d H:i:s');
    }
}


