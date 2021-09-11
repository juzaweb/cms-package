<div class="form-group">
    <label class="col-form-label">{{ trans('juzaweb::app.label') }}</label>
    <input type="text" class="form-control change-label menu-data" data-name="label" autocomplete="off" value="{{ $item->label }}">
</div>

<div class="form-group">
    <label class="col-form-label">Model</label>
    <p><b><a href="{{ route('admin.' . $postType->get('key') . '.edit', [$item->model_id]) }}">{{ class_basename($item->model_class) }}</a></b></p>
</div>
