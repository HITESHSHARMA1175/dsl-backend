
<?php 
if(session('app_locale')=='cn'){
    $how_to_book = 'بک کرنے کا طریقہ';
    $Book_your_free_in = 'اپنا مفت کلینک، فون یا ویڈیو مشاورت بک کریں۔';
    $Book_Consultation = 'کتابی مشاورت';
    $Call_Us_Today = 'ہمیں آج ہی کال کریں۔';
    $Visit_one_of_our_clinics = 'ہمارے کلینک میں سے کسی ایک کا دورہ کریں۔';
    $in_London = 'لندن میں';
    $View_map = 'نقشہ دیکھیں';
    $Book_Free_Consultation = 'کتاب مفت مشاورت';
}elseif(session('app_locale')=='ar'){
    $how_to_book = 'كيفية الحجز';
    $Book_your_free_in = 'احجز استشارتك المجانية في العيادة أو عبر الهاتف أو الفيديو';
    $Book_Consultation = 'استشارة كتابية';
    $Call_Us_Today = 'اتصل بنا اليوم';
    $Visit_one_of_our_clinics = 'قم بزيارة إحدى عياداتنا';
    $in_London = 'في لندن';
    $View_map = 'عرض الخريطة';
    $Book_Free_Consultation = 'احجز استشارة مجانية';
}else{
    $how_to_book = 'how-to-book';
    $Book_your_free_in = 'Book your free in-clinic, phone or video consultation';
    $Book_Consultation = 'Book Consultation';
    $Call_Us_Today = 'Call Us Today';
    $Visit_one_of_our_clinics = 'Visit one of our clinics';
    $in_London = 'in London';
    $View_map = 'View map';
    $Book_Free_Consultation = 'Book Free Consultation';
}
?>     
<style>
    .footer-popup {
    position: fixed;
    bottom: 0;
    width: 100%;
    left: 0;
    transform: translateY(262px);
    transition: 0.5s;
    text-align: center;
    background: #55bba8;
}
.closebtn {
    position: absolute;
    right: 2px;
    top: -2px;
    background: #fff;
    border-radius: 50px;
    width: 20px;
    height: 20px;
    display: flex
;
    justify-content: center;
    box-shadow: 0px 0px 5px 0px gray;
;
    justify-content: center;
}
.closebtn svg {
    padding-top: 2px;
}
.footer-popup img {
    width: 100%;
}
#submit-button {
    width: 100%;
    margin-top: 30px;
}
</style>
    @if(!session('footerPopupClosed'))
    <div class="footer-popup" id="popupFooter">

       
        <div class="position-relative">
            <a href="javascript:void(0)" class="closebtn"><i class="fa-solid fa-xmark"></i></a>
        </div>

        <img class="laptop-view-image" src="{{asset('frontend/images/Diamond-Skin.webp')}}" alt="" onclick="window.location.href='{{ url('book-free-consultation') }}'" style="cursor: pointer;">

        <img class="mobile-view-image" src="{{asset('frontend/images/skinbodyhairs.jpeg')}}" alt="" onclick="window.location.href='{{ url('book-free-consultation') }}'" style="cursor: pointer;">
       

    </div>
    @endif
    <div class="footer-button">
        <a href="{{ url('book-free-consultation') }}" class="bookbtn bigbtn primary-btn btn">{{ $Book_Free_Consultation }}</a>
        <a href="https://wa.me/message/UUVVIUDNUOIUM1" class="whatsappbtn"><img src="{{asset('frontend/images/whatsapp-img.jpg')}}" /></a>
    </div>
    <section class="how-to-book">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-4">
                    <h2>{{ $how_to_book }}</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="how-to-book-box text-center mb-lg-0 mb-4">
                        <img src="{{ asset('frontend/images/consultation-free.png') }}" alt="">
                        <p>{{ $Book_your_free_in }}</p>
                        <a href="{{ url('book-free-consultation') }}" class="bigbtn primary-btn btn">{{ $Book_Consultation }}</a>
                    </div>

                </div>
                <div class="col-lg-4">

                    <div class="how-to-book-box text-center mb-lg-0 mb-4">
                        <img src="{{ asset('frontend/images/today-call.png') }}" alt="">
                        <p>{{ $Call_Us_Today }}</p>
                        @foreach ($menudata['clinics'] as $item)
                        <a href="{{ url('book-free-consultation') }}" class="bigbtn primary-btn btn">{{ $item->clinic_name }}</a><br>
                        @endforeach
                    </div>

                </div>
                <div class="col-lg-4">

                    <div class="how-to-book-box text-center mb-lg-0 mb-4">
                        <img src="{{ asset('frontend/images/clinics-visit.png') }}" alt="">
                        <p>{{ $Visit_one_of_our_clinics }} <br>
                            {{ $in_London }}</p>
                        <a target="_blank" href="https://www.google.com/maps/place//data=!4m3!3m2!1s0x487613dc0e682e31:0x72bf47c04f17b6c!12e1" class="bigbtn primary-btn btn">{{ $View_map }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen " style="margin-top:57px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="searchModalLabel">Search</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body overflow-auto">
                <div class="position-relative">
                    <form class="d-flex" role="search" action="{{ url('homesearchbox') }}" method="post">
                        @csrf
                        <input class="form-control me-2" type="search" name="searchbox" id="searchbox" placeholder="Search" aria-label="Search" onkeyup="searchResult()">
                        <button class="btn btn-outline-primary" type="submit">Search</button>
                    </form>
                
                    <!-- Search Results Dropdown -->
                    <div id="search_result_box" class="searchwp-live-search-results searchwp-live-search-results-showing border rounded bg-white shadow mt-2 p-2 w-100 " style="display: none;">
                        
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-6">
                        <div class="mt-3">
                            <h6>Popular Searches:</h6>
                            <div class="d-flex flex-wrap gap-2">
                                @php
                                use App\Models\Search;
                                $searchResults = Search::select('searchbox')->distinct()->limit(12)->get();
                                @endphp
                                @foreach($searchResults as $result)
                                <a href="https://dslclinic.com/homesearchbox?searchbox={{ $result->searchbox }}" class="btn btn-light">{{ $result->searchbox }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mt-4">
                            <h6>Services Options:</h6>
                            <div class="row">
                                @php
                                use App\Models\PropertyCategory;
                                $serviceResults = PropertyCategory::inRandomOrder()->where('parent_id', '0')->where('status', '1')->limit(6)->get();
                                @endphp
                                @foreach($serviceResults as $result)
                                <div class="col-md-4 col-6 mb-2">
                                    <a href="{{ url('/' . $result->category_slug) }}" class="text-decoration-none">
                                        <img style="height: 125px;" src="{{ (!empty($result->icon) ? asset('uploads/servicecat/' . $result->icon) : asset('uploads/addon/96PVtJZCXGwMZ4ejf.jpg')) }}" class="img-fluid rounded" alt="{{ $result->category_name }}">
                                        <div class="text-center">{{ $result->category_name }}</div>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    
function hidePopup() {
    //alert(lang);
    return $.ajax({
        url: "{{ route('hidePopup') }}",
        type: 'POST',
        data: {
            "_token": "{{ csrf_token() }}"
        },
        beforeSend: function() {
           
        },
        success: function(res) {
            console.log(res.abc);
            if (res.status === 'success') {
                $('#popupFooter').hide();
            } else {
                alert('Something went wrong. Please try again.');
            }
        },
        error: function(err) {
            console.error('AJAX error:', err);
            alert('An error occurred while communicating with the server.');
        }
    });
}

function changeLanguage(lang) {
    //alert(lang);
    return $.ajax({
        url: "{{ route('changeLanguage') }}",
        type: 'POST',
        data: {
            "_token": "{{ csrf_token() }}",
            lang: lang,
        },
        beforeSend: function() {
           
        },
        success: function(res) {
            console.log(res.abc);
            if (res.status === 'success') {
                
                location.reload(); // Reload the page to apply the new language
               
            } else {
                console.error('Failed to update the cart:', res.message);
                alert('Something went wrong. Please try again.');
            }
        },
        error: function(err) {
            console.error('AJAX error:', err);
            alert('An error occurred while communicating with the server.');
        }
    });
}

function searchResult() {
    
    var searchbox = $('#searchbox').val();
    
    if (searchbox !== '') {
        $('#search_result_box').show();
    } else {
        $('#search_result_box').hide();
    }
    
    return $.ajax({
        url: "{{ route('searchResult') }}",
        type: 'POST',
        data: {
            "_token": "{{ csrf_token() }}",
            searchbox: searchbox,
        },
        beforeSend: function() {
           $('#search_result_box').html('<div class="searchwp-live-search-result p-2 text-center"><img src="https://i.gifer.com/4V0b.gif" alt="Loading..." style="width: 43px;"></div>');
        },
        success: function(res) {
            console.log(res.abc);
            if (res.status === 'success') {
                
                $('#search_result_box').html(res.abc);
               
            } else {
                console.error('Failed to update the cart:', res.message);
                alert('Something went wrong. Please try again.');
            }
        },
        error: function(err) {
            console.error('AJAX error:', err);
            alert('An error occurred while communicating with the server.');
        }
    });
}

    
</script> 

@if(session('app_locale')=='cn')
<footer>
        <section class="bg-logo">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 text-center">
                        <h2 class="text-white">جیسا کہ دیکھا گیا ہے۔</h2>
                    </div>
                    <div class="col-12">
                        <img class="d-lg-block d-none" src="{{ asset('frontend/images/2.webp') }}" alt="">
                        <img class="d-lg-none d-block" src="{{ asset('frontend/images/346-by-400-pixels.webp') }}" alt="">
                    </div>
                </div>
            </div>
        </section>
        <section class="clients-say">
            <div class="container">
                <div class="row">
                    <div class="col-12 mb-4 text-center">
                        <h2>ہمارے کلائنٹس کیا کہتے ہیں۔</h2>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-lg-4">
                        <div class="clients-box">
                            <iframe src="https://www.youtube.com/embed/NQontDfDIF8?si=z9Ji2kQpRpy5o57u"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            <p>21 اور فراون لائنز؟! اینٹی شیکن انجیکشن</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="clients-box">
                            <iframe src="https://www.youtube.com/embed/wECJb9p-EGM?si=u5X7yZQpH16O_PHn"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            <p>لیزر سے بالوں کو ہٹانا - جلد کی تمام اقسام - Candela gentle max pro</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="clients-box">
                            <iframe src="https://www.youtube.com/embed/8LhFgwvxPgM?si=HwbP_YU0zMeM-IRe"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            <p>میک اپ بمقابلہ جلد: وہ حقیقت جو آپ کو جاننے کی ضرورت ہے۔</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="clinics">
                        <div class="footer-single-clinic">
                            <p class="name"> Wembley</p>
                            <p class="phone"> <a href="tel:02075235158"> 02080040277 </a></p>
                            <p class="phone"> <a href="tel:03301131130"> 03301131130 </a></p>
                            <p class=""> <a href="mailto:hello@dslclinic.com"> hello@dslclinic.com </a></p>
                            <address> <a href="https://maps.app.goo.gl/AMt3AnMvraaXimYb6" target="_blank" rel="noopener"> 348 High Road Wembley HA9 6AZ </a> </address>
                        </div>
                        <div class="footer-single-clinic">
                            <p class="name"> Ladbroke Grove</p>
                            <p class="phone"> <a href="tel:02075938055"> 02080040277 </a></p>
                            <p class="phone"> <a href="tel:03301131130"> 03301131130 </a></p>
                            <p class=""> <a href="mailto:hello@dslclinic.com"> hello@dslclinic.com </a></p>

                            <address> <a href="https://maps.app.goo.gl/VfdEAPWeYnMSytdB8" target="_blank" rel="noopener">758 HARROW ROAD North Kensington NW10 5LE</a>
                            </address>
                        </div>
                        <div class="footer-single-clinic">
                            <p class="name"> Harley Street</p>
                            <p class="phone"> <a href="tel:02080040277"> 02080040277 </a></p>
                            <p class="phone"> <a href="tel:03301131130"> 03301131130 </a></p>
                            <p class=""> <a href="mailto:hello@dslclinic.com"> hello@dslclinic.com </a></p>

                            <address> <a href="https://maps.app.goo.gl/XTrCGykKCiDPSDUy6" target="_blank" rel="noopener"> 102 Harley Street W1G 7JB </a>
                            </address>
                        </div>
                        <div class="footer-single-clinic">
                            <p class="name">Knightsbridge                            </p>
                            <p class="phone"> <a href="tel:01614640694"> 02080040277 </a></p>
                            <p class="phone"> <a href="tel:03301131130"> 03301131130 </a></p>
                            <p class=""> <a href="mailto:hello@dslclinic.com"> hello@dslclinic.com </a></p>

                            <address> <a href="https://maps.app.goo.gl/fWu6bF2MgiVH9eLy5" target="_blank" rel="noopener"> KNIGHTSBRIDGE 20 Beauchamp Place Knightsbridge SW3 1NQ</a> </address>
                        </div>
                        
                    </div>
                </div>
                <div class="col-lg-4">
                    <div>
                        <div id="sidebar-footer-new" class="sidebar" role="complementary">
                            <div id="text-23" class="widget widget_text">
                                <h2 class="widgettitle p">Helpful Links</h2>
                                <div class="textwidget">
                                    <ul>
                                        <li>
                                            <h3>Popular Treatments</h3>
                                        </li>
                                        <li><a title="Laser Hair Removal" href="{{ url('/laser-hair-removal-london') }}" >لیزر سے بالوں کو ہٹانا</a></li>
                                        <li><a title="Bum and Hip fillers" href="{{ url('/bum-and-hip-fillers') }}" >بوم اور ہپ فلرز</a></li>
                                        <li><a title="Anti-Wrinkle Injections" href="{{ url('/anti-wrinkle-injections') }}" >اینٹی شیکن انجیکشن</a></li>
                                        <li><a title="Stretch Mark Removal" href="{{ url('/stretch-mark-treatment') }}" >اسٹریچ مارک کو ہٹانا</a></li>
                                        <li><a title="Microblading" href="{{ url('/microblading') }}" >مائیکرو بلیڈنگ</a></li>
                                        
                                    </ul>
                                    <ul>
                                        <li><a title="Fat Reduction" href="{{ url('/fat-reduction') }}">چربی میں کمی</a></li>
                                        <li><a title="Pigmentations" href="{{ url('/pigmentation-removal-treatment') }}">پگمنٹیشن ہٹانا</a></li>
                                        <li><a title="Anti Ageing" href="{{ url('/eyes-area-boosters') }}">آنکھوں کے علاقے کو بڑھانے والے</a>
                                        </li>
                                        <li>
                                            <h3>Quick Links</h3>
                                        </li>
                                        <li><a title="About DSL Clinic" href="{{ url('about') }}">ہمارے بارے میں</a> |
                                            <a title="Contact" href="{{ url('book-free-consultation') }}">رابطہ کریں۔</a>
                                        </li>
                                        <li><a title="Blog" href="{{ url('blog') }}">بلاگ</a> | <a title="Terms Conditions"
                                                href="{{ url('terms-conditions') }}">شرائط کی شرائط</a></li>
                                    </ul>
                                </div>

                            </div>


                        </div>

                    </div>
                    <div class="social-icon">
                        <ul>
                            <li>
                                <a href="https://www.facebook.com/diamondskinuk/" class="icon-so facebook"><img src="{{ asset('frontend/images/facebook.png') }}" alt=""></a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/diamondskin.uk/" class="icon-so insata"><img src="{{ asset('frontend/images/insata.png') }}" alt=""></a>
                            </li>
                            <li>
                                <a href="https://www.youtube.com/@dslclinicuk" class="icon-so youtube-i"><img src="{{ asset('frontend/images/icon-sprites-you.png') }}" alt=""></a>
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
                <div class="col-lg-2">
                    <div class="footer-contact--logo">
                        <img src="{{ asset('frontend/images/Diamond Skin.png') }}"
                            class="attachment-medium size-medium entered lazyloaded" alt="Care Quality Commission logo"
                            data-ll-status="loaded">
                        <noscript><img width="105" height="33"
                                src="{{ asset('frontend/images/Diamond Skin.png') }}"
                                class="attachment-medium size-medium" /></noscript>
                    </div>
                </div>
            </div>
            <div class="row bottom-footer">
                <div class="col-12">
                    <div id="sidebar-footer" class="sidebar cf" role="complementary">
                        <div id="nav_menu-16" class="widget widget_nav_menu">
                            <!-- <p class="widgettitle hidden">Footer Navigation Links</p> -->
                            <div class="menu-footer-navigation-container">
                                <ul id="menu-footer-navigation" class="menu">
                                    
                                    <li id="menu-item-7407"
                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-7407">
                                        <a href="{{ url('blog') }}">علاج کا بلاگ</a></li>
                                    <li id="menu-item-24173"
                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-24173">
                                        <a href="{{ url('about') }}">ہمارے بارے میں</a></li>
                                    <li id="menu-item-12844"
                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-12844">
                                        <a href="{{ url('privacy-policy') }}">رازداری کی پالیسی</a></li>
                                    <li id="menu-item-12845"
                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-12845">
                                        <a href="{{ url('terms-conditions') }}">شرائط و ضوابط</a></li>
                                </ul>
                            </div>
                        </div>
                        <div id="text-20" class="widget widget_text">
                            <!-- <p class="widgettitle hidden">Copyright</p> -->
                            <div class="textwidget">
<p>
  Copyright © 2025 Doctor Skin Clinic Ltd. All rights reserved.
  Design & Developed by 
  <a href="https://devolyt.com/" class="devolyt-link">
    <strong>Devolyt Technologies</strong>
  </a>
  <br>
  Company House Details: DOCTOR SKIN CLINIC LIMITED, Company Number: 14614894, Registered Address: 758 Harrow Road Harrow Road, London, England, NW10 5LE  
</p>

<style>
  .devolyt-link{
    color:#0c53d8; /* blue link color */
    font-weight:700;
    text-decoration:none;
  }
  .devolyt-link:hover{
    text-decoration:underline;
  }
</style>

                                <p>Doctor Skin Clinic Ltd T/A DSL کلینک فنانشل کنڈکٹ اتھارٹی کے ذریعہ مجاز اور منظم ہے۔</p>
                                <p>ہم ایک کریڈٹ بروکر کے طور پر کام کرتے ہیں، قرض دہندہ کے طور پر نہیں اور Klarna سے 3 میں فنانس کی پیشکش کرتے ہیں Klarna (یورپ) کا تجارتی نام ہے۔ شرائط و ضوابط لاگو ہیں۔ شکایات کا طریقہ کار۔</p>
                                <p>DSL کلینک (UK) LTD Klarna سے مالیاتی مصنوعات پیش کرنے والے کریڈٹ بروکر کے طور پر کام کر رہا ہے۔ DSL کلینک (UK) LTD فنانشل کنڈکٹ اتھارٹی کے ذریعہ مجاز اور ریگولیٹ ہے۔ کریڈٹ اسٹیٹس سے مشروط ہے۔ شکایات کا طریقہ کار۔</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
@elseif(session('app_locale')=='ar')
<footer>
        <section class="bg-logo">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 text-center">
                        <h2 class="text-white">كما رأينا في</h2>
                    </div>
                    <div class="col-12">
                        <img class="d-lg-block d-none" src="{{ asset('frontend/images/2.webp') }}" alt="">
                        <img class="d-lg-none d-block" src="{{ asset('frontend/images/346-by-400-pixels.webp') }}" alt="">
                    </div>
                </div>
            </div>
        </section>
        <section class="clients-say">
            <div class="container">
                <div class="row">
                    <div class="col-12 mb-4 text-center">
                        <h2>ماذا يقول عملاؤنا</h2>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-lg-4">
                        <div class="clients-box">
                            <iframe src="https://www.youtube.com/embed/NQontDfDIF8?si=z9Ji2kQpRpy5o57u"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            <p>٢١ وخطوط العبوس؟! حقن مضادة للتجاعيد</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="clients-box">
                            <iframe src="https://www.youtube.com/embed/wECJb9p-EGM?si=u5X7yZQpH16O_PHn"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            <p>إزالة الشعر بالليزر - جميع أنواع البشرة - جهاز كانديلا جنتل ماكس برو</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="clients-box">
                            <iframe src="https://www.youtube.com/embed/8LhFgwvxPgM?si=HwbP_YU0zMeM-IRe"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            <p>المكياج مقابل البشرة: الحقيقة التي تحتاج إلى معرفتها</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="clinics">
                        <div class="footer-single-clinic">
                            <p class="name"> Wembley</p>
                            <p class="phone"> <a href="tel:02075235158"> 02080040277 </a></p>
                            <p class="phone"> <a href="tel:03301131130"> 03301131130 </a></p>
                            <p class=""> <a href="mailto:hello@dslclinic.com"> hello@dslclinic.com </a></p>
                            <address> <a href="https://maps.app.goo.gl/AMt3AnMvraaXimYb6" target="_blank" rel="noopener"> 348 High Road Wembley HA9 6AZ </a> </address>
                        </div>
                        <div class="footer-single-clinic">
                            <p class="name"> Ladbroke Grove</p>
                            <p class="phone"> <a href="tel:02075938055"> 02080040277 </a></p>
                            <p class="phone"> <a href="tel:03301131130"> 03301131130 </a></p>
                            <p class=""> <a href="mailto:hello@dslclinic.com"> hello@dslclinic.com </a></p>

                            <address> <a href="https://maps.app.goo.gl/VfdEAPWeYnMSytdB8" target="_blank" rel="noopener">758 HARROW ROAD North Kensington NW10 5LE</a>
                            </address>
                        </div>
                        <div class="footer-single-clinic">
                            <p class="name"> Harley Street</p>
                            <p class="phone"> <a href="tel:02080040277"> 02080040277 </a></p>
                            <p class="phone"> <a href="tel:03301131130"> 03301131130 </a></p>
                            <p class=""> <a href="mailto:hello@dslclinic.com"> hello@dslclinic.com </a></p>

                            <address> <a href="https://maps.app.goo.gl/XTrCGykKCiDPSDUy6" target="_blank" rel="noopener"> 102 Harley Street W1G 7JB </a>
                            </address>
                        </div>
                        <div class="footer-single-clinic">
                            <p class="name">Knightsbridge                            </p>
                            <p class="phone"> <a href="tel:01614640694"> 02080040277 </a></p>
                            <p class="phone"> <a href="tel:03301131130"> 03301131130 </a></p>
                            <p class=""> <a href="mailto:hello@dslclinic.com"> hello@dslclinic.com </a></p>

                            <address> <a href="https://maps.app.goo.gl/fWu6bF2MgiVH9eLy5" target="_blank" rel="noopener"> KNIGHTSBRIDGE 20 Beauchamp Place Knightsbridge SW3 1NQ</a> </address>
                        </div>
                        
                    </div>
                </div>
                <div class="col-lg-4">
                    <div>
                        <div id="sidebar-footer-new" class="sidebar" role="complementary">
                            <div id="text-23" class="widget widget_text">
                                <h2 class="widgettitle p">روابط مفيدة</h2>
                                <div class="textwidget">
                                    <ul>
                                        <li>
                                            <h3>العلاجات الشعبية</h3>
                                        </li>
                                        <li><a title="Laser Hair Removal" href="{{ url('/laser-hair-removal-london') }}" >إزالة الشعر بالليزر</a></li>
                                        <li><a title="Bum and Hip fillers" href="{{ url('/bum-and-hip-fillers') }}" >حشوات المؤخرة والورك</a></li>
                                        <li><a title="Anti-Wrinkle Injections" href="{{ url('/anti-wrinkle-injections') }}" >حقن مضادة للتجاعيد</a></li>
                                        <li><a title="Stretch Mark Removal" href="{{ url('/stretch-mark-treatment') }}" >إزالة علامات التمدد</a></li>
                                        <li><a title="Microblading" href="{{ url('/microblading') }}" >مايكرو بليدنج</a></li>
                                        
                                    </ul>
                                    <ul>
                                        <li><a title="Fat Reduction" href="{{ url('/fat-reduction') }}">تقليل الدهون</a></li>
                                        <li><a title="Pigmentations" href="{{ url('/pigmentation-removal-treatment') }}">إزالة التصبغات</a></li>
                                        <li><a title="Anti Ageing" href="{{ url('/eyes-area-boosters') }}">معززات منطقة العين</a>
                                        </li>
                                        <li>
                                            <h3>Quick Links</h3>
                                        </li>
                                        <li><a title="About DSL Clinic" href="{{ url('about') }}">معلومات عنا</a> |
                                            <a title="Contact" href="{{ url('book-free-consultation') }}">اتصال</a>
                                        </li>
                                        <li><a title="Blog" href="{{ url('blog') }}">مدونة</a> | <a title="Terms Conditions"
                                                href="{{ url('terms-conditions') }}">الشروط والأحكام</a></li>
                                    </ul>
                                </div>

                            </div>


                        </div>

                    </div>
                    <div class="social-icon">
                        <ul>
                            <li>
                                <a href="https://www.facebook.com/diamondskinuk/" class="icon-so facebook"><img src="{{ asset('frontend/images/facebook.png') }}" alt=""></a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/diamondskin.uk/" class="icon-so insata"><img src="{{ asset('frontend/images/insata.png') }}" alt=""></a>
                            </li>
                            <li>
                                <a href="https://www.youtube.com/@dslclinicuk" class="icon-so youtube-i"><img src="{{ asset('frontend/images/icon-sprites-you.png') }}" alt=""></a>
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
                <div class="col-lg-2">
                    <div class="footer-contact--logo">
                        <img src="{{ asset('frontend/images/Diamond Skin.png') }}"
                            class="attachment-medium size-medium entered lazyloaded" alt="Care Quality Commission logo"
                            data-ll-status="loaded">
                        <noscript><img width="105" height="33"
                                src="{{ asset('frontend/images/Diamond Skin.png') }}"
                                class="attachment-medium size-medium" /></noscript>
                    </div>
                </div>
            </div>
            <div class="row bottom-footer">
                <div class="col-12">
                    <div id="sidebar-footer" class="sidebar cf" role="complementary">
                        <div id="nav_menu-16" class="widget widget_nav_menu">
                            <!-- <p class="widgettitle hidden">Footer Navigation Links</p> -->
                            <div class="menu-footer-navigation-container">
                                <ul id="menu-footer-navigation" class="menu">
                                    
                                    <li id="menu-item-7407"
                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-7407">
                                        <a href="{{ url('blog') }}">مدونة العلاجات</a></li>
                                    <li id="menu-item-24173"
                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-24173">
                                        <a href="{{ url('about') }}">معلومات عنا</a></li>
                                    <li id="menu-item-12844"
                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-12844">
                                        <a href="{{ url('privacy-policy') }}">سياسة الخصوصية</a></li>
                                    <li id="menu-item-12845"
                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-12845">
                                        <a href="{{ url('terms-conditions') }}">الشروط والأحكام</a></li>
                                </ul>
                            </div>
                        </div>
                        <div id="text-20" class="widget widget_text">
                            <!-- <p class="widgettitle hidden">Copyright</p> -->
                            <div class="textwidget">
                                <p>Copyright © 2025 Doctor Skin Clinic Ltd. All rights reserved. <a href="https://devolyt.com/">Design & Developed by Devolyt Technologies</a><br>
                                Company House Details: DOCTOR SKIN CLINIC LIMITED, Company Number: 14614894, Registered Address: 758 Harrow Road Harrow Road, London, England, NW10 5LE  </p>
                                <p>شركة DSL Clinic (المملكة المتحدة) المحدودة  مرخصة ومنظمة من قبل هيئة السلوك المالي.</p>
                                <p>نحن نعمل كوسيط ائتماني، وليس مُقرضًا، ونقدم تمويلًا من كلارنا في 3، وهو اسم تجاري لشركة كلارنا (أوروبا). تُطبق الشروط والأحكام. إجراءات تقديم الشكاوى.</p>
                                <p>شركة DSL Clinic (المملكة المتحدة) المحدودة تعمل كوسيط ائتماني يقدم منتجات تمويلية من Klarna. شركة DSL Clinic (المملكة المتحدة) المحدودة مرخصة ومنظمة من قبل هيئة السلوك المالي. يخضع الائتمان للحالة. إجراءات الشكاوى.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
@else
<footer>
        <section class="bg-logo">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 text-center">
                        <h2 class="text-white">As Seen In</h2>
                    </div>
                    <div class="col-12">
                        <img class="d-lg-block d-none" src="{{ asset('frontend/images/2.webp') }}" alt="">
                        <img class="d-lg-none d-block" src="{{ asset('frontend/images/346-by-400-pixels.webp') }}" alt="">
                    </div>
                </div>
            </div>
        </section>
        <section class="clients-say">
            <div class="container">
                <div class="row">
                    <div class="col-12 mb-4 text-center">
                        <h2>What Our Clients Say</h2>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-lg-4">
                        <div class="clients-box">
                            <iframe src="https://www.youtube.com/embed/Pg6lv70k1Tw?si=KY0eq0JXQNpSMv0H"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            <p>She Had Full Face Fillers and Looks 10 Years Younger — The Glow-Up Is Unreal!”“From Tired</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="clients-box">
                            <iframe src="https://www.youtube.com/embed/wECJb9p-EGM?si=u5X7yZQpH16O_PHn"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            <p>Laser hair removal - All Skin Types - Candela gentle max pro</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="clients-box">
                            <iframe src="https://www.youtube.com/embed/BggJOeAR4jk?si=Tp0V6qc07btidJRh"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            <p>This Skin Tightening Treatment Took 10 Years Off Her Face — Only at Diamond Skin Clinic</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="clinics">
                        <div class="footer-single-clinic">
                            <p class="name"> Wembley</p>
                            <p class="phone"> <a href="tel:02075235158"> 02080040277 </a></p>
                            <p class="phone"> <a href="tel:03301131130"> 03301131130 </a></p>
                            <p class=""> <a href="mailto:hello@dslclinic.com"> hello@dslclinic.com </a></p>
                            <address> <a href="https://maps.app.goo.gl/AMt3AnMvraaXimYb6" target="_blank" rel="noopener"> 348 High Road Wembley HA9 6AZ </a> </address>
                        </div>
                        <div class="footer-single-clinic">
                            <p class="name"> Ladbroke Grove</p>
                            <p class="phone"> <a href="tel:02075938055"> 02080040277 </a></p>
                            <p class="phone"> <a href="tel:03301131130"> 03301131130 </a></p>
                            <p class=""> <a href="mailto:hello@dslclinic.com"> hello@dslclinic.com </a></p>

                            <address> <a href="https://maps.app.goo.gl/VfdEAPWeYnMSytdB8" target="_blank" rel="noopener">758 HARROW ROAD North Kensington NW10 5LE</a>
                            </address>
                        </div>
                        <div class="footer-single-clinic">
                            <p class="name"> Harley Street</p>
                            <p class="phone"> <a href="tel:02080040277"> 02080040277 </a></p>
                            <p class="phone"> <a href="tel:03301131130"> 03301131130 </a></p>
                            <p class=""> <a href="mailto:hello@dslclinic.com"> hello@dslclinic.com </a></p>

                            <address> <a href="https://maps.app.goo.gl/XTrCGykKCiDPSDUy6" target="_blank" rel="noopener"> 102 Harley Street W1G 7JB </a>
                            </address>
                        </div>
                        <div class="footer-single-clinic">
                            <p class="name">Knightsbridge                            </p>
                            <p class="phone"> <a href="tel:01614640694"> 02080040277 </a></p>
                            <p class="phone"> <a href="tel:03301131130"> 03301131130 </a></p>
                            <p class=""> <a href="mailto:hello@dslclinic.com"> hello@dslclinic.com </a></p>

                            <address> <a href="https://maps.app.goo.gl/fWu6bF2MgiVH9eLy5" target="_blank" rel="noopener"> KNIGHTSBRIDGE 20 Beauchamp Place Knightsbridge SW3 1NQ</a> </address>
                        </div>
                        
                    </div>
                </div>
                <div class="col-lg-4">
                    <div>
                        <div id="sidebar-footer-new" class="sidebar" role="complementary">
                            <div id="text-23" class="widget widget_text">
                                <h2 class="widgettitle p">Helpful Links</h2>
                                <div class="textwidget">
                                    <ul>
                                        <li>
                                            <h3>Popular Treatments</h3>
                                        </li>
                                        <li><a title="Laser Hair Removal" href="{{ url('/laser-hair-removal-london') }}" >Laser Hair Removal</a></li>
                                        <li><a title="Bum and Hip fillers" href="{{ url('/bum-and-hip-fillers') }}" >Bum and Hip fillers</a></li>
                                        <li><a title="Anti-Wrinkle Injections" href="{{ url('/anti-wrinkle-injections') }}" >Anti-Wrinkle Injections</a></li>
                                        <li><a title="Stretch Mark Removal" href="{{ url('/stretch-mark-treatment') }}" >Stretch Mark Removal</a></li>
                                        <li><a title="Microblading" href="{{ url('/microblading') }}" >Microblading</a></li>
                                        <li><a title="Anti-Wrinkle Injections" href="{{ url('/anti-wrinkle-injections') }}" >Anti-Wrinkle Injections</a></li>
                                    </ul>
                                    <ul>
                                        <li><a title="Fat Reduction" href="{{ url('/fat-reduction') }}">Fat Reduction</a></li>
                                        <li><a title="Pigmentations" href="{{ url('/pigmentation-removal-treatment') }}">Pigmentations Removal</a></li>
                                        <li><a title="Anti Ageing" href="{{ url('/eyes-area-boosters') }}">Eyes area boosters</a>
                                        </li>
                                        <li>
                                            <h3>Quick Links</h3>
                                        </li>
                                        <li><a title="About DSL Clinic" href="{{ url('about') }}">About Us</a> |
                                            <a title="Contact" href="{{ url('book-free-consultation') }}">Contact</a>
                                        </li>
                                        <li><a title="Blog" href="{{ url('blog') }}">Blog</a> | <a title="Terms Conditions"
                                                href="{{ url('terms-conditions') }}">Terms Conditions</a></li>
                                    </ul>
                                </div>

                            </div>


                        </div>

                    </div>
                    <div class="social-icon">
                        <ul>
                            <li>
                                <a href="https://www.facebook.com/diamondskinuk/" class="icon-so facebook"><img src="{{ asset('frontend/images/facebook.png') }}" alt=""></a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/diamondskin.uk/" class="icon-so insata"><img src="{{ asset('frontend/images/insata.png') }}" alt=""></a>
                            </li>
                            <li>
                                <a href="https://www.youtube.com/@dslclinicuk" class="icon-so youtube-i"><img src="https://dslclinic.com/public/frontend/images/icon-sprites-you.png" alt=""></a>
                            </li>
                            <!--                            <li>
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
                            </li>-->
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="footer-contact--logo">
                        <img src="{{ asset('frontend/images/Diamond Skin.png') }}"
                            class="attachment-medium size-medium entered lazyloaded" alt="Care Quality Commission logo"
                            data-ll-status="loaded">
                        <noscript><img width="105" height="33"
                                src="{{ asset('frontend/images/Diamond Skin.png') }}"
                                class="attachment-medium size-medium" /></noscript>
                    </div>
                </div>
            </div>
            <div class="row bottom-footer">
                <div class="col-12">
                    <div id="sidebar-footer" class="sidebar cf" role="complementary">
                        <div id="nav_menu-16" class="widget widget_nav_menu">
                            <!-- <p class="widgettitle hidden">Footer Navigation Links</p> -->
                            <div class="menu-footer-navigation-container">
                                <ul id="menu-footer-navigation" class="menu">
                                    
                                    <li id="menu-item-7407"
                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-7407">
                                        <a href="{{ url('blog') }}">Treatments Blog</a></li>
                                    <li id="menu-item-24173"
                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-24173">
                                        <a href="{{ url('about') }}">About Us</a></li>
                                    <li id="menu-item-12844"
                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-12844">
                                        <a href="{{ url('privacy-policy') }}">Privacy Policy</a></li>
                                    <li id="menu-item-12845"
                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-12845">
                                        <a href="{{ url('terms-conditions') }}">Terms and Conditions</a></li>
                                </ul>
                            </div>
                        </div>
                        <div id="text-20" class="widget widget_text">
                            <!-- <p class="widgettitle hidden">Copyright</p> -->
                            <div class="textwidget">
                                
                               <p> Registered Address: 758 Harrow Road Harrow Road, London, England, NW10 5LE  </p>
                                                              <p> Company House Details: DOCTOR SKIN CLINIC LIMITED, Company Number: 14614894, </p>

                                                              <p>Copyright © 2025 Doctor Skin Clinic Ltd. All rights reserved. <a href="https://devolyt.com/">Design & Developed by Devolyt Technologies</a><br>

<!--                                <p>Doctor Skin Clinic Ltd is authorised and regulated by the Financial Conduct Authority.</p>
-->                                <p>We act as a credit broker, not a lender and offer finance from Klarna in 3 is a trading name of Klarna (Europe).Terms & Conditions apply. Complaints procedure.</p>
                                <p>Doctor Skin Clinic Ltd is acting as a credit broker offering finance products from Klarna. Doctor Skin Clinic Ltd is authorised and regulated by the Financial Conduct Authority. Credit is subject to status. Complaints procedure.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
@endif
    
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".laser-hair-removal").forEach(function (menuItem) {
            menuItem.addEventListener("click", function (event) {
                event.preventDefault();
                let parentLi = this.parentElement; // Get the parent <li> of the clicked item
                parentLi.classList.toggle("active"); // Toggle active class
            });
        });
    });
</script>
<script>

document.addEventListener("DOMContentLoaded", function () {
    var startPos12 = 500; // Scroll position to trigger popup
    var footerPopup = document.querySelector(".footer-popup");
    var closeBtn = document.querySelector(".closebtn");

    // Scroll event to show/hide the footer popup
    window.addEventListener("scroll", function () {
        var currentPos = window.scrollY;
        if (currentPos > startPos12) {
            footerPopup.style.transform = "translateY(0px)"; // Show popup
        } else {
            footerPopup.style.transform = "translateY(250px)"; // Hide popup
        }
    });

    // Click event to hide popup when close button is clicked
    closeBtn.addEventListener("click", function () {
        footerPopup.style.transform = "translateY(250px)"; // Hide popup on close
        hidePopup();
    });
});


       

</script>
 