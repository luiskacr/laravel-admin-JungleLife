<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('admin.home') }}" class="app-brand-link" >
              <span class="app-brand-logo demo">
                <img src="{{ asset('assets/images/logo2.png') }}"  width="70" height="50">
              </span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Home -->
        <li class="menu-item active">
            <a href="{{ route('admin.home') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">{{ __('app.home') }}</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ __('app.tour_tittle') }}</span>
        </li>

        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-landscape"></i>
                <div data-i18n="Account Settings">Tour</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('guides.index') }}" class="menu-link">
                        <div data-i18n="Account">{{ __('app.guide') }}</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('clients.index') }}" class="menu-link">
                        <div data-i18n="Notifications">{{ __('app.customer') }}</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('tours.index') }}" class="menu-link">
                        <div data-i18n="Connections">Tours</div>
                    </a>
                </li>
            </ul>
        </li>


        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ __('app.tour_config_tittle') }}</span>
        </li>

        <li class="menu-item">
            <a href="{{ route('type-client.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-pin"></i>
                <div data-i18n="Basic">{{ __('app.type_client') }}</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('type-guides.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-voice"></i>
                <div data-i18n="Basic">{{ __('app.type_guides') }}</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{ route('tour-type.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-calendar-plus"></i>
                <div data-i18n="Basic">{{ __('app.tour_type') }}</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{ route('tour-state.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-calendar-check"></i>
                <div data-i18n="Basic">{{ __('app.tour_states') }}</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Pages</span>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">Account Settings</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="pages-account-settings-account.html" class="menu-link">
                        <div data-i18n="Account">Account</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="pages-account-settings-notifications.html" class="menu-link">
                        <div data-i18n="Notifications">Notifications</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="pages-account-settings-connections.html" class="menu-link">
                        <div data-i18n="Connections">Connections</div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
<!-- / Menu -->
