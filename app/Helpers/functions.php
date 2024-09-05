<?php

use Carbon\Carbon;
use App\Models\User;
use App\Models\Support;
use App\Models\Employee;
use Illuminate\Support\Arr;
use App\Services\Utils\Locale;
use Illuminate\Support\Number;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

if (! function_exists('formatCurrency')) {
    function formatCurrency($amount, $currency = 'SAR')
    {
        $formattedAmount = number_format(
            num: $amount,
            decimals: (is_numeric($amount) && $amount == floor($amount)) ? 0 : 2
        );
        $currencySymbol = str(Number::currency(1, $currency, app()->getLocale()))
            ->before('1.00')
            ->after('١٫٠٠')
            ->trim();

        return $formattedAmount . ' ' . $currencySymbol;
    }
}

if (! function_exists('formatPercentage')) {
    function formatPercentage($amount)
    {
        $formattedAmount = number_format(
            num: $amount,
            decimals: (is_numeric($amount) && $amount == floor($amount)) ? 0 : 2
        );

        return $formattedAmount . '%';
    }
}

if (!function_exists('locale')) {
    function locale(): Locale
    {
        app()->singletonIf(Locale::class);

        return app(Locale::class);
    }
}

if (!function_exists('can')) {
    function can($permission)
    {
        $user = user();

        if ($user instanceof (User::class)) {
            return true;
        }

        return $user->can($permission);
    }
}

if (!function_exists('canAny')) {
    function canAny(array $permissions)
    {
        $user = user();

        if ($user instanceof (User::class)) {
            return true;
        }

        return $user->canAny($permissions);
    }
}

if (!function_exists('carbon')) {
    function carbon(string|int $datetime): Carbon
    {
        return Carbon::parse($datetime);
    }
}

if (!function_exists('isJson')) {
    function isJson($string): bool
    {
        if (is_string($string)) {
            json_decode($string);
        } else if (is_array($string)) {
            return true;
        }

        return json_last_error() === JSON_ERROR_NONE;
    }
}

if (!function_exists('nestedArrToObject')) {
    function nestedArrToObject(array $nestedArr): object
    {
        if (empty($nestedArr)) {
            return new stdClass;
        }

        return json_decode(json_encode($nestedArr));
    }
}


if (! function_exists('enableQueryLog')) {
    function enableQueryLog()
    {
        DB::enableQueryLog();
    }
}

if (! function_exists('getQueryLog')) {
    function getQueryLog()
    {
        return  DB::getQueryLog();
    }
}

if (! function_exists('saveQueryLogAsJson')) {
    function saveQueryLogAsJson()
    {
        file_put_contents(public_path('debug/query-log.json'), json_encode(getQueryLog()));
    }
}

if (! function_exists('getExcelFileName')) {
    function getExcelFileName(string $type) : string
    {
        $time = now()->format('Y-m-d-h-i-s');

        return "$type-$time.xlsx";
    }
}

if (!function_exists('query')) {
    function query(...$params): array
    {
        if (empty($params)) {
            return request()->query();
        }

        return Arr::only(request()->query(), $params);
    }
}

if (!function_exists('queryToString')) {
    function queryToString(...$params): string
    {
        $query = query(...$params);

        $queryStr = '';
        if(filled($query)) {
            foreach ($query as $key => $val) {
                $query[$key] = "$key=$val";
            }

            $queryStr = '?' . implode('&', $query);
        }

        return $queryStr;
    }
}

if (! function_exists('arrayFilterNull')) {
    function arrayFilterNull(array $arr): array
    {
        return array_filter($arr, fn($el) => $el !== null);
    }
}

if (! function_exists('arrayFilterEmpty')) {
    function arrayFilterEmpty(array $arr): array
    {
        return array_filter($arr, fn($el) => ! empty($el));
    }
}

if (! function_exists('logError')) {
    function logError(mixed $data): void
    {
        Log::error($data);
    }
}

if (! function_exists('siteTitle')) {
    function siteTitle(string $lang = null): string
    {
        $locale = $lang ?? locale()->current();

        return ($locale === 'en') ? config('app.name') : config('app.name_ar');
    }
}

if (! function_exists('currentUser')) {
    function currentUser()
    {
        static $currentUser;

        if ($currentUser) {
            return $currentUser;
        }

        return $currentUser = app()->make('currentUser');
    }
}

if (! function_exists('assetCustom')) {
    function assetCustom(string $asset): string
    {
        if (request()->secure()) {
            return asset($asset, true);
        }

        return asset($asset);
    }
}

if (! function_exists('boolToYesNo')) {
    function boolToYesNo(mixed $var): string
    {
        return $var ? __('globals.yes') : __('globals.no');
    }
}

if (! function_exists('boolToYesNoBadge')) {
    function boolToYesNoBadge(mixed $var): string
    {
        return $var ?
            "<span class='badge badge-success'>" . __('globals.yes') . "</span>" :
            "<span class='badge badge-danger'>" . __('globals.no') . "</span>";
    }
}

if (! function_exists('boolToYesNoSymbol')) {
    function boolToYesNoSymbol(mixed $var): string
    {
        return $var ?
            "<span class='badge badge-success'><i class='fas fa-check text-white'></i></span>" :
            "<span class='badge badge-danger'><i class='fas fa-xmark text-white'></i></span>";
    }
}

if (! function_exists('user')) {
    function user(): User|Employee|Support|null
    {
        return Auth::user();
    }
}

if (! function_exists('lang')) {
    function lang(string $key, string $default = null): string
    {
        if (Lang::has($key)) {
            return __($key);
        }

        if ($default) {
            return $default;
        }

        return str($key)->afterLast('.');
    }
}

if (! function_exists('trimFileName')) {
    function trimFileName(string $fileName): string
    {
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);

        return str($fileName)->limit(10) . '...' . $extension;
    }
}
