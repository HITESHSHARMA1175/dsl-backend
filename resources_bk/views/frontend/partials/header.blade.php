<?php
/**
 * DSL Clinic Header (original implementation inspired by clean clinic layouts)
 * - Full-width sticky header
 * - Desktop dropdown menus (hover/focus)
 * - Mobile hamburger with slide-in drawer + expandable submenus
 * - Accessible: aria attributes, keyboard focus, skip link
 */
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

<!-- Skip link for accessibility -->
<a class="skip-link" href="#main">Skip to content</a>

<!-- Optional top announcement bar -->
<div class="topbar" role="region" aria-label="Announcements">
  <div class="topbar__inner">
    <div class="topbar__rotator" aria-live="polite">
      <a class="topbar__msg is-active" href="offers.php">Refer a friend, you both get £50 off. <span class="topbar__u">See details</span></a>
      <a class="topbar__msg" href="offers.php">Special Offers! <span class="topbar__u">View Offers</span></a>
      <a class="topbar__msg" href="reviews.php">Over 80,000 five star reviews. <span class="topbar__u">See reviews</span></a>
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


<style>
  :root{
    --bg:#ffffff;
    --ink:#0b1b2a;
    --muted:#516072;
    --line:rgba(11,27,42,.10);
    --primary:#0f4c81;
    --primary2:#1b78c8;
    --surface:#f6f9fc;
    --shadow:0 12px 30px rgba(11,27,42,.10);
    --radius:16px;
    --navText:#0c1520;
    --navHover:#0c1520;
    --navLetter:1.2px;
  }

  *{box-sizing:border-box}
  .topbar, .site-header, .drawer, .cart-drawer{font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;}
  a{color:inherit;text-decoration:none}
  a:focus-visible, button:focus-visible{outline:3px solid rgba(27,120,200,.45); outline-offset:3px; border-radius:10px;}

  .skip-link{
    position:absolute; left:-999px; top:10px;
    background:var(--ink); color:#fff; padding:10px 14px;
    border-radius:12px; z-index:9999;
  }
  .skip-link:focus{left:10px;}

  .topbar{width:100%; background: #000; border-bottom:1px solid var(--line);}
  .topbar__inner{
    width:100%;
    max-width:100%;
    margin:0;
    padding:10px 20px;
    display:flex;
    gap:14px;
    align-items:center;
    justify-content:center;
  }

  .topbar__rotator{
    position:relative;
    display:flex;
    align-items:center;
    justify-content:center;
    min-height:18px;
    width:100%;
    max-width:900px;
    overflow:hidden;
  }

  .topbar__msg{
    position:absolute;
    left:0;
    right:0;
    margin:0 auto;
    text-align:center;
    color: #fff;
    font-size:14px;
    line-height:1.3;
    font-weight:600;
    opacity:0;
    transform:translateY(8px);
    transition:opacity .35s ease, transform .35s ease;
    white-space:nowrap;
    text-overflow:ellipsis;
    overflow:hidden;
    padding:0 10px;
  }

  .topbar__msg:hover{color:var(--ink);}

  .topbar__msg.is-active{
    opacity:1;
    transform:translateY(0);
  }
 .has-mega:hover .mega-menu,
  .has-mega.is-mega-open .mega-menu,
  .has-mega:focus-within .mega-menu{
    opacity:1;
    visibility:visible;
    pointer-events:auto;
  }
  .topbar__u{
    text-decoration:underline;
    text-underline-offset:3px;
    text-decoration-thickness:2px;
    text-decoration-color:rgba(12,21,32,.25);
  }

  .topbar__dots{
    display:flex;
    gap:6px;
    align-items:center;
  }
  .topbar__dots .dot{
    width:6px;
    height:6px;
    border-radius:999px;
    background:rgba(12,21,32,.20);
  }
  .topbar__dots .dot.is-active{
    background:rgba(12,21,32,.55);
  }

  @media (max-width: 640px){
    .topbar__inner{padding:10px 12px;}
    .topbar__dots{display:none;}
    .topbar__msg{font-size:13px;}
  }

  .site-header{
    width:100%;
    position:sticky;
    top:0;
    z-index:1000;
    background:#fff;
    border-bottom:1px solid var(--line);
  }
  .site-header.is-scrolled{box-shadow:0 10px 25px rgba(11,27,42,.08)}

  .header-inner{
    width:100%;
    max-width:100%;
    margin:0;
    padding:14px 20px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:14px;
  }

  .brand{display:flex; align-items:center; gap:10px; min-width:140px;}
  .brand__logo{display:flex; align-items:center; justify-content:center; max-height:44px;}
  .brand__logo img{height:44px; width:auto; display:block; object-fit:contain;}

  .nav{display:flex; align-items:center; flex:1; justify-content:center;}
  .nav__list{list-style:none; padding:0; margin:0; display:flex; align-items:center; gap:6px;}
  .nav__item{position:relative;}
  .nav__link{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:10px 14px;
    border-radius:999px;
    color:var(--navText);
    font-weight:700;
    font-size:13px;
    letter-spacing:var(--navLetter);
    text-transform:uppercase;
    transition:opacity .2s ease, text-decoration-color .2s ease;
    text-decoration:underline;
    text-decoration-thickness:2px;
    text-underline-offset:8px;
    text-decoration-color:transparent;
  }
  .nav__link:hover{
    opacity:.85;
    text-decoration-color:rgba(12,21,32,.35);
  }

  .nav__link--treatments{padding-right:10px;}
  .nav__caret{opacity:.75; transition:transform .18s ease;}

  .has-mega:hover > .nav__link,
  .has-mega.is-mega-open > .nav__link,
  .has-mega:focus-within > .nav__link{
    text-decoration-color:rgba(12,21,32,.35);
  }

  .has-mega:hover > .nav__link .nav__caret,
  .has-mega.is-mega-open > .nav__link .nav__caret,
  .has-mega:focus-within > .nav__link .nav__caret{
    transform:rotate(180deg);
  }

  .mega-menu{
    position:fixed;
    top:100;
    left:8px;
    right:8px;
    width:auto;
    transform:none;
    background:#fff;
    border-top:1px solid rgba(12,21,32,.05);
    opacity:0;
    visibility:hidden;
    pointer-events:none;
    transition:opacity .16s ease, visibility .16s ease;
    box-shadow:0 14px 26px rgba(11,27,42,.08);
  }

  .mega-menu__inner{
    display:grid;
    grid-template-columns:310px 1fr;
    min-height:420px;
  }

  .mega-menu__tabs{
    list-style:none;
    margin:0;
    padding:28px 20px;
    border-right:1px solid rgba(12,21,32,.10);
  }

  .mega-tab{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:14px;
    color:#5a6572;
    font-size:16px;
    line-height:1.2;
    font-weight:500;
    padding:12px 0;
    letter-spacing:-.01em;
  }

  .mega-menu__tabs li + li{margin-top:2px;}

  .mega-menu__tabs li.is-active .mega-tab{
    color:#0c1520;
    font-weight:700;
  }

  .mega-tab svg{opacity:.75; flex:0 0 auto;}

  .mega-menu__content{padding:26px 24px 20px 26px;}

  .mega-panel{
    display:none;
    grid-template-columns:repeat(3, minmax(180px, 1fr)) 300px;
    gap:30px;
    align-items:start;
  }

  .mega-panel.is-active{display:grid;}

  .mega-col h4{
    margin:0 0 18px;
    font-size:16px;
    line-height:1;
    font-weight:750;
    color:#20242a;
    letter-spacing:.05em;
    white-space:nowrap;
  }

  .mega-col__spaced{margin-top:22px !important;}

  .mega-col a{
    display:block;
    color:#6c727a;
    font-size:16px;
    line-height:1.25;
    padding:7px 0;
    transition:color .15s ease;
  }

  .mega-col a + a{margin-top:1px;}

  .mega-col a:hover{color:#171c23;}

  .mega-promo{
    position:relative;
    display:flex;
    min-height:360px;
    border-radius:4px;
    overflow:hidden;
    align-items:flex-end;
    padding:28px 20px 20px;
    background-image:linear-gradient(180deg, rgba(10,12,16,.08), rgba(10,12,16,.55)), var(--promo-bg);
    background-size:cover;
    background-position:center;
  }

  .mega-promo__title{
    color:#fff;
    font-size:42px;
    line-height:1.08;
    font-weight:500;
    max-width:90%;
    margin-bottom:14px;
  }

  .mega-promo__btn{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    width:max-content;
    background:#fff;
    color:#191d23;
    font-size:14px;
    line-height:1;
    font-weight:700;
    padding:15px 30px;
    border-radius:999px;
  }

  .mega-panel--tattoo{grid-template-columns:340px;}

  .mega-panel--tattoo .mega-promo{max-width:340px;}

  .mega-panel .mega-promo{flex-direction:column; align-items:flex-start; justify-content:flex-end;}

  .has-mega:hover .mega-menu,
  .has-mega.is-mega-open .mega-menu,
  .has-mega:focus-within .mega-menu{
    opacity:1;
    visibility:visible;
    pointer-events:auto;
  }

  .header-actions{display:flex; align-items:center; gap:10px; justify-content:flex-end;}

  .header-icons{
    display:flex;
    align-items:center;
    gap:18px;
    margin-right:20px;
  }

  .icon-btn{
    position:relative;
    width:36px;
    height:36px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:50%;
    cursor:pointer;
  }
  .header-icons .icon-btn{border:0; padding:0; background:transparent;}

  .icon-btn svg{stroke:#0c1520;}

  .cart-badge{
    position:absolute;
    top:-6px;
    right:-6px;
    background:#e53935;
    color:#fff;
    font-size:12px;
    font-weight:700;
    width:20px;
    height:20px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:50%;
  }
  .cart-badge[hidden]{display:none;}

  /* Cart drawer */
  .cart-drawer{
    position:fixed;
    inset:0;
    z-index:2500;
    display:none;
  }
  .cart-drawer.is-open{display:block;}
  .cart-drawer__backdrop{
    position:absolute;
    inset:0;
    background:rgba(0,0,0,.35);
  }
  .cart-drawer__panel{
    position:absolute;
    top:0;
    right:0;
    width:min(430px, 92vw);
    height:100%;
    background:#fff;
    border-left:1px solid var(--line);
    box-shadow:-18px 0 34px rgba(11,27,42,.16);
    display:flex;
    flex-direction:column;
    transform:translateX(100%);
    transition:transform .22s ease;
  }
  .cart-drawer.is-open .cart-drawer__panel{transform:translateX(0);}
  .cart-drawer__head{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:12px;
    padding:18px 18px 16px;
    border-bottom:1px solid var(--line);
  }
  .cart-drawer__eyebrow{
    margin:0 0 4px;
    color:var(--muted);
    font-size:12px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.12em;
  }
  .cart-drawer__title{margin:0; font-size:24px; line-height:1.1;}
  .cart-drawer__close{
    width:40px;
    height:40px;
    border-radius:12px;
    border:1px solid var(--line);
    background:#fff;
    cursor:pointer;
    font-size:22px;
    line-height:1;
  }
  .cart-drawer__items{
    padding:6px 18px 18px;
    overflow:auto;
    flex:1;
  }
  .cart-drawer__empty{
    padding:20px 18px 0;
    color:var(--muted);
    font-size:15px;
  }
  .cart-drawer__item{
    display:grid;
    grid-template-columns:68px 1fr auto;
    gap:14px;
    align-items:center;
    padding:14px 0;
    border-bottom:1px solid rgba(11,27,42,.08);
  }
  .cart-drawer__thumb{
    width:68px;
    height:68px;
    border-radius:14px;
    border:1px solid rgba(11,27,42,.08);
    overflow:hidden;
    background:#f7f9fb;
    display:flex;
    align-items:center;
    justify-content:center;
  }
  .cart-drawer__thumb img{width:100%; height:100%; object-fit:contain; display:block;}
  .cart-drawer__meta{min-width:0;}
  .cart-drawer__name{margin:0 0 8px; font-size:14px; font-weight:700; color:var(--ink);}
  .cart-drawer__actions{display:flex; align-items:center; gap:10px; flex-wrap:wrap;}
  .cart-drawer__qty{
    display:inline-flex;
    align-items:center;
    border:1px solid var(--line);
    border-radius:999px;
    overflow:hidden;
  }
  .cart-drawer__qty button,
  .cart-drawer__remove{
    border:0;
    background:transparent;
    cursor:pointer;
    font:inherit;
  }
  .cart-drawer__qty button{
    width:34px;
    height:34px;
    color:var(--ink);
    font-weight:700;
  }
  .cart-drawer__qty span{
    min-width:28px;
    text-align:center;
    font-size:14px;
    font-weight:700;
    color:var(--ink);
  }
  .cart-drawer__remove{
    color:#b3261e;
    font-size:13px;
    font-weight:700;
  }
  .cart-drawer__price{
    font-size:15px;
    font-weight:800;
    color:var(--ink);
    white-space:nowrap;
  }
  .cart-drawer__foot{
    padding:18px;
    border-top:1px solid var(--line);
    background:#fff;
  }
  .cart-drawer__subtotal{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:16px;
    font-size:15px;
    margin-bottom:14px;
  }
  .cart-drawer__subtotal strong{font-size:18px;}
  .cart-drawer__cta{
    display:flex;
    align-items:center;
    justify-content:center;
    width:100%;
    min-height:48px;
    border-radius:999px;
    background:var(--primary);
    color:#fff;
    font-weight:800;
    letter-spacing:.01em;
  }
  .cart-drawer__cta:hover{background:var(--primary2);}

  .lang-switcher{position:relative;}
  .lang-switcher__btn{
    height:36px;
    min-width:42px;
    padding:0 4px;
    border:0;
    border-radius:999px;
    background:transparent;
    display:inline-flex;
    align-items:center;
    gap:4px;
    cursor:pointer;
    color:#0c1520;
  }
  .lang-switcher__flag img{
    width:28px;
    height:28px;
    border-radius:50%;
    object-fit:cover;
    display:block;
  }
  .lang-switcher__caret{opacity:.75; transition:transform .16s ease;}

  .lang-switcher__menu{
    position:absolute;
    top:calc(100% + 8px);
    right:0;
    min-width:150px;
    padding:8px;
    border-radius:12px;
    background:#fff;
    border:1px solid rgba(11,27,42,.12);
    box-shadow:0 14px 28px rgba(11,27,42,.14);
    display:none;
    z-index:20;
  }
  .lang-switcher.is-open .lang-switcher__menu{display:block;}
  .lang-switcher.is-open .lang-switcher__caret{transform:rotate(180deg);}
  .lang-switcher__menu button{
    width:100%;
    border:0;
    background:transparent;
    text-align:left;
    padding:10px 10px;
    border-radius:8px;
    color:#202a35;
    font-weight:600;
    font-size:14px;
    cursor:pointer;
  }
  .lang-switcher__menu button:hover{background:rgba(11,27,42,.06);}

  .header-cta{
    height:52px;
    padding:0 28px;
    border-radius:40px;
    font-size:16px;
    font-weight:700;
    background:linear-gradient(135deg,#6b5bd2,#7a6be6);
    box-shadow:none;
  }

  .header-cta:hover{transform:none; opacity:.95;}

  /* ===== Mobile responsiveness (UPDATED) ===== */
  @media (max-width:980px){
    .header-icons{display:none;}

    /* tighter header spacing */
    .header-inner{padding:12px 12px; gap:10px;}
    .brand{min-width:auto;}
    .brand__logo img{height:38px;}

    /* keep CTA but make it compact */
    .header-cta{height:42px; padding:0 14px; font-size:14px; border-radius:999px;}

    /* hamburger always visible on mobile */
    .nav{display:none;}
    .mega-menu{display:none !important;}

    /* topbar align center on mobile */
    .topbar__inner{flex-direction:row; align-items:center; justify-content:center;}
  }

  @media (max-width:768px){
    /* hide CTA on mobile/tablet widths to avoid crowding with logo + hamburger */
    .header-cta{display:none;}
  }

  @media (max-width:520px){

    .header-inner{padding:10px 10px;}
    .brand__logo img{height:36px;}

    /* keep hamburger compact */
    .hamburger{width:42px; height:42px; border-radius:14px;}
  }

  .btn{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    height:42px;
    padding:0 16px;
    border-radius:15px;
    border:1px solid transparent;
    font-weight:700;
    font-size:14px;
    transition:transform .15s ease, box-shadow .15s ease, background .2s ease, color .2s ease, border-color .2s ease;
    will-change:transform;
  }
  .btn--primary{background:linear-gradient(135deg, var(--primary), var(--primary2)); color:#fff; box-shadow:0 10px 18px rgba(15,76,129,.18);}
  .btn--primary:hover{transform:translateY(-1px); box-shadow:0 14px 26px rgba(15,76,129,.22);}
  .btn--ghost{background:rgba(15,76,129,.07); color:var(--ink); border-color:rgba(15,76,129,.14);}
  .btn--ghost:hover{background:rgba(15,76,129,.11);}

  .hamburger{
    display:inline-flex;
    width:44px;
    height:44px;
    border-radius:14px;
    border:1px solid var(--line);
    background:rgba(255,255,255,.7);
    align-items:center;
    justify-content:center;
    cursor:pointer;
  }

  /* Hide hamburger on desktop (desktop uses the full nav) */
  @media (min-width:981px){
    .hamburger{display:none;}
  }
  .hamburger__bars{
    width:20px;
    height:14px;
    position:relative;
    display:block;
  }
  .hamburger__bars::before,
  .hamburger__bars::after{
    content:"";
    position:absolute;
    left:0;
    width:20px;
    height:2px;
    background:var(--ink);
    border-radius:2px;
  }
  .hamburger__bars::before{top:0;}
  .hamburger__bars::after{bottom:0;}
  .hamburger__bar{
    position:absolute;
    left:0;
    right:0;
    top:50%;
    transform:translateY(-50%);
    height:2px;
    background:var(--ink);
    border-radius:2px;
    display:block;
  }

  /* Drawer */
  .drawer{position:fixed; inset:0; z-index:2000; display:none;}
  .drawer.is-open{display:block;}
  .drawer__backdrop{position:absolute; inset:0; background:rgba(0,0,0,.35);}
  .drawer__panel{
    position:absolute;
    left:0;
    top:0;
    height:100%;
    width:min(420px, 92vw);
    background:var(--bg);
    border-left:0;
    border-right:1px solid var(--line);
    box-shadow:var(--shadow);
    transform:translateX(-100%);
    transition:transform .22s ease;
    display:flex;
    flex-direction:column;
  }
  .drawer.is-open .drawer__panel{transform:translateX(0);}
  .drawer.is-open .drawer__backdrop{backdrop-filter: blur(2px);}
  .drawer__top{display:flex; align-items:center; justify-content:space-between; padding:14px 16px; border-bottom:1px solid var(--line);}
  .drawer__brand img{height:38px; width:auto; display:block; object-fit:contain;}
  .drawer__close{width:42px; height:42px; border-radius:14px; border:1px solid var(--line); background:rgba(15,76,129,.06); cursor:pointer; font-size:18px;}

  .mnav{padding:10px 16px 18px; overflow:auto;}

  /* UPDATED: uppercase links in mobile drawer */
  .mnav__link{
    display:block;
    padding:12px 12px;
    border-radius:14px;
    font-weight:800;
    color:var(--ink);
    text-transform:uppercase;
    letter-spacing:1.1px;
  }
  .mnav__link:hover{background:rgba(15,76,129,.08); color:var(--primary);}

  .mnav__toggle{
    width:100%;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:12px 12px;
    border-radius:14px;
    border:1px solid rgba(11,27,42,.08);
    background:var(--surface);
    font-weight:800;
    color:var(--ink);
    cursor:pointer;
    margin-top:10px;
  }
  .mnav__submenu{padding:8px 8px 0 8px;}
  .mnav__submenu a{display:block; padding:10px 12px; border-radius:12px; color:var(--muted); font-weight:700;}
  .mnav__submenu a:hover{background:rgba(27,120,200,.10); color:var(--primary2);}

  .mnav__subtoggle{
    width:100%;
    display:flex;
    align-items:center;
    justify-content:space-between;
    border:0;
    border-radius:12px;
    background:transparent;
    color:#445264;
    font-weight:700;
    font-size:15px;
    text-align:left;
    padding:10px 12px;
    cursor:pointer;
  }
  .mnav__subtoggle:hover{background:rgba(15,76,129,.06); color:#182432;}
  .mnav__subtoggle span{transition:transform .16s ease;}
  .mnav__subtoggle[aria-expanded="true"] span{transform:rotate(180deg);}
  .mnav__subpanel{padding:4px 8px 10px 18px;}
  .mnav__subheading{
    margin:10px 10px 6px;
    color:#1a2736;
    font-size:12px;
    font-weight:800;
    letter-spacing:.08em;
    text-transform:uppercase;
  }
  .mnav__subpanel a{
    display:block;
    padding:8px 10px;
    border-radius:10px;
    color:#5f6874;
    font-weight:600;
    font-size:14px;
  }
  .mnav__subpanel a:hover{background:rgba(27,120,200,.10); color:var(--primary2);}

  .mnav__languages{
    display:flex;
    align-items:center;
    gap:10px;
    padding:8px 0 4px;
  }
  .mnav__lang{
    width:56px;
    border:1px solid rgba(11,27,42,.12);
    border-radius:12px;
    background:#fff;
    color:#2f3d4d;
    display:grid;
    justify-items:center;
    gap:4px;
    padding:7px 4px 6px;
    cursor:pointer;
    font-size:11px;
    font-weight:800;
    letter-spacing:.08em;
    text-transform:uppercase;
  }
  .mnav__lang img{
    width:22px;
    height:22px;
    border-radius:999px;
    object-fit:cover;
    display:block;
  }
  .mnav__lang.is-active{
    border-color:#1b78c8;
    box-shadow:0 0 0 1px rgba(27,120,200,.2) inset;
    color:#0f4c81;
  }

  /* UPDATED: premium CTA area */
  .mnav__cta{
    display:grid;
    gap:12px;
    margin-top:18px;
    padding-top:14px;
    border-top:1px solid var(--line);
  }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
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