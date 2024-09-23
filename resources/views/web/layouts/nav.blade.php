@php
    $investor = session()->get('investor');
@endphp

<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand hvr-pulse-grow d-flex block items-center" href="{{ url('/') }}" wire:navigate>
        <img src="{{ asset('images/staking_logo.png') }}" alt="" class="logo img-fluid"
            style="height: 60px; width: 60px;" />
        <h2 class="text-center pl-2 " style="font-size: 26px;text-transform: uppercase;font-weight: 700">Stakingcoins</h2>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span> <i class="bi bi-list"></i></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent" style="visibility: visible !important;">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link hvr-underline-from-left" aria-current="page" href="{{ url('/') }}"
                    wire:navigate>
                    Home
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link hvr-underline-from-left" href="{{ url('/aboutus') }}" wire:navigate>
                    About Us
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link hvr-underline-from-left" href="{{ url('/faq') }}" wire:navigate>
                    Faq
                </a>
            </li>

            <li class="nav-item dropdown-language dropdown me-2 me-xl-0 ">
                <div id="google_element"></div>
                {{-- <a class="nav-link dropdown-toggle hide-arrow" id="dropdownDefaultButton"
                    data-dropdown-toggle="dropdown">
                    <i class='fa fa-language' style="font-size:22px;"></i>
                </a>
                <ul id="dropdown" aria-labelledby="dropdownDefaultButton" class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item {{ app()->getLocale() === 'en' ? 'active' : '' }}"
                            href="{{ url('admin/lang/en') }}" data-language="en" data-text-direction="ltr">
                            <span class="align-middle">English</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ app()->getLocale() === 'vi' ? 'active' : '' }}"
                            href="{{ url('admin/lang/vi') }}" data-language="vi" data-text-direction="ltr">
                            <span class="align-middle">VietNam</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ app()->getLocale() === 'fr' ? 'active' : '' }}"
                            href="{{ url('admin/lang/fr') }}" data-language="fr" data-text-direction="ltr">
                            <span class="align-middle">French</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ app()->getLocale() === 'ar' ? 'active' : '' }}"
                            href="{{ url('admin/lang/ar') }}" wire:navigate data-language="ar"
                            data-text-direction="rtl">
                            <span class="align-middle">Arabic</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ app()->getLocale() === 'de' ? 'active' : '' }}"
                            href="{{ url('admin/lang/de') }}" data-language="de" data-text-direction="ltr">
                            <span class="align-middle">German</span>
                        </a>
                    </li>
                </ul> --}}
            </li>
            <li class="nav-item nav_but">
                <a class="nav-link hvr-float-shadow" href="{{ $investor ? url('account') : url('register') }}"
                    wire:navigate>
                    {{ $investor ? 'Account' : 'signup' }}
                </a>
            </li>
            <li class="nav-item nav_but">
                <a class="nav-link nav-link1 hvr-float-shadow" href="{{ $investor ? url('logout') : url('login') }}"
                    wire:navigate>
                    {{ $investor ? 'logout' : 'login' }}
                </a>
            </li>
        </ul>
    </div>
</nav>
