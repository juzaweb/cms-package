@extends('juzaweb::layouts.backend')

@section('content')

    <table class="table juzaweb-table">
        <thead>
            <tr>
                <th data-field="datetime" data-width="5%" data-formatter="time_formatter">@lang('juzaweb::app.time')</th>
                <th data-width="5%" data-align="center" data-field="level" data-formatter="level_formatter">@lang('juzaweb::app.level')</th>
                <th data-field="header" data-formatter="header_formatter" data-width="50%">@lang('juzaweb::app.header')</th>
                <th data-width="10%" data-align="center" data-formatter="actions_formatter">@lang('juzaweb::app.actions')</th>
            </tr>
        </thead>
    </table>

    <script type="text/javascript">
        function time_formatter(value, row, index) {
            return value.split(' ')[1] ?? '';
        }

        function level_formatter(value, row, index) {
            let spanClass = 'badge badge-info';
            switch (value) {
                case 'error':
                    spanClass = 'badge badge-danger';
            }
            return `<span class="p-2 ${spanClass}">${value}</span>`;
        }
        
        function header_formatter(value, row, index) {
            let key = row.datetime.split(' ')[1] ?? '';
            key = key.replace(/:/g, '-');

            return `<div style="max-width: 100px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    text-align: center;">${value}</div>  <div class="stack-content collapse" id="log-stack-${key}" style="overflow: hidden;"><pre>${row.stack}</pre></div>`;
        }

        function actions_formatter(value, row, index) {
            let key = row.datetime.split(' ')[1] ?? '';
            key = key.replace(/:/g, '-');

            let str = `<a class="btn btn-info px-2 btn-sm stack-log" data-toggle="collapse" href="#log-stack-${key}" aria-expanded="false" aria-controls="log-stack-${key}"><i class="fa fa-toggle-off"></i> ${juzaweb.lang.stack}</a>`;
            return str;
        }
        
        var table = new JuzawebTable({
            url: '{{ route('admin.logs.error.get-logs-date', [$date]) }}',
        });
    </script>

@endsection