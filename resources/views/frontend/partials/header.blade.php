<?php
/**
 * DSL Clinic Header (original implementation inspired by clean clinic layouts)
 * - Full-width sticky header
 * - Desktop dropdown menus (hover/focus)
 * - Mobile hamburger with slide-in drawer + expandable submenus
 * - Accessible: aria attributes, keyboard focus, skip link
 */
?>

<link rel="stylesheet" href="{{ asset('frontend/css/custom_new.css?v=4.1') }}" />
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

<!-- Skip link for accessibility -->
<a class="skip-link" href="#main">Skip to content</a>

<!-- Optional top announcement bar -->
<div class="topbar" role="region" aria-label="Announcements">
  <div class="topbar__inner">
    <div class="topbar__rotator" aria-live="polite">
      <a class="topbar__msg is-active" href="offers.php">Refer a friend, you both get £50 off. <span class="topbar__u">See details</span></a>
      <a class="topbar__msg" href="shop">Special Offers! <span class="topbar__u">View Offers</span></a>
      <!-- <a class="topbar__msg" href="shop">Over 80,000 five star reviews. <span class="topbar__u">See reviews</span></a> -->
    </div>
    <div class="topbar__dots" aria-hidden="true">
      <span class="dot is-active"></span>
      <span class="dot"></span>
      <span class="dot"></span>
    </div>
  </div>
</div>

<header class="site-header" id="siteHeader">
  <div class="header-inner">

    <!-- Logo -->
    <a class="brand" href="/" aria-label="Go to homepage">
      <span class="brand__logo" aria-hidden="true">
        <img src="https://dslclinic.com/frontend/images/logo-plc.jpeg" alt="DSL Clinic" loading="eager" />
      </span>
    </a>

    <!-- Desktop nav -->
    <nav class="nav" aria-label="Primary navigation">
      <ul class="nav__list">

        <li class="nav__item has-submenu has-mega">
          <a class="nav__link nav__link--treatments" href="services" aria-haspopup="true" aria-expanded="false">
            <span>TREATMENTS</span>
            <svg class="nav__caret" width="12" height="12" viewBox="0 0 12 12" aria-hidden="true">
              <path d="M2 4.5L6 8l4-3.5" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </a>

          <div class="mega-menu" aria-label="Treatments mega menu">
            <div class="mega-menu__inner">
              <ul class="mega-menu__tabs" role="list">

                  <li class="is-active">
                    <a href="javascript:void(0)" class="mega-tab" data-panel="hair" aria-current="true">
                      <span>Hair Restoration</span>
                      <svg width="16" height="16" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M6 3.5L10.5 8 6 12.5" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </a>
                  </li>
                
                  <li>
                    <a href="javascript:void(0)" class="mega-tab" data-panel="laser">
                      <span>Laser Hair Removal</span>
                      <svg width="16" height="16" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M6 3.5L10.5 8 6 12.5" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </a>
                  </li>
                
                  <li>
                    <a href="javascript:void(0)" class="mega-tab" data-panel="tattoo">
                      <span>Tattoo Removal</span>
                      <svg width="16" height="16" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M6 3.5L10.5 8 6 12.5" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </a>
                  </li>
                
                  <li>
                    <a href="javascript:void(0)" class="mega-tab" data-panel="skin">
                      <span>Skin Treatments</span>
                      <svg width="16" height="16" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M6 3.5L10.5 8 6 12.5" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </a>
                  </li>
                
                  <li>
                    <a href="javascript:void(0)" class="mega-tab" data-panel="body">
                      <span>Body Sculpting</span>
                      <svg width="16" height="16" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M6 3.5L10.5 8 6 12.5" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </a>
                  </li>
                
                  <li>
                    <a href="javascript:void(0)" class="mega-tab" data-panel="medical">
                      <span>Medical & Injectables</span>
                      <svg width="16" height="16" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M6 3.5L10.5 8 6 12.5" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </a>
                  </li>
                
                  <li>
                    <a href="javascript:void(0)" class="mega-tab" data-panel="derma">
                      <span>Dermatology</span>
                      <svg width="16" height="16" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M6 3.5L10.5 8 6 12.5" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </a>
                  </li>
                
              </ul>

              <div class="mega-menu__content">

  {{-- ================= HAIR ================= --}}
  <div class="mega-panel is-active" data-panel="hair">
    <div class="mega-col">
      <h4>{{ $Hair_Restoration }}</h4>
      @foreach ($menudata['hair_restoration'] as $item)
        <a href="{{ url($item->category_slug) }}">
          {{ \Illuminate\Support\Str::limit($item->$category_name, 40) }}
        </a>
      @endforeach
    </div>

    {{-- SAME IMAGE --}}
    <a class="mega-promo" href="#" style="--promo-bg:url('https://images.unsplash.com/photo-1616394584738-fc6e612e71b9?auto=format&fit=crop&w=900&q=80')">
      <span class="mega-promo__title">Hair Treatments</span>
      <span class="mega-promo__btn">View More</span>
    </a>
  </div>

  {{-- ================= LASER ================= --}}
  <div class="mega-panel" data-panel="laser">
    <div class="mega-col">
      <h4>{{ $Laser_Hair_Removal }}</h4>
      @foreach ($menudata['laser_hair_removal'] as $item)
        <a href="{{ url($item->category_slug) }}">
          {{ \Illuminate\Support\Str::limit($item->$category_name, 40) }}
        </a>
      @endforeach
    </div>

    <a class="mega-promo" href="#" style="--promo-bg:url('https://images.unsplash.com/photo-1626430352344-671f98c7dd2a?auto=format&fit=crop&w=900&q=80')">
      <span class="mega-promo__title">Laser Treatments</span>
      <span class="mega-promo__btn">View Offers</span>
    </a>
  </div>

  {{-- ================= TATTOO ================= --}}
  <div class="mega-panel" data-panel="tattoo">

    <div class="mega-col">
      <h4>{{ $Tattoo_Removal }}</h4>
      @foreach ($menudata['tattoo_removal'] as $item)
        <a href="{{ url($item->category_slug) }}">
          {{ \Illuminate\Support\Str::limit($item->$category_name, 40) }}
        </a>
      @endforeach
    </div>

    <div class="mega-col">
      <h4>{{ $Laser_Tattoo_Removal_By_Machine }}</h4>
      @foreach ($menudata['tattoo_removal_machine'] as $item)
        <a href="{{ url($item->category_slug) }}">
          {{ \Illuminate\Support\Str::limit($item->$category_name, 40) }}
        </a>
      @endforeach
    </div>

    <div class="mega-col">
      <h4>{{ $Semi_Permanent_Makeup_Removal }}</h4>
      @foreach ($menudata['semi_tattoo_removal_machine'] as $item)
        <a href="{{ url($item->category_slug) }}">
          {{ \Illuminate\Support\Str::limit($item->$category_name, 40) }}
        </a>
      @endforeach
    </div>

    <a class="mega-promo" href="#" style="--promo-bg:url('https://images.unsplash.com/photo-1598373182133-52452f7691ef?auto=format&fit=crop&w=900&q=80')">
      <span class="mega-promo__title">Tattoo Removal</span>
      <span class="mega-promo__btn">Learn More</span>
    </a>
  </div>

  {{-- ================= SKIN ================= --}}
  <div class="mega-panel" data-panel="skin">

      {{-- ===== COLUMN 1: SKIN TREATMENTS ===== --}}
      <div class="mega-col">
        <h4>{{ $Skin_Treatments }}</h4>
        @foreach ($menudata['skin_treatments'] as $item)
          <a href="{{ url($item->category_slug) }}">
            {{ \Illuminate\Support\Str::limit($item->$category_name, 40) }}
          </a>
        @endforeach
      </div>
    
      {{-- ===== COLUMN 2: BY MACHINE ===== --}}
      <div class="mega-col">
        <h4>{{ $Skin_Treatments_By_Machine }}</h4>
        @foreach ($menudata['skin_treatments_machine'] as $item)
          <a href="{{ url($item->category_slug) }}">
            {{ \Illuminate\Support\Str::limit($item->$category_name, 40) }}
          </a>
        @endforeach
      </div>
    
      {{-- ===== COLUMN 3: IPL ===== --}}
      <div class="mega-col">
        <h4>{{ $IPL_Treatments }}</h4>
        @foreach ($menudata['ipl_treatments'] as $item)
          <a href="{{ url($item->category_slug) }}">
            {{ \Illuminate\Support\Str::limit($item->$category_name, 40) }}
          </a>
        @endforeach
      </div>
    
      {{-- ===== COLUMN 4: PACKAGES ===== --}}
      <div class="mega-col">
        <h4>{{ $Combination_Packages }}</h4>
        @foreach ($menudata['skin_combination_packages'] as $item)
          <a href="{{ url($item->category_slug) }}">
            {{ \Illuminate\Support\Str::limit($item->$category_name, 40) }}
          </a>
        @endforeach
      </div>
    
      {{-- ===== IMAGE (DON'T REMOVE) ===== --}}
      <!--<a class="mega-promo" href="#" style="--promo-bg:url('https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=900&q=80')">-->
      <!--  <span class="mega-promo__title">Advanced Skin Treatments</span>-->
      <!--  <span class="mega-promo__btn">Explore</span>-->
      <!--</a>-->
    
    </div>

  {{-- ================= BODY ================= --}}
  <div class="mega-panel" data-panel="body">

  {{-- ===== COLUMN 1: BODY TREATMENTS ===== --}}
  <div class="mega-col">
    <h4>{{ $Body_Treatments }}</h4>
    @foreach ($menudata['body_treatments'] as $item)
      <a href="{{ url($item->category_slug) }}">
        {{ \Illuminate\Support\Str::limit($item->$category_name, 40) }}
      </a>
    @endforeach
  </div>

  {{-- ===== COLUMN 2: BY MACHINES ===== --}}
  <div class="mega-col">
    <h4>{{ $Body_Treatments_by_Machines }}</h4>
    @foreach ($menudata['body_treatments_machines'] as $item)
      <a href="{{ url($item->category_slug) }}">
        {{ \Illuminate\Support\Str::limit($item->$category_name, 40) }}
      </a>
    @endforeach
  </div>

  {{-- ===== COLUMN 3: BY AREA ===== --}}
  <div class="mega-col">
    <h4>{{ $Body_Treatments_by_Area }}</h4>
    @foreach ($menudata['body_treatments_area'] as $item)
      <a href="{{ url($item->category_slug) }}">
        {{ \Illuminate\Support\Str::limit($item->$category_name, 40) }}
      </a>
    @endforeach
  </div>

  {{-- ===== COLUMN 4: PACKAGES ===== --}}
  <div class="mega-col">
    <h4>{{ $Combination_Packages }}</h4>
    @foreach ($menudata['body_combination_packages'] as $item)
      <a href="{{ url($item->category_slug) }}">
        {{ \Illuminate\Support\Str::limit($item->$category_name, 40) }}
      </a>
    @endforeach
  </div>

  {{-- ===== IMAGE (KEEP SAME) ===== --}}
  <!--<a class="mega-promo" href="#" style="--promo-bg:url('https://images.unsplash.com/photo-1517836357463-d25dfeac3438?auto=format&fit=crop&w=900&q=80')">-->
  <!--  <span class="mega-promo__title">Body Sculpting</span>-->
  <!--  <span class="mega-promo__btn">Explore</span>-->
  <!--</a>-->

</div>

  {{-- ================= MEDICAL ================= --}}
  <div class="mega-panel" data-panel="medical">

  {{-- ===== COLUMN 1: MEDICAL ===== --}}
  <div class="mega-col">
    <h4>{{ $Medical }}</h4>
    @foreach ($menudata['medical'] as $item)
      <a href="{{ url($item->category_slug) }}">
        {{ \Illuminate\Support\Str::limit($item->$category_name, 40) }}
      </a>
    @endforeach
  </div>

  {{-- ===== COLUMN 2: INJECTABLES ===== --}}
  <div class="mega-col">
    <h4>{{ $Injectables }}</h4>
    @foreach ($menudata['injectables'] as $item)
      <a href="{{ url($item->category_slug) }}">
        {{ \Illuminate\Support\Str::limit($item->$category_name, 40) }}
      </a>
    @endforeach
  </div>

  {{-- ===== COLUMN 3: MEDICAL TEAM ===== --}}
  <div class="mega-col">
    <h4>{{ $The_Medical_Team }}</h4>
    @foreach ($menudata['medical_teams'] as $item)
      <a href="{{ url($item->team_slug) }}">
        {{ \Illuminate\Support\Str::limit($item->team_name, 40) }}
      </a>
    @endforeach
  </div>

  {{-- ===== IMAGE (KEEP SAME / REUSE) ===== --}}
  <a class="mega-promo" href="#" style="--promo-bg:url('https://images.unsplash.com/photo-1616394584738-fc6e612e71b9?auto=format&fit=crop&w=900&q=80')">
    <span class="mega-promo__title">Medical & Injectables</span>
    <span class="mega-promo__btn">Explore</span>
  </a>

</div>

  {{-- ================= DERMA ================= --}}
  <div class="mega-panel" data-panel="derma">
    <div class="mega-col">
      <h4>{{ $Dermatology }}</h4>
      @foreach ($menudata['dermatology'] as $item)
        <a href="{{ url($item->category_slug) }}">
          {{ \Illuminate\Support\Str::limit($item->$category_name, 40) }}
        </a>
      @endforeach
    </div>

    <a class="mega-promo" href="#" style="--promo-bg:url('https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=900&q=80')">
      <span class="mega-promo__title">Dermatology</span>
      <span class="mega-promo__btn">View</span>
    </a>
  </div>

</div>
            </div>
          </div>
        </li>

        <li class="nav__item"><a class="nav__link" href="{{ route('pricing') }}">PRICING</a></li>
        <li class="nav__item"><a class="nav__link" href="{{ route('reviews') }}">REVIEWS</a></li>
        <li class="nav__item"><a class="nav__link" href="{{ route('locations') }}">LOCATIONS</a></li>
        <li class="nav__item"><a class="nav__link" href="{{ route('shop') }}">SHOP</a></li>

      </ul>
    </nav>

    <!-- Right actions -->
    <div class="header-actions">

      <div class="header-icons">
        <!-- Cart Icon -->
        @php
            $ip = request()->ip();

            $cartCount = DB::table('guest_carts')
                ->where('ip_address', $ip)
                ->sum('qty');
        @endphp
       <button class="icon-btn cart-icon" type="button" aria-label="Open cart" data-cart-open>
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M6 6h15l-1.5 9h-13z"/>
            <path d="M6 6L5 3H2"/>
          </svg>
          <span class="cart-badge">{{ $cartCount ?? 0 }}</span>
        </button>

        <!-- User Icon -->
        <div class="icon-btn">
          <a  href="{{ route('login') }}">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="7" r="4"/>
            <path d="M5.5 21a6.5 6.5 0 0 1 13 0"/>
          </svg>
        </a>
        </div>

        <!-- UK Flag -->
        <div class="flag-icon">
          <img src="https://flagcdn.com/w40/gb.png" alt="UK" />
        </div>
      </div>

      <a class="btn btn--primary header-cta" style="color:#fff;background: #000;" href="{{ route('book-free-consultation') }}">Free Consultation</a>

      <!-- Mobile hamburger -->
      <button class="hamburger" type="button" aria-label="Open menu" aria-controls="mobileNav" aria-expanded="false">
        <span class="hamburger__bars" aria-hidden="true">
          <span class="hamburger__bar"></span>
        </span>
      </button>
    </div>
  </div>
</header>

<!-- Mobile drawer -->
<div class="drawer" id="mobileNav" aria-hidden="true">
  <div class="drawer__backdrop" data-drawer-close></div>
  <div class="drawer__panel" role="dialog" aria-modal="true" aria-label="Mobile navigation">
    <div class="drawer__top">
      <a class="drawer__brand" href="/" aria-label="Go to homepage">
        <img src="https://dslclinic.com/frontend/images/logo-plc.jpeg" alt="DSL Clinic" loading="eager" />
      </a>
      <button class="drawer__close" type="button" aria-label="Close menu" data-drawer-close>✕</button>
    </div>

    <nav class="mnav" aria-label="Mobile navigation">

      <button class="mnav__toggle" type="button" aria-expanded="false" aria-controls="m_treatments">
        TREATMENTS <span aria-hidden="true">▾</span>
      </button>
      <div class="mnav__submenu" id="m_treatments" hidden>
        <a href="service-detail.php?slug=injectables">Injectables</a>
        <a href="service-detail.php?slug=laser-hair-removal">Laser Hair Removal</a>
        <a href="service-detail.php?slug=skin-treatments">Skin Treatments</a>
        <a href="service-detail.php?slug=body-treatments">Body Treatments</a>
        <a href="service-detail.php?slug=laser-tattoo-removal">Laser Tattoo Removal</a>
      </div>

      <a class="mnav__link" href="pricing.php">PRICING</a>
      <a class="mnav__link" href="reviews.php">REVIEWS</a>
      <a class="mnav__link" href="locations.php">LOCATIONS</a>
      <a class="mnav__link" href="shop.php">SHOP</a>

      <div class="mnav__cta">
        <a class="btn btn--primary header-cta" href="appointment.php">Free Consultation</a>
      </div>
    </nav>
  </div>
</div>



<!-- Global cart drawer -->
<div class="cart-drawer" id="cartDrawer" aria-hidden="true">
  <div class="cart-drawer__backdrop" id="cartDrawerOverlay" data-cart-close></div>
  <aside class="cart-drawer__panel" role="dialog" aria-modal="true" aria-label="Shopping cart">
    <div class="cart-drawer__head">
      <div>
        <p class="cart-drawer__eyebrow">Your bag</p>
        <h2 class="cart-drawer__title">Cart</h2>
      </div>
      <button class="cart-drawer__close" type="button" aria-label="Close cart" data-cart-close>×</button>
    </div>

    <div class="cart-drawer__items" id="cartDrawerItems"></div>

    <div class="cart-drawer__empty" id="cartDrawerEmpty" hidden>
      Your cart is empty.
    </div>

    <div class="cart-drawer__foot">
      <div class="cart-drawer__subtotal">
        <span>Subtotal</span>
        <strong id="cartDrawerSubtotal">£0.00</strong>
      </div>
      <a class="cart-drawer__cta" href="{{ route('login') }}">Continue shopping</a>
    </div>
  </aside>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
  $(document).on("click","#addToBagBtn",function(){
var data_url = $(this).attr('data-url');
window.location.href = data_url;
});
  $(document).on('click', '[data-cart-open]', function () {

    $.ajax({
        url: "{{ route('get.cart') }}",
        type: "GET",
        success: function (res) {

            let html = '';

            if (res.items.length > 0) {

                res.items.forEach(function (item) {

                    let qty = item.qty;
                    let price = item.price;

                    html += `
                    <div class="cart-drawer__item" data-id="${item.product_id}">
                        
                        <div class="cart-drawer__thumb">
                            <img src="${item.image || ''}" alt="${item.product_name}">
                        </div>

                        <div class="cart-drawer__meta">
                            <p class="cart-drawer__name">${item.product_name}</p>

                            <div class="cart-drawer__actions">
                                <div class="cart-drawer__qty">
                                    <button type="button" data-cart-qty="dec">−</button>
                                    <span>${qty}</span>
                                    <button type="button" data-cart-qty="inc">+</button>
                                </div>

                                <button type="button" class="cart-drawer__remove">Remove</button>
                            </div>
                        </div>

                        <div class="cart-drawer__price">
                            ${money(price * qty)}
                        </div>

                    </div>
                    `;
                });

            } else {
                html = `<p style="text-align:center;">Cart is empty</p>`;
            }

            // ✅ Set items
            $('#cartDrawerItems').html(html);

            // ✅ Update badge
          $('#cartDrawerSubtotal').text(money(res.subtotal));

    // ✅ Update cart badge
    $('.cart-badge').text(res.count);

            // ✅ Open drawer
            $('#cartDrawer').addClass('is-open').attr('aria-hidden', 'false');

        }
    });

});
  // ➕ Increase / ➖ Decrease
$(document).on('click', '[data-cart-qty]', function () {

    let button = $(this);
    let type = button.data('cart-qty'); // inc / dec
    let product_id = button.closest('.cart-drawer__item').data('id');

    $.ajax({
        url: "/cart/update-qty",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            product_id: product_id,
            type: type
        },
        success: function (res) {
            renderCart(res);
        }
    });
});

// ❌ Remove Item
$(document).on('click', '.cart-drawer__remove', function () {

    let product_id = $(this).closest('.cart-drawer__item').data('id');

    $.ajax({
        url: "/cart/remove",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            product_id: product_id
        },
        success: function (res) {
            renderCart(res);
        }
    });
});
function money(amount) {
    return '£' + parseFloat(amount).toFixed(2);
}

function renderCart(res) {

    let html = '';

    if (res.items.length > 0) {

        $('#cartDrawerEmpty').attr('hidden', true); // hide empty msg

        res.items.forEach(function (item) {

            html += `
            <div class="cart-drawer__item" data-id="${item.id}">
                
                <div class="cart-drawer__thumb">
                    <img src="${item.image || ''}" alt="${item.product_name}">
                </div>

                <div class="cart-drawer__meta">
                    <p class="cart-drawer__name">${item.product_name}</p>

                    <div class="cart-drawer__actions">
                        <div class="cart-drawer__qty">
                            <button type="button" data-cart-qty="dec">−</button>
                            <span>${item.qty}</span>
                            <button type="button" data-cart-qty="inc">+</button>
                        </div>

                        <button type="button" class="cart-drawer__remove">Remove</button>
                    </div>
                </div>

                <div class="cart-drawer__price">
                    ${money(item.price * item.qty)}
                </div>

            </div>
            `;
        });

    } else {
        html = '';
        $('#cartDrawerEmpty').removeAttr('hidden'); // show empty msg
    }

    // ✅ Set items
    $('#cartDrawerItems').html(html);

    // ✅ Update subtotal (YOUR MAIN REQUIREMENT 🔥)
    $('#cartDrawerSubtotal').text(money(res.subtotal));

    // ✅ Update cart badge
    $('.cart-badge').text(res.count);
}
</script>
<script>
  (function(){
    const header = document.getElementById('siteHeader');
    const drawer = document.getElementById('mobileNav');
    const burger = document.querySelector('.hamburger');
    const closeEls = drawer ? drawer.querySelectorAll('[data-drawer-close]') : [];
    const cartStorageKey = 'dsl_cart_v1';
    const cartDrawer = document.getElementById('cartDrawer');
    const cartOverlay = document.getElementById('cartDrawerOverlay');
    const cartItemsEl = document.getElementById('cartDrawerItems');
    const cartSubtotalEl = document.getElementById('cartDrawerSubtotal');
    const cartEmptyEl = document.getElementById('cartDrawerEmpty');
    const cartCountEls = Array.from(document.querySelectorAll('[data-cart-count]'));
    const cartOpeners = Array.from(document.querySelectorAll('[data-cart-open]'));

    const money = (value) => '£' + (Math.round(value * 100) / 100).toFixed(2);


  // Sticky shadow on scroll
    const onScroll = () => {
      if(!header) return;
      header.classList.toggle('is-scrolled', window.scrollY > 6);
    };
    window.addEventListener('scroll', onScroll, {passive:true});
    onScroll();

    // Desktop submenu aria-expanded helper
    document.querySelectorAll('.nav__item.has-submenu').forEach((li) => {
      const a = li.querySelector(':scope > a');
      if(!a) return;
      li.addEventListener('mouseenter', () => a.setAttribute('aria-expanded','true'));
      li.addEventListener('mouseleave', () => a.setAttribute('aria-expanded','false'));
      li.addEventListener('focusin', () => a.setAttribute('aria-expanded','true'));
      li.addEventListener('focusout', (e) => {
        if(!li.contains(e.relatedTarget)) a.setAttribute('aria-expanded','false');
      });
    });

    // Treatments mega-menu panel switcher
    const megaNav = document.querySelector('.has-mega');
    if (megaNav) {
      const megaMenu = megaNav.querySelector('.mega-menu');
      const tabs = Array.from(megaNav.querySelectorAll('.mega-tab'));
      const panels = Array.from(megaNav.querySelectorAll('.mega-panel'));
      const desktopMegaQuery = window.matchMedia('(min-width: 981px)');
      let megaCloseTimer = null;

      const setMegaTop = () => {
        if (!header || !megaMenu || !desktopMegaQuery.matches) return;
        const rect = header.getBoundingClientRect();
        megaMenu.style.top = `${Math.max(0, Math.floor(rect.bottom) - 1)}px`;
      };

      const openMega = () => {
        if (!desktopMegaQuery.matches) return;
        if (megaCloseTimer) {
          clearTimeout(megaCloseTimer);
          megaCloseTimer = null;
        }
        setMegaTop();
        megaNav.classList.add('is-mega-open');
      };

      const closeMega = () => {
        if (!desktopMegaQuery.matches) {
          megaNav.classList.remove('is-mega-open');
          return;
        }
        if (megaCloseTimer) clearTimeout(megaCloseTimer);
        megaCloseTimer = setTimeout(() => {
          megaNav.classList.remove('is-mega-open');
        }, 320);
      };

      const syncMegaMode = () => {
        if (desktopMegaQuery.matches) {
          setMegaTop();
          return;
        }
        megaNav.classList.remove('is-mega-open');
        if (megaMenu) megaMenu.style.top = '';
      };

      const activatePanel = (panelId) => {
        tabs.forEach((tab) => {
          const isActive = tab.dataset.panel === panelId;
          const parent = tab.closest('li');
          if(parent) parent.classList.toggle('is-active', isActive);
          if(isActive){
            tab.setAttribute('aria-current', 'true');
          } else {
            tab.removeAttribute('aria-current');
          }
        });

        panels.forEach((panel) => {
          panel.classList.toggle('is-active', panel.dataset.panel === panelId);
        });
      };

      tabs.forEach((tab) => {
        const panelId = tab.dataset.panel;
        if(!panelId) return;
        tab.addEventListener('mouseenter', () => activatePanel(panelId));
        tab.addEventListener('focus', () => activatePanel(panelId));
      });

      megaNav.addEventListener('mouseenter', openMega);
      megaNav.addEventListener('mouseleave', closeMega);
      if (megaMenu) {
        megaMenu.addEventListener('mouseenter', openMega);
        megaMenu.addEventListener('mouseleave', closeMega);
      }
      megaNav.addEventListener('focusin', openMega);
      megaNav.addEventListener('focusout', (e) => {
        if (!megaNav.contains(e.relatedTarget)) closeMega();
      });

      window.addEventListener('resize', syncMegaMode);
      window.addEventListener('scroll', setMegaTop, { passive: true });
      syncMegaMode();
    }

    // Drawer open/close
    const setDrawer = (open) => {
      if(!drawer || !burger) return;
      drawer.classList.toggle('is-open', open);
      drawer.setAttribute('aria-hidden', open ? 'false' : 'true');
      burger.setAttribute('aria-expanded', open ? 'true' : 'false');
      document.documentElement.style.overflow = open ? 'hidden' : '';
    };

    if(burger){
      burger.addEventListener('click', () => {
        const isOpen = drawer.classList.contains('is-open');
        setDrawer(!isOpen);
      });
    }

    closeEls.forEach(el => el.addEventListener('click', () => setDrawer(false)));

    // Header language dropdown
    const langSwitcher = document.getElementById('langSwitcher');
    if (langSwitcher) {
      const langBtn = langSwitcher.querySelector('.lang-switcher__btn');
      const langMenu = langSwitcher.querySelector('.lang-switcher__menu');
      const langItems = Array.from(langSwitcher.querySelectorAll('[data-language]'));

      const setLangOpen = (open) => {
        langSwitcher.classList.toggle('is-open', open);
        if (langBtn) langBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
      };

      if (langBtn) {
        langBtn.addEventListener('click', (e) => {
          e.preventDefault();
          const open = langSwitcher.classList.contains('is-open');
          setLangOpen(!open);
        });
      }

      langItems.forEach((item) => {
        item.addEventListener('click', () => {
          const selected = item.getAttribute('data-language') || 'English';
          setLangOpen(false);
          if (langBtn) langBtn.setAttribute('aria-label', `Language: ${selected}`);
        });
      });

      document.addEventListener('click', (e) => {
        if (!langSwitcher.contains(e.target)) setLangOpen(false);
      });

      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') setLangOpen(false);
      });

    }

    // Close on ESC
    document.addEventListener('keydown', (e) => {
      if(e.key === 'Escape' && drawer && drawer.classList.contains('is-open')) setDrawer(false);
    });

    // Mobile submenu toggles
    document.querySelectorAll('.mnav__toggle').forEach(btn => {
      btn.addEventListener('click', () => {
        const id = btn.getAttribute('aria-controls');
        const panel = id ? document.getElementById(id) : null;
        const expanded = btn.getAttribute('aria-expanded') === 'true';
        btn.setAttribute('aria-expanded', expanded ? 'false' : 'true');
        if(panel) panel.hidden = expanded;
      });
    });

    // Mobile treatment nested toggles
    document.querySelectorAll('.mnav__subtoggle').forEach(btn => {
      btn.addEventListener('click', () => {
        const id = btn.getAttribute('aria-controls');
        const panel = id ? document.getElementById(id) : null;
        const expanded = btn.getAttribute('aria-expanded') === 'true';
        btn.setAttribute('aria-expanded', expanded ? 'false' : 'true');
        if(panel) panel.hidden = expanded;
      });
    });

    // Mobile language icons (UI only)
    document.querySelectorAll('.mnav__lang').forEach((btn) => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('.mnav__lang').forEach((node) => node.classList.remove('is-active'));
        btn.classList.add('is-active');
      });
    });

    // Topbar rotator
    const msgs = Array.from(document.querySelectorAll('.topbar__msg'));
    const dots = Array.from(document.querySelectorAll('.topbar__dots .dot'));
    let idx = 0;

    const showMsg = (i) => {
      msgs.forEach((m, k) => m.classList.toggle('is-active', k === i));
      dots.forEach((d, k) => d.classList.toggle('is-active', k === i));
    };

    if (msgs.length > 1) {
      showMsg(0);
      setInterval(() => {
        idx = (idx + 1) % msgs.length;
        showMsg(idx);
      }, 3200);
    }
  })();



const setCartOpens = (open) => {
  if (!cartDrawer) return;

  cartDrawer.classList.toggle('is-open', open);
  cartDrawer.setAttribute('aria-hidden', open ? 'false' : 'true');

  if (cartOverlay) cartOverlay.hidden = !open;

  document.documentElement.style.overflow = open ? 'hidden' : '';
};

// ✅ CLOSE: button + overlay + ESC
document.addEventListener('click', function (e) {
  if (e.target.matches('[data-cart-close]') || e.target === cartOverlay) {
    setCartOpens(false);
  }
});

document.addEventListener('keydown', function (e) {
  if (e.key === 'Escape') {
    setCartOpens(false);
  }
});


    const getCartCount = (items) => items.reduce((total, item) => total + Math.max(0, parseInt(item.qty, 10) || 0), 0);

    const syncBadge = (items) => {
      const count = getCartCount(items);
      cartCountEls.forEach((badge) => {
        badge.textContent = String(count);
        badge.hidden = count === 0;
        badge.setAttribute('aria-label', count === 1 ? '1 item in cart' : `${count} items in cart`);
      });
      return count;
    };

    const setCartOpen = (open) => {
      if (!cartDrawer) return;
      cartDrawer.classList.toggle('is-open', open);
      cartDrawer.setAttribute('aria-hidden', open ? 'false' : 'true');
      if (cartOverlay) cartOverlay.hidden = !open;
      document.documentElement.style.overflow = open ? 'hidden' : '';
    };

    const syncCartUI = () => {
      const items = readCart();
      syncBadge(items);
      renderCartDrawer(items);
      return items;
    };

    const persistCart = (items) => {
      const nextItems = items
        .filter((item) => item && item.name)
        .map((item) => ({
          name: String(item.name),
          img: item.img ? String(item.img) : '',
          price: Number(item.price) || 0,
          qty: Math.max(1, parseInt(item.qty, 10) || 1)
        }));

      writeCart(nextItems);
      syncCartUI();
      window.dispatchEvent(new CustomEvent('dsl-cart:updated', { detail: { items: nextItems } }));
      return nextItems;
    };

    if (cartOverlay) {
      cartOverlay.addEventListener('click', () => window.DSLCart.close());
    }

    if (cartDrawer) {
      cartDrawer.querySelectorAll('[data-cart-close]').forEach((button) => {
        button.addEventListener('click', () => window.DSLCart.close());
      });
    }

    document.addEventListener('keydown', (event) => {
      if (event.key === 'Escape' && cartDrawer && cartDrawer.classList.contains('is-open')) {
        window.DSLCart.close();
      }
    });

    window.addEventListener('storage', (event) => {
      if (event.key === cartStorageKey) syncCartUI();
    });

    syncCartUI();

  
</script>


