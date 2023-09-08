<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

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
    }
}
