<!DOCTYPE html>
<html lang="{{ App::getLocale() }}" dir="@lang('boilerplate::layout.direction')">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} | {{ config('app.name') }}</title>
    <link rel="shortcut icon" href="{{ config('boilerplate.theme.favicon') ?? mix('favicon.svg', '/assets/vendor/boilerplate') }}">
@stack('plugin-css')
    <link rel="stylesheet" href="{{ mix('/plugins/fontawesome/fontawesome.min.css', '/assets/vendor/boilerplate') }}">
    <link rel="stylesheet" href="{{ mix('/adminlte.min.css', '/assets/vendor/boilerplate') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,300;0,400;0,700;1,400&display=swap" rel="stylesheet">
    @stack('css')
<style>
.login-footer {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 1030;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
    background-color: var(--bs-body-bg); /* Supports theme-aware backgrounds */
}

/* Text color for light mode */
.footer-left,
.footer-right {
    color: #212529; /* Bootstrap's body text */
}

/* Text color for dark mode - activated via .dark-mode class on body/html */
.dark-mode .footer-left,
.dark-mode .footer-right {
    color: #f1f1f1;
}

@media (max-width: 576px) {
    .login-footer {
        flex-direction: column;
        text-align: center;
    }
}

</style>
@if(config('boilerplate.app.pwa.enabled', false))
    <link rel="manifest" href="{{ route('boilerplate.pwa.manifest') }}">
    <meta name="theme-color" content="{{ config('boilerplate.app.pwa.theme_color') }}">
    <link rel="apple-touch-icon" href="{{ url(config('boilerplate.app.pwa.apple_touch_icon')) }}">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="mobile-web-app-capable" content="yes">

@endif
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-NXWWXL4RPF"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-NXWWXL4RPF');
</script>
</head>
<body class="hold-transition login-page">
    @yield('content')
    <script src="{{ mix('/bootstrap.min.js', '/assets/vendor/boilerplate') }}"></script>
    <script src="{{ mix('/admin-lte.min.js', '/assets/vendor/boilerplate') }}"></script>
    <script src="{{ mix('/boilerplate.min.js', '/assets/vendor/boilerplate') }}"></script>
    <script>$.ajaxSetup({headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}});</script>
@if(config('boilerplate.theme.darkmode'))
    <script>window.matchMedia("(prefers-color-scheme: dark)") ? $('body').addClass('dark-mode accent-light') : $('body').removeClass('dark-mode accent-light')</script>
@endif
@stack('js')

<footer class="login-footer text-sm d-flex justify-content-between flex-wrap px-3 py-2 bg-body">
    <div class="footer-left">
        <strong>
                &copy; {{ date('Y') }}
                @if(config('boilerplate.theme.footer.vendorlink'))
                    <a href="{{ config('boilerplate.theme.footer.vendorlink') }}">
                        {!! config('boilerplate.theme.footer.vendorname') !!}
                    </a>.
                @else
                    {!! config('boilerplate.theme.footer.vendorname') !!}.
                @endif
            </strong>
            {{ __('boilerplate::layout.rightsres') }}
    </div>
    <a href="https://engineerbd.net/" target="_blank" class="footer-right text-decoration-none">
        Developed by <strong>Engineer BD Network</strong>
    </a>
</footer>

@if(config('boilerplate.app.pwa.enabled', false))
<script>
"use strict";
                if ("serviceWorker" in navigator) {
                    navigator.serviceWorker.register("/service-worker.js").then(
                        (registration) => {
                            console.log("Service worker registration succeeded:");
                        },
                        (error) => {
                            console.error("Service worker registration failed", error);
                        }
                    );
                } else {
                    console.error("Service workers are not supported.");
                }
</script>
@endif
</body>
</html>
