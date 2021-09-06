<?php

namespace Juzaweb\Cms\Providers;

use Illuminate\Support\ServiceProvider;
use Juzaweb\Cms\Console\Commands\Plugin\CommandMakeCommand;
use Juzaweb\Cms\Console\Commands\Plugin\ControllerMakeCommand;
use Juzaweb\Cms\Console\Commands\Plugin\DisableCommand;
use Juzaweb\Cms\Console\Commands\Plugin\DumpCommand;
use Juzaweb\Cms\Console\Commands\Plugin\EnableCommand;
use Juzaweb\Cms\Console\Commands\Plugin\EventMakeCommand;
use Juzaweb\Cms\Console\Commands\Plugin\FactoryMakeCommand;
use Juzaweb\Cms\Console\Commands\InstallCommand;
use Juzaweb\Cms\Console\Commands\Plugin\JobMakeCommand;
use Juzaweb\Cms\Console\Commands\Plugin\LaravelModulesV6Migrator;
use Juzaweb\Cms\Console\Commands\Plugin\ListCommand;
use Juzaweb\Cms\Console\Commands\Plugin\ListenerMakeCommand;
use Juzaweb\Cms\Console\Commands\Plugin\MailMakeCommand;
use Juzaweb\Cms\Console\Commands\Plugin\MiddlewareMakeCommand;
use Juzaweb\Cms\Console\Commands\Plugin\MigrateCommand;
use Juzaweb\Cms\Console\Commands\Plugin\MigrateRefreshCommand;
use Juzaweb\Cms\Console\Commands\Plugin\MigrateResetCommand;
use Juzaweb\Cms\Console\Commands\Plugin\MigrateRollbackCommand;
use Juzaweb\Cms\Console\Commands\Plugin\MigrateStatusCommand;
use Juzaweb\Cms\Console\Commands\Plugin\MigrationMakeCommand;
use Juzaweb\Cms\Console\Commands\Plugin\ModelMakeCommand;
use Juzaweb\Cms\Console\Commands\Plugin\ModuleDeleteCommand;
use Juzaweb\Cms\Console\Commands\Plugin\ModuleMakeCommand;
use Juzaweb\Cms\Console\Commands\Plugin\NotificationMakeCommand;
use Juzaweb\Cms\Console\Commands\Plugin\PolicyMakeCommand;
use Juzaweb\Cms\Console\Commands\Plugin\ProviderMakeCommand;
use Juzaweb\Cms\Console\Commands\Plugin\RequestMakeCommand;
use Juzaweb\Cms\Console\Commands\Plugin\ResourceMakeCommand;
use Juzaweb\Cms\Console\Commands\Plugin\RouteProviderMakeCommand;
use Juzaweb\Cms\Console\Commands\Plugin\RuleMakeCommand;
use Juzaweb\Cms\Console\Commands\Plugin\SeedCommand;
use Juzaweb\Cms\Console\Commands\Plugin\SeedMakeCommand;
use Juzaweb\Cms\Console\Commands\SendMailCommand;
use Juzaweb\Cms\Console\Commands\Plugin\SetupCommand;
use Juzaweb\Cms\Console\Commands\Plugin\TestMakeCommand;
use Juzaweb\Cms\Console\Commands\Plugin\UnUseCommand;
use Juzaweb\Cms\Console\Commands\UpdateCommand;
use Juzaweb\Cms\Console\Commands\Plugin\UseCommand;
use Juzaweb\Cms\Console\Commands\Theme\ThemeGeneratorCommand;
use Juzaweb\Cms\Console\Commands\Theme\ThemeListCommand;
use Juzaweb\Cms\Console\Commands\Theme\ThemePublishCommand;

class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * The available commands
     *
     * @var array
     */
    protected $commands = [
        CommandMakeCommand::class,
        ControllerMakeCommand::class,
        DisableCommand::class,
        //DumpCommand::class,
        EnableCommand::class,
        EventMakeCommand::class,
        JobMakeCommand::class,
        ListenerMakeCommand::class,
        //MailMakeCommand::class,
        MiddlewareMakeCommand::class,
        //NotificationMakeCommand::class,
        ProviderMakeCommand::class,
        RouteProviderMakeCommand::class,
        InstallCommand::class,
        ListCommand::class,
        ModuleDeleteCommand::class,
        ModuleMakeCommand::class,
        //FactoryMakeCommand::class,
        //PolicyMakeCommand::class,
        RequestMakeCommand::class,
        RuleMakeCommand::class,
        MigrateCommand::class,
        MigrateRefreshCommand::class,
        MigrateResetCommand::class,
        MigrateRollbackCommand::class,
        MigrateStatusCommand::class,
        MigrationMakeCommand::class,
        ModelMakeCommand::class,
        SeedCommand::class,
        SeedMakeCommand::class,
        //SetupCommand::class,
        //UnUseCommand::class,
        //UpdateCommand::class,
        //UseCommand::class,
        ResourceMakeCommand::class,
        TestMakeCommand::class,
        LaravelModulesV6Migrator::class,
        SendMailCommand::class,
        ThemeGeneratorCommand::class,
        ThemeListCommand::class,
        ThemePublishCommand::class,
    ];

    /**
     * Register the commands.
     */
    public function register()
    {
        $this->commands($this->commands);
    }

    /**
     * @return array
     */
    public function provides()
    {
        $provides = $this->commands;

        return $provides;
    }
}
