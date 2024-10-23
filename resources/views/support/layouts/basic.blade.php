<!DOCTYPE html>
<html lang="{{ locale()->current() }}" direction="{{ locale()->direction() }}" dir="{{ locale()->direction() }}" style="direction: {{ locale()->direction() }}">
<head>
    <title>@yield('title') | {{ siteTitle() }}</title>
    <meta charset="utf-8">
    <meta name="description" content="{{ siteTitle() }}">
    <meta name="keywords" content="{{ siteTitle() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ assetCustom('assets/client/media/logos/favicon.webp') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700">

    @stack('beforeStyles')
    @if(locale()->isRtl())
        <link href="{{ assetCustom('assets/client/plugins/global/plugins.bundle.rtl.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ assetCustom('assets/client/css/style.bundle.rtl.css') }}" rel="stylesheet" type="text/css">
    @else
        <link href="{{ assetCustom('assets/client/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ assetCustom('assets/client/css/style.bundle.css') }}" rel="stylesheet" type="text/css">
    @endif
    @stack('afterStyles')
</head>
<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">

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

<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
    <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
        @yield('content')
    </div>
</div>

@stack('beforeScripts')
<script>
    var hostUrl = "assets/client/";
    const APP_BASE_URL = "{{ config('app.url') }}";
</script>
<script src="{{ assetCustom('assets/client/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ assetCustom('assets/client/js/scripts.bundle.js') }}"></script>
<script src="{{ assetCustom('assets/helpers.js') }}?version=1.0.31"></script>
@stack('afterScripts')
</body>
</html>
