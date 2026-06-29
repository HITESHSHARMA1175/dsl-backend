<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>DSL Clinic</title>
  <meta name="description" content="DSL Clinic - Premium treatments and consultations." />

  <!-- If you already load Inter elsewhere, you can remove this -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

 
</head>

<body>



@include('frontend.partials.header')



  
  <script src="assets/ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js.js" type="text/javascript"></script>

  <main id="main">
    <!-- Personalised Plans (New Hero) -->
      <section class="hero">
        <video autoplay muted loop playsinline class="hero-video">
            <source src="{{ asset('frontend/dslsitevideo.mp4') }}" type="video/mp4">
        </video>

        <div class="hero-overlay"></div>

        <div class="hero-content reveal-up">
            <h1>Luxury Aesthetic Treatments</h1>
            <p>Premium skincare and laser treatments tailored to your needs.</p>
            <a href="book-free-consultation.html" class="hero-cta">Book Free Consultation</a>
        </div>
    </section>

    <!-- Sale now on / Most Popular Offers (original implementation, no hotlinked images) -->
    <section class="offers" aria-label="Most popular offers">
      <div class="offers__inner">
        <p class="offers__kicker">Sale now on</p>
        <div class="offers__head">
          <h2 class="offers__title">Most Popular Offers</h2>
          <div class="offers__controls">
            <a class="offers__viewall" href="shop.html">View all</a>
            <button class="offers__btn" type="button" data-offers-prev aria-label="Previous offers">‹</button>
            <button class="offers__btn" type="button" data-offers-next aria-label="Next offers">›</button>
          </div>
        </div>

        <div class="carousel" data-offers>
          <div class="carousel__track" data-offers-track tabindex="0">


@forelse($home_special_offer as $offer)
    
            <article class="offer" aria-label="{{ $offer->category_name }}">
     
                <!-- IMAGE -->
                <div class="offer__media"
                     style="background-image:url('{{ asset('uploads/servicecat/'.$offer->icon) }}'); 
                            background-size:cover; background-position:center;">
                </div>
    
                <!-- TAG -->
               
    
                <div class="offer__body">
    
                    <!-- CATEGORY -->
                    <p class="offer__category">
                   
    
                    <!-- NAME -->
                    <h3 class="offer__name">
                        {{ $offer->category_name }}
                    </h3>
    
                    <!-- PRICE -->
                 <!--    <div class="offer__priceRow">
                        <div class="offer__from">From</div>
    
                        <div class="offer__price">
                            £{{ number_format($offer->discounted_price > 0 ? $offer->discounted_price : $offer->price, 2) }}
                        </div>
    
                        @if($offer->discounted_price > 0)
                            <div class="offer__was">
                                was £{{ number_format($offer->price, 2) }}
                            </div>
                        @endif
                    </div> -->
    
                    <!-- CTA -->
                    <a class="offer__cta" href="{{ url($offer->category_slug) }}">
                        Book now
                    </a>
    
                </div>
            </article>
    
            @empty
    
            <p>No offers available</p>
    
            @endforelse

          </div>

          <!-- DOTS (dynamic optional) -->
         <div class="carousel__dots">
            @foreach($home_special_offer as $key => $o)
                <span class="dot {{ $key == 0 ? 'is-active' : '' }}"></span>
            @endforeach
        </div>

        </div>

      </div>
    </section>

    <!-- Full-width promo banner (anti-wrinkle subscription style) -->
    <section class="promo" aria-label="Featured subscription">
      <div class="promo__image reveal-up delay-2">
        <img src="{{ asset('uploads/female_face_promo.png') }}" alt="Flawless Skin" />
      </div>
      <div class="promo__surface">
        <div class="promo__inner">
          <div class="promo__content reveal-up">
            <p class="promo__eyebrow">NO STRESS. JUST FLAWLESS RESULTS</p>
            <h2 class="promo__title">Check Out Our<br>Skin Care</h2>
            <p class="promo__desc">Advanced care. Visible results. Delivered to you. Your journey to younger, smoother
              skin starts now.</p>
            <a class="promo__cta" href="offers.html">Check Out Our Skin Care Brands &nbsp;&nbsp;&rarr;</a>
          </div>
        </div>
      </div>
    </section>

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
<?php

// Demo tiles (replace images/links with your own)
$tiles = [
  [
    "title" => $Hair_Restoration,
    "cta" => "View pricing",
    "href" => "/pricing/hair_restoration",
    "img" => "https://dslclinic.com/uploads/servicecat/88bhP4fcxRXahRrtO.webp",
    "col" => 1,
  ],
  [
    "title" => $Laser_Hair_Removal,
    "cta" => "View pricing",
    "href" => "/pricing/laser_hair_removal",
    "img" => "https://dslclinic.com/uploads/servicecat/22ju9vGLOOHPGLQs7.webp",
    "col" => 1,
  ],
  [
    "title" => $Tattoo_Removal,
    "cta" => "View pricing",
    "href" => "/pricing/tattoo_removal",
    "img" => "https://dslclinic.com/uploads/servicecat/23Ce8mz76QYS2uQ9F.webp",
    "col" => 1,
  ],
  [
    "title" => $Skin_Treatments,
    "cta" => "View pricing",
    "href" => "/pricing/skin_treatments",
    "img" => "https://dslclinic.com/uploads/servicecat/615ylVi9uLqX7ysOk.webp",
    "col" => 1,
  ],
  [
    "title" => $Body_Sculpting,
    "cta" => "View pricing",
    "href" => "/pricing/body_treatments",
    "img" => "https://dslclinic.com/uploads/servicecat/28ieW7svK4jbmrzut.webp",
    "col" => 1,
  ],
  [
    "title" => $Medical_Injectables,
    "cta" => "View pricing",
    "href" => "/pricing/medical",
    "img" => "https://dslclinic.com/uploads/servicecat/95shKpgl2H20YpjJv.webp",
    "col" => 1,
  ],
  [
    "title" => $Dermatology,
    "cta" => "View pricing",
    "href" => "/pricing/dermatology",
    "img" => "https://dslclinic.com/uploads/servicecat/94IXusT4sGIgyFYz1.webp",
    "col" => 1,
  ]
];
?>

    <!-- Begin your journey / Explore Our Treatments (original implementation) -->
    <section class="treatments" aria-label="Explore our treatments">
      <div class="treatments__inner">
        <p class="treatments__kicker">BEGIN YOUR JOURNEY</p>
        <div class="treatments__head reveal-up">
          <h2 class="treatments__title">Explore Our Treatments</h2>
          <div class="treatments__controls">
            <button class="treatments__btn" type="button" data-treat-prev aria-label="Previous treatments">‹</button>
            <button class="treatments__btn" type="button" data-treat-next aria-label="Next treatments">›</button>
          </div>
        </div>

         <div class="tcarousel" data-treat>
    <div class="tcarousel__track" data-treat-track tabindex="0">

        @foreach($tiles as $index => $tile)

        <article class="tcard" aria-label="{{ $tile['title'] }}">

            {{-- Media --}}
            <div class="tcard__media" style="
                background:
                radial-gradient(700px 520px at 30% 20%, rgba(255,255,255,.62), rgba(255,255,255,0) 60%),
                radial-gradient(620px 420px at 78% 16%, rgba(107,91,210,.35), rgba(107,91,210,0) 62%),
                linear-gradient(135deg, rgba(0,0,0,.10), rgba(0,0,0,0));
            ">

                {{-- Image --}}
                <img 
                    src="{{ $tile['img'] }}" 
                    alt="{{ $tile['title'] }}" 
                    loading="lazy"
                    style="width:100%; height:100%; object-fit:cover;"
                >

            </div>

            {{-- Body --}}
            <div class="tcard__body">

                <h3 class="tcard__title">
                    {!! nl2br(e($tile['title'])) !!}
                </h3>

                <a class="tcard__cta" href="{{ $tile['href'] }}">
                    {{ $tile['cta'] }}
                </a>

            </div>

        </article>

        @endforeach

    </div>

    {{-- Dots --}}
    <div class="treatments__dots">
        @foreach($tiles as $index => $tile)
            <span class="tdot {{ $index == 0 ? 'is-active' : '' }}"></span>
        @endforeach
    </div>
</div>

      </div>
    </section>



    <!-- Proof: Stats + Reels (original, placeholder visuals) -->
    <section class="proof" aria-label="Clinic results and stories">

      <!-- <div class="stats" aria-label="Clinic statistics">
        <div class="stats__inner">
          <div class="stats__text reveal-up">
            <p class="stats__kicker">WHY PATIENTS TRUST DSL CLINIC</p>
            <h2 class="stats__title">Delivering Exceptional Results For Over 20 Years</h2>
            <p class="stats__desc">Combining advanced technology, experienced specialists and personalised care to help
              patients achieve confidence and lasting results.</p>
          </div>
          <div class="stats__grid reveal-up delay-1">
            <div class="stat reveal-up">
              <div class="stat__icon"><svg viewBox="0 0 24 24">
                  <circle cx="12" cy="12" r="10"></circle>
                  <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                  <path d="M2 12h20"></path>
                </svg></div>
              <p class="stat__value">85+</p>
              <p class="stat__label">CLINICS<br>GLOBALLY</p>
            </div>
            <div class="stat reveal-up">
              <div class="stat__icon"><svg viewBox="0 0 24 24">
                  <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                  <circle cx="9" cy="7" r="4"></circle>
                  <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                  <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg></div>
              <p class="stat__value">200+</p>
              <p class="stat__label">QUALIFIED<br>DOCTORS</p>
            </div>
            <div class="stat reveal-up">
              <div class="stat__icon"><svg viewBox="0 0 24 24">
                  <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                  <polyline points="9 12 11 14 15 10"></polyline>
                </svg></div>
              <p class="stat__value">20+</p>
              <p class="stat__label">YEARS IN<br>BUSINESS</p>
            </div>
            <div class="stat reveal-up">
              <div class="stat__icon"><svg viewBox="0 0 24 24">
                  <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                  <circle cx="9" cy="7" r="4"></circle>
                  <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                  <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg></div>
              <p class="stat__value">10<br>Million+</p>
              <p class="stat__label">TREATMENTS<br>DELIVERED</p>
            </div>
          </div>
        </div>
      </div> -->

      <div class="reels" aria-label="Patient stories">
        <div class="reels__inner">
          <div class="reels__head reveal-up">
            <p class="reels__kicker">REAL STORIES. REAL TRANSFORMATIONS.</p>
            <h2 class="reels__title">See Why Thousands Trust DSL Clinic</h2>
          </div>
          <div class="reels__grid reveal-up delay-1">

            <a class="reel" href="javascript:void(0)" aria-label="Play story 1">

    <div class="reel reel__media">
        <iframe
            src="https://www.youtube.com/embed/xxNmtX7nEXs?autoplay=1&mute=1&loop=1&playlist=xxNmtX7nEXs"
            title="YouTube Short"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen style="height: 100%;">
        </iframe>
    </div>

    <div class="reel__caption">
       Sagging Neck? This Non-Surgical Turkey Neck Rescue Will Blow Your Mind!
    </div>

</a>

                    <a class="reel" href="javascript:void(0)" aria-label="Play story 1">

    <div class="reel reel__media">
        <iframe
            src="https://www.youtube.com/embed/GQpZ-L9ZE5s?autoplay=1&mute=1&loop=1&playlist=GQpZ-L9ZE5s"
            title="YouTube Short"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen style="height: 100%;">
        </iframe>
    </div>

    <div class="reel__caption">
      Think Laser Hair Removal Doesn’t Work on Dark Skin? Think Again! Safe, Pain-Free & Super Effective!
    </div>

</a>

                   <a class="reel" href="javascript:void(0)" aria-label="Play story 1">

    <div class="reel reel__media">
        <iframe
            src="https://www.youtube.com/embed/x6h-zILe4NE?autoplay=1&mute=1&loop=1&playlist=x6h-zILe4NE"
            title="YouTube Short"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen style="height: 100%;">
        </iframe>
    </div>

    <div class="reel__caption">
     Laser Hair Removal: Finally, Freedom from Unwanted Hair! #shorts
    </div>

</a>

                   <a class="reel" href="javascript:void(0)" aria-label="Play story 1">

    <div class="reel reel__media">
        <iframe
            src="https://www.youtube.com/embed/BggJOeAR4jk?autoplay=1&mute=1&loop=1&playlist=BggJOeAR4jk"
            title="YouTube Short"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen style="height: 100%;">
        </iframe>
    </div>

    <div class="reel__caption">
      This Skin Tightening Treatment Took 10 Years Off Her Face — Only at Diamond Skin Clinic
    </div>

</a>

          </div>
        </div>
      </div>

    </section>

    <!-- DSL Clinic for all (statement section) -->
    <section class="story" aria-label="Clinic story">
      <div class="story__surface">
        <div class="story__inner">
          <p class="story__kicker">DSL Clinic for all</p>
          <h3 class="story__title">
           With Many Years of Experience, <em>we are proud</em> to be a trusted destination<br />
            for advanced medical aesthetic treatments across Europe.
          </h3>
          <div class="story__ctaRow">
            <a class="story__cta" href="/about">Read our story</a>
          </div>
        </div>
      </div>
    </section>

    <!-- What's new and trending / Featured at DSL Clinic -->
    <section class="featured" aria-label="What's new and trending">
      <div class="featured__inner">
        <p class="featured__kicker">WHAT'S NEW AND TRENDING</p>
        <h2 class="featured__title">Featured at DSL Clinic</h2>

        <div class="featured__grid" aria-label="Featured cards">

         <article class="fcard" aria-label="Get 3 treatments of 3 areas annually, and save 15%" style="background-image: url('{{ asset('uploads/evegrn-anti-wrinkle-exiting.jpg') }}') !important;background-size: cover !important;background-position: center !important;">
          <!-- Replace background-image url below with your real image when ready -->
          <div class="fcard__media" aria-hidden="true"></div>
          <div class="fcard__tag">NEW!</div>
          <div class="fcard__body">
            <h3 class="fcard__headline">Get 3 treatments of<br/>3 areas annually,<br/>and save 15%.</h3>
            <a class="fcard__cta" href="#">Learn More</a>
          </div>
        </article>

        <article class="fcard" aria-label="The next evolution of skincare with SKIN+ Packages" style="background-image:url('https://therapieclinic.com/_next/image?url=%2Fassets%2Foffers%2Foffers%2FusBodyFace.webp&w=1536&q=75') !important;background-size: cover !important;background-position: center !important;">
          <div class="fcard__media" aria-hidden="true"></div>
          <div class="fcard__tag">NEW!</div>
          <div class="fcard__body">
            <h3 class="fcard__headline">The next evolution<br/>of skincare with<br/>SKIN+ Packages</h3>
            <a class="fcard__cta" href="#">Buy Now</a>
          </div>
        </article>

        <article class="fcard" aria-label="We're opening 5 New Clinics Across the UK" style="background-image:url('https://therapieclinic.com/_next/image?url=%2Fassets%2Foffers%2Foffers%2Flower-legs-any-bikini-underarms.webp&w=1536&q=75') !important;background-size: cover !important;background-position: center !important;">
          <div class="fcard__media" aria-hidden="true"></div>
          <div class="fcard__tag">New Clinics!</div>
          <div class="fcard__body">
            <h3 class="fcard__headline">We’re opening 5<br/>New Clinics Across<br/>the UK!</h3>
            <a class="fcard__cta" href="#">Find Your Clinic</a>
          </div>
        </article>

        </div>
      </div>
    </section>

    <!-- Our Locations (like therapie) -->
    <section class="locations" aria-label="Our locations">
      <div class="locations__inner">
        <p class="locations__kicker">FIND A CLINIC NEAR YOU</p>
        <div class="locations__head">
          <h2 class="locations__title">Our Locations</h2>
          <a class="locations__viewall" href="locations">View all</a>
        </div>

        <div class="locations__grid" aria-label="Location cards">

      
@foreach($clinics as $clinic)
    <article class="lcard" aria-label="{{ $clinic->clinic_name }} clinic">
        
        <div class="lcard__media">
            <img 
                src="{{ !empty($clinic->profile) ? asset('uploads/clinic/'.$clinic->profile) : 'https://via.placeholder.com/400x300' }}" 
                alt="{{ $clinic->clinic_name }} clinic" 
                loading="lazy" 
            />
        </div>

        <div class="lcard__body">
            
            <h3 class="lcard__name">{{ $clinic->clinic_name }}</h3>

            <p class="lcard__addr">{{ $clinic->address }}</p>

            <div class="lcard__phone">
                <svg class="lcard__icon" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2a1 1 0 011.01-.24c1.12.37 2.33.57 3.58.57a1 1 0 011 1V20a1 1 0 01-1 1C10.85 21 3 13.15 3 3a1 1 0 011-1h3.5a1 1 0 011 1c0 1.25.2 2.46.57 3.58a1 1 0 01-.24 1.01l-2.21 2.2z"/>
                </svg>
                <span>{{ $clinic->clinic_phone }}</span>
            </div>

            <div class="lcard__footer">
                
                {{-- Google Map --}}
                <a class="lcard__cta" href="{{ $clinic->google_map }}" target="_blank">
                    Get directions
                </a>

               

            </div>

        </div>
    </article>
@endforeach

        </div>
      </div>
    </section>

    <section class="trusted-brands" aria-label="Trusted by Leading Brands">
      <div class="trusted-brands__bg-waves">
        <svg viewBox="0 0 1440 600" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M0,400 C300,300 600,500 900,400 C1200,300 1440,450 1440,450 L1440,600 L0,600 Z" fill="none"
            stroke="rgba(212, 175, 55, 0.1)" stroke-width="2" />
          <path d="M0,450 C350,350 650,550 950,450 C1250,350 1440,500 1440,500 L1440,600 L0,600 Z" fill="none"
            stroke="rgba(212, 175, 55, 0.05)" stroke-width="2" />
          <path d="M0,500 C400,400 700,600 1000,500 C1300,400 1440,550 1440,550 L1440,600 L0,600 Z" fill="none"
            stroke="rgba(212, 175, 55, 0.02)" stroke-width="2" />
        </svg>
      </div>
      <div class="trusted-brands__inner">
        <div class="trusted-brands__header">
          <div class="trusted-brands__kicker">
            <span></span>
            ✦ AS SEEN IN <span></span>
          </div>
          <h2 class="trusted-brands__title">Trusted by Leading Brands</h2>
          <p class="trusted-brands__desc">We are proud to be recognized by industry leaders<br>and featured in top
            publications around the world.</p>
          <div class="trusted-brands__star">✦</div>
        </div>

  <style>
    .trusted-brands__tabs {
      display: flex;
      justify-content: center;
      gap: 15px;
      margin-bottom: 40px;
      flex-wrap: wrap;
    }
    .brand-tab {
      background: #ffffff;
      border: 1px solid rgba(212, 175, 55, 0.3);
      color: #444444;
      padding: 12px 28px;
      border-radius: 30px;
      font-size: 0.95rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
      font-family: var(--font-heading, "Inter", sans-serif);
      letter-spacing: 1px;
      text-transform: uppercase;
      box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .brand-tab:hover {
      background: #fdfaf4;
      border-color: #d4af37;
      color: #b8912e;
      transform: translateY(-2px);
      box-shadow: 0 6px 15px rgba(212, 175, 55, 0.1);
    }
    .brand-tab.active {
      background: #d4af37;
      border-color: #d4af37;
      color: #ffffff;
      box-shadow: 0 6px 15px rgba(212, 175, 55, 0.2);
    }
    .brand-tab-content {
      display: none;
      animation: fadeIn 0.5s ease forwards;
    }
    .brand-tab-content.active {
      display: block;
    }
    .trusted-brands__grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 20px;
      width: 100%;
    }
    .tb-card {
      background: #ffffff;
      border: 1px solid rgba(0, 0, 0, 0.04);
      box-shadow: 0 4px 15px rgba(0,0,0,0.03);
      padding: 20px 20px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
    }
    .tb-card:hover {
      border-color: rgba(212, 175, 55, 0.5);
      box-shadow: 0 8px 25px rgba(212, 175, 55, 0.15);
      transform: translateY(-4px);
    }
    .tb-card span {
      font-size: 0.95rem;
      color: #333333;
      font-weight: 600;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      letter-spacing: 0.3px;
    }
    .hidden-brand {
      display: none !important;
    }
    .view-more-brands {
      grid-column: 1 / -1;
      text-align: center;
      margin-top: 15px;
    }
    .view-more-btn {
      background: transparent;
      border: 1px solid #d4af37;
      color: #b8912e;
      padding: 10px 24px;
      border-radius: 30px;
      font-size: 0.85rem;
      cursor: pointer;
      transition: all 0.3s ease;
      text-transform: uppercase;
      font-family: var(--font-heading, "Inter", sans-serif);
      font-weight: 600;
      letter-spacing: 1px;
    }
    .view-more-btn:hover {
      background: #d4af37;
      color: #ffffff;
      transform: translateY(-2px);
      box-shadow: 0 4px 10px rgba(212, 175, 55, 0.2);
    }
    @media (max-width: 768px) {
      .trusted-brands__grid {
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 15px;
      }
      .brand-tab {
        font-size: 0.85rem;
        padding: 10px 18px;
      }
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(15px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
        <div class="trusted-brands__tabs">
          <button class="brand-tab active" data-target="brand-cat-1">Laser & Device Brands</button>
          <button class="brand-tab" data-target="brand-cat-2">Injectables & Skin</button>
          <button class="brand-tab" data-target="brand-cat-3">Our Own Brand</button>
        </div>

        <div class="brand-tab-content active" id="brand-cat-1">
          <div class="trusted-brands__grid">
            <div class="tb-card">
              <span>Candela (GentleMax Pro)</span>
            </div>
            <div class="tb-card">
              <span>Cynosure</span>
            </div>
            <div class="tb-card">
              <span>PicoWay</span>
            </div>
            <div class="tb-card">
              <span>PicoSure</span>
            </div>
            <div class="tb-card">
              <span>RevLite</span>
            </div>
            <div class="tb-card hidden-brand">
              <span>Fotona</span>
            </div>
            <div class="tb-card hidden-brand">
              <span>Morpheus8</span>
            </div>
            <div class="tb-card hidden-brand">
              <span>Sofwave</span>
            </div>
            <div class="tb-card hidden-brand">
              <span>CoolSculpting</span>
            </div>
            <div class="tb-card hidden-brand">
              <span>Emsculpt Neo</span>
            </div>
            <div class="tb-card hidden-brand">
              <span>EMTONE</span>
            </div>
            <div class="tb-card hidden-brand">
              <span>LaseMD</span>
            </div>
            <div class="tb-card hidden-brand">
              <span>Halo</span>
            </div>
            <div class="tb-card hidden-brand">
              <span>Nordlys</span>
            </div>
            <div class="tb-card hidden-brand">
              <span>Lumenis (M22)</span>
            </div>
            <div class="tb-card hidden-brand">
              <span>Fraxel Dual</span>
            </div>
            <div class="tb-card hidden-brand">
              <span>Endolift</span>
            </div>
            <div class="tb-card hidden-brand">
              <span>Deka (CO2 Laser)</span>
            </div>
            <div class="tb-card hidden-brand">
              <span>Asclepion (Dermablate)</span>
            </div>
            <div class="tb-card hidden-brand">
              <span>HydraFacial</span>
            </div>
            <div class="view-more-brands"><button class="view-more-btn" data-expanded="false">VIEW ALL BRANDS</button></div>
          </div>
        </div>

        <div class="brand-tab-content" id="brand-cat-2">
          <div class="trusted-brands__grid">
            <div class="tb-card">
              <span>Anti-Wrinkle Injections</span>
            </div>
            <div class="tb-card">
              <span>Juvederm</span>
            </div>
            <div class="tb-card">
              <span>Profhilo</span>
            </div>
            <div class="tb-card">
              <span>Dermamelan</span>
            </div>
            <div class="tb-card">
              <span>Cosmelan</span>
            </div>
            <div class="tb-card hidden-brand">
              <span>Aqualyx</span>
            </div>
            <div class="tb-card hidden-brand">
              <span>Sculptra</span>
            </div>
            <div class="tb-card hidden-brand">
              <span>Radiesse</span>
            </div>
            <div class="tb-card hidden-brand">
              <span>Lanluma</span>
            </div>
            <div class="tb-card hidden-brand">
              <span>Exosomes</span>
            </div>
            <div class="tb-card hidden-brand">
              <span>JuveLook</span>
            </div>
            <div class="tb-card hidden-brand">
              <span>Obagi</span>
            </div>
            <div class="tb-card hidden-brand">
              <span>IntraVita</span>
            </div>
            <div class="tb-card hidden-brand">
              <span>Glutathione</span>
            </div>
            <div class="tb-card hidden-brand">
              <span>Bioses</span>
            </div>
            <div class="tb-card hidden-brand">
              <span>Regenera</span>
            </div>
            <div class="tb-card hidden-brand">
              <span>Juliane</span>
            </div>
            <div class="view-more-brands"><button class="view-more-btn" data-expanded="false">VIEW ALL BRANDS</button></div>
          </div>
        </div>

        <div class="brand-tab-content" id="brand-cat-3">
          <div class="trusted-brands__grid">
            <div class="tb-card">
              <span>Diamond Skin Care</span>
            </div>
            <div class="tb-card">
              <span>SPF 50</span>
            </div>
            <div class="tb-card">
              <span>Probiotic Cleanser</span>
            </div>
            <div class="tb-card">
              <span>Post Treatment Recovery Cream</span>
            </div>
            <div class="tb-card">
              <span>Brightening Cream</span>
            </div>
          </div>
        </div>


  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const tabs = document.querySelectorAll('.brand-tab');
      const contents = document.querySelectorAll('.brand-tab-content');
      tabs.forEach(tab => {
        tab.addEventListener('click', () => {
          tabs.forEach(t => t.classList.remove('active'));
          contents.forEach(c => c.classList.remove('active'));
          tab.classList.add('active');
          const target = tab.getAttribute('data-target');
          document.getElementById(target).classList.add('active');
        });
      });

      document.querySelectorAll('.view-more-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
          const tabContent = e.target.closest('.brand-tab-content');
          const isExpanded = e.target.getAttribute('data-expanded') === 'true';
          const cards = tabContent.querySelectorAll('.tb-card:nth-child(n+6)');
          
          if (isExpanded) {
            // Collapse
            cards.forEach(card => card.classList.add('hidden-brand'));
            e.target.innerText = 'VIEW ALL BRANDS';
            e.target.setAttribute('data-expanded', 'false');
          } else {
            // Expand
            cards.forEach(card => card.classList.remove('hidden-brand'));
            e.target.innerText = 'VIEW LESS';
            e.target.setAttribute('data-expanded', 'true');
          }
        });
      });
    });
  </script>


    </section>

    <!-- Video modal (UI placeholder) -->
    <div class="vmodal" id="vmodal" aria-hidden="true">
      <div class="vmodal__backdrop" data-vclose></div>
      <div class="vmodal__panel" role="dialog" aria-modal="true" aria-label="Video preview">
        <div class="vmodal__top">
          <p class="vmodal__title">Video preview</p>
          <button class="vmodal__close" type="button" aria-label="Close" data-vclose>✕</button>
        </div>
        <div class="vmodal__body">
          <div class="vmodal__placeholder" id="vmodalText">
            <strong>Placeholder video</strong>
            <p>This is a UI-only preview. You can replace this with your own MP4 files later and we’ll wire up real
              playback.</p>
          </div>
        </div>
      </div>
    </div>

  </main>

@include('frontend.partials.footer')

<script>
  (function(){
    const track = document.querySelector('[data-offers-track]');
    const prev = document.querySelector('[data-offers-prev]');
    const next = document.querySelector('[data-offers-next]');
    const dots = Array.from(document.querySelectorAll('.carousel__dots .dot'));

    if(!track) return;

    const getCardWidth = () => {
      const card = track.querySelector('.offer');
      if(!card) return 320;
      const styles = window.getComputedStyle(track);
      const gap = parseFloat(styles.columnGap || styles.gap || '18') || 18;
      return card.getBoundingClientRect().width + gap;
    };

    const scrollByCard = (dir) => {
      track.scrollBy({ left: dir * getCardWidth(), behavior: 'smooth' });
    };

    prev && prev.addEventListener('click', () => scrollByCard(-1));
    next && next.addEventListener('click', () => scrollByCard(1));

    // Update dots based on nearest card
    const updateDots = () => {
      const cards = Array.from(track.querySelectorAll('.offer'));
      if(!cards.length || !dots.length) return;
      const left = track.scrollLeft;
      const w = getCardWidth();
      const idx = Math.max(0, Math.min(cards.length - 1, Math.round(left / w)));
      dots.forEach((d,i) => d.classList.toggle('is-active', i === idx));
    };

    track.addEventListener('scroll', () => {
      window.requestAnimationFrame(updateDots);
    }, {passive:true});

    // Keyboard support
    track.addEventListener('keydown', (e) => {
      if(e.key === 'ArrowRight') { e.preventDefault(); scrollByCard(1); }
      if(e.key === 'ArrowLeft') { e.preventDefault(); scrollByCard(-1); }
    });

    updateDots();
  })();

  (function(){
    const track = document.querySelector('[data-treat-track]');
    const prev = document.querySelector('[data-treat-prev]');
    const next = document.querySelector('[data-treat-next]');
    const dots = Array.from(document.querySelectorAll('.treatments__dots .tdot'));

    if(!track) return;

    const getCardWidth = () => {
      const card = track.querySelector('.tcard');
      if(!card) return 360;
      const styles = window.getComputedStyle(track);
      const gap = parseFloat(styles.columnGap || styles.gap || '18') || 18;
      return card.getBoundingClientRect().width + gap;
    };

    const scrollByCard = (dir) => {
      track.scrollBy({ left: dir * getCardWidth(), behavior: 'smooth' });
    };

    prev && prev.addEventListener('click', () => scrollByCard(-1));
    next && next.addEventListener('click', () => scrollByCard(1));

    const updateDots = () => {
      const cards = Array.from(track.querySelectorAll('.tcard'));
      if(!cards.length || !dots.length) return;
      const left = track.scrollLeft;
      const w = getCardWidth();
      const idx = Math.max(0, Math.min(cards.length - 1, Math.round(left / w)));
      dots.forEach((d,i) => d.classList.toggle('is-active', i === idx));
    };

    track.addEventListener('scroll', () => {
      window.requestAnimationFrame(updateDots);
    }, {passive:true});

    track.addEventListener('keydown', (e) => {
      if(e.key === 'ArrowRight') { e.preventDefault(); scrollByCard(1); }
      if(e.key === 'ArrowLeft') { e.preventDefault(); scrollByCard(-1); }
    });

    updateDots();
  })();
  (function(){
    const modal = document.getElementById('vmodal');
    const text = document.getElementById('vmodalText');
    const closeEls = modal ? modal.querySelectorAll('[data-vclose]') : [];
    const reels = Array.from(document.querySelectorAll('[data-reel]'));

    if(!modal || !text || !reels.length) return;

    const setOpen = (open) => {
      modal.classList.toggle('is-open', open);
      modal.setAttribute('aria-hidden', open ? 'false' : 'true');
      document.documentElement.style.overflow = open ? 'hidden' : '';
    };

    reels.forEach((a) => {
      a.addEventListener('click', (e) => {
        e.preventDefault();
        const msg = a.getAttribute('data-reel') || 'Video preview';
        text.innerHTML = `
          <strong>Placeholder video</strong>
          <p>${msg}</p>
          <p style="opacity:.85">(Replace with your own videos later — this section is ready.)</p>
        `;
        setOpen(true);
      });
    });

    closeEls.forEach(el => el.addEventListener('click', () => setOpen(false)));

    document.addEventListener('keydown', (e) => {
      if(e.key === 'Escape' && modal.classList.contains('is-open')) setOpen(false);
    });
  })();
</script>
  
  <script>
    (function () {
      const track = document.querySelector('[data-offers-track]');
      const prev = document.querySelector('[data-offers-prev]');
      const next = document.querySelector('[data-offers-next]');
      const dots = Array.from(document.querySelectorAll('.carousel__dots .dot'));

      if (!track) return;

      const getCardWidth = () => {
        const card = track.querySelector('.offer');
        if (!card) return 320;
        const styles = window.getComputedStyle(track);
        const gap = parseFloat(styles.columnGap || styles.gap || '18') || 18;
        return card.getBoundingClientRect().width + gap;
      };

      const scrollByCard = (dir) => {
        track.scrollBy({ left: dir * getCardWidth(), behavior: 'smooth' });
      };

      prev && prev.addEventListener('click', () => scrollByCard(-1));
      next && next.addEventListener('click', () => scrollByCard(1));

      // Update dots based on nearest card
      const updateDots = () => {
        const cards = Array.from(track.querySelectorAll('.offer'));
        if (!cards.length || !dots.length) return;
        const left = track.scrollLeft;
        const w = getCardWidth();
        const idx = Math.max(0, Math.min(cards.length - 1, Math.round(left / w)));
        dots.forEach((d, i) => d.classList.toggle('is-active', i === idx));
      };

      track.addEventListener('scroll', () => {
        window.requestAnimationFrame(updateDots);
      }, { passive: true });

      // Keyboard support
      track.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowRight') { e.preventDefault(); scrollByCard(1); }
        if (e.key === 'ArrowLeft') { e.preventDefault(); scrollByCard(-1); }
      });

      updateDots();
    })();

    (function () {
      const track = document.querySelector('[data-treat-track]');
      const prev = document.querySelector('[data-treat-prev]');
      const next = document.querySelector('[data-treat-next]');
      const dots = Array.from(document.querySelectorAll('.treatments__dots .tdot'));

      if (!track) return;

      const getCardWidth = () => {
        const card = track.querySelector('.tcard');
        if (!card) return 360;
        const styles = window.getComputedStyle(track);
        const gap = parseFloat(styles.columnGap || styles.gap || '18') || 18;
        return card.getBoundingClientRect().width + gap;
      };

      const scrollByCard = (dir) => {
        track.scrollBy({ left: dir * getCardWidth(), behavior: 'smooth' });
      };

      prev && prev.addEventListener('click', () => scrollByCard(-1));
      next && next.addEventListener('click', () => scrollByCard(1));

      const updateDots = () => {
        const cards = Array.from(track.querySelectorAll('.tcard'));
        if (!cards.length || !dots.length) return;
        const left = track.scrollLeft;
        const w = getCardWidth();
        const idx = Math.max(0, Math.min(cards.length - 1, Math.round(left / w)));
        dots.forEach((d, i) => d.classList.toggle('is-active', i === idx));
      };

      track.addEventListener('scroll', () => {
        window.requestAnimationFrame(updateDots);
      }, { passive: true });

      track.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowRight') { e.preventDefault(); scrollByCard(1); }
        if (e.key === 'ArrowLeft') { e.preventDefault(); scrollByCard(-1); }
      });

      updateDots();
    })();
    (function () {
      const modal = document.getElementById('vmodal');
      const text = document.getElementById('vmodalText');
      const closeEls = modal ? modal.querySelectorAll('[data-vclose]') : [];
      const reels = Array.from(document.querySelectorAll('[data-reel]'));

      if (!modal || !text || !reels.length) return;

      const setOpen = (open) => {
        modal.classList.toggle('is-open', open);
        modal.setAttribute('aria-hidden', open ? 'false' : 'true');
        document.documentElement.style.overflow = open ? 'hidden' : '';
      };

      reels.forEach((a) => {
        a.addEventListener('click', (e) => {
          e.preventDefault();
          const msg = a.getAttribute('data-reel') || 'Video preview';
          text.innerHTML = `
          <strong>Placeholder video</strong>
          <p>${msg}</p>
          <p style="opacity:.85">(Replace with your own videos later — this section is ready.)</p>
        `;
          setOpen(true);
        });
      });

      closeEls.forEach(el => el.addEventListener('click', () => setOpen(false)));

      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.classList.contains('is-open')) setOpen(false);
      });
    })();
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.15
      };

      const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('in-view');
            observer.unobserve(entry.target);
          }
        });
      }, observerOptions);

      document.querySelectorAll('.reveal-up').forEach(el => {
        observer.observe(el);
      });
    });
  </script>

























  <!-- ================= PREMIUM UI OVERRIDES ================= -->
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">

  <!-- ================= END PREMIUM UI ================= -->

























</body>

</html>