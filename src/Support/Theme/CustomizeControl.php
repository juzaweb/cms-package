<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Cms\Support\Theme;

use Juzaweb\Cms\Abstracts\CustomizeControlAbstract;

class CustomizeControl extends CustomizeControlAbstract
{
    public function contentTemplate()
    {
        switch ($this->args->get('type')) {
            case 'text':
                return view('jw_theme::backend.editor.control.text', [
                    'args' => $this->args,
                    'key' => $this->key
                ]);
            case 'textarea':
                return view('jw_theme::backend.editor.control.textarea', [
                    'args' => $this->args,
                    'key' => $this->key
                ]);
            case 'site_identity':
                return view('jw_theme::backend.editor.control.site_identity', [
                    'args' => $this->args,
                    'key' => $this->key
                ]);
        }

        return '';
    }
}