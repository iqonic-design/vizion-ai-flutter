<?php

namespace Database\Seeders\Auth;

use App\Events\Backend\UserCreated;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Arr;
use App\Models\Address;

/**
 * Class UserTableSeeder.
 */
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        // Add the master administrator, user id of 1
        $avatarPath = config('app.avatar_base_path');


        $users = [
            [
              'first_name' => 'Super',
              'last_name' => 'Admin',
              'email' => 'admin@vizion.com',
              'password' => Hash::make('12345678'),
              'mobile' => '44-5289568745',
              'date_of_birth' => fake()->date,
              'avatar' => $avatarPath.'male.webp',
              'profile_image' => public_path('/dummy-images/profile/Admin/super_admin.png'),
              'gender' => 'male',
              'email_verified_at' => Carbon::now(),
              'created_at' => Carbon::now(),
              'updated_at' => Carbon::now(),
              'user_type' => 'admin',
            ],
            [
              'first_name' => 'Demo',
              'last_name' => 'Admin',
              'email' => 'demo@vizion.com',
              'password' => Hash::make('12345678'),
              'mobile' => '44-5289568745',
              'date_of_birth' => fake()->date,
              'avatar' => $avatarPath.'male.webp',
              'profile_image' => public_path('/dummy-images/profile/Admin/super_admin.png'),
              'gender' => 'male',
              'email_verified_at' => Carbon::now(),
              'created_at' => Carbon::now(),
              'updated_at' => Carbon::now(),
              'user_type' => 'demo_admin',
            ],
            [
                'first_name' => 'Felix',
                'last_name' => 'Harris',
                'email' => 'felix@gmail.com',
                'password' => Hash::make('12345678'),
                'mobile' => '1-4578952512',
                'date_of_birth' => fake()->date,
                'profile_image' => public_path('/dummy-images/profile/owner/felix.png'),
                'avatar' => $avatarPath.'male.webp',
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_type' => 'user',
                'address' => [
                  [
                    'postal_code' => '445632',
                    'address_line_1' => '23, Square Street',
                    'address_line_2' => 'Near Sea View Point',
                    'city' =>  10001,
                    'state' => 3866,
                    'country' => 230,
                  ],
                  [
                    'postal_code' => '442387',
                    'address_line_1' => '3, Hill Street',
                    'address_line_2' => 'Near Mile View Building',
                    'city' =>  10002,
                    'state' => 3866,
                    'country' => 230,
                  ]
                ]
              ],
              [
                'first_name' => 'Andrew',
                'last_name' => 'Rhodes',
                'email' => 'andrew@gmail.com',
                'password' => Hash::make('12345678'),
                'mobile' => '1-7485961545',
                'date_of_birth' => fake()->date,
                'avatar' => $avatarPath.'male.webp',
                'profile_image' => public_path('/dummy-images/profile/owner/andrew.png'),
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'created_at' => '2024-01-20 09:11:07',
                'updated_at' => Carbon::now(),
              'user_type' => 'user',

            ],
            [
              'first_name' => 'Jennifer',
              'last_name' => 'Davis',
              'email' => 'jennifer@gmail.com',
              'password' => Hash::make('12345678'),
              'mobile' => '1-7485961545',
              'date_of_birth' => fake()->date,
              'avatar' => $avatarPath.'male.webp',
              'profile_image' => public_path('/dummy-images/profile/owner/jennifer.png'),
              'gender' => 'male',
              'email_verified_at' => Carbon::now(),
              'created_at' => '2024-01-22 09:11:07',
              'updated_at' => Carbon::now(),
            'user_type' => 'user',

            ],
            [
              'first_name' => 'Danny',
              'last_name' => 'Mark',
              'email' => 'danny@gmail.com',
              'password' => Hash::make('12345678'),
              'mobile' => '1-7485961545',
              'date_of_birth' => fake()->date,
              'avatar' => $avatarPath.'male.webp',
              'profile_image' => public_path('/dummy-images/profile/owner/danny.png'),
              'gender' => 'male',
              'email_verified_at' => Carbon::now(),
              'created_at' => '2024-01-29 09:11:07',
              'updated_at' => Carbon::now(),
            'user_type' => 'user',

            ],
            [
              'first_name' => 'Kahlil',
              'last_name' => 'Graham',
              'email' => 'kahil@gmail.com',
              'password' => Hash::make('12345678'),
              'mobile' => '1-7485961545',
              'date_of_birth' => fake()->date,
              'avatar' => $avatarPath.'male.webp',
              'profile_image' => public_path('/dummy-images/profile/owner/kahil.png'),
              'gender' => 'male',
              'email_verified_at' => Carbon::now(),
              'created_at' => '2024-01-31 09:11:07',
              'updated_at' => Carbon::now(),
            'user_type' => 'user',

            ],
            [
              'first_name' => 'Beverly',
              'last_name' => 'Mendiz',
              'email' => 'beverly@gmail.com',
              'password' => Hash::make('12345678'),
              'mobile' => '1-7485961545',
              'date_of_birth' => fake()->date,
              'avatar' => $avatarPath.'male.webp',
              'profile_image' => public_path('/dummy-images/profile/owner/beverly.png'),
              'gender' => 'male',
              'email_verified_at' => Carbon::now(),
              'created_at' => '2024-02-02 09:11:07',
              'updated_at' => Carbon::now(),
            'user_type' => 'user',

            ],
            [
              'first_name' => 'Erik',
              'last_name' => 'Simon',
              'email' => 'erik@gmail.com',
              'password' => Hash::make('12345678'),
              'mobile' => '1-7485961545',
              'date_of_birth' => fake()->date,
              'avatar' => $avatarPath.'male.webp',
              'profile_image' => public_path('/dummy-images/profile/owner/erik.png'),
              'gender' => 'male',
              'email_verified_at' => Carbon::now(),
              'created_at' => '2024-02-08 09:11:07',
              'updated_at' => Carbon::now(),
            'user_type' => 'user',

            ],
            [
              'first_name' => 'Ricahard',
              'last_name' => 'Gross',
              'email' => 'richard@gmail.com',
              'password' => Hash::make('12345678'),
              'mobile' => '1-7485961545',
              'date_of_birth' => fake()->date,
              'avatar' => $avatarPath.'male.webp',
              'profile_image' => public_path('/dummy-images/profile/owner/richard.png'),
              'gender' => 'male',
              'email_verified_at' => Carbon::now(),
              'created_at' => '2024-02-13 09:11:07',
              'updated_at' => Carbon::now(),
            'user_type' => 'user',

            ],
            [
              'first_name' => 'Venesa',
              'last_name' => 'Shaw',
              'email' => 'venesa@gmail.com',
              'password' => Hash::make('12345678'),
              'mobile' => '1-7485961545',
              'date_of_birth' => fake()->date,
              'avatar' => $avatarPath.'male.webp',
              'profile_image' => public_path('/dummy-images/profile/owner/venesa.png'),
              'gender' => 'male',
              'email_verified_at' => Carbon::now(),
              'created_at' => '2024-02-18 09:11:07',
              'updated_at' => Carbon::now(),
            'user_type' => 'user',

            ],
            [
              'first_name' => 'Jorge',
              'last_name' => 'Perez',
              'email' => 'jorge@gmail.com',
              'password' => Hash::make('12345678'),
              'mobile' => '1-7485961545',
              'date_of_birth' => fake()->date,
              'avatar' => $avatarPath.'male.webp',
              'profile_image' => public_path('/dummy-images/profile/owner/jorge.png'),
              'gender' => 'male',
              'email_verified_at' => Carbon::now(),
              'created_at' => '2024-02-22 09:11:07',
              'updated_at' => Carbon::now(),
            'user_type' => 'user',

            ],
            [
              'first_name' => 'Daniel',
              'last_name' => 'Wiliams',
              'email' => 'daniel@gmail.com',
              'password' => Hash::make('12345678'),
              'mobile' => '1-7485961545',
              'date_of_birth' => fake()->date,
              'avatar' => $avatarPath.'male.webp',
              'profile_image' => public_path('/dummy-images/profile/owner/daniel.png'),
              'gender' => 'male',
              'email_verified_at' => Carbon::now(),
              'created_at' => '2024-02-24 09:11:07',
              'updated_at' => Carbon::now(),
            'user_type' => 'user',

            ],
            [
              'first_name' => 'Katie',
              'last_name' => 'Brown',
              'email' => 'katie@gmail.com',
              'password' => Hash::make('12345678'),
              'mobile' => '1-7485961545',
              'date_of_birth' => fake()->date,
              'avatar' => $avatarPath.'male.webp',
              'profile_image' => public_path('/dummy-images/profile/owner/katie.png'),
              'gender' => 'male',
              'email_verified_at' => Carbon::now(),
              'created_at' => '2024-02-29 09:11:07',
              'updated_at' => Carbon::now(),
            'user_type' => 'user',

            ],


        ];

        if (env('IS_DUMMY_DATA')) {
          foreach ($users as $key => $user_data) {
              $featureImage = $user_data['profile_image'] ?? null;
              $userData = Arr::except($user_data, ['profile_image','address']);
              $user = User::create($userData);

              if (isset($user_data['address'])) {
                $addresses = $user_data['address'];

                foreach($addresses as $addressData){
                    $address = new Address($addressData);
                    $user->address()->save($address);
                }
              }

              $user->assignRole($user_data['user_type']);


              event(new UserCreated($user));
              if (isset($featureImage)) {
                  $this->attachFeatureImage($user, $featureImage);
              }
          }
          if (env('IS_FAKE_DATA')) {
            User::factory()->count(30)->create()->each(function ($user){
              $user->assignRole('user');
              $img = public_path('/dummy-images/customers/'.fake()->numberBetween(1,13).'.webp');
              $this->attachFeatureImage($user, $img);
            });
          }
      }


        Schema::enableForeignKeyConstraints();
    }

    private function attachFeatureImage($model, $publicPath)
    {
        if(!env('IS_DUMMY_DATA_IMAGE')) return false;

        $file = new \Illuminate\Http\File($publicPath);

        $media = $model->addMedia($file)->preservingOriginal()->toMediaCollection('profile_image');

        return $media;
    }
}
