@extends('juzacms::layouts.backend')

@section('content')
    <div class="row">
        <div class="col-md-6"></div>

        <div class="col-md-6">
            {{--<div class="btn-group float-right">
                <a href="{{ route('admin.plugins.install') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> @lang('juzacms::app.add-new-plugin')</a>
            </div>--}}
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-3">
            <form method="post" class="form-inline">
                @csrf
                <select name="bulk_actions" class="form-control w-60 mb-2 mr-1">
                    <option value="">@lang('juzacms::app.bulk_actions')</option>
                    <option value="delete">@lang('juzacms::app.delete')</option>
                    <option value="activate">@lang('juzacms::app.activate')</option>
                    <option value="deactivate">@lang('juzacms::app.deactivate')</option>
                </select>

                <button type="submit" class="btn btn-primary mb-2" id="apply-action">@lang('juzacms::app.apply')</button>
            </form>
        </div>

        <div class="col-md-9">
            <form method="get" class="form-inline" id="form-search">
                <div class="form-group mb-2 mr-1">
                    <label for="search" class="sr-only">@lang('juzacms::app.search')</label>
                    <input name="search" type="text" id="search" class="form-control" placeholder="@lang('juzacms::app.search')" autocomplete="off">
                </div>

                <div class="form-group mb-2 mr-1">
                    <label for="status" class="sr-only">@lang('juzacms::app.status')</label>
                    <select name="status" id="status" class="form-control select2-default">
                        <option value="">@lang('juzacms::app.all_status')</option>
                        <option value="1">@lang('juzacms::app.enabled')</option>
                        <option value="0">@lang('juzacms::app.disabled')</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mb-2">@lang('juzacms::app.search')</button>
            </form>
        </div>
    </div>

    <div class="table-responsive mb-5">
        <table class="table juzacms-table">
            <thead>
                <tr>
                    <th data-width="3%" data-field="state" data-checkbox="true"></th>
                    <th data-field="name" data-formatter="nameFormatter">@lang('juzacms::app.name')</th>
                    <th data-field="description" data-width="35%">@lang('juzacms::app.description')</th>
                    <th data-width="15%" data-field="status" data-formatter="statusFormatter">@lang('juzacms::app.status')</th>
                </tr>
            </thead>
        </table>
    </div>

    <script type="text/javascript">
        function nameFormatter(value, row, index) {
            return value;
        }
        
        function statusFormatter(value, row, index) {
            switch (value) {
                case 'inactive':
                    return `<span class='text-disable'>${juzacms.lang.inactive}</span>`;
            }

            return `<span class='text-success'>${juzacms.lang.active}</span>`;
        }

        var table = new JuzawebTable({
            url: '{{ route('admin.module.get-data') }}',
            action_url: '{{ route('admin.module.bulk-actions') }}',
        });
    </script>
@endsection