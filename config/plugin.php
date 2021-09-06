<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 *
 * Created by JUZAWEB.
 * Date: 8/9/2021
 * Time: 7:54 PM
 */

use Juzaweb\Cms\Activators\FileActivator;

return [
    /**
     * Enable upload plugins
     *
     * Default: true
     */
    'enable_upload' => true,

    /**
     * Plugins path
     *
     * This path used for save the generated plugin. This path also will added
    automatically to list of scanned folders.
     */
    'path' => base_path('plugins'),
    /**
     * Plugins assets path
     *
     * Path for assets when it was publish
     * Default: plugins
     */
    'assets' => public_path('plugins'),

    'stubs' => [
        'enabled' => true,
        'files' => [
            'actions/action' => 'actions/action.php',
            'routes/admin' => 'src/routes/admin.php',
            'routes/api' => 'src/routes/api.php',
            'views/index' => 'src/resources/views/index.blade.php',
            'composer' => 'composer.json',
            'webpack' => 'webpack.mix.js',
            'package' => 'package.json',
        ],
        'replacements' => [
            'routes/admin' => ['LOWER_NAME', 'STUDLY_NAME'],
            'routes/api' => ['LOWER_NAME'],
            'webpack' => ['LOWER_NAME'],
            'json' => ['LOWER_NAME', 'STUDLY_NAME', 'MODULE_NAMESPACE', 'PROVIDER_NAMESPACE'],
            'views/index' => ['LOWER_NAME'],
            'views/master' => ['LOWER_NAME', 'STUDLY_NAME'],
            'composer' => [
                'LOWER_NAME',
                'STUDLY_NAME',
                'SNAKE_NAME',
                'VENDOR',
                'AUTHOR_NAME',
                'AUTHOR_EMAIL',
                'MODULE_NAME',
                'MODULE_NAMESPACE',
                'PROVIDER_NAMESPACE',
            ],
        ],
        'gitkeep' => true,
    ],
    'paths' => [
        /*
        |--------------------------------------------------------------------------
        | Modules path
        |--------------------------------------------------------------------------
        |
        | This path used for save the generated plugin. This path also will be added
        | automatically to list of scanned folders.
        |
        */

        'modules' => base_path('plugins'),
        /*
        |--------------------------------------------------------------------------
        | Modules assets path
        |--------------------------------------------------------------------------
        |
        | Here you may update the plugins assets path.
        |
        */

        'assets' => public_path('plugins'),
        /*
        |--------------------------------------------------------------------------
        | The migrations path
        |--------------------------------------------------------------------------
        |
        | Where you run 'plugin:publish-migration' command, where do you publish the
        | the migration files?
        |
        */

        'migration' => base_path('database/migrations'),
        /*
        |--------------------------------------------------------------------------
        | Generator path
        |--------------------------------------------------------------------------
        | Customise the paths where the folders will be generated.
        | Set the generate key to false to not generate that folder
        */
        'generator' => [
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
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Scan Path
    |--------------------------------------------------------------------------
    |
    | Here you define which folder will be scanned. By default will scan vendor
    | directory. This is useful if you host the package in packagist website.
    |
    */

    'scan' => [
        'enabled' => false,
        'paths' => [
            base_path('vendor/*/*'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Caching
    |--------------------------------------------------------------------------
    |
    | Here is the config for setting up caching feature.
    |
    */
    'cache' => [
        'enabled' => false,
        'key' => 'juzaweb-plugins',
        'lifetime' => 60,
    ],
    /*
    |--------------------------------------------------------------------------
    | Choose what laravel-modules will register as custom namespaces.
    | Setting one to false will require you to register that part
    | in your own Service Provider class.
    |--------------------------------------------------------------------------
    */
    'register' => [
        /**
         * load files on boot or register method
         *
         * Note: boot not compatible with asgardcms
         *
         * @example boot|register
         */
        'files' => 'register',
    ],

    /*
    |--------------------------------------------------------------------------
    | Activators
    |--------------------------------------------------------------------------
    |
    | You can define new types of activators here, file, database etc. The only
    | required parameter is 'class'.
    | The file activator will store the activation status in storage/installed_modules
    */
    'activators' => [
        'file' => [
            'class' => FileActivator::class,
            'statuses-file' => base_path('bootstrap/cache/plugins_statuses.php'),
            'cache-key' => 'juzaweb.activator.installed',
            'cache-lifetime' => 604800,
        ],
    ],

    'activator' => 'file',
];
