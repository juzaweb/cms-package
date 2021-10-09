@extends('juzaweb::layouts.backend')

@section('content')

    @component('juzaweb::components.form_resource', [
        'model' => $model,
    ])
        <div class="row">
            <div class="col-md-8">

                {{ Field::text($model, 'title', [
                    'required' => true,
                    'class' => empty($model->slug) ? 'generate-slug' : '',
                ]) }}

                {{ Field::editor($model, 'content') }}

                @do_action('post_type.'. $postType .'.form.left')

            </div>

            <div class="col-md-4">

                {{ Field::select($model, 'status', [
                    'options' => $model->getStatuses()
                ]) }}

                {{ Field::image($model, 'thumbnail') }}

                {{ Field::slug($model, 'slug') }}

                @do_action('post_type.'. $postType .'.form.right', $model)
            </div>
        </div>
    @endcomponent

@endsection
