<?php

namespace Modules\Subscriptions\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;



class PlanlimitationTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('planlimitation')->delete();
        
        \DB::table('planlimitation')->insert(array (
            0 => 
            array (
                'created_at' => '2024-03-07 08:26:31',
                'created_by' => 1,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'id' => 1,
                'key' => 'image_count',
                'limit' => 10,
                'limit_type' => 'system_service',
                'name' => 'AI Image Generate Limit',
                'status' => 1,
                'type' => 'ai_image',
                'updated_at' => '2024-03-07 08:26:31',
                'updated_by' => 1,
            ),
            1 => 
            array (
                'created_at' => '2024-03-07 08:26:59',
                'created_by' => 1,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'id' => 2,
                'key' => 'image_count',
                'limit' => 10,
                'limit_type' => 'system_service',
                'name' => 'AI Art Generate Limit',
                'status' => 1,
                'type' => 'ai_art_generator',
                'updated_at' => '2024-03-07 08:26:59',
                'updated_by' => 1,
            ),
            2 => 
            array (
                'created_at' => '2024-03-07 08:27:32',
                'created_by' => 1,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'id' => 3,
                'key' => 'word_count',
                'limit' => 10000,
                'limit_type' => 'system_service',
                'name' => 'AI Writer Generate Limit',
                'status' => 1,
                'type' => 'ai_writer',
                'updated_at' => '2024-03-07 08:27:32',
                'updated_by' => 1,
            ),
            3 => 
            array (
                'created_at' => '2024-03-07 08:28:25',
                'created_by' => 1,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'id' => 4,
                'key' => 'word_count',
                'limit' => 10000,
                'limit_type' => 'system_service',
                'name' => 'AI Chat Generate Limit',
                'status' => 1,
                'type' => 'ai_chat',
                'updated_at' => '2024-03-07 08:28:25',
                'updated_by' => 1,
            ),
            4 => 
            array (
                'created_at' => '2024-03-07 08:28:57',
                'created_by' => 1,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'id' => 5,
                'key' => 'word_count',
                'limit' => 10000,
                'limit_type' => 'system_service',
                'name' => 'AI Code Generate Limit',
                'status' => 1,
                'type' => 'ai_code',
                'updated_at' => '2024-03-07 08:28:57',
                'updated_by' => 1,
            ),
            5 => 
            array (
                'created_at' => '2024-03-07 08:29:40',
                'created_by' => 1,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'id' => 6,
                'key' => 'word_count',
                'limit' => 10000,
                'limit_type' => 'system_service',
                'name' => 'AI Imge to Text Generate Limit',
                'status' => 1,
                'type' => 'ai_image_text',
                'updated_at' => '2024-03-07 08:29:40',
                'updated_by' => 1,
            ),
            6 => 
            array (
                'created_at' => '2024-03-07 08:26:31',
                'created_by' => 1,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'id' => 7,
                'key' => 'image_count',
                'limit' => 1,
                'limit_type' => 'system_service',
                'name' => 'AI Image Generate Limit',
                'status' => 1,
                'type' => 'ai_image',
                'updated_at' => '2024-03-07 08:26:31',
                'updated_by' => 1,
            ),
            7 => 
            array (
                'created_at' => '2024-03-07 08:26:59',
                'created_by' => 1,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'id' => 8,
                'key' => 'image_count',
                'limit' => 1,
                'limit_type' => 'system_service',
                'name' => 'AI Art Generate Limit',
                'status' => 1,
                'type' => 'ai_art_generator',
                'updated_at' => '2024-03-07 08:26:59',
                'updated_by' => 1,
            ),
            8 => 
            array (
                'created_at' => '2024-03-07 08:27:32',
                'created_by' => 1,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'id' => 9,
                'key' => 'word_count',
                'limit' => 100,
                'limit_type' => 'system_service',
                'name' => 'AI Writer Generate Limit',
                'status' => 1,
                'type' => 'ai_writer',
                'updated_at' => '2024-03-07 08:27:32',
                'updated_by' => 1,
            ),
            9 => 
            array (
                'created_at' => '2024-03-07 08:28:25',
                'created_by' => 1,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'id' => 10,
                'key' => 'word_count',
                'limit' => 100,
                'limit_type' => 'system_service',
                'name' => 'AI Chat Generate Limit',
                'status' => 1,
                'type' => 'ai_chat',
                'updated_at' => '2024-03-07 08:28:25',
                'updated_by' => 1,
            ),
            10 => 
            array (
                'created_at' => '2024-03-07 08:28:57',
                'created_by' => 1,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'id' => 11,
                'key' => 'word_count',
                'limit' => 100,
                'limit_type' => 'system_service',
                'name' => 'AI Code Generate Limit',
                'status' => 1,
                'type' => 'ai_code',
                'updated_at' => '2024-03-07 08:28:57',
                'updated_by' => 1,
            ),
            11 => 
            array (
                'created_at' => '2024-03-07 08:29:40',
                'created_by' => 1,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'id' => 12,
                'key' => 'word_count',
                'limit' => 100,
                'limit_type' => 'system_service',
                'name' => 'AI Imge to Text Generate Limit',
                'status' => 1,
                'type' => 'ai_image_text',
                'updated_at' => '2024-03-07 08:29:40',
                'updated_by' => 1,
            ),
        ));
        
        
    }
}