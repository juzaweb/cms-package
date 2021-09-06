@extends('juzaweb::layouts.backend')

@section('content')
    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <div class="float-right">
                <div class="btn-group">
                    <a href="javascript:void(0)" class="btn btn-success" data-toggle="modal" data-target="#addModal"><i class="fa fa-plus-circle"></i> {{ trans('juzaweb::app.add_new') }}</a>
                    <button type="button" class="btn btn-danger" id="delete-item"><i class="fa fa-trash"></i> @lang('app.delete')</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12">
            <form method="get" class="form-inline" id="form-search">

                <div class="form-group mb-2 mr-1">
                    <label for="inputName" class="sr-only">@lang('app.search')</label>
                    <input name="search" type="text" id="inputName" class="form-control" placeholder="@lang('app.search')" autocomplete="off">
                </div>

                <div class="form-group mb-2 mr-1">
                    <label for="inputStatus" class="sr-only">@lang('app.status')</label>
                    <select name="status" id="inputStatus" class="form-control">
                        <option value="1">@lang('app.enabled')</option>
                        <option value="0">@lang('app.disabled')</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-search"></i> @lang('app.search')</button>
            </form>
        </div>

    </div>

    <div class="table-responsive mb-5">
        <table class="table juzaweb-table">
            <thead>
            <tr>
                <th data-width="3%" data-field="state" data-checkbox="true"></th>
                <th data-width="10%" data-field="key">@lang('app.code')</th>
                <th data-field="name">@lang('app.name')</th>
                <th data-field="status" data-width="15%" data-align="center" data-formatter="status_formatter">@lang('app.status')</th>
                <th data-field="default" data-width="5%" data-formatter="default_formatter">@lang('app.default')</th>
                <th data-width="20%" data-field="options" data-formatter="options_formatter" data-align="center">@lang('app.options')</th>
            </tr>
            </thead>
        </table>
    </div>

    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('admin.languages.store') }}" method="post" class="form-ajax">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">{{ trans('juzaweb::app.add_language') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-form-label" for="name">@lang('app.name')</label>

                            <input type="text" name="name" class="form-control" id="name" value="" autocomplete="off" required placeholder="Ex: English, French">
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="key">@lang('app.code')</label>

                            <input type="text" name="key" class="form-control" id="key" autocomplete="off" required placeholder="Ex: en, fe">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> @lang('app.save')</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close"></i> @lang('app.close')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function status_formatter(value, row, index) {
            if (value == 1) {
                return `<span class="text-success">${juzaweb.lang.enabled} +</span>`;
            }
            return `<span class="text-danger">${juzaweb.lang.disabled}</span>`;
        }

        function default_formatter(value, row, index) {
            let checked = value == 1 ? true : false;
            return '<input type="radio" name="default" value="'+ row.id +'" class="form-control set-default" '+ (checked ? 'checked' : '') +'>';
        }

        function options_formatter(value, row, index) {
            let result = '';
            result += '<a href="'+ row.tran_url +'" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> '+ langs.translate +'</a>';
            return result;
        }

        var table = new JuzawebTable({
            url: '{{ route('admin.languages.get-data') }}',
            action_url: '{{ route('admin.languages.bulk-actions') }}',
        });

        $('.table').on('change', '.set-default', function () {
            let id = $(this).val();
            $.ajax({
                type: 'POST',
                url: '{{ route('admin.languages.default') }}',
                dataType: 'json',
                data: {
                    'id': id,
                }
            }).done(function(data) {

                if (data.status === "error") {
                    show_message(data);
                    return false;
                }

                return false;
            }).fail(function(data) {
                show_message(langs.data_error, false);
                return false;
            });
        });

    </script>
@endsection