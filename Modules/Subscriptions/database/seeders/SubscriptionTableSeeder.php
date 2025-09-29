<?php

namespace Modules\Subscriptions\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Subscriptions\Models\Subscription;
use DateTime;
use \DateInterval;

class SubscriptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currentDate = new \DateTime();
        $endDate = clone $currentDate;
        $endDate->add(new \DateInterval('P7D'));

        $yearBefore = clone $endDate;
        $yearBefore->sub(new \DateInterval('P1Y'));

        if (env('IS_DUMMY_DATA')) {
            $data = [

                [
                    'plan_id' => 1,
                    'user_id' => 3,
                    'start_date' => '2024-01-22 08:35:14',
                    'end_date' => '2024-02-22 08:36:14',
                    'status' => 'active',
                    'amount' => 0,
                    'name' => 'Free',
                    'identifier' => 'free',
                    'type' => 'Monthly',
                    'duration' => 1,
                    'plan_type' => 'Unlimited',
                    'payment_id' => 1,
                    'planlimits' => json_decode('[{"id":1,"planlimitation_id":7,"limitation_title":"AI Image Generate Limit","limit_type":"system_service","type":"ai_image","limit":1,"key":"image_count","status":1},{"id":2,"planlimitation_id":8,"limitation_title":"AI Art Generate Limit","limit_type":"system_service","type":"ai_art_generator","limit":1,"key":"image_count","status":1},{"id":3,"planlimitation_id":9,"limitation_title":"AI Writer Generate Limit","limit_type":"system_service","type":"ai_writer","limit":100,"key":"word_count","status":1},{"id":4,"planlimitation_id":10,"limitation_title":"AI Chat Generate Limit","limit_type":"system_service","type":"ai_chat","limit":100,"key":"word_count","status":1},{"id":5,"planlimitation_id":11,"limitation_title":"AI Code Generate Limit","limit_type":"system_service","type":"ai_code","limit":100,"key":"word_count","status":1},{"id":6,"planlimitation_id":12,"limitation_title":"AI Image to Text Generate Limit","limit_type":"system_service","type":"ai_image_text","limit":100,"key":"word_count","status":1}]'),
                    'created_by' => 3,
                    'updated_by' => 3,
                    'deleted_by' => NULL,
                    'deleted_at' => NULL,
                    'created_at' => '2024-01-22 08:35:14',
                    'updated_at' => '2024-01-22 08:35:14',
                ],
                [
                    'plan_id' => 1,
                    'user_id' => 4,
                    'start_date' => '2024-01-28 08:44:03',
                    'end_date' => '2024-02-28 08:44:03',
                    'status' => 'active',
                    'amount' => 0,
                    'name' => 'Free',
                    'identifier' => 'free',
                    'type' => 'Monthly',
                    'duration' => 1,
                    'plan_type' => 'Unlimited',
                    'payment_id' => 2,
                    'planlimits' => json_decode('[{"id":1,"planlimitation_id":7,"limitation_title":"AI Image Generate Limit","limit_type":"system_service","type":"ai_image","limit":1,"key":"image_count","status":1},{"id":2,"planlimitation_id":8,"limitation_title":"AI Art Generate Limit","limit_type":"system_service","type":"ai_art_generator","limit":1,"key":"image_count","status":1},{"id":3,"planlimitation_id":9,"limitation_title":"AI Writer Generate Limit","limit_type":"system_service","type":"ai_writer","limit":100,"key":"word_count","status":1},{"id":4,"planlimitation_id":10,"limitation_title":"AI Chat Generate Limit","limit_type":"system_service","type":"ai_chat","limit":100,"key":"word_count","status":1},{"id":5,"planlimitation_id":11,"limitation_title":"AI Code Generate Limit","limit_type":"system_service","type":"ai_code","limit":100,"key":"word_count","status":1},{"id":6,"planlimitation_id":12,"limitation_title":"AI Image to Text Generate Limit","limit_type":"system_service","type":"ai_image_text","limit":100,"key":"word_count","status":1}]'),
                    'created_by' => 4,
                    'updated_by' => 4,
                    'deleted_by' => NULL,
                    'deleted_at' => NULL,
                    'created_at' => '2024-01-28 08:44:03',
                    'updated_at' => '2024-01-28 08:44:03',
                ],
                [
                    'plan_id' => 1,
                    'user_id' => 5,
                    'start_date' => '2023-03-5 08:59:59',
                    'end_date' => '2023-04-5 08:59:59',
                    'status' => 'active',
                    'amount' => 0,
                    'name' => 'Free',
                    'identifier' => 'free',
                    'type' => 'Monthly',
                    'duration' => 1,
                    'plan_type' => 'Unlimited',
                    'payment_id' => 3,
                    'planlimits' => json_decode('[{"id":1,"planlimitation_id":7,"limitation_title":"AI Image Generate Limit","limit_type":"system_service","type":"ai_image","limit":1,"key":"image_count","status":1},{"id":2,"planlimitation_id":8,"limitation_title":"AI Art Generate Limit","limit_type":"system_service","type":"ai_art_generator","limit":1,"key":"image_count","status":1},{"id":3,"planlimitation_id":9,"limitation_title":"AI Writer Generate Limit","limit_type":"system_service","type":"ai_writer","limit":100,"key":"word_count","status":1},{"id":4,"planlimitation_id":10,"limitation_title":"AI Chat Generate Limit","limit_type":"system_service","type":"ai_chat","limit":100,"key":"word_count","status":1},{"id":5,"planlimitation_id":11,"limitation_title":"AI Code Generate Limit","limit_type":"system_service","type":"ai_code","limit":100,"key":"word_count","status":1},{"id":6,"planlimitation_id":12,"limitation_title":"AI Image to Text Generate Limit","limit_type":"system_service","type":"ai_image_text","limit":100,"key":"word_count","status":1}]'),
                    'created_by' => 5,
                    'updated_by' => 5,
                    'deleted_by' => NULL,
                    'deleted_at' => NULL,
                    'created_at' => '2023-03-5 08:59:59',
                    'updated_at' => '2023-03-5 08:59:59',
                ],
                [
                    'plan_id' => 1,
                    'user_id' => 6,
                    'start_date' => '2023-06-5 08:59:59',
                    'end_date' => '2023-07-5 08:59:59',
                    'status' => 'active',
                    'amount' => 0,
                    'name' => 'Free',
                    'identifier' => 'free',
                    'type' => 'Monthly',
                    'duration' => 1,
                    'plan_type' => 'Unlimited',
                    'payment_id' => 4,
                    'planlimits' => json_decode('[{"id":1,"planlimitation_id":7,"limitation_title":"AI Image Generate Limit","limit_type":"system_service","type":"ai_image","limit":1,"key":"image_count","status":1},{"id":2,"planlimitation_id":8,"limitation_title":"AI Art Generate Limit","limit_type":"system_service","type":"ai_art_generator","limit":1,"key":"image_count","status":1},{"id":3,"planlimitation_id":9,"limitation_title":"AI Writer Generate Limit","limit_type":"system_service","type":"ai_writer","limit":100,"key":"word_count","status":1},{"id":4,"planlimitation_id":10,"limitation_title":"AI Chat Generate Limit","limit_type":"system_service","type":"ai_chat","limit":100,"key":"word_count","status":1},{"id":5,"planlimitation_id":11,"limitation_title":"AI Code Generate Limit","limit_type":"system_service","type":"ai_code","limit":100,"key":"word_count","status":1},{"id":6,"planlimitation_id":12,"limitation_title":"AI Image to Text Generate Limit","limit_type":"system_service","type":"ai_image_text","limit":100,"key":"word_count","status":1}]'),
                    'created_by' => 6,
                    'updated_by' => 6,
                    'deleted_by' => NULL,
                    'deleted_at' => NULL,
                    'created_at' => '2024-02-24 09:02:40',
                    'updated_at' => '2024-02-24 09:02:40',
                ],
                [
                    'plan_id' => 1,
                    'user_id' => 12,
                    'start_date' => '2023-04-15 08:59:59',
                    'end_date' => '2023-05-15 08:59:59',
                    'status' => 'active',
                    'amount' => 0,
                    'name' => 'Free',
                    'identifier' => 'free',
                    'type' => 'Monthly',
                    'duration' => 1,
                    'plan_type' => 'Unlimited',
                    'planlimits' => json_decode('[{"id":1,"planlimitation_id":7,"limitation_title":"AI Image Generate Limit","limit_type":"system_service","type":"ai_image","limit":1,"key":"image_count","status":1},{"id":2,"planlimitation_id":8,"limitation_title":"AI Art Generate Limit","limit_type":"system_service","type":"ai_art_generator","limit":1,"key":"image_count","status":1},{"id":3,"planlimitation_id":9,"limitation_title":"AI Writer Generate Limit","limit_type":"system_service","type":"ai_writer","limit":100,"key":"word_count","status":1},{"id":4,"planlimitation_id":10,"limitation_title":"AI Chat Generate Limit","limit_type":"system_service","type":"ai_chat","limit":100,"key":"word_count","status":1},{"id":5,"planlimitation_id":11,"limitation_title":"AI Code Generate Limit","limit_type":"system_service","type":"ai_code","limit":100,"key":"word_count","status":1},{"id":6,"planlimitation_id":12,"limitation_title":"AI Image to Text Generate Limit","limit_type":"system_service","type":"ai_image_text","limit":100,"key":"word_count","status":1}]'),
                    'payment_id' => 5,
                    'created_by' => 12,
                    'updated_by' => 12,
                    'deleted_by' => NULL,
                    'deleted_at' => NULL,
                    'created_at' => '2024-02-24 09:04:21',
                    'updated_at' => '2024-02-24 09:04:21',
                ],
                [
                    'plan_id' => 1,
                    'user_id' => 9,
                    'start_date' => '2023-06-15 08:59:59',
                    'end_date' =>'2023-07-15 08:59:59',
                    'status' => 'active',
                    'amount' => 0,
                    'name' => 'Free',
                    'identifier' => 'free',
                    'type' => 'Monthly',
                    'duration' => 1,
                    'plan_type' => 'Unlimited',
                    'planlimits' => json_decode('[{"id":1,"planlimitation_id":7,"limitation_title":"AI Image Generate Limit","limit_type":"system_service","type":"ai_image","limit":1,"key":"image_count","status":1},{"id":2,"planlimitation_id":8,"limitation_title":"AI Art Generate Limit","limit_type":"system_service","type":"ai_art_generator","limit":1,"key":"image_count","status":1},{"id":3,"planlimitation_id":9,"limitation_title":"AI Writer Generate Limit","limit_type":"system_service","type":"ai_writer","limit":100,"key":"word_count","status":1},{"id":4,"planlimitation_id":10,"limitation_title":"AI Chat Generate Limit","limit_type":"system_service","type":"ai_chat","limit":100,"key":"word_count","status":1},{"id":5,"planlimitation_id":11,"limitation_title":"AI Code Generate Limit","limit_type":"system_service","type":"ai_code","limit":100,"key":"word_count","status":1},{"id":6,"planlimitation_id":12,"limitation_title":"AI Image to Text Generate Limit","limit_type":"system_service","type":"ai_image_text","limit":100,"key":"word_count","status":1}]'),
                    'payment_id' => 6,
                    'created_by' => 9,
                    'updated_by' => 9,
                    'deleted_by' => NULL,
                    'deleted_at' => NULL,
                    'created_at' => '2024-02-24 09:06:47',
                    'updated_at' => '2024-02-24 09:06:47',
                ],
                [
                    'plan_id' => 1,
                    'user_id' => 7,
                    'start_date' => '2023-04-25 08:59:59',
                    'end_date' => '2023-05-25 08:59:59',
                    'status' => 'active',
                    'amount' => 0,
                    'name' => 'Free',
                    'identifier' => 'free',
                    'type' => 'Monthly',
                    'duration' => 1,
                    'plan_type' => 'Unlimited',
                    'planlimits' => json_decode('[{"id":1,"planlimitation_id":7,"limitation_title":"AI Image Generate Limit","limit_type":"system_service","type":"ai_image","limit":1,"key":"image_count","status":1},{"id":2,"planlimitation_id":8,"limitation_title":"AI Art Generate Limit","limit_type":"system_service","type":"ai_art_generator","limit":1,"key":"image_count","status":1},{"id":3,"planlimitation_id":9,"limitation_title":"AI Writer Generate Limit","limit_type":"system_service","type":"ai_writer","limit":100,"key":"word_count","status":1},{"id":4,"planlimitation_id":10,"limitation_title":"AI Chat Generate Limit","limit_type":"system_service","type":"ai_chat","limit":100,"key":"word_count","status":1},{"id":5,"planlimitation_id":11,"limitation_title":"AI Code Generate Limit","limit_type":"system_service","type":"ai_code","limit":100,"key":"word_count","status":1},{"id":6,"planlimitation_id":12,"limitation_title":"AI Image to Text Generate Limit","limit_type":"system_service","type":"ai_image_text","limit":100,"key":"word_count","status":1}]'),
                    'payment_id' => 7,
                    'created_by' => 7,
                    'updated_by' => 7,
                    'deleted_by' => NULL,
                    'deleted_at' => NULL,
                    'created_at' => '2024-02-24 09:09:03',
                    'updated_at' => '2024-02-24 09:09:03',
                ],
                [
                    'plan_id' => 1,
                    'user_id' => 11,
                    'start_date' => '2024-02-24 09:11:07',
                    'end_date' => '2024-03-24 09:12:07',
                    'status' => 'active',
                    'amount' => 0,
                    'name' => 'Free',
                    'planlimits' => json_decode('[{"id":1,"planlimitation_id":7,"limitation_title":"AI Image Generate Limit","limit_type":"system_service","type":"ai_image","limit":1,"key":"image_count","status":1},{"id":2,"planlimitation_id":8,"limitation_title":"AI Art Generate Limit","limit_type":"system_service","type":"ai_art_generator","limit":1,"key":"image_count","status":1},{"id":3,"planlimitation_id":9,"limitation_title":"AI Writer Generate Limit","limit_type":"system_service","type":"ai_writer","limit":100,"key":"word_count","status":1},{"id":4,"planlimitation_id":10,"limitation_title":"AI Chat Generate Limit","limit_type":"system_service","type":"ai_chat","limit":100,"key":"word_count","status":1},{"id":5,"planlimitation_id":11,"limitation_title":"AI Code Generate Limit","limit_type":"system_service","type":"ai_code","limit":100,"key":"word_count","status":1},{"id":6,"planlimitation_id":12,"limitation_title":"AI Image to Text Generate Limit","limit_type":"system_service","type":"ai_image_text","limit":100,"key":"word_count","status":1}]'),
                    'payment_id' => 7,
                    'identifier' => 'free',
                    'type' => 'Monthly',
                    'duration' => 1,
                    'plan_type' => 'Unlimited',
                    'payment_id' => 8,
                    'created_by' => 11,
                    'updated_by' => 11,
                    'deleted_by' => NULL,
                    'deleted_at' => NULL,
                    'created_at' => '2024-02-24 09:11:07',
                    'updated_at' => '2024-02-24 09:11:07',
                ],

            ];
            foreach ($data as $key => $value) {
                $subscription = [
                    'plan_id' => $value['plan_id'],
                    'user_id' => $value['user_id'],
                    'start_date' => $value['start_date'],
                    'end_date' => $value['end_date'],
                    'status' => $value['status'],
                    'amount' => $value['amount'],
                    'name' => $value['name'],
                    'identifier' => $value['identifier'],
                    'planlimits' => json_encode($value['planlimits']),
                    'type' => $value['type'],
                    'duration' => $value['duration'],
                    'plan_type' => $value['plan_type'],
                    'payment_id' => $value['payment_id'],
                    'created_at' => $value['created_at'],
                    'updated_at' => $value['updated_at'],
                ];
                $subscription = Subscription::create($subscription);
            }
        }
        // Enable foreign key checks!
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
