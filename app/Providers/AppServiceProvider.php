<?php

namespace App\Providers;

use App\Example;
use App\Cservice;
use App\ExampleInner;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind('App\Example',function ()
        {
            $foo=new ExampleInner();
            $a='1';

            return new Example($foo,$a);

        });

        // bind singleton crypto pro service to config
        $this->app->singleton(Cservice::class, function ($app) {
            return new Cservice(config('app.cspservice', 'http://cryptopro:8080/'));
        });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
