<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Subscriptions\Models\Subscription;
use App\Mail\ExpiringSubscriptionEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Carbon\Carbon;

class SendSubscriptionNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $expiryThreshold = Carbon::now()->addDays(7);
        $userIds = Subscription::where('status', 'active')
            ->where('end_date', '<=', $expiryThreshold)
            ->pluck('user_id')
            ->toArray();
        // Get users with the retrieved user IDs
        $users = User::whereIn('id', $userIds)->get();
        foreach ($users as $user) {
            // Customize email send
            Mail::to($user->email)->send(new ExpiringSubscriptionEmail($user));
        }

        $this->info('Subscription notifications sent successfully.');
    }
}
