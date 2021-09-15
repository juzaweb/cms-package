@extends('juzaweb::layouts.backend')

@section('content')

    <div class="row" id="widget-container">
        <div class="col-md-4">
            @foreach($widgets as $key => $widget)

            <div class="widget-block">
                <div class="widget-block-body">
                    <a href="javascript:void(0)" class="dropdown-action"><i class="fa fa-sort-down fa-2x"></i></a>
                    <div class="widget-title">{{ $widget->get('label') }}</div>
                    <div class="widget-description">{{ $widget->get('description') }}</div>
                </div>

                <div class="sidebar-blocks">
                    <div class="list-group mt-3">
                        @foreach($sidebars as $key => $sidebar)
                            <a href="javascript:void(0);" class="list-group-item rounded-0">
                                Add to {{ $sidebar->get('label') }}
                            </a>
                        @endforeach
                    </div>

                    <div class="text-center">
                        <button type="button" class="btn btn-success btn-sm mt-2">Add widget</button>
                    </div>

                </div>

            </div>

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