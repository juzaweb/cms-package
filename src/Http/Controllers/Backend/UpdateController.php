<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzawebcms/juzawebcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzawebcms/juzawebcms
 * @license    MIT
 *
 * Created by JUZAWEB.
 * Date: 6/13/2021
 * Time: 11:09 AM
 */

namespace Juzaweb\Http\Controllers\Backend;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Juzaweb\Http\Controllers\BackendController;
use Juzaweb\Support\Manager\UpdateManager;

class UpdateController extends BackendController
{
    public function index()
    {
        $title = trans('juzaweb::app.updates');
        $updater = app(UpdateManager::class);
        $checkUpdate = Cache::remember('check_update', 3600, function () use ($updater) {
            return $updater->checkUpdate();
        });

        $versionAvailable = null;
        if ($checkUpdate) {
            $versionAvailable = Cache::remember('check_update_available', 3600, function () use ($updater) {
                return $updater->getVersionAvailable();
            });
        }

        return view('juzaweb::backend.update', compact(
            'title',
            'checkUpdate',
            'versionAvailable'
        ));
    }

    public function update()
    {
        set_time_limit(0);

        DB::beginTransaction();

        try {
            $update = new UpdateManager();
            $update->update();
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            throw $e;
        }

        Cache::forget('check_update');
        Cache::forget('check_update_available');

        return $this->success([
            'message' => trans('juzaweb::app.updated_successfully'),
        ]);
    }
}
