@extends('juzaweb::layouts.auth')

@section('content')
    <div class="juzaweb__layout__content">
        <div class="juzaweb__utils__content">
            <div class="juzaweb__auth__authContainer">

                <div class="juzaweb__auth__containerInner">
                    <div class="text-center mb-5">
                        <h1 class="mb-5 px-3">
                            <strong>{{ trans('juzaweb::message.login_form.welcome', ['name' => get_config('sitename', 'JUZAWEB')]) }}</strong>
                        </h1>

                        <p class="mb-4">
                            {{ trans('juzaweb::message.login_form.description') }}
                        </p>
                    </div>

                    <div class="card juzaweb__auth__boxContainer">
                        <div class="text-dark font-size-24 mb-4">
                            <strong>@lang('juzaweb::message.login_form.header')</strong>
                        </div>

                        <form action="{{ route('login') }}" method="post" class="mb-4 form-ajax" data-success="login_success">

                            @do_action('login_form')

                            <div class="form-group mb-4">
                                <input type="email" name="email" class="form-control" placeholder="@lang('juzaweb::app.email_address')" />
                            </div>

                            <div class="form-group mb-4">
                                <input type="password" name="password" class="form-control" placeholder="@lang('juzaweb::app.password')" />
                            </div>

                            <button type="submit" class="btn btn-primary text-center w-100 mb-2" data-loading-text="@lang('juzaweb::app.please_wait')"><i class="fa fa-sign-in"></i> @lang('juzaweb::app.login')</button>

                            <input type="checkbox" name="remember" value="1" checked> @lang('juzaweb::app.remember_me')
                        </form>

                        <a href="{{ route('forgot_password') }}" class="jw__utils__link font-size-16" data-turbolinks="false">
                            @lang('juzaweb::app.forgot_password')
                        </a>
                    </div>

                    @if(get_config('user_registration'))
                    <div class="text-center pt-2 mb-auto">
                        <span class="mr-2">@lang('juzaweb::message.login_form.dont_have_an_account')</span>
                        <a href="{{ route('register') }}" class="jw__utils__link font-size-16" data-turbolinks="false">
                            @lang('juzaweb::app.sign_up')
                        </a>
                    </div>
                    @endif
                </div>

                <div class="mt-auto pb-5 pt-5">
                    <div class="text-center">
                        Copyright © {{ date('Y') }} {{ get_config('sitename') }} - Provided by JUZAWEB
                    </div>
                </div>
            </div>

            <script type="text/javascript">
                function login_success(form, response) {
                    if (response.data.redirect) {
                        window.location = response.data.redirect;
                    }
                    return false;
                }
            </script>
        </div>
    </div>
@endsection