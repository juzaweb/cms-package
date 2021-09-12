{{--<ul class="nav nav-tabs">
    <li class="nav-item">
        <a href="javascript:void(0)" class="nav-link active">{{ trans('juzaweb::app.information') }}</a>
    </li>
</ul>--}}

{{--<div class="tab-content">
    <div class="tab-pane p-2 active" role="tabpanel" aria-labelledby="home-tab">--}}
        <form
                action="{{ $action ?? '' }}"
                method="post"
                class="form-ajax"
                id="{{ random_string() }}"
        >
            @csrf

            @if(isset($method) && $method == 'put')
                @method('PUT')
            @endif

            <div class="row mb-2">
                <div class="col-md-6"></div>

                <div class="col-md-6">
                    <div class="btn-group float-right">
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> @lang('juzaweb::app.save')</button>

                        <button type="button" class="btn btn-warning cancel-button"><i class="fa fa-refresh"></i> @lang('juzaweb::app.reset')</button>
                    </div>
                </div>
            </div>

            {{ $slot ?? '' }}

            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> @lang('juzaweb::app.save')</button>
                        <button type="button" class="btn btn-warning cancel-button"><i class="fa fa-refresh"></i> @lang('juzaweb::app.reset')</button>
                    </div>
                </div>
            </div>

        </form>
   {{-- </div>
</div>--}}

