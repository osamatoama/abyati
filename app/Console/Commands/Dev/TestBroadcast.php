<?php

namespace App\Console\Commands\Dev;

use Illuminate\Console\Command;
use App\Events\Dev\TestBroadcastPublicEvent;

class TestBroadcast extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:test-broadcast';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test broadcast is running';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        event(new TestBroadcastPublicEvent);
    }
}
