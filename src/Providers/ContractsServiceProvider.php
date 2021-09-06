<?php

namespace Juzaweb\Cms\Providers;

use Illuminate\Support\ServiceProvider;
use Juzaweb\Cms\Contracts\RepositoryInterface;
use Juzaweb\Cms\Support\LaravelFileRepository;

class ContractsServiceProvider extends ServiceProvider
{
    /**
     * Register some binding.
     */
    public function register()
    {
        $this->app->bind(RepositoryInterface::class, LaravelFileRepository::class);
    }
}
