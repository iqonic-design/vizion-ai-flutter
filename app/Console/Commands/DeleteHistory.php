<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\History;
use Carbon\Carbon;
class DeleteHistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:history';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Get the date 7 days ago
        $sevenDaysAgo = Carbon::now()->subDays(7);

        // Retrieve old History records
        $oldHistoryRecords = History::where('created_at', '<', $sevenDaysAgo)->get();
        \Log::info('Delete History : -  '.$oldHistoryRecords);
        // Loop through each old History record
        foreach ($oldHistoryRecords as $historyRecord) {
            // Delete related HistoryImageMapping records
            $historyRecord->historyimage()->delete();

            // Delete the History record
            $historyRecord->delete();
        }

        $this->info('Old data has been deleted successfully.');
    }
}
