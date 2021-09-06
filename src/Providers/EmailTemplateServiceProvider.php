<?php

namespace Juzaweb\Cms\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;
use Juzaweb\Cms\Facades\HookAction;
use Juzaweb\Cms\Console\Commands\SendMailCommand;

class EmailTemplateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        HookAction::loadActionForm(__DIR__ . '/../../actions');
        $this->loadViewsFrom(__DIR__ . '/../views', 'jw_email');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->publishes([
            __DIR__ . '/../../config/email.php' => base_path('config/email.php'),
        ], 'jw_email_config');

        $this->publishes([
            __DIR__ . '/../views' => resource_path('views/vendor/jw_email'),
        ], 'jw_email_views');

        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('email:send')->everyMinute();
        });
    }
    
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/email.php', 'email');

        $this->commands([
            SendMailCommand::class,
        ]);
    }
}
