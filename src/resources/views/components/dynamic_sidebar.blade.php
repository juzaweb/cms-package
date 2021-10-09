@foreach ($widgets as $widget)
    @php
        $widgetData = \Juzaweb\Facades\HookAction::getWidgets($widget['widget'] ?? 'null');
    @endphp

    {!! $sidebar->get('before_widget') !!}

        {{ $widgetData['widget']->show($widget) }}

    {!! $sidebar->get('after_widget') !!}

@endforeach