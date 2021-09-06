<?php

namespace Juzaweb\Cms\Support\Config;

class GenerateConfigReader
{
    public static function read(string $value) : GeneratorPath
    {
        return new GeneratorPath(config("plugin.paths.generator.$value"));
    }
}