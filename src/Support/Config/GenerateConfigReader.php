<?php

namespace Juzaweb\Support\Config;

class GenerateConfigReader
{
    public static function read(string $value) : GeneratorPath
    {
        $data = [
            'config' => ['path' => 'Config', 'generate' => false],
            'command' => ['path' => 'src/Commands', 'generate' => false],
            'migration' => ['path' => 'src/database/migrations', 'generate' => true],
            'seeder' => ['path' => 'src/database/seeders', 'generate' => true],
            'factory' => ['path' => 'src/database/factories', 'generate' => true],
            'model' => ['path' => 'src/Models', 'generate' => true],
            'routes' => ['path' => 'src/routes', 'generate' => true],
            'controller' => ['path' => 'src/Http/Controllers', 'generate' => true],
            'filter' => ['path' => 'src/Http/Middleware', 'generate' => true],
            'request' => ['path' => 'src/Http/Requests', 'generate' => true],
            'datatable' => ['path' => 'src/Http/Datatable', 'generate' => true],
            'provider' => ['path' => 'src/Providers', 'generate' => true],
            'assets' => ['path' => 'src/resources/assets', 'generate' => true],
            'assets_js' => ['path' => 'assets/js', 'generate' => true],
            'assets_css' => ['path' => 'assets/css', 'generate' => true],
            'lang' => ['path' => 'src/resources/lang', 'generate' => true],
            'views' => ['path' => 'src/resources/views', 'generate' => true],
            'test' => ['path' => 'tests/Unit', 'generate' => true],
            'test-feature' => ['path' => 'tests/Feature', 'generate' => true],
            'repository' => ['path' => 'src/Repositories', 'generate' => false],
            'event' => ['path' => 'src/Events', 'generate' => false],
            'listener' => ['path' => 'src/Listeners', 'generate' => false],
            'policies' => ['path' => 'src/Policies', 'generate' => false],
            'rules' => ['path' => 'src/Rules', 'generate' => false],
            'jobs' => ['path' => 'src/Jobs', 'generate' => false],
            'emails' => ['path' => 'src/Emails', 'generate' => false],
            'notifications' => ['path' => 'src/Notifications', 'generate' => false],
            'resource' => ['path' => 'src/Transformers', 'generate' => false],
        ];

        return new GeneratorPath($data[$value]);
    }
}
