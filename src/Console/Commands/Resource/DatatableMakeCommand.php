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

use Illuminate\Support\Str;
use Juzaweb\Console\Commands\Plugin\GeneratorCommand;
use Juzaweb\Support\Config\GenerateConfigReader;
use Juzaweb\Support\Stub;
use Juzaweb\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class DatatableMakeCommand extends GeneratorCommand
{
    use ModuleCommandTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:make-datatable';

    protected $argumentName = 'name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new restful datatable for the specified plugin.';
    /**
     * Get template contents.
     *
     * @return string
     */
    protected function getTemplateContents()
    {
        return (new Stub('/resource/datatable.stub', $this->getDataStub()))->render();
    }

    /**
     * Get the destination file path.
     *
     * @return string
     */
    protected function getDestinationFilePath()
    {
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());
        $datatablePath = GenerateConfigReader::read('datatable');

        return $path . $datatablePath->getPath() . '/' . $this->getDatatableName() . '.php';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the datatable class.'],
            ['module', InputArgument::OPTIONAL, 'The name of plugin will be used.'],
        ];
    }

    /**
     * @return array|string
     */
    protected function getDatatableName()
    {
        $name = Str::studly($this->argument('name'));

        if (Str::contains(strtolower($name), 'datatable') === false) {
            $name .= 'Datatable';
        }

        return $name;
    }

    /**
     * @return array|string
     */
    protected function getDatatableNameWithoutNamespace()
    {
        return class_basename($this->getDatatableName());
    }

    protected function getDataStub()
    {
        /**
         * @var \Juzaweb\Abstracts\Plugin $module
         */
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        return array_merge([
            'MODULENAME'        => $module->getStudlyName(),
            'NAMESPACE'         => $module->getStudlyName(),
            'DOMAIN_NAME'       => $module->getDomainName(),
            'CLASS_NAMESPACE'   => $this->getClassNamespace($module),
            'CLASS'             => $this->getDatatableNameWithoutNamespace(),
            'LOWER_NAME'        => $module->getLowerName(),
            'SNAKE_NAME'        => $module->getSnakeName(),
            'MODULE'            => $this->getModuleName(),
            'NAME'              => $this->getModuleName(),
            'STUDLY_NAME'       => $module->getStudlyName(),
            'MODULE_NAMESPACE'  => $this->laravel['modules']->config('namespace')
        ], $this->getDataModelStub());
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['model', null, InputOption::VALUE_OPTIONAL, 'The model for query.', null],
        ];
    }

    public function getDefaultNamespace() : string
    {
        return 'Http/Datatable';
    }

    protected function getDataModelStub()
    {
        $data = [
            'QUERY_TABLE' => '// Query handle',
            'USE_NAMESPACE' => '',
            'BULK_ACTIONS' => 'switch ($action) {
            case \'delete\':
                
                break;
        }',
        ];

        if ($model = $this->option('model')) {
            $module = $this->laravel['modules']->findOrFail($this->getModuleName());

            $data['QUERY_TABLE'] = $this->stubRender('resource/datatable/query-model.stub', [
                'MODEL_NAME' => $model
            ]);

            $data['USE_NAMESPACE'] = $this->stubRender('resource/datatable/use-namespaces.stub', [
                'NAMESPACE' => str_replace('/', '\\', $module->getStudlyName()) . '\Models\\' . $model,
            ]);

            $data['BULK_ACTIONS'] = $this->stubRender('resource/datatable/bulk-actions.stub', [
                'MODEL_NAME' => $model
            ]);
        }

        return $data;
    }
}
