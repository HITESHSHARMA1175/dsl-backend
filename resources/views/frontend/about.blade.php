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
  /* --- Scope all styles to this page only --- */
  .dsl-page, .dsl-page * { box-sizing: border-box; }

  :root{
      --bg:#05070a;
      --text:#ffffff;
      --muted:#a0aab2;
      --border:rgba(212, 175, 55, 0.15);
      --card:rgba(11, 27, 42, .45);
      --purple:#D4AF37;
      --pill:rgba(255, 255, 255, 0.1);
      --shadow:0 24px 50px rgba(212, 175, 55, 0.1);
      --radius:16px;
  }

  body {
    background: #05070a !important;
    font-family: 'Outfit', sans-serif !important;
    color: #fff !important;
    margin: 0 !important;
  }

  /* Typography */
  h2, h3, .about-title, .journey-title, .why-title, .doctor-title {
    font-family: 'Canela', serif;
    color: #fff;
    margin-top: 0;
  }
  
  .about-kicker, .journey-kicker, .why-kicker, .doctor-kicker {
    font-size: 14px;
    font-weight: 600;
    letter-spacing: 0.1em;
    color: #D4AF37;
    margin-bottom: 16px;
    text-transform: uppercase;
  }

  p, .about-copy, .journey-copy, .doctor-bio, .doctor-quote {
    font-size: 18px;
    color: #a0aab2;
    line-height: 1.6;
  }

  /* Images */
  img {
    max-width: 100%;
    height: auto;
    border-radius: 16px;
  }

  /* Buttons */
  .journey-cta {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #D4AF37;
    color: #000;
    font-weight: 600;
    font-size: 16px;
    padding: 16px 32px;
    border-radius: 999px;
    text-decoration: none;
    transition: all 0.2s ease;
    margin-top: 24px;
  }
  .journey-cta:hover {
    background: #ebd071;
    transform: translateY(-2px);
  }

  /* Stats Strip */
  .stats-strip {
    width: 100%;
    background: var(--card);
    backdrop-filter: blur(16px);
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
    padding: 60px 24px;
    margin-bottom: 100px;
  }
  .stats-inner {
    max-width: 1400px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 40px;
  }
  .stat {
    text-align: center;
    flex: 1;
    min-width: 200px;
  }
  .stat-num {
    font-size: clamp(32px, 5vw, 54px);
    color: var(--purple);
    margin-bottom: 8px;
    line-height: 1;
  }
  .stat-label {
    font-size: 14px;
    font-weight: 600;
    letter-spacing: 0.1em;
    color: var(--muted);
  }

  /* About Split */
  .about-split {
    width: 100%;
    margin-bottom: 120px;
  }
  .about-inner, .journey-inner {
    max-width: 1400px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    gap: 80px;
    padding: 0 24px;
  }
  .about-split.alt .about-inner {
    flex-direction: row-reverse;
  }
  .about-left, .about-right, .journey-media, .journey-content {
    flex: 1;
  }
  .about-title {
    font-size: clamp(36px, 5vw, 64px);
    line-height: 1.1;
    margin-bottom: 32px;
  }
  .about-media img, .journey-media img {
    width: 100%;
    object-fit: cover;
    box-shadow: var(--shadow);
  }

  /* Journey Section */
  .journey-dark {
    width: 100%;
    padding: 80px 0;
    margin-bottom: 120px;
    background: rgba(11, 27, 42, 0.3);
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
  }
  .journey-title {
    font-size: clamp(36px, 4vw, 54px);
    line-height: 1.1;
    margin-bottom: 24px;
  }

  /* Why DSL */
  .why-therapie {
    width: 100%;
    margin-bottom: 120px;
  }
  .why-inner {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 24px;
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr;
    gap: 32px;
  }
  .why-left {
    display: flex;
    flex-direction: column;
    justify-content: center;
  }
  .why-title {
    font-size: 32px;
    line-height: 1.2;
  }
  .why-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 24px;
    padding: 32px;
    backdrop-filter: blur(16px);
    transition: transform 0.3s ease;
  }
  .why-card:hover {
    transform: translateY(-8px);
  }
  .why-img {
    margin-bottom: 24px;
  }
  .why-img img {
    border-radius: 12px;
  }
  .why-card h3 {
    font-size: 24px;
    margin-bottom: 16px;
    color: var(--purple);
  }
  .why-card p {
    font-size: 16px;
    margin: 0;
  }

  /* Doctor Reviews */
  .doctor-reviews {
    width: 100%;
    margin-bottom: 120px;
  }
  .doctor-inner {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 24px;
  }
  .doctor-head {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 48px;
  }
  .doctor-title {
    font-size: clamp(36px, 4vw, 54px);
    margin: 0;
  }
  .doctor-nav {
    display: flex;
    gap: 16px;
  }
  .doctor-nav button {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: var(--card);
    border: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
  }
  .doctor-nav button:hover {
    background: var(--purple);
  }
  .doctor-nav button svg path {
    stroke: #fff;
  }
  .doctor-grid {
    display: grid;
    align-items: stretch;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 32px;
  }
  .doctor-card {
    height: 100%;
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 24px;
    padding: 32px;
    backdrop-filter: blur(16px);
    display: flex;
    flex-direction: column;
  }
  .doctor-card-top {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 24px;
  }
  .doctor-avatar {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: var(--purple);
    color: #000;
    font-weight: 700;
    font-size: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .doctor-meta h3 {
    margin: 0 0 4px;
    font-size: 20px;
  }
  .doctor-clinic {
    font-size: 14px;
    color: var(--muted);
  }
  .doctor-rating {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 24px;
  }
  .doctor-rating .star {
    display: flex;
  }
  .doctor-rating .star svg {
    width: 20px;
    height: 20px;
  }
  .doctor-divider {
    height: 1px;
    background: var(--border);
    margin: 24px 0;
  }
  .doctor-quote {
    font-style: italic;
    flex-grow: 1;
  }
  .doctor-quote strong {
    color: #fff;
    font-style: normal;
  }
  .doctor-foot {
    margin-top: 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 14px;
    color: var(--muted);
  }
  .g-badge {
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .g-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #4285F4;
  }

  /* Responsive Design */
  @media (max-width: 1024px) {
    .why-inner {
      grid-template-columns: 1fr 1fr;
    }
    .why-left {
      grid-column: span 2;
      text-align: center;
      margin-bottom: 32px;
    }
  }

  @media (max-width: 768px) {
    .about-inner, .journey-inner {
      flex-direction: column;
      gap: 40px;
      text-align: center;
    }
    .about-split.alt .about-inner {
      flex-direction: column;
    }
    .stats-inner {
      gap: 24px;
    }
    .stat {
      min-width: 40%;
    }
    .why-inner {
      grid-template-columns: 1fr;
    }
    .why-left {
      grid-column: span 1;
    }
  }

  /* Join Team Section */
  .join-team {
    width: 100%;
    margin-bottom: 120px;
  }
  .join-inner {
    max-width: 1400px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    gap: 80px;
    padding: 0 24px;
  }
  .join-left, .join-right {
    flex: 1;
  }
  .join-title {
    font-size: clamp(36px, 4vw, 54px);
    line-height: 1.1;
    margin-bottom: 24px;
    font-family: 'Canela', serif;
    color: #fff;
  }
  .join-copy {
    font-size: 18px;
    color: #a0aab2;
    line-height: 1.6;
    margin-bottom: 32px;
  }
  .join-media img {
    width: 100%;
    object-fit: cover;
    box-shadow: var(--shadow);
    border-radius: 24px;
  }
  .join-cta {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #D4AF37;
    color: #000;
    font-weight: 600;
    font-size: 16px;
    padding: 16px 32px;
    border-radius: 999px;
    text-decoration: none;
    transition: all 0.2s ease;
  }
  .join-cta:hover {
    background: #ebd071;
    transform: translateY(-2px);
  }

  /* Responsive Fix for Join */
  @media (max-width: 768px) {
    .join-inner {
      flex-direction: column;
      text-align: center;
      gap: 40px;
    }
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