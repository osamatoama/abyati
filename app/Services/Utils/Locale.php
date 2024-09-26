<?php

namespace App\Services\Utils;

use Illuminate\Support\Collection;

class Locale
{
    protected Collection $rtlLocales;

    public function __construct()
    {
        $this->rtlLocales = $this->getRtlLocales();
    }

    public function available(): Collection
    {
        return collect(config('locales'));
    }

    public function count(): int
    {
        return $this->available()->count();
    }

    public function current(bool $upper = false): string
    {
        $locale = app()->getLocale();
        if ($upper) {
            $locale = str($locale)->upper();
        }

        return $locale ?? config('app.locale');
    }

    public function currentNative(): string
    {
        return $this->available()[$this->current()]['native'] ?? '';
    }

    public function isCurrent(string $locale): bool
    {
        return $locale === $this->current();
    }

    public function direction(): string
    {
        return $this->available()[$this->current()]['dir'] ?? 'rtl';
    }

    public function isRtl(?string $locale = null): bool
    {
        $locale ??= $this->current();

        return $this->rtlLocales->contains($locale);
    }

    protected function getRtlLocales(): Collection
    {
        return $this->available()->whereIn('dir', 'rtl')->keys();
    }
}
