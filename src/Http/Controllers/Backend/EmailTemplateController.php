<?php

namespace Juzaweb\Http\Controllers\Backend;

use Juzaweb\Http\Controllers\BackendController;
use Juzaweb\Http\Datatable\EmailTemplateDataTable;
use Juzaweb\Traits\ResourceController;
use Juzaweb\Models\EmailTemplate;
use Illuminate\Support\Facades\Validator;

class EmailTemplateController extends BackendController
{
    use ResourceController;

    protected $viewPrefix = 'juzaweb::backend.email_template';

    protected function getDataTable()
    {
        return new EmailTemplateDataTable();
    }

    protected function validator(array $attributes)
    {
        $validator = Validator::make($attributes, [
            'code' => 'required|unique:id,' . $attributes['id'],
            'subject' => 'required',
        ]);

        return $validator;
    }

    protected function getModel()
    {
        return EmailTemplate::class;
    }

    protected function getTitle()
    {
        return trans('juzaweb::app.email_templates');
    }
}
