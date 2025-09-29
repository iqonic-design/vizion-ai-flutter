<?php

namespace Modules\Category\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Modules\Category\Models\Category;

class CategoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (env('IS_DUMMY_DATA')) {
            $data = [
               
                [
                    'slug' => 'blog',
                    'name' => 'Blog',
                    'status' => 1,
                    'feature_image' => public_path('/dummy-images/category-images/blog.jpg'),
                    'type' => 'ai_writer'
                ],
                [
                    'slug' => 'development',
                    'name' => 'Development',
                    'status' => 1,
                    'feature_image' => public_path('/dummy-images/category-images/devlopment.jpg'),
                    'type' => 'ai_writer'
                ],
                [
                    'slug' => 'advertisement',
                    'name' => 'Advertisement',
                    'status' => 1,
                    'feature_image' => public_path('/dummy-images/category-images/Advertisement.jpg'),
                    'type' => 'ai_writer'
                ],
                [
                    'slug' => 'social-media',
                    'name' => 'Social media',
                    'status' => 1,
                    'feature_image' => public_path('/dummy-images/category-images/Social-media.jpg'),
                    'type' => 'ai_writer'
                ],


                // Ai Image

                [
                    'slug' => 'photo_enhancer',
                    'name' => 'Photo Enhancer',
                    'status' => 1,
                    'feature_image' => public_path('/dummy-images/category-images/Photo-Enhancer.jpg'),
                    'type' => 'ai_image'
                ],
                [
                    'slug' => 'face_enhancer',
                    'name' => 'Face Enhancer',
                    'status' => 1,
                    'feature_image' => public_path('/dummy-images/category-images/Face-Enhancer.jpg'),
                    'type' => 'ai_image'
                ],


            ];
            foreach ($data as $key => $val) {
                // $subCategorys = $val['sub_category'];
                $featureImage = $val['feature_image'] ?? null;
                $categoryData = Arr::except($val, ['sub_category', 'feature_image']);
                $category = Category::create($categoryData);
                if (isset($featureImage)) {
                    $this->attachFeatureImage($category, $featureImage);
                }
                if(!empty($subCategorys)){
                    foreach ($subCategorys as $subKey => $subCategory) {
                        $subCategory['parent_id'] = $category->id;
                        $featureImage = $subCategory['feature_image'] ?? null;
                        $sub_categoryData = Arr::except($subCategory, ['feature_image']);
                        $subcategoryData = Category::create($sub_categoryData);
                        if (isset($featureImage)) {
                            $this->attachFeatureImage($subcategoryData, $featureImage);
                        }
                    }
                }
             
            }
        }
    }

    private function attachFeatureImage($model, $publicPath)
    {
        if(!env('IS_DUMMY_DATA_IMAGE')) return false;

        $file = new \Illuminate\Http\File($publicPath);

        $media = $model->addMedia($file)->preservingOriginal()->toMediaCollection('feature_image');

        return $media;

    }
}
