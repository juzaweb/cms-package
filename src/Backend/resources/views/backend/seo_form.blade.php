<hr class="mt-4 mb-4">

<h5>@lang('juzacms::app.seo_and_marketing')</h5>

<div class="form-group">
    <label class="col-form-label" for="meta_title">@lang('juzacms::app.meta_title')</label>
    <input type="text" name="meta_title" id="meta_title" class="form-control" autocomplete="off" value="{{ $model->meta_title }}">
</div>

<div class="form-group">
    <label class="col-form-label" for="slug">@lang('juzacms::app.meta_description')</label>
    <textarea name="meta_description" id="meta_description" class="form-control" rows="5">{{ $model->meta_description }}</textarea>
</div>

<div class="form-group">
    <label class="col-form-label" for="keywords">@lang('juzacms::app.keywords')</label>
    <input type="text" name="keywords" id="keywords" class="form-control" autocomplete="off" value="{{ $model->keywords }}">
    <p class="description">@lang('juzacms::app.use_comma_to_separate_keyword')</p>
</div>

<div class="form-group">
    <label class="col-form-label" for="slug">@lang('juzacms::app.slug')</label>
    <input type="text" name="slug" id="slug" class="form-control" autocomplete="off" value="{{ $model->slug }}">
</div>