<div class="form-group">
    <label class="col-form-label" for="{{ $name }}">
        {{ $label ?? $name }}
    </label>

    <input
        type="text"
        name="{{ $name }}"
        class="form-control {{ $options['class'] ?? '' }}"
        value="{{ $value ?? '' }}"
        autocomplete="off"
    >
</div>
