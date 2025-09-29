<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SubscriptionsTransactionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('subscriptions_transactions')->delete();
        
        \DB::table('subscriptions_transactions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'subscriptions_id' => 1,
                'user_id' => 3,
                'amount' => 0,
                'payment_type' => 'stripe',
                'payment_status' => 'paid',
                'transaction_id' => 'pi_1OnGh1FTMa5P8ht0pEWTzG1e',
                'other_transactions_details' => NULL,
                'created_by' => 3,
                'updated_by' => 3,
                'deleted_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-02-24 08:35:14',
                'updated_at' => '2024-02-24 08:35:14',
            ),
            1 => 
            array (
                'id' => 2,
                'subscriptions_id' => 2,
                'user_id' => 4,
                'amount' => 0,
                'payment_type' => 'stripe',
                'payment_status' => 'paid',
                'transaction_id' => 'pi_1OnGpRFTMa5P8ht0g6ohV6ua',
                'other_transactions_details' => NULL,
                'created_by' => 4,
                'updated_by' => 4,
                'deleted_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-02-24 08:44:03',
                'updated_at' => '2024-02-24 08:44:03',
            ),
            2 => 
            array (
                'id' => 3,
                'subscriptions_id' => 3,
                'user_id' => 5,
                'amount' => 0,
                'payment_type' => 'stripe',
                'payment_status' => 'paid',
                'transaction_id' => 'pi_1OnH4yFTMa5P8ht05TMPnJmI',
                'other_transactions_details' => NULL,
                'created_by' => 5,
                'updated_by' => 5,
                'deleted_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-02-24 08:59:59',
                'updated_at' => '2024-02-24 08:59:59',
            ),
            3 => 
            array (
                'id' => 4,
                'subscriptions_id' => 4,
                'user_id' => 6,
                'amount' => 0,
                'payment_type' => 'stripe',
                'payment_status' => 'paid',
                'transaction_id' => 'pi_1OnH7aFTMa5P8ht0MZopyOgk',
                'other_transactions_details' => NULL,
                'created_by' => 6,
                'updated_by' => 6,
                'deleted_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-02-24 09:02:40',
                'updated_at' => '2024-02-24 09:02:40',
            ),
            4 => 
            array (
                'id' => 5,
                'subscriptions_id' => 5,
                'user_id' => 12,
                'amount' => 0,
                'payment_type' => 'stripe',
                'payment_status' => 'paid',
                'transaction_id' => 'pi_1OnH9DFTMa5P8ht0qlv5eOGL',
                'other_transactions_details' => NULL,
                'created_by' => 12,
                'updated_by' => 12,
                'deleted_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-02-24 09:04:21',
                'updated_at' => '2024-02-24 09:04:21',
            ),
            5 => 
            array (
                'id' => 6,
                'subscriptions_id' => 6,
                'user_id' => 9,
                'amount' => 0,
                'payment_type' => 'stripe',
                'payment_status' => 'paid',
                'transaction_id' => 'pi_1OnHBYFTMa5P8ht0UJGfnyw6',
                'other_transactions_details' => NULL,
                'created_by' => 9,
                'updated_by' => 9,
                'deleted_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-02-24 09:06:47',
                'updated_at' => '2024-02-24 09:06:47',
            ),
            6 => 
            array (
                'id' => 7,
                'subscriptions_id' => 7,
                'user_id' => 7,
                'amount' => 0,
                'payment_type' => 'stripe',
                'payment_status' => 'paid',
                'transaction_id' => 'pi_1OnHDkFTMa5P8ht0ZCk4sP0K',
                'other_transactions_details' => NULL,
                'created_by' => 7,
                'updated_by' => 7,
                'deleted_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-02-24 09:09:03',
                'updated_at' => '2024-02-24 09:09:03',
            ),
            7 => 
            array (
                'id' => 8,
                'subscriptions_id' => 8,
                'user_id' => 11,
                'amount' => 0,
                'payment_type' => 'stripe',
                'payment_status' => 'paid',
                'transaction_id' => 'pi_1OnHFkFTMa5P8ht0Z6WoJkPi',
                'other_transactions_details' => NULL,
                'created_by' => 11,
                'updated_by' => 11,
                'deleted_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-02-24 09:11:07',
                'updated_at' => '2024-02-24 09:11:07',
            ),
        ));
        
        
    }
}