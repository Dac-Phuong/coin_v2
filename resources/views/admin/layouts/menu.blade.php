    <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
        <div class="app-brand demo">
            <a href="{{ route('dashboard') }}" class="app-brand-link">
                <span class="app-brand-logo demo">
                    <svg width="32" height="22" viewBox="0 0 32 22" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
                            fill="#7367F0" />
                        <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                            d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z" fill="#161616" />
                        <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                            d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z" fill="#161616" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
                            fill="#7367F0" />
                    </svg>
                </span>
                <span class="app-brand-text demo menu-text fw-bold">Hyip Coin</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
                <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
            </a>
        </div>
        <div class="menu-inner-shadow"></div>
        <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="menu-header small pt-1">
                <span class="menu-header-text" data-i18n="Apps &amp; Pages">{{ __('SYSTEM MANAGEMENT') }}</span>
            </li>
            <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-smart-home"></i>
                    <div data-i18n="Thống kê">{{ __('Dashboard') }}</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('users') || request()->routeIs('roles') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-users"></i>
                    <div data-i18n="Quản lý phân quyền">{{ __('Users') }}</div>
                </a>
                <ul class="menu-sub">
                    @can('list-user')
                        <li class="menu-item {{ request()->routeIs('users') ? 'active' : '' }}">
                            <a href="{{ url('admin/user/list') }}" class="menu-link">
                                <div data-i18n="Danh sách">{{ __('Users') }}</div>
                            </a>
                        </li>
                    @endcan
                    @can('list-role')
                        <li class="menu-item {{ request()->routeIs('roles') ? 'active' : '' }}">
                            <a href="{{ url('admin/role/list') }}" class="menu-link">
                                <div data-i18n="Vai trò">{{ __('Roles') }}</div>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
            <li class="menu-header small pt-1">
                <span class="menu-header-text" data-i18n="Apps &amp; Pages">{{ __('INVESTOR MANAGEMENT') }}</span>
            </li>
            <!-- Layouts -->
            @can('list-investor')
                <li class="menu-item {{ request()->routeIs('investors') ? 'active' : '' }}">
                    <a href="{{ url('admin/investor/list') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-users"></i>
                        <div data-i18n="Danh sách">{{ __('Investor') }}</div>
                    </a>
                </li>
            @endcan
            @can('list-network')
                <li class="menu-item {{ request()->routeIs('network') ? 'active' : '' }}">
                    <a href="{{ url('admin/network/list') }}" class="menu-link">
                        <i class="menu-icon ti ti-network"></i>
                        <div data-i18n="Danh sách đầu tư">{{ __('Network') }}</div>
                    </a>
                </li>
            @endcan
            @can('list-coin')
                <li class="menu-item {{ request()->routeIs('coin') ? 'active' : '' }}">
                    <a href="{{ url('admin/coin/list') }}" class="menu-link">
                        <i class="menu-icon ti ti-coin"></i>
                        <div data-i18n="Danh sách ví">{{ __('Coin') }}</div>
                    </a>
                </li>
            @endcan
            @can('list-plan')
                <li class="menu-item {{ request()->routeIs('plans') ? 'active' : '' }}">
                    <a href="{{ url('admin/plan/list') }}" class="menu-link">
                        <i class="menu-icon ti ti-checklist"></i>
                        <div data-i18n="Gói cố định">{{ __('Plan') }}</div>
                    </a>
                </li>
            @endcan
            <li class="menu-header small pt-1">
                <span class="menu-header-text" data-i18n="Apps &amp; Pages">{{ __('Bill MANAGEMENT') }}</span>
            </li>
            @can('list-deposit')
                <li class="menu-item {{ request()->routeIs('deposits') ? 'active' : '' }}">
                    <a href="{{ url('admin/deposit/list') }}" class="menu-link">
                        <i class="menu-icon ti ti-credit-card"></i>
                        <div data-i18n="Danh sách đầu tư">{{ __('Deposit') }}</div>
                    </a>
                </li>
            @endcan
            @can('list-withdraw')
                <li class="menu-item {{ request()->routeIs('withdraws') ? 'active' : '' }}">
                    <a href="{{ url('admin/withdraw/list') }}" class="menu-link">
                        <i class="menu-icon ti ti-wallet"></i>
                        <div data-i18n="Danh sách rút tiền">{{ __('Withdraw') }}</div>
                    </a>
                </li>
            @endcan
            @can('list-referral')
                <li class="menu-item {{ request()->routeIs('referrals') ? 'active' : '' }}">
                    <a href="{{ url('admin/referral/list') }}" class="menu-link">
                        <i class="menu-icon ti ti-share"></i>
                        <div data-i18n="Danh sách giới thiệu">{{ __('Referral') }}</div>
                    </a>
                </li>
            @endcan
            @can('settings')
                <li class="menu-item {{ request()->routeIs('settings') ? 'active' : '' }}">
                    <a href="{{ url('admin/settings') }}" class="menu-link">
                        <i class="menu-icon ti ti-settings"></i>
                        <div data-i18n="Danh sách rút tiền">{{ __('Settings') }}</div>
                    </a>
                </li>
            @endcan
        </ul>
    </aside>
