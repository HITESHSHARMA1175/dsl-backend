<div class="main-header side-header sticky">
    <div class="main-container container-fluid">
        <div class="main-header-left">
            <a class="main-header-menu-icon" href="javascript:void(0)" id="mainSidebarToggle"><span></span></a>
            <div class="hor-logo">
                <a class="main-logo" href="{{ route('dashboard') }}">
                    <img src="{{ asset('assets/img/Logo_SH_Grey.png') }}" class="header-brand-img desktop-logo"
                        alt="logo" style="width:60px;">
                    <img src="{{ asset('assets/img/Logo_SH_Grey.png') }}" class="header-brand-img desktop-logo-dark"
                        alt="logo" style="width:60px;">
                    <img src="{{ asset('assets/img/brand/icon-light.png') }}" class="header-brand-img icon-logo"
                        alt="logo">
                    <img src="{{ asset('assets/img/brand/logo.png') }}" class="header-brand-img desktop-logo theme-logo"
                        alt="logo">
                    <img src="{{ asset('assets/img/brand/icon.png') }}" class="header-brand-img icon-logo theme-logo"
                        alt="logo">
                </a>
            </div>


        </div>
        <div class="main-header-center">
            <div class="responsive-logo">
                <a href="{{ route('dashboard') }}"><img src="{{ asset('assets/img/brand/logo.png') }}"
                        class="mobile-logo" alt="logo" style="height:50px;"></a>
                <a href="{{ route('dashboard') }}"><img src="{{ asset('assets/img/brand/logo-light.png') }}"
                        class="mobile-logo-dark" alt="logo"></a>
            </div>

        </div>
        <div class="main-header-right">
            <div class="dropdown main-profile-menu navbar-toggler navresponsive-toggler">
                <a class="d-flex" href="javascript:void(0)">
                    <span class="main-img-user"><img alt="avatar"
                            src="{{ !empty(auth()->user()->profile) ? asset('uploads/userimage/' . auth()->user()->profile) : asset('assets/img/user-img-.png') }}"></span>
                </a>
                <div class="dropdown-menu">
                    <div class="header-navheading">
                        <h6 class="main-notification-title">{{ auth()->user()->first_name }}
                            {{ auth()->user()->last_name }}</h6>
                        <p class="main-notification-text">{{ auth()->user()->emp_type }}</p>
                    </div>
                    <a class="dropdown-item" href="{{ route('logout') }}">
                        <i class="fe fe-power"></i> Sign Out
                    </a>
                </div>
            </div>
            <!--<button class="navbar-toggler navresponsive-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4"
                aria-expanded="false" aria-label="Toggle navigation">
                <i class="fe fe-more-vertical header-icons navbar-toggler-icon"></i>
            </button>--><!-- Navresponsive closed -->
            <div class="navbar navbar-expand-lg  nav nav-item  navbar-nav-right responsive-navbar navbar-dark  ">
                <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                    <div class="d-flex order-lg-2 ms-auto">
                        <!-- Search -->
                        <div class="dropdown header-search">
                            <a class="nav-link icon header-search">
                                <i class="fe fe-search header-icons"></i>
                            </a>

                        </div>
                        <!-- Search -->
                        <!-- Theme-Layout -->
                        <div class="dropdown d-flex main-header-theme">
                            <a class="nav-link icon layout-setting">
                                <span class="dark-layout">
                                    <i class="fe fe-sun header-icons"></i>
                                </span>
                                <span class="light-layout">
                                    <i class="fe fe-moon header-icons"></i>
                                </span>
                            </a>
                        </div>
                        <!-- Theme-Layout -->

                        <!-- Full screen -->
                        <div class="dropdown ">
                            <a class="nav-link icon full-screen-link">
                                <i class="fe fe-maximize fullscreen-button fullscreen header-icons"></i>
                                <i class="fe fe-minimize fullscreen-button exit-fullscreen header-icons"></i>
                            </a>
                        </div>
                        <!-- Full screen -->
                        <!-- Notification -->
                        <!--<div class="dropdown main-header-notification">
                            <a class="nav-link icon" href="">
                                <i class="fe fe-bell header-icons"></i>
                                <span class="badge bg-danger nav-link-badge">4</span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="header-navheading">
                                    <p class="main-notification-text">You have 1 unread notification<span
                                            class="badge bg-pill bg-primary ms-3">View all</span></p>
                                </div>
                                <div class="main-notification-list">
                                    <div class="media new">
                                        <div class="main-img-user online"><img alt="avatar"
                                                src="{{ asset('assets/img/users/5.jpg') }}"></div>
                                        <div class="media-body">
                                            <p>Congratulate <strong>Olivia James</strong> for New template
                                                start</p>
                                            <span>Oct 15 12:32pm</span>
                                        </div>
                                    </div>
                                    <div class="media">
                                        <div class="main-img-user"><img alt="avatar"
                                                src="{{ asset('assets/img/users/2.jpg') }}">
                                        </div>
                                        <div class="media-body">
                                            <p><strong>Joshua Gray</strong> New Message Received</p>
                                            <span>Oct 13
                                                02:56am</span>
                                        </div>
                                    </div>
                                    <div class="media">
                                        <div class="main-img-user online"><img alt="avatar"
                                                src="{{ asset('assets/img/users/3.jpg') }}"></div>
                                        <div class="media-body">
                                            <p><strong>Elizabeth Lewis</strong> added new schedule realease
                                            </p><span>Oct
                                                12 10:40pm</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown-footer">
                                    <a href="javascript:void(0)">View All Notifications</a>
                                </div>
                            </div>
                        </div>-->
                        <!-- Notification -->
                        <!-- Messages -->
                        <!--<div class="main-header-notification">
                            <a class="nav-link icon" href="chat.html">
                                <i class="fe fe-message-square header-icons"></i>
                                <span class="badge bg-success nav-link-badge">6</span>
                            </a>
                        </div>-->
                        <!-- Messages -->
                        <!-- Profile -->
                        <div class="dropdown main-profile-menu">
                            <a class="d-flex" href="javascript:void(0)">
                                <span class="main-img-user"><img alt="avatar"
                                        src="{{ !empty(auth()->user()->profile) ? asset('uploads/userimage/' . auth()->user()->profile) : asset('assets/img/user-img-.png') }}"></span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="header-navheading">
                                    <h6 class="main-notification-title">{{ auth()->user()->first_name }}
                                        {{ auth()->user()->last_name }}</h6>
                                    <p class="main-notification-text">{{ auth()->user()->emp_type }}</p>
                                </div>
                                <!--<a class="dropdown-item border-top" href="profile.html">
                                    <i class="fe fe-user"></i> My Profile
                                </a>
                                <a class="dropdown-item" href="profile.html">
                                    <i class="fe fe-edit"></i> Edit Profile
                                </a>
                                <a class="dropdown-item" href="profile.html">
                                    <i class="fe fe-settings"></i> Account Settings
                                </a>
                                <a class="dropdown-item" href="profile.html">
                                    <i class="fe fe-settings"></i> Support
                                </a>
                                <a class="dropdown-item" href="profile.html">
                                    <i class="fe fe-compass"></i> Activity
                                </a>-->
                                <a class="dropdown-item" href="{{ route('logout') }}">
                                    <i class="fe fe-power"></i> Sign Out
                                </a>
                            </div>
                        </div>
                        <!-- Profile -->
                        <!-- Sidebar -->
                        <!--<div class="dropdown  header-settings">
                            <a href="javascript:void(0)" class="nav-link icon" data-bs-toggle="sidebar-right"
                                data-bs-target=".sidebar-right">
                                <i class="fe fe-align-right header-icons"></i>
                            </a>
                        </div>-->
                        <!-- Sidebar -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
