<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Actions;

use Juzaweb\Abstracts\Action;

class EnqueueStyleAction extends Action
{
    public function handle()
    {
        $this->addAction(self::BACKEND_HEADER_ACTION, [$this, 'enqueueStylesHeader']);
        $this->addAction(self::BACKEND_FOOTER_ACTION, [$this, 'enqueueStylesFooter']);
        $this->addAction(self::FRONTEND_HEADER_ACTION, [$this, 'addFrontendHeader']);
    }

    public function enqueueStylesHeader()
    {
        $scripts = get_enqueue_scripts(false);
        $styles = get_enqueue_styles(false);

        foreach($styles as $style) {
            echo '<link rel="stylesheet" type="text/css" href="'. e($style->get('src')) .'?v='. e($style->get('ver')) .'">';
        }

        foreach($scripts as $script) {
            echo '<script src="'. e($script->get('src')) .'?v='. e($script->get('ver')) .'"></script>';
        }
    }

    public function enqueueStylesFooter()
    {
        $scripts = get_enqueue_scripts(true);
        $styles = get_enqueue_styles(true);

        foreach($styles as $style) {
            echo '<link rel="stylesheet" type="text/css" href="'. e($style->get('src')) .'?v='. e($style->get('ver')) .'">';
        }

        foreach($scripts as $script) {
            echo '<script src="'. e($script->get('src')) .'?v='. e($script->get('ver')) .'"></script>';
        }
    }

    public function addFrontendHeader()
    {
        $fbAppId = get_config('fb_app_id');
        $googleAnalytics = get_config('google_analytics');

        echo e(view('juzaweb::items.frontend_header', compact(
            'fbAppId',
            'googleAnalytics'
        )));
    }
}
