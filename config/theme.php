<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

return [
    'stubs' => [
        'files' => [
            'css' => 'assets/css/app.css',
            'js' => 'assets/js/app.js',
            'index' => 'views/index.blade.php',
            'page' => 'views/page.blade.php',
            'taxonomy' => 'views/taxonomy.blade.php',
            'single' => 'views/single.blade.php',
            'profile' => 'views/profile/index.blade.php',
            'content' => 'views/template-parts/content.blade.php',
            'lang' => 'lang/en/content.php',
            'home' => 'templates/home.blade.php',
        ],
        'folders' => [
            'views' => 'views',
            'views/auth' => 'views/auth',
            'views/profile' => 'views/profile',
            'views/template-parts' => 'views/template-parts',
            'templates' => 'templates',
            'lang' => 'lang',
            'lang/en' => 'lang/en',
            'assets' => 'assets',
            'css' => 'assets/css',
            'js' => 'assets/js',
            'img' => 'assets/images'
        ],
    ]
];
