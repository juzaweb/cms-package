@extends('juzacms::layouts.backend')

@section('content')
    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <div class="btn-group float-right">
                <a href="{{ route('admin.notification.create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> @lang('juzacms::app.add_new')</a>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <form method="post" class="form-inline">
                @csrf
                <select name="bulk_actions" class="form-control w-60 mb-2 mr-1">
                    <option value="">@lang('juzacms::app.bulk_actions')</option>
                    <option value="send">@lang('juzacms::app.send')</option>
                    <option value="delete">@lang('juzacms::app.delete')</option>
                </select>

                <button type="submit" class="btn btn-primary mb-2" id="apply-action">@lang('juzacms::app.apply')</button>
            </form>
        </div>

        <div class="col-md-8">
            <form method="get" class="form-inline" id="form-search">
                <div class="form-group mb-2 mr-1">
                    <label for="search" class="sr-only">@lang('juzacms::app.search')</label>
                    <input name="search" type="text" id="search" class="form-control" placeholder="@lang('juzacms::app.search')" autocomplete="off">
                </div>

                <div class="form-group mb-2 mr-1">
                    <label for="status" class="sr-only">@lang('juzacms::app.status')</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">--- @lang('juzacms::app.status') ---</option>
                        <option value="1">@lang('juzacms::app.enabled')</option>
                        <option value="0">@lang('juzacms::app.disabled')</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-search"></i> @lang('juzacms::app.search')</button>
            </form>
        </div>
    </div>

    <div class="table-responsive mb-5">
        <table class="table juzacms-table">
            <thead>
                <tr>
                    <th data-width="3%" data-field="state" data-checkbox="true"></th>
                    <th data-field="subject" data-formatter="subject_formatter">@lang('juzacms::app.subject')</th>
                    <th data-field="method" data-width="20%" data-formatter="via_formatter">@lang('juzacms::app.via')</th>
                    <th data-field="created" data-width="15%">@lang('juzacms::app.created_at')</th>
                    <th data-field="error" data-width="15%">@lang('juzacms::app.error')</th>
                    <th data-field="status" data-width="15%" data-align="center" data-formatter="status_formatter">@lang('juzacms::app.status')</th>
                </tr>
            </thead>
        </table>
    </div>

    <script type="text/javascript">
        function via_formatter(value, row, index) {
            if (row.method) {
                return row.method;
            }

            return "{{ trans('juzacms::app.all') }}";
        }

        function subject_formatter(value, row, index) {
            return '<a href="'+ row.edit_url +'">'+ row.data.subject +'</a>';
        }

        function status_formatter(value, row, index) {
            let status = parseInt(value);

            switch (status) {
                case 0: return "{{ trans('juzacms::app.error') }}";
                case 1: return "{{ trans('juzacms::app.sended') }}";
                case 2: return "{{ trans('juzacms::app.pending') }}";
                case 3: return "{{ trans('juzacms::app.sending') }}";
                case 4: return "{{ trans('juzacms::app.unsent') }}";
            }
        }

        var table = new JuzawebTable({
            url: '{{ route('admin.notification.get-data') }}',
            action_url: '{{ route('admin.notification.bulk-actions') }}',
        });
    </script>
@endsection