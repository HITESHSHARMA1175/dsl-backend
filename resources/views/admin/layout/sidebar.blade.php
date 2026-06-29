<!-- Sidemenu -->
<div class="sticky">
    <div class="main-menu main-sidebar main-sidebar-sticky side-menu">
        <div class="main-sidebar-header main-container-1 active">
            <div class="sidemenu-logo">
                <a class="main-logo" href="{{ route('dashboard') }}">
                    <img src="{{ asset('assets/img/Logo_SH_Grey.png') }}" class="header-brand-img desktop-logo"
                        alt="logo">
                    <img src="{{ asset('assets/img/brand/icon-light.png') }}" class="header-brand-img icon-logo"
                        alt="logo">
                    <img src="{{ asset('assets/img/brand/logo.png') }}" class="header-brand-img desktop-logo theme-logo"
                        alt="logo">
                    <img src="{{ asset('assets/img/brand/icon.png') }}" class="header-brand-img icon-logo theme-logo"
                        alt="logo">
                </a>
            </div>
            <div class="main-sidebar-body main-body-1">
                <div class="slide-left disabled" id="slide-left"><i class="fe fe-chevron-left"></i></div>
                <ul class="menu-nav nav">
                    <li class="nav-header"><span class="nav-label">Dashboard</span></li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            <span class="shape1"></span>
                            <span class="shape2"></span>
                            <i class="ti-home sidemenu-icon menu-icon "></i>
                            <span class="sidemenu-label"> Dashboard</span>
                        </a>
                    </li>

                    {{-- <li class="nav-item">
                        <a class="nav-link with-sub" href="javascript:void(0)">
                            <span class="shape1"></span>
                            <span class="shape2"></span>
                            <i class="ti-wallet sidemenu-icon menu-icon "></i>
                            <span class="sidemenu-label">Sub Admin</span>
                            <i class="angle fe fe-chevron-right"></i>
                        </a>
                        <ul class="nav-sub">
                            <li class="side-menu-label1"><a href="javascript:void(0)">Sub Admin</a></li>

                            <li class="nav-sub-item"> <a class="nav-sub-link" href="{{ route('subadmin.create') }}">Add
                                    Sub Admin</a></li>
                            <li class="nav-sub-item"> <a class="nav-sub-link" href="{{ route('subadmin.index') }}">View
                                    Sub Admin</a></li>

                        </ul>
                    </li> --}}

                    <li class="nav-item">
                        <a class="nav-link with-sub" href="javascript:void(0)">
                            <span class="shape1"></span>
                            <span class="shape2"></span>
                            <i class="ti-wallet sidemenu-icon menu-icon "></i>
                            <span class="sidemenu-label">Masters</span>
                            <i class="angle fe fe-chevron-right"></i>
                        </a>
                        <ul class="nav-sub">
                            <li class="side-menu-label1"><a href="javascript:void(0)">Masters</a></li>

                            <li class="nav-sub-item"> <a class="nav-sub-link" href="{{ route('masters.index') }}">Manage
                                    Master</a></li>
                            <li class="nav-sub-item"> <a class="nav-sub-link"
                                    href="{{ route('mastervalues.index') }}">Manage Master Value</a></li>
                            <li class="nav-sub-item"> <a class="nav-sub-link"
                                    href="{{ route('banner.index') }}">Manage Banner</a></li>
                            <li class="nav-sub-item"> <a class="nav-sub-link"
                                    href="{{ route('faq.index') }}">Manage Faq</a></li>
                            <li class="nav-sub-item"> <a class="nav-sub-link"
                                    href="{{ route('reviews.index') }}">Manage Review</a></li>
                            <li class="nav-sub-item"> <a class="nav-sub-link"
                                    href="{{ route('blog.index') }}">Manage Blog</a></li>
                            <li class="nav-sub-item"> <a class="nav-sub-link"
                                    href="{{ route('clinic.index') }}">Manage Clinic</a></li>
                            <li class="nav-sub-item"> <a class="nav-sub-link"
                                    href="{{ route('team.index') }}">Manage Team</a></li>
                            <li class="nav-sub-item"> <a class="nav-sub-link"
                                    href="{{ route('medicalhistory.index') }}">Medical History</a></li>
                            <li class="nav-sub-item"> <a class="nav-sub-link"
                                    href="{{ route('concern.index') }}">Concern</a></li>
                            <li class="nav-sub-item"> <a class="nav-sub-link"
                                    href="{{ route('clinicaloption.index') }}">Clinical Option</a></li>
                            <li class="nav-sub-item"> <a class="nav-sub-link"
                                    href="{{ route('redurl.index') }}">Redirect URL</a></li>
                            <li class="nav-sub-item"> <a class="nav-sub-link"
                                    href="{{ route('seo.index') }}">Page SEO</a></li>

                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link with-sub" href="javascript:void(0)">
                            <span class="shape1"></span>
                            <span class="shape2"></span>
                            <i class="ti-wallet sidemenu-icon menu-icon "></i>
                            <span class="sidemenu-label">Category</span>
                            <i class="angle fe fe-chevron-right"></i>
                        </a>
                        <ul class="nav-sub">
                            <li class="side-menu-label1"><a href="javascript:void(0)">Category</a></li>
                            <li class="nav-sub-item"> <a class="nav-sub-link"
                                    href="{{ route('servicecatmain.index') }}">Main Category List</a></li>
                            <li class="nav-sub-item"> <a class="nav-sub-link"
                                    href="{{ route('servicecatmain.create') }}">Add Main Category</a></li>
                            <li class="nav-sub-item"> <a class="nav-sub-link"
                                    href="{{ route('servicecat.index') }}">Service Category List</a></li>
                            <li class="nav-sub-item"> <a class="nav-sub-link"
                                    href="{{ route('servicecat.create') }}">Add Service Category</a></li>
                            <li class="nav-sub-item"> <a class="nav-sub-link"
                                    href="{{ route('servicesubcat.index') }}">Service Sub Category List</a></li>
                            <li class="nav-sub-item"> <a class="nav-sub-link"
                                    href="{{ route('servicesubcat.create') }}">Add Service Sub Category</a></li>
                            <li class="nav-sub-item"> <a class="nav-sub-link"
                                    href="{{ route('skincondition.index') }}">Condition List</a></li>
                            <li class="nav-sub-item"> <a class="nav-sub-link"
                                    href="{{ route('skincondition.create') }}">Add Condition</a></li>
                            <li class="nav-sub-item"> <a class="nav-sub-link"
                                    href="{{ route('skinsubcondition.index') }}">Sub Condition List</a></li>
                            <li class="nav-sub-item"> <a class="nav-sub-link"
                                    href="{{ route('skinsubcondition.create') }}">Add Sub Condition</a></li>

                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link with-sub" href="javascript:void(0)">
                            <span class="shape1"></span>
                            <span class="shape2"></span>
                            <i class="ti-wallet sidemenu-icon menu-icon "></i>
                            <span class="sidemenu-label">Treatment</span>
                            <i class="angle fe fe-chevron-right"></i>
                        </a>
                        <ul class="nav-sub">
                            <li class="side-menu-label1"><a href="javascript:void(0)">Treatment</a></li>

                            <li class="nav-sub-item"> <a class="nav-sub-link"
                                    href="{{ route('treatments.index') }}">Treatment List</a></li>
                            <li class="nav-sub-item"> <a class="nav-sub-link"
                                    href="{{ route('treatments.create') }}">Add Treatment</a></li>

                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link with-sub" href="javascript:void(0)">
                            <span class="shape1"></span>
                            <span class="shape2"></span>
                            <i class="ti-wallet sidemenu-icon menu-icon "></i>
                            <span class="sidemenu-label">Service</span>
                            <i class="angle fe fe-chevron-right"></i>
                        </a>
                        <ul class="nav-sub">
                            <li class="side-menu-label1"><a href="javascript:void(0)">Service</a></li>

                            <li class="nav-sub-item"> <a class="nav-sub-link"
                                    href="{{ route('property.index') }}">Service List</a></li>
                            <li class="nav-sub-item"> <a class="nav-sub-link" href="{{ route('property.create') }}">Add
                                    Service</a></li>

                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link with-sub" href="javascript:void(0)">
                            <span class="shape1"></span>
                            <span class="shape2"></span>
                            <i class="ti-wallet sidemenu-icon menu-icon "></i>
                            <span class="sidemenu-label">Addon</span>
                            <i class="angle fe fe-chevron-right"></i>
                        </a>
                        <ul class="nav-sub">
                            <li class="side-menu-label1"><a href="javascript:void(0)">Addon</a></li>

                            <li class="nav-sub-item"> <a class="nav-sub-link" href="{{ route('addon.index') }}">Addon
                                    List</a></li>
                            <li class="nav-sub-item"> <a class="nav-sub-link" href="{{ route('addon.create') }}">Add
                                    Addon</a></li>

                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link with-sub" href="javascript:void(0)">
                            <span class="shape1"></span>
                            <span class="shape2"></span>
                            <i class="ti-wallet sidemenu-icon menu-icon "></i>
                            <span class="sidemenu-label">Professional</span>
                            <i class="angle fe fe-chevron-right"></i>
                        </a>
                        <ul class="nav-sub">
                            <li class="side-menu-label1"><a href="javascript:void(0)">Professional</a></li>

                            <li class="nav-sub-item"> <a class="nav-sub-link"
                                    href="{{ route('professional.index') }}">Professional
                                    List</a></li>
                            <li class="nav-sub-item"> <a class="nav-sub-link"
                                    href="{{ route('professional.create') }}">Add
                                    Professional</a></li>

                        </ul>
                    </li>

                    {{-- <li class="nav-item">
                        <a class="nav-link with-sub" href="javascript:void(0)">
                            <span class="shape1"></span>
                            <span class="shape2"></span>
                            <i class="ti-wallet sidemenu-icon menu-icon "></i>
                            <span class="sidemenu-label">Banner</span>
                            <i class="angle fe fe-chevron-right"></i>
                        </a>
                        <ul class="nav-sub">
                            <li class="side-menu-label1"><a href="javascript:void(0)">Banner</a></li>

                            <li class="nav-sub-item"> <a class="nav-sub-link" href="{{ route('banner.index') }}">Manage
                                    Banner</a></li>
                            <li class="nav-sub-item"> <a class="nav-sub-link" href="{{ route('banner.create') }}">Add
                                    Banner</a></li>

                        </ul>
                    </li> --}}


                    <li class="nav-item">
                        <a class="nav-link with-sub" href="javascript:void(0)">
                            <span class="shape1"></span>
                            <span class="shape2"></span>
                            <i class="ti-wallet sidemenu-icon menu-icon "></i>
                            <span class="sidemenu-label">Customer</span>
                            <i class="angle fe fe-chevron-right"></i>
                        </a>
                        <ul class="nav-sub">
                            <li class="side-menu-label1"><a href="javascript:void(0)">Customer</a></li>

                            <li class="nav-sub-item"> <a class="nav-sub-link"
                                    href="{{ route('customer.index') }}">View
                                    All Customer</a></li>

                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link with-sub" href="javascript:void(0)">
                            <span class="shape1"></span>
                            <span class="shape2"></span>
                            <i class="ti-wallet sidemenu-icon menu-icon "></i>
                            <span class="sidemenu-label">Booking</span>
                            <i class="angle fe fe-chevron-right"></i>
                        </a>
                        <ul class="nav-sub">
                            <li class="side-menu-label1"><a href="javascript:void(0)">Ki Booking</a></li>

                            <li class="nav-sub-item"> <a class="nav-sub-link"
                                    href="{{ route('kibooking.index') }}">Ki Booking</a></li>
                              
                            <li class="nav-sub-item"> <a class="nav-sub-link"
                                    href="{{ route('kibooking_web') }}">Web Booking</a></li>
                                    
                            <li class="nav-sub-item"> <a class="nav-sub-link"
                                    href="{{ route('consultation-form.index') }}">Consultation Form</a></li>
                            <li class="nav-sub-item"> <a class="nav-sub-link"
                                    href="{{ route('consultation-refer') }}">Consultation Refer</a></li>
                            <li class="nav-sub-item"> <a class="nav-sub-link"
                                    href="{{ route('subscribed-form') }}">Subscribed Form</a></li>

                        </ul>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link with-sub" href="javascript:void(0)">
                            <span class="shape1"></span>
                            <span class="shape2"></span>
                            <i class="ti-wallet sidemenu-icon menu-icon "></i>
                            <span class="sidemenu-label">Order</span>
                            <i class="angle fe fe-chevron-right"></i>
                        </a>
                        <ul class="nav-sub">
                            <li class="side-menu-label1"><a href="javascript:void(0)">Order</a></li>

                            <li class="nav-sub-item"> <a class="nav-sub-link"
                                    href="{{ route('order.index') }}">Order</a></li>
                            

                        </ul>
                    </li>


                    @php
                        $menu_permissionarr = explode(',', @auth()->user()->menu_permission);
                    @endphp





                </ul>
                <div class="slide-right" id="slide-right"><i class="fe fe-chevron-right"></i></div>
            </div>
        </div>
    </div>
</div>
<!-- End Sidemenu -->
