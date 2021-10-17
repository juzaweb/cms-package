@extends('juzaweb::layouts.backend')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success">
                <p>You are using Juzaweb CMS Version: {{ \Juzaweb\Version::getVersion() }}</p>
                <p>View CMS change logs: <a href="https://github.com/juzaweb/cms/releases" target="_blank">click here</a></p>
            </div>

            <div id="update-form">
                <img src="{{ asset('themes/default/assets/images/loader.gif') }}" alt="">
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12">
            <h5>Update plugins</h5>

            <div class="table-responsive mb-5">
                <table class="table" id="plugins-table">
                    <thead>
                        <tr>
                            <th data-field="state" data-width="3%" data-checkbox="true"></th>
                            <th data-field="plugin">{{ trans('juzaweb::app.plugin') }}</th>
                            <th data-field="version" data-width="15%">{{ trans('juzaweb::app.version') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-12">
            <h5>Update themes</h5>

            <div class="table-responsive mb-5">
                <table class="table" id="themes-table">
                    <thead>
                        <tr>
                            <th data-field="state" data-width="3%" data-checkbox="true"></th>
                            <th data-field="plugin">{{ trans('juzaweb::app.theme') }}</th>
                            <th data-field="version" data-width="15%">{{ trans('juzaweb::app.version') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function update_success() {
            window.location = "";
            return false;
        }

        var table = new JuzawebTable({
            table: "#plugins-table",
            url: "{{ route('admin.update.plugins') }}",
            action_url: "{{ route('admin.themes.require-plugins.buld-actions') }}",
            chunk_action: true
        });

        var table = new JuzawebTable({
            table: "#themes-table",
            url: "{{ route('admin.update.themes') }}",
            action_url: "{{ route('admin.themes.require-plugins.buld-actions') }}",
            chunk_action: true
        });

        ajaxRequest("{{ route('admin.update.check') }}", {}, {
            method: 'GET',
            callback: function (response) {
                $('#update-form').html(response.html);
            }
        })
    </script>
@endsection