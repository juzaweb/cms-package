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
            $widgets = jw_get_sidebar($item->get('key'));
            @endphp
            <ol class="dd-list">
                @foreach($widgets as $key => $widget)
                    @php
                    $widgetData = \Juzaweb\Facades\HookAction::getWidgets($widget->get('widget'));
                    @endphp
                    @component('juzaweb::backend.widget.components.sidebar_widget_item', [
                        'widget' => $widgetData,
                        'sidebar' => $sidebar,
                        'key' => $item,
                        'data' => $widget->values()
                    ])
                    @endcomponent
                @endforeach
            </ol>
        </div>

        <button type="button" class="btn btn-success save-sidebar-widget">
            <i class="fa fa-save"></i> {{ trans('juzaweb::app.save') }}
        </button>

    </div>
</div>
