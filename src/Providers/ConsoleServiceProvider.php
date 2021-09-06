<?php

namespace Juzaweb\Cms\Providers;

use Illuminate\Support\ServiceProvider;
use Juzaweb\Cms\Console\Commands\CommandMakeCommand;
use Juzaweb\Cms\Console\Commands\ControllerMakeCommand;
use Juzaweb\Cms\Console\Commands\DisableCommand;
use Juzaweb\Cms\Console\Commands\DumpCommand;
use Juzaweb\Cms\Console\Commands\EnableCommand;
use Juzaweb\Cms\Console\Commands\EventMakeCommand;
use Juzaweb\Cms\Console\Commands\FactoryMakeCommand;
use Juzaweb\Cms\Console\Commands\InstallCommand;
use Juzaweb\Cms\Console\Commands\JobMakeCommand;
use Juzaweb\Cms\Console\Commands\LaravelModulesV6Migrator;
use Juzaweb\Cms\Console\Commands\ListCommand;
use Juzaweb\Cms\Console\Commands\ListenerMakeCommand;
use Juzaweb\Cms\Console\Commands\MailMakeCommand;
use Juzaweb\Cms\Console\Commands\MiddlewareMakeCommand;
use Juzaweb\Cms\Console\Commands\MigrateCommand;
use Juzaweb\Cms\Console\Commands\MigrateRefreshCommand;
use Juzaweb\Cms\Console\Commands\MigrateResetCommand;
use Juzaweb\Cms\Console\Commands\MigrateRollbackCommand;
use Juzaweb\Cms\Console\Commands\MigrateStatusCommand;
use Juzaweb\Cms\Console\Commands\MigrationMakeCommand;
use Juzaweb\Cms\Console\Commands\ModelMakeCommand;
use Juzaweb\Cms\Console\Commands\ModuleDeleteCommand;
use Juzaweb\Cms\Console\Commands\ModuleMakeCommand;
use Juzaweb\Cms\Console\Commands\NotificationMakeCommand;
use Juzaweb\Cms\Console\Commands\PolicyMakeCommand;
use Juzaweb\Cms\Console\Commands\ProviderMakeCommand;
use Juzaweb\Cms\Console\Commands\RequestMakeCommand;
use Juzaweb\Cms\Console\Commands\ResourceMakeCommand;
use Juzaweb\Cms\Console\Commands\RouteProviderMakeCommand;
use Juzaweb\Cms\Console\Commands\RuleMakeCommand;
use Juzaweb\Cms\Console\Commands\SeedCommand;
use Juzaweb\Cms\Console\Commands\SeedMakeCommand;
use Juzaweb\Cms\Console\Commands\SetupCommand;
use Juzaweb\Cms\Console\Commands\TestMakeCommand;
use Juzaweb\Cms\Console\Commands\UnUseCommand;
use Juzaweb\Cms\Console\Commands\UpdateCommand;
use Juzaweb\Cms\Console\Commands\UseCommand;

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
