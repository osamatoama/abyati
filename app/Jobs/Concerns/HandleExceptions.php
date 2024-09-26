<?php

namespace App\Jobs\Concerns;

use Throwable;

trait HandleExceptions
{
    public int $tries = 10;

    public ?int $maxAttempts = null;

    public bool $shouldLog = true;

    public bool $onlyLogWhenFail = true;

    public bool $failIfDelayIsNull = true;

    public bool $appendExceptionToContext = false;

    protected function handleException(Throwable $exception, bool $fail = false, ?int $delay = null): void
    {
        if ($this->shouldLog && ! $this->onlyLogWhenFail) {
            $this->logException(
                exception: $exception,
            );
        }

        $delay ??= $this->getDelayInSeconds(
            code: $exception->getCode(),
        );

        if ($this->shouldFail(
            fail: $fail,
            delay: $delay,
        )) {
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

        $this->release(
            delay: $delay,
        );
    }

    protected function getDelayInSeconds(int|string $code): ?int
    {
        return match ($code) {
            401 => null,
            429 => 60,
            default => 0,
        };
    }

    protected function shouldFail(bool $fail, ?int $delay): bool
    {
        if ($fail || $this->isAttemptedTooManyTimes()) {
            return true;
        }

        if ($this->failIfDelayIsNull && $delay === null) {
            return true;
        }

        return false;
    }

    protected function isAttemptedTooManyTimes(): bool
    {
        if ($this->attempts() >= ($this->tries - 1)) {
            return true;
        }

        return $this->maxAttempts !== null && $this->attempts() >= $this->maxAttempts;
    }

    protected function logException(Throwable $exception): void
    {
        $context = method_exists(
            object_or_class: $exception,
            method: 'context',
        ) ? $exception->context() : [];

        $context = $this->appendExceptionToContext ? array_merge_recursive(
            [
                'exception' => $exception,
            ],
            $context,
        ) : $context;

        logger()->error(
            message: $exception->getMessage(),
            context: $context,
        );
    }

    protected function disableLog(bool $condition = true): void
    {
        $this->shouldLog = ! $condition;
    }
}
