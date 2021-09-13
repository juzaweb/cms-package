<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Console\Commands\Resource;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Juzaweb\Traits\ModuleCommandTrait;
use Juzaweb\Traits\ResourceCommandTrait;
use Symfony\Component\Console\Input\InputArgument;

class JwResouceMakeCommand extends Command
{
    use ModuleCommandTrait, ResourceCommandTrait;

    /**
     * The name of argument being used.
     *
     * @var string
     */
    protected $argumentName = 'name';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:make-jwresource';

    /**
     * @var \Juzaweb\Abstracts\Plugin $module
     */
    protected $module;

    public function handle()
    {
        $this->module = $this->laravel['modules']->find($this->getModuleName());

        $table = $this->argument('name');
//        if (!Schema::hasTable($table)) {
//            $this->error("Table [{$table}] does not exist.");
//            exit(1);
//        }

        $model = Str::studly($table);

        $this->makeModel($model);

        $this->makeDataTable($model);

        $this->makeController($table, $model);

        $this->makeViews($table);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the table.'],
            ['module', InputArgument::OPTIONAL, 'The name of plugin will be used.'],
        ];
    }
}
