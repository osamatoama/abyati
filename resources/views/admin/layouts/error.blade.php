<!DOCTYPE html>
<html lang="{{ locale()->current() }}" direction="{{ locale()->direction() }}" dir="{{ locale()->direction() }}" style="direction: {{ locale()->direction() }}">
<head>
    <title>@yield('title') | {{ siteTitle() }}</title>
    <meta charset="utf-8">
    <meta name="description" content="{{ siteTitle() }}">
    <meta name="keywords" content="{{ siteTitle() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ assetCustom('assets/client/media/logos/return-favicon.png') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700">

    @stack('beforeStyles')
    @if(locale()->isRtl())
        <link href="{{ assetCustom('assets/client/plugins/global/plugins.bundle.rtl.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ assetCustom('assets/client/css/style.bundle.rtl.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ assetCustom('assets/client/css/custom.rtl.css') }}?version=1.0.21" rel="stylesheet" type="text/css">
    @else
        <link href="{{ assetCustom('assets/client/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ assetCustom('assets/client/css/style.bundle.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ assetCustom('assets/client/css/custom.css') }}?version=1.0.21" rel="stylesheet" type="text/css">
    @endif

    @stack('afterStyles')
</head>

<body id="kt_body" class="app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>

    <div class="d-flex flex-column flex-root" id="kt_app_root">
        @yield('content')
    </div>

    @stack('beforeScripts')
    <script>
        var hostUrl = "assets/client/";
        const APP_BASE_URL = "{{ config('app.url') }}";
    </script>
    <script src="{{ assetCustom('assets/client/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ assetCustom('assets/client/js/scripts.bundle.js') }}"></script>
    <script src="{{ assetCustom('assets/helpers.js') }}?version=1.0.29"></script>
    @stack('afterScripts')
</body>
</html>
