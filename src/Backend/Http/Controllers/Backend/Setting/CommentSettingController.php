<?php

namespace Juzaweb\Cms\Backend\Http\Controllers\Backend\Setting;

use Juzaweb\Cms\Core\Models\Config;
use Illuminate\Http\Request;
use Juzaweb\Cms\Backend\Http\Controllers\Controller;

class CommentSettingController extends Controller
{
    public function index() {
        return view('juzacms::backend.setting.comment.index', [
            'title' => trans('juzacms::app.comment_setting')
        ]);
    }
    
    public function save(Request $request) {
        $this->validateRequest([
            'comment_able' => 'required|in:0,1',
            'comment_type' => 'required_if:comment_able,!=,0|string|max:300',
            'comments_per_page' => 'required|string|max:300',
            'comments_approval' => 'required|string|max:300',
        ], $request, [
            'comment_able' => trans('juzacms::app.comment_able'),
            'comment_type' => trans('juzacms::app.comment_type'),
            'comments_per_page' => trans('juzacms::app.comments_per_page'),
            'comments_approval' => trans('juzacms::app.comments_approval'),
        ]);
    
        $configs = $request->only([
            'comment_able',
            'comment_type',
            'comments_per_page',
            'comments_approval',
        ]);
        
        foreach ($configs as $key => $config) {
            Config::setConfig($key, $config);
        }
    
        return response()->json([
            'status' => 'success',
            'message' => trans('juzacms::app.saved_successfully'),
            'redirect' => route('admin.setting.comment'),
        ]);
    }
}
