<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use GuzzleHttp\Promise\Create;

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

        // オス1,オス2の選択
        Validator::extend(
            'select_male',
            function ($attribute, $value, $parameters, $validator) {
                return $value === strval($value) && $value != '選択してください';
            }
        );

        // オス1,オス2の選択
        Validator::extend(
            'after_add_day',
            function ($attribute, $value, $parameters, $validator) {
                return false;
            }
        );
    }
}
