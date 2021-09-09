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

            @foreach($searchFields as $name => $field)
                @switch($field['type'] ?? 'text')
                    @case('text')
                        <div class="form-group mb-2 mr-1">
                            <label for="search-{{ $name }}" class="sr-only">{{ $field['label'] ?? '' }}</label>
                            <input name="{{ $name }}" id="search-{{ $name }}" class="form-control" placeholder="{{ $field['placeholder'] ?? '' }}" autocomplete="off">
                        </div>
                @break

                    @case('select')
                    <div class="form-group mb-2 mr-1">

                        <select name="{{ $name }}" id="search-{{ $name }}" class="form-control select2-default">
                            <option value="">{{ trans('juzaweb::app.all') }}</option>
                            @foreach($field['options'] ?? [] as $key => $val)
                                <option value="{{ $key }}">{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>
                    @break
                @endswitch
            @endforeach



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
        action_url: '{{ route('admin.datatable.bulk-actions') }}?table={{ urlencode($table) }}&data={{ urlencode(json_encode($params)) }}'
    });
</script>
