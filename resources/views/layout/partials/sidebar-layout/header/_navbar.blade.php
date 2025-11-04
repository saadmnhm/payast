<!--begin::Navbar-->
<div class="app-navbar flex-shrink-0">
    <!--begin::Search-->
    {{-- <div class="app-navbar-item align-items-stretch ms-1 ms-md-3">
        @include(config('settings.KT_THEME_LAYOUT_DIR').'/partials/sidebar-layout/search/_dropdown')
    </div> --}}
    <!--end::Search-->
    <!--begin::Activities-->
	{{-- <div class="app-navbar-item ms-1 ms-md-4">
        <!--begin::Drawer toggle-->
		<div class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px" id="kt_activities_toggle">{!! getIcon('messages', 'fs-2') !!}</div>
        <!--end::Drawer toggle-->
    </div> --}}
    <!--end::Activities-->
    <!--begin::Notifications-->
	{{-- <div class="app-navbar-item ms-1 ms-md-4">
        <!--begin::Menu- wrapper-->
		<div class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" id="kt_menu_item_wow">{!! getIcon('notification-status', 'fs-2') !!}</div>
        @include('partials/menus/_notifications-menu')
        <!--end::Menu wrapper-->
    </div> --}}
    <!--end::Notifications-->
    <!--begin::Chat-->
	{{-- <div class="app-navbar-item ms-1 ms-md-4">
        <!--begin::Menu wrapper-->
		<div class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px position-relative" id="kt_drawer_chat_toggle">{!! getIcon('message-text-2', 'fs-2') !!} 
		<span class="bullet bullet-dot bg-success h-6px w-6px position-absolute translate-middle top-0 start-50 animation-blink"></span></div>
        <!--end::Menu wrapper-->
    </div> --}}
    <!--end::Chat-->
    <!--begin::My apps links-->
	{{-- <div class="app-navbar-item ms-1 ms-md-4">
        <!--begin::Menu wrapper-->
		<div class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">{!! getIcon('element-11', 'fs-2') !!}</div>
        @include('partials/menus/_my-apps-menu')
        <!--end::Menu wrapper-->
    </div> --}}
    <!--end::My apps links-->
    <!--begin::User menu-->
	<div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
        <!--begin::Menu wrapper-->
		<div class="cursor-pointer symbol symbol-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
            @if(Auth::user()->profile_photo_url)
                <img src="{{ \Auth::user()->profile_photo_url }}" class="rounded-3" alt="user" />
            @else
                <div class="symbol-label fs-3 {{ app(\App\Actions\GetThemeType::class)->handle('bg-light-? text-?', Auth::user()->name) }}">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            @endif
        </div>
        <!--begin::User account menu-->
<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
    <!--begin::Menu item-->
    <div class="menu-item px-3">
        <div class="menu-content d-flex align-items-center px-3">
            <!--begin::Avatar-->
            <div class="symbol symbol-50px me-5">
                @if(Auth::user()->profile_photo_url)
                    <img alt="Logo" src="{{ Auth::user()->profile_photo_url }}"/>
                @else
                    <div class="symbol-label fs-3 {{ app(\App\Actions\GetThemeType::class)->handle('bg-light-? text-?', Auth::user()->name) }}">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                @endif
            </div>
            <!--end::Avatar-->
            <!--begin::Username-->
            <div class="d-flex flex-column">
                <div class="fw-bold d-flex align-items-center fs-5">{{ Auth::user()->name}}
                </div>
                <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">{{ Auth::user()->email }}</a>
            </div>
            <!--end::Username-->
        </div>
    </div>
    <!--end::Menu item-->
    <!--begin::Menu separator-->
    <div class="separator my-2"></div>
    <!--end::Menu separator-->
    <!--begin::Menu item-->
    <div class="menu-item px-5">
        <a href="#" class="menu-link px-5">My Profile</a>
    </div>
   
    <!--end::Menu item-->
    <!--begin::Menu item-->
    <div class="menu-item px-5">
        <a class="button-ajax menu-link px-5" href="#" data-action="{{ route('logout') }}" data-method="post" data-csrf="{{ csrf_token() }}" data-reload="true">
            Sign Out
        </a>
    </div>
    <!--end::Menu item-->
</div>
<!--end::User account menu-->

        <!--end::Menu wrapper-->
    </div>
    <!--end::User menu-->
    {{-- <!--begin::Header menu toggle-->
	<div class="app-navbar-item d-lg-none ms-2 me-n2" title="Show header menu">
		<div class="btn btn-flex btn-icon btn-active-color-primary w-30px h-30px" id="kt_app_header_menu_toggle">{!! getIcon('element-4', 'fs-1') !!}</div>
    </div> --}}
    <!--end::Header menu toggle-->
	<!--begin::Aside toggle-->
	<!--end::Header menu toggle-->
</div>
<!--end::Navbar-->
