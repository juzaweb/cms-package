<div class="row mb-3">
    @if($actions)
        <div class="col-md-4">
            <form method="post" class="form-inline">
                @csrf

                <select name="bulk_actions" class="form-control select2-default w-60 mb-2 mr-1">
                    <option value="">{{ trans('juzaweb::app.bulk_actions') }}</option>
                    @foreach($actions as $key => $action)
                        <option value="{{ $key }}">{{ $action }}</option>
                    @endforeach
                </select>

                <button type="submit" class="btn btn-primary mb-2" id="apply-action">{{ trans('juzaweb::app.apply') }}</button>
            </form>
        </div>
    @endif

    <div class="col-md-8">
        <form method="get" class="form-inline" id="form-search">

            <div class="form-group mb-2 mr-1">
                <label for="search" class="sr-only">{{ trans('juzaweb::app.search') }}</label>
                <input name="search" type="text" id="search" class="form-control" placeholder="{{ trans('juzaweb::app.search') }}" autocomplete="off">
            </div>

            <div class="form-group mb-2 mr-1">
                <label for="status" class="sr-only">{{ trans('juzaweb::app.status') }}</label>
                <select name="status" id="status" class="form-control">
                    <option value="">--- @lang('juzaweb::app.status') ---</option>
                    <option value="publish">@lang('juzaweb::app.public')</option>
                    <option value="private">@lang('juzaweb::app.private')</option>
                    <option value="draft">@lang('juzaweb::app.draft')</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-search"></i> {{ trans('juzaweb::app.search') }}</button>
        </form>
    </div>
</div>

<div class="table-responsive">
    <table class="table" id="{{ $uniqueId }}">
        <thead>
            <tr>
                <th data-width="3%" data-checkbox="true"></th>
                @foreach($columns as $key => $column)
                    <th
                            data-width="{{ $column['width'] ?? 'auto' }}"
                            data-align="{{ $column['align'] ?? 'left' }}"
                            data-field="{{ $key }}">{{
                                $column['label'] ?? strtoupper($key) }}
                    </th>
                @endforeach
            </tr>
        </thead>
    </table>
</div>

<script type="text/javascript">
    var table = new JuzawebTable({
        table: "#{{ $uniqueId }}",
        url: '{{ route('admin.datatable.get-data') }}?table={{ urlencode($table) }}&data={{ urlencode(json_encode($params)) }}',
    });
</script>
