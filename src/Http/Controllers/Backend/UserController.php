<?php

namespace Juzaweb\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Juzaweb\Http\Controllers\BackendController;
use Juzaweb\Http\Datatables\UserDataTable;
use Juzaweb\Models\User;
use Juzaweb\Traits\ResourceController;

class UserController extends BackendController
{
    use ResourceController;

    protected $viewPrefix = 'juzaweb::backend.user';

    /**
     * Validator for store and update
     *
     * @param array $attributes
     * @return \Illuminate\Support\Facades\Validator|array
     */
    protected function validator(array $attributes)
    {
        $allStatus = array_keys(User::getAllStatus());

        return [
            'name' => 'required|string|max:250',
            'password' => 'required_if:id,',
            'avatar' => 'nullable|string|max:150',
            'email' => 'required_if:id,|unique:users,email',
            'status' => 'required|in:' . implode(',', $allStatus),
        ];
    }

    /**
     * Get model resource
     *
     * @return string
     */
    protected function getModel()
    {
        return User::class;
    }

    /**
     * Get title resource
     *
     * @return string
     **/
    protected function getTitle()
    {
        return trans('juzaweb::app.users');
    }

    /**
     * Get data table resource
     *
     * @return \Juzaweb\Abstracts\DataTable
     */
    protected function getDataTable()
    {
        return new UserDataTable();
    }

    protected function getDataForForm($model)
    {
        $allStatus = User::getAllStatus();

        return [
            'model' => $model,
            'allStatus' => $allStatus,
        ];
    }

    /**
     * After Save model
     *
     * @param Request $request
     * @param \Juzaweb\Models\Model $model
     */
    protected function afterSave(Request $request, $model)
    {
        $model->setAttribute('is_admin', $request->post('is_admin', 0));

        if ($request->post('password')) {
            $request->validate([
                'password' => 'required|string|max:32|min:8|confirmed',
                'password_confirmation' => 'required|string|max:32|min:8',
            ], [], [
                'password' => trans('juzaweb::app.password'),
                'password_confirmation' => trans('juzaweb::app.confirm_password'),
            ]);

            $model->setAttribute('password', Hash::make($request->post('password')));
        }

        $model->save();
    }
}
