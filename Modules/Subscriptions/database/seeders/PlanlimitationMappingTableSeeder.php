<?php

namespace Modules\Subscriptions\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class PlanlimitationMappingTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('planlimitation_mapping')->delete();
        
        \DB::table('planlimitation_mapping')->insert(array (
            0 => 
            array (
                'created_at' => '2024-03-07 08:35:24',
                'created_by' => NULL,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'id' => 1,
                'limit' => 10,
                'plan_id' => 2,
                'planlimitation_id' => 1,
                'updated_at' => '2024-03-07 08:35:24',
                'updated_by' => NULL,
            ),
            1 => 
            array (
                'created_at' => '2024-03-07 08:35:24',
                'created_by' => NULL,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'id' => 2,
                'limit' => 10,
                'plan_id' => 2,
                'planlimitation_id' => 2,
                'updated_at' => '2024-03-07 08:35:24',
                'updated_by' => NULL,
            ),
            2 => 
            array (
                'created_at' => '2024-03-07 08:35:24',
                'created_by' => NULL,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'id' => 3,
                'limit' => 10000,
                'plan_id' => 2,
                'planlimitation_id' => 3,
                'updated_at' => '2024-03-07 08:35:24',
                'updated_by' => NULL,
            ),
            3 => 
            array (
                'created_at' => '2024-03-07 08:35:24',
                'created_by' => NULL,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'id' => 4,
                'limit' => 10000,
                'plan_id' => 2,
                'planlimitation_id' => 4,
                'updated_at' => '2024-03-07 08:35:24',
                'updated_by' => NULL,
            ),
            4 => 
            array (
                'created_at' => '2024-03-07 08:35:24',
                'created_by' => NULL,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'id' => 5,
                'limit' => 10000,
                'plan_id' => 2,
                'planlimitation_id' => 5,
                'updated_at' => '2024-03-07 08:35:24',
                'updated_by' => NULL,
            ),
            5 => 
            array (
                'created_at' => '2024-03-07 08:35:24',
                'created_by' => NULL,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'id' => 6,
                'limit' => 10000,
                'plan_id' => 2,
                'planlimitation_id' => 6,
                'updated_at' => '2024-03-07 08:35:24',
                'updated_by' => NULL,
            ),
            6 => 
            array (
                'created_at' => '2024-03-07 08:35:24',
                'created_by' => NULL,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'id' => 7,
                'limit' => 1,
                'plan_id' => 1,
                'planlimitation_id' => 7,
                'updated_at' => '2024-03-07 08:35:24',
                'updated_by' => NULL,
            ),
            7 => 
            array (
                'created_at' => '2024-03-07 08:35:24',
                'created_by' => NULL,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'id' => 8,
                'limit' => 1,
                'plan_id' => 1,
                'planlimitation_id' => 8,
                'updated_at' => '2024-03-07 08:35:24',
                'updated_by' => NULL,
            ),
            8 => 
            array (
                'created_at' => '2024-03-07 08:35:24',
                'created_by' => NULL,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'id' => 9,
                'limit' => 100,
                'plan_id' => 1,
                'planlimitation_id' => 9,
                'updated_at' => '2024-03-07 08:35:24',
                'updated_by' => NULL,
            ),
            9 => 
            array (
                'created_at' => '2024-03-07 08:35:24',
                'created_by' => NULL,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'id' => 10,
                'limit' => 100,
                'plan_id' => 1,
                'planlimitation_id' => 10,
                'updated_at' => '2024-03-07 08:35:24',
                'updated_by' => NULL,
            ),
            10 => 
            array (
                'created_at' => '2024-03-07 08:35:24',
                'created_by' => NULL,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'id' => 11,
                'limit' => 100,
                'plan_id' => 1,
                'planlimitation_id' => 11,
                'updated_at' => '2024-03-07 08:35:24',
                'updated_by' => NULL,
            ),
            11 => 
            array (
                'created_at' => '2024-03-07 08:35:24',
                'created_by' => NULL,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'id' => 12,
                'limit' => 100,
                'plan_id' => 1,
                'planlimitation_id' => 12,
                'updated_at' => '2024-03-07 08:35:24',
                'updated_by' => NULL,
            ),
        ));
        
        
    }
}