<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Http\Controllers\Frontend;

use Juzaweb\Http\Controllers\FrontendController;
use Juzaweb\Facades\HookAction;
use Juzaweb\Models\Post;

class PostController extends FrontendController
{
    public function index(...$slug)
    {
        if (count($slug) > 1) {
            return $this->detail(...$slug);
        }

        $title = get_config('title');
        $posts = Post::wherePublish()->paginate(10);

        return view('theme::post.index', compact(
            'posts',
            'title'
        ));
    }

    public function detail(...$slug)
    {
        $base = $slug[0];
        $postSlug = $slug[1];

        $permalink = $this->getPermalinks($base);

        $view = 'theme::post.content';
        if ($base != 'post') {
            $typeView = "theme::post.content-{$base}";
            if (view()->exists($typeView)) {
                $view = $typeView;
            }
        }

        $postType = HookAction::getPostTypes($permalink->get('post_type'));
        $post = app($postType->get('model'))
            ->where('slug', $postSlug)
            ->firstOrFail();

        $title = $post->getTitle();

        return view($view, compact(
            'title',
            'post'
        ));
    }
}