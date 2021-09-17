<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Providers;

use Juzaweb\Support\ServiceProvider;
use Arcanedev\LogViewer\{Contracts, LogViewer, Utilities};
use Illuminate\Contracts\Support\DeferrableProvider;

class LogViewerServicesProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->registerLogViewer();
        $this->registerLogLevels();
        $this->registerStyler();
        $this->registerLogMenu();
        $this->registerFilesystem();
        $this->registerFactory();
        $this->registerChecker();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [
            Contracts\LogViewer::class,
            Contracts\Utilities\LogLevels::class,
            Contracts\Utilities\LogStyler::class,
            Contracts\Utilities\LogMenu::class,
            Contracts\Utilities\Filesystem::class,
            Contracts\Utilities\Factory::class,
            Contracts\Utilities\LogChecker::class,
        ];
    }

    /* -----------------------------------------------------------------
     |  LogViewer Utilities
     | -----------------------------------------------------------------
     */

    /**
     * Register the log viewer service.
     */
    private function registerLogViewer(): void
    {
        $this->singleton(Contracts\LogViewer::class, LogViewer::class);
    }

    /**
     * Register the log levels.
     */
    private function registerLogLevels(): void
    {
        $this->singleton(Contracts\Utilities\LogLevels::class, function ($app) {
            return new Utilities\LogLevels(
                $app['translator'],
                $app['config']->get('log-viewer.locale')
            );
        });
    }

    /**
     * Register the log styler.
     */
    private function registerStyler(): void
    {
        $this->singleton(Contracts\Utilities\LogStyler::class, Utilities\LogStyler::class);
    }

    /**
     * Register the log menu builder.
     */
    private function registerLogMenu(): void
    {
        $this->singleton(Contracts\Utilities\LogMenu::class, Utilities\LogMenu::class);
    }

    /**
     * Register the log filesystem.
     */
    private function registerFilesystem(): void
    {
        $this->singleton(Contracts\Utilities\Filesystem::class, function ($app) {
            /** @var  \Illuminate\Config\Repository  $config */
            $config     = $app['config'];
            $filesystem = new Utilities\Filesystem($app['files'], $config->get('log-viewer.storage-path'));

            return $filesystem->setPattern(
                $config->get('log-viewer.pattern.prefix', Utilities\Filesystem::PATTERN_PREFIX),
                $config->get('log-viewer.pattern.date', Utilities\Filesystem::PATTERN_DATE),
                $config->get('log-viewer.pattern.extension', Utilities\Filesystem::PATTERN_EXTENSION)
            );
        });
    }

    /**
     * Register the log factory class.
     */
    private function registerFactory(): void
    {
        $this->singleton(Contracts\Utilities\Factory::class, Utilities\Factory::class);
    }

    /**
     * Register the log checker service.
     */
    private function registerChecker(): void
    {
        $this->singleton(Contracts\Utilities\LogChecker::class, Utilities\LogChecker::class);
    }
}
