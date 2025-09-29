<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use App\Models\ChatHistoryImage;

class ChatHistoryImageTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        if (env('IS_DUMMY_DATA')) {
            $data = [
               
                [
                    'id' => 1,
                    'user_id' => 3,
                    'created_by' => 3,
                    'updated_by' => 3,
                    'upload_image' => public_path('/dummy-images/chat_history_images/chat_image_1.png'),
                    'deleted_by' => NULL,
                    'deleted_at' => NULL,
                    'created_at' => '2024-02-26 11:48:08',
                    'updated_at' => '2024-02-26 11:48:08',
                ],
                [
                    'id' => 2,
                    'user_id' => 3,
                    'created_by' => 3,
                    'updated_by' => 3,
                    'upload_image' => public_path('/dummy-images/chat_history_images/chat_image_2.png'),
                    'deleted_by' => NULL,
                    'deleted_at' => NULL,
                    'created_at' => '2024-02-26 11:49:00',
                    'updated_at' => '2024-02-26 11:49:00',
                ],
                [
                    'id' => 3,
                    'user_id' => 3,
                    'created_by' => 3,
                    'updated_by' => 3,
                    'upload_image' => public_path('/dummy-images/chat_history_images/chat_image_3.jpg'),
                    'deleted_by' => NULL,
                    'deleted_at' => NULL,
                    'created_at' => '2024-02-26 11:50:33',
                    'updated_at' => '2024-02-26 11:50:33',
                ],
                [
                    'id' => 4,
                    'user_id' => 3,
                    'created_by' => 3,
                    'updated_by' => 3,
                    'upload_image' => public_path('/dummy-images/chat_history_images/chat_image_4.png'),
                    'deleted_by' => NULL,
                    'deleted_at' => NULL,
                    'created_at' => '2024-02-26 11:51:34',
                    'updated_at' => '2024-02-26 11:51:34',
                ],
                [
                    'id' => 5,
                    'user_id' => 3,
                    'created_by' => 3,
                    'updated_by' => 3,
                    'upload_image' => public_path('/dummy-images/chat_history_images/chat_image_5.png'),
                    'deleted_by' => NULL,
                    'deleted_at' => NULL,
                    'created_at' => '2024-02-26 11:53:06',
                    'updated_at' => '2024-02-26 11:53:06',
                ],
                [
                    'id' => 6,
                    'user_id' => 3,
                    'created_by' => 3,
                    'updated_by' => 3,
                    'upload_image' => public_path('/dummy-images/chat_history_images/chat_image_6.png'),
                    'deleted_by' => NULL,
                    'deleted_at' => NULL,
                    'created_at' => '2024-02-26 11:53:07',
                    'updated_at' => '2024-02-26 11:53:07',
                ],
                [
                    'id' => 7,
                    'user_id' => 3,
                    'created_by' => 3,
                    'updated_by' => 3,
                    'upload_image' => public_path('/dummy-images/chat_history_images/chat_image_7.png'),
                    'deleted_by' => NULL,
                    'deleted_at' => NULL,
                    'created_at' => '2024-02-26 12:01:33',
                    'updated_at' => '2024-02-26 12:01:33',
                ],
                [
                    'id' => 8,
                    'user_id' => 3,
                    'created_by' => 3,
                    'updated_by' => 3,
                    'upload_image' => public_path('/dummy-images/chat_history_images/chat_image_8.png'),
                    'deleted_by' => NULL,
                    'deleted_at' => NULL,
                    'created_at' => '2024-02-26 12:01:36',
                    'updated_at' => '2024-02-26 12:01:36',
                ],
                [
                    'id' => 9,
                    'user_id' => 3,
                    'created_by' => 3,
                    'updated_by' => 3,
                    'upload_image' => public_path('/dummy-images/chat_history_images/chat_image_9.png'),
                    'deleted_by' => NULL,
                    'deleted_at' => NULL,
                    'created_at' => '2024-02-26 12:01:59',
                    'updated_at' => '2024-02-26 12:01:59',
                ],
                [
                    'id' => 10,
                    'user_id' => 3,
                    'created_by' => 3,
                    'updated_by' => 3,
                    'upload_image' => public_path('/dummy-images/chat_history_images/chat_image_10.png'),
                    'deleted_by' => NULL,
                    'deleted_at' => NULL,
                    'created_at' => '2024-02-26 12:02:21',
                    'updated_at' => '2024-02-26 12:02:21',
                ],
                [
                    'id' => 11,
                    'user_id' => 3,
                    'created_by' => 3,
                    'updated_by' => 3,
                    'upload_image' => public_path('/dummy-images/chat_history_images/chat_image_11.jpg'),
                    'deleted_by' => NULL,
                    'deleted_at' => NULL,
                    'created_at' => '2024-02-26 12:03:26',
                    'updated_at' => '2024-02-26 12:03:26',
                ],
            ];
            foreach ($data as $key => $val) {
                $uploadImage = $val['upload_image'] ?? null;
                $historyData = Arr::except($val, ['upload_image']);
                $history = ChatHistoryImage::create($historyData);
                if (isset($uploadImage)) {
                    $this->attachFeatureImage($history, $uploadImage);
                }
            }
        }  
    }
    private function attachFeatureImage($model, $publicPath)
    {
        if(!env('IS_DUMMY_DATA_IMAGE')) return false;

        $file = new \Illuminate\Http\File($publicPath);

        $media = $model->addMedia($file)->preservingOriginal()->toMediaCollection('upload_image');

        return $media;

    }
}