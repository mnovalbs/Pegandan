<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
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
        Schema::defaultStringLength(191);

        \Response::macro('api', function($code, $data, $message = '') {
            $res = [
                'meta' => [
                    'code' => $code
                ],
                'data' => $data,
                'message' => $message
            ];
            return response()->json($res, $code);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    
}
