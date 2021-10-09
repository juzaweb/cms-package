<div class="form-group">
    <label class="col-form-label">{{ $label ?? '' }}</label>
    <select
            name="{{ $name }}"
            class="form-control load-taxonomies"
            data-post-type="{{ $post_type ?? '' }}"
            data-taxonomy="{{ $taxonomy ?? '' }}"
            data-placeholder="{{ trans('juzaweb::app.select', ['name' => $label ?? '']) }}"
            @if($multiple ?? false) multiple @endif
    >
        @php
            $options = $value ?? [];
            if (!is_array($options)) {
                $options = [$options];
            }

            $selected = \Juzaweb\Models\Taxonomy::whereIn('id', $options)->get();
        @endphp

        @foreach($selected as $item)
            <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
        @endforeach
    </select>
</div>