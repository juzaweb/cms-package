<div class="font-weight-bold">{{ $value }}</div>
<ul class="list-inline mb-0 list-actions mt-2 ">
    @foreach($actions as $key => $action)
    @php
        $actionClass = empty($action['action']) ? '' : $action['action'] . '-item';
    @endphp
    <li class="list-inline-item">
        <a
                href="{{ $action['url'] ?? 'javascript:void(0)' }}"
                class="jw-table-row {{ $action['class'] ?? '' }} {{ $actionClass }}"
                data-id="{{ $row->id ?? '' }}"
        >
            {{ $action['label'] ?? '' }}
        </a>
    </li>
    @endforeach
</ul>
