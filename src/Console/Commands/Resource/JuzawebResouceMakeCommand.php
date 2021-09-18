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

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Juzaweb\Abstracts\ResourceCommand;
use Symfony\Component\Console\Input\InputArgument;

class JuzawebResouceMakeCommand extends ResourceCommand
{
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

    public function handle()
    {
        $this->module = $this->laravel['modules']->find($this->getModuleName());

        $table = $this->argument('name');
        $realTable = $this->module->getDomainName().'_'.$table;

        if (!Schema::hasTable($realTable)) {
            $this->error("Table [{$realTable}] does not exist. Please create table.");
            exit(1);
        }

        $this->columns = collect(Schema::getColumnListing($realTable))
            ->filter(function ($item) {
                return !in_array($item, [
                    'id',
                    'created_at',
                    'updated_at',
                    'updated_by',
                    'updated_by',
                ]);
            })->toArray();

        $model = Str::studly($table);

        $this->makeModel($table, $model);

        $this->makeDataTable($model);

        $this->makeController($table, $model);

        $this->makeViews($table);

        $routePath = $this->module->getPath() . '/src/routes/admin.php';
        $this->info('Add resource route ' . $routePath);

        $content = "Route::jwResource('{$table}', 'Backend\\{$model}Controller');";
        file_put_contents($routePath, PHP_EOL.$content.PHP_EOL, FILE_APPEND | LOCK_EX);
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
