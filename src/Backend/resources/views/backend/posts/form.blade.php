@extends('juzacms::layouts.backend')

@section('content')

    @component('juzacms::components.form_resource', [
        'method' => $model->id ? 'put' : 'post',
        'action' =>  $model->id ?
            route('admin.posts.update', [$model->id]) :
            route('admin.posts.store')
    ])
        <div class="row">
            <div class="col-md-8">

                <div class="form-group">
                    <label class="col-form-label" for="title">@lang('juzacms::app.title')</label>
                    <input type="text" name="title" class="form-control" id="title" value="{{ $model->title }}" autocomplete="off" required>
                </div>

                @include('juzacms::components.form_ckeditor', [
                    'name' => 'content',
                    'value' => $model->content,
                ])

                @component('juzacms::components.form_select', [
                    'label' => trans('juzacms::app.status'),
                    'name' => 'status',
                    'value' => $model->status,
                    'options' => [
                        'public' => trans('juzacms::app.public'),
                        'private' => trans('juzacms::app.private'),
                        'draft' => trans('juzacms::app.draft'),
                    ],
                ])
                @endcomponent

                @do_action('post_type.'. $postType .'.form.left')
                {{--@include('juzacms::backend.seo_form')--}}
            </div>

            <div class="col-md-4">
                @component('juzacms::components.form_image', [
                    'label' => trans('juzacms::app.thumbnail'),
                    'name' => 'thumbnail',
                    'value' => $model->thumbnail,
                ])@endcomponent

                @do_action('post_type.'. $postType .'.form.rigth', $model)
            </div>
        </div>
    @endcomponent

@endsection
