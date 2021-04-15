<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelpersProvider extends ServiceProvider
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
        require __DIR__.'/../Helpers/autoload.php';
    }
}
