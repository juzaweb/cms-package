@extends('juzacms::layouts.backend')

@section('content')

    <div class="row">
        <div class="col-md-6"></div>

        <div class="col-md-6">
            <div class="btn-group float-right">
                <a href="{{ route('admin.posts.create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> @lang('juzacms::app.add_new')</a>
                <button type="button" class="btn btn-danger" id="delete-item"><i class="fa fa-trash"></i> @lang('juzacms::app.delete')</button>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <form method="post" class="form-inline">
                @csrf
                <select name="bulk_actions" class="form-control w-60 mb-2 mr-1">
                    <option value="">@lang('juzacms::app.bulk_actions')</option>
                    <option value="publish">@lang('juzacms::app.public')</option>
                    <option value="private">@lang('juzacms::app.private')</option>
                    <option value="draft">@lang('juzacms::app.draft')</option>
                    <option value="delete">@lang('juzacms::app.delete')</option>
                </select>

                <button type="submit" class="btn btn-primary mb-2" id="apply-action">@lang('juzacms::app.apply')</button>
            </form>
        </div>

        <div class="col-md-8">
            <form method="get" class="form-inline" id="form-search">

                <div class="form-group mb-2 mr-1">
                    <label for="inputName" class="sr-only">@lang('juzacms::app.search')</label>
                    <input name="search" type="text" id="inputName" class="form-control" placeholder="@lang('juzacms::app.search')" autocomplete="off">
                </div>

                <div class="form-group mb-2 mr-1">
                    <label for="inputStatus" class="sr-only">@lang('juzacms::app.status')</label>
                    <select name="status" id="inputStatus" class="form-control">
                        <option value="">--- @lang('juzacms::app.status') ---</option>
                        <option value="publish">@lang('juzacms::app.public')</option>
                        <option value="private">@lang('juzacms::app.private')</option>
                        <option value="draft">@lang('juzacms::app.draft')</option>
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
                    <th data-width="10%" data-field="thumbnail" data-formatter="thumbnail_formatter">@lang('juzacms::app.thumbnail')</th>
                    <th data-field="title" data-formatter="name_formatter">@lang('juzacms::app.name')</th>

                    <th data-width="15%" data-field="created">@lang('juzacms::app.created_at')</th>
                    <th data-width="15%" data-field="status" data-align="center" data-formatter="status_formatter">@lang('juzacms::app.status')</th>
                </tr>
            </thead>
        </table>
    </div>

    <script type="text/javascript">
        function thumbnail_formatter(value, row, index) {
            return '<img src="'+ row.thumb_url +'" class="w-100">';
        }

        function name_formatter(value, row, index) {
            return '<a href="'+ row.edit_url +'">'+ value +'</a>';
        }

        function status_formatter(value, row, index) {
            switch (value) {
                case 'public':
                    return `<span class="text-success">${juzacms.lang.public}</span>`;
                case 'private':
                    return `<span class="text-warning">${juzacms.lang.private}</span>`;
                case 'draft':
                    return `<span class="text-secondary">${juzacms.lang.draft}</span>`;
            }
        }

        var table = new JuzawebTable({
            url: '{{ route('admin.posts.get-data') }}',
            action_url: '{{ route('admin.posts.bulk-actions') }}',
        });
    </script>
@endsection