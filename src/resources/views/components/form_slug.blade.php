<div class="form-group">
    <label class="col-form-label" for="{{ $name }}">
        {{ $label ?? $name }}
    </label>

    <div class="input-group">
        <input
                type="text"
                name="{{ $name }}"
                class="form-control {{ $options['class'] ?? '' }}"
                id="{{ $name }}"
                value="{{ $value ?? '' }}"
                autocomplete="off"
                max-length="150"
                readonly

        @foreach ($options['data'] ?? [] as $key => $val)
            {{ 'data-' . $key. '="'. $val .'"' }}
                @endforeach
        >

        <div class="input-group-append">
            <span class="input-group-text">
                <a href="javascript:void(0)" class="slug-edit"><i class="fa fa-edit"></i></a>
            </span>
        </div>
    </div>

</div>