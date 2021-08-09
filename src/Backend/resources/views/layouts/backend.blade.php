<!DOCTYPE html>
<html lang="en" data-kit-theme="default">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="turbolinks-cache-control" content="no-cache">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? '' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('juzacms/styles/images/icon.png') }}" />
    <link href="https://fonts.googleapis.com/css?family=Mukta:400,700,800&display=swap" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="{{ asset('juzacms/styles/css/vendor.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('juzacms/styles/css/backend.css') }}">

    @include('juzacms::components.juzacms_langs')

    <script src="{{ asset('juzacms/styles/js/vendor.js') }}"></script>
    <script src="{{ asset('juzacms/styles/js/backend.js') }}"></script>
    <script src="{{ asset('juzacms/styles/ckeditor/ckeditor.js') }}"></script>

    @do_action('juzacms_header')
    @yield('header')
</head>

<body class="juzacms__menuLeft--dark juzacms__topbar--fixed juzacms__menuLeft--unfixed">
<div class="juzacms__layout juzacms__layout--hasSider">

    <div class="juzacms__menuLeft">
        <div class="juzacms__menuLeft__mobileTrigger"><span></span></div>

        <div class="juzacms__menuLeft__outer">
            <div class="juzacms__menuLeft__logo__container">
                <div class="juzacms__menuLeft__logo">
                    <div class="juzacms__menuLeft__logo__name">
                        <a href="/{{ config('juzacms.admin_prefix') }}">
                            <img src="{{ asset('juzacms/styles/images/logo.png') }}" alt="">
                        </a>
                    </div>
                </div>
            </div>

            <div class="juzacms__menuLeft__scroll kit__customScroll">
                @include('juzacms::backend.menu_left')
            </div>
        </div>
    </div>
    <div class="juzacms__menuLeft__backdrop"></div>

    <div class="juzacms__layout">
        <div class="juzacms__layout__header">
            @include('juzacms::backend.menu_top')
        </div>

        <div class="juzacms__layout__content">
            @if(!request()->is(config('juzacms.admin_prefix') . '/dashboard'))
            {{ breadcrumb('admin', [
                    [
                        'title' => $title
                    ]
                ]) }}
            @else
                <div class="mb-3"></div>
            @endif

            <h4 class="font-weight-bold ml-3">{{ $title }}</h4>

            <div class="juzacms__utils__content">
                @yield('content')
            </div>
        </div>
        <div class="juzacms__layout__footer">
            <div class="juzacms__footer">
                <div class="juzacms__footer__inner">
                    <a href="https://github.com/juzacmscms/juzacmscms" target="_blank" rel="noopener noreferrer" class="juzacms__footer__logo">
                        MYMO CMS - The Best Laravel CMS
                        <span></span>
                    </a>
                    <br />
                    <p class="mb-0">
                        Copyright © {{ date('Y') }} {{ get_config('sitename') }} - Provided by MYMO CMS
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $.extend( $.validator.messages, {
        required: "{{ trans('juzacms::app.this_field_is_required') }}",
    });

    $(".form-ajax").validate();
</script>

@do_action('juzacms_footer')
@yield('footer')
</body>
</html>