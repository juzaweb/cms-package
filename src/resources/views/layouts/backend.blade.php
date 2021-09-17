<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="turbolinks-cache-control" content="no-cache">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? '' }}</title>
    <link rel="icon" href="{{ asset('vendor/juzaweb/styles/images/favicon.ico') }}" />
    <link href="https://fonts.googleapis.com/css?family=Mukta:400,700,800&display=swap" rel="stylesheet" />

    @include('juzaweb::components.juzaweb_langs')

    @php
        $scripts = get_enqueue_scripts(false);
        $styles = get_enqueue_styles(false);
    @endphp

    @foreach($styles as $style)
        <link rel="stylesheet" type="text/css" href="{{ $style->get('src') }}?v={{ $style->get('ver') }}">
    @endforeach

    @foreach($scripts as $script)
        <script src="{{ $script->get('src') }}?v={{ $script->get('ver') }}"></script>
    @endforeach
    <link rel="stylesheet" href="{{ asset('css/widget.css') }}">
    <script src="{{ asset('js/widget.js') }}"></script>

    @do_action('juzaweb_header')

    @yield('header')
</head>

<body class="juzaweb__menuLeft--dark juzaweb__topbar--fixed juzaweb__menuLeft--unfixed">
<div class="juzaweb__layout juzaweb__layout--hasSider">

    <div class="juzaweb__menuLeft">
        <div class="juzaweb__menuLeft__mobileTrigger"><span></span></div>

        <div class="juzaweb__menuLeft__outer">
            <div class="juzaweb__menuLeft__logo__container">
                <a href="/{{ config('juzaweb.admin_prefix') }}">
                <div class="juzaweb__menuLeft__logo">
                    <img src="{{ asset('vendor/juzaweb/styles/images/logo.svg') }}" class="mr-2" alt="Juzaweb">
                    <div class="juzaweb__menuLeft__logo__name">Juzaweb</div>
                    <div class="juzaweb__menuLeft__logo__descr">Cms</div>
                </div>

                </a>
                {{--<div class="juzaweb__menuLeft__logo">
                    <div class="juzaweb__menuLeft__logo__name">
                        <a href="/{{ config('juzaweb.admin_prefix') }}">
                            <img src="{{ asset('vendor/juzaweb/styles/images/logo.png') }}" alt="">
                        </a>
                    </div>
                </div>--}}
            </div>

            <div class="juzaweb__menuLeft__scroll jw__customScroll">
                @include('juzaweb::backend.menu_left')
            </div>
        </div>
    </div>
    <div class="juzaweb__menuLeft__backdrop"></div>

    <div class="juzaweb__layout">
        <div class="juzaweb__layout__header">
            @include('juzaweb::backend.menu_top')
        </div>

        <div class="juzaweb__layout__content">
            @if(!request()->is(config('juzaweb.admin_prefix')))
                {{ jw_breadcrumb('admin', [
                        [
                            'title' => $title
                        ]
                    ]) }}
            @else
                <div class="mb-3"></div>
            @endif

            <h4 class="font-weight-bold ml-3 text-capitalize">{{ $title }}</h4>

            <div class="juzaweb__utils__content">

                @if(session()->has('message'))
                    <div class="alert alert-{{ session()->get('status') == 'success' ? 'success' : 'danger' }}">{{ session()->get('message') }}</div>
                @endif

                @yield('content')
            </div>
        </div>

        <div class="juzaweb__layout__footer">
            <div class="juzaweb__footer">
                <div class="juzaweb__footer__inner">
                    <a href="https://juzaweb.com/cms" target="_blank" rel="noopener noreferrer" class="juzaweb__footer__logo">
                        Juzaweb CMS ({{ \Juzaweb\Version::getVersion() }}) - The Best for Laravel Project
                        <span></span>
                    </a>
                    <br />
                    <p class="mb-0">
                        Copyright © {{ date('Y') }} {{ get_config('sitename') }} - Provided by Juzaweb CMS
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $.extend( $.validator.messages, {
        required: "{{ trans('juzaweb::app.this_field_is_required') }}",
    });

    $(".form-ajax").validate();
</script>

@php
    $scripts = get_enqueue_scripts(true);
    $styles = get_enqueue_styles(false);
@endphp

@foreach($scripts as $script)
    <script src="{{ $script->get('src') }}?v={{ $script->get('ver') }}"></script>
@endforeach

@do_action('juzaweb_footer')

@yield('footer')
</body>
</html>