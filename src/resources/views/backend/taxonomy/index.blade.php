@extends('juzaweb::layouts.backend')

@section('content')

    <div class="row">
        <div class="col-md-4">
            <h5>{{ trans('juzaweb::app.add_new') }}</h5>
            @php
                $type = $setting->get('type');
                $postType = $setting->get('post_type');
            @endphp

            <form method="post" action="{{ route('admin.'. $type .'.taxonomy.store', [$taxonomy]) }}" class="form-ajax" data-success="reload_data" id="form-add">

                @component('juzaweb::components.form_input', [
                    'name' => 'name',
                    'label' => trans('juzaweb::app.name'),
                    'value' => '',
                    'required' => true,
                ])
                @endcomponent

                @component('juzaweb::components.form_textarea', [
                    'name' => 'description',
                    'rows' => '3',
                    'label' => trans('juzaweb::app.description'),
                    'value' => ''
                ])
                @endcomponent

                @if(in_array('hierarchical', $setting->get('supports', [])))
                    <div class="form-group">
                        <label class="col-form-label" for="parent_id">{{ trans('juzaweb::app.parent') }}</label>
                        <select name="parent_id" id="parent_id" class="form-control load-taxonomies" data-post-type="{{ $setting->get('post_type') }}" data-taxonomy="{{ $setting->get('taxonomy') }}" data-placeholder="{{ trans('juzaweb::app.parent') }}">
                        </select>
                    </div>
                @endif

                    <input type="hidden" name="post_type" value="{{ $postType }}">
                    <input type="hidden" name="taxonomy" value="{{ $taxonomy }}">

                <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i>
                    {{ trans('juzaweb::app.add') }} {{ $setting->get('label') }}
                </button>
            </form>
        </div>

        <div class="col-md-8">
            {{ $dataTable->render() }}
        </div>


    </div>

    <script type="text/javascript">
        function reload_data(form) {
            $('#form-add input, #form-add textarea').val(null);
            $('#form-add #parent_id').val(null).trigger('change.select2');
            table.refresh();
        }
    </script>

@endsection
