<?php

namespace App\Jobs\Concerns;

use Exception;

trait HandleExceptions
{
    public int $tries = 2;
    public bool $logWhenFail = true;
    public int $secondsBetweenTries = 30;

    protected function handleException(?Exception $exception = null): void
    {
        if ($this->attempts() < $this->tries) {
            $this->release(
                now()->addSeconds(
                    $this->tryAfterInSeconds(),
                ),
            );
        } else {
            $this->logAndFail($exception);
        }
    }

    public function logAndFail($exception = null): void
    {
        if ($this->logWhenFail) {
            logError($exception);
        }

        $this->fail($exception);
    }

    protected function tryAfterInSeconds(): int
    {
        return app()->isProduction() ? $this->secondsBetweenTries : 0;
    }
}
