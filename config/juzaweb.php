<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzawebcms/juzawebcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzawebcms/juzawebcms
 * @license    MIT
*/

return [
    'admin_prefix' => env('ADMIN_PREFIX', 'admin-cp'),

    'api_route' => (bool) env('API_ROUTE', false),

    'email' => [
        /**
         * Method send email
         *
         * Support: sync, queue, cron
         * Default: sync
         */
        'method' => 'sync'
    ],

    'theme' => [
        /**
         * Enable upload themes
         *
         * Default: true
         */
        'enable_upload' => true,

        /**
         * Themes path
         *
         * This path used for save the generated theme. This path also will added
        automatically to list of scanned folders.
         */
        'path' => base_path('themes'),
    ],

    'plugin' => [
        /**
         * Enable upload plugins
         *
         * Default: true
         */
        'enable_upload' => true,

        'path' => base_path('plugins'),

        /**
         * Plugins assets path
         *
         * Path for assets when it was publish
         * Default: plugins
         */
        'assets' => public_path('plugins'),
    ],

    'performance' => [
        'minify_views' => true,
        'deny_iframe' => true,
    ],

    'filemanager' => [
        'disk' => 'public',
        'types' => [
            'file'  => [
                'max_size'     => 5, // size in MB
                'valid_mime'   => [
                    'image/jpeg',
                    'image/pjpeg',
                    'image/png',
                    'image/gif',
                    'image/svg+xml',
                    'application/pdf',
                    'text/plain',
                ],
            ],
            'image' => [
                'max_size'     => 50, // size in MB
                'valid_mime'   => [
                    'image/jpeg',
                    'image/pjpeg',
                    'image/png',
                    'image/gif',
                    'image/svg+xml',
                ],
            ],
        ],
    ],

];
