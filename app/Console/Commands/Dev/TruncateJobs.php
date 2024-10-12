<?php

namespace App\Console\Commands\Dev;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TruncateJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:truncate-jobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncate jobs after pre-live tests';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (app()->isProduction()) {
            $this->error("Can't run this command outside dev env");
            return;
        }

        $this->info('Truncating jobs...');

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        DB::table('jobs')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
