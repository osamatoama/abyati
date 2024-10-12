<!DOCTYPE html>
<html lang="{{ locale()->current() }}" direction="{{ locale()->direction() }}" dir="{{ locale()->direction() }}"
      style="direction: {{ locale()->direction() }}">
<head>
    <title>@yield('title') | {{ siteTitle() }}</title>
    <meta charset="utf-8">
    <meta name="_token" content="{{ csrf_token() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ siteTitle() }}">
    <meta name="keywords" content="{{ siteTitle() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ assetCustom('assets/client/media/logos/favicon.webp') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700">

    @stack('beforeStyles')

    @if(locale()->isRtl())
        <link href="{{ assetCustom('assets/client/plugins/custom/datatables/datatables.bundle.rtl.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ assetCustom('assets/client/plugins/global/plugins.bundle.rtl.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ assetCustom('assets/client/css/style.bundle.rtl.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ assetCustom('assets/client/css/custom.rtl.css') }}?version=1.0.21" rel="stylesheet" type="text/css">
    @else
        <link href="{{ assetCustom('assets/client/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ assetCustom('assets/client/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ assetCustom('assets/client/css/style.bundle.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ assetCustom('assets/client/css/custom.css') }}?version=1.0.21" rel="stylesheet" type="text/css">
    @endif

    {{-- @vite('resources/js/app.js') --}}

    {{-- <script>
        {!! Vite::content('resources/js/app.js') !!}
    </script> --}}

    @livewireStyles

    @stack('afterStyles')
</head>
<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true"
      data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true"
      data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true"
      data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">

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
        @include('admin.layouts.partials.master.header')

        <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
            @include('admin.layouts.partials.master.sidebar')

            <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                <!--begin::Content wrapper-->
                <div class="d-flex flex-column flex-column-fluid">

                    <!--begin::Toolbar-->
                    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                        <!--begin::Toolbar container-->
                        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                            <!--begin::Page title-->
                            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                                <!--begin::Title-->
                                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">@yield('title')</h1>
                                <!--end::Title-->

                                @if(! request()->routeIs('admin.home'))
                                    <!--begin::Breadcrumb-->
                                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                                        {!! Breadcrumbs::render() !!}
                                    </ul>
                                    <!--end::Breadcrumb-->
                                @endif
                            </div>
                            <!--end::Page title-->
                            <!--begin::Actions-->
                            <div class="page-actions d-flex align-items-start gap-2 gap-lg-3">
                                @yield('actions')
                            </div>
                            <!--end::Actions-->
                        </div>
                        <!--end::Toolbar container-->
                    </div>
                    <!--end::Toolbar-->

                    <!--begin::Content-->
                    <div id="kt_app_content" class="app-content flex-column-fluid">
                        <!--begin::Content container-->
                        <div id="kt_app_content_container" class="app-container container-fluid">
                            <!--begin::Flush Messages and Errors-->
                                @include("admin.layouts.partials.messages")
                            <!--end::Flush Messages and Errors-->

                            @yield('content')
                        </div>
                        <!--end::Content container-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Content wrapper-->

                @include('admin.layouts.partials.master.footer')
            </div>
        </div>
    </div>
</div>

@include('admin.layouts.partials.master.scroll-top')

@stack('modals')

@stack('beforeScripts')
<script>
    var hostUrl = "assets/client/";
    const APP_BASE_URL = "{{ config('app.url') }}";
</script>

<script src="{{ assetCustom('assets/client/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ assetCustom('assets/client/js/scripts.bundle.js') }}"></script>
<script src="{{ assetCustom('assets/client/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ assetCustom('assets/client/js/custom/axios.min.js') }}"></script>
<script src="{{ asset('assets/client/plugins/custom/pusher/pusher.min.js') }}"></script>

<script>
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
    axios.defaults.headers.common['X-CSRF-Token'] = $('meta[name="_token"]').attr('content')
</script>
<script src="{{ assetCustom('assets/main.js') }}?version=1.0.31"></script>
<script src="{{ assetCustom('assets/helpers.js') }}?version=1.0.30"></script>

@include('admin.layouts.partials.notifications')

@livewireScripts

@stack('afterScripts')

</body>
</html>
