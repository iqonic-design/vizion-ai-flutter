<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ChatHistoryTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('chat_history')->delete();
        
        \DB::table('chat_history')->insert(array (
            0 => 
            array (
                'id' => 7,
                'user_id' => 3,
                'title' => 'Exploring the Future of Autonomous Vehicles and Their Impact',
                'created_by' => 3,
                'updated_by' => 3,
                'deleted_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-02-26 11:33:57',
                'updated_at' => '2024-02-26 11:34:36',
            ),
            1 => 
            array (
                'id' => 8,
                'user_id' => 3,
                'title' => 'Impact of Big Data Analytics on Healthcare Outcomes and Strategies',
                'created_by' => 3,
                'updated_by' => 3,
                'deleted_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-02-26 11:36:02',
                'updated_at' => '2024-02-26 11:36:37',
            ),
            2 => 
            array (
                'id' => 9,
                'user_id' => 3,
                'title' => 'Exploring Flutter\'s Hot Reload: A Revolution in App Development',
                'created_by' => 3,
                'updated_by' => 3,
                'deleted_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-02-26 11:37:47',
                'updated_at' => '2024-02-26 11:38:21',
            ),
            3 => 
            array (
                'id' => 10,
                'user_id' => 3,
                'title' => 'Navigating Post-Pandemic Global Economic Recovery: Outlook & Challenges',
                'created_by' => 3,
                'updated_by' => 3,
                'deleted_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-02-26 11:39:20',
                'updated_at' => '2024-02-26 11:40:01',
            ),
            4 => 
            array (
                'id' => 11,
                'user_id' => 3,
                'title' => 'Recent Advances in Global Climate Change Policies and Initiatives',
                'created_by' => 3,
                'updated_by' => 3,
                'deleted_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-02-26 11:40:15',
                'updated_at' => '2024-02-26 11:40:53',
            ),
        ));
        
        
    }
}