<div class="form-group">
    <label class="col-form-label" for="{{ $name }}">
        {{ $label ?? $name }} @if($required ?? false) <abbr>*</abbr> @endif
    </label>

    <input
        type="text"
        name="{{ $name }}"
        class="form-control {{ $class ?? '' }}"
        id="{{ $name }}"
        value="{{ $value ?? '' }}"
        autocomplete="off"
        @if($required ?? false) required @endif
        @if ($readonly ?? false) readonly @endif
        @foreach ($data ?? [] as $key => $val)
            {{ 'data-' . $key. '="'. $val .'"' }}
        @endforeach
    >
</div>