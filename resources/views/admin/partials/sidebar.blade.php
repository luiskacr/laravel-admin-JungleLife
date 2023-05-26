<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('admin.home') }}" class="app-brand-link" >
              <span class="app-brand-logo demo">
                <img alt="logo" src="{{ asset('assets/images/logo2.png') }}"  width="70" height="50">
              </span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <ul class="menu-inner py-1">
        <!-- Home -->
        <li class="menu-item {{ $title == __('app.home') ? 'active' : '' }}">
            <a href="{{ route('admin.home') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">{{ __('app.home') }}</div>
            </a>
        </li>
        <!-- Tours -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ __('app.tour_tittle') }}</span>
        </li>

        @php( $menuTour = array(__('app.tours_active'),__('app.tours_history'),__('app.tours_book'), __('app.products')))
        <li class="menu-item {{ in_array($title,$menuTour) ? 'open' : '' }} {{ in_array($title,$menuTour) ? 'active' : ''}} ">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-landscape"></i>
                <div data-i18n="Basic">{{ __('app.tour') }}</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ $title == __('app.tours_active') ? 'active' : '' }}">
                    <a href="{{ route('tours.index') }}" class="menu-link">
                        <div data-i18n="Basic">{{ __('app.tours_active') }}</div>
                    </a>
                </li>
            </ul>

            <ul class="menu-sub">
                <li class="menu-item {{ $title == __('app.tours_book') ? 'active' : '' }}">
                    <a href="{{ route('booking.index') }}" class="menu-link">
                        <div data-i18n="Basic">{{ __('app.tours_book') }}</div>
                    </a>
                </li>
            </ul>

            <ul class="menu-sub">
                <li class="menu-item {{ $title == __('app.products') ? 'active' : '' }}">
                    <a href="{{ route('product.index') }}" class="menu-link">
                        <div data-i18n="Basic">{{ __('app.products') }}</div>
                    </a>
                </li>
            </ul>

            <ul class="menu-sub">
                <li class="menu-item {{ $title == __('app.tours_history') ? 'active' : '' }}">
                    <a href="{{ route('tour-history.index') }}" class="menu-link">
                        <div data-i18n="Basic">{{ __('app.tours_history') }}</div>
                    </a>
                </li>
            </ul>

        </li>


        <li class="menu-item {{ $title == __('app.customer') ? 'active' : '' }}">
            <a href="{{ route('clients.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-circle"></i>
                <div data-i18n="Basic">{{ __('app.customer') }}</div>
            </a>
        </li>

        <li class="menu-item {{ $title == __('app.guide') ? 'active' : '' }} ">
            <a href="{{ route('guides.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-body"></i>
                <div data-i18n="Basic">{{ __('app.guide') }}</div>
            </a>
        </li>

        <li class="menu-item {{ $title == __('app.calendar') ? 'active' : '' }} ">
            <a href="{{ route('calendar.show') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-calendar"></i>
                <div data-i18n="Basic">{{ __('app.calendar') }}</div>
            </a>
        </li>

        <li class="menu-item {{ $title == __('app.invoice') ? 'active' : '' }} ">
            <a href="{{ route('invoice.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-spreadsheet"></i>
                <div data-i18n="Basic">{{ __('app.invoice') }}</div>
            </a>
        </li>


        @php( $menuConfig = array(__('app.type_client'),__('app.type_guides'),__('app.tour_type'), __('app.tour_states'),__('app.timetables'), __('app.product_type')) )
        <li class="menu-item {{ in_array($title,$menuConfig)  ? 'open' : '' }}  {{ in_array($title,$menuConfig)  ? 'active' : '' }} ">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-slider"></i>
                <div data-i18n="Account Settings">{{ __('app.config_tour') }}</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ $title == __('app.type_client') ? 'active' : '' }}">
                    <a href="{{  route('type-client.index')  }}" class="menu-link">
                        <div data-i18n="Account">{{ __('app.type_client') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ $title == __('app.type_guides') ? 'active' : '' }}">
                    <a href="{{ route('type-guides.index') }}" class="menu-link">
                        <div data-i18n="Account">{{ __('app.type_guides') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ $title == __('app.tour_type') ? 'active' : '' }}">
                    <a href="{{ route('tour-type.index') }}" class="menu-link">
                        <div data-i18n="Account">{{ __('app.tour_type') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ $title == __('app.tour_states') ? 'active' : '' }}">
                    <a href="{{  route('tour-state.index')}}" class="menu-link">
                        <div data-i18n="Account">{{ __('app.tour_states') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ $title == __('app.product_type') ? 'active' : '' }}">
                    <a href="{{  route('product-type.index')}}" class="menu-link">
                        <div data-i18n="Account">{{ __('app.product_type') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ $title == __('app.timetables') ? 'active' : '' }}">
                    <a href="{{  route('timetable.index') }}" class="menu-link">
                        <div data-i18n="Account">{{ __('app.timetables') }}</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ __('app.reports') }}</span>
        </li>

        <!-- Config -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ __('app.config') }}</span>
        </li>
        <li class="menu-item {{ $title == __('app.user') ? 'active' : '' }}">
            <a href="{{ route('users.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Basic">{{ __('app.user') }}</div>
            </a>
        </li>
        <li class="menu-item ">
            <a href="#" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Basic">Roles</div>
            </a>
        </li>
        <li class="menu-item ">
            <a href="#" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Basic">Permisos</div>
            </a>
        </li>
        <li class="menu-item {{ $title == __('app.config') ? 'active' : '' }}">
            <a href="{{ route('configurations.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-wrench"></i>
                <div data-i18n="Basic">{{ __('app.config') }}</div>
            </a>
        </li>
        <!-- Config -->

        @php($env_colors = ['local' => 'success', 'develop' => 'success', 'stage' => 'warning','production' => 'danger'] )
        @php($env_current = App::environment())
        <li class="menu-header small text-uppercase">{{ __('app.environment') }}</li>
        <li class="menu-item">
            <a class="menu-link" href="javascript:;" >
                <i class='menu-icon tf-icons bx bxs-circle environment-{{ $env_colors[$env_current] }}' ></i>
                <div data-i18n="Basic">{{ __('app.'.$env_current) }}</div>
            </a>
        </li>
        <li class="menu-item {{ $title == __('app.log_tittle') ? 'active' : '' }}">
            <a href="{{ route('log-viewer.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-message-error"></i>
                <div data-i18n="Basic">{{ __('app.log_tittle') }}</div>
            </a>
        </li>

    </ul>
</aside>
<!-- / Menu -->
