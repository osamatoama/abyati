<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
     data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
     data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <a href="{{ route('support.home') }}">
            <img alt="Logo" src="{{ assetCustom('assets/client/media/logos/logo.png') }}"
                 class="h-50px app-sidebar-logo-default">
            <img alt="Logo" src="{{ assetCustom('assets/client/media/logos/logo-sm.png') }}"
                 class="h-30px app-sidebar-logo-minimize">
        </a>
        <!--begin::Sidebar toggle-->
        <!--begin::Minimized sidebar setup:
        if (isset($_COOKIE["sidebar_minimize_state"]) && $_COOKIE["sidebar_minimize_state"] === "on") {
            1. "src/js/layout/sidebar.js" adds "sidebar_minimize_state" cookie value to save the sidebar minimize state.
            2. Set data-kt-app-sidebar-minimize="on" attribute for body tag.
            3. Set data-kt-toggle-state="active" attribute to the toggle element with "kt_app_sidebar_toggle" id.
            4. Add "active" class to to sidebar toggle element with "kt_app_sidebar_toggle" id.
        }
        -->
        <div id="kt_app_sidebar_toggle"
             class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
             data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
             data-kt-toggle-name="app-sidebar-minimize">
            <i class="ki-duotone ki-double-left fs-2 rotate-180">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </div>
    </div>

    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5"
            data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
            data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px"
            data-kt-scroll-save-state="true"
        >
            <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">

                <div class="menu-item">
                    <a @class(['menu-link', 'active' => request()->routeIs('support.home')])
                       href="{{ route('support.home') }}">
                    <span class="menu-icon">
                            <i class="fa-solid fa-home fs-2"></i>
                        </span>
                        <span class="menu-title">
                        {{ __('support.home.title') }}
                        </span>
                    </a>
                </div>

                <div class="menu-item">
                    <a @class(['menu-link', 'active' => request()->routeIs('support.orders.*')]) href="{{ route('support.orders.index') }}"
                    >
                        <span class="menu-icon">
                            <i class="fa-solid fa-shopping-cart fs-2"></i>
                        </span>
                            <span class="menu-title">
                        {{ __('support.orders.title') }}
                        </span>
                    </a>
                </div>

                <div class="menu-item">
                    <a @class(['menu-link', 'active' => request()->routeIs('support.reports.*')])
                    href="{{ route('support.reports.index') }}"
                    >
                        <span class="menu-icon">
                            <i class="fa-solid fa-file fs-2"></i>
                        </span>
                            <span class="menu-title">
                        {{ __('support.reports.title') }}
                        </span>
                    </a>
                </div>

                {{-- @if(true)
                    <div class="menu-item">
                        <a @class(['menu-link', 'active' => request()->routeIs('support.reports.*')])
                        href="{{ route('support.reports.index') }}"
                        >
                            <span class="menu-icon">
                                <i class="fa-solid fa-file fs-2"></i>
                            </span>
                                <span class="menu-title">
                            {{ __('reports.title') }}
                            </span>
                        </a>
                    </div>
                @endif --}}

                {{-- @if(can("customers.show") or can("products.show") or can("orders.show"))
                    <div data-kt-menu-trigger="click"
                         class="menu-item menu-accordion {{ (request()->routeIs("support.customers.*") or request()->routeIs("support.products.*") or request()->routeIs("support.orders.*")) ? " hover show " : "" }}">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="fa-solid fa-database fs-2"></i>
                            </span>
                            <span class="menu-title">{{ __('globals.store_data') }}</span>
                            <span class="menu-arrow"></span>
                        </span>

                        <div class="menu-sub menu-sub-accordion">
                            @if(can("products.show"))
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs("support.products.*") ? "active" : "" }}"
                                       href="{{ route("support.products.index") }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __("products.title") }}</span>
                                    </a>
                                </div>
                            @endif

                            @if(can("customers.show"))
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs("support.customers.*") ? "active" : "" }}"
                                    href="{{ route("support.customers.index") }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __("customers.title") }}</span>
                                    </a>
                                </div>
                            @endif

                            @if(can("orders.show"))
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs("support.orders.*") ? "active" : "" }}"
                                    href="{{ route("support.orders.index") }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __("support.orders.title") }}</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif --}}

                {{-- @if(can('settings.show') && (can('return_settings.edit') || can('exchange_settings.edit') || can('website_settings.edit') || can('domain_settings.edit')))
                    <div class="menu-item">
                        <a @class(['menu-link', 'active' => request()->routeIs('support.settings.*')])
                            href="{{ route('support.settings.index') }}"
                        >
                            <span class="menu-icon">
                                <i class="fa-solid fa-cog fs-2"></i>
                            </span>
                                <span class="menu-title">
                            {{ __('settings.title') }}
                            </span>
                        </a>
                    </div>
                @endif --}}
            </div>
        </div>
    </div>
</div>
