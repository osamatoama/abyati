<?php

namespace App\Services\Utils;

class Core
{
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

    public function currentUserId()
    {
        static $currentUserId;

        if ($currentUserId) {
            return $currentUserId;
        }

        return $currentUserId = app()->make('currentUserId');
    }

    public function currentUser()
    {
        static $currentUser;

        if ($currentUser) {
            return $currentUser;
        }

        return $currentUser = app()->make('currentUser');
    }

    public function currentUserIsEmployee()
    {
        return app()->make('currentUserIsEmployee');
    }

    public function currentUserIsMerchant()
    {
        return !app()->make('currentUserIsEmployee');
    }

    // public function whatsAppProvider()
    // {
    //     static $whatsappProvider;

    //     if ($whatsappProvider) {
    //         return $whatsappProvider;
    //     }

    //     return $whatsappProvider = WhatsappFactory::create(config('whatsapp.default_provider'));
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

    // public function websiteSettings(string $key = null)
    // {
    //     $websiteSettings = core()->settings()?->{SettingType::WEBSITE->value};

    //     return $key ? $websiteSettings?->{$key} : $websiteSettings;
    // }
}
