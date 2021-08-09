<form method="post" action="{{ route('admin.setting.save') }}" class="form-ajax">
    <input type="hidden" name="form" value="general">
    @php
        $registration = get_config('user_registration');
        $verification = get_config('user_verification');
        //$only_member_view = get_config('only_member_view');
    @endphp

    <h5>@lang('juzacms::app.general')</h5>

    <div class="form-group">
        <label class="col-form-label" for="title">@lang('juzacms::app.home_title')</label>

        <input type="text" name="title" class="form-control" id="title" value="{{ get_config('title') }}" autocomplete="off" required>
    </div>

    <div class="form-group">
        <label class="col-form-label" for="keywords">@lang('juzacms::app.keywords')</label>

        <input type="text" name="keywords" id="keywords" class="form-control" value="{{ get_config('keywords') }}" autocomplete="off">
        <em class="description">@lang('juzacms::app.use_comma_to_separate_keyword')</em>
    </div>

    <div class="form-group">
        <label class="col-form-label" for="description">@lang('juzacms::app.home_description')</label>
        <textarea class="form-control" name="description" id="description" rows="5">{{ get_config('description') }}</textarea>
    </div>

    <div class="form-group">
        <label class="col-form-label" for="logo">@lang('juzacms::app.logo') <span class="float-right"><a href="javascript:void(0)" data-input="logo" data-preview="preview-logo" class="file-manager"><i class="fa fa-edit"></i> @lang('juzacms::app.change_image')</a></span></label>
        <div id="preview-logo">
            <img src="{{ image_url(get_config('logo')) }}" alt="" class="w-25">
        </div>
        <input id="logo" class="form-control" type="hidden" name="logo" value="{{ get_config('logo') }}">
    </div>

    <div class="form-group">
        <label class="col-form-label" for="icon">@lang('juzacms::app.icon') <span class="float-right"><a href="javascript:void(0)" data-input="icon" data-preview="preview-icon" class="file-manager"><i class="fa fa-edit"></i> @lang('juzacms::app.change_image')</a></span></label>
        <div id="preview-icon">
            <img src="{{ image_url(get_config('icon')) }}" alt="" class="w-25">
        </div>
        <input id="icon" class="form-control" type="hidden" name="icon" value="{{ get_config('icon') }}">
    </div>

    <div class="form-group">
        <label class="col-form-label" for="banner">@lang('juzacms::app.banner') <span class="float-right"><a href="javascript:void(0)" data-input="banner" data-preview="preview-banner" class="file-manager"><i class="fa fa-edit"></i> @lang('juzacms::app.change_image')</a></span></label>
        <div id="preview-banner">
            <img src="{{ image_url(get_config('banner')) }}" alt="" class="w-25">
        </div>
        <input id="banner" class="form-control" type="hidden" name="banner" value="{{ get_config('banner') }}">
    </div>

    <div class="form-group">
        <label class="col-form-label" for="fb_app_id">@lang('juzacms::app.fb_app_id')</label>

        <input type="text" name="fb_app_id" class="form-control" id="fb_app_id" value="{{ get_config('fb_app_id') }}" autocomplete="off">
    </div>

    <div class="form-group">
        <label class="col-form-label" for="google_analytics">@lang('juzacms::app.google_analytics_id')</label>

        <input type="text" name="google_analytics" class="form-control" id="google_analytics" value="{{ get_config('google_analytics') }}" autocomplete="off">
    </div>

    <h5>@lang('juzacms::app.registration')</h5>
    <div class="form-group">
        <label class="col-form-label" for="user_registration">@lang('juzacms::app.user_registration')</label>
        <select name="user_registration" id="user_registration" class="form-control">
            <option value="1" @if($registration == 1) selected @endif>@lang('juzacms::app.enabled')</option>
            <option value="0" @if($registration == 0) selected @endif>@lang('juzacms::app.disabled')</option>
        </select>
    </div>

    <div class="form-group">
        <label class="col-form-label" for="user_verification">@lang('juzacms::app.user_e_mail_verification')</label>
        <select name="user_verification" id="user_verification" class="form-control">
            <option value="1" @if($verification == 1) selected @endif>@lang('juzacms::app.enabled')</option>
            <option value="0" @if($verification == 0) selected @endif>@lang('juzacms::app.disabled')</option>
        </select>
    </div>

    {{--<h5>@lang('juzacms::app.tmdb')</h5>
    <div class="form-group">
        <label class="col-form-label" for="tmdb_api_key">@lang('juzacms::app.tmdb_api_key')</label>

        <input type="text" name="tmdb_api_key" class="form-control" id="tmdb_api_key" value="{{ get_config('tmdb_api_key') }}" autocomplete="off">
    </div>--}}

    <div class="row">
        <div class="col-md-6"></div>

        <div class="col-md-6">
            <div class="btn-group float-right">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-save"></i> @lang('juzacms::app.save')
                </button>

                <button type="reset" class="btn btn-default">
                    <i class="fa fa-refresh"></i> @lang('juzacms::app.reset')
                </button>
            </div>
        </div>
    </div>
</form>