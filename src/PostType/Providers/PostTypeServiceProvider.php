<?php
/**
 * MYMO CMS - Free Laravel CMS
 *
 * @package    juzacmscms/juzacmscms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzacmscms/juzacmscms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 5/30/2021
 * Time: 1:16 PM
 */

namespace Juzaweb\Cms\PostType\Providers;

use Illuminate\Support\ServiceProvider;
use Juzaweb\Cms\Core\Facades\HookAction;

class PostTypeServiceProvider extends ServiceProvider
{
    public function boot()
    {

    }

    public function register()
    {
        $this->app->register(RepositoryServiceProvider::class);
    }
}