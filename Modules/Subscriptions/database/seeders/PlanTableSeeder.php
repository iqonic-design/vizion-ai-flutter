<?php

namespace Modules\Subscriptions\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Subscriptions\Models\Plan;

class PlanTableSeeder extends Seeder
{
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Disable foreign key checks!
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        if (env('IS_DUMMY_DATA')) {
            $data = [
               
                [
                    'name' => 'Free',
                    'type' => 'Monthly',
                    'duration' => 1,
                    'amount' => 0,
                    'identifier' => 'free',
                    'status' => 1,
                    'trial_period' => 0,
                    'planlimitation' => 'Unlimited',
                    'description' => 'Get started with our free plan: access basic features and resources without spending a dime, empowering you to explore and innovate.',
                ],
                [
                    'name' => 'Premium',
                    'type' => 'Yearly',
                    'duration' => 1,
                    'amount' => 20,
                    'identifier' => 'premium',
                    'status' => 1,
                    'trial_period' => 0,
                    'planlimitation' => 'Limited',
                    'description' => 'Unlock the full potential with our premium plan, offering advanced features and exclusive benefits.',
                ],
               
            ];
            foreach ($data as $key => $value) {
                $plan = [
                    'name' => $value['name'],
                    'type' => $value['type'],
                    'duration' => $value['duration'],
                    'amount' => $value['amount'],
                    'identifier' => $value['identifier'],
                    'status' => $value['status'],
                    'trial_period' => $value['trial_period'],
                    'planlimitation' => $value['planlimitation'],
                    'description' => $value['description'],
                ];
                $plan = Plan::create($plan);
                
            }
        }
         // Enable foreign key checks!
         \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
