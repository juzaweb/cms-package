<div class="form-group">
    <label class="col-form-label" for="{{ $name }}">{{ $label ?? $name }}</label>
    <select
            name="{{ $name }}"
            id="{{ $name }}"
            class="form-control load-taxonomies"
            data-post-type="{{ $post_type }}"
            data-taxonomy="{{ $taxonomy }}"
    >
        @foreach($options as $key => $tname)
            <option value="{{ $key }}" @if($key == ($value ?? '')) selected @endif>{{ $tname }}</option>
        @endforeach
    </select>
</div>