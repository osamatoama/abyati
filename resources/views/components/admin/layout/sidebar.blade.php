<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
     data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
     data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <a href="{{ route('client.home') }}">
            <img alt="Logo" src="{{ assetCustom('assets/client/media/logos/return-logo.png') }}"
                 class="h-50px app-sidebar-logo-default">
            <img alt="Logo" src="{{ assetCustom('assets/client/media/logos/return-logo-sm.png') }}"
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
             data-kt-scroll-save-state="true">
            <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu"
                 data-kt-menu="true" data-kt-menu-expand="false">
                <div class="menu-item">
                    <a @class(['menu-link', 'active' => request()->routeIs('client.home')])
                       href="{{ route('client.home') }}">
                    <span class="menu-icon">
                            <i class="fa-solid fa-home fs-2"></i>
                        </span>
                        <span class="menu-title">
                        {{ __("home.title") }}
                        </span>
                    </a>
                </div>

                @if(featureIsActive('return-system') && can('return_requests.show'))
                    <div class="menu-item">
                        <a
                            @class(['menu-link', 'active' => request()->routeIs('client.return.*')])
                            href="{{ route('client.return.requests.index') }}"
                        >
                            <span class="menu-icon">
                                <i class="fa-solid fa-rotate-left fs-2"></i>
                            </span>
                            <span class="menu-title">
                                {{ __('return.title') }}
                            </span>
                        </a>
                    </div>
                @endif

                @if(featureIsActive('exchange-system') && can('exchange_requests.show'))
                    <div class="menu-item">
                        <a
                            @class(['menu-link', 'active' => request()->routeIs('client.exchange.*')])
                            href="{{ route('client.exchange.requests.index') }}"
                        >
                            <span class="menu-icon">
                                <i class="fa-solid fa-rotate fs-2"></i>
                            </span>
                            <span class="menu-title">
                                    {{ __('exchange.title') }}
                            </span>
                        </a>
                    </div>
                @endif

                @if(featureIsActive('shipping-company-integration') && can('system_shipping_companies.show'))
                    <div class="menu-item">
                        <a
                            @class(['menu-link', 'active' => request()->routeIs('client.system-shipping-companies.*')])
                            href="{{ route('client.system-shipping-companies.index') }}"
                        >
                            <span class="menu-icon">
                                <i class="fa-solid fa-truck fs-2"></i>
                            </span>
                            <span class="menu-title">
                                {{ __('system-shipping-companies.title') }}
                            </span>
                        </a>
                    </div>
                @endif

                @if(can("roles.show") or can("employees.show"))
                    <div data-kt-menu-trigger="click"
                         class="menu-item menu-accordion {{ (request()->routeIs("client.employees.*") or request()->routeIs("client.roles.*")) ? " hover show " : "" }}">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="fa-solid fa-user fs-2"></i>
                            </span>
                            <span class="menu-title">{{ __("employees.management") }}</span>
                            <span class="menu-arrow"></span>
                        </span>

                        <div class="menu-sub menu-sub-accordion">
                            @if(can("roles.show"))
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs("client.roles.*") ? "active" : "" }}"
                                       href="{{ route("client.roles.index") }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __("roles.title") }}</span>
                                    </a>
                                </div>
                            @endif

                            @if(can("employees.show"))
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs("client.employees.*") ? "active" : "" }}"
                                       href="{{ route("client.employees.index") }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __("employees.title") }}</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                @if(true)
                    <div class="menu-item">
                        <a @class(['menu-link', 'active' => request()->routeIs('client.reports.*')])
                        href="{{ route('client.reports.index') }}"
                        >
                            <span class="menu-icon">
                                <i class="fa-solid fa-file fs-2"></i>
                            </span>
                                <span class="menu-title">
                            {{ __('reports.title') }}
                            </span>
                        </a>
                    </div>
                @endif

                @if(canAny(['whatsapp_integration.show', 'whatsapp_templates.show']))
                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ (request()->routeIs("client.whatsapp.*")) ? " hover show " : "" }}">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="fab fa-whatsapp fs-2"></i>
                            </span>
                            <span class="menu-title">{{ __('whatsapp.title') }}</span>
                            <span class="menu-arrow"></span>
                        </span>

                        <div class="menu-sub menu-sub-accordion">
                            @if(featureIsActive('whatsapp-integration') && can('whatsapp_integration.show'))
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('client.whatsapp.integration.index') ? 'active' : '' }}"
                                       href="{{ route('client.whatsapp.integration.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('whatsapp.integration') }}</span>
                                    </a>
                                </div>
                            @endif

                            @if(can('whatsapp_templates.show'))
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('client.whatsapp.templates.index') ? 'active' : '' }}"
                                       href="{{ route('client.whatsapp.templates.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('whatsapp.message_templates') }}</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- @if(featureIsActive('sms-integration') && canAny(['sms_integration.show', 'sms_templates.show'])) --}}
                @if(canAny(['sms_integration.show', 'sms_templates.show']))
                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ (request()->routeIs("client.sms.*")) ? " hover show " : "" }}">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="fas fa-comment-sms fs-2"></i>
                            </span>
                            <span class="menu-title">{{ __('sms.title') }}</span>
                            <span class="menu-arrow"></span>
                        </span>

                        <div class="menu-sub menu-sub-accordion">
                            @if(can('sms_integration.show'))
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('client.sms.integration.index') ? 'active' : '' }}"
                                       href="{{ route('client.sms.integration.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('sms.integration.title') }}</span>
                                    </a>
                                </div>
                            @endif

                            @if(can('sms_templates.show'))
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('client.sms.templates.index') ? 'active' : '' }}"
                                       href="{{ route('client.sms.templates.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('sms.message_templates') }}</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                @if(can("customers.show") or can("products.show") or can("orders.show"))
                    <div data-kt-menu-trigger="click"
                         class="menu-item menu-accordion {{ (request()->routeIs("client.customers.*") or request()->routeIs("client.products.*") or request()->routeIs("client.orders.*")) ? " hover show " : "" }}">
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
                                    <a class="menu-link {{ request()->routeIs("client.products.*") ? "active" : "" }}"
                                       href="{{ route("client.products.index") }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __("products.title") }}</span>
                                    </a>
                                </div>
                            @endif

                            @if(can("customers.show"))
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs("client.customers.*") ? "active" : "" }}"
                                    href="{{ route("client.customers.index") }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __("customers.title") }}</span>
                                    </a>
                                </div>
                            @endif

                            @if(can("orders.show"))
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs("client.orders.*") ? "active" : "" }}"
                                    href="{{ route("client.orders.index") }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __("admin.orders.title") }}</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                @if(core()->currentUserIsMerchant())
                    <div class="menu-item">
                        <a
                            @class(['menu-link', 'active' => request()->routeIs('client.subscription.index')])
                            href="{{ route('client.subscription.index') }}"
                        >
                            <span class="menu-icon">
                                <i class="fa-solid fa-file-invoice-dollar fs-2"></i>
                            </span>
                            <span class="menu-title">
                                    {{ __('subscription.title') }}
                            </span>
                        </a>
                    </div>
                @endif

                @if(can('settings.show') && (can('return_settings.edit') || can('exchange_settings.edit') || can('website_settings.edit') || can('domain_settings.edit')))
                    <div class="menu-item">
                        <a @class(['menu-link', 'active' => request()->routeIs('client.settings.*')])
                            href="{{ route('client.settings.index') }}"
                        >
                            <span class="menu-icon">
                                <i class="fa-solid fa-cog fs-2"></i>
                            </span>
                                <span class="menu-title">
                            {{ __('settings.title') }}
                            </span>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
