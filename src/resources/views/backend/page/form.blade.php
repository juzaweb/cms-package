@extends('juzaweb::layouts.backend')

@section('content')

    @component('juzaweb::components.form_resource', [
        'action' => $model->id ? route('admin.pages.update', [$model->id]) : route('admin.pages.store'),
        'method' => $model->id ? 'put' : 'post'
    ])
        <div class="row">
            <div class="col-md-8">

                <div class="form-group">
                    <label class="col-form-label" for="title">@lang('juzaweb::app.title')</label>
                    <input type="text" name="title" class="form-control" id="title" value="{{ $model->title }}" autocomplete="off" required>
                </div>

                @component('juzaweb::components.form_ckeditor', [
                    'label' => trans('juzaweb::app.content'),
                    'name' => 'content',
                    'value' => $model->content
                ])
                @endcomponent

            </div>

            <div class="col-md-4">

                @component('juzaweb::components.form_select', [
                    'label' => trans('juzaweb::app.status'),
                    'name' => 'status',
                    'value' => $model->status,
                    'options' => $model->getStatuses(),
                ])
                @endcomponent

                @component('juzaweb::components.form_select', [
                    'label' => trans('juzaweb::app.template'),
                    'name' => 'template',
                    'value' => $model->template,
                    'options' => array_merge([
                        '' => trans('juzaweb::app.page_template')
                    ], $templates),
                ])
                @endcomponent

                @component('juzaweb::components.form_image', [
                    'label' => trans('juzaweb::app.thumbnail'),
                    'name' => 'thumbnail',
                    'value' => $model->thumbnail
                ])
                @endcomponent
            </div>
        </div>

        <input type="hidden" name="id" value="{{ $model->id }}">
    @endcomponent

@endsection
