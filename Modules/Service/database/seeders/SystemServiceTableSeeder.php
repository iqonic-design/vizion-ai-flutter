<?php

namespace Modules\Service\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Modules\Service\Models\SystemService;

class SystemServiceTableSeeder extends Seeder
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

        /*
         * Services Seed
         * ------------------
         */

        // DB::table('services')->truncate();
        // echo "Truncate: services \n";
        if (env('IS_DUMMY_DATA')) {
            $data = [
              
                [
                    'slug' => 'ai_writer',
                    'type' => 'ai_writer',
                    'name' => 'AI Writer',
                    'description' => 'Revolutionizing the writing process with the ingenuity of artificial intelligence, seamlessly crafting compelling narratives, insightful articles, and engaging content with precision and efficiency.',
                    'status' => 1,
                    'feature_image' => public_path('/dummy-images/system_images/ai_writer.jpeg'),

                ],
                [
                    'slug' => 'ai_voice',
                    'type' => 'ai_voice',
                    'name' => 'AI Voice',
                    'description' => 'Empowering communication with advanced AI voice technology, enabling seamless audio narration, voice commands, and interactive experiences with natural and expressive speech synthesis.',
                    'status' => 1,
                    'feature_image' => public_path('/dummy-images/system_images/ai_code.jpg'),
                ],                
                [
                    'slug' => 'ai_art_generator',
                    'type' => 'ai_art_generator',
                    'name' => 'AI Art Generator',
                    'description' => 'Dive into a realm where artificial intelligence converges with the canvas, crafting captivating and innovative artworks that redefine the landscape of traditional artistry.',
                    'status' => 1,
                    'feature_image' => public_path('/dummy-images/system_images/art_generator.jpg'),

                ],
                [
                    'slug' => 'ai_image',
                    'type' => 'ai_image',
                    'name' => 'AI Image',
                    'description' => 'Experience the fusion of creativity and technology as artificial intelligence transforms pixels into breathtaking visual masterpieces, redefining the essence of imagery with unparalleled innovation.',
                    'status' => 1,
                    'feature_image' => public_path('/dummy-images/system_images/ai_image.jpg'),
                ],
                [
                    'slug' => 'ai_code',
                    'type' => 'ai_code',
                    'name' => 'AI Code',
                    'description' => 'Unlock the power of AI to revolutionize your codebase, enhancing productivity and unlocking new possibilities in software development.',
                    'status' => 1,
                    'feature_image' => public_path('/dummy-images/system_images/ai_code.jpg'),

                ],
                [
                    'slug' => 'ai_image_text',
                    'type' => 'ai_image_text',
                    'name' => 'AI Image To Text',
                    'description' => "Convert images to text effortlessly with AI, bridging visual content with written communication seamlessly.",
                    'status' => 1,
                    'feature_image' => public_path('/dummy-images/system_images/image_text.jpg'),

                ],
               
                [
                    'slug' => 'ai_chat',
                    'type' => 'ai_chat',
                    'name' => 'AI Chat',
                    'description' => 'AI Chat: Seamlessly interact with virtual agents, experiencing responsive and intuitive dialogue.',
                    'status' => 1,
                    'feature_image' => public_path('/dummy-images/system_images/ai_chat.jpg'),

                ],
               
                
            ];
            foreach ($data as $key => $value) {
                $featureImage = $value['feature_image'] ?? null;
                $service = [
                    'slug' => $value['slug'],
                    'name' => $value['name'],
                    'description' => $value['description'],
                    'type' => $value['type'],
                    'status' => $value['status'],
                ];
                $service = SystemService::create($service);
                if (isset($featureImage)) {
                    $this->attachFeatureImage($service, $featureImage);
                }
            }
        }
        // Enable foreign key checks!
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    private function attachFeatureImage($model, $publicPath)
    {
        if(!env('IS_DUMMY_DATA_IMAGE')) return false;

        $file = new \Illuminate\Http\File($publicPath);

        $media = $model->addMedia($file)->preservingOriginal()->toMediaCollection('feature_image');

        return $media;
    }
}
