<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use App\Models\HistroyImageMapping;

class HistoryImageMappingTableSeeder extends Seeder
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
                    'history_id' => 1,
                    'image_url' => env('APP_URL').'/storage/53/Bgr5wGZRYhTtjKXGJH3DL0tosnfzL1GT7Te5ZcVp.png',
                    'created_by' => 3,
                    'updated_by' => 3,
                    'history_image' => public_path('/dummy-images/history_images/history_image_1.png'),
                    'deleted_by' => NULL,
                    'deleted_at' => NULL,
                    'created_at' => '2024-02-26 11:09:11',
                    'updated_at' => '2024-02-26 11:09:12',
                ],
                [
                    'id' => 2,
                    'history_id' => 2,
                    'image_url' => env('APP_URL').'/storage/54/PwvfQ9QIau9tBwlLHMCVBhBAJz3qsHB3AkqSNM4J.png',
                    'created_by' => 3,
                    'updated_by' => 3,
                    'history_image' => public_path('/dummy-images/history_images/history_image_2.png'),
                    'deleted_by' => NULL,
                    'deleted_at' => NULL,
                    'created_at' => '2024-02-26 11:12:06',
                    'updated_at' => '2024-02-26 11:12:06',
                ],
                [
                    'id' => 3,
                    'history_id' => 3,
                    'image_url' => env('APP_URL').'/storage/55/yIGIShawaV54KD7U3ucgsfcq3rdPj2GJQNVvHC6H.png',
                    'created_by' => 3,
                    'updated_by' => 3,
                    'history_image' => public_path('/dummy-images/history_images/history_image_3.png'),
                    'deleted_by' => NULL,
                    'deleted_at' => NULL,
                    'created_at' => '2024-02-26 11:17:43',
                    'updated_at' => '2024-02-26 11:17:43',
                ],
                [
                    'id' => 5,
                    'history_id' => 5,
                    'image_url' => env('APP_URL').'/storage/57/f4NmuNhaOcYwlLrlDhzm726XocsbE60uMRXz2Eh2.png',
                    'created_by' => 3,
                    'updated_by' => 3,
                    'history_image' => public_path('/dummy-images/history_images/history_image_5.png'),
                    'deleted_by' => NULL,
                    'deleted_at' => NULL,
                    'created_at' => '2024-02-26 11:25:03',
                    'updated_at' => '2024-02-26 11:25:03',
                ],
                [
                    'id' => 8,
                    'history_id' => 55,
                    'image_url' => env('APP_URL').'/storage/74/YgzBFCnUmuQBlLQtXCohWxZQ5z3HvRgUsOtUgc6Q.png',
                    'created_by' => 3,
                    'updated_by' => 3,
                    'history_image' => public_path('/dummy-images/history_images/history_image_6.png'),
                    'deleted_by' => NULL,
                    'deleted_at' => NULL,
                    'created_at' => '2024-02-26 19:23:51',
                    'updated_at' => '2024-02-26 19:23:51',
                ],
                [
                    'id' => 9,
                    'history_id' => 57,
                    'image_url' => env('APP_URL').'/storage/76/XW6nZtykE5JBq1dJ8UoMQQPQ1KFdC3Rxdg2V5622.png',
                    'created_by' => 3,
                    'updated_by' => 3,
                    'history_image' => public_path('/dummy-images/history_images/history_image_7.png'),
                    'deleted_by' => NULL,
                    'deleted_at' => NULL,
                    'created_at' => '2024-02-27 09:59:42',
                    'updated_at' => '2024-02-27 09:59:42',
                ],
                [
                    'id' => 10,
                    'history_id' => 58,
                    'image_url' => env('APP_URL').'/storage/78/UcgBppdi1ZL170v0ROMdg6LQeuHZrjYG7JWHeDAE.png',
                    'created_by' => 3,
                    'updated_by' => 3,
                    'history_image' => public_path('/dummy-images/history_images/history_image_8.png'),
                    'deleted_by' => NULL,
                    'deleted_at' => NULL,
                    'created_at' => '2024-02-27 10:00:10',
                    'updated_at' => '2024-02-27 10:00:10',
                ],
            ];
            foreach ($data as $key => $val) {
                $historyImage = $val['history_image'] ?? null;
                $historyData = Arr::except($val, ['history_image']);
                $history = HistroyImageMapping::create($historyData);
                if (isset($historyImage)) {
                    $this->attachFeatureImage($history, $historyImage);
                }
            }
        }     
    }
    private function attachFeatureImage($model, $publicPath)
    {
        if(!env('IS_DUMMY_DATA_IMAGE')) return false;

        $file = new \Illuminate\Http\File($publicPath);

        $media = $model->addMedia($file)->preservingOriginal()->toMediaCollection('history_image');

        return $media;

    }
}