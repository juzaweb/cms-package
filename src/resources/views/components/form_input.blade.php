<div class="form-group">
    <label class="col-form-label" for="{{ $name }}">
        {{ $label ?? $name }} @if($required) <abbr>*</abbr> @endif
    </label>

    <input
        type="text"
        name="{{ $name }}"
        class="form-control {{ $options['class'] ?? '' }}"
        id="{{ $name }}"
        value="{{ $value ?? '' }}"
        autocomplete="off"
        @if($required ?? false) required @endif
        @if ($options['readonly'] ?? false) readonly @endif
        @foreach ($options['data'] ?? [] as $key => $val)
            {{ 'data-' . $key. '="'. $val .'"' }}
        @endforeach
    >
</div>