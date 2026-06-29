<!-- Font Awesome 6 CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" />

<!-- Google tag (gtag.js) --> <script async src="https://www.googletagmanager.com/gtag/js?id=G-L3HWB8RWLL"></script> <script>   window.dataLayer = window.dataLayer || [];   function gtag(){dataLayer.push(arguments);}   gtag('js', new Date());   gtag('config', 'G-L3HWB8RWLL'); </script>

<?php
use App\Models\CheckedService;

$productsystems = CheckedService::with('getCheckedAddon') // Assuming the relationship is correctly defined
    ->where('system_id', session('uuid'))
    ->where('stype', 'product')
    ->count();
?>



<?php 
if(session('app_locale')=='cn'){
    $category_name = 'category_name_cn';
    
    $Search = 'تلاش کریں۔';
    $Conditions = 'شرائط';
    $View_All_Conditions = 'تمام شرائط دیکھیں';
    $Blog = 'بلاگ';
    $Contact = 'رابطہ کریں۔';
    $Offers = 'پیشکش کرتا ہے۔';
    $Cart = 'ٹوکری';
    $Profile = 'پروفائل';
    $Login = 'لاگ ان';
    $Book_Free_Consultation = 'کتاب مفت مشاورت';
    $Hair_Restoration = 'بالوں کی بحالی';
    $Laser_Hair_Removal = 'لیزر سے بالوں کو ہٹانا';
    $Tattoo_Removal = 'ٹیٹو ہٹانا';
    $Laser_Tattoo_Removal_By_Machine = 'مشین کے ذریعے لیزر ٹیٹو ہٹانا';
    $Semi_Permanent_Makeup_Removal = 'نیم مستقل میک اپ ہٹانا';
    $Skin_Treatments = 'جلد کا علاج';
    $Skin_Treatments_By_Machine = 'مشین کے ذریعے جلد کا علاج';
    $IPL_Treatments = 'آئی پی ایل کے علاج';
    $Combination_Packages = 'امتزاج پیکجز';
    $Body_Sculpting = 'باڈی سکلپٹنگ';
    $Body_Treatments = 'جسمانی علاج';
    $Body_Treatments_by_Machines = 'مشینوں کے ذریعے جسمانی علاج';
    $Body_Treatments_by_Area = 'علاقے کے لحاظ سے جسمانی علاج';
    $Medical_Injectables = 'میڈیکل اور انجیکشن ایبلز';
    $Medical = 'میڈیکل';
    $Injectables = 'انجیکشن ایبلز';
    $Dermatology = 'ڈرمیٹولوجی';
    $Shop = 'دکان';
    $Clinics = 'کلینکس';
    $Call = 'کال کریں۔';
    $Offers = 'پیشکش کرتا ہے۔';
    $Contact = 'رابطہ کریں۔';
    $Services = 'خدمات';
    $Profile = 'پروفائل';
    $Login = 'لاگ ان';
    $The_Medical_Team = 'ڈی ایس ایل کلینک ٹیم';
    
}elseif(session('app_locale')=='ar'){
    $category_name = 'category_name_ar';
    
    $Search = 'يبحث';
    $Conditions = 'شروط';
    $View_All_Conditions = 'عرض جميع الشروط';
    $Blog = 'مدونة';
    $Contact = 'اتصال';
    $Offers = 'العروض';
    $Cart = 'عربة التسوق';
    $Profile = 'حساب تعريفي';
    $Login = 'تسجيل الدخول';
    $Book_Free_Consultation = 'احجز استشارة مجانية';
    $Hair_Restoration = 'استعادة الشعر';
    $Laser_Hair_Removal = 'إزالة الشعر بالليزر';
    $Tattoo_Removal = 'إزالة الوشم';
    $Laser_Tattoo_Removal_By_Machine = 'إزالة الوشم بالليزر بواسطة الجهاز';
    $Semi_Permanent_Makeup_Removal = 'إزالة المكياج شبه الدائم';
    $Skin_Treatments = 'علاجات البشرة';
    $Skin_Treatments_By_Machine = 'علاجات البشرة بالجهاز';
    $IPL_Treatments = 'علاجات IPL';
    $Combination_Packages = 'الباقات المجمعة';
    $Body_Sculpting = 'نحت الجسم';
    $Body_Treatments = 'علاجات الجسم';
    $Body_Treatments_by_Machines = 'علاجات الجسم بالآلات';
    $Body_Treatments_by_Area = 'علاجات الجسم حسب المنطقة';
    $Medical_Injectables = 'المواد الطبية والحقن';
    $Medical = 'طبي';
    $Injectables = 'الحقن';
    $Dermatology = 'طب الأمراض الجلدية';
    $Shop = 'محل';
    $Clinics = 'العيادات';
    $Call = 'يتصل';
    $Offers = 'العروض';
    $Contact = 'اتصال';
    $Services = 'خدمات';
    $Profile = 'حساب تعريفي';
    $Login = 'تسجيل الدخول';
    $The_Medical_Team = 'فريق عيادة دي إس إل';
    
}else{
    
    $category_name = 'category_name';
    
    $Search = 'Search';
    $Conditions = 'Conditions';
    $View_All_Conditions = 'View All Conditions';
    $Blog = 'Blog';
    $Contact = 'Contact';
    $Offers = 'Offers';
    $Cart = 'Cart';
    $Profile = 'Profile';
    $Login = 'Login';
    $Book_Free_Consultation = 'Book Free Consultation';
    $Hair_Restoration = 'Hair Restoration';
    $Laser_Hair_Removal = 'Laser Hair Removal';
    $Tattoo_Removal = 'Tattoo Removal';
    $Laser_Tattoo_Removal_By_Machine = 'Laser Tattoo Removal By Machine';
    $Semi_Permanent_Makeup_Removal = 'Semi Permanent Makeup Removal';
    $Skin_Treatments = 'Skin Treatments';
    $Skin_Treatments_By_Machine = 'Skin Treatments By Machine';
    $IPL_Treatments = 'IPL Treatments';
    $Combination_Packages = 'Combination Packages';
    $Body_Sculpting = 'Body Sculpting';
    $Body_Treatments = 'Body Treatments';
    $Body_Treatments_by_Machines = 'Body Treatments by Machines';
    $Body_Treatments_by_Area = 'Body Treatments by Area';
    $Medical_Injectables = 'Medical & Injectables';
    $Medical = 'Medical';
    $Injectables = 'Injectables';
    $Dermatology = 'Dermatology';
    $Shop = 'Shop';
    $Clinics = 'Clinics';
    $Call = 'Call';
    $Offers = 'Offers';
    $Contact = 'Contact';
    $Services = 'Services';
    $Profile = 'Profile';
    $Login = 'Login';
    $The_Medical_Team = 'DSL Clinic Team';
    
}
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
                                <img class="search-icon" src="{{ asset('frontend/images/search.svg') }}" alt=""> {{ $Search }}</a>
                        </li>
                        
                        <li class="nav-item dropdown">
                        
                            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"
                                aria-expanded="true"><img src="{{ asset('frontend/images/icon-conditions.svg') }}" alt=""> {{ $Conditions }}</a>
                            <ul class="dropdown-menu">
                                @foreach ($menudata['conditions'] as $item)
                                <li><a class="dropdown-item" href="{{ url($item->category_slug) }}">{{ \Illuminate\Support\Str::limit($item->$category_name, 45) }}</a></li>
                                @endforeach
                                <li><a class="dropdown-item" href="{{ url('allcondition') }}">{{ $View_All_Conditions }}</a></li>
                            </ul>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('blog') }}"><img src="{{ asset('frontend/images/blog.svg') }}" alt=""> {{ $Blog }}</a>
                        </li>
                        <!--<li class="nav-item">
                            <a class="nav-link" href="javascript:void(0)"><img src="{{ asset('frontend/images/location.svg') }}" class="location-icon" alt="">
                                Clinics</a>
                        </li>-->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('contact-us') }}"><img src="{{ asset('frontend/images/contact.svg') }}" class="contant-icon" alt="">
                                {{ $Contact }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link offers" href="{{ url('offer') }}"> <i class="fa-solid fa-percent"></i>
                                <span>{{ $Offers }}</span></a>
                        </li>
                        
                        <li class="nav-item d-none">
                            <a class="nav-link d-flex align-items-center" href="{{ route('cart') }}" >
                                <span class="badge bg-primary me-2 px-2 py-1" ></span>
                                <span class="fa fa-shopping-cart me-1"></span> {{ $Cart }}</a>
                        </li>
                        @if (Auth::guard('customer')->check())
                        <li class="nav-item">
                            <a class="nav-link offers" href="{{ url('profile') }}"> <span class="fa fa-user"></span>
                                <span>{{ $Profile }}</span></a>
                        </li>
                        @else
                        <li class="nav-item">
                            <a class="nav-link offers" href="{{ route('login') }}"> <span class="fa fa-user"></span>
                                <span>{{ $Login }}</span></a>
                        </li>
                        @endif
                        <li class="ms-2">
                            <a href="{{ url('book-free-consultation') }}" class="bigbtn primary-btn btn"> {{ $Book_Free_Consultation }}</a>
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
                            <a class="nav-link dropdown-toggle" href="javascript:void(0)" role="button" data-bs-toggle="dropdown"
                                aria-expanded="true">
                                {{ $Hair_Restoration }}
                            </a>
                            <ul class="dropdown-menu">
                                @foreach ($menudata['hair_restoration'] as $item)
                                <li><a class="dropdown-item" href="{{ url($item->category_slug) }}">{{ \Illuminate\Support\Str::limit($item->$category_name, 45) }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0)" role="button" data-bs-toggle="dropdown"
                                aria-expanded="true">
                                {{ $Laser_Hair_Removal }}
                            </a>
                            <ul class="dropdown-menu">
                                @foreach ($menudata['laser_hair_removal'] as $item)
                                <li><a class="dropdown-item" href="{{ url($item->category_slug) }}">{{ \Illuminate\Support\Str::limit($item->$category_name, 45) }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        
                        <li class="nav-item dropdown position-static">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0)" role="button" data-bs-toggle="dropdown"
                                aria-expanded="true">
                                {{ $Tattoo_Removal }}
                            </a>
                            <div class="dropdown-menu w-100 ">
                                <div class="mega-menu">
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="javascript:void(0)"><b>{{ $Tattoo_Removal }}</b></a></li>
                                        @foreach ($menudata['tattoo_removal'] as $item)
                                        <li><a class="dropdown-item" href="{{ url($item->category_slug) }}">{{ \Illuminate\Support\Str::limit($item->$category_name, 45) }}</a></li>
                                        @endforeach

                                    </ul>
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="javascript:void(0)"><b>{{ $Laser_Tattoo_Removal_By_Machine }}</b></a></li>
                                        @foreach ($menudata['tattoo_removal_machine'] as $item)
                                        <li><a class="dropdown-item" href="{{ url($item->category_slug) }}">{{ \Illuminate\Support\Str::limit($item->$category_name, 45) }}</a></li>
                                        @endforeach

                                    </ul>
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="javascript:void(0)"><b>{{ $Semi_Permanent_Makeup_Removal }}</b></a></li>
                                        @foreach ($menudata['semi_tattoo_removal_machine'] as $item)
                                        <li><a class="dropdown-item" href="{{ url($item->category_slug) }}">{{ \Illuminate\Support\Str::limit($item->$category_name, 45) }}</a></li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item dropdown position-static">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0)" role="button" data-bs-toggle="dropdown"
                                aria-expanded="true">
                                {{ $Skin_Treatments }}
                            </a>
                            <div class="dropdown-menu w-100 ">
                                <div class="mega-menu">
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="javascript:void(0)"><b>{{ $Skin_Treatments }}</b></a></li>
                                        @foreach ($menudata['skin_treatments'] as $item)
                                        <li><a class="dropdown-item" href="{{ url($item->category_slug) }}">{{ \Illuminate\Support\Str::limit($item->$category_name, 45) }}</a></li>
                                        @endforeach
                                        
                                    </ul>
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="javascript:void(0)"><b>{{ $Skin_Treatments_By_Machine }}</b></a></li>
                                        @foreach ($menudata['skin_treatments_machine'] as $item)
                                        <li><a class="dropdown-item" href="{{ url($item->category_slug) }}">{{ \Illuminate\Support\Str::limit($item->$category_name, 45) }}</a></li>
                                        @endforeach

                                    </ul>
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="javascript:void(0)"><b>{{ $IPL_Treatments }}</b></a></li>
                                        @foreach ($menudata['ipl_treatments'] as $item)
                                        <li><a class="dropdown-item" href="{{ url($item->category_slug) }}">{{ \Illuminate\Support\Str::limit($item->$category_name, 45) }}</a></li>
                                        @endforeach

                                    </ul>
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="javascript:void(0)"><b>{{ $Combination_Packages }}</b></a></li>
                                        @foreach ($menudata['skin_combination_packages'] as $item)
                                        <li><a class="dropdown-item" href="{{ url($item->category_slug) }}">{{ \Illuminate\Support\Str::limit($item->$category_name, 45) }}</a></li>
                                        @endforeach
                                        
                                    </ul>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item dropdown position-static">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0)" role="button" data-bs-toggle="dropdown"
                                aria-expanded="true">
                                {{ $Body_Sculpting }}
                            </a>
                            <div class="dropdown-menu w-100 ">
                                <div class="mega-menu">
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="javascript:void(0)"><b>{{ $Body_Treatments }}</b></a></li>
                                        @foreach ($menudata['body_treatments'] as $item)
                                        <li><a class="dropdown-item" href="{{ url($item->category_slug) }}">{{ \Illuminate\Support\Str::limit($item->$category_name, 45) }}</a></li>
                                        @endforeach

                                    </ul>
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="javascript:void(0)"><b>{{ $Body_Treatments_by_Machines }}</b></a></li>
                                        @foreach ($menudata['body_treatments_machines'] as $item)
                                        <li><a class="dropdown-item" href="{{ url($item->category_slug) }}">{{ \Illuminate\Support\Str::limit($item->$category_name, 45) }}</a></li>
                                        @endforeach

                                    </ul>
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="javascript:void(0)"><b>{{ $Body_Treatments_by_Area }}</b></a></li>
                                        @foreach ($menudata['body_treatments_area'] as $item)
                                        <li><a class="dropdown-item" href="{{ url($item->category_slug) }}">{{ \Illuminate\Support\Str::limit($item->$category_name, 45) }}</a></li>
                                        @endforeach

                                    </ul>
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="javascript:void(0)"><b>{{ $Combination_Packages }}</b></a></li>
                                        @foreach ($menudata['body_combination_packages'] as $item)
                                        <li><a class="dropdown-item" href="{{ url($item->category_slug) }}">{{ \Illuminate\Support\Str::limit($item->$category_name, 45) }}</a></li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item dropdown position-static">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0)" role="button" data-bs-toggle="dropdown"
                                aria-expanded="true">
                                {{ $Medical_Injectables }}
                            </a>
                            <div class="dropdown-menu w-100 ">
                                <div class="mega-menu">
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="javascript:void(0)"><b>{{ $Medical }}</b></a></li>
                                        @foreach ($menudata['medical'] as $item)
                                        <li><a class="dropdown-item" href="{{ url($item->category_slug) }}">{{ \Illuminate\Support\Str::limit($item->$category_name, 45) }}</a></li>
                                        @endforeach

                                    </ul>
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="javascript:void(0)"><b>{{ $Injectables }}</b></a></li>
                                        @foreach ($menudata['injectables'] as $item)
                                        <li><a class="dropdown-item" href="{{ url($item->category_slug) }}">{{ \Illuminate\Support\Str::limit($item->$category_name, 45) }}</a></li>
                                        @endforeach

                                    </ul>
                                    <ul class="p-0">
                                        <li><a class="dropdown-item" href="javascript:void(0)"><b>{{ $The_Medical_Team }}</b></a></li>
                                        @foreach ($menudata['medical_teams'] as $item)
                                        <li><a class="dropdown-item" href="{{ url($item->team_slug) }}">{{ \Illuminate\Support\Str::limit($item->team_name, 45) }}</a></li>
                                        @endforeach

                                    </ul>
                                    
                                    
                                </div>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0)" role="button" data-bs-toggle="dropdown"
                                aria-expanded="true">
                                {{ $Dermatology }}
                            </a>
                            <ul class="dropdown-menu">
                                @foreach ($menudata['dermatology'] as $item)
                                <li><a class="dropdown-item" href="{{ url($item->category_slug) }}">{{ \Illuminate\Support\Str::limit($item->$category_name, 45) }}</a></li>
                                @endforeach

                            </ul>
                        </li>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="{{ url('shop') }}">
                                {{ $Shop }}
                            </a>
                        </li>


                    </ul>
                </div>
            </div>
        </nav>

        <!-- mobile menu  -->
        
        <nav class="mobile-menu navbar navbar-expand-lg d-lg-none" style="margin-top:0px;padding-top: 0px;">
            <div class="container-fluid" style="background-color: #F2F7FC; padding:8px; " >
                <div class="d-flex align-items-center">
                    <a href="https://wa.me/message/UUVVIUDNUOIUM1" target="_blank" ><i class="fab fa-whatsapp" style="font-size:26px;"> </i></a>
                    <a class="nav-link  mobile-search" aria-current="page" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#searchModal"><img class="search-icon" src="https://dslclinic.com/frontend/images/search.svg" alt=""></a>
                </div> 
               
               <div>
                
                <a href="{{ url('contact-us') }}" style="font-size: 16px; margin-right: 9px;"><i class="fas fa-map-marker-alt"> </i> {{ $Clinics }} </a>
                <a href="tel:02080040277" target="_blank" style="font-size: 16px; margin-right: 9px;"><i class="fas fa-phone"> </i> {{ $Call }}</a>
                <a href="{{ url('offer') }}"  style="font-size: 16px; margin-right: 9px;"><i class="fas fa-percentage"> </i> {{ $Offers }}</a>
                
                
               </div>
                
            </div>
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
                                        <span>{{ $Conditions }}</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                                <ul class="submenu">
                                    @foreach ($menudata['conditions'] as $item)
                                    <li><a href="{{ url($item->category_slug) }}">{{ \Illuminate\Support\Str::limit($item->$category_name, 45) }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link laser-hair-removal" href="javascript:void(0);">
                                    <div>
                                        <img class="mobile-icon" src="{{ asset('frontend/images/icon-laser-hair-removal.svg') }}" alt="">
                                        <span>{{ $Hair_Restoration }}</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                                <ul class="submenu">
                                    @foreach ($menudata['hair_restoration'] as $item)
                                    <li><a href="{{ url($item->category_slug) }}">{{ \Illuminate\Support\Str::limit($item->$category_name, 45) }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link laser-hair-removal" href="javascript:void(0);">
                                    <div>
                                        <img class="mobile-icon" src="{{ asset('frontend/images/icon-laser-hair-removal.svg') }}" alt="">
                                        <span>{{ $Laser_Hair_Removal }}</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                                <ul class="submenu">
                                    @foreach ($menudata['laser_hair_removal'] as $item)
                                    <li><a href="{{ url($item->category_slug) }}">{{ \Illuminate\Support\Str::limit($item->$category_name, 45) }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link laser-hair-removal" href="javascript:void(0);">
                                    <div>
                                        <img class="mobile-icon" src="{{ asset('frontend/images/icon-tattoo-removal.svg') }}" alt="">
                                        <span>{{ $Tattoo_Removal }}</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                                <ul class="submenu">
                                    <li class="nav-item dropdown">
                                        <a class="nav-link" href="javascript:void(0)" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span>{{ $Tattoo_Removal }}</span>
                                            <i class="fa-solid fa-chevron-right"></i>

                                        </a>
                                        <ul class="dropdown-menu">
                                            @foreach ($menudata['tattoo_removal'] as $item)
                                                <li><a href="{{ url($item->category_slug) }}">{{ \Illuminate\Support\Str::limit($item->$category_name, 45) }}</a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link" href="javascript:void(0)" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                             <span>{{ $Laser_Tattoo_Removal_By_Machine }}</span>
                                            <i class="fa-solid fa-chevron-right"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            @foreach ($menudata['tattoo_removal_machine'] as $item)
                                                <li><a href="{{ url($item->category_slug) }}">{{ \Illuminate\Support\Str::limit($item->$category_name, 45) }} </a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link" href="javascript:void(0)" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                             <span>{{ $Semi_Permanent_Makeup_Removal }}</span>
                                            <i class="fa-solid fa-chevron-right"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            @foreach ($menudata['semi_tattoo_removal_machine'] as $item)
                                                <li><a href="{{ url($item->category_slug) }}">{{ \Illuminate\Support\Str::limit($item->$category_name, 45) }} </a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link laser-hair-removal" href="javascript:void(0);">
                                    <div>
                                        <img class="mobile-icon" src="{{ asset('frontend/images/icon-skin-treatments.svg') }}" alt="">
                                        <span>{{ $Skin_Treatments }}</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                                <ul class="submenu">
                                    <li class="nav-item dropdown">
                                        <a class="nav-link" href="javascript:void(0)" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span>{{ $Skin_Treatments }}</span>
                                            <i class="fa-solid fa-chevron-right"></i>

                                        </a>
                                        <ul class="dropdown-menu">
                                            @foreach ($menudata['skin_treatments'] as $item)
                                                <li><a href="{{ url($item->category_slug) }}">{{ \Illuminate\Support\Str::limit($item->$category_name, 45) }}</a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link" href="javascript:void(0)" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                             <span>{{ $Skin_Treatments_By_Machine }}</span>
                                            <i class="fa-solid fa-chevron-right"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            @foreach ($menudata['skin_treatments_machine'] as $item)
                                                <li><a href="{{ url($item->category_slug) }}">{{ \Illuminate\Support\Str::limit($item->$category_name, 45) }} </a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link" href="javascript:void(0)" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                             <span>{{ $IPL_Treatments }}</span>
                                            <i class="fa-solid fa-chevron-right"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            @foreach ($menudata['ipl_treatments'] as $item)
                                                <li><a href="{{ url($item->category_slug) }}">{{ \Illuminate\Support\Str::limit($item->$category_name, 45) }} </a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link" href="javascript:void(0)" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                             <span>{{ $Combination_Packages }}</span>
                                            <i class="fa-solid fa-chevron-right"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            @foreach ($menudata['skin_combination_packages'] as $item)
                                                <li><a href="{{ url($item->category_slug) }}">{{ \Illuminate\Support\Str::limit($item->$category_name, 45) }} </a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link laser-hair-removal" href="javascript:void(0);">
                                    <div>
                                        <img class="mobile-icon" src="{{ asset('frontend/images/icon-body-sculpting.svg') }}" alt="">
                                        <span>{{ $Body_Sculpting }}</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                                <ul class="submenu">
                                    <li class="nav-item dropdown">
                                        <a class="nav-link" href="javascript:void(0)" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span>{{ $Body_Treatments }}</span>
                                            <i class="fa-solid fa-chevron-right"></i>

                                        </a>
                                        <ul class="dropdown-menu">
                                            @foreach ($menudata['body_treatments'] as $item)
                                                <li><a href="{{ url($item->category_slug) }}">{{ \Illuminate\Support\Str::limit($item->$category_name, 45) }}</a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link" href="javascript:void(0)" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                             <span>{{ $Body_Treatments_by_Machines }}</span>
                                            <i class="fa-solid fa-chevron-right"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            @foreach ($menudata['body_treatments_machines'] as $item)
                                                <li><a href="{{ url($item->category_slug) }}">{{ \Illuminate\Support\Str::limit($item->$category_name, 45) }} </a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link" href="javascript:void(0)" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                             <span>{{ $Body_Treatments_by_Area }}</span>
                                            <i class="fa-solid fa-chevron-right"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            @foreach ($menudata['body_treatments_area'] as $item)
                                                <li><a href="{{ url($item->category_slug) }}">{{ \Illuminate\Support\Str::limit($item->$category_name, 45) }} </a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link" href="javascript:void(0)" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                             <span>{{ $Combination_Packages }}</span>
                                            <i class="fa-solid fa-chevron-right"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            @foreach ($menudata['body_combination_packages'] as $item)
                                                <li><a href="{{ url($item->category_slug) }}">{{ \Illuminate\Support\Str::limit($item->$category_name, 45) }} </a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link laser-hair-removal" href="javascript:void(0);">
                                    <div>
                                        <img class="mobile-icon" src="{{ asset('frontend/images/icon-medical.svg') }}" alt="">
                                        <span>{{ $Medical_Injectables }}</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                                <ul class="submenu">
                                    <li class="nav-item dropdown">
                                        <a class="nav-link" href="javascript:void(0)" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span>{{ $Medical }}</span>
                                            <i class="fa-solid fa-chevron-right"></i>

                                        </a>
                                        <ul class="dropdown-menu">
                                            @foreach ($menudata['medical'] as $item)
                                                <li><a href="{{ url($item->category_slug) }}">{{ \Illuminate\Support\Str::limit($item->$category_name, 45) }}</a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link" href="javascript:void(0)" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                             <span>{{ $Injectables }}</span>
                                            <i class="fa-solid fa-chevron-right"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            @foreach ($menudata['injectables'] as $item)
                                                <li><a href="{{ url($item->category_slug) }}">{{ \Illuminate\Support\Str::limit($item->$category_name, 45) }} </a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link" href="javascript:void(0)" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                             <span>{{ $The_Medical_Team }}</span>
                                            <i class="fa-solid fa-chevron-right"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            @foreach ($menudata['medical_teams'] as $item)
                                                <li><a href="{{ url($item->team_slug) }}">{{ \Illuminate\Support\Str::limit($item->team_name, 45) }} </a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    
                                </ul>
                            </li>
                            
                            
                            <li class="nav-item">
                                <a class="nav-link laser-hair-removal" href="javascript:void(0);">
                                    <div>
                                        <img class="mobile-icon" src="{{ asset('frontend/images/icon-dermatology.svg') }}" alt="">
                                        <span>{{ $Dermatology }}</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                                <ul class="submenu">
                                    @foreach ($menudata['dermatology'] as $item)
                                    <li><a href="{{ url($item->category_slug) }}">{{ \Illuminate\Support\Str::limit($item->$category_name, 45) }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            
                           
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('shop') }}">
                                    <div>
                                        <img class="mobile-icon" src="{{ asset('frontend/images/icon-tattoo-removal.svg') }}" alt="">
                                        <span>{{ $Shop }}</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('contact-us') }}">
                                    <div>
                                        <img class="mobile-icon" src="{{ asset('frontend/images/contact.svg') }}" alt="">
                                        <span>{{ $Contact }}</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('services') }}">
                                    <div>
                                        <img class="mobile-icon" src="{{ asset('frontend/images/icon-conditions.svg') }}" alt="">
                                        <span>{{ $Services }}</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </li>
                            
                            @if (Auth::guard('customer')->check())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('profile') }}">
                                    <div>
                                        <span class="fa fa-user" style="font-size: 28px;"></span>
                                        <span>{{ $Profile }}</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </li>
                            @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    <div>
                                        <span class="fa fa-user" style="font-size: 28px;"></span>
                                        <span>{{ $Login }}</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </li>
                            @endif
                           
                        </ul>

                        <div class="header-bottom-box">
                            <a href="{{ url('book-free-consultation') }}" class="bigbtn primary-btn btn w-100"> {{ $Book_Free_Consultation }}</a>
                            <div class="header-bottom">
                                <ul>
                                    <li><a href="{{ url('blog') }}">{{ $Blog }}</a></li>
                                    <li><span>|</span></li>
                                    <li><a href="{{ url('offer') }}">{{ $Offers }}</a></li>
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
                                        <a href="javascript:void(0)" class="icon-so x-icon"><img src="{{ asset('frontend/images/icon-sprites-x.png') }}" alt=""></a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" class="icon-so tiktok"><img src="{{ asset('frontend/images/icon-sprites-tik.png') }}" alt=""></a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" class="icon-so"><img src="{{ asset('frontend/images/threads-blue.svg') }}" alt=""></a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" class="icon-so"><img src="{{ asset('frontend/images/pinterest-blue.svg') }}" alt=""></a>
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
    