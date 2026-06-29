
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
                                <img class="search-icon" src="{{ asset('frontend/images/search.svg') }}" alt=""> يبحث</a>
                        </li>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"
                                aria-expanded="true"><img src="{{ asset('frontend/images/icon-conditions.svg') }}" alt=""> شروط</a>
                            <ul class="dropdown-menu">
                                @foreach ($menudata['conditions'] as $item)
                                <li><a class="dropdown-item" href="{{ url($item->category_slug) }}" dir="rtl">{{ $item->category_name_ar }}</a></li>
                                @endforeach
                                <li><a class="dropdown-item" href="{{ url('allcondition') }}">عرض جميع الشروط</a></li>
                            </ul>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('blog') }}"><img src="{{ asset('frontend/images/blog.svg') }}" alt=""> مدونة</a>
                        </li>
                        <!--<li class="nav-item">
                            <a class="nav-link" href="#"><img src="{{ asset('frontend/images/location.svg') }}" class="location-icon" alt="">
                                Clinics</a>
                        </li>-->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('contact-us') }}"><img src="{{ asset('frontend/images/contact.svg') }}" class="contant-icon" alt="">
                                اتصال</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link offers" href="{{ url('offer') }}"> <i class="fa-solid fa-percent"></i>
                                <span>العروض</span></a>
                        </li>
                        
                        <li class="nav-item d-none">
                            <a class="nav-link d-flex align-items-center" href="{{ route('cart') }}" >
                                <span class="badge bg-primary me-2 px-2 py-1" ></span>
                                <span class="fa fa-shopping-cart me-1"></span> عربة التسوق</a>
                        </li>
                        @if (Auth::guard('customer')->check())
                        <li class="nav-item">
                            <a class="nav-link offers" href="{{ url('profile') }}"> <span class="fa fa-user"></span>
                                <span>حساب تعريفي</span></a>
                        </li>
                        @else
                        <li class="nav-item">
                            <a class="nav-link offers" href="{{ route('login') }}"> <span class="fa fa-user"></span>
                                <span>تسجيل الدخول</span></a>
                        </li>
                        @endif
                        <li class="ms-2">
                            <a href="{{ url('contact') }}" class="bigbtn primary-btn btn"> احجز استشارة مجانية</a>
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
                                استعادة الشعر
                            </a>
                            <ul class="dropdown-menu">
                                @foreach ($menudata['hair_restoration'] as $item)
                                <li><a class="dropdown-item" href="{{ url($item->category_slug) }}">{{ $item->category_name_ar }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="true">
                                إزالة الشعر بالليزر
                            </a>
                            <ul class="dropdown-menu">
                                @foreach ($menudata['laser_hair_removal'] as $item)
                                <li><a class="dropdown-item" href="{{ url($item->category_slug) }}">{{ $item->category_name_ar }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        
                        <li class="nav-item dropdown position-static">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="true">
                                إزالة الوشم
                            </a>
                            <div class="dropdown-menu w-100 ">
                                <div class="mega-menu">
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="#"><b>إزالة الوشم</b></a></li>
                                        @foreach ($menudata['tattoo_removal'] as $item)
                                        <li><a class="dropdown-item" href="{{ url($item->category_slug) }}">{{ $item->category_name_ar }}</a></li>
                                        @endforeach

                                    </ul>
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="#"><b>إزالة الوشم بالليزر بواسطة الجهاز</b></a></li>
                                        @foreach ($menudata['tattoo_removal_machine'] as $item)
                                        <li><a class="dropdown-item" href="{{ url($item->category_slug) }}">{{ $item->category_name_ar }}</a></li>
                                        @endforeach

                                    </ul>
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="#"><b>إزالة المكياج شبه الدائم</b></a></li>
                                        @foreach ($menudata['semi_tattoo_removal_machine'] as $item)
                                        <li><a class="dropdown-item" href="{{ url($item->category_slug) }}">{{ $item->category_name_ar }}</a></li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item dropdown position-static">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="true">
                                علاجات البشرة
                            </a>
                            <div class="dropdown-menu w-100 ">
                                <div class="mega-menu">
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="#"><b>علاجات البشرة</b></a></li>
                                        @foreach ($menudata['skin_treatments'] as $item)
                                        <li><a class="dropdown-item" href="{{ url($item->category_slug) }}">{{ $item->category_name_ar }}</a></li>
                                        @endforeach
                                        
                                    </ul>
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="#"><b>علاجات البشرة بالجهاز</b></a></li>
                                        @foreach ($menudata['skin_treatments_machine'] as $item)
                                        <li><a class="dropdown-item" href="{{ url($item->category_slug) }}">{{ $item->category_name_ar }}</a></li>
                                        @endforeach

                                    </ul>
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="#"><b>علاجات IPL</b></a></li>
                                        @foreach ($menudata['ipl_treatments'] as $item)
                                        <li><a class="dropdown-item" href="{{ url($item->category_slug) }}">{{ $item->category_name_ar }}</a></li>
                                        @endforeach

                                    </ul>
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="#"><b>الباقات المجمعة</b></a></li>
                                        @foreach ($menudata['skin_combination_packages'] as $item)
                                        <li><a class="dropdown-item" href="{{ url($item->category_slug) }}">{{ $item->category_name_ar }}</a></li>
                                        @endforeach
                                        
                                    </ul>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item dropdown position-static">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="true">
                                نحت الجسم
                            </a>
                            <div class="dropdown-menu w-100 ">
                                <div class="mega-menu">
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="#"><b>علاجات الجسم</b></a></li>
                                        @foreach ($menudata['body_treatments'] as $item)
                                        <li><a class="dropdown-item" href="{{ url($item->category_slug) }}">{{ $item->category_name_ar }}</a></li>
                                        @endforeach

                                    </ul>
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="#"><b>علاجات الجسم بالآلات</b></a></li>
                                        @foreach ($menudata['body_treatments_machines'] as $item)
                                        <li><a class="dropdown-item" href="{{ url($item->category_slug) }}">{{ $item->category_name_ar }}</a></li>
                                        @endforeach

                                    </ul>
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="#"><b>علاجات الجسم حسب المنطقة</b></a></li>
                                        @foreach ($menudata['body_treatments_area'] as $item)
                                        <li><a class="dropdown-item" href="{{ url($item->category_slug) }}">{{ $item->category_name_ar }}</a></li>
                                        @endforeach

                                    </ul>
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="#"><b>الباقات المجمعة</b></a></li>
                                        @foreach ($menudata['body_combination_packages'] as $item)
                                        <li><a class="dropdown-item" href="{{ url($item->category_slug) }}">{{ $item->category_name_ar }}</a></li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item dropdown position-static">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="true">
                                المواد الطبية والحقن
                            </a>
                            <div class="dropdown-menu w-100 ">
                                <div class="mega-menu">
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="#"><b>طبي</b></a></li>
                                        @foreach ($menudata['medical'] as $item)
                                        <li><a class="dropdown-item" href="{{ url($item->category_slug) }}">{{ $item->category_name_ar }}</a></li>
                                        @endforeach

                                    </ul>
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="#"><b>الحقن</b></a></li>
                                        @foreach ($menudata['injectables'] as $item)
                                        <li><a class="dropdown-item" href="{{ url($item->category_slug) }}">{{ $item->category_name_ar }}</a></li>
                                        @endforeach

                                    </ul>
                                    <!--<ul class="p-0">
                                        <li><a class="dropdown-item" href="#"><b>الفريق الطبي</b></a></li>
                                        @foreach ($menudata['medical_team'] as $item)
                                        <li><a class="dropdown-item" href="{{ url($item->category_slug) }}">{{ $item->category_name_ar }}</a></li>
                                        @endforeach


                                    </ul>-->

                                </div>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="true">
                                طب الأمراض الجلدية
                            </a>
                            <ul class="dropdown-menu">
                                @foreach ($menudata['dermatology'] as $item)
                                <li><a class="dropdown-item" href="{{ url($item->category_slug) }}">{{ $item->category_name_ar }}</a></li>
                                @endforeach

                            </ul>
                        </li>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="{{ url('shop') }}">
                                محل
                            </a>
                        </li>


                    </ul>
                </div>
            </div>
        </nav>

        <!-- mobile menu   -->
        <nav class="mobile-menu navbar navbar-expand-lg d-lg-none" style="margin-top:0px;padding-top: 0px;">
            <div class="container-fluid" style="background-color: #F2F7FC; padding: 5px;">
                <a href="https://wa.me/+442080040277?text=Can%20you%20please%20help%20with%20my%20enquiry?" target="_blank" ><i class="fab fa-whatsapp"> </i></a>
               <div>
                
                <a href="{{ url('contact-us') }}" style="font-size: 13px;"><i class="fas fa-map-marker-alt"> </i> Clinics </a> &nbsp;
                <a href="tel:02080040277" target="_blank" style="font-size: 13px;"><i class="fas fa-phone"> </i> Call</a>
                
                
               </div>
                
            </div>
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('frontend/images/logo-plc.jpeg') }}" alt="">
                </a>
               <div>
               
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
                                        <input class="form-control me-2" type="search" placeholder="يبحث" aria-label="Search" name="searchbox" id="searchbox">
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
                                        <span>شروط</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                                <ul class="submenu">
                                    @foreach ($menudata['conditions'] as $item)
                                    <li><a href="{{ url($item->category_slug) }}">{{ $item->category_name_ar }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link laser-hair-removal" href="javascript:void(0);">
                                    <div>
                                        <img class="mobile-icon" src="{{ asset('frontend/images/icon-laser-hair-removal.svg') }}" alt="">
                                        <span>إزالة الشعر بالليزر</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                                <ul class="submenu">
                                    @foreach ($menudata['laser_hair_removal'] as $item)
                                    <li><a href="{{ url($item->category_slug) }}">{{ $item->category_name_ar }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link laser-hair-removal" href="javascript:void(0);">
                                    <div>
                                        <img class="mobile-icon" src="{{ asset('frontend/images/icon-skin-treatments.svg') }}" alt="">
                                        <span>علاجات البشرة</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                                <ul class="submenu">
                                    @foreach ($menudata['skin_treatments'] as $item)
                                    <li><a href="{{ url($item->category_slug) }}">{{ $item->category_name_ar }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link laser-hair-removal" href="javascript:void(0);">
                                    <div>
                                        <img class="mobile-icon" src="{{ asset('frontend/images/icon-body-sculpting.svg') }}" alt="">
                                        <span>نحت الجسم</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                                <ul class="submenu">
                                    @foreach ($menudata['body_sculpting'] as $item)
                                    <li><a href="{{ url($item->category_slug) }}">{{ $item->category_name_ar }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link laser-hair-removal" href="javascript:void(0);">
                                    <div>
                                        <img class="mobile-icon" src="{{ asset('frontend/images/icon-dermatology.svg') }}" alt="">
                                        <span>طب الأمراض الجلدية</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                                <ul class="submenu">
                                    @foreach ($menudata['dermatology'] as $item)
                                    <li><a href="{{ url($item->category_slug) }}">{{ $item->category_name_ar }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link laser-hair-removal" href="javascript:void(0);">
                                    <div>
                                        <img class="mobile-icon" src="{{ asset('frontend/images/icon-medical.svg') }}" alt="">
                                        <span>المواد الطبية والحقن</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                                <ul class="submenu">
                                    @foreach ($menudata['medical_injectables'] as $item)
                                    <li><a href="{{ url($item->category_slug) }}">{{ $item->category_name_ar }}</a></li>
                                    @endforeach
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('allservice/laser-tattoo-removal') }}">
                                    <div>
                                        <img class="mobile-icon" src="{{ asset('frontend/images/icon-body-sculpting.svg') }}" alt="">
                                        <span>إزالة الوشم</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('shop') }}">
                                    <div>
                                        <img class="mobile-icon" src="{{ asset('frontend/images/icon-tattoo-removal.svg') }}" alt="">
                                        <span>محل</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('contact') }}">
                                    <div>
                                        <img class="mobile-icon" src="{{ asset('frontend/images/contact.svg') }}" alt="">
                                        <span>اتصال</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('allservices') }}">
                                    <div>
                                        <img class="mobile-icon" src="{{ asset('frontend/images/contact.svg') }}" alt="">
                                        <span>خدمات</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </li>
                            
                            @if (Auth::guard('customer')->check())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('profile') }}">
                                    <div>
                                        <span class="fa fa-user" style="font-size: 28px;"></span>
                                        <span>حساب تعريفي</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </li>
                            @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    <div>
                                        <span class="fa fa-user" style="font-size: 28px;"></span>
                                        <span>تسجيل الدخول</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </li>
                            @endif
                           
                        </ul>

                        <div class="header-bottom-box">
                            <a href="{{ url('contact') }}" class="bigbtn primary-btn btn w-100">احجز استشارة مجانية</a>
                            <div class="header-bottom">
                                <ul>
                                    <li><a href="{{ url('blog') }}">مدونة</a></li>
                                    <li><span>|</span></li>
                                    <li><a href="{{ url('offer') }}">العروض</a></li>
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
    