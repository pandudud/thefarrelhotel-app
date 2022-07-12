<?php

namespace TheFarrelHotel\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Route::resourceVerbs([
            'create' => 'tambah',
            'edit' => 'ubah',
        ]);
        \Validator::extend('no_spaces', function($attr, $value){
            return preg_match('/^\S*$/u', $value);
        });
        \Validator::extend('old_password', function ($attribute, $value, $parameters, $validator) {
            return \Hash::check($value, current($parameters));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        setlocale(LC_TIME, config('app.locale'));
        Schema::defaultStringLength(191);
    }
}
