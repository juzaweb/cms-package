<div class="form-group">
    <label class="col-form-label" for="{{ $name }}">
        {{ $label ?? $name }}
    </label>

    <textarea
        name="{{ $name }}"
        class="form-control {{ $options['class'] ?? '' }}"
        autocomplete="off"
    >{{ $value ?? '' }}</textarea>
</div>