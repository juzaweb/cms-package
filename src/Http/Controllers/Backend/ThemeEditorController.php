<?php

namespace Juzaweb\Cms\Http\Controllers\Backend;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Juzaweb\Cms\Http\Controllers\BackendController;
use Juzaweb\Cms\Facades\Theme;
use Juzaweb\Cms\Facades\ThemeConfig;
use Juzaweb\Cms\Support\Customize;
use Juzaweb\Cms\Support\CustomizeControl;

class ThemeEditorController extends BackendController
{
    public function index() {
        Theme::set('juzaweb');
        $panels = $this->getDataCustomize();

        return view('jw_theme::backend.editor.index', [
            'panels' => $panels
        ]);
    }
    
    public function save(Request $request) {
        $settings = $request->post('setting', []);
        if ($settings) {
            foreach ($settings as $key => $setting) {
                set_config($key, $setting);
            }
        }

        $data = $request->post('theme', []);

        foreach ($data as $key => $value) {
            ThemeConfig::setConfig($key, $value);
        }
        
        return $this->success([
            'message' => trans('juzaweb::app.saved_successfully'),
        ]);
    }

    protected function getDataCustomize()
    {
        $customize = new Customize();
        $customize->addSection('site_identity', [
            'title' => __("juzaweb::app.site_identity"),
            'priority' => 1,
        ]);

        $customize->addControl(new CustomizeControl($customize, 'site_identity', [
            'label' => __('juzaweb::app.site_identity'),
            'section' => 'site_identity',
            'settings' => 'site_identity',
            'type' => 'site_identity',
        ]));

        $themePath = base_path('themes/juzaweb/config/customize.php');
        if (file_exists($themePath)) {
            include $themePath;
        }

        /**
         * @var Customize $customize
         */
        $customize = apply_filters('theme_editor.get_customize', $customize);
        $panels = $customize->getPanel()->sortBy('priority');
        foreach ($panels as $key => $panel) {
            $sections = $customize->getSection()->where('panel', $key);
            if ($sections->isEmpty()) {
                continue;
            }

            $childs = $panel->get('childs', new Collection([]));
            foreach ($sections as $secKey => $section) {
                $controls = $customize->getControl()->where('section', $secKey);
                $section->put('controls', $controls);

                $childs->put($secKey, $section);
            }

            $panel->put('childs', $childs);
        }

        $sections = $customize->getSection()->whereNull('panel');
        foreach ($sections as $secKey => $section) {
            $controls = $customize->getControl()->where('section', $secKey);
            $section->put('controls', $controls);
            $panels->put($secKey, $section);
        }

        return $panels;
    }
}
