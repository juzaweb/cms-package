@extends('juzaweb::layouts.backend')

@section('content')

    @component('juzaweb::components.form_resource', [
        'model' => $model,
    ])

        @component('juzaweb::components.tabs', [
            'tabs' => [
                'information' => [
                    'label' => trans('juzaweb::app.information'),
                ],
            ],
        ])

        @slot('tab_information')
            <div class="row">
                <div class="col-md-8">

                    {{ Field::text($model, 'title', [
                        'required' => true,
                        'class' => empty($model->slug) ? 'generate-slug' : '',
                    ]) }}

                    {{ Field::editor($model, 'content') }}

                    @do_action('post_type.pages.form.left')

                </div>

                <div class="col-md-4">

                    {{ Field::select($model, 'status', [
                        'options' => $model->getStatuses()
                    ]) }}

                    {{ Field::slug($model, 'slug') }}

                    {{ Field::select($model, 'template', [
                        'options' => array_merge([
                            '' => trans('juzaweb::app.page_template')
                        ], $templates)
                    ]) }}

                    {{ Field::image($model, 'thumbnail') }}

                    @do_action('post_type.pages.form.right', $model)

                </div>
            </div>
        @endslot

        @endcomponent

    @endcomponent

@endsection
