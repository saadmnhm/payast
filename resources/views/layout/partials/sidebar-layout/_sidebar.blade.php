
<!--begin::Sidebar-->
<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Logo-->
<div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
    <!--begin::Logo image-->
    <a href="{{ route('dashboard') }}">
        <img alt="Logo" src="{{ image('logos/default-dark.svg') }}" class="h-150px app-sidebar-logo-default" />
    </a>
    <!--end::Logo image-->
    <!--begin::Sidebar toggle-->
    <script type="text/javascript">
        var sidebar_toggle = document.getElementById("kt_app_sidebar_toggle");  // Get the sidebar toggle button element
        @if (isset($_COOKIE["sidebar_minimize_state"]) && $_COOKIE["sidebar_minimize_state"] === "on")
            document.body.setAttribute("data-kt-app-sidebar-minimize", "on");  // Set the 'data-kt-app-sidebar-minimize' attribute for the body tag
            sidebar_toggle.setAttribute("data-kt-toggle-state", "active");  // Set the 'data-kt-toggle-state' attribute for the sidebar toggle button
            sidebar_toggle.classList.add("active");  // Add the 'active' class to the sidebar toggle button
        @endif
    </script>
    <!--end::Sidebar toggle-->
</div>
<!--end::Logo-->
    <!--begin::sidebar menu-->
<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
    <!--begin::Menu wrapper-->
    <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
        <!--begin::Menu-->
        <div class="menu menu-column menu-rounded menu-sub-indention px-3 fw-semibold fs-6" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
            <!--begin:Menu item-->
            <div class="menu-item menu-accordion {{ request()->routeIs('dashboard') ? 'here show' : '' }}">
                <!--begin:Menu link-->
                <a class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <span class="menu-icon">{!! getIcon('element-11', 'fs-2') !!}</span>
                    <span class="menu-title">Tableau de bord</span>
                </a>
                <!--end:Menu link-->
            </div>
            <!--end:Menu item-->
            <!--begin:Menu item-->
            <div class="menu-item menu-accordion ">
                <!--begin:Menu link-->
                <a class="menu-link {{ request()->routeIs('apps.contact.*') ? 'active' : '' }}"  href="{{ route('apps.contact.index') }}">
                    <span class="menu-icon">{!! getIcon('notification-status', 'fs-2') !!}</span>
                    <span class="menu-title">Demandes de Contact</span>
                </a>
                <!--end:Menu link-->
            </div>
            <!--end:Menu item-->
            <!--begin:Menu item-->

            <!--end:Menu item-->
            <!--begin:Menu item-->
            <div class="menu-item menu-accordion ">
                <!--begin:Menu link-->
                <a class="menu-link {{ request()->routeIs('apps.navigation-menu.*') ? 'active' : '' }}"  href="{{ route('apps.navigation-menu.index') }}">
                    <span class="menu-icon">{!! getIcon('menu', 'fs-2') !!}</span>
                    <span class="menu-title">Menu de Navigation</span>
                </a>
                <!--end:Menu link-->
            </div>
            <!--end:Menu item-->
            <!--begin:Menu item-->
            <div class="menu-item menu-accordion ">
                <!--begin:Menu link-->
                <a class="menu-link {{ request()->routeIs('apps.cataloge.*') ? 'active' : '' }}"  href="{{ route('apps.cataloge.index') }}">
                    <span class="menu-icon">{!! getIcon('menu', 'fs-2') !!}</span>
                    <span class="menu-title">cataloge de piece</span>
                </a>
                <!--end:Menu link-->
            </div>
            <!--end:Menu item-->
             <!--begin:Menu item-->
             <div data-kt-menu-trigger="click" class="menu-item menu-accordion ">
                <!--begin:Menu link-->
                <span class="menu-link">
                    <span class="menu-icon">{!! getIcon('setting', 'fs-2') !!}</span>
                    <span class="menu-title">Référentiel </span>
                    <span class="menu-arrow"></span>
                </span>
                <!--end:Menu link-->

                <!--begin:Menu sub-->
                <div class="menu-sub menu-sub-accordion">
                    <!--begin:Menu item-->
                    <!--end:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->routeIs('apps.users.*') ? 'active' : '' }}" href="{{ route('apps.users.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Utilisateurs</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                </div>

                <div class="menu-sub menu-sub-accordion">
                    <!--begin:Menu item-->
                    <!--end:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->routeIs('apps.brand.*') ? 'active' : '' }}" href="{{ route('apps.brand.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Brand</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                </div>

                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->routeIs('apps.constructeur.*') ? 'active' : '' }}" href="{{ route('apps.constructeur.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Constructeur</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                </div>
            </div>
            <!--end:Menu item-->
        </div>
        <!--end::Menu-->
    </div>
    <!--end::Menu wrapper-->
</div>
<!--end::sidebar menu-->
</div>
<!--end::Sidebar-->
