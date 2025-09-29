<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Modules;
use Carbon\Carbon;

class ModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        $modules = [


            [
                'module_name' => 'Syetem Service',
                'description' => '',
                'status' => 1,   
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],


            [
                'module_name' => 'Service',
                'description' => '',
                'status' => 1,   
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
           
        
            [
                'module_name' => 'Category',
                'description' => '',
                'status' => 1,   
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'module_name' => 'subcategory',
                'description' => '',
                'status' => 1,   
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                
            ],

            [
                'module_name' => 'User',
                'description' => '',
                'more_permission' =>json_encode(['change_password','send_notification','subscribe_user', 'paid_plan_expire_user']),
                'status' => 1,   
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                
            ],

            [
                'module_name' => 'Subscriptions',
                'description' => '',
                'status' => 1,   
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],


            [
                'module_name' => 'Subscriptions Plan',
                'description' => '',
                'status' => 1,   
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],


            [
                'module_name' => 'CustomTemplate',
                'description' => '',
                'status' => 1,   
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'module_name' => 'Page',
                'description' => '',
                'status' => 1,   
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
      
            [
                'module_name' => 'Notification',
                'description' => '',
                'status' => 1,   
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_name' => 'App Banner',
                'description' => '',
                'status' => 1,   
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_name' => 'Notification Template',
                'description' => '',
                'status' => 1,   
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], 

            [
                'module_name' => 'Setting',
                'description' => '',
                'status' => 1,   
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // [
            //     'module_name' => 'Constant',
            //     'description' => '',
            //     'status' => 1,   
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ], 
            [
                'module_name' => 'Permission',
                'description' => '',
                'status' => 1,   
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], 
            // [
            //     'module_name' => 'Modules',
            //     'description' => '',
            //     'status' => 1,   
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ] 
        ];

        // if(env('IS_DUMMY_DATA')) {
            foreach ($modules as $key => $module_data) {
                
                $modules = Modules::create($module_data);
                
            }
        // }

    }
}
