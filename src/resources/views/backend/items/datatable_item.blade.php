<div class="font-weight-bold">{{ $value }}</div>
<ul class="list-inline mb-0 list-actions mt-2 ">
    @foreach($actions as $key => $action)
    <li class="list-inline-item">
        <a
                href="{{ $action['url'] ?? 'javascript:void(0)' }}"
                class="{{ $action['class'] ?? '' }}"
        >
            {{ $action['label'] ?? '' }}
        </a>
    </li>
    @endforeach
</ul>
