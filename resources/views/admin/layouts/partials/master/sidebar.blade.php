<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
     data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
     data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <a href="{{ route('admin.home') }}">
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
                    <a @class(['menu-link', 'active' => request()->routeIs('admin.home')])
                       href="{{ route('admin.home') }}">
                    <span class="menu-icon">
                            <i class="fa-solid fa-home fs-2"></i>
                        </span>
                        <span class="menu-title">
                        {{ __('admin.home.title') }}
                        </span>
                    </a>
                </div>

                <div class="menu-item">
                    <a @class(['menu-link', 'active' => request()->routeIs('admin.stores.*')]) href="{{ route('admin.stores.index') }}"
                    >
                        <span class="menu-icon">
                            <i class="fa-solid fa-globe fs-2"></i>
                        </span>
                            <span class="menu-title">
                        {{ __('admin.stores.title') }}
                        </span>
                    </a>
                </div>

                <div class="menu-item">
                    <a @class(['menu-link', 'active' => request()->routeIs('admin.branches.*')]) href="{{ route('admin.branches.index') }}"
                    >
                        <span class="menu-icon">
                            <i class="fa-solid fa-store fs-2"></i>
                        </span>
                            <span class="menu-title">
                        {{ __('admin.branches.title') }}
                        </span>
                    </a>
                </div>

                <div class="menu-item">
                    <a @class(['menu-link', 'active' => request()->routeIs('admin.products.*')]) href="{{ route('admin.products.index') }}"
                    >
                        <span class="menu-icon">
                            <i class="fa-solid fa-box fs-2"></i>
                        </span>
                            <span class="menu-title">
                        {{ __('admin.products.title') }}
                        </span>
                    </a>
                </div>

                <div class="menu-item">
                    <a @class(['menu-link', 'active' => request()->routeIs('admin.orders.*')]) href="{{ route('admin.orders.index') }}"
                    >
                        <span class="menu-icon">
                            <i class="fa-solid fa-shopping-cart fs-2"></i>
                        </span>
                            <span class="menu-title">
                        {{ __('admin.orders.title') }}
                        </span>
                    </a>
                </div>

                <div class="menu-item">
                    <a @class(['menu-link', 'active' => request()->routeIs('admin.employees.*')]) href="{{ route('admin.employees.index') }}"
                    >
                        <span class="menu-icon">
                            <i class="fa-solid fa-users fs-2"></i>
                        </span>
                            <span class="menu-title">
                        {{ __('admin.employees.title') }}
                        </span>
                    </a>
                </div>

                <div class="menu-item">
                    <a @class(['menu-link', 'active' => request()->routeIs('admin.supports.*')]) href="{{ route('admin.supports.index') }}"
                    >
                        <span class="menu-icon">
                            <i class="fa-solid fa-headset fs-2"></i>
                        </span>
                            <span class="menu-title">
                        {{ __('admin.supports.title') }}
                        </span>
                    </a>
                </div>

                @if(can("roles.show") or can("roles.show"))
                    <div data-kt-menu-trigger="click"
                         class="menu-item menu-accordion {{ (request()->routeIs("admin.roles.*") or request()->routeIs("admin.roles.*")) ? " hover show " : "" }}">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="fa-solid fa-user fs-2"></i>
                            </span>
                            <span class="menu-title">{{ __('admin.management.title') }}</span>
                            <span class="menu-arrow"></span>
                        </span>

                        <div class="menu-sub menu-sub-accordion">
                            @if(can("roles.show"))
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs("admin.roles.*") ? "active" : "" }}"
                                       href="{{ route("admin.roles.index") }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('admin.roles.title') }}</span>
                                    </a>
                                </div>
                            @endif

                            @if(can("users.show"))
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs("admin.users.*") ? "active" : "" }}"
                                       href="{{ route("admin.users.index") }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('admin.users.title') }}</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                @if(can('employee_performance_report.show'))
                    <div class="menu-item">
                        <a @class(['menu-link', 'active' => request()->routeIs('admin.reports.*')])
                        href="{{ route('admin.reports.index') }}"
                        >
                            <span class="menu-icon">
                                <i class="fa-solid fa-file fs-2"></i>
                            </span>
                                <span class="menu-title">
                            {{ __('admin.reports.title') }}
                            </span>
                        </a>
                    </div>
                @endif

                {{-- @if(can("customers.show") or can("products.show") or can("orders.show"))
                    <div data-kt-menu-trigger="click"
                         class="menu-item menu-accordion {{ (request()->routeIs("admin.customers.*") or request()->routeIs("admin.products.*") or request()->routeIs("admin.orders.*")) ? " hover show " : "" }}">
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
                                    <a class="menu-link {{ request()->routeIs("admin.products.*") ? "active" : "" }}"
                                       href="{{ route("admin.products.index") }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __("products.title") }}</span>
                                    </a>
                                </div>
                            @endif

                            @if(can("customers.show"))
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs("admin.customers.*") ? "active" : "" }}"
                                    href="{{ route("admin.customers.index") }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __("customers.title") }}</span>
                                    </a>
                                </div>
                            @endif

                            @if(can("orders.show"))
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs("admin.orders.*") ? "active" : "" }}"
                                    href="{{ route("admin.orders.index") }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __("admin.orders.title") }}</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif --}}

                {{-- @if(can('settings.show') && (can('return_settings.edit') || can('exchange_settings.edit') || can('website_settings.edit') || can('domain_settings.edit')))
                    <div class="menu-item">
                        <a @class(['menu-link', 'active' => request()->routeIs('admin.settings.*')])
                            href="{{ route('admin.settings.index') }}"
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
