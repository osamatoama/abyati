<?php

namespace App\Console\Commands\Dev;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TruncateFailedJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:truncate-failed-jobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncate failed jobs after pre-live tests';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $this->error("Can't run this command outside dev env");
        // return;

        $this->info('Truncating failed jobs...');

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        DB::table('failed_jobs')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
