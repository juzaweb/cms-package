<?php

namespace Juzaweb\Tests;

if (! defined('JW_BASEPATH')) {
    define('JW_BASEPATH', __DIR__ . '/../../../..');
}

$autoloadPath = JW_BASEPATH . '/vendor/juzaweb/cms/src/Helpers/autoload.php';

if (! file_exists($autoloadPath)) {
    echo 'Missing vendor files, try running "composer install" or use the Wizard installer.' . PHP_EOL;
    exit(1);
}

require $autoloadPath;

use Illuminate\Contracts\Console\Kernel;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require JW_BASEPATH .'/bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}
