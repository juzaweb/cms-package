@extends('juzaweb::layouts.backend')

@section('content')

    <div class="row mb-3">
        <div class="col-md-12">
            <form method="get" class="form-inline" id="form-search">

                <div class="form-group mb-2 mr-1">
                    <label for="search" class="sr-only">@lang('juzaweb::app.search')</label>
                    <input name="search" type="text" id="search" class="form-control" placeholder="{{ trans('juzaweb::app.search') }}" autocomplete="off">
                </div>

                <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-search"></i> {{ trans('juzaweb::app.search') }}</button>
            </form>
        </div>

    </div>

    <div class="table-responsive mb-5">
        <table class="table juzaweb-table">
            <thead>
                <tr>
                    <th data-width="3%" data-field="state" data-checkbox="true"></th>
                    <th data-field="date">@lang('juzaweb::app.date')</th>
                    <th data-width="10%" data-align="center" data-field="all">@lang('juzaweb::app.content')</th>
                    <th data-width="10%" data-align="center" data-field="emergency">@lang('juzaweb::app.emergency')</th>
                    <th data-width="10%" data-align="center" data-field="error">@lang('juzaweb::app.error')</th>
                    <th data-width="10%" data-align="center" data-field="info">@lang('juzaweb::app.info')</th>
                    <th data-width="10%" data-align="center" data-field="warning">@lang('juzaweb::app.warning')</th>
                    <th data-width="10%" data-align="center" data-field="notice">@lang('juzaweb::app.notice')</th>
                    <th data-width="15%" data-align="center" data-formatter="action_formatter">{{ trans('juzaweb::app.actions') }}</th>
                </tr>
            </thead>
        </table>
    </div>

    <script type="text/javascript">
        function action_formatter(value, row, index) {
            let str = `<a href="${row.edit_url}" class="btn btn-info px-2"><i class="fa fa-search"></i></a>`;
            str += `<a href="javascript:void(0)" class="btn btn-danger px-2"><i class="fa fa-trash"></i></a>`;
            return str;
        }

        var table = new JuzawebTable({
            url: '{{ route('admin.logs.error.get-logs') }}',
        });
    </script>

@endsection