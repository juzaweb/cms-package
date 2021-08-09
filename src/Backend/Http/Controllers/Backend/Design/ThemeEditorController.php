<?php

namespace Juzaweb\Cms\Backend\Http\Controllers\Backend\Design;

use Juzaweb\Cms\Core\Models\Config;
use Juzaweb\Cms\Core\Models\ThemeConfig;
use Illuminate\Http\Request;
use Juzaweb\Cms\Backend\Http\Controllers\BackendController;
use Juzaweb\Cms\Theme\Facades\Theme;

class ThemeEditorController extends BackendController
{
    public function index() {
        Theme::set('juzaweb');
        $config = include base_path('themes/juzaweb/config.php');

        return view('juzaweb::backend.design.editor.index', [
            'config' => $config,
        ]);
    }
    
    public function save(Request $request) {
        $settings = $request->post('setting');
        if ($settings) {
            $configs = Config::getConfigs();
            foreach ($settings as $key => $setting) {
                if (in_array($key, $configs)) {
                    Config::setConfig($key, $setting);
                }
            }
        }
    
        $model = ThemeConfig::firstOrNew(['code' => $request->post('code')]);
        $model->content = response()->json($request->except(['setting']))->getContent();
        $model->save();
        
        return response()->json([
            'status' => 'success',
            'message' => trans('juzaweb::app.saved_successfully'),
        ]);
    }
}
