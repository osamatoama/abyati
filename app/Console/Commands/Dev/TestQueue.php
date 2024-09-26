<?php

namespace App\Console\Commands\Dev;

use App\Jobs\Dev\TestJob;
use Illuminate\Console\Command;

class TestQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:test-queue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test queue is running';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        dispatch(new TestJob);
        $this->info('Job dispatched to queue');
    }
}
