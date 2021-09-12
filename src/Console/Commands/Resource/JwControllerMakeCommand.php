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

use Juzaweb\Console\Commands\Plugin\ControllerMakeCommand;

class JwControllerMakeCommand extends ControllerMakeCommand
{
    protected $name = 'plugin:make-jwcontroller';

    protected function getOptions()
    {
        return [];
    }

    protected function getStubName()
    {
        return '/resource/controller.stub';
    }

    protected function getDataStub()
    {
        /**
         * @var \Juzaweb\Abstracts\Plugin $module
         */
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        $data = parent::getDataStub();

    }
}