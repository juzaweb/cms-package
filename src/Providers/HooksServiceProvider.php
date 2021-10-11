<?php

namespace Juzaweb\Providers;

use Illuminate\Support\ServiceProvider;
use Juzaweb\Contracts\EventyContract;
use Juzaweb\Support\Hooks\Events;

class HooksServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Registers the eventy singleton.
        $this->app->singleton(EventyContract::class, function () {
            return new Events();
        });

        // Register service providers
        $this->app->register(HookBladeServiceProvider::class);
    }
}
