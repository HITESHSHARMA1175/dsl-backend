@include('frontend.partials.header')



<script src="https://x.klarnacdn.net/kp/lib/v1/api.js" async></script>

<style>
.product-cart-box {
    position: relative;
    display: flex;
    /*flex-direction: column;*/
    gap: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    background: #fff;
    margin-bottom: 5px;
}

.remove-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    padding: 5px 10px;
    font-size: 14px;
    border-radius: 5px;
}

    /* Real Results section (before/after) */
    .results-split{background:#fff; padding: 72px 0;}
    .results-grid{
      display:grid;
      grid-template-columns: 1.05fr .95fr;
      gap: 56px;
      align-items:center;
    }
    @media (max-width: 980px){
      .results-grid{grid-template-columns:1fr; gap: 28px;}
    }

    .ba-wrap{position:relative; width:100%; max-width: 720px;}
    .ba-frame{
      position:relative;
      width:100%;
      aspect-ratio: 1 / 1;
      border-radius: 6px;
      overflow:hidden;
      background:#f3f4f6;
    }
    .ba-img, .ba-img-top{position:absolute; inset:0; width:100%; height:100%; object-fit:cover;}
    .ba-top{position:absolute; inset:0; width:50%; overflow:hidden;}

    .ba-divider{
      position:absolute;
      top:0; bottom:0;
      left:50%;
      width:2px;
      background: rgba(255,255,255,.9);
      box-shadow: 0 0 0 1px rgba(0,0,0,.06);
      transform: translateX(-1px);
      z-index: 4;
    }

    .ba-handle{
      position:absolute;
      left:50%;
      top:50%;
      transform: translate(-50%, -50%);
      width: 56px;
      height: 56px;
      border-radius: 999px;
      background: rgba(0,0,0,.0);
      display:flex;
      align-items:center;
      justify-content:center;
      z-index: 5;
      pointer-events:none;
    }

    .ba-arrows{
      display:flex;
      gap: 14px;
      align-items:center;
      justify-content:center;
      color:#fff;
      font-size: 22px;
      user-select:none;
    }

    .ba-pill{
      position:absolute;
      top: 18px;
      padding: 8px 14px;
      border-radius: 999px;
      font-weight: 700;
      font-size: 13px;
      color:#fff;
      background: rgba(0,0,0,.72);
      z-index: 6;
    }
    .ba-pill.before{left: 18px; background: rgba(203,203,203,.9); color:#fff;}
    .ba-pill.after{right: 18px;}

    .ba-range{
      position:absolute;
      inset:0;
      width:100%;
      height:100%;
      opacity:0;
      cursor: ew-resize;
      z-index: 10;
    }

    .results-kicker{
      text-transform: uppercase;
      letter-spacing: .14em;
      font-weight: 700;
      font-size: 13px;
      color: var(--purple);
      margin: 0 0 18px;
    }
    .results-title{
      font-family: Georgia, "Times New Roman", Times, serif;
      font-weight: 500;
      letter-spacing: -0.02em;
      font-size: clamp(44px, 4.2vw, 72px);
      line-height: 1.02;
      margin: 0 0 18px;
      color:#0b1220;
    }
    .results-copy{
      margin: 0;
      color:#4b5563;
      font-size: 18px;
      line-height: 1.9;
      max-width: 640px;
    }

    .results-chip{
      display:inline-flex;
      align-items:center;
      justify-content:center;
      margin-top: 26px;
      padding: 10px 22px;
      border-radius: 999px;
      border: 1px solid #cfd3dd;
      color:#111827;
      font-weight: 700;
      font-size: 14px;
      background:#f5f5f9;
      width: fit-content;
    }
    :root{
      --bg:#f5f5f9;
      --text:#111827;
      --muted:#6b7280;
      --border:#e5e7eb;
      --card:#ffffff;
      --purple:#6b63d6;
      --pill:#efeff4;
      --shadow:0 12px 28px rgba(0,0,0,.08);
      --radius:16px;
    }

    /* Keep page full width (no container clipping) */
    html,body{height:100%;}
    body{margin:0; color:var(--text); background:#fff; font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji","Segoe UI Emoji";}

    /* Main wrapper */
    .page-wrap{width:100%;}

    /* Page top spacing under header */
    .content{padding: 28px 0 60px;}

    .container{
      width: 100%;
      max-width: 100%;
      margin: 0;
      padding: 0 64px;
      box-sizing: border-box;
    }
    /* How It Works (video) section */
    .howitworks{background:#fff; padding: 64px 0 72px;}
    .howitworks-head{text-align:center;}
    .howitworks-kicker{
      text-transform: uppercase;
      letter-spacing: .14em;
      font-weight: 700;
      font-size: 13px;
      color: var(--purple);
      margin: 0 0 16px;
    }
    .howitworks-title{
      font-family: Georgia, "Times New Roman", Times, serif;
      font-weight: 500;
      letter-spacing: -0.02em;
      font-size: clamp(44px, 4.2vw, 72px);
      line-height: 1.02;
      margin: 0 0 28px;
      color:#0b1220;
    }
    .howitworks-media{
      border-radius: 10px;
      overflow:hidden;
      border: 2px solid rgba(107,99,214,.35);
      box-shadow: 0 12px 28px rgba(0,0,0,.06);
      background:#f3f4f6;
    }
    .howitworks-media video,
    .howitworks-media iframe,
    .howitworks-media img{
      width:100%;
      height:auto;
      display:block;
    }
    @media (max-width: 768px){
      .container{padding: 0 16px;}
    }

    /* Breadcrumb */
    .crumbs{font-size:14px; color:#6b7280; margin: 0 0 10px;}
    .crumbs a{color:#6b7280; text-decoration:none;}
    .crumbs a:hover{color:#374151; text-decoration:underline;}

    /* H1 serif like Therapie */
    .h1{
      font-family: Georgia, "Times New Roman", Times, serif;
      font-weight: 500;
      letter-spacing: -0.02em;
      font-size: clamp(36px, 4vw, 64px);
      line-height: 1.02;
      margin: 0 0 18px;
      color:#0b1220;
    }

    /* Pills */
    .pills{display:flex; gap:12px; flex-wrap:wrap; padding: 6px 0 18px;}
    .pill{
      border:1px solid transparent;
      background: var(--pill);
      color:#111827;
      padding: 10px 18px;
      border-radius: 999px;
      font-size: 14px;
      line-height: 1;
      cursor: pointer;
      user-select:none;
      text-decoration:none;
      display:inline-flex;
      align-items:center;
      gap:8px;
    }
    .pill:hover{filter: brightness(0.98);}
    .pill.active{background:#111827; color:#fff;}

    /* Section background */
    .service-band{background: var(--bg); padding: 56px 0;}

    .grid{
      display:grid;
      grid-template-columns: 1.05fr .95fr;
      gap: 44px;
      align-items:start;
    }
    @media (max-width: 980px){
      .grid{grid-template-columns: 1fr; gap: 28px;}
    }

    /* Left card image */
    .image-card{
      position: relative;
      border-radius: 4px;
      overflow: hidden;
      background:#ddd;
      box-shadow: none;
    }
    .image-card img{
      width: 100%;
      height: 550px;
      display:block;
      object-fit: cover;
    }
    .image-label{
      position:absolute;
      left: 24px;
      bottom: 16px;
      font-family: Georgia, "Times New Roman", Times, serif;
      font-size: 54px;
      font-weight: 500;
      color: rgba(255,255,255,.85);
      text-shadow: 0 10px 24px rgba(0,0,0,.25);
    }

    .price-badge{
      position:absolute;
      right: 24px;
      top: 24px;
      width: 130px;
      height: 130px;
      border-radius: 999px;
      background: var(--purple);
      color:#fff;
      display:flex;
      flex-direction:column;
      justify-content:center;
      align-items:center;
      text-align:center;
      box-shadow: 0 10px 24px rgba(107,99,214,.35);
    }
    .price-badge .from{font-size: 16px; opacity:.9; margin-bottom:6px;}
    .price-badge .amount{
      font-family: Georgia, "Times New Roman", Times, serif;
      font-size: 44px;
      line-height: 1;
      font-weight: 600;
    }
    .price-badge .pence{font-size: 16px; opacity:.9; margin-left:2px; vertical-align: super;}

    /* Left info */
    .help-title{
      font-family: Georgia, "Times New Roman", Times, serif;
      font-size: 44px;
      line-height: 1.05;
      font-weight: 500;
      margin: 22px 0 8px;
      color:#0b1220;
    }
    .help-sub{margin: 0 0 6px; color:#4b5563; font-size: 16px;}
    .help-link{color: var(--purple); text-decoration:none; font-weight:600; font-size: 16px;}
    .help-link:hover{text-decoration:underline;}

    .reviews{
      display:flex;
      align-items:center;
      gap: 14px;
      margin-top: 20px;
      color:#6b7280;
      font-size: 15px;
    }
    .stars{display:flex; gap:4px;}
    .star{width: 18px; height: 18px; display:inline-block;}

    /* Right content */
    .service-title{
      font-family: Georgia, "Times New Roman", Times, serif;
      font-size: 30px;
      line-height: 1.05;
      font-weight: 500;
      margin: 0 0 10px;
      color:#0b1220;
    }
    .service-desc{margin: 0px; color:#4b5563; font-size: 14.5px; line-height: 1.7; max-width: 560px;}
    .learn-more{color: var(--purple); text-decoration:none; font-weight:600; display:inline-block; margin-bottom: 18px;}
    .learn-more:hover{text-decoration:underline;}

    .select-title{margin: 18px 0 12px; font-size: 18px; font-weight: 700; color:#111827;}

    .option-card{
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 10px;
      padding: 7px 18px;
      display:flex;
      align-items:flex-start;
      justify-content:space-between;
      gap: 16px;
      margin-bottom: 10px;
    }
    .option-card:hover{border-color:#d1d5db;}
    .option-card.js-package-popup{cursor:pointer;}
    .option-left h4{margin: 0 0 6px; font-size: 18px; font-weight: 500; color:#111827;}
    .option-left p{margin: 0; color:#6b7280; font-size: 14px; line-height: 1.4;}
    .option-right{font-size: 16px; font-weight: 800; color:#111827; white-space:nowrap; padding-top: 4px;}
    .option-right.muted{color:#6b7280; font-weight:700;}

    /* Therapie-style content hero (text left, image right) */
    .hero-split{background:#ffffff; padding: 72px 0;}
    .hero-grid{
      display:grid;
      grid-template-columns: 1fr 1fr;
      gap: 56px;
      align-items:center;
    }
    @media (max-width: 980px){
      .hero-grid{grid-template-columns:1fr; gap: 28px;}
    }

    .kicker{
      text-transform: uppercase;
      letter-spacing: .14em;
      font-weight: 700;
      font-size: 13px;
      color: var(--purple);
      margin: 0 0 18px;
    }

    .hero-title{
      font-family: Georgia, "Times New Roman", Times, serif;
      font-weight: 500;
      letter-spacing: -0.02em;
      font-size: clamp(44px, 4.2vw, 72px);
      line-height: 1.02;
      margin: 0 0 18px;
      color:#0b1220;
    }

    .hero-copy{
      margin: 0;
      color:#4b5563;
      font-size: 18px;
      line-height: 1.85;
      max-width: 640px;
    }

    .hero-actions{display:flex; gap:14px; flex-wrap:wrap; margin-top: 28px;}
    .btn{
      display:inline-flex;
      align-items:center;
      justify-content:center;
      padding: 14px 28px;
      border-radius: 999px;
      font-weight: 700;
      font-size: 15px;
      text-decoration:none;
      border: 1px solid transparent;
      cursor:pointer;
      user-select:none;
      min-width: 220px;
      box-sizing: border-box;
    }
    .btn-primary{background: var(--purple); color:#fff; box-shadow: 0 12px 28px rgba(107,99,214,.25);}
    .btn-primary:hover{filter: brightness(0.98);}
    .btn-outline{background: #fff; color:#111827; border-color:#cfd3dd;}
    .btn-outline:hover{border-color:#b9bfcc;}

    .hero-image{
      width: 100%;
      border-radius: 6px;
      overflow:hidden;
      background:#f3f4f6;
    }
    .hero-image img{width:100%; height:auto; display:block; object-fit:cover;}

    /* Quick info strip (icons + labels) */
    .info-strip{background:#fff; padding: 36px 0; border-top: 1px solid #f0f0f4;}
    .info-grid{
      display:grid;
      grid-template-columns: repeat(4, minmax(0, 1fr));
      gap: 28px;
      align-items:center;
    }
    @media (max-width: 980px){
      .info-grid{grid-template-columns: repeat(2, minmax(0, 1fr));}
    }
    @media (max-width: 520px){
      .info-grid{grid-template-columns: 1fr;}
    }

    .info-item{display:flex; gap: 18px; align-items:flex-start; padding: 14px 6px;}
    .info-ico{width: 46px; height: 46px; flex: 0 0 46px; display:flex; align-items:center; justify-content:center; color:#9ca3af;}
    .info-ico svg{width: 46px; height: 46px; display:block;}

    .info-text{line-height: 1.2;}
    .info-k{font-size: 18px; color:#6b7280; font-weight: 500; margin: 0 0 6px;}
    .info-v{font-size: 22px; color:#111827; font-weight: 700; margin: 0;}

    /* Ensure header/footer widths don't constrain this page */
    header, footer{width:100%;}

    /* Klarna banner (dark CTA section) */
    .klarna-banner{background:#0f0f10; padding: 92px 0;}
    .klarna-inner{display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center;}
    .klarna-kicker{
      text-transform: uppercase;
      letter-spacing: .18em;
      font-weight: 800;
      font-size: 13px;
      color: rgba(168,160,255,.95);
      margin: 0 0 22px;
    }
    .klarna-title{
      font-family: Georgia, "Times New Roman", Times, serif;
      font-weight: 500;
      letter-spacing: -0.02em;
      font-size: clamp(44px, 5vw, 78px);
      line-height: 1.02;
      margin: 0 0 34px;
      color:#ffffff;
      max-width: 980px;
    }
    .klarna-title em{font-style: italic;}
    .klarna-btn{
      display:inline-flex;
      align-items:center;
      justify-content:center;
      padding: 16px 38px;
      border-radius: 999px;
      font-weight: 800;
      font-size: 16px;
      text-decoration:none;
      color:#ffffff;
      background: var(--purple);
      box-shadow: 0 14px 34px rgba(107,99,214,.35);
      border: 1px solid transparent;
      min-width: 220px;
    }
    .klarna-btn:hover{filter: brightness(0.98);}

    /* Testimonials (What our clients say) */
    .testimonials{background:#fff; padding: 84px 0 96px;}
    .test-head{display:flex; align-items:flex-start; justify-content:space-between; gap: 24px;}
    .test-kicker{
      text-transform: uppercase;
      letter-spacing: .14em;
      font-weight: 800;
      font-size: 13px;
      color: rgba(107,99,214,.95);
      margin: 0 0 18px;
    }
    .test-title{
      font-family: Georgia, "Times New Roman", Times, serif;
      font-weight: 500;
      letter-spacing: -0.02em;
      font-size: clamp(44px, 4.6vw, 76px);
      line-height: 1.02;
      margin: 0;
      color:#0b1220;
    }

    .test-nav{display:flex; gap: 12px; padding-top: 22px;}
    .test-btn{
      width: 44px;
      height: 44px;
      border-radius: 999px;
      border: 1px solid #e5e7eb;
      background: #f3f4f6;
      color:#6b7280;
      display:flex;
      align-items:center;
      justify-content:center;
      cursor:pointer;
      user-select:none;
    }
    .test-btn:hover{filter: brightness(0.98);}

    .test-track{
      margin-top: 34px;
      display:grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: 28px;
    }
    @media (max-width: 980px){
      .test-track{grid-template-columns: repeat(2, minmax(0, 1fr));}
    }
    @media (max-width: 680px){
      .test-head{flex-direction:column;}
      .test-nav{padding-top: 0;}
      .test-track{
        grid-template-columns: 1fr;
      }
    }

    .review-card{
      background:#fff;
      border: 1px solid #edf0f6;
      border-radius: 14px;
      box-shadow: 0 12px 26px rgba(0,0,0,.08);
      padding: 28px;
      min-height: 360px;
      display:flex;
      flex-direction:column;
      justify-content:space-between;
    }

    .review-top{display:flex; flex-direction:column; gap: 10px;}
    .review-name{font-size: 26px; font-weight: 800; color:#111827; margin:0;}
    .review-meta{color:#6b7280; font-size: 14px; line-height: 1.45;}
    .review-stars{display:flex; gap: 4px; margin-top: 4px;}
    .review-stars svg{width: 16px; height: 16px; display:block; fill:#d4a72c;}

    .review-text{color:#111827; font-size: 18px; line-height: 1.8; margin: 16px 0 0;}

    .review-source{margin-top: 24px;}
    .review-source .g{font-size: 28px; font-weight: 800; color:#111827; margin:0;}
    .review-source .s{color:#6b7280; font-size: 14px; margin-top: 2px;}

    /* FAQ (Frequently Asked Questions) */
    .faq{background:#fff; padding: 88px 0 96px;}
    .faq-title{
      font-family: Georgia, "Times New Roman", Times, serif;
      font-weight: 500;
      letter-spacing: -0.02em;
      font-size: clamp(44px, 4.6vw, 76px);
      line-height: 1.02;
      margin: 0 0 44px;
      color:#0b1220;
      text-align:center;
    }
    .faq-inner{max-width: 980px; margin: 0 auto;}
    .faq-item{border-top: 1px solid #e7eaf1;}
    .faq-item:last-child{border-bottom: 1px solid #e7eaf1;}

    .faq-btn{
      width:100%;
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap: 18px;
      padding: 26px 0;
      background: transparent;
      border: 0;
      cursor:pointer;
      text-align:left;
      color:#111827;
      font-size: 22px;
      font-weight: 700;
      font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji","Segoe UI Emoji";
    }
    @media (max-width: 680px){
      .faq-btn{font-size: 18px; padding: 22px 0;}
    }

    .faq-icon{
      width: 22px;
      height: 22px;
      flex: 0 0 22px;
      color:#111827;
      transition: transform .18s ease;
    }
    .faq-item[aria-expanded="true"] .faq-icon{transform: rotate(180deg);}

    .faq-panel{
      max-height: 0;
      overflow:hidden;
      transition: max-height .22s ease;
    }
    .faq-panel > div{
      padding: 0 0 22px;
      color:#4b5563;
      font-size: 18px;
      line-height: 1.85;
      max-width: 920px;
    }
  .option-scroll {
    max-height: 408px;   /* adjust height as per design */
    overflow-y: auto;
    padding-right: 10px;
    margin-bottom: 8px;
}

/* Optional: smooth scrollbar */
.option-scroll::-webkit-scrollbar {
    width: 6px;
}

.option-scroll::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 10px;
}
</style>

<?php 

use App\Models\Property;

if(session('app_locale')=='cn'){
    if($category->icon_large_cn!=''){
    $icon_large11 = $category->icon_large_cn;
    }else{
    $icon_large11 = $category->icon_large;
    }
    $category_name11 = $category->category_name_cn;
    $description11 = $category->description_cn;
    $youtube_link11 = $category->youtube_link_cn;
    if($category->icon2_cn!=''){
    $icon211 = $category->icon2_cn;
    }else{
    $icon211 = $category->icon2;
    }
    $description311 = $category->description3_cn;
}elseif(session('app_locale')=='ar'){
    if($category->icon_large_ar!=''){
    $icon_large11 = $category->icon_large_ar;
    }else{
    $icon_large11 = $category->icon_large;
    }
    $category_name11 = $category->category_name_ar;
    $description11 = $category->description_ar;
    $youtube_link11 = $category->youtube_link_ar;
    if($category->icon2_ar!=''){
    $icon211 = $category->icon2_ar;
    }else{
    $icon211 = $category->icon2;
    }
    $description311 = $category->description3_ar;
}else{
    $icon_large11 = $category->icon_large;
    $category_name11 = $category->category_name;
    $description11 = $category->description;
    $youtube_link11 = $category->youtube_link;
    $icon211 = $category->icon2;
    $description311 = $category->description3;
}
?>

    <div class="breadcrumb-cell" aria-label="breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ol class="breadcrumb mb-0">
                        <a href="{{ url('/') }}"> Home </a> &gt; {{ $category_name11 }}
                    </ol>
                </div>
            </div>
        </div>
    </div>
 <section class="banner-acne p-0">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 p-0">
                <a href="https://share.google/NNg1CDBV051jzMDVD" target="_blank" rel="noopener noreferrer">
                    <img 
                        src="{{ !empty($icon_large11) ? asset('uploads/servicecat/' . $icon_large11) : asset('assets/img/media/1.jpg') }}" 
                        alt="{{ $category_name11 }}"
                        style="width:100%; height:auto; cursor:pointer;"
                    >
                </a>
            </div>
        </div>
    </div>
</section>

<div class="page-wrap">
  <main class="content">
    

    <section class="service-band">
      <div class="container">
        <div class="grid">

          <!-- LEFT -->
          <div>
            <div class="image-card">
               @if($youtube_link11!='')
                    <iframe width="100%" src="{{ $youtube_link11 }}"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    @elseif($icon211!='')
                    <img src="{{ !empty($icon211) ? asset('uploads/servicecat/' . $icon211) : asset('assets/img/media/1.jpg') }}" >
                    @endif
            </div>

          </div>

          <!-- RIGHT -->
          <div>
            <h5 class="service-title">{{ $category_name11 }}</h5>
                    <p class="service-desc">{{ $description11 }}</p>
          
            <!-- <a class="learn-more" href="#">Learn more</a> -->
<div class="option-scroll">
            <div class="select-title">Select what works for you:</div>
             @if(count($subcategories) > 0)
                    @foreach ($subcategories as $subcategory)
                    @php 
                        
                        $services = Property::whereJsonContains('property_sub_category', strval($subcategory->id))
                        ->orWhereJsonContains('skin_sub_condition', strval($subcategory->id))->get();
                        
                    @endphp

             @foreach ($services as $service)
             <?php
                                        
            if($service->session1>0){
                $liwidth = 1;
            }
            
            if($service->session2>0){
                $liwidth += 1;
            }
            
            if($service->session3>0){
                $liwidth += 1;
            }
            
            if($service->session4>0){
                $liwidth += 1;
            }
            
            
            ?>

              @if($service->session1>0)
              <div class="option-card js-package-popup" data-property="{{ $service->property_name }}" data-service="{{ $service->id }}" data-session="{{ $service->session1 }}" data-price="{{ ($service->price-$service->discounted_price) }}" data-image="{{ !empty($category->image1) ? asset('uploads/servicecat/' . $category->image1) : asset('assets/img/media/1.jpg') }}">
                  <div class="option-left">
                    <h4>{{ $service->property_name }}</h4>
                    <p>Select Number of Sessions - {{ $service->session1 }}x</p>
                  </div>
                   @if($service->discounted_price>0)
                  <div class="option-right muted" style="font-size: 1.05rem;font-weight: 400;color: #13283e;text-decoration: line-through;">£ {{ $service->price }}</div>
                  <span style="color: #d1223d;font-size: 16px;font-weight: 600;">Now £{{ ($service->price-$service->discounted_price) }} Total</span>
                   @endif
                   £ {{ ceil(($service->price-$service->discounted_price)/$service->session1) }} per session
                </div>
              @endif

               @if($service->session2>0)
             <div class="option-card js-package-popup" data-property="{{ $service->property_name }}" data-service="{{ $service->id }}" data-session="{{ $service->session2 }}" data-price="{{ ($service->price2-$service->discounted_price2) }}" data-image="{{ !empty($category->image1) ? asset('uploads/servicecat/' . $category->image1) : asset('assets/img/media/1.jpg') }}">
                  <div class="option-left">
                    <h4>{{ $service->property_name }}</h4>
                    <p>Select Number of Sessions - {{ $service->session2 }}x</p>
                  </div>
                   @if($service->discounted_price2>0)
                  <div class="option-right muted" style="font-size: 1.05rem;font-weight: 400;color: #13283e;text-decoration: line-through;">£ {{ $service->price2 }}</div>
                  <span style="color: #d1223d;font-size: 16px;font-weight: 600;">Now £{{ ($service->price2-$service->discounted_price2) }} Total</span>
                   @endif
                   £ {{ ceil(($service->price2-$service->discounted_price2)/$service->session2) }} per session
                </div>
              @endif

               @if($service->session3>0)
             <div class="option-card js-package-popup" data-property="{{ $service->property_name }}" data-service="{{ $service->id }}" data-session="{{ $service->session3 }}" data-price="{{ ($service->price3-$service->discounted_price3) }}" data-image="{{ !empty($category->image1) ? asset('uploads/servicecat/' . $category->image1) : asset('assets/img/media/1.jpg') }}">
                  <div class="option-left">
                    <h4>{{ $service->property_name }}</h4>
                    <p>Select Number of Sessions - {{ $service->session3 }}x</p>
                  </div>
                   @if($service->discounted_price3>0)
                  <div class="option-right muted" style="font-size: 1.05rem;font-weight: 400;color: #13283e;text-decoration: line-through;">£ {{ $service->price3 }}</div>
                  <span style="color: #d1223d;font-size: 16px;font-weight: 600;">Now £{{ ($service->price3-$service->discounted_price3) }} Total</span>
                   @endif
                   £ {{ ceil(($service->price3-$service->discounted_price3)/$service->session3) }} per session
                </div>
              @endif

               @if($service->session4>0)
             <div class="option-card js-package-popup" data-property="{{ $service->property_name }}" data-service="{{ $service->id }}" data-session="{{ $service->session4 }}" data-price="{{ ($service->price4-$service->discounted_price4) }}" data-image="{{ !empty($category->image1) ? asset('uploads/servicecat/' . $category->image1) : asset('assets/img/media/1.jpg') }}">
                  <div class="option-left">
                    <h4>{{ $service->property_name }}</h4>
                    <p>Select Number of Sessions - {{ $service->session4 }}x</p>
                  </div>
                   @if($service->discounted_price4>0)
                  <div class="option-right muted price-was" style="font-size: 1.05rem;font-weight: 400;color: #13283e;text-decoration: line-through;">£ {{ $service->price4 }}</div>
                  <span style="color: #d1223d;font-size: 16px;font-weight: 600;">Now £{{ ($service->price4-$service->discounted_price4) }} Total</span>
                   @endif
                   £ {{ ceil(($service->price4-$service->discounted_price4)/$service->session4) }} per session
                </div>
              @endif


            

             @endforeach
             @endforeach

  @endif
</div>

<a href="javascript:void(0)" style="background: #000;color: #fff;" class="btn btn--primary header-cta" >Buy</a>
          </div>

        </div>
      </div>
    </section>

<!--   <section class="hero-split">
      <div class="container">
        <div class="hero-grid">
          <div>
            <div class="kicker">GOODBYE RAZOR, HELLO LASER</div>
            <h2 class="hero-title">Precise and gentle<br/>laser hair removal</h2>
            <p class="hero-copy">
              Our Elite IQ™ by Cynosure® technology targets facial hair with precision, effectively removing hair without
              harming your skin. Our advanced medical-grade lasers are gentle yet effective, designed to address both
              hormonal and hereditary hair growth. With our laser hair removal, you can enjoy lasting confidence and smooth,
              clear skin.
            </p>

            <div class="hero-actions">
              <a class="btn btn-primary" href="#">Book free consultation</a>
              <a class="btn btn-outline" href="#">Buy and save</a>
            </div>
          </div>

          <div class="hero-image" aria-label="Laser hair removal face">
            <img src="https://therapieclinic.com/_next/image?url=%2Fassets%2Ftreatments%2Flaser-hair-removal%2Fwomen%2Fareas%2Fface1.webp&w=1024&q=75" alt="Facial laser hair removal" />
          </div>
        </div>
      </div>
    </section> -->

    <!-- Quick treatment info strip (as per reference screenshot) -->
    <section class="info-strip" aria-label="Treatment quick facts">
      <div class="container">
        <div class="info-grid">

          <div class="info-item">
            <div class="info-ico" aria-hidden="true">
              <!-- hourglass -->
              <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18 10h28" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                <path d="M18 54h28" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                <path d="M22 12c0 10 8 14 10 16-2 2-10 6-10 16" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                <path d="M42 12c0 10-8 14-10 16 2 2 10 6 10 16" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                <path d="M26 22h12" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                <path d="M26 42h12" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                <path d="M10 14c4-3 7-4 10-4" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-dasharray="4 6"/>
              </svg>
            </div>
            <div class="info-text">
              <p class="info-k">Treatment length</p>
              <p class="info-v">15 mins</p>
            </div>
          </div>

          <div class="info-item">
            <div class="info-ico" aria-hidden="true">
              <!-- clipboard -->
              <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M22 14h20" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                <path d="M24 10h16" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                <path d="M20 14h24c3 0 6 3 6 6v30c0 3-3 6-6 6H20c-3 0-6-3-6-6V20c0-3 3-6 6-6z" stroke="currentColor" stroke-width="2.2"/>
                <path d="M24 28h16" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                <path d="M24 36h10" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                <path d="M40 34l6 6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                <path d="M46 34l-6 6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
              </svg>
            </div>
            <div class="info-text">
              <p class="info-k">Number of sessions</p>
              <p class="info-v">6-10 Sessions</p>
            </div>
          </div>

          <div class="info-item">
            <div class="info-ico" aria-hidden="true">
              <!-- infinity -->
              <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M20 38c4 0 8-4 12-8s8-8 12-8c6 0 10 5 10 10s-4 10-10 10c-4 0-8-4-12-8s-8-8-12-8c-6 0-10 5-10 10s4 10 10 10" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                <path d="M42 38l4 4 8-10" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </div>
            <div class="info-text">
              <p class="info-k">Duration of results</p>
              <p class="info-v">Permanent</p>
            </div>
          </div>

          <div class="info-item">
            <div class="info-ico" aria-hidden="true">
              <!-- calendar -->
              <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18 14v8" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                <path d="M46 14v8" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                <path d="M16 20h32" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                <path d="M18 18h28c4 0 8 4 8 8v20c0 4-4 8-8 8H18c-4 0-8-4-8-8V26c0-4 4-8 8-8z" stroke="currentColor" stroke-width="2.2"/>
                <path d="M22 30h6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                <path d="M34 30h6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                <path d="M22 40h6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                <path d="M34 40h6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                <path d="M50 40c2 2 3 4 3 6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                <path d="M50 52c-3 0-6-2-8-4" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
              </svg>
            </div>
            <div class="info-text">
              <p class="info-k">Session frequency</p>
              <p class="info-v">Every 6-8 Weeks</p>
            </div>
          </div>

        </div>
      </div>
    </section>
    <!-- Real Results (before/after) -->
    <section class="results-split" aria-label="Real Results">
        <div class="container">
          <div class="results-grid">

            <div>
              <div class="ba-wrap">
                <div class="ba-frame" data-ba>
                  <!-- Replace these two URLs with your real BEFORE/AFTER images -->
                  <img class="ba-img" src="https://therapieclinic.com/_next/image?url=%2Fassets%2Ftreatments%2Flaser-hair-removal%2Fwomen%2Fareas%2Fface1.webp&w=1024&q=75" alt="Before" />

                  <div class="ba-top" data-ba-top>
                    <img class="ba-img-top" src="https://therapieclinic.com/_next/image?url=%2Fassets%2Ftreatments%2Flaser-hair-removal%2Fwomen%2Fareas%2Fface.webp&w=1536&q=75" alt="After" />
                  </div>

                  <div class="ba-divider" data-ba-divider></div>
                  <div class="ba-handle" aria-hidden="true">
                    <div class="ba-arrows">
                      <span>‹</span>
                      <span>›</span>
                    </div>
                  </div>

                  <div class="ba-pill before">Before</div>
                  <div class="ba-pill after">After</div>

                  <input class="ba-range" type="range" min="0" max="100" value="50" aria-label="Before and after slider" data-ba-range />
                </div>
              </div>

              <div class="results-chip">Face</div>
            </div>

            <div>
              <div class="results-kicker">OUR CLIENTS SEE</div>
              <h2 class="results-title">Real Results</h2>
              <p class="results-copy">
                You’ll see visible results from your very first session, with the best outcomes typically achieved after 6-10 sessions.
                Whether it’s your legs, thighs, or bikini line, our treatments deliver fast results that leave your skin smooth and hair-free.
              </p>

              <div class="hero-actions">
                <a class="btn btn-primary" style="background: #000;color: #fff;" href="book-free-consultation">Book free consultation</a>
              </div>
            </div>

          </div>
        </div>
      </section>

      <!-- Testimonials (as per reference screenshot) -->
      <section class="testimonials" aria-label="What our clients say">
        <div class="container">
          <div class="test-head">
            <div>
              <div class="test-kicker">YOU MAKE US LOOK GOOD</div>
              <h2 class="test-title">What our clients say</h2>
            </div>

            <div class="test-nav" aria-label="Testimonials navigation">
              <button class="test-btn" type="button" aria-label="Previous" data-test-prev>‹</button>
              <button class="test-btn" type="button" aria-label="Next" data-test-next>›</button>
            </div>
          </div>

          <div class="test-track" data-test-track>
            <article class="review-card">
              <div class="review-top">
                <div>
                  <p class="review-name">Caitlin Reid</p>
                  <div class="review-stars" aria-label="5 star rating">
                    <svg viewBox="0 0 24 24"><path d="M12 17.3l-6.18 3.7 1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.63 7.19.61-5.46 4.73L18.18 21z"/></svg>
                    <svg viewBox="0 0 24 24"><path d="M12 17.3l-6.18 3.7 1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.63 7.19.61-5.46 4.73L18.18 21z"/></svg>
                    <svg viewBox="0 0 24 24"><path d="M12 17.3l-6.18 3.7 1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.63 7.19.61-5.46 4.73L18.18 21z"/></svg>
                    <svg viewBox="0 0 24 24"><path d="M12 17.3l-6.18 3.7 1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.63 7.19.61-5.46 4.73L18.18 21z"/></svg>
                    <svg viewBox="0 0 24 24"><path d="M12 17.3l-6.18 3.7 1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.63 7.19.61-5.46 4.73L18.18 21z"/></svg>
                  </div>
                </div>
                <div class="review-meta">DSL Clinic, Dundee<br/>Feb 18, 2026</div>
                <p class="review-text">Just had my first laser session, Susan was lovely and friendly :) and no pain.</p>
              </div>
              <div class="review-source">
                <p class="g">Google</p>
                <div class="s">Official Review</div>
              </div>
            </article>

            <article class="review-card">
              <div class="review-top">
                <div>
                  <p class="review-name">Nicola Mccauley</p>
                  <div class="review-stars" aria-label="5 star rating">
                    <svg viewBox="0 0 24 24"><path d="M12 17.3l-6.18 3.7 1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.63 7.19.61-5.46 4.73L18.18 21z"/></svg>
                    <svg viewBox="0 0 24 24"><path d="M12 17.3l-6.18 3.7 1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.63 7.19.61-5.46 4.73L18.18 21z"/></svg>
                    <svg viewBox="0 0 24 24"><path d="M12 17.3l-6.18 3.7 1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.63 7.19.61-5.46 4.73L18.18 21z"/></svg>
                    <svg viewBox="0 0 24 24"><path d="M12 17.3l-6.18 3.7 1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.63 7.19.61-5.46 4.73L18.18 21z"/></svg>
                    <svg viewBox="0 0 24 24"><path d="M12 17.3l-6.18 3.7 1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.63 7.19.61-5.46 4.73L18.18 21z"/></svg>
                  </div>
                </div>
                <div class="review-meta">DSL Clinic, Kent - Bluewater Shopping Centre<br/>Feb 18, 2026</div>
                <p class="review-text">Absolutely excellent service from beginning to end explained everything thoroughly I felt so comfortable can’t wait to come back, Kerina and Nicola 😊</p>
              </div>
              <div class="review-source">
                <p class="g">Google</p>
                <div class="s">Official Review</div>
              </div>
            </article>

            <article class="review-card">
              <div class="review-top">
                <div>
                  <p class="review-name">Orla Maginness</p>
                  <div class="review-stars" aria-label="5 star rating">
                    <svg viewBox="0 0 24 24"><path d="M12 17.3l-6.18 3.7 1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.63 7.19.61-5.46 4.73L18.18 21z"/></svg>
                    <svg viewBox="0 0 24 24"><path d="M12 17.3l-6.18 3.7 1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.63 7.19.61-5.46 4.73L18.18 21z"/></svg>
                    <svg viewBox="0 0 24 24"><path d="M12 17.3l-6.18 3.7 1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.63 7.19.61-5.46 4.73L18.18 21z"/></svg>
                    <svg viewBox="0 0 24 24"><path d="M12 17.3l-6.18 3.7 1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.63 7.19.61-5.46 4.73L18.18 21z"/></svg>
                    <svg viewBox="0 0 24 24"><path d="M12 17.3l-6.18 3.7 1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.63 7.19.61-5.46 4.73L18.18 21z"/></svg>
                  </div>
                </div>
                <div class="review-meta">DSL Clinic, Newry<br/>Feb 18, 2026</div>
                <p class="review-text">I had lip filler done by injector Emma M in Newry clinic and WOW - I’ve had lip filler done many times but never have my lips been as perfect for my face shape!</p>
              </div>
              <div class="review-source">
                <p class="g">Google</p>
                <div class="s">Official Review</div>
              </div>
            </article>
          </div>
        </div>
      </section>

  
      <!-- How It Works (video) section (as per reference screenshot) -->
   <!--    <section class="howitworks" aria-label="How It Works">
        <div class="container">
          <div class="howitworks-head">
            <div class="howitworks-kicker">LONG LASTING RESULTS</div>
            <h2 class="howitworks-title">How It Works</h2>
          </div>

          <div class="howitworks-media">
            <?php
              // Set your video URL here (MP4). If caller doesn't set $howItWorksVideoUrl, use the default Mux MP4.
              $howItWorksVideoUrl = $howItWorksVideoUrl ?? 'https://stream.mux.com/W00KF3M7izF5402Ewj9cbAdaXNhq25U2anL6NtSP02g00G8/capped-1080p.mp4';
            ?>

            <video controls playsinline preload="metadata" style="width:100%;height:auto;display:block;">
              <source src="<?php echo htmlspecialchars($howItWorksVideoUrl, ENT_QUOTES, 'UTF-8'); ?>" type="video/mp4" />
              Your browser does not support the video tag.
            </video>
          </div>
        </div>
      </section> -->

      <!-- Klarna banner (as per reference screenshot) -->
      <section class="klarna-banner" aria-label="Klarna instalments">
        <div class="container">
          <div class="klarna-inner">
            <div class="klarna-kicker">A SMARTER WAY TO SHOP AND PAY</div>
            <h2 class="klarna-title">Pay in 3 interest-free<br/>instalments with <em>Klarna</em>.</h2>
            <a class="klarna-btn" style="background: #fff;color: #000;" href="#">Learn more</a>
          </div>
        </div>
      </section>

      <!-- Testimonials (as per reference screenshot) -->
      <section class="testimonials" aria-label="What our clients say">
        <div class="container">
          <div class="test-head">
            <div>
              <div class="test-kicker">YOU MAKE US LOOK GOOD</div>
              <h2 class="test-title">What our clients say</h2>
            </div>

            <div class="test-nav" aria-label="Testimonials navigation">
              <button class="test-btn" type="button" aria-label="Previous" data-test-prev>‹</button>
              <button class="test-btn" type="button" aria-label="Next" data-test-next>›</button>
            </div>
          </div>

          <div class="test-track" data-test-track>
            <article class="review-card">
              <div class="review-top">
                <div>
                  <p class="review-name">Caitlin Reid</p>
                  <div class="review-stars" aria-label="5 star rating">
                    <svg viewBox="0 0 24 24"><path d="M12 17.3l-6.18 3.7 1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.63 7.19.61-5.46 4.73L18.18 21z"/></svg>
                    <svg viewBox="0 0 24 24"><path d="M12 17.3l-6.18 3.7 1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.63 7.19.61-5.46 4.73L18.18 21z"/></svg>
                    <svg viewBox="0 0 24 24"><path d="M12 17.3l-6.18 3.7 1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.63 7.19.61-5.46 4.73L18.18 21z"/></svg>
                    <svg viewBox="0 0 24 24"><path d="M12 17.3l-6.18 3.7 1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.63 7.19.61-5.46 4.73L18.18 21z"/></svg>
                    <svg viewBox="0 0 24 24"><path d="M12 17.3l-6.18 3.7 1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.63 7.19.61-5.46 4.73L18.18 21z"/></svg>
                  </div>
                </div>
                <div class="review-meta">DSL Clinic, Dundee<br/>Feb 18, 2026</div>
                <p class="review-text">Just had my first laser session, Susan was lovely and friendly :) and no pain.</p>
              </div>
              <div class="review-source">
                <p class="g">Google</p>
                <div class="s">Official Review</div>
              </div>
            </article>

            <article class="review-card">
              <div class="review-top">
                <div>
                  <p class="review-name">Nicola Mccauley</p>
                  <div class="review-stars" aria-label="5 star rating">
                    <svg viewBox="0 0 24 24"><path d="M12 17.3l-6.18 3.7 1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.63 7.19.61-5.46 4.73L18.18 21z"/></svg>
                    <svg viewBox="0 0 24 24"><path d="M12 17.3l-6.18 3.7 1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.63 7.19.61-5.46 4.73L18.18 21z"/></svg>
                    <svg viewBox="0 0 24 24"><path d="M12 17.3l-6.18 3.7 1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.63 7.19.61-5.46 4.73L18.18 21z"/></svg>
                    <svg viewBox="0 0 24 24"><path d="M12 17.3l-6.18 3.7 1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.63 7.19.61-5.46 4.73L18.18 21z"/></svg>
                    <svg viewBox="0 0 24 24"><path d="M12 17.3l-6.18 3.7 1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.63 7.19.61-5.46 4.73L18.18 21z"/></svg>
                  </div>
                </div>
                <div class="review-meta">DSL Clinic, Kent - Bluewater Shopping Centre<br/>Feb 18, 2026</div>
                <p class="review-text">Absolutely excellent service from beginning to end explained everything thoroughly I felt so comfortable can’t wait to come back, Kerina and Nicola 😊</p>
              </div>
              <div class="review-source">
                <p class="g">Google</p>
                <div class="s">Official Review</div>
              </div>
            </article>

            <article class="review-card">
              <div class="review-top">
                <div>
                  <p class="review-name">Orla Maginness</p>
                  <div class="review-stars" aria-label="5 star rating">
                    <svg viewBox="0 0 24 24"><path d="M12 17.3l-6.18 3.7 1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.63 7.19.61-5.46 4.73L18.18 21z"/></svg>
                    <svg viewBox="0 0 24 24"><path d="M12 17.3l-6.18 3.7 1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.63 7.19.61-5.46 4.73L18.18 21z"/></svg>
                    <svg viewBox="0 0 24 24"><path d="M12 17.3l-6.18 3.7 1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.63 7.19.61-5.46 4.73L18.18 21z"/></svg>
                    <svg viewBox="0 0 24 24"><path d="M12 17.3l-6.18 3.7 1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.63 7.19.61-5.46 4.73L18.18 21z"/></svg>
                    <svg viewBox="0 0 24 24"><path d="M12 17.3l-6.18 3.7 1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.63 7.19.61-5.46 4.73L18.18 21z"/></svg>
                  </div>
                </div>
                <div class="review-meta">DSL Clinic, Newry<br/>Feb 18, 2026</div>
                <p class="review-text">I had lip filler done by injector Emma M in Newry clinic and WOW - I’ve had lip filler done many times but never have my lips been as perfect for my face shape!</p>
              </div>
              <div class="review-source">
                <p class="g">Google</p>
                <div class="s">Official Review</div>
              </div>
            </article>
          </div>
        </div>
      </section>



  </main>
</div>




 <section class="faq" aria-label="Frequently Asked Questions">
        <div class="container">
          <h2 class="faq-title">Frequently Asked Questions</h2>

          <div class="faq-inner" data-faq>

            <div class="faq-item" aria-expanded="false">
              <button class="faq-btn" type="button" aria-controls="faq-1" aria-expanded="false">
                <span>Is facial laser hair removal safe for all skin types?</span>
                <svg class="faq-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </button>
              <div class="faq-panel" id="faq-1" role="region" aria-hidden="true">
                <div>
                  Yes — when performed with the right technology and settings for your skin tone. Your clinician will assess your skin and hair type at consultation to tailor the treatment safely and effectively.
                </div>
              </div>
            </div>

            <div class="faq-item" aria-expanded="false">
              <button class="faq-btn" type="button" aria-controls="faq-2" aria-expanded="false">
                <span>How many facial laser hair removal sessions will I need?</span>
                <svg class="faq-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </button>
              <div class="faq-panel" id="faq-2" role="region" aria-hidden="true">
                <div>
                  Most people see the best outcomes after around 6–10 sessions. Exact numbers vary depending on hair growth cycle, hormone levels, and the area being treated.
                </div>
              </div>
            </div>

            <div class="faq-item" aria-expanded="false">
              <button class="faq-btn" type="button" aria-controls="faq-3" aria-expanded="false">
                <span>Does facial laser hair removal hurt?</span>
                <svg class="faq-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </button>
              <div class="faq-panel" id="faq-3" role="region" aria-hidden="true">
                <div>
                  Sensation is usually mild — often described as a quick warm snap. Modern devices include cooling to keep treatments comfortable, and most clients tolerate facial areas well.
                </div>
              </div>
            </div>

            <div class="faq-item" aria-expanded="false">
              <button class="faq-btn" type="button" aria-controls="faq-4" aria-expanded="false">
                <span>Can laser hair removal treat hormonal facial hair growth?</span>
                <svg class="faq-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </button>
              <div class="faq-panel" id="faq-4" role="region" aria-hidden="true">
                <div>
                  It can significantly reduce hair growth, but if hormones are driving regrowth (e.g., PCOS), you may need additional maintenance sessions to keep results consistent.
                </div>
              </div>
            </div>

            <div class="faq-item" aria-expanded="false">
              <button class="faq-btn" type="button" aria-controls="faq-5" aria-expanded="false">
                <span>How should I prepare for my facial laser hair removal treatment?</span>
                <svg class="faq-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </button>
              <div class="faq-panel" id="faq-5" role="region" aria-hidden="true">
                <div>
                  Avoid sun exposure and self-tan before treatment, shave the area as advised, and pause waxing/threading/plucking in the weeks leading up to your session. Your clinician will share a personalised prep plan.
                </div>
              </div>
            </div>

            <div class="faq-item" aria-expanded="false">
              <button class="faq-btn" type="button" aria-controls="faq-6" aria-expanded="false">
                <span>Are there any side effects of facial laser hair removal?</span>
                <svg class="faq-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </button>
              <div class="faq-panel" id="faq-6" role="region" aria-hidden="true">
                <div>
                  Temporary redness or warmth is common and usually settles quickly. Your clinician will guide you on aftercare to minimise irritation and protect your skin between sessions.
                </div>
              </div>
            </div>

          </div>
        </div>
      </section>

      













<!-- <section class="banner-acne p-0">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 p-0">
                <a href="https://share.google/NNg1CDBV051jzMDVD" target="_blank" rel="noopener noreferrer">
                    <img 
                        src="{{ !empty($icon_large11) ? asset('uploads/servicecat/' . $icon_large11) : asset('assets/img/media/1.jpg') }}" 
                        alt="{{ $category_name11 }}"
                        style="width:100%; height:auto; cursor:pointer;"
                    >
                </a>
            </div>
        </div>
    </div>
</section> -->

 
 <style>
     .option-card.active {
    border: 2px solid #000;
    background: #f5f5f5;
}
 </style>
  
   
<script>
let client_token = null;


let selectedPackage = null;

// select card
$(document).on('click', '.option-card', function () {
    $('.option-card').removeClass('active'); // remove old
    $(this).addClass('active'); // highlight

    // store selected data
    selectedPackage = {
        service_id: $(this).data('service'),
        session: $(this).data('session'),
        price: $(this).data('price'),
        name: $(this).find('h4').text(),
        image: $(this).data('image') // ✅ ADD THIS
    };
});


$('.header-cta').click(function () {

    if (!selectedPackage) {
        alert('Please select a package');
        return;
    }

    $.ajax({
        url: "{{ route('add.to.cart') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",

            // existing fields
            product_id: selectedPackage.service_id,
            name: selectedPackage.name + " Sessions: "+selectedPackage.session,
            price: selectedPackage.price,
            image: selectedPackage.image, 

            // ✅ NEW SERVICE FIELDS
            type: 'service',
            session: selectedPackage.session
        },
        success: function (res) {

            let html = '';

            res.items.forEach(function (item) {

                html += `
                <div class="cart-drawer__item" data-id="${item.id}">
                         <div class="cart-drawer__thumb">
                <img src="${item.image || '/assets/img/default.jpg'}" alt="${item.product_name}">
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

            $('#cartDrawerItems').html(html);
            $('#cartDrawerSubtotal').text(money(res.subtotal));
            $('.cart-badge').text(res.count);

            $('#cartDrawer').addClass('is-open');
        }
    });
});












document.getElementById("submit-button-klarna").addEventListener("click", () => {
    
    if (!$('#flexCheckDefault').prop('checked')) {
        $('#flexCheckDefault').focus().css('outline', '2px solid red'); // better than border for checkbox
        return false;
    } else {
        $('#flexCheckDefault').css('outline', '');
    }
    
    var billingData = {
        amount2: parseInt($('#amount2').val(), 10) * 100
    };
    
    
    
    fetch('/klarna/session', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            purchase_country: "GB",
            purchase_currency: "GBP",
            order_amount: billingData.amount2,
            order_tax_amount: 0,
            locale: "en-GB",
            order_lines: [
                {
                    name: "Dsl Product",
                    quantity: 1,
                    unit_price: billingData.amount2,
                    total_amount: billingData.amount2
                }
            ],
            merchant_urls: {
                confirmation: "https://dslclinic.com/order-success",
                cancel: "https://dslclinic.com/order-cancelled"
            }
        })
    })
    .then(res => res.json())
    .then(data => {
        client_token = data.client_token;
        console.log("Session Created:", data);

        Klarna.Payments.init({ client_token });

        Klarna.Payments.load({
            container: '#klarna_container',
            payment_method_category: 'pay_later' // or pay_now, pay_over_time
        }, function(res) {
            if (res.show_form) {
                //document.getElementById("klarna-pay-button").style.display = 'inline-block';
                document.getElementById("klarna_container").style.display = 'none';
                const payButton = document.getElementById("klarna-pay-button");
                payButton.click();
            }
        });
    });
});

document.getElementById("klarna-pay-button").addEventListener("click", () => {
    
    
    
    var billingData = {
        amount2: parseInt($('#amount2').val(), 10) * 100
    };
    
    
    Klarna.Payments.authorize(
        { payment_method_category: 'pay_later' },
        {},
        function (res) {
            console.log("Authorization Response:", res);
            if (res.approved && res.authorization_token) {
                fetch(`/klarna/order/${res.authorization_token}`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        purchase_country: "GB",
                        purchase_currency: "GBP",
                        order_amount: billingData.amount2,
                        order_tax_amount: 0,
                        locale: "en-GB",
                        order_lines: [
                            {
                                name: "Dsl Product",
                                quantity: 1,
                                unit_price: billingData.amount2,
                                total_amount: billingData.amount2
                            }
                        ],
                        merchant_reference1: "Order_Test_001"
                    })
                })
                .then(res => res.json())
                .then(order => {
                    console.log("Order Created:", order);
                    //alert("Order Created: " + order.order_id);
                    window.location.href = "/klarna/booking-success/" + order.order_id;
                });
            }
        }
    );
});
</script>
<script>
    function submitKlarnaForm() {
        
        if (!$('#flexCheckDefault').prop('checked')) {
            $('#flexCheckDefault').focus().css('outline', '2px solid red'); // better than border for checkbox
            return false;
        } else {
            $('#flexCheckDefault').css('outline', '');
        }

        
        console.log("Button clicked! Submitting Klarna form...");
        
        // Submit the hidden form
        document.getElementById("klarnaPaymentForm").submit();
    }
</script>

<script>
    document.getElementById('payment-form').addEventListener('submit', async (event) => {
        event.preventDefault();
        
        let amount = document.getElementById('amount').value;

        const response = await fetch("{{ route('stripe.create.payment') }}", {
            method: "POST",
            headers: { 
                'Content-Type': 'application/json', 
                'X-CSRF-TOKEN': "{{ csrf_token() }}" 
            },
            body: JSON.stringify({ amount: amount })
        });

        const data = await response.json();

        if (data.success) {
            window.location.href = data.payment_url;
        } else {
            document.getElementById('payment-result').innerText = data.message;
        }
    });
</script>

<script>
    
function addRemoveService(stype, sid, action, ssession, sprice) {
    
    
    if(stype!='addon'){
        var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
        myModal.show();
    }
    
    return $.ajax({
        url: "{{ route('addRemoveService') }}",
        type: 'POST',
        data: {
            "_token": "{{ csrf_token() }}",
            sid: sid,
            stype: stype,
            ssession: ssession,
            sprice: sprice,
            action: action,
        },
        beforeSend: function() {
           
        },
        success: function(res) {
            //console.log(res.sugpro);
            if (res.status === 'success') {
                
                $('#tprice').html('£'+res.tprice);
                $('#tsprice').html('£'+res.tsprice);
                $('#ttsprice').html('£'+res.ttsprice);
                $('#amount').val(res.ttsprice_num);
                $('#amount2').val(res.ttsprice_num);
                $('#abc').html(res.abc);
                $('#sugpro').html(res.sugpro);
                
                if (action === 'add') {
                    
                } else if (action === 'remove') {
                   
                }

                $('#cartCount').html(res.cartCount); // Replace `cartCount` with the correct key from the response
                
                //console.log('Cart updated successfully:', res);
            } else {
                //console.error('Failed to update the cart:', res.message);
                //alert('Something went wrong. Please try again.');
            }
        },
        error: function(err) {
            console.error('AJAX error:', err);
            alert('An error occurred while communicating with the server.');
        }
    });
}

    
</script> 


     
@include('frontend.partials.footer')