<header>
        <!-- laptop header menu  -->
        <nav class="navbar navbar-expand-lg top-header d-lg-block d-none fullscreen-desktop fullscreen-desktopdef">
            <div class="container-fluid">
                <div class="language-box">
                    <img class="language-icon" src="{{ asset('frontend/images/earth.svg') }}" alt="">
                    <a class="navbar-brand m-0" href="#">
                        中文
                    </a>
                    <span>|</span>
                    <a class="navbar-brand m-0" href="#">
                        عربى
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="search.html">
                                <img class="search-icon" src="{{ asset('frontend/images/search.svg') }}" alt=""> Search</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"
                                aria-expanded="true"><img src="{{ asset('frontend/images/icon-conditions.svg') }}" alt=""> Conditions</a>
                            <ul class="dropdown-menu">
                                @foreach ($menudata['laser_hair_removal'] as $item)
                                <li><a class="dropdown-item" href="{{ url('allservice/' . $item->category_slug) }}">{{ $item->category_name }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('blog') }}"><img src="{{ asset('frontend/images/blog.svg') }}" alt=""> Blog</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><img src="{{ asset('frontend/images/location.svg') }}" class="location-icon" alt="">
                                Clinics</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('contact') }}"><img src="{{ asset('frontend/images/contact.svg') }}" class="contant-icon" alt="">
                                Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link offers" href="#"> <i class="fa-solid fa-percent"></i>
                                <span>Offers</span></a>
                        </li>
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

                        <li class="nav-item dropdown position-static">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="true">
                                Tattoo Removal
                            </a>
                            <div class="dropdown-menu w-100 ">
                                <div class="mega-menu">
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="#"><b>Laser Hair Removal London</b></a></li>
                                        @foreach ($menudata['tattoo_removal'] as $item)
                                        <li><a class="dropdown-item" href="{{ url('allservice/' . $item->category_slug) }}">{{ $item->category_name }}</a></li>
                                        @endforeach

                                    </ul>
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="#"><b>Laser Hair Removal London</b></a></li>
                                        @foreach ($menudata['tattoo_removal_machine'] as $item)
                                        <li><a class="dropdown-item" href="{{ url('allservice/' . $item->category_slug) }}">{{ $item->category_name }}</a></li>
                                        @endforeach

                                    </ul>
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="#"><b>Laser Hair Removal London</b></a></li>
                                        @foreach ($menudata['semi_tattoo_removal_machine'] as $item)
                                        <li><a class="dropdown-item" href="{{ url('allservice/' . $item->category_slug) }}">{{ $item->category_name }}</a></li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item dropdown position-static">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="true">
                                Skin Treatments
                            </a>
                            <div class="dropdown-menu w-100 ">
                                <div class="mega-menu">
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="#"><b>Skin Treatments</b></a></li>
                                        @foreach ($menudata['skin_treatments'] as $item)
                                        <li><a class="dropdown-item" href="{{ url('allservice/' . $item->category_slug) }}">{{ $item->category_name }}</a></li>
                                        @endforeach
                                        
                                    </ul>
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="#"><b>Skin Treatments By Machine</b></a></li>
                                        @foreach ($menudata['skin_treatments_machine'] as $item)
                                        <li><a class="dropdown-item" href="{{ url('allservice/' . $item->category_slug) }}">{{ $item->category_name }}</a></li>
                                        @endforeach

                                    </ul>
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="#"><b>IPL Treatments</b></a></li>
                                        @foreach ($menudata['ipl_treatments'] as $item)
                                        <li><a class="dropdown-item" href="{{ url('allservice/' . $item->category_slug) }}">{{ $item->category_name }}</a></li>
                                        @endforeach

                                    </ul>
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="#"><b>Combination Packages</b></a></li>
                                        @foreach ($menudata['skin_combination_packages'] as $item)
                                        <li><a class="dropdown-item" href="{{ url('allservice/' . $item->category_slug) }}">{{ $item->category_name }}</a></li>
                                        @endforeach
                                        
                                    </ul>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item dropdown position-static">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="true">
                                Body Sculpting
                            </a>
                            <div class="dropdown-menu w-100 ">
                                <div class="mega-menu">
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="#"><b>Body Treatments</b></a></li>
                                        @foreach ($menudata['body_treatments'] as $item)
                                        <li><a class="dropdown-item" href="{{ url('allservice/' . $item->category_slug) }}">{{ $item->category_name }}</a></li>
                                        @endforeach

                                    </ul>
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="#"><b>Body Treatments by Machines</b></a></li>
                                        @foreach ($menudata['body_treatments_machines'] as $item)
                                        <li><a class="dropdown-item" href="{{ url('allservice/' . $item->category_slug) }}">{{ $item->category_name }}</a></li>
                                        @endforeach

                                    </ul>
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="#"><b>Body Treatments by Area</b></a></li>
                                        @foreach ($menudata['body_treatments_area'] as $item)
                                        <li><a class="dropdown-item" href="{{ url('allservice/' . $item->category_slug) }}">{{ $item->category_name }}</a></li>
                                        @endforeach

                                    </ul>
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="#"><b>Combination Packages</b></a></li>
                                        @foreach ($menudata['body_combination_packages'] as $item)
                                        <li><a class="dropdown-item" href="{{ url('allservice/' . $item->category_slug) }}">{{ $item->category_name }}</a></li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item dropdown position-static">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="true">
                                Medical & Injectables
                            </a>
                            <div class="dropdown-menu w-100 ">
                                <div class="mega-menu">
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="#"><b>Medical</b></a></li>
                                        @foreach ($menudata['medical'] as $item)
                                        <li><a class="dropdown-item" href="{{ url('allservice/' . $item->category_slug) }}">{{ $item->category_name }}</a></li>
                                        @endforeach

                                    </ul>
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="#"><b>Injectables</b></a></li>
                                        @foreach ($menudata['injectables'] as $item)
                                        <li><a class="dropdown-item" href="{{ url('allservice/' . $item->category_slug) }}">{{ $item->category_name }}</a></li>
                                        @endforeach

                                    </ul>
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="#"><b>The Medical Team</b></a></li>
                                        @foreach ($menudata['medical_team'] as $item)
                                        <li><a class="dropdown-item" href="{{ url('allservice/' . $item->category_slug) }}">{{ $item->category_name }}</a></li>
                                        @endforeach


                                    </ul>

                                </div>
                            </div>
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
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="fullheight collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="p-0">
                        <li class="nav-item">
                            <div class="nav-link  border-0">
                                <div>
                                    <form class="d-flex searchbar position-relative" role="search">
                                        <input class="form-control me-2" type="search" placeholder="Search"
                                            aria-label="Search">
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
                                <a class="nav-link" href="#">
                                    <div>
                                        <img class="mobile-icon" src="{{ asset('frontend/images/icon-laser-hair-removal.svg') }}" alt="">
                                        <span>Laser Hair Removal</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <div>
                                        <img class="mobile-icon" src="{{ asset('frontend/images/icon-tattoo-removal.svg') }}" alt="">
                                        <span>Tattoo Removal</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <div>
                                        <img class="mobile-icon" src="{{ asset('frontend/images/icon-skin-treatments.svg') }}" alt="">
                                        <span>Skin Treatments</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <div>
                                        <img class="mobile-icon" src="{{ asset('frontend/images/icon-body-sculpting.svg') }}" alt="">
                                        <span>Body Sculpting</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <div>
                                        <img class="mobile-icon" src="{{ asset('frontend/images/icon-medical.svg') }}" alt="">
                                        <span>Medical & Injectables</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <div>
                                        <img class="mobile-icon" src="{{ asset('frontend/images/icon-dermatology.svg') }}" alt="">
                                        <span>Dermatology</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <div>
                                        <span>Conditions</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <div>
                                        <span>Prices</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('contact') }}">
                                    <div>
                                        <span>Contact Us</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </li>


                        </ul>

                        <div class="header-bottom-box">
                            <a href="{{ url('contact') }}" class="bigbtn primary-btn btn w-100"> Book Free Consultation</a>
                            <div class="header-bottom">
                                <ul>
                                    <li><a href="#">Blog</a></li>
                                    <li><span>|</span></li>
                                    <li><a href="#">Media</a></li>
                                    <li><span>|</span></li>
                                    <li><a href="#">Newsletter</a></li>
                                </ul>
                            </div>
                            <div class="social-icon">
                                <ul>
                                    <li>
                                        <a href="#" class="icon-so facebook"><img src="{{ asset('frontend/images/facebook.png') }}" alt=""></a>
                                    </li>
                                    <li>
                                        <a href="#" class="icon-so x-icon"><img src="{{ asset('frontend/images/icon-sprites-x.png') }}"
                                                alt=""></a>
                                    </li>
                                    <li>
                                        <a href="#" class="icon-so youtube-i"><img src="{{ asset('frontend/images/icon-sprites-you.png') }}"
                                                alt=""></a>
                                    </li>
                                    <!-- <li>
                                    <a href="#" class="icon-so google"><img src="{{ asset('frontend/images/google.png') }}" alt=""></a>
                                </li> -->
                                    <li>
                                        <a href="#" class="icon-so insata"><img src="{{ asset('frontend/images/insata.png') }}" alt=""></a>
                                    </li>


                                    <li>
                                        <a href="#" class="icon-so tiktok"><img src="{{ asset('frontend/images/icon-sprites-tik.png') }}"
                                                alt=""></a>
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
    