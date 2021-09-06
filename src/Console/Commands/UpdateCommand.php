<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Cms\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Juzaweb\Cms\Support\Manager\UpdateManager;

class UpdateCommand extends Command
{
    protected $signature = 'juzaweb:update';

    public function handle()
    {
        try {

            app(UpdateManager::class)
                ->update('core');

        } catch (\Throwable $e) {
            Log::error($e);
        }
    }
}