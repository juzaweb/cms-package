<div class="card sidebar-item" id="sidebar-{{ $item->get('key') }}">
    <div class="card-header">
        <h5>{{ $item->get('label') }}</h5>

        <div class="text-right right-actions">
            <a href="javascript:void(0)" class="show-edit-form">
                <i class="fa fa-sort-down fa-2x"></i>
            </a>
        </div>
    </div>

    <div class="card-body @if(empty($show)) box-hidden @endif">
        <div class="dd jw-widget-builder" data-key="{{ $item->get('key') }}">
            @php
            $widgets = jw_get_widgets_sidebar($item->get('key'));
            @endphp
            <ol class="dd-list">
                @foreach($widgets as $key => $widget)
                    @php
                    $widgetData = \Juzaweb\Facades\HookAction::getWidgets($widget['widget'] ?? 'null');
                    @endphp

                    @component('juzaweb::backend.widget.components.sidebar_widget_item', [
                        'widget' => $widgetData,
                        'sidebar' => $item,
                        'key' => $key,
                        'data' => $widget
                    ])
                    @endcomponent
                @endforeach
            </ol>
        </div>

        <button type="button" class="btn btn-success save-sidebar-widget" data-sidebar="{{ $item->get('key') }}">
            <i class="fa fa-save"></i> {{ trans('juzaweb::app.save') }}
        </button>

    </div>
</div>
