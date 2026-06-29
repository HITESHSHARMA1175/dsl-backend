<?php
/**
 * DSL Clinic - Location Details Page (Therapie-style)
 * - Includes existing header/footer if present (header.php, footer.php)
 * - Responsive 2-column layout: image left, info + opening times right
 * - Clean typography + large CTA button
 */
 
$slug = isset($_GET['slug']) ? strtolower(trim($_GET['slug'])) : 'bristol';

// You can expand this list or load from DB later.
$locations = [
  'bristol' => [
    'country' => 'United Kingdom',
    'name' => 'Bristol',
    'image' => 'https://therapieclinic.com/_next/image?url=%2Fassets%2Fimages%2Flocations%2Fbristol.webp&w=1920&q=75',
    'address' => 'Unit UR157 Upper Level, The Mall, Cribbs Causeway, Bristol, BS34 5DG, United Kingdom',
    'phone' => '+44 0117 463 2121',
    'opening_times' => [
      'Sunday' => '11:00 - 17:00',
      'Monday' => '09:30 - 20:00',
      'Tuesday' => '09:30 - 20:00',
      'Wednesday' => '09:30 - 20:00',
      'Thursday' => '09:30 - 20:00',
      'Friday' => '09:30 - 20:00',
      'Saturday' => '09:30 - 20:00',
    ],
  ],
];

$loc = $locations[$slug] ?? $locations['bristol'];

// Google Maps embed (no API key). Uses a simple query embed.
$mapQuery = urlencode(($loc['name'] ?? '') . ' ' . ($loc['address'] ?? ''));
$mapSrc = 'https://www.google.com/maps?q=' . $mapQuery . '&output=embed';

// Try to include shared header/footer if available.
$headerPath = __DIR__ . '/header.php';
$footerPath = __DIR__ . '/footer.php';
?><!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ $clinic->clinic_name }} | Locations</title>
  <style>
    :root{
      --bg:#ffffff;
      --ink:#0b1b2a;
      --muted:#5c6b7a;
      --line:rgba(11,27,42,.12);
      --surface:#f6f7fb;
      --purple:#6b64d8;
      --purple2:#5d57cd;
      --shadow:0 18px 46px rgba(11,27,42,.12);
      --radius:18px;
      --serif: ui-serif, Georgia, "Times New Roman", Times, serif;
      --sans: Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
    }

    *{box-sizing:border-box}
    body{margin:0; background:var(--bg); color:var(--ink); font-family:var(--sans)}
    a{color:inherit; text-decoration:none}

    main{width:100%;}

    .ld-wrap{
      width:100%;
      max-width:100%;
      margin:0;
      padding:24px 20px 24px;
    }

    .ld-breadcrumbs{
      display:flex;
      gap:10px;
      align-items:center;
      font-size:16px;
      color:rgba(11,27,42,.55);
      padding-top:8px;
      padding-bottom:16px;
    }
    .ld-breadcrumbs a{color:rgba(11,27,42,.55)}
    .ld-breadcrumbs a:hover{color:rgba(11,27,42,.85); text-decoration:underline; text-underline-offset:4px;}

    .ld-title{
      font-family:var(--serif);
      font-weight:500;
      letter-spacing:-.02em;
      font-size:72px;
      line-height:1.02;
      margin:6px 0 22px;
    }

    .ld-grid{
      display:grid;
      grid-template-columns: 1.4fr 1fr;
      gap:46px;
      align-items:start;
    }

    .ld-hero{
      width:100%;
      border-radius: 8px;
      overflow:hidden;
      background:#f1f2f5;
    }
    .ld-hero img{
      width:100%;
      height:auto;
      display:block;
      object-fit:cover;
    }

    .ld-side{
      width:100%;
    }

    .ld-card{
      width:100%;
      border:1px solid var(--line);
      border-radius: 22px;
      padding:26px 26px;
      background:#fff;
    }

    .ld-h{
      font-size:14px;
      font-weight:900;
      letter-spacing:.18em;
      text-transform:uppercase;
      color:rgba(11,27,42,.75);
      margin:0 0 14px;
    }

    .ld-row{
      display:grid;
      grid-template-columns: 22px 1fr;
      gap:12px;
      align-items:start;
      margin:12px 0;
      color:rgba(11,27,42,.88);
      font-weight:600;
      line-height:1.5;
    }

    .ld-ico{
      width:22px;
      height:22px;
      display:flex;
      align-items:center;
      justify-content:center;
      color:rgba(11,27,42,.75);
      margin-top:2px;
    }

    .ld-pill{
      margin-top:18px;
      display:flex;
      justify-content:center;
    }

    .ld-outline-btn{
      width:100%;
      height:56px;
      border-radius: 999px;
      border:1.6px solid rgba(11,27,42,.32);
      background:#fff;
      color:rgba(11,27,42,.88);
      font-weight:800;
      font-size:16px;
      cursor:pointer;
      transition:transform .15s ease, background .2s ease, border-color .2s ease;
    }
    .ld-outline-btn:hover{transform:translateY(-1px); background:rgba(11,27,42,.03); border-color:rgba(11,27,42,.42)}

    .ld-times{
      margin-top:26px;
    }

    .ld-times-grid{
      display:grid;
      grid-template-columns: 1fr auto;
      gap:12px 18px;
      padding-top:6px;
      font-size:16px;
      color:rgba(11,27,42,.92);
      font-weight:650;
    }
    .ld-times-grid .day{color:rgba(11,27,42,.92)}
    .ld-times-grid .time{color:rgba(11,27,42,.92)}

    .ld-cta{
      margin-top:22px;
    }

    .ld-cta a{
      display:flex;
      align-items:center;
      justify-content:center;
      height:62px;
      width:100%;
      border-radius:999px;
      background:linear-gradient(135deg, var(--purple), var(--purple2));
      color:#fff;
      font-weight:900;
      font-size:18px;
      letter-spacing:.01em;
      box-shadow:0 18px 34px rgba(107,100,216,.25);
      transition:transform .15s ease, filter .2s ease;
    }
    .ld-cta a:hover{transform:translateY(-1px); filter:saturate(1.06)}

    /* Full-bleed sections (100% viewport width) */
    .ld-fullbleed{
      width:100vw;
      margin-left:calc(50% - 50vw);
      margin-right:calc(50% - 50vw);
    }
    .ld-fullbleed-inner{
      width:100%;
      max-width:1280px;
      margin:0 auto;
      padding:0 20px;
    }

    .ld-map{
      margin-top:42px;
      width:100%;
      overflow:hidden;
      border-top:1px solid var(--line);
      border-bottom:1px solid var(--line);
      background:#e9ecef;
      position:relative;
      min-height:520px;
      border-radius:0;
      border-left:0;
      border-right:0;
    }

    .ld-map iframe{
      position:absolute;
      inset:0;
      width:100%;
      height:100%;
      border:0;
      display:block;
    }

    .ld-map-card{
      position:absolute;
      left:50%;
      top:26px;
      transform:translateX(-50%);
      width:min(560px, calc(100% - 28px));
      background:#fff;
      border-radius:16px;
      border:1px solid rgba(11,27,42,.14);
      box-shadow:0 16px 34px rgba(11,27,42,.18);
      padding:16px 56px 16px 18px;
      z-index:3;
    }

    .ld-map-card__title{
      font-weight:900;
      font-size:18px;
      letter-spacing:-.01em;
      margin:0 0 6px;
      color:rgba(11,27,42,.95);
    }

    .ld-map-card__sub{
      margin:0;
      font-weight:650;
      font-size:14px;
      line-height:1.45;
      color:rgba(11,27,42,.78);
    }

    .ld-map-card__x{
      position:absolute;
      right:12px;
      top:12px;
      width:34px;
      height:34px;
      border-radius:999px;
      border:1px solid rgba(11,27,42,.14);
      background:#fff;
      cursor:pointer;
      display:flex;
      align-items:center;
      justify-content:center;
      font-size:18px;
      color:rgba(11,27,42,.75);
    }

    .ld-map-card__x:hover{background:rgba(11,27,42,.04)}

    .ld-map-card.is-hidden{display:none;}

    /* Purple content section (Therapie-style) */
    .ld-purple{
      background:var(--purple);
      color:#fff;
      padding:70px 0 76px;
    }
    .ld-purple .kicker{
      font-weight:800;
      font-size:20px;
      opacity:.95;
      margin:0 0 22px;
    }
    .ld-purple .big{
      font-family:var(--serif);
      font-weight:500;
      letter-spacing:-.02em;
      font-size:64px;
      line-height:1.08;
      margin:0;
      color:#fff;
    }

    /* Treatments in clinic (carousel) */
    .tc-sec{background:#fff; padding:56px 0 44px;}
    /* Make this section truly full-width (edge-to-edge) */
    .tc-inner{width:100%; max-width:100%; margin:0; padding:0;}
    .tc-head{padding:0 20px;}
    .tc-track{padding:0 20px 10px; scroll-padding:20px;}
    @media (max-width: 520px){
      .tc-head{padding:0 14px;}
      .tc-track{padding:0 14px 10px; scroll-padding:14px;}
    }
    .tc-head{display:flex; align-items:flex-start; justify-content:space-between; gap:18px;}
    .tc-kicker{font-weight:900; letter-spacing:.18em; text-transform:uppercase; font-size:14px; color:var(--purple); margin:0 0 10px;}
    .tc-title{font-family:var(--serif); font-weight:500; letter-spacing:-.02em; font-size:66px; line-height:1.02; margin:0; color:var(--ink);}

    .tc-nav{display:flex; gap:10px; align-items:center; padding-top:10px;}
    .tc-arrow{
      width:46px; height:46px; border-radius:999px;
      border:1px solid rgba(11,27,42,.12);
      background:#f6f6f8;
      cursor:pointer;
      display:flex; align-items:center; justify-content:center;
      color:rgba(11,27,42,.75);
      transition:transform .15s ease, background .2s ease, border-color .2s ease;
    }
    .tc-arrow:hover{transform:translateY(-1px); background:#fff; border-color:rgba(11,27,42,.18)}

    .tc-track{
      margin-top:28px;
      display:grid;
      grid-auto-flow:column;
      grid-auto-columns: minmax(320px, 1fr);
      gap:16px;
      overflow:auto;
      scroll-snap-type:x mandatory;
      -webkit-overflow-scrolling: touch;
      padding-bottom:10px;
    }
    .tc-track::-webkit-scrollbar{height:10px;}
    .tc-track::-webkit-scrollbar-track{background:transparent;}
    .tc-track::-webkit-scrollbar-thumb{background:rgba(11,27,42,.12); border-radius:999px;}

    .tc-card{
      position:relative;
      border-radius: 8px;
      overflow:hidden;
      background:#eee;
      height:520px;
      scroll-snap-align:start;
    }
    .tc-card img{width:100%; height:100%; object-fit:cover; display:block;}

    .tc-overlay{
      position:absolute; inset:0;
      background:linear-gradient(180deg, rgba(0,0,0,.10) 0%, rgba(0,0,0,.32) 65%, rgba(0,0,0,.36) 100%);
    }

    .tc-content{
      position:absolute;
      left:22px;
      bottom:20px;
      right:22px;
      display:flex;
      flex-direction:column;
      gap:18px;
    }

    .tc-card-title{
      font-family:var(--serif);
      font-weight:500;
      letter-spacing:-.02em;
      font-size:48px;
      line-height:1.02;
      color:#fff;
      text-shadow:0 10px 28px rgba(0,0,0,.28);
    }

    .tc-btn{
      width:max-content;
      padding:12px 22px;
      border-radius:999px;
      background:#fff;
      color:rgba(11,27,42,.92);
      font-weight:900;
      font-size:14px;
      letter-spacing:.02em;
      box-shadow:0 14px 26px rgba(0,0,0,.12);
    }

    .tc-dots{display:flex; justify-content:center; gap:10px; margin-top:18px;}
    .tc-dot{width:82px; height:3px; border-radius:999px; background:rgba(11,27,42,.12);}
    .tc-dot.is-active{background:rgba(11,27,42,.65);}

    /* Reviews section */
    .rv-sec{background:#f6f6f8; padding:70px 0 80px;}
    .rv-inner{width:100%; max-width:100%; margin:0; padding:0 20px;}
    .rv-head{display:flex; justify-content:space-between; align-items:flex-start; gap:20px;}
    .rv-kicker{
      font-weight:900;
      letter-spacing:.18em;
      text-transform:uppercase;
      font-size:14px;
      color:var(--purple);
      margin:0 0 10px;
    }
    .rv-title{
      font-family:var(--serif);
      font-weight:500;
      letter-spacing:-.02em;
      font-size:66px;
      line-height:1.02;
      margin:0;
      color:var(--ink);
    }

    .rv-nav{display:flex; gap:10px; padding-top:10px;}
    .rv-arrow{
      width:46px; height:46px;
      border-radius:999px;
      border:1px solid rgba(11,27,42,.12);
      background:#ececf2;
      display:flex; align-items:center; justify-content:center;
      cursor:pointer;
      transition:.2s ease;
    }
    .rv-arrow:hover{background:#fff;}

    .rv-track{
      margin-top:30px;
      display:grid;
      grid-auto-flow:column;
      grid-auto-columns:minmax(320px, 1fr);
      gap:20px;
      overflow:auto;
      scroll-snap-type:x mandatory;
      padding-bottom:10px;
    }

    .rv-card{
      background:#fff;
      border-radius:22px;
      padding:26px 24px 22px;
      box-shadow:0 14px 30px rgba(11,27,42,.06);
      scroll-snap-align:start;
      display:flex;
      flex-direction:column;
      gap:12px;
    }

    .rv-name{font-weight:900; font-size:20px;}
    .rv-stars{color:#f4b400; letter-spacing:3px;}
    .rv-meta{font-size:14px; color:rgba(11,27,42,.6);}
    .rv-text{font-size:16px; line-height:1.6; color:rgba(11,27,42,.85); margin:6px 0 10px;}
    .rv-source{margin-top:auto; font-weight:900;}
    .rv-source span{display:block; font-weight:600; font-size:13px; color:rgba(11,27,42,.6);}

    @media (max-width: 980px){
      .rv-sec{padding:50px 0 60px;}
      .rv-title{font-size:48px;}
    }

    @media (max-width: 520px){
      .rv-inner{padding:0 14px;}
      .rv-title{font-size:36px;}
      .rv-nav{display:none;}
    }
    @media (max-width: 980px){
      .tc-sec{padding:44px 0 34px;}
      .tc-title{font-size:48px;}
      .tc-card{height:460px;}
      .tc-card-title{font-size:40px;}
      .tc-dot{width:64px;}
    }

    @media (max-width: 520px){
      .tc-sec{padding:34px 0 28px;}
      .tc-title{font-size:40px;}
      .tc-card{height:420px;}
      .tc-content{left:16px; right:16px; bottom:16px;}
      .tc-card-title{font-size:34px;}
      .tc-dot{width:46px;}
      .tc-nav{display:none;}
    }

    /* Personalised plans (dark CTA section) */
    .pp-sec{
      background:#151515;
      color:#fff;
      padding:92px 0 96px;
      position:relative;
      overflow:hidden;
    }
    .pp-inner{width:100%; max-width:100%; margin:0; padding:0 20px;}
    .pp-center{max-width:980px; margin:0 auto; text-align:center;}
    .pp-kicker{
      font-weight:900;
      letter-spacing:.18em;
      text-transform:uppercase;
      font-size:14px;
      color:rgba(150,140,255,.9);
      margin:0 0 18px;
    }
    .pp-title{
      font-family:var(--serif);
      font-weight:500;
      letter-spacing:-.02em;
      font-size:72px;
      line-height:1.04;
      margin:0;
      color:#fff;
    }
    .pp-title em{font-style:italic;}

    .pp-cta{margin-top:32px; display:flex; justify-content:center;}
    .pp-btn{
      display:inline-flex;
      align-items:center;
      justify-content:center;
      height:58px;
      padding:0 34px;
      border-radius:999px;
      border:1px solid rgba(255,255,255,.22);
      background:linear-gradient(135deg, var(--purple), var(--purple2));
      color:#fff;
      font-weight:900;
      font-size:16px;
      letter-spacing:.01em;
      box-shadow:0 18px 34px rgba(107,100,216,.22);
      transition:transform .15s ease, filter .2s ease;
      white-space:nowrap;
    }
    .pp-btn:hover{transform:translateY(-1px); filter:saturate(1.06)}

    @media (max-width: 980px){
      .pp-sec{padding:70px 0 74px;}
      .pp-title{font-size:52px;}
    }
    @media (max-width: 520px){
      .pp-sec{padding:58px 0 62px;}
      .pp-inner{padding:0 14px;}
      .pp-title{font-size:38px; line-height:1.08;}
      .pp-cta{margin-top:24px;}
      .pp-btn{height:54px; padding:0 24px; font-size:15px;}
    }

    @media (max-width: 980px){
      .ld-wrap{padding:18px 14px 38px;}
      .ld-title{font-size:52px;}
      .ld-grid{grid-template-columns: 1fr; gap:20px;}
      .ld-card{padding:20px; border-radius:20px;}
      .ld-hero{border-radius: 10px;}
      .ld-map{min-height:420px; margin-top:26px; border-radius:0;}
      .ld-purple{padding:56px 0 60px;}
      .ld-purple .big{font-size:46px;}
      .ld-purple .kicker{font-size:18px;}
    }

    @media (max-width: 520px){
      .ld-title{font-size:42px;}
      .ld-breadcrumbs{font-size:14px;}
      .ld-outline-btn{height:52px; font-size:15px;}
      .ld-cta a{height:58px; font-size:16px;}
      .ld-map{min-height:360px;}
      .ld-map-card{top:14px; padding:14px 52px 14px 14px;}
      .ld-map-card__title{font-size:16px;}
      .ld-purple{padding:44px 0 52px;}
      .ld-purple .big{font-size:34px; line-height:1.12;}
      .ld-purple .kicker{font-size:16px;}
    }
  </style>
</head>
<body>

@include('frontend.partials.header')

<main id="main">
  <div class="ld-wrap">

    <div class="ld-breadcrumbs" aria-label="Breadcrumb">
      <a href="{{ route('locations') }}">Locations</a>
      <span aria-hidden="true">/</span>
      <span>{{ $clinic->clinic_name }}</span>
    </div>

    <h1 class="ld-title">{{ $clinic->clinic_name }}</h1>

    <section class="ld-grid" aria-label="Location details">
      <div class="ld-hero">
        <img src="{{ asset('uploads/clinic/'.$clinic->profile) }}" alt="{{ $clinic->clinic_name }}" loading="lazy" />
      </div>

      <aside class="ld-side">
        <div class="ld-card">
          <h2 class="ld-h">Information</h2>

          <div class="ld-row">
            <div class="ld-ico" aria-hidden="true">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 21s-7-5.33-7-11a7 7 0 1 1 14 0c0 5.67-7 11-7 11z"/>
                <circle cx="12" cy="10" r="2.5"/>
              </svg>
            </div>
            <div>{{ $clinic->address }}</div>
          </div>

          <div class="ld-row">
            <div class="ld-ico" aria-hidden="true">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 16.9v3a2 2 0 0 1-2.2 2A19.8 19.8 0 0 1 3.1 5.2 2 2 0 0 1 5.1 3h3a2 2 0 0 1 2 1.7c.1.9.3 1.8.6 2.6a2 2 0 0 1-.5 2.1L9 10.9a16 16 0 0 0 4.1 4.1l1.5-1.2a2 2 0 0 1 2.1-.5c.8.3 1.7.5 2.6.6a2 2 0 0 1 1.7 2z"/>
              </svg>
            </div>
            <div>
              <a href="tel:{{ preg_replace('/[^0-9+]/','',$clinic->clinic_phone) }}">
                    {{ $clinic->clinic_phone }}
                </a>
            </div>
          </div>

          <div class="ld-pill">
            <button class="ld-outline-btn" type="button" onclick="document.getElementById('ldContactModal')?.classList.add('is-open'); document.documentElement.style.overflow='hidden';">
              Get in touch
            </button>
          </div>

          <div class="ld-times">
            <h2 class="ld-h" style="margin-top:0;">Opening times</h2>
            <div class="ld-times-grid" role="table" aria-label="Opening times">
              @if($clinic->mon_to_fry)
                  <div>Mon - Fri</div>
                  <div>{{ date('h:i A', strtotime($clinic->clinic_start_time)) }} - {{ date('h:i A', strtotime($clinic->clinic_close_time)) }}</div>
                @endif
                
                @if($clinic->sat)
                  <div>Saturday</div>
                  <div>{{ date('h:i A', strtotime($clinic->sat_start_time)) }} - {{ date('h:i A', strtotime($clinic->sat_close_time)) }}</div>
                @endif
                
                @if($clinic->sun)
                  <div>Sunday</div>
                  <div>{{ date('h:i A', strtotime($clinic->sun_start_time)) }} - {{ date('h:i A', strtotime($clinic->sun_close_time)) }}</div>
                @endif
            </div>
          </div>

          <div class="ld-cta">
            <a href="appointment.php">Book free consultation</a>
          </div>
        </div>
      </aside>
    </section>

    <!-- Map -->
    <section class="ld-map ld-fullbleed" aria-label="Map">
      <iframe
          src="https://www.google.com/maps?q={{ urlencode($clinic->address ?? $clinic->address) }}&output=embed">
        </iframe>

      <div id="ldMapCard" class="ld-map-card" role="note" aria-label="Location pin">
        <button class="ld-map-card__x" type="button" aria-label="Close" onclick="hideLdMapCard()">✕</button>
        <div class="ld-map-card__title">{{ $clinic->clinic_name }} Clinic</div>
        <p class="ld-map-card__sub">{{ $clinic->address }}</p>
      </div>
    </section>

    <!-- Purple content section -->
    <section class="ld-purple ld-fullbleed" aria-label="Clinic description">
      <div class="ld-fullbleed-inner">
        <div class="kicker">DSL Clinic, {{ $clinic->clinic_name }}</div>
        <p class="big">{{ $clinic->address }}</p>
      </div>
    </section>

    <!-- Treatments in clinic (carousel) -->
    <section class="tc-sec ld-fullbleed" aria-label="Treatments in clinic">
      <div class="tc-inner">
        <div class="tc-head">
          <div>
            <div class="tc-kicker">BEGIN YOUR JOURNEY</div>
            <h2 class="tc-title">Treatments in clinic</h2>
          </div>

          <div class="tc-nav" aria-label="Carousel controls">
            <button class="tc-arrow" type="button" aria-label="Previous" onclick="tcScroll(-1)">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
            </button>
            <button class="tc-arrow" type="button" aria-label="Next" onclick="tcScroll(1)">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
            </button>
          </div>
        </div>

        <div class="tc-track" id="tcTrack" role="group" aria-roledescription="carousel">
          <a class="tc-card" href="#" aria-label="Laser Hair Removal for Women">
            <img src="https://therapieclinic.com/_next/image?url=%2Fassets%2Foffers%2Foffers%2Flower-legs-any-bikini-underarms.webp&w=1536&q=75" alt="Laser Hair Removal for Women" loading="lazy" />
            <div class="tc-overlay"></div>
            <div class="tc-content">
              <div class="tc-card-title">Laser Hair Removal<br/>For Women</div>
              <div class="tc-btn" role="button" aria-hidden="true">Explore</div>
            </div>
          </a>

          <a class="tc-card" href="#" aria-label="Laser Hair Removal for Men">
            <img src="https://therapieclinic.com/_next/image?url=%2Fassets%2Foffers%2Foffers%2FusBodyFace.webp&w=1536&q=75" alt="Laser Hair Removal for Men" loading="lazy" />
            <div class="tc-overlay"></div>
            <div class="tc-content">
              <div class="tc-card-title">Laser Hair Removal<br/>For Men</div>
              <div class="tc-btn" role="button" aria-hidden="true">Explore</div>
            </div>
          </a>

          <a class="tc-card" href="#" aria-label="Cosmetic Injections">
            <img src="https://therapieclinic.com/_next/image?url=%2Fassets%2Foffers%2Foffers%2Fevegrn-anti-wrinkle-exiting.webp&w=1536&q=75" alt="Cosmetic Injections" loading="lazy" />
            <div class="tc-overlay"></div>
            <div class="tc-content">
              <div class="tc-card-title">Cosmetic<br/>Injections</div>
              <div class="tc-btn" role="button" aria-hidden="true">Explore</div>
            </div>
          </a>
        </div>

        <div class="tc-dots" id="tcDots" aria-label="Carousel pagination"></div>
      </div>
    </section>

    <!-- Personalised plans (dark CTA section) -->
    <section class="pp-sec ld-fullbleed" aria-label="Personalised plans">
      <div class="pp-inner">
        <div class="pp-center">
          <div class="pp-kicker">PERSONALISED PLANS</div>
          <h2 class="pp-title">Let our team of experts<br/>build tailored treatments <em>just for you.</em></h2>
          <div class="pp-cta">
            <a class="pp-btn" href="appointment.php">Book free consultation</a>
          </div>
        </div>
      </div>
    </section>

    <!-- Reviews section -->
    <section class="rv-sec ld-fullbleed" aria-label="Client reviews">
      <div class="rv-inner">
        <div class="rv-head">
          <div>
            <div class="rv-kicker">YOU MAKE US LOOK GOOD</div>
            <h2 class="rv-title">What our clients say</h2>
          </div>

          <div class="rv-nav">
            <button class="rv-arrow" type="button" onclick="rvScroll(-1)">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M15 18l-6-6 6-6"/>
              </svg>
            </button>
            <button class="rv-arrow" type="button" onclick="rvScroll(1)">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 18l6-6-6-6"/>
              </svg>
            </button>
          </div>
        </div>

        <div class="rv-track" id="rvTrack">

        @forelse($reviews as $review)
        
            <div class="rv-card">
                <div class="rv-name">{{ $review->full_name }}</div>
        
                <div class="rv-stars">
                    {!! str_repeat('★', $review->rating) !!}
                </div>
        
                <div class="rv-meta">
                    {{ $clinic->clinic_name }},
                    {{ date('M d, Y', strtotime($review->adddate)) }}
                </div>
        
                <p class="rv-text">
                    {{ $review->description }}
                </p>
        
                <div class="rv-source">
                    Google<br/>
                    <span>Official Review</span>
                </div>
            </div>
        
        @empty
        
            <div class="rv-card">
                <p>No reviews available.</p>
            </div>
        
        @endforelse
        
        </div>
      </div>
    </section>

  </div>
</main>

<!-- Simple modal for "Get in touch" -->
<div id="ldContactModal" class="ld-modal" aria-hidden="true">
  <div class="ld-modal__backdrop" onclick="closeLdModal()"></div>
  <div class="ld-modal__panel" role="dialog" aria-modal="true" aria-label="Get in touch">
    <div class="ld-modal__top">
      <div class="ld-modal__title">Get in touch</div>
      <button class="ld-modal__x" type="button" aria-label="Close" onclick="closeLdModal()">✕</button>
    </div>

    <form class="ld-form" method="post" action="#" onsubmit="event.preventDefault(); alert('Thanks! We\'ll contact you shortly.'); closeLdModal();">
      <label>
        Name
        <input required type="text" name="name" placeholder="Your name" />
      </label>
      <label>
        Phone
        <input required type="tel" name="phone" placeholder="Your phone" />
      </label>
      <label>
        Message
        <textarea name="message" rows="4" placeholder="How can we help?"></textarea>
      </label>
      <button class="ld-submit" type="submit">Send</button>
    </form>
  </div>
</div>

<style>
  .ld-modal{position:fixed; inset:0; z-index:5000; display:none;}
  .ld-modal.is-open{display:block;}
  .ld-modal__backdrop{position:absolute; inset:0; background:rgba(0,0,0,.45);}
  .ld-modal__panel{
    position:absolute;
    left:50%;
    top:50%;
    transform:translate(-50%, -50%);
    width:min(520px, 92vw);
    background:#fff;
    border-radius:22px;
    box-shadow:var(--shadow);
    overflow:hidden;
  }
  .ld-modal__top{display:flex; align-items:center; justify-content:space-between; padding:16px 18px; border-bottom:1px solid var(--line);}
  .ld-modal__title{font-weight:900; font-size:20px;}
  .ld-modal__x{width:40px; height:40px; border-radius:999px; border:1px solid var(--line); background:#fff; cursor:pointer; font-size:18px;}

  .ld-form{display:grid; gap:12px; padding:16px 18px 18px;}
  .ld-form label{display:grid; gap:6px; font-weight:800; color:rgba(11,27,42,.82); font-size:14px;}
  .ld-form input, .ld-form textarea{
    width:100%;
    padding:12px 12px;
    border-radius:14px;
    border:1px solid rgba(11,27,42,.16);
    outline:none;
    font:inherit;
  }
  .ld-form input:focus, .ld-form textarea:focus{border-color:rgba(107,100,216,.55); box-shadow:0 0 0 4px rgba(107,100,216,.18)}
  .ld-submit{
    height:52px;
    border-radius:999px;
    border:0;
    cursor:pointer;
    background:linear-gradient(135deg, var(--purple), var(--purple2));
    color:#fff;
    font-weight:900;
    font-size:16px;
  }
</style>

<script>
  function closeLdModal(){
    const m = document.getElementById('ldContactModal');
    if(!m) return;
    m.classList.remove('is-open');
    document.documentElement.style.overflow='';
  }
  function hideLdMapCard(){
    const c = document.getElementById('ldMapCard');
    if(!c) return;
    c.classList.add('is-hidden');
  }
  document.addEventListener('keydown', (e)=>{
    if(e.key === 'Escape') closeLdModal();
  });

  // Treatments carousel
  function tcGetCards(){
    return Array.from(document.querySelectorAll('#tcTrack .tc-card'));
  }

  function tcEnsureDots(){
    const dotsWrap = document.getElementById('tcDots');
    const cards = tcGetCards();
    if(!dotsWrap || !cards.length) return;
    if(dotsWrap.childElementCount === cards.length) return;
    dotsWrap.innerHTML = '';
    cards.forEach((_, i)=>{
      const d = document.createElement('button');
      d.type = 'button';
      d.className = 'tc-dot' + (i===0 ? ' is-active' : '');
      d.setAttribute('aria-label', 'Go to slide ' + (i+1));
      d.style.border = '0';
      d.style.padding = '0';
      d.style.cursor = 'pointer';
      d.style.background = '';
      d.addEventListener('click', ()=>tcGo(i));
      dotsWrap.appendChild(d);
    });
  }

  function tcActiveIndex(){
    const track = document.getElementById('tcTrack');
    const cards = tcGetCards();
    if(!track || !cards.length) return 0;
    const left = track.scrollLeft;
    let best = 0;
    let bestDist = Infinity;
    cards.forEach((c, i)=>{
      const dist = Math.abs(c.offsetLeft - left);
      if(dist < bestDist){ bestDist = dist; best = i; }
    });
    return best;
  }

  function tcSetActiveDot(i){
    const dotsWrap = document.getElementById('tcDots');
    if(!dotsWrap) return;
    Array.from(dotsWrap.children).forEach((el, idx)=>{
      el.classList.toggle('is-active', idx === i);
    });
  }

  function tcGo(i){
    const track = document.getElementById('tcTrack');
    const cards = tcGetCards();
    if(!track || !cards[i]) return;
    track.scrollTo({ left: cards[i].offsetLeft, behavior: 'smooth' });
    tcSetActiveDot(i);
  }

  function tcScroll(dir){
    const track = document.getElementById('tcTrack');
    const cards = tcGetCards();
    if(!track || !cards.length) return;
    const i = tcActiveIndex();
    const next = Math.max(0, Math.min(cards.length - 1, i + dir));
    tcGo(next);
  }

  (function tcInit(){
    tcEnsureDots();
    const track = document.getElementById('tcTrack');
    if(!track) return;
    let t;
    track.addEventListener('scroll', ()=>{
      window.clearTimeout(t);
      t = window.setTimeout(()=>tcSetActiveDot(tcActiveIndex()), 60);
    }, { passive:true });
    window.addEventListener('resize', ()=>{ tcEnsureDots(); tcSetActiveDot(tcActiveIndex()); });
  })();

  function rvScroll(dir){
    const track = document.getElementById('rvTrack');
    if(!track) return;
    const cardWidth = track.querySelector('.rv-card')?.offsetWidth || 320;
    track.scrollBy({ left: dir * (cardWidth + 20), behavior: 'smooth' });
  }
</script>

@include('frontend.partials.footer')

</body>
</html>
