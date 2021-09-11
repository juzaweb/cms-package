<?php

namespace Juzaweb\Http\Controllers\Frontend;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Juzaweb\Http\Controllers\Controller;
use Juzaweb\Facades\Theme;
use Noodlehaus\Config;

class FrontendController extends Controller
{
    public function callAction($method, $parameters)
    {
        /**
         * Action after call action frontend
         * Add action to this hook add_action('theme.call_action', $callback)
         */
        do_action('theme.call_action', $method, $parameters);

        $this->addThemeStyles();

        return parent::callAction($method, $parameters);
    }

    protected function addThemeStyles()
    {
        $currentTheme = jw_current_theme();
        $theme = Theme::getThemeInfo($currentTheme);
        $config = Theme::getThemeConfig($currentTheme);

        $version = $theme->get('version');
        $styles = $config->get('styles');

        $js = Arr::get($styles, 'js', []);
        $css = Arr::get($styles, 'css', []);

        foreach ($js as $item) {
            add_action('theme.header', function () use ($item, $version) {
                echo '<script src="'. Theme::assets($item) .'?v='. $version .'"></script>';
            }, 16);
        }

        foreach ($css as $item) {
            add_action('theme.header', function () use ($item, $version) {
                echo '<link rel="stylesheet" href="'. Theme::assets($item) .'?v='. $version .'">';
            }, 10);
        }
    }
}
