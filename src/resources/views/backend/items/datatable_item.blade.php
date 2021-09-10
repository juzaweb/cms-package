<div class="font-weight-bold">{{ $value }}</div>
<ul class="list-inline mb-0 list-actions mt-2 ">
    @foreach($actions as $key => $action)
    @php
        $hasAction = empty($action['action']) ? false : true;
    @endphp
    <li class="list-inline-item">
        <a
                href="{{ $action['url'] ?? 'javascript:void(0)' }}"
                class="jw-table-row {{ $action['class'] ?? '' }} {{ $hasAction ? 'action-item' : '' }}"
                data-id="{{ $row->id ?? '' }}"
                @if(!empty($action['target'])) target="{{ $action['target'] }}" @endif
                @if($hasAction) data-action="{{ $action['action'] }}" @endif
        >
            {{ $action['label'] ?? '' }}
        </a>
    </li>
    @endforeach
</ul>
