@php($darkmode = (setting('darkmode', false) && config('boilerplate.theme.darkmode')))
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
    <link rel="stylesheet" href="{{ asset('/custom.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,300;0,400;0,700;1,400&display=swap" rel="stylesheet">
@stack('css')
@if(config('boilerplate.app.pwa.enabled', false))
    <link rel="manifest" href="{{ route('boilerplate.pwa.manifest') }}">
    <meta name="theme-color" content="{{ config('boilerplate.app.pwa.theme_color') }}">
    <link rel="apple-touch-icon" href="{{ url(config('boilerplate.app.pwa.apple_touch_icon')) }}">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="mobile-web-app-capable" content="yes">
    
    <!-- NProgress CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
    
    <style>
      #nprogress {
        pointer-events: none;
      }
    
      #nprogress .bar {
        background: #1eff00ff !important;
        position: fixed;
        z-index: 99999;
        top: 0;
        left: 0;
        width: 100%;
        height: 3px;
      }
    
      #nprogress .peg {
        display: block;
        position: absolute;
        right: 0px;
        width: 100px;
        height: 100%;
        box-shadow: 0 0 10px #1eff00ff, 0 0 5px #1eff00ff;
        opacity: 1.0;
        -webkit-transform: rotate(3deg) translate(0px, -4px);
            -ms-transform: rotate(3deg) translate(0px, -4px);
                transform: rotate(3deg) translate(0px, -4px);
      }
    
      #nprogress .spinner {
        display: none !important;
      }
    </style>

@endif
    <script src="{{ mix('/bootstrap.min.js', '/assets/vendor/boilerplate') }}"></script>
    <script src="{{ mix('/admin-lte.min.js', '/assets/vendor/boilerplate') }}"></script>
    <script src="{{ mix('/boilerplate.min.js', '/assets/vendor/boilerplate') }}" data-csrf="{{ csrf_token() }}" data-locale="{{ App::getLocale() }}" data-settings="{{ route('boilerplate.user.settings',null,false) }}"></script>
    @include('boilerplate::layout.session')
@stack('plugin-js')

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-NXWWXL4RPF"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-NXWWXL4RPF');
</script>

</head>
<body class="layout-fixed layout-navbar-fixed sidebar-mini{{ $darkmode ? ' dark-mode' : '' }}{{ setting('sidebar-collapsed', false) ? ' sidebar-collapse' : '' }}" data-darkmode="{{ setting('darkmode', '2') }}">
    <div class="wrapper">
        @include('boilerplate::layout.header')
        @include('boilerplate::layout.mainsidebar')
        <div class="content-wrapper{{ $darkmode ? ' accent-light' : ' accent-dark' }}" id="content-wrapper">
            @include('boilerplate::layout.contentheader')
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>
        @includeWhen(config('boilerplate.theme.footer.visible', true), 'boilerplate::layout.footer')
        <aside class="control-sidebar control-sidebar-{{ config('boilerplate.theme.sidebar.type') }} elevation-{{ config('boilerplate.theme.sidebar.shadow') }}">
            <button class="btn btn-sm" data-widget="control-sidebar"><span class="fa fa-times"></span></button>
            <div class="control-sidebar-content">
                <div class="p-3">
                    @yield('right-sidebar')
                </div>
            </div>
        </aside>
        <div class="control-sidebar-bg"></div>
    </div>
@stack('js')
@if(session('growl'))
    <script>growl("{!! session('growl')[0] ?? session('growl') !!}", "{{ session('growl')[1] ?? 'info' }}")</script>
@endif

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

<script>
  let deferredPrompt;

  // Only show install button if PWA is not installed
  function checkPWAInstallationStatus() {
    const isStandalone = window.matchMedia('(display-mode: standalone)').matches
      || window.navigator.standalone === true;

    if (isStandalone) {
      // Already installed — hide the install button
      document.getElementById('installPwaBtn')?.remove();
    }
  }

  // Check right away if app is already installed
  window.addEventListener('load', () => {
    checkPWAInstallationStatus();
  });

  window.addEventListener('beforeinstallprompt', (e) => {
    // Prevent the mini-infobar from appearing
    e.preventDefault();
    deferredPrompt = e;

    // Show install button if not installed
    const installBtn = document.getElementById('installPwaBtn');
    if (installBtn) installBtn.style.display = 'inline-block';
  });

  document.getElementById('installPwaBtn')?.addEventListener('click', async () => {
    if (deferredPrompt) {
      deferredPrompt.prompt();
      const { outcome } = await deferredPrompt.userChoice;

      if (outcome === 'accepted') {
        console.log('User accepted install prompt');
      } else {
        console.log('User dismissed install prompt');
      }

      deferredPrompt = null;

      // Hide the install button after decision
      document.getElementById('installPwaBtn')?.remove();
    }
  });
</script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    // Finish progress on load
    NProgress.done();

    // Form submission
    document.querySelectorAll('form').forEach(function (form) {
      form.addEventListener('submit', function () {
        NProgress.start();
      });
    });

    // Link clicks
    document.querySelectorAll('a[href]').forEach(function (link) {
      link.addEventListener('click', function (e) {
        if (
          link.hostname === window.location.hostname &&
          !link.target &&
          !e.ctrlKey && !e.metaKey &&
          !link.hasAttribute('download') &&
          !link.href.includes('#')
        ) {
          NProgress.start();
        }
      });
    });

    // Also handle page unload/reload
    window.addEventListener('beforeunload', function () {
      NProgress.start();
    });
  });
</script>
@endif

</body>
</html>
