<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzawebcms/juzawebcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzawebcms/juzawebcms
 * @license    MIT
*/

namespace Juzaweb\Support;


use Illuminate\Support\Facades\DB;

class Installer
{
    /**
     * If application is already installed.
     *
     * @return bool
     */
    public static function alreadyInstalled()
    {
        if (!self::checkDbInstall()) {
            if (file_exists(static::installedPath())) {
                unlink(static::installedPath());
            }

            return false;
        }

        if (file_exists(static::installedPath())) {
            return true;
        }

        return false;
    }

    public static function installedPath()
    {
        return storage_path('app/installed');
    }

    protected static function checkDbInstall()
    {
        try {
            DB::connection()->getPdo();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}