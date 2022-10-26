<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class ValidatorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend(
            'zipcode',
            function ($attribute, $value, $parameters, $validator) {
                return preg_match('/^[0-9]{3}-?[0-9]{4}$/', $value);
            }
        );

        Validator::extend(
            'individual_num',
            function ($attribute, $value, $parameters, $validator) {
                return $value === strval($value) && $value != '選択してください';
            }
        );
    }
}
