<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Traits;

use Illuminate\Support\Facades\File;
use Juzaweb\Support\Config\GenerateConfigReader;

trait ResourceCommandTrait
{
    protected function makeModel($model)
    {
        $this->call('plugin:make-model', [
            'model' => $model,
            'module' => $this->getModuleName(),
            '--stub' => 'resource/model.stub'
        ]);
    }

    protected function makeDataTable($model)
    {
        $this->call('plugin:make-datatable', [
            'name' => $model,
            'module' => $this->getModuleName(),
            '--model' => $model
        ]);
    }

    protected function makeController($table, $model)
    {
        $file = $model . 'Controller.php';
        $path = $this->getDestinationControllerFilePath($file);

        $contents = $this->stubRender('resource/controller.stub', [
            'CLASS_NAMESPACE' => $this->module->getNamespace() . 'Http\Controllers',
            'DATATABLE' => $model . 'Datatable',
            'MODEL_NAME' => $model,
            'MODULE_NAMESPACE'  => $this->module->getNamespace(),
            'CLASS'  => $model . 'Controller',
            'TABLE_NAME'  => $table,
            'MODULE_DOMAIN'  => $this->module->getDomainName(),
        ]);

        $this->makeFile($path, $contents);
    }

    protected function makeViews($table)
    {
        $path = str_replace('\\', '/', $this->getDestinationViewsFilePath($table, 'index.blade.php'));
        $contents = $this->stubRender('resource/views/index.stub', [
            'ROUTE_NAME' => $table
        ]);

        $this->makeFile($path, $contents);


        $path = str_replace('\\', '/', $this->getDestinationViewsFilePath($table, 'form.blade.php'));
        $contents = $this->stubRender('resource/views/form.stub', [
            'ROUTE_NAME' => $table
        ]);

        $this->makeFile($path, $contents);
    }

    protected function getDestinationControllerFilePath($file)
    {
        $controllerPath = $this->module->getPath() .'/'. GenerateConfigReader::read('controller')->getPath() . '/Backend/';

        if (!is_dir($controllerPath)) {
            File::makeDirectory($controllerPath, 0775, true);
        }

        return $controllerPath . '/' . $file;
    }

    protected function getDestinationViewsFilePath($table, $file)
    {
        $viewPath = $this->module->getPath() .'/'. GenerateConfigReader::read('views')->getPath() . '/backend/' . $table;

        if (!is_dir($viewPath)) {
            File::makeDirectory($viewPath, 0775, true);
        }

        return $viewPath . '/' . $file;
    }
}
