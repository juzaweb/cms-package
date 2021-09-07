<?php

namespace Juzaweb\Cms\Traits;

trait ModuleCommandTrait
{
    /**
     * Get the plugin name.
     *
     * @return string
     */
    public function getModuleName()
    {
        $module = $this->argument('module');
        $module = app('modules')->findOrFail($module);
        return $module->getName();
    }
}
