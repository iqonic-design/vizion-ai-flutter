<?php

namespace Modules\CustomTemplate\Console\Commands;

use Illuminate\Console\Command;

class CustomTemplateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:CustomTemplateCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'CustomTemplate Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return Command::SUCCESS;
    }
}
