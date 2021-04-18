<?php

namespace App\Providers;

use App\Auth\CspUserGuard;
use App\Auth\CspUserProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // CSPprover - extend
        Auth::provider('cspuserprovider', function ($app, array $config) {
            // Return an instance of Illuminate\Contracts\Auth\Guard...
            return new CspUserProvider($app['hash'],$config['model'],$config['csptable'],$config['cspapi']);
        });

        // CSPGuard  - extend
        Auth::extend('cspdriver', function ($app, $name, array $config) {
            // Return an instance of Illuminate\Contracts\Auth\Guard...
            return new CspUserGuard('cspdriver',Auth::createUserProvider($config['provider']), $this->app['session.store']);
        });
    }
}
