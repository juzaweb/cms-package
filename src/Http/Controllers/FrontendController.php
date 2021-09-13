<?php

namespace Juzaweb\Http\Controllers;

use Illuminate\Support\Arr;
use Juzaweb\Facades\Theme;
use Juzaweb\Facades\HookAction;

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

        add_action('theme.header', function () use ($js, $version) {
            foreach ($js as $item) {
                echo '<script src="'. Theme::assets($item) .'?v='. $version .'"></script>';
            }
        }, 16);

        add_action('theme.header', function () use ($css, $version) {
            foreach ($css as $item) {
                echo '<link rel="stylesheet" href="'. Theme::assets($item) .'?v='. $version .'">';
            }
        }, 10);
    }

    protected function getPermalinks($base = null)
    {
        if ($base) {
            return collect(HookAction::getPermalinks())
                ->where('base', $base)
                ->first();
        }

        return collect(HookAction::getPermalinks());
    }
}
