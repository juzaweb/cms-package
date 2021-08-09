<?php

namespace Juzaweb\Cms\Backend\Http\Controllers\Backend\Setting;

use Juzaweb\Cms\Backend\Http\Controllers\BackendController;
use Juzaweb\Cms\Core\Models\Config;
use Illuminate\Http\Request;

class SystemSettingController extends BackendController
{
    public function index($form = 'general')
    {
        $forms = $this->getForms();
        
        return view('juzacms::backend.setting.system.index', [
            'title' => trans('juzacms::app.system_setting'),
            'component' => $form,
            'forms' => $forms,
        ]);
    }
    
    public function save(Request $request)
    {
        $configs = $request->only($this->getSettings());
        foreach ($configs as $key => $config) {
            if ($request->has($key)) {
                Config::setConfig($key, $config);
            }
        }
    
        $form = $request->post('form');
        if (empty($form)) {
            $form = 'general';
        }
        
        return $this->success([
            'message' => trans('juzacms::app.saved_successfully'),
            'redirect' => route('admin.setting.form', [$form]),
        ]);
    }

    protected function getForms()
    {
        $items = [
            'general' => [
                'name' => trans('juzacms::app.general_setting'),
                'view' => 'juzacms::backend.setting.system.form.general'
            ],
            'recaptcha' => [
                'name' => trans('juzacms::app.google_recaptcha'),
                'view' => 'juzacms::backend.setting.system.form.recaptcha'
            ]
        ];

        return apply_filters('admin.general_settings.forms', $items);
    }

    protected function getSettings()
    {
        $items = Config::getConfigs();

        return apply_filters('admin.setting_fields', $items);
    }
}
