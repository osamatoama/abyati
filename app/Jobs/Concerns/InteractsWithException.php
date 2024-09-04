<?php

namespace App\Jobs\Concerns;

use Exception;

trait InteractsWithException
{
    public int $tries = 255;

    public ?int $maxAttempts = null;

    public bool $shouldLog = true;

    public bool $onlyLogWhenFail = true;

    protected function handleException(Exception $exception, bool $fail = false, ?int $delay = null): void
    {
        if ($this->shouldLog && ! $this->onlyLogWhenFail) {
            $this->logException(
                exception: $exception,
            );
        }

        if ($fail || $this->isAttemptedTooManyTimes()) {
            if ($this->shouldLog && $this->onlyLogWhenFail) {
                $this->logException(
                    exception: $exception,
                );
            }

            $this->fail(
                exception: $exception,
            );

            return;
        }

        $delay ??= $this->getDelayInSeconds(
            code: $exception->getCode(),
        );

        $this->release(
            delay: $delay,
        );
    }

    protected function isAttemptedTooManyTimes(): bool
    {
        if ($this->attempts() > 250) {
            return true;
        }

        return $this->maxAttempts !== null && $this->attempts() >= $this->maxAttempts;
    }

    protected function getDelayInSeconds(int $code): int
    {
        return match ($code) {
            429 => 60,
            default => 0,
        };
    }

    protected function logException(Exception $exception): void
    {
        logger()->error(
            message: $exception->getMessage(),
            context: [
                'code' => $exception->getCode(),
            ],
        );
    }
}
