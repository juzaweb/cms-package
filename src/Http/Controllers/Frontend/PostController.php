<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Cms\Http\Controllers\Frontend;

use Juzaweb\Cms\Models\Post;

class PostController extends FrontendController
{
    public function index(...$slug)
    {
        $title = trans('juzaweb::app.title');
        $posts = Post::wherePublish()->paginate(10);

        return view('theme::post.index', compact(
            'posts',
            'title'
        ));
    }
}