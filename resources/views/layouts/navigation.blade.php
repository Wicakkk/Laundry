<header class="top-header">
    <nav class="navbar navbar-expand align-items-center gap-4">
        <div class="btn-toggle">
            <a href="javascript:;"><i class="material-icons-outlined">menu</i></a>
        </div>
        <div class="search-bar flex-grow-1">
            <div class="position-relative">
                <input class="form-control rounded-5 px-5 search-control d-lg-block d-none" type="text"
                    placeholder="Search">
                <span
                    class="material-icons-outlined position-absolute d-lg-block d-none ms-3 translate-middle-y start-0 top-50">search</span>
                <span
                    class="material-icons-outlined position-absolute me-3 translate-middle-y end-0 top-50 search-close">close</span>
                <div class="search-popup p-3">
                    <div class="card rounded-4 overflow-hidden">
                        <div class="card-body search-content">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <ul class="navbar-nav gap-1 nav-right-links align-items-center">
            <li class="nav-item dropdown">
                <div class="dropdown-menu dropdown-notify dropdown-menu-end shadow">
                    <div class="notify-list">
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a href="javascrpt:;" class="dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown">
                    <img src="../assets/images/avatars/11.png" class="rounded-circle p-1 border" width="45"
                        height="45" alt="">
                </a>
                <div class="dropdown-menu dropdown-user dropdown-menu-end shadow">
                    <a class="dropdown-item  gap-2 py-2" href="javascript:;">
                        <div class="text-center">
                            <img src="../assets/images/avatars/11.png" class="rounded-circle p-1 shadow mb-3"
                                width="90" height="90" alt="">
                            <h5 class="user-name mb-0 fw-bold">Hello, {{ Auth::user()->nama }}</h5>
                        </div>
                    </a>
                    <hr class="dropdown-divider">
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i
                            class="material-icons-outlined">person_outline</i>Profile</a>
                    <hr class="dropdown-divider">
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('logout') }}"><i
                            class="material-icons-outlined">power_settings_new</i>Logout</a>
                </div>
            </li>
        </ul>

    </nav>
</header>



<aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div class="logo-icon">
            <img src="../assets/images/logo-icon.png" class="logo-img" alt="">
        </div>
        <div class="logo-name flex-grow-1">
            <h5 class="mb-0">{{ env('APP_NAME') }}</h5>
        </div>
        <div class="sidebar-close">
            <span class="material-icons-outlined">close</span>
        </div>
    </div>
    <div class="sidebar-nav">
        <ul class="metismenu" id="sidenav">
            <li>
                <a href="{{ route('dashboard') }}">
                    <div class="parent-icon"><i class="material-icons-outlined">home</i></div>
                    <div class="menu-title">Dashboard</div>
                </a>
            </li>
            @if (auth()->user()->role === 'admin' || auth()->user()->role === 'owner')
            <li class="menu-label">Management</li>
                <li>
                    <a href="{{ route('outlet.index') }}">
                        <div class="parent-icon"><i class="material-icons-outlined">account_balance</i></div>
                        <div class="menu-title">Outlets</div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('paket.index') }}">
                        <div class="parent-icon"><i class="material-icons-outlined">shopping_bag</i></div>
                        <div class="menu-title">Packages</div>
                    </a>
                </li>
            @endif
            <li class="menu-label">Data Overview</li>
            @if (auth()->user()->role === 'admin')
                <li>
                    <a href="{{ route('user.index') }}">
                        <div class="parent-icon"><i class="material-icons-outlined">person</i></div>
                        <div class="menu-title">User</div>
                    </a>
                </li>
            @endif
            <li>
                <a href="{{ route('member.index') }}">
                    <div class="parent-icon"><i class="material-icons-outlined">person</i></div>
                    <div class="menu-title">Members</div>
                </a>
            </li>
            <li>
                <a href="{{ route('transaksi.index') }}">
                    <div class="parent-icon"><i class="material-icons-outlined">money</i></div>
                    <div class="menu-title">Transactions</div>
                </a>
            </li>
        </ul>
    </div>
</aside>
