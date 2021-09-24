@foreach($styles as $style)
    <link rel="stylesheet" type="text/css" href="{{ $style->get('src') }}?v={{ $style->get('ver') }}">
@endforeach

@foreach($scripts as $script)
    <script src="{{ $script->get('src') }}?v={{ $script->get('ver') }}"></script>
@endforeach

@if($googleAnalytics)
    <!-- Google Analytics -->

    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $googleAnalytics }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', '{{ $googleAnalytics }}');
    </script>

    <!-- End Google Analytics -->
@endif

@if($fbAppId)
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&autoLogAppEvents=1&version=v8.0&appId={{ $fbAppId }}" nonce="ozkqznFT"></script>
@endif
