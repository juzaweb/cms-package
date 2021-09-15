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
                'blocks' => [
                    'label' => trans('juzaweb::app.blocks'),
                ],
            ],
        ])

        @slot('tab_information')
            <div class="row">
                <div class="col-md-8">

                    @component('juzaweb::components.form_input', [
                        'label' => trans('juzaweb::app.title'),
                        'name' => 'title',
                        'value' => $model->title,
                        'required' => true,
                        'options' => [
                            'class' => empty($model->slug) ? 'generate-slug' : '',
                        ],
                    ])@endcomponent

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

                    @component('juzaweb::components.form_slug', [
                        'label' => trans('juzaweb::app.slug'),
                        'name' => 'slug',
                        'value' => $model->slug,
                    ])@endcomponent

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
        @endslot

        @endcomponent

        <input type="hidden" name="id" value="{{ $model->id }}">

    @endcomponent

@endsection
