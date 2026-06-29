
<?php
use App\Models\CheckedService;

$productsystems = CheckedService::with('getCheckedAddon') // Assuming the relationship is correctly defined
    ->where('system_id', session('uuid'))
    ->where('stype', 'product')
    ->count();
?>

<header>
        <!-- laptop header menu  -->
        <nav class="navbar navbar-expand-lg top-header d-lg-block d-none fullscreen-desktop fullscreen-desktopdef">
            <div class="container-fluid">
                <div class="language-box">
                    <img class="language-icon" src="{{ asset('frontend/images/earth.svg') }}" alt="" onclick="changeLanguage('en');">
                    <a class="navbar-brand m-0" href="javascript:void(0);" onclick="changeLanguage('cn');">
                        اردو
                    </a>
                    <span>|</span>
                    <a class="navbar-brand m-0" href="javascript:void(0);" onclick="changeLanguage('ar');">
                        عربى
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#searchModal">
                                <img class="search-icon" src="{{ asset('frontend/images/search.svg') }}" alt=""> Search</a>
                        </li>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"
                                aria-expanded="true"><img src="{{ asset('frontend/images/icon-conditions.svg') }}" alt=""> Conditions</a>
                            <ul class="dropdown-menu">
                                @foreach ($menudata['conditions'] as $item)
                                <li><a class="dropdown-item" href="{{ url('allservice/' . $item->category_slug) }}">{{ $item->category_name }}</a></li>
                                @endforeach
                                <li><a class="dropdown-item" href="{{ url('allcondition') }}">View All Conditions</a></li>
                            </ul>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('blog') }}"><img src="{{ asset('frontend/images/blog.svg') }}" alt=""> Blog</a>
                        </li>
                        <!--<li class="nav-item">
                            <a class="nav-link" href="#"><img src="{{ asset('frontend/images/location.svg') }}" class="location-icon" alt="">
                                Clinics</a>
                        </li>-->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('contact') }}"><img src="{{ asset('frontend/images/contact.svg') }}" class="contant-icon" alt="">
                                Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link offers" href="{{ url('offer') }}"> <i class="fa-solid fa-percent"></i>
                                <span>Offers</span></a>
                        </li>
                        
                        <li class="nav-item d-none">
                            <a class="nav-link d-flex align-items-center" href="{{ route('cart') }}" >
                                <span class="badge bg-primary me-2 px-2 py-1" ></span>
                                <span class="fa fa-shopping-cart me-1"></span> Cart</a>
                        </li>
                        @if (Auth::guard('customer')->check())
                        <li class="nav-item">
                            <a class="nav-link offers" href="{{ url('profile') }}"> <span class="fa fa-user"></span>
                                <span>Profile</span></a>
                        </li>
                        @else
                        <li class="nav-item">
                            <a class="nav-link offers" href="{{ route('login') }}"> <span class="fa fa-user"></span>
                                <span>Login</span></a>
                        </li>
                        @endif
                        <li class="ms-2">
                            <a href="{{ url('contact') }}" class="bigbtn primary-btn btn"> Book Free Consultation</a>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
        <nav class="navbar navbar-expand-lg d-lg-block d-none fullscreen-desktop fullscreen-desktopabc">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('frontend/images/logo-plc.jpeg') }}" alt="">
                </a>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="true">
                                Laser Hair Removal
                            </a>
                            <ul class="dropdown-menu">
                                @foreach ($menudata['laser_hair_removal'] as $item)
                                <li><a class="dropdown-item" href="{{ url('allservice/' . $item->category_slug) }}">{{ $item->category_name }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="true">
                                Skin Treatments
                            </a>
                            <ul class="dropdown-menu">
                                @foreach ($menudata['skin_treatments'] as $item)
                                <li><a class="dropdown-item" href="{{ url('allservice/' . $item->category_slug) }}">{{ $item->category_name }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="true">
                                Body Sculpting
                            </a>
                            <ul class="dropdown-menu">
                                @foreach ($menudata['body_sculpting'] as $item)
                                <li><a class="dropdown-item" href="{{ url('allservice/' . $item->category_slug) }}">{{ $item->category_name }}</a></li>
                                @endforeach
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="true">
                                Dermatology
                            </a>
                            <ul class="dropdown-menu">
                                @foreach ($menudata['dermatology'] as $item)
                                <li><a class="dropdown-item" href="{{ url('allservice/' . $item->category_slug) }}">{{ $item->category_name }}</a></li>
                                @endforeach

                            </ul>
                        </li>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="true">
                                Medical & Injectables
                            </a>
                            <ul class="dropdown-menu">
                                @foreach ($menudata['medical_injectables'] as $item)
                                <li><a class="dropdown-item" href="{{ url('allservice/' . $item->category_slug) }}">{{ $item->category_name }}</a></li>
                                @endforeach
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link" href="{{ url('allservice/laser-tattoo-removal') }}">
                                Tattoo Removal
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="{{ url('shop') }}">
                                Shop
                            </a>
                        </li>


                    </ul>
                </div>
            </div>
        </nav>

        <!-- mobile menu  -->
        <nav class="mobile-menu navbar navbar-expand-lg d-lg-none">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('frontend/images/logo-plc.jpeg') }}" alt="">
                </a>
               <div>
                <!--<a href="{{ url('cart') }}" class="mobile-cart-icon"><i class="fa-solid fa-cart-shopping"> </i><span>{{ $productsystems }}</span> </a>
                @if (Auth::guard('customer')->check())
                <a href="{{ url('profile') }}" class="mobile-user-login"><i class="fa-solid fa-user"></i></a>
                @else
                <a href="{{ route('login') }}" class="mobile-user-login"><i class="fa-solid fa-user"></i></a>
                @endif-->
               
                <img class="language-icon" src="{{ asset('frontend/images/earth.svg') }}" alt="" onclick="changeLanguage('en');">
                <a class="navbar-brand m-0" href="javascript:void(0);" onclick="changeLanguage('cn');">
                    اردو
                </a>
                <span>|</span>
                <a class="navbar-brand m-0" href="javascript:void(0);" onclick="changeLanguage('ar');">
                    عربى
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
               </div>
                <div class="fullheight collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="p-0">
                        <li class="nav-item">
                            <div class="nav-link  border-0">
                                <div>
                                    <form class="d-flex searchbar position-relative" role="search" action="{{ url('homesearchbox') }}" method="post">
                                        @csrf
                                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="searchbox" id="searchbox">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </form>
                                </div>
                                <a href="javascript:void(0)" class="navbar-toggler close-menu" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                                    aria-controls="navbarNavDropdown" aria-expanded="false"
                                    aria-label="Toggle navigation"><i class="fa-solid fa-xmark"></i></a>
                            </div>
                        </li>
                    </ul>
                    <div class="position-relative box-social">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link laser-hair-removal" href="javascript:void(0);">
                                    <div>
                                        <img class="mobile-icon" src="{{ asset('frontend/images/icon-conditions.svg') }}" alt="">
                                        <span>Conditions</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                                <ul class="submenu">
                                    @foreach ($menudata['conditions'] as $item)
                                    <li><a href="{{ url('allservice/' . $item->category_slug) }}">{{ $item->category_name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link laser-hair-removal" href="javascript:void(0);">
                                    <div>
                                        <img class="mobile-icon" src="{{ asset('frontend/images/icon-laser-hair-removal.svg') }}" alt="">
                                        <span>Laser Hair Removal</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                                <ul class="submenu">
                                    @foreach ($menudata['laser_hair_removal'] as $item)
                                    <li><a href="{{ url('allservice/' . $item->category_slug) }}">{{ $item->category_name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link laser-hair-removal" href="javascript:void(0);">
                                    <div>
                                        <img class="mobile-icon" src="{{ asset('frontend/images/icon-skin-treatments.svg') }}" alt="">
                                        <span>Skin Treatments</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                                <ul class="submenu">
                                    @foreach ($menudata['skin_treatments'] as $item)
                                    <li><a href="{{ url('allservice/' . $item->category_slug) }}">{{ $item->category_name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link laser-hair-removal" href="javascript:void(0);">
                                    <div>
                                        <img class="mobile-icon" src="{{ asset('frontend/images/icon-body-sculpting.svg') }}" alt="">
                                        <span>Body Sculpting</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                                <ul class="submenu">
                                    @foreach ($menudata['body_sculpting'] as $item)
                                    <li><a href="{{ url('allservice/' . $item->category_slug) }}">{{ $item->category_name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link laser-hair-removal" href="javascript:void(0);">
                                    <div>
                                        <img class="mobile-icon" src="{{ asset('frontend/images/icon-dermatology.svg') }}" alt="">
                                        <span>Dermatology</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                                <ul class="submenu">
                                    @foreach ($menudata['dermatology'] as $item)
                                    <li><a href="{{ url('allservice/' . $item->category_slug) }}">{{ $item->category_name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link laser-hair-removal" href="javascript:void(0);">
                                    <div>
                                        <img class="mobile-icon" src="{{ asset('frontend/images/icon-medical.svg') }}" alt="">
                                        <span>Medical & Injectables</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                                <ul class="submenu">
                                    @foreach ($menudata['medical_injectables'] as $item)
                                    <li><a href="{{ url('allservice/' . $item->category_slug) }}">{{ $item->category_name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('allservice/laser-tattoo-removal') }}">
                                    <div>
                                        <img class="mobile-icon" src="{{ asset('frontend/images/icon-body-sculpting.svg') }}" alt="">
                                        <span>Tattoo Removal</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('shop') }}">
                                    <div>
                                        <img class="mobile-icon" src="{{ asset('frontend/images/icon-tattoo-removal.svg') }}" alt="">
                                        <span>Shop</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('contact') }}">
                                    <div>
                                        <img class="mobile-icon" src="{{ asset('frontend/images/contact.svg') }}" alt="">
                                        <span>Contact</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </li>
                            
                            @if (Auth::guard('customer')->check())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('profile') }}">
                                    <div>
                                        <span class="fa fa-user" style="font-size: 28px;"></span>
                                        <span>Profile</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </li>
                            @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    <div>
                                        <span class="fa fa-user" style="font-size: 28px;"></span>
                                        <span>Login</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </li>
                            @endif
                           
                        </ul>

                        <div class="header-bottom-box">
                            <a href="{{ url('contact') }}" class="bigbtn primary-btn btn w-100"> Book Free Consultation</a>
                            <div class="header-bottom">
                                <ul>
                                    <li><a href="{{ url('blog') }}">Blog</a></li>
                                    <li><span>|</span></li>
                                    <li><a href="{{ url('offer') }}">Offers</a></li>
                                </ul>
                            </div>
                            <div class="social-icon">
                                <ul>
                                    <li>
                                        <a href="https://www.facebook.com/diamondskinuk/" class="icon-so facebook"><img src="{{ asset('frontend/images/facebook.png') }}" alt=""></a>
                                    </li>
                                    <li>
                                        <a href="https://www.youtube.com/@dslclinicuk" class="icon-so youtube-i"><img src="{{ asset('frontend/images/icon-sprites-you.png') }}" alt=""></a>
                                    </li>
                                    <li>
                                        <a href="https://www.instagram.com/diamondskin.uk/" class="icon-so insata"><img src="{{ asset('frontend/images/insata.png') }}" alt=""></a>
                                    </li>

                                    <li>
                                        <a href="#" class="icon-so x-icon"><img src="{{ asset('frontend/images/icon-sprites-x.png') }}" alt=""></a>
                                    </li>
                                    <li>
                                        <a href="#" class="icon-so tiktok"><img src="{{ asset('frontend/images/icon-sprites-tik.png') }}" alt=""></a>
                                    </li>
                                    <li>
                                        <a href="#" class="icon-so"><img src="{{ asset('frontend/images/threads-blue.svg') }}" alt=""></a>
                                    </li>
                                    <li>
                                        <a href="#" class="icon-so"><img src="{{ asset('frontend/images/pinterest-blue.svg') }}" alt=""></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    
    

    
<section class="header-top-height"></section>
    