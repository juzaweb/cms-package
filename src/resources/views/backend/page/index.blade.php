@extends('juzaweb::layouts.backend')

@section('content')

    <div class="row">
        <div class="col-md-6"></div>

        <div class="col-md-6">
            <div class="btn-group float-right">
                <a href="{{ route('admin.pages.create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> @lang('juzaweb::app.add_new')</a>
            </div>
        </div>
    </div>

    {{ $dataTable->render() }}
@endsection