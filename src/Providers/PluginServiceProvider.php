<?php

namespace Juzaweb\Cms;

use Juzaweb\Cms\Facades\HookAction;
use Juzaweb\Cms\Contracts\ActivatorInterface;
use Juzaweb\Cms\Contracts\RepositoryInterface;
use Juzaweb\Cms\Exceptions\InvalidActivatorClass;
use Juzaweb\Cms\Laravel\LaravelFileRepository;
use Juzaweb\Cms\Abstracts\PluginServiceProvider as BaseServiceProvider;
use Juzaweb\Cms\Support\Stub;

class PluginServiceProvider extends BaseServiceProvider
{
    /**
     * Booting the package.
     */
    public function boot()
    {
        HookAction::loadActionForm(__DIR__ . '/../actions');
        $this->registerModules();
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerNamespaces();
        $this->registerServices();
        $this->setupStubPath();
        $this->registerProviders();
    }

    /**
     * Setup stub path.
     */
    public function setupStubPath()
    {
        Stub::setBasePath(__DIR__ . '/../stubs');
    }

    /**
     * {@inheritdoc}
     */
    protected function registerServices()
    {
        $this->app->singleton(RepositoryInterface::class, function ($app) {
            $path = config('plugin.paths.modules');
            return new LaravelFileRepository($app, $path);
        });

        $this->app->singleton(ActivatorInterface::class, function ($app) {
            $activator = config('plugin.activator');
            $class = config('plugin.activators.' . $activator)['class'];

            if ($class === null) {
                throw InvalidActivatorClass::missingConfig();
            }

            return new $class($app);
        });

        $this->app->alias(RepositoryInterface::class, 'modules');
    }
}
