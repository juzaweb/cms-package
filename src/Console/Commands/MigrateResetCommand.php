<?php

namespace Juzaweb\Cms\Console\Commands;

use Illuminate\Console\Command;
use Juzaweb\Cms\Migrations\Migrator;
use Juzaweb\Cms\Support\Traits\MigrationLoaderTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MigrateResetCommand extends Command
{
    use MigrationLoaderTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:migrate-reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset the plugins migrations.';

    /**
     * @var \Juzaweb\Cms\Contracts\RepositoryInterface
     */
    protected $module;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->module = $this->laravel['modules'];

        $name = $this->argument('module');

        if (!empty($name)) {
            $this->reset($name);

            return;
        }

        foreach ($this->module->getOrdered($this->option('direction')) as $module) {
            $this->line('Running for plugin: <info>' . $module->getName() . '</info>');

            $this->reset($module);
        }
    }

    /**
     * Rollback migration from the specified plugin.
     *
     * @param $module
     */
    public function reset($module)
    {
        if (is_string($module)) {
            $module = $this->module->findOrFail($module);
        }

        $migrator = new Migrator($module, $this->getLaravel());

        $database = $this->option('database');

        if (!empty($database)) {
            $migrator->setDatabase($database);
        }

        $migrated = $migrator->reset();

        if (count($migrated)) {
            foreach ($migrated as $migration) {
                $this->line("Rollback: <info>{$migration}</info>");
            }

            return;
        }

        $this->comment('Nothing to rollback.');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['module', InputArgument::OPTIONAL, 'The name of plugin will be used.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['direction', 'd', InputOption::VALUE_OPTIONAL, 'The direction of ordering.', 'desc'],
            ['database', null, InputOption::VALUE_OPTIONAL, 'The database connection to use.'],
            ['force', null, InputOption::VALUE_NONE, 'Force the operation to run when in production.'],
            ['pretend', null, InputOption::VALUE_NONE, 'Dump the SQL queries that would be run.'],
        ];
    }
}
