<?php

namespace App\Providers;

use App\Models\BusinessSetting;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('string_number_allow_only_number_not_allow', function ($attribute, $value, $parameters, $validator) {
            return (preg_match('/[A-Za-z]/', $value) && preg_match('/[0-9]/', $value)) || is_numeric($value);
        });
        $businessSetting = BusinessSetting::first(); // Use the correct model name

        if ($businessSetting) {
            $data = [
                'driver'       => $businessSetting->mail_transport,
                'host'         => $businessSetting->mail_host,
                'port'         => $businessSetting->mail_port,
                'encryption'   => $businessSetting->mail_encryption,
                'username'     => $businessSetting->mail_username,
                'password'     => $businessSetting->mail_password,
                'form'         => [
                    'address' => $businessSetting->mail_from,
                    'name'    => 'LaravelStarter'
                ]
            ];

            config([
                'mail.driver'          => $businessSetting->mail_transport,
                'mail.host'            => $businessSetting->mail_host,
                'mail.port'            => $businessSetting->mail_port,
                'mail.encryption'      => $businessSetting->mail_encryption,
                'mail.username'        => $businessSetting->mail_username,
                'mail.password'        => $businessSetting->mail_password,
                'mail.from.address'    => $businessSetting->mail_from,
                'mail.from.name'       => 'LaravelStarter',
            ]);
        }
    }
}
