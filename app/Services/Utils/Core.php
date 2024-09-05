<?php

namespace App\Services\Utils;

use App\Enums\SettingType;
use App\Services\Whatsapp\WhatsappFactory;

class Core
{
    /**
     * @param string|null $date
     * @return null[]
     */
    public function getDateFromFlatpickrRange($date): array
    {
        $from = null;
        $to = null;
        $localeDelimiter = match (app()->getLocale()) {
            'ar' => ' إلى ',
            'en' => ' to ',
            default => ' to ',
        };

        if ($date) {
            $date = explode($localeDelimiter, $date);
            $from = $date[0] ?? null;
            $to = $date[1] ?? null;
        }

        return [
            'from' => $from,
            'to' => $to,
        ];
    }

    /**
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function currentUserId()
    {
        static $currentUserId;

        if ($currentUserId) {
            return $currentUserId;
        }

        return $currentUserId = app()->make('currentUserId');
    }

    /**
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function currentUser()
    {
        static $currentUser;

        if ($currentUser) {
            return $currentUser;
        }

        return $currentUser = app()->make('currentUser');
    }

    /**
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function currentUserIsEmployee()
    {
        return app()->make('currentUserIsEmployee');
    }

    /**
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function currentUserIsMerchant()
    {
        return !app()->make('currentUserIsEmployee');
    }

    /**
     * @return \App\Services\Whatsapp\Providers\WhatsappProvider|mixed
     */
    public function whatsAppProvider()
    {
        static $whatsappProvider;

        if ($whatsappProvider) {
            return $whatsappProvider;
        }

        return $whatsappProvider = WhatsappFactory::create(config('whatsapp.default_provider'));
    }

    // public function returnSettings(string $key = null)
    // {
    //     static $returnSettings;

    //     if ($returnSettings) {
    //         return $key ? $returnSettings?->{$key} : $returnSettings;
    //     }

    //     app()->singletonIf('returnSettings', function () {
    //         try {
    //             $user = core()->currentUser();
    //         } catch (\Throwable $th) {
    //             throw new \Exception("Can't get return settings for no user");
    //         }

    //         return $user?->returnSetting;
    //     });

    //     $returnSettings = app()->make('returnSettings');

    //     return $key ? $returnSettings?->{$key} : $returnSettings;
    // }

    // public function exchangeSettings(string $key = null)
    // {
    //     static $exchangeSettings;

    //     if ($exchangeSettings) {
    //         return $key ? $exchangeSettings?->{$key} : $exchangeSettings;
    //     }

    //     app()->singletonIf('exchangeSettings', function () {
    //         try {
    //             $user = core()->currentUser();
    //         } catch (\Throwable $th) {
    //             throw new \Exception("Can't get exchange settings for no user");
    //         }

    //         return $user?->exchangeSetting;
    //     });

    //     $exchangeSettings = app()->make('exchangeSettings');

    //     return $key ? $exchangeSettings?->{$key} : $exchangeSettings;
    // }

    public function settings(string $key = null)
    {
        static $settings;

        if ($settings) {
            return $key ? $settings?->{$key} : $settings;
        }

        app()->singletonIf('settings', function () {
            try {
                $user = core()->currentUser();
            } catch (\Throwable $th) {
                throw new \Exception("Can't get settings for no user");
            }

            return nestedArrToObject(
                $user?->settings
                    ->groupBy(['type'])
                    ->map(function($group) {
                        return $group->pluck('value', 'key');
                    })
                    ->toArray()
            );
        });

        $settings = app()->make('settings');

        return $key ? $settings?->{$key} : $settings;
    }

    public function returnSettings(string $key = null)
    {
        $returnSettings = core()->settings()?->{SettingType::RETURN->value};

        return $key ? $returnSettings?->{$key} : $returnSettings;
    }

    public function exchangeSettings(string $key = null)
    {
        $exchangeSettings = core()->settings()?->{SettingType::EXCHANGE->value};

        return $key ? $exchangeSettings?->{$key} : $exchangeSettings;
    }

    public function websiteSettings(string $key = null)
    {
        $websiteSettings = core()->settings()?->{SettingType::WEBSITE->value};

        return $key ? $websiteSettings?->{$key} : $websiteSettings;
    }

    public function domainSettings(string $key = null)
    {
        $domainSettings = core()->settings()?->{SettingType::DOMAIN->value};

        return $key ? $domainSettings?->{$key} : $domainSettings;
    }

    public function shippingSettings(string $key = null)
    {
        $shippingSettings = core()->settings()?->{SettingType::SHIPPING->value};

        return $key ? $shippingSettings?->{$key} : $shippingSettings;
    }
}
