<?php

namespace Modules\Subscriptions\Http\Controllers\Backend\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Subscriptions\Http\Requests\SubscriptionRequest;
use Modules\Subscriptions\Models\Plan;
use Modules\Subscriptions\Models\Subscription;
use Modules\Subscriptions\Models\SubscriptionTransactions;
use Modules\Subscriptions\Trait\SubscriptionTrait;
use Modules\Subscriptions\Transformers\SubscriptionResource;
use Modules\Subscriptions\Transformers\PlanlimitationMappingResource;

class SubscriptionController extends Controller
{
    use SubscriptionTrait;

    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function saveSubscriptionDetails(SubscriptionRequest $request)
    {
        
        $user_id = $request->user_id ? $request->user_id : auth()->id();

        $user = User::where('id', $user_id)->first();
        
        $timezone = date_default_timezone_set($this->getTimeZone());

        $get_existing_plan = $this->get_user_active_plan($user_id);

        $active_plan_left_days = 0;
        //set Default Status

        $status = config('constant.SUBSCRIPTION_STATUS.PENDING');

        //start date

        $start_date = date('Y-m-d H:i:s');

        if ($get_existing_plan) {
           
            if ($request->identifier == $get_existing_plan->identifier) {

                $active_plan_left_days = $this->check_days_left_plan($get_existing_plan);
             
            }

            $get_existing_plan->update([
                'status' => config('constant.SUBSCRIPTION_STATUS.INACTIVE'),
            ]);

            $get_existing_plan->save();
        }

        $plan = Plan::where('id', $request->plan_id)->with('planLimitation')->first();

        $limitation_data= PlanlimitationMappingResource::collection($plan->planLimitation);

     

        //get end date

        $end_date = $this->get_plan_expiration_date($start_date, $plan['type'], $active_plan_left_days, $plan['duration']);

        $subscribed_plan_data = [

            'plan_id' => $request->plan_id,
            'user_id' => $user_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'status' => $status,
            'amount' => $plan['amount'],
            'name' => $plan['name'],
            'identifier' => $plan['identifier'],
            'type' => $plan['type'],
            'duration' => $plan['duration'],
            'plan_type' => $plan['planlimitation'],
            'planlimits'=> $limitation_data ? json_encode( $limitation_data) : null

        ];
        
        $result = Subscription::create($subscribed_plan_data);
        
        if ($result) {
            $payment_data = [
                'subscriptions_id' => $result->id,
                'user_id' => $result->user_id,
                'amount' => $result->amount,
                'payment_status' => $request->payment_status,
                'payment_type' => $request->payment_type,
                'transaction_id' => $request->transaction_id,
            ];
            $payment = SubscriptionTransactions::create($payment_data);

            if ($payment->payment_status == 'paid') {
                $result->status = config('constant.SUBSCRIPTION_STATUS.ACTIVE');
                $result->payment_id = $payment->id;
                $result->save();
                $user->save();   $user->is_subscribe = 1;
                $message = __('messages.payment_completed');
            }
        }

        $result_data=Subscription::where('id', $result->id)->first();

        $result_data['username']=optional($result_data->user)->full_name;

        $response = new SubscriptionResource($result_data);

    
        // Assuming $this refers to the current class instance
        $type = 'new_subscription';
        $notify_message = 'A new user has subscribed!';
        $this->sendNotificationOnsubscription($type,$notify_message,$response);       
        return $this->sendResponse($response, __('messages.user_subscribe'));

    }

       public function getUserSubscriptionHistory()
       {

           $user_id = auth()->id();

           return $this->sendResponse(SubscriptionResource::collection(Subscription::where('user_id', $user_id)->get()), __('messages.user_subscribe_history'));

       }

       public function cancelSubscription(Request $request)
       {
           $user_id = $request->user_id ? $request->user_id : auth()->id();
           $subscription_plan_id = $request->id;

           $user_subscription = Subscription::where('id', $subscription_plan_id)->where('user_id', $user_id)->first();

           $user = User::where('id', $user_id)->first();

           if ($user_subscription) {

               $user_subscription->status = config('constant.SUBSCRIPTION_STATUS.INACTIVE');
               $user_subscription->save();
               $user->is_subscribe = 0;
               $user->save();

           }

           $message = __('messages.subscribe_cancel');

           return $this->sendResponse($subscription_plan_id, $message);

       }
}
