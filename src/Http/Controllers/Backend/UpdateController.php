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

use Illuminate\Support\Facades\DB;
use Juzaweb\Http\Controllers\BackendController;
use Juzaweb\Support\Manager\UpdateManager;

class UpdateController extends BackendController
{
    public function index()
    {
        $updater = app(UpdateManager::class);

        return view('juzaweb::backend.update', [
            'title' => trans('juzaweb::app.updates'),
            'updater' => $updater
        ]);
    }

    public function update()
    {
        set_time_limit(0);

        DB::beginTransaction();

        try {
            $update = new UpdateManager();
            $update->updateStep1();
            $update->updateStep2();
            $update->updateStep3();
            $update->updateStep4();
            $update->updateStep5();
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->error([
                'message' => $e->getMessage(),
            ]);
        }

        return $this->success([
            'message' => trans('juzaweb::app.updated_successfully'),
        ]);
    }
}