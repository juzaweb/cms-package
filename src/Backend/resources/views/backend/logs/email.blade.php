@extends('juzacms::layouts.backend')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="float-right">
                <div class="btn-group">
                    <button type="button" class="btn btn-success status-button" data-status="2"><i class="fa fa-refresh"></i> @lang('juzacms::app.resend')</button>

                    <button type="button" class="btn btn-warning status-button" data-status="3"><i class="fa fa-times-circle"></i> @lang('juzacms::app.cancel')</button>
                </div>

                <div class="btn-group">
                    <button type="button" class="btn btn-danger" id="delete-item"><i class="fa fa-trash"></i> @lang('juzacms::app.delete')</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12">
            <form method="get" class="form-inline" id="form-search">

                <div class="form-group mb-2 mr-1">
                    <label for="search" class="sr-only">@lang('juzacms::app.search')</label>
                    <input name="search" type="text" id="search" class="form-control" placeholder="@lang('juzacms::app.search')" autocomplete="off">
                </div>

                <div class="form-group mb-2 mr-1">
                    <label for="status" class="sr-only">@lang('juzacms::app.status')</label>
                    <select name="status" id="status" class="form-control select2-default">
                        <option value="">--- @lang('juzacms::app.status') ---</option>
                        <option value="1">@lang('juzacms::app.sended')</option>
                        <option value="2">@lang('juzacms::app.pending')</option>
                        <option value="3">@lang('juzacms::app.cancel')</option>
                        <option value="0">@lang('juzacms::app.error')</option>
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
                    <th data-field="subject">@lang('juzacms::app.subject')</th>
                    <th data-width="30%" data-field="content">@lang('juzacms::app.content')</th>
                    <th data-width="15%" data-field="created">@lang('juzacms::app.created_at')</th>
                    <th data-width="15%" data-field="status" data-align="center" data-formatter="status_formatter">@lang('juzacms::app.status')</th>
                </tr>
            </thead>
        </table>
    </div>

    <script type="text/javascript">
        function status_formatter(value, row, index) {
            if (value == 'success') {
                return '<span class="text-success">@lang('juzacms::app.sended')</span>';
            }
            
            if (value == 'pending') {
                return '<span class="text-warning">@lang('juzacms::app.pending')</span>';
            }

            if (value == 'cancel') {
                return '<span class="text-success">@lang('juzacms::app.cancel')</span>';
            }
            
            return '<span class="text-danger">@lang('juzacms::app.error')</span>';
        }

        var table = new JuzawebTable({
            url: '{{ route('admin.logs.email.getdata') }}',
            action_url: '{{ route('admin.logs.email.status') }}',
        });
    </script>
@endsection