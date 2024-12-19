<?php

use Carbon\Carbon;
use App\Models\User;
use App\Models\Store;
use App\Models\Setting;
use App\Models\Support;
use App\Models\Employee;
use App\Models\OrderItem;
use Illuminate\Support\Arr;
use App\Services\Utils\Core;
use App\Services\Utils\Locale;
use Illuminate\Support\Number;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Milon\Barcode\Facades\DNS1DFacade;

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

if (!function_exists('core')) {
    function core(): Core
    {
        app()->singletonIf(Core::class);

        return app(Core::class);
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

if (! function_exists('getStoreColor')) {
    function getStoreIdColor(string $storeId): string
    {
        $colors = cache()->remember(
            key: Store::CACHE_STORES_ID_COLORS_KEY,
            ttl: 60 * 60,
            callback: fn () => Store::pluck('id_color', 'id')->toArray()
        );

        return $colors[$storeId] ?? Store::DEFAULT_ID_COLOR;
    }
}

if (! function_exists('sortOrderItemsByShelves')) {
    function sortOrderItemsByShelves(Collection $items): Collection
    {
        // Extract aisle, shelf, and shelf_number for sorting
        $items->each(function (OrderItem $item) {
            $shelf = $item->product?->shelves?->first();
            $item->aisle = $shelf?->aisle ?? null;
            $item->shelf = $shelf?->name ?? null;
            $item->shelf_number = filled($item->shelf) ? str($item->shelf)->after($item->aisle)->__toString() : null;
        });

        // Undefined aisles
        $undefinedAisles = $items->whereNull('aisle');

        // Group items by aisles
        $groupedByAisle = $items->whereNotNull('aisle')->groupBy('aisle');
        $sortedAisles = $groupedByAisle->sortKeys()->keys()->toArray();

        // Sort aisles alphabetically but handle sorting inside each aisle
        $sortedItems = $groupedByAisle->sortKeys()->map(function ($group, $aisle) use ($sortedAisles) {
            // Determine sort order based on the aisle's position
            $aisleIndex = array_search($aisle, $sortedAisles);
            $sortOrder = $aisleIndex % 2 === 0 ? 'asc' : 'desc';

            // Sort within the aisle by shelf_number
            return $group->sortBy([
                ['shelf_number', $sortOrder],
            ]);
        });

        // Flatten the sorted groups back into a single collection
        return $sortedItems->flatten()->merge($undefinedAisles);
    }
}

if (! function_exists('settings')) {
    function settings(): mixed
    {
        $settings = cache()->remember(
            key: 'settings',
            ttl: 60 * 60,
            callback: fn () => Setting::get(),
        );

        return $settings;
    }
}

if (! function_exists('generateBarcode')) {
    function generateBarcode($barcode)
    {
        return DNS1DFacade::getBarcodeSVG($barcode, 'PHARMA2T', 3, 33);
        // $d = new DNS2D();
        // $d->setStorPath(public_path('barcodes/'));
        // $barcodeData = $d->getBarcodePNG($ticketNumber, "PDF417");

        // // Decode the base64 data and save it as a PNG file
        // $image = base64_decode($barcodeData);

        // // Define the path to save the image
        // $path = public_path('barcodes/'.$ticketNumber.'.png');

        // // Ensure the directory exists
        // if (!file_exists(dirname($path))) {
        //     mkdir(dirname($path), 0755, true);
        // }

        // // Save the image
        // file_put_contents($path, $image);
    }
}
