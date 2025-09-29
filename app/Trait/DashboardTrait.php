<?php

namespace App\Trait;

use App\Models\User;
use App\Jobs\BulkNotification;

trait DashboardTrait{


    public function sendNotificationOnrechargeReminder($type,$notify_message,$response){
        
        $data = mail_footer($type,$notify_message,$response);   

        $data['recharge'] = $response;
        
        BulkNotification::dispatch($data);
    }

}