@extends('juzacms::layouts.backend')

@section('content')
    <div class="row">
        <div class="col-md-7">
            <h5>@lang('juzacms::app.setting')</h5>

            @component('juzacms::components.form', [
                'method' => 'post'
            ])

                @component('juzacms::components.form_input', [
                    'label' => trans('juzacms::app.email_host'),
                    'name' => 'email[host]',
                    'value' => $config['host'] ?? '',
                ])@endcomponent

                <div class="row">
                    <div class="col-md-6">
                        @component('juzacms::components.form_input', [
                            'label' => trans('juzacms::app.email_port'),
                            'name' => 'email[port]',
                            'value' => $config['port'] ?? '',
                        ])@endcomponent
                    </div>
                    <div class="col-md-6">
                        @component('juzacms::components.form_select', [
                            'label' => trans('juzacms::app.email_encryption'),
                            'name' => 'email[encryption]',
                            'value' => $config['encryption'] ?? '',
                            'options' => [
                                '' => 'none',
                                'tls' => 'tls',
                                'ssl' => 'ssl'
                            ],
                        ])@endcomponent
                    </div>
                </div>

                @component('juzacms::components.form_input', [
                    'label' => trans('juzacms::app.email_username'),
                    'name' => 'email[username]',
                    'value' => $config['username'] ?? '',
                ])@endcomponent

                @component('juzacms::components.form_input', [
                    'label' => trans('juzacms::app.email_password'),
                    'name' => 'email[password]',
                    'value' => $config['password'] ?? '',
                ])@endcomponent

                <hr>

                @component('juzacms::components.form_input', [
                    'label' => trans('juzacms::app.email_from_address'),
                    'name' => 'email[from_address]',
                    'value' => $config['from_address'] ?? '',
                ])@endcomponent

                @component('juzacms::components.form_input', [
                    'label' => trans('juzacms::app.email_from_name'),
                    'name' => 'email[from_name]',
                    'value' => $config['from_name'] ?? '',
                ])@endcomponent

                <div class="mt-3">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> @lang('juzacms::app.save')
                    </button>
                </div>
            @endcomponent

        </div>

        <div class="col-md-5">
            <h5>@lang('juzacms::app.send_email_test')</h5>

            @component('juzacms::components.form', [
                'method' => 'post',
                'action' => route('admin.email.test-email')
            ])
                @component('juzacms::components.form_input', [
                    'label' => trans('juzacms::app.email'),
                    'name' => 'email',
                    'required' => true,
                ])@endcomponent

                <button type="submit" class="btn btn-success">
                    <i class="fa fa-send"></i>
                    @lang('juzacms::app.send_email_test')
                </button>
            @endcomponent
        </div>
    </div>
@endsection
