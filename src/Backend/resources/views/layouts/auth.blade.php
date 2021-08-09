<!DOCTYPE html>
<html lang="en" data-kit-theme="default">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <link rel="icon" type="image/png" href="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css?family=Mukta:400,700,800&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('juzacms/styles/css/vendor.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('juzacms/styles/css/backend.css') }}">

    @include('juzacms::components.juzacms_langs')

    <script src="{{ asset('juzacms/styles/js/vendor.js') }}"></script>
    <script src="{{ asset('juzacms/styles/js/backend.js') }}"></script>
</head>
    <body class="juzacms__layout--cardsShadow juzacms__menuLeft--dark">
        <div class="juzacms__layout juzacms__layout--hasSider">
            <div class="juzacms__menuLeft__backdrop"></div>
            <div class="juzacms__layout">
                @yield('content')
            </div>
        </div>
    </body>
</html>