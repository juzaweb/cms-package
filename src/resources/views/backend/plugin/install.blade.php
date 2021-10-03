@extends('juzaweb::layouts.backend')

@section('content')

    <div class="row">
        <div class="col-md-8">

        </div>
    </div>

    <div class="row" id="plugin-list"></div>

    <template id="plugin-template">
        <div class="col-md-4">
            {content}
        </div>
    </template>

    <script>
        var listView = new JuzawebListView({
            url: "{{ route('admin.plugin.install.all') }}",
            list: "#plugin-list",
            template: "plugin-template",
        });
    </script>
@endsection