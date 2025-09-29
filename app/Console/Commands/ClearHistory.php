<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearHistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clearHistory';

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
        
        $thresholdDate = Carbon::now()->subDays(7);

        $histrot_ids=History::where('created_at', '<', $thresholdDate)->pluck('id');

        History::whereIn('id',$histroy_id)->delete();

        HistroyImageMapping::whereIn('history_id',$histroy_id)->delete();


        exit;
      
    }
}
