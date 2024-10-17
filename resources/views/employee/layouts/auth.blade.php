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

    @if(locale()->isRtl())
        <link href="{{ assetCustom('assets/client/plugins/global/plugins.bundle.rtl.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ assetCustom('assets/client/css/style.bundle.rtl.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ assetCustom('assets/client/css/custom.rtl.css') }}?version=1.0.21" rel="stylesheet" type="text/css">
    @else
        <link href="{{ assetCustom('assets/client/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ assetCustom('assets/client/css/style.bundle.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ assetCustom('assets/client/css/custom.css') }}?version=1.0.21" rel="stylesheet" type="text/css">
    @endif
    @stack('styles')
</head>
<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center bgi-no-repeat">

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
    <style>
        body {
            background-image: url('{{ assetCustom('assets/client/media/auth/bg6.jpg') }}');
        }

        [data-bs-theme="dark"] body {
            background-image: url('{{ assetCustom('assets/client/media/auth/bg6-dark.jpg') }}');
        }
    </style>
    <div class="d-flex flex-column flex-column-fluid flex-lg-row">
        <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
            <div class="d-flex flex-center flex-lg-start flex-column">
                <a href="{{ route('employee.home') }}" class="mb-7">
                    <img alt="Logo" src="{{ assetCustom('assets/client/media/logos/logo-300.png') }}">
                </a>
                {{--<h2 class="text-white fw-normal m-0">
                    Branding tools designed for your business
                </h2>--}}
            </div>
        </div>

        <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
            <div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">
                <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
                    @yield('content')
                </div>
                @include('employee.layouts.partials.auth.footer')
            </div>
        </div>
    </div>
</div>
<script>
    var hostUrl = "assets/client/";
    const APP_BASE_URL = "{{ config('app.url') }}";
</script>
<script src="{{ assetCustom('assets/client/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ assetCustom('assets/client/js/scripts.bundle.js') }}"></script>
<script src="{{ assetCustom('assets/client/js/custom/axios.min.js') }}"></script>
<script>
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
    axios.defaults.headers.common['X-CSRF-Token'] = $('meta[name="_token"]').attr('content')
</script>
<script src="{{ assetCustom('assets/main.js') }}?version=1.0.32"></script>
<script src="{{ assetCustom('assets/helpers.js') }}?version=1.0.30"></script>
@stack('scripts')
</body>
</html>
