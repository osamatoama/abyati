<?php

namespace App\Console\Commands\Dev;

use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test command for development';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        logger()->debug("Test command at " . now());
    }
}
