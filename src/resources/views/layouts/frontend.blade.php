<!DOCTYPE html>
<html lang="vi">
<head>
    @php
        $title = apply_filters('theme.title', $title);
        $description = apply_filters('theme.description', $description ?? '');
    @endphp

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $description ?? '' }}">
    <meta name="turbolinks-cache-control" content="no-cache">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:description" content="{{ $description ?? '' }}">
    <meta name="twitter:card" content="summary">
    <meta property="twitter:title" content="{{ $title }}">
    <meta property="twitter:description" content="{{ $description ?? '' }}">

    <title>{{ $title }}</title>

    @do_action('theme.header')
    @yield('header')
</head>
<body class="{{ body_class() }}">

    @include('theme::header')

    @yield('content')

    @include('theme::footer')

    @yield('footer')

    @do_action('theme.footer')

</body>
</html>