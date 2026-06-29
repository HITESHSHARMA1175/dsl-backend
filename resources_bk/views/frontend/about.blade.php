<?php
/**
 * About page
 * - Includes shared header/footer by fetching these endpoints:
 *   https://mobileemilocker.com/DSL/header
 *   https://mobileemilocker.com/DSL/footer
 *
 * NOTE: We fetch via cURL (preferred) with file_get_contents fallback.
 */

function dsl_fetch_partial(string $url): string {
    // Prefer cURL (more reliable on many hosts)
    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 5,
            CURLOPT_CONNECTTIMEOUT => 8,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (DSL About Page)'
        ]);
        $out = curl_exec($ch);
        $code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err  = curl_error($ch);
        curl_close($ch);

        if ($out !== false && $code >= 200 && $code < 300) {
            return $out;
        }

        // If cURL failed, fall through to file_get_contents
    }

    // Fallback
    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'timeout' => 15,
            'header' => "User-Agent: Mozilla/5.0 (DSL About Page)\r\n"
        ]
    ]);

    $out = @file_get_contents($url, false, $context);
    return $out !== false ? $out : '';
}

//$__dsl_header_html = dsl_fetch_partial('https://mobileemilocker.com/DSL/header');
//$__dsl_footer_html = dsl_fetch_partial('https://mobileemilocker.com/DSL/footer');
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>About</title>

  <!-- Elegant serif similar to Therapie style -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
    :root{
      --bg: #ffffff;
      --section-bg: #f3f4f7;
      --text: #0b0f1a;
      --muted: rgba(11,15,26,0.55);
      --label: rgba(11,15,26,0.55);
    }

    /* Ensure true 100% width and no horizontal scroll */
    html, body { width: 100%; max-width: 100%; overflow-x: hidden; }
    body{
      margin: 0;
      background: var(--bg);
      color: var(--text);
      font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
    }

    /* If any included header adds default padding/margins, keep page consistent */
    .dsl-page{ width: 100%; }

    /* Stats section (85+, 200+, 20+, 10 million+) */
    .stats-strip{
      width: 100%;
      background: var(--section-bg);
      padding: 64px 0;
    }
    .stats-inner{
      width: min(1320px, calc(100% - 80px));
      margin: 0 auto;
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 48px;
      align-items: center;
      justify-items: center;
      text-align: center;
    }

    .stat-num{
      font-family: "Playfair Display", serif;
      font-weight: 500;
      letter-spacing: -0.02em;
      font-size: clamp(48px, 6.5vw, 104px);
      line-height: 1;
      margin: 0;
      color: var(--text);
    }

    .stat-label{
      margin-top: 14px;
      font-size: 14px;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      color: var(--label);
    }

    @media (max-width: 1024px){
      .stats-strip{ padding: 56px 0; }
      .stats-inner{ grid-template-columns: repeat(2, 1fr); gap: 40px 24px; width: min(960px, calc(100% - 48px)); }
    }

    @media (max-width: 640px){
      .stats-strip{ padding: 44px 0; }
      .stats-inner{ grid-template-columns: 1fr; gap: 28px; width: calc(100% - 32px); }
      .stat-label{ font-size: 12px; }
    }

    /* About split section (Helping you look and feel your best every day.) */
    .about-split{
      width: 100%;
      background: #ffffff;
      padding: 96px 0;
    }
    .about-inner{
      width: min(1320px, calc(100% - 80px));
      margin: 0 auto;
      display: grid;
      grid-template-columns: 1.05fr 0.95fr;
      gap: 80px;
      align-items: center;
    }
    .about-kicker{
      font-size: 14px;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      color: #6b63ff;
      font-weight: 600;
      margin: 0 0 18px 0;
    }
    .about-title{
      font-family: "Playfair Display", serif;
      font-weight: 500;
      letter-spacing: -0.03em;
      font-size: clamp(44px, 5.2vw, 92px);
      line-height: 0.98;
      margin: 0 0 28px 0;
      color: #0b0f1a;
    }
    .about-copy{
      max-width: 680px;
      font-size: 18px;
      line-height: 1.8;
      color: rgba(11,15,26,0.62);
      margin: 0;
    }
    .about-media{
      width: 100%;
      background: #7b79e8;
      display: flex;
      justify-content: center;
      align-items: flex-end;
      padding: 44px;
      border-radius: 0;
      overflow: hidden;
      min-height: 520px;
    }
    .about-media img{
      width: auto;
      max-width: 100%;
      max-height: 560px;
      height: auto;
      display: block;
    }

    @media (max-width: 1024px){
      .about-split{ padding: 72px 0; }
      .about-inner{ grid-template-columns: 1fr; gap: 40px; width: min(960px, calc(100% - 48px)); }
      .about-media{ min-height: 420px; padding: 32px; }
      .about-title{ line-height: 1.02; }
    }

    @media (max-width: 640px){
      .about-split{ padding: 52px 0; }
      .about-inner{ width: calc(100% - 32px); }
      .about-copy{ font-size: 16px; }
      .about-media{ min-height: 340px; padding: 22px; }
    }

    /* About split (alt) - Empowered to Belong */
    .about-split.alt{
      background: #ffffff;
      padding: 96px 0;
    }
    .about-split.alt .about-kicker{
      color: #6b63ff;
    }

    @media (max-width: 1024px){
      .about-split.alt{ padding: 72px 0; }
    }

    @media (max-width: 640px){
      .about-split.alt{ padding: 52px 0; }
    }

    /* Dark journey section (Your Journey with DSL Clinic) */
    .journey-dark{
      width: 100%;
      background: #1f1f1f;
      padding: 96px 0;
    }
    .journey-inner{
      width: min(1320px, calc(100% - 80px));
      margin: 0 auto;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 80px;
      align-items: center;
    }
    .journey-media{
      width: 100%;
      background: #6b63ff;
      padding: 36px;
      display: flex;
      justify-content: center;
      align-items: flex-end;
      overflow: hidden;
      border-radius: 0;
      min-height: 560px;
    }
    .journey-media img{
      width: auto;
      max-width: 100%;
      height: auto;
      max-height: 620px;
      display: block;
    }

    .journey-kicker{
      font-size: 14px;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      color: rgba(123, 121, 232, 0.9);
      font-weight: 700;
      margin: 0 0 18px 0;
    }
    .journey-title{
      font-family: "Playfair Display", serif;
      font-weight: 500;
      letter-spacing: -0.03em;
      font-size: clamp(44px, 5.2vw, 92px);
      line-height: 0.98;
      margin: 0 0 22px 0;
      color: #ffffff;
    }
    .journey-copy{
      font-size: 18px;
      line-height: 1.9;
      color: rgba(255,255,255,0.78);
      margin: 0 0 34px 0;
      max-width: 680px;
    }
    .journey-cta{
      display: inline-flex;
      align-items: center;
      justify-content: center;
      height: 56px;
      padding: 0 34px;
      border-radius: 999px;
      background: #6b63ff;
      color: #ffffff;
      text-decoration: none;
      font-weight: 600;
      font-size: 16px;
      box-shadow: 0 10px 24px rgba(107, 99, 255, 0.22);
    }
    .journey-cta:hover{ filter: brightness(1.03); }

    @media (max-width: 1024px){
      .journey-dark{ padding: 72px 0; }
      .journey-inner{ grid-template-columns: 1fr; gap: 40px; width: min(960px, calc(100% - 48px)); }
      .journey-media{ min-height: 440px; padding: 28px; }
      .journey-title{ line-height: 1.02; }
    }

    @media (max-width: 640px){
      .journey-dark{ padding: 52px 0; }
      .journey-inner{ width: calc(100% - 32px); }
      .journey-copy{ font-size: 16px; }
      .journey-media{ min-height: 360px; padding: 20px; }
    }

    /* Why Therapie Clinic (dark 4-column strip: left text + 3 feature cards) */
    .why-therapie{
      width: 100%;
      background: #1f1f1f;
      padding: 96px 0;
    }
    .why-inner{
      width: min(1320px, calc(100% - 80px));
      margin: 0 auto;
      display: grid;
      grid-template-columns: 1.05fr 1fr 1fr 1fr;
      gap: 32px;
      align-items: start;
    }
    .why-kicker{
      font-size: 14px;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      color: rgba(123, 121, 232, 0.9);
      font-weight: 700;
      margin: 0 0 22px 0;
    }
    .why-title{
      font-family: "Playfair Display", serif;
      font-weight: 500;
      letter-spacing: -0.03em;
      font-size: clamp(40px, 4.4vw, 72px);
      line-height: 1.05;
      margin: 0;
      color: #ffffff;
      max-width: 520px;
    }

    .why-card{
      color: #ffffff;
    }
    .why-card .why-img{
      width: 100%;
      background: #2a2a2a;
      border: 2px solid rgba(255,255,255,0.14);
      overflow: hidden;
    }
    .why-card .why-img img{
      width: 100%;
      height: 380px;
      object-fit: cover;
      display: block;
    }
    .why-card h3{
      margin: 14px 0 0 0;
      font-size: 22px;
      font-weight: 600;
      color: #ffffff;
    }
    .why-card p{
      margin: 14px 0 0 0;
      font-size: 16px;
      line-height: 1.8;
      color: rgba(255,255,255,0.72);
    }

    @media (max-width: 1200px){
      .why-inner{ grid-template-columns: 1fr 1fr; gap: 28px; }
      .why-title{ max-width: none; }
      .why-card .why-img img{ height: 340px; }
    }

    @media (max-width: 640px){
      .why-therapie{ padding: 52px 0; }
      .why-inner{ width: calc(100% - 32px); grid-template-columns: 1fr; }
      .why-card .why-img img{ height: 260px; }
      .why-card h3{ font-size: 20px; }
      .why-card p{ font-size: 15px; }
    }

    /* Doctor Reviews section (4 columns) */
    .doctor-reviews{
      width: 100%;
      background: #ffffff;
      padding: 96px 0;
    }
    .doctor-inner{
      width: min(1320px, calc(100% - 80px));
      margin: 0 auto;
      position: relative;
    }
    .doctor-head{
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 24px;
      margin-bottom: 32px;
    }
    .doctor-kicker{
      font-size: 14px;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      color: #6b63ff;
      font-weight: 700;
      margin: 0 0 12px 0;
    }
    .doctor-title{
      font-family: "Playfair Display", serif;
      font-weight: 500;
      letter-spacing: -0.03em;
      font-size: clamp(44px, 5.2vw, 86px);
      line-height: 1.02;
      margin: 0;
      color: #0b0f1a;
    }

    .doctor-nav{
      display: inline-flex;
      gap: 10px;
      margin-top: 10px;
      user-select: none;
    }
    .doctor-nav button{
      width: 44px;
      height: 44px;
      border-radius: 999px;
      border: 0;
      background: rgba(11,15,26,0.06);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
    }
    .doctor-nav button:hover{ background: rgba(11,15,26,0.08); }
    .doctor-nav svg{ width: 18px; height: 18px; }

    .doctor-grid{
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 28px;
      align-items: stretch;
    }

    .doctor-card{
      background: #ffffff;
      border-radius: 16px;
      box-shadow: 0 12px 28px rgba(11, 15, 26, 0.08);
      border: 1px solid rgba(11, 15, 26, 0.06);
      overflow: hidden;
      display: flex;
      flex-direction: column;
      min-height: 560px;
    }

    .doctor-card-top{
      padding: 26px 26px 10px 26px;
      display: flex;
      gap: 14px;
      align-items: center;
    }

    .doctor-avatar{
      width: 66px;
      height: 66px;
      border-radius: 999px;
      background: radial-gradient(circle at 30% 30%, #e9ecff, #cfd6ff);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: #2a2d3a;
      font-weight: 700;
      font-size: 18px;
      letter-spacing: 0.02em;
      flex: 0 0 auto;
      border: 1px solid rgba(11,15,26,0.06);
    }

    .doctor-meta h3{
      margin: 0;
      font-size: 20px;
      line-height: 1.2;
      color: #0b0f1a;
      font-weight: 700;
    }
    .doctor-meta .doctor-clinic{
      margin-top: 4px;
      font-size: 14px;
      color: rgba(11,15,26,0.55);
    }

    .doctor-rating{
      padding: 0 26px 18px 26px;
      display: flex;
      align-items: center;
      gap: 8px;
      color: rgba(11,15,26,0.75);
      font-weight: 600;
      font-size: 15px;
    }
    .doctor-rating .star{
      width: 16px;
      height: 16px;
      display: inline-block;
    }

    .doctor-bio{
      padding: 0 26px;
      color: rgba(11,15,26,0.72);
      font-size: 15px;
      line-height: 1.85;
      margin: 0;
      flex: 1 1 auto;
    }

    .doctor-divider{
      height: 1px;
      background: rgba(11,15,26,0.10);
      margin: 18px 26px;
    }

    .doctor-quote{
      padding: 0 26px 24px 26px;
      color: rgba(11,15,26,0.68);
      font-size: 14px;
      line-height: 1.8;
      margin: 0;
    }
    .doctor-quote strong{ color: #0b0f1a; }

    .doctor-foot{
      padding: 18px 26px 22px 26px;
      margin-top: auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      color: rgba(11,15,26,0.55);
      font-size: 13px;
      border-top: 1px solid rgba(11,15,26,0.06);
      background: rgba(11,15,26,0.02);
    }
    .doctor-foot .g-badge{
      display: inline-flex;
      align-items: center;
      gap: 10px;
      font-weight: 700;
      color: rgba(11,15,26,0.75);
    }
    .doctor-foot .g-dot{
      width: 10px;
      height: 10px;
      border-radius: 999px;
      background: #6b63ff;
      box-shadow: 0 8px 18px rgba(107,99,255,0.22);
    }

    @media (max-width: 1200px){
      .doctor-grid{ grid-template-columns: repeat(2, 1fr); }
      .doctor-card{ min-height: 520px; }
    }

    @media (max-width: 640px){
      .doctor-reviews{ padding: 52px 0; }
      .doctor-inner{ width: calc(100% - 32px); }
      .doctor-head{ flex-direction: column; align-items: flex-start; }
      .doctor-grid{ grid-template-columns: 1fr; }
      .doctor-card{ min-height: auto; }
    }
    /* Join our Team section (light split with CTA) */
    .join-team{
      width: 100%;
      background: #ffffff;
      padding: 96px 0;
    }
    .join-inner{
      width: min(1320px, calc(100% - 80px));
      margin: 0 auto;
      display: grid;
      grid-template-columns: 1.05fr 0.95fr;
      gap: 80px;
      align-items: center;
    }
    .join-title{
      font-family: "Playfair Display", serif;
      font-weight: 500;
      letter-spacing: -0.03em;
      font-size: clamp(44px, 5.2vw, 92px);
      line-height: 0.98;
      margin: 0 0 22px 0;
      color: #0b0f1a;
    }
    .join-copy{
      max-width: 720px;
      font-size: 18px;
      line-height: 1.9;
      color: rgba(11,15,26,0.62);
      margin: 0 0 34px 0;
    }
    .join-cta{
      display: inline-flex;
      align-items: center;
      justify-content: center;
      height: 56px;
      padding: 0 34px;
      border-radius: 999px;
      background: #6b63ff;
      color: #ffffff;
      text-decoration: none;
      font-weight: 600;
      font-size: 16px;
      box-shadow: 0 10px 24px rgba(107, 99, 255, 0.22);
    }
    .join-cta:hover{ filter: brightness(1.03); }

    .join-media{
      width: 100%;
      background: #7b79e8;
      display: flex;
      justify-content: center;
      align-items: flex-end;
      padding: 44px;
      border-radius: 0;
      overflow: hidden;
      min-height: 560px;
    }
    .join-media img{
      width: auto;
      max-width: 100%;
      max-height: 620px;
      height: auto;
      display: block;
    }

    @media (max-width: 1024px){
      .join-team{ padding: 72px 0; }
      .join-inner{ grid-template-columns: 1fr; gap: 40px; width: min(960px, calc(100% - 48px)); }
      .join-title{ line-height: 1.02; }
      .join-media{ min-height: 440px; padding: 28px; }
    }

    @media (max-width: 640px){
      .join-team{ padding: 52px 0; }
      .join-inner{ width: calc(100% - 32px); }
      .join-copy{ font-size: 16px; }
      .join-media{ min-height: 360px; padding: 20px; }
    }
  </style>
</head>
<body>
  <div class="dsl-page">

    <!-- HEADER (fetched from /DSL/header) -->
    @include('frontend.partials.header')

    <!-- MAIN CONTENT -->
    <main>
      <!-- Stats strip section (100% width) -->
      <section class="stats-strip">
        <div class="stats-inner">
          <div class="stat">
            <h2 class="stat-num">85+</h2>
            <div class="stat-label">CLINICS GLOBALLY</div>
          </div>
          <div class="stat">
            <h2 class="stat-num">200+</h2>
            <div class="stat-label">QUALIFIED DOCTORS</div>
          </div>
          <div class="stat">
            <h2 class="stat-num">20+</h2>
            <div class="stat-label">YEARS IN BUSINESS</div>
          </div>
          <div class="stat">
            <h2 class="stat-num">10&nbsp;million+</h2>
            <div class="stat-label">TREATMENTS DELIVERED</div>
          </div>
        </div>
      </section>

      <!-- About split section (100% width) -->
      <section class="about-split">
        <div class="about-inner">
          <div class="about-left">
            <div class="about-kicker">ABOUT US</div>
            <h2 class="about-title">Helping you look<br>and feel your best<br>every day.</h2>
            <p class="about-copy">
              At DSL Clinic, we’ve been enhancing confidence and empowering lives for over 20 years.
              With more than 75 clinics across the UK, Ireland, and the USA, we’re proud to be Europe’s
              No. 1 provider of Laser Hair Removal and Aesthetic Treatments. Our mission is simple: to
              make advanced, effective treatments accessible to everyone.
            </p>
          </div>

          <div class="about-right">
            <div class="about-media">
              <img
                src="https://therapieclinic.com/_next/image?url=%2Fassets%2Faboutus%2Fabout01.webp&w=1024&q=75"
                alt="About us"
                loading="lazy"
              />
            </div>
          </div>
        </div>
      </section>

      <!-- Dark journey section (100% width) -->
      <section class="journey-dark">
        <div class="journey-inner">
          <div class="journey-media" aria-hidden="true">
            <!-- NOTE: Replace this image URL with your final asset if needed -->
            <img
              src="https://therapieclinic.com/_next/image?url=%2Fassets%2Faboutus%2Fabout01.webp&w=1024&q=75"
              alt=""
              loading="lazy"
            />
          </div>

          <div class="journey-content">
            <div class="journey-kicker">GUARANTEED BEST RESULTS</div>
            <h2 class="journey-title">Your Journey with<br>DSL Clinic</h2>
            <p class="journey-copy">
              We’re here to make aesthetics simple, approachable, and effective. From laser hair removal to advanced skin
              treatments, our team combines expertise with the latest technology to deliver outstanding results you can trust.
              At DSL Clinic, we make it easy to feel confident in your skin.
            </p>
            <a class="journey-cta" href="#">Book free consultation</a>
          </div>
        </div>
      </section>

      <!-- About split alt section (100% width) -->
      <section class="about-split alt">
        <div class="about-inner">
          <div class="about-left">
            <div class="about-kicker">A PLACE FOR EVERYONE</div>
            <h2 class="about-title">Empowered to<br>Belong</h2>
            <p class="about-copy">
              We are a people-first organisation, welcoming everyone with open arms—clients, patients, and employees alike.
              We foster a culture of belonging, where individuals feel supported, celebrated, and valued for who they are.
              Diversity is at the heart of our growing community, empowering each person to live their best life and build meaningful relationships.
            </p>
          </div>

          <div class="about-right">
            <div class="about-media">
              <img
                src="https://therapieclinic.com/_next/image?url=%2Fassets%2Faboutus%2Fabout03.webp&w=1024&q=75"
                alt="Empowered to Belong"
                loading="lazy"
              />
            </div>
          </div>
        </div>
      </section>

      <!-- Why Therapie Clinic section (100% width) -->
      <section class="why-therapie">
        <div class="why-inner">
          <div class="why-left">
            <div class="why-kicker">WHY DSL CLINIC?</div>
            <h2 class="why-title">
              With over 20<br>
              years of<br>
              offer safe,<br>
              suit your needs.
            </h2>
          </div>

          <article class="why-card">
            <div class="why-img">
              <img
                src="https://therapieclinic.com/_next/image?url=%2Fassets%2Fhome%2FLHR.webp&w=1536&q=75"
                alt="Affordable and accessible"
                loading="lazy"
              />
            </div>
            <h3>Affordable and accessible</h3>
            <p>
              High-quality treatments shouldn’t be out of reach. Our clinics are conveniently located,
              with pricing designed to fit your lifestyle.
            </p>
          </article>

          <article class="why-card">
            <div class="why-img">
              <img
                src="https://therapieclinic.com/_next/image?url=%2Fassets%2Ftreatments%2Flaser-hair-removal%2Fmen%2Fareas%2Fupper-body.webp&w=1536&q=75"
                alt="Leading technology"
                loading="lazy"
              />
            </div>
            <h3>Leading technology</h3>
            <p>
              We use the safest, most advanced technology to deliver exceptional results for all skin
              tones and types.
            </p>
          </article>

          <article class="why-card">
            <div class="why-img">
              <img
                src="https://therapieclinic.com/_next/image?url=%2Fassets%2Fhome%2FBODY.webp&w=1536&q=75"
                alt="Expert care"
                loading="lazy"
              />
            </div>
            <h3>Expert care</h3>
            <p>
              Our highly-trained therapists and medical professionals are here to guide you every step
              of the way, offering personalised care with a smile.
            </p>
          </article>
        </div>
      </section>

      <!-- Doctor Reviews section (100% width) -->
      <section class="doctor-reviews">
        <div class="doctor-inner">
          <div class="doctor-head">
            <div>
              <div class="doctor-kicker">YOU MAKE US LOOK GOOD</div>
              <h2 class="doctor-title">Doctor Reviews</h2>
            </div>

            <!-- Static nav buttons (visual only) -->
            <div class="doctor-nav" aria-hidden="true">
              <button type="button" title="Previous">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M15 6l-6 6 6 6" stroke="rgba(11,15,26,0.65)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </button>
              <button type="button" title="Next">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M9 6l6 6-6 6" stroke="rgba(11,15,26,0.65)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </button>
            </div>
          </div>

          <div class="doctor-grid">
            <!-- Card 1 -->
            <article class="doctor-card">
              <div class="doctor-card-top">
                <div class="doctor-avatar" aria-hidden="true">NP</div>
                <div class="doctor-meta">
                  <h3>Dr. Nutchannun Poolworalru</h3>
                  <div class="doctor-clinic">DSL Clinic Brent Cross</div>
                </div>
              </div>
              <div class="doctor-rating">
                <span class="star" aria-hidden="true">
                  <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill="#d4a93a" d="M12 17.3l-6.18 3.73 1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.63 7.19.61-5.46 4.76 1.64 7.03z"/></svg>
                </span>
                4.9 average rating
              </div>
              <p class="doctor-bio">
                Aesthetic medicine has been my passion since medical school, combining medical expertise with artistic skill to enhance appearances and boost confidence.
                Working at DSL Clinic allows me to positively impact self‑esteem while using innovative technologies.
              </p>
              <div class="doctor-divider"></div>
              <p class="doctor-quote">
                “I have had anti‑wrinkle injections twice now. Both times I have felt very at ease, well looked after and received honest advice. Highly recommend.”
                <br><strong>— Joanna Karveli</strong>
              </p>
              <div class="doctor-foot">
                <span class="g-badge"><span class="g-dot"></span>Google</span>
                <span>Official Review</span>
              </div>
            </article>

            <!-- Card 2 -->
            <article class="doctor-card">
              <div class="doctor-card-top">
                <div class="doctor-avatar" aria-hidden="true">YN</div>
                <div class="doctor-meta">
                  <h3>Dr. Yvonne Ndefo</h3>
                  <div class="doctor-clinic">DSL Clinic Galway</div>
                </div>
              </div>
              <div class="doctor-rating">
                <span class="star" aria-hidden="true">
                  <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill="#d4a93a" d="M12 17.3l-6.18 3.73 1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.63 7.19.61-5.46 4.76 1.64 7.03z"/></svg>
                </span>
                4.8 average rating
              </div>
              <p class="doctor-bio">
                I am driven by a passion for aesthetic medicine. I’m dedicated to helping patients achieve their desired look with natural results tailored to their unique needs.
                My focus is confidence, comfort, and overall wellbeing.
              </p>
              <div class="doctor-divider"></div>
              <p class="doctor-quote">
                “Yvonne was an absolute dote—very honest, very helpful and informative. Really lovely to talk to.”
                <br><strong>— Sharon Reynolds</strong>
              </p>
              <div class="doctor-foot">
                <span class="g-badge"><span class="g-dot"></span>Google</span>
                <span>Official Review</span>
              </div>
            </article>

            <!-- Card 3 -->
            <article class="doctor-card">
              <div class="doctor-card-top">
                <div class="doctor-avatar" aria-hidden="true">ZK</div>
                <div class="doctor-meta">
                  <h3>Dr. Zara Katchi</h3>
                  <div class="doctor-clinic">DSL Clinic Epsom</div>
                </div>
              </div>
              <div class="doctor-rating">
                <span class="star" aria-hidden="true">
                  <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill="#d4a93a" d="M12 17.3l-6.18 3.73 1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.63 7.19.61-5.46 4.76 1.64 7.03z"/></svg>
                </span>
                4.7 average rating
              </div>
              <p class="doctor-bio">
                DSL Clinic is known for outstanding patient care and a strong community presence. I love creating subtle enhancements that keep results balanced and natural.
                Every treatment is planned with safety, comfort, and your goals in mind.
              </p>
              <div class="doctor-divider"></div>
              <p class="doctor-quote">
                “Always a great experience coming here! Dr Zara is wonderful and always makes me feel comfortable. Highly recommend.”
                <br><strong>— Tam P</strong>
              </p>
              <div class="doctor-foot">
                <span class="g-badge"><span class="g-dot"></span>Google</span>
                <span>Official Review</span>
              </div>
            </article>

            <!-- Card 4 (new) -->
            <article class="doctor-card">
              <div class="doctor-card-top">
                <div class="doctor-avatar" aria-hidden="true">EM</div>
                <div class="doctor-meta">
                  <h3>Dr. Emma M</h3>
                  <div class="doctor-clinic">DSL Clinic Newry</div>
                </div>
              </div>
              <div class="doctor-rating">
                <span class="star" aria-hidden="true">
                  <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill="#d4a93a" d="M12 17.3l-6.18 3.73 1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.63 7.19.61-5.46 4.76 1.64 7.03z"/></svg>
                </span>
                4.8 average rating
              </div>
              <p class="doctor-bio">
                I specialise in patient‑first aesthetics—clear consultation, honest recommendations, and results that feel like you.
                My aim is to keep treatments comfortable, predictable, and beautifully natural.
              </p>
              <div class="doctor-divider"></div>
              <p class="doctor-quote">
                “I had lip filler done and WOW — the most natural result I’ve ever had. Listened to exactly what I wanted and explained everything clearly.”
                <br><strong>— Orla M</strong>
              </p>
              <div class="doctor-foot">
                <span class="g-badge"><span class="g-dot"></span>Google</span>
                <span>Official Review</span>
              </div>
            </article>
          </div>
        </div>
      </section>

      <!-- Join our Team section (100% width) -->
      <section class="join-team">
        <div class="join-inner">
          <div class="join-left">
            <h2 class="join-title">Join our Team at<br>DSL Clinic</h2>
            <p class="join-copy">
              We want everyone to do their best work at DSL Clinic. If you’re passionate about aesthetics and eager to contribute to a dynamic team, you’ll find more than just a job with us.
              We offer a vibrant culture that values innovation, collaboration, and personal growth. Here, you’ll find incredible growth opportunities, competitive rewards and a supportive, fun work environment.
            </p>
            <a class="join-cta" href="#">View Open Positions</a>
          </div>

          <div class="join-right">
            <div class="join-media">
              <img
                src="https://therapieclinic.com/_next/image?url=%2Fassets%2Faboutus%2Fabout06.webp&w=1024&q=75"
                alt="Join our team"
                loading="lazy"
              />
            </div>
          </div>
        </div>
      </section>
    </main>

    <!-- FOOTER (fetched from /DSL/footer) -->
    @include('frontend.partials.footer')

  </div>
</body>
</html>