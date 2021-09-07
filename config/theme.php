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
];
