<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb\laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb;

use Composer\InstalledVersions;

class Version
{
    public static function getVersion()
    {
        return InstalledVersions::getVersion('juzaweb/cms');
    }
}
