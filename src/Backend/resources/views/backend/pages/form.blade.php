@extends('juzacms::layouts.backend')

@section('content')

    @component('juzacms::components.form_resource', [
        'action' => route('admin.page.save')
    ])
        <div class="row">
            <div class="col-md-8">

                <div class="form-group">
                    <label class="col-form-label" for="baseName">@lang('juzacms::app.name')</label>

                    <input type="text" name="name" class="form-control" id="baseName" value="{{ $model->name }}" autocomplete="off" required>
                </div>

                @component('juzacms::components.form_ckeditor', [
                    'label' => trans('juzacms::app.content'),
                    'name' => 'content',
                    'value' => $model->content
                ])
                @endcomponent

                <div class="form-group">
                    <label class="col-form-label" for="baseStatus">@lang('juzacms::app.status')</label>
                    <select name="status" id="baseStatus" class="form-control">
                        <option value="1" @if($model->status == 1) selected @endif>@lang('juzacms::app.enabled')</option>
                        <option value="0" @if($model->status == 0 && !is_null($model->status)) selected @endif>@lang('juzacms::app.disabled')</option>
                    </select>
                </div>
            </div>

            <div class="col-md-4">

                @component('juzacms::components.form_image', [
                    'label' => trans('juzacms::app.thumbnail'),
                    'name' => 'thumbnail',
                    'value' => $model->thumbnail
                ])
                @endcomponent

            </div>
        </div>

        <input type="hidden" name="id" value="{{ $model->id }}">
    @endcomponent

@endsection
