

<?php
// DSL - Refer a Friend page
// Includes shared header/footer from these endpoints:
// https://mobileemilocker.com/DSL/header
// https://mobileemilocker.com/DSL/footer

function dsl_fetch_partial(string $url): string {
    // Prefer cURL (more reliable on shared hosting)
    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CONNECTTIMEOUT => 8,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_USERAGENT => 'DSL-Web/1.0',
        ]);
        $html = (string)curl_exec($ch);
        curl_close($ch);
        if ($html !== '') return $html;
    }

    // Fallback to file_get_contents
    $ctx = stream_context_create([
        'http' => [
            'method'  => 'GET',
            'timeout' => 15,
            'header'  => "User-Agent: DSL-Web/1.0\r\n",
        ],
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
        ],
    ]);

    $html = @file_get_contents($url, false, $ctx);
    return $html !== false ? $html : '';
}

$header_html = dsl_fetch_partial('https://mobileemilocker.com/DSL/header');
$footer_html = dsl_fetch_partial('https://mobileemilocker.com/DSL/footer');
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Refer a friend</title>

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

  .dsl-raf-wrap {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 60px 24px 100px;
    display: flex;
    justify-content: center;
  }

  .dsl-raf-card {
    background: rgba(11, 27, 42, .45);
    border: 1px solid rgba(212, 175, 55, 0.15);
    border-radius: 24px;
    backdrop-filter: blur(16px);
    box-shadow: 0 24px 50px rgba(212, 175, 55, 0.1);
    overflow: hidden;
    width: 100%;
  }

  .dsl-raf-inner {
    display: flex;
    flex-direction: row;
    align-items: center;
  }

  .dsl-raf-left {
    flex: 1;
    width: 50%;
  }

  .dsl-raf-image {
    width: 100%;
    height: 100%;
    min-height: 500px;
    position: relative;
  }

  .dsl-raf-image img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .dsl-raf-right {
    flex: 1;
    width: 50%;
    padding: 60px 80px;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .dsl-kicker {
    font-size: 14px;
    font-weight: 600;
    letter-spacing: 0.1em;
    color: #D4AF37;
    margin: 0 0 16px;
    text-transform: uppercase;
  }

  .dsl-title {
    font-family: 'Canela', serif;
    font-size: clamp(36px, 4vw, 54px);
    font-weight: 500;
    color: #fff;
    line-height: 1.1;
    margin: 0 0 24px;
  }

  .dsl-body {
    font-size: 18px;
    color: #a0aab2;
    line-height: 1.6;
    margin: 0 0 40px;
  }

  .dsl-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    background: #D4AF37;
    color: #000;
    font-weight: 600;
    font-size: 16px;
    padding: 16px 32px;
    border-radius: 999px;
    text-decoration: none;
    width: fit-content;
    transition: all 0.2s ease;
  }
  
  .dsl-btn svg path {
    stroke: #000;
  }

  .dsl-btn:hover {
    background: #ebd071;
    transform: translateY(-2px);
  }

  @media (max-width: 900px) {
    .dsl-raf-inner {
      flex-direction: column;
    }
    .dsl-raf-left, .dsl-raf-right {
      width: 100%;
    }
    .dsl-raf-image {
      min-height: 300px;
    }
    .dsl-raf-right {
      padding: 40px 24px;
      text-align: center;
      align-items: center;
    }
  }
</style>
</head>
<body>

  <!-- HEADER (loaded from /DSL/header) -->
  @include('frontend.partials.header')

  <main class="dsl-page">
    <section class="dsl-raf-wrap">
      <div class="dsl-raf-card">
        <div class="dsl-raf-inner">

          <div class="dsl-raf-left">
            <div class="dsl-raf-image">
              <img
                src="https://therapieclinic.com/_next/image?url=%2Fassets%2Floyalty%2Ftherapie-loyalty.webp&w=1024&q=75"
                alt="Refer a friend"
                loading="lazy"
              />
            </div>
          </div>

          <div class="dsl-raf-right">
            <p class="dsl-kicker">LOYALTY AT DSL CLINIC</p>
            <h1 class="dsl-title">Refer a friend, you<br/>both get £50 off</h1>
            <p class="dsl-body">
              When your friend schedules a consultation and spends £225 or more on their first treatment,
              you and your friend both earn a £50 credit. It's that simple! Spread the word — get a £50
              credit for every friend you refer.
            </p>

            <a class="dsl-btn" href="#" onclick="return false;" aria-label="Invite friends">
              <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M3.6 10.2l16.2-6.8c.7-.3 1.4.4 1.1 1.1l-6.8 16.2c-.3.8-1.5.8-1.8 0l-2.3-6.1-6.1-2.3c-.8-.3-.8-1.5 0-1.8z" stroke="white" stroke-width="1.8" stroke-linejoin="round"/>
                <path d="M9.6 14.4l4.8-4.8" stroke="white" stroke-width="1.8" stroke-linecap="round"/>
              </svg>
              Invite friends
            </a>
          </div>

        </div>
      </div>
    </section>
  </main>

  <!-- FOOTER (loaded from /DSL/footer) -->
  @include('frontend.partials.footer')

</body>
</html>