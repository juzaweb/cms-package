<?php

namespace Juzaweb\Cms\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function map()
    {
        if (config('juzaweb.api_route')) {
            $this->mapApiRoutes();
        }

        $this->mapWebRoutes();
        $this->mapApiRoutes();
        $this->mapAssetRoutes();
        $this->mapAdminRoutes();
        $this->mapThemeRoutes();
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->group(__DIR__ . '/../routes/web.php');
    }

    protected function mapAdminRoutes()
    {
        Route::middleware('admin')
            ->prefix(config('juzaweb.admin_prefix'))
            ->group(__DIR__ . '/../routes/admin.php');
    }

    protected function mapThemeRoutes()
    {
        Route::middleware('theme')
            ->group(__DIR__ . '/../routes/theme.php');
    }

    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->group(__DIR__ . '/../routes/api.php');
    }

    protected function mapAssetRoutes()
    {
        Route::middleware('assets')
            ->group(__DIR__ . '/../routes/assets.php');
    }
}
