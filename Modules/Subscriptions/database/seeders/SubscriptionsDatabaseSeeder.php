<?php

namespace Modules\Subscriptions\database\seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class SubscriptionsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(PlanlimitationTableSeeder::class);
        $this->call(PlanTableSeeder::class);
        $this->call(PlanlimitationMappingTableSeeder::class);
        $this->call(SubscriptionTableSeeder::class);
        $this->call(SubscriptionsTransactionsTableSeeder::class);
    }
}
