@extends('juzaweb::layouts.backend')

@section('content')

    <div class="row" id="widget-container">
        <div class="col-md-4">
            @foreach($widgets as $key => $widget)
                @component('juzaweb::backend.widget.components.widget_item', [
                        'widget' => $widget,
                        'key' => $key,
                        'sidebars' => $sidebars
                    ])
                @endcomponent
            @endforeach
        </div>

        <div class="col-md-8">
            @foreach($sidebars as $key => $sidebar)
                @component('juzaweb::backend.widget.components.sidebar_item', [
                    'item' => $sidebar
                ])
                @endcomponent
            @endforeach
        </div>
    </div>
@endsection