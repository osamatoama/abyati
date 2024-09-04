<?php

namespace App\Console\Commands\Dev;

use App\Jobs\Dev\TestMailJob;
use Illuminate\Console\Command;

class TestMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:test-mail {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test mail command for checking email account credentials';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?? 'kareemmfouad.dev@gmail.com';

        dispatch(new TestMailJob($email));
        $this->info('Sending mail dispatched');
    }
}
