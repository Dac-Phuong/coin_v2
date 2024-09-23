<div class="sidebar close menu" id="mobile-show">
    <div class="logo-details">
        <a href="{{ url('/') }}" wire:navigate> <img src="../images/staking_logo.png" class="img=fluid hvr-wobble-vertical mt-3"></a>
    </div>
    <ul class="nav-links">
        <li>
            <a href="{{ url('/account') }}" wire:navigate>
                <i class="ri-dashboard-fill"></i>
                <span class="link_name">Dashboard</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="{{ url('/account') }}" wire:navigate>Dashboard</a></li>
            </ul>
        </li>
        <li>
            <a href="{{ url('/deposit') }}" wire:navigate>
                <i class="ri-luggage-deposit-fill"></i>
                <span class="link_name">Deposit</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="{{ url('/deposit') }}" wire:navigate>Deposit</a></li>
            </ul>
        </li>
        <li>
            <a href="{{ url('/withdraw') }}" wire:navigate>
                <i class="ri-money-dollar-circle-fill"></i>
                <span class="link_name">Withdraw</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="{{ url('/withdraw') }}" wire:navigate>Withdraw</a></li>
            </ul>
        </li>
        <li>
            <a href="{{ url('/list-deposit') }}" wire:navigate>
                <i class="ri-file-list-3-fill"></i>
                <span class="link_name">Deposit List</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="{{ url('/list-deposit') }}" wire:navigate>Deposit List</a></li>
            </ul>
        </li>
        <li>
            <a href="{{ url('/referrals') }}" wire:navigate>
                <i class="ri-file-history-fill"></i>
                <span class="link_name">Referral Link</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="{{ url('/referrals') }}" wire:navigate>Referral Link</a></li>
            </ul>
        </li>
        <li>
            <a href="{{ url('/edit-account') }}" wire:navigate>
                <i class="ri-edit-2-fill"></i>
                <span class="link_name">Edit Account</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="{{ url('/edit-account') }}" wire:navigate>Edit Account</a></li>
            </ul>
        </li>
        <li>
            <a href="{{ url('logout') }}" wire:navigate>
                <i class="ri-logout-circle-fill"></i>
                <span class="link_name">Logout</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="{{ url('logout') }}" wire:navigate>Logout</a></li>
            </ul>
        </li>
    </ul>
</div>