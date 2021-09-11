@extends('juzaweb::layouts.backend')

@section('content')

    @component('juzaweb::components.form_resource', [
        'method' => $model->id ? 'put' : 'post',
        'action' =>  $model->id ?
            route('admin.posts.update', [$model->id]) :
            route('admin.posts.store')
    ])
        <div class="row">
            <div class="col-md-8">

                <div class="form-group">
                    <label class="col-form-label" for="title">@lang('juzaweb::app.title')</label>
                    <input type="text" name="title" class="form-control" id="title" value="{{ $model->title }}" autocomplete="off" required>
                </div>

                @component('juzaweb::components.form_ckeditor', [
                    'name' => 'content',
                    'value' => $model->content,
                ])@endcomponent

                @do_action('post_type.'. $postType .'.form.left')

            </div>

            <div class="col-md-4">

                @component('juzaweb::components.form_select', [
                    'label' => trans('juzaweb::app.status'),
                    'name' => 'status',
                    'value' => $model->status,
                    'options' => $model->getStatuses(),
                ])
                @endcomponent

                @component('juzaweb::components.form_image', [
                    'label' => trans('juzaweb::app.thumbnail'),
                    'name' => 'thumbnail',
                    'value' => $model->thumbnail,
                ])@endcomponent

                @do_action('post_type.'. $postType .'.form.right', $model)
            </div>
        </div>
    @endcomponent

@endsection
