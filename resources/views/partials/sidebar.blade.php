    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->

    <!-- [ navigation menu ] start -->
    <nav class="pcoded-navbar menu-light ">
        <div class="navbar-wrapper  ">
            <div class="navbar-content scroll-div ">

                <div class="">
                    <div class="main-menu-header">
                        <img class="img-radius" src="assets/images/user/avatar-2.jpg" alt="User-Profile-Image">

                        <div class="user-details">
                            <div id="more-details">{{ $user->username }}<i class="fa fa-caret-down"></i></div>
                        </div>
                    </div>
                    <div class="collapse" id="nav-user-link">
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="user-profile.html" data-toggle="tooltip"
                                    title="View Profile"><i class="feather icon-user"></i></a></li>
                            <li class="list-inline-item"><a href="email_inbox.html"><i class="feather icon-mail"
                                        data-toggle="tooltip" title="Messages"></i><small
                                        class="badge badge-pill badge-primary">5</small></a></li>
                            <li class="list-inline-item"><a href="auth-signin.html" data-toggle="tooltip" title="Logout"
                                    class="text-danger"><i class="feather icon-power"></i></a></li>
                        </ul>
                    </div>
                </div>

                <ul class="nav pcoded-inner-navbar">
                    @foreach ($groupedMenus as $menuId => $menuItems)
                        {{-- <li class="nav-item pcoded-menu-caption">
                            <label>{{ $menuItems->first()->nama_menu }}</label>
                        </li> --}}
                        <li class="nav-item pcoded-hasmenu">
                            <a href="#!" class="nav-link">
                                <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                                <span class="pcoded-mtext">{{ $menuItems->first()->nama_menu }}</span>
                            </a>
                            <ul class="pcoded-submenu">
                                @foreach ($menuItems as $item)
                                    <li><a href="{{ url($item->url_menu) }}">{{ $item->nama_menu_sub }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>

            </div>
        </div>
    </nav>
    <!-- [ navigation menu ] end -->
