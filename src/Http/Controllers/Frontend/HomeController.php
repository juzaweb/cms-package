<?php

namespace Juzaweb\Cms\Http\Controllers\Frontend;

use Illuminate\Support\Facades\App;

class HomeController extends FrontendController
{
    public function index()
    {
        do_action('theme.home.index');

        if ($pageId = jw_home_page()) {
            return App::call('Juzaweb\Cms\Http\Controllers\Frontend\PageController@detail', ['id' => $pageId]);
        }

        return App::call('Juzaweb\Cms\Http\Controllers\Frontend\PostController@index', []);
    }

    protected function handlePage()
    {
        $config = get_configs(['title', 'description']);
        $theme = $this->getThemeInfo();
        $view = $this->getViewPage();

        $params = [
            'title' => $config['title'],
            'description' => $config['description'],
            'theme' => $theme,
            'config' => $config,
        ];

        return apply_filters(
            'theme.page.home.handle',
            view($view, $params),
            $params
        );
    }

    protected function getViewPage()
    {
        $view = 'theme::post.index';

        return $view;
    }
}
