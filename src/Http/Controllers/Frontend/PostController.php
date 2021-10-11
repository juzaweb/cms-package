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

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Juzaweb\Facades\HookAction;
use Juzaweb\Http\Controllers\FrontendController;

class PostController extends FrontendController
{
    public function index(...$slug)
    {
        if (count($slug) > 1) {
            return $this->detail(...$slug);
        }

        $title = get_config('title');
        $base = $slug[0];
        $permalink = $this->getPermalinks($base);
        $postType = HookAction::getPostTypes($permalink->get('post_type'));
        $posts = $postType->get('model')::selectFrontendBuilder()
            ->paginate(10);

        return view('theme::index', compact(
            'posts',
            'title'
        ));
    }

    public function detail(...$slug)
    {
        $base = $slug[0];
        $postSlug = $slug[1];

        $permalink = $this->getPermalinks($base);
        $postType = HookAction::getPostTypes($permalink->get('post_type'));

        $post = $postType->get('model')::createFrontendBuilder()
            ->where('slug', $postSlug)
            ->firstOrFail();

        $title = $post->getTitle();
        $type = $post->getPostType('singular');
        $template = get_name_template_part($type, 'single');

        return view('theme::template-parts.' . $template, compact(
            'title',
            'post'
        ));
    }

    public function comment(Request $request, $base, $slug)
    {
        if (Auth::check()) {
            $this->validate($request, [
                'content' => 'required',
            ]);
        } else {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email',
                'content' => 'required',
            ]);
        }

        $permalink = $this->getPermalinks($base);
        $postType = HookAction::getPostTypes($permalink->get('post_type'));

        $post = $postType->get('model')::createFrontendBuilder()
            ->where('slug', '=', $slug)
            ->firstOrFail();

        $post->comments()->create(array_merge($request->all(), [
            'object_type' => $permalink->get('post_type'),
            'user_id' => Auth::id(),
        ]));

        return $this->success([
            'message' => true,
        ]);
    }
}
