

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
    :root{
      --dsl-bg:#111214;
      --dsl-bg2:#1a1b1f;
      --dsl-purple:#6d63d6;
      --dsl-purple-2:#7b72ea;
      --dsl-text:#ffffff;
      --dsl-muted:rgba(255,255,255,.78);
      --dsl-card-radius:22px;
      --dsl-max:1240px;
    }

    /* Ensure page is full width */
    html,body{height:100%;}
    body{margin:0; width:100%; background:#fff;}

    /* Prevent duplicate spacing from injected header/footer wrappers */
    .dsl-page{width:100%;}

    /* Main hero section */
    .dsl-raf-wrap{
      width:100%;
      background: radial-gradient(1200px 600px at 10% 10%, rgba(255,255,255,.06), transparent 60%),
                  radial-gradient(900px 500px at 90% 20%, rgba(109,99,214,.18), transparent 55%),
                  linear-gradient(180deg, var(--dsl-bg) 0%, var(--dsl-bg2) 100%);
      padding: 54px 24px;
      box-sizing:border-box;
    }

    .dsl-raf-card{
      width:min(var(--dsl-max), calc(100% - 0px));
      margin:0 auto;
      border-radius: var(--dsl-card-radius);
      background: transparent;
      box-shadow: 0 18px 60px rgba(0,0,0,.35);
      overflow:hidden;
    }

    .dsl-raf-inner{
      display:grid;
      grid-template-columns: 1.02fr 0.98fr;
      gap: 0;
      align-items:stretch;
      background: transparent;
      border-radius: var(--dsl-card-radius);
    }

    .dsl-raf-left{
      padding: 34px;
      box-sizing:border-box;
      display:flex;
      align-items:center;
      justify-content:center;
      background: rgba(255,255,255,.02);
    }

    .dsl-raf-image{
      width:100%;
      max-width: 560px;
      aspect-ratio: 1 / 1;
      border-radius: 8px;
      background: #f3f3f3;
      overflow:hidden;
      display:flex;
      align-items:center;
      justify-content:center;
    }

    .dsl-raf-image img{
      width:100%;
      height:100%;
      object-fit: cover;
      display:block;
    }

    .dsl-raf-right{
      padding: 54px 54px 54px 34px;
      box-sizing:border-box;
      color: var(--dsl-text);
      display:flex;
      flex-direction:column;
      justify-content:center;
    }

    .dsl-kicker{
      font: 600 14px/1.2 system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif;
      letter-spacing: .18em;
      text-transform: uppercase;
      color: rgba(123,114,234,.9);
      margin:0 0 14px 0;
    }

    .dsl-title{
      margin:0 0 18px 0;
      font-family: ui-serif, Georgia, "Times New Roman", Times, serif;
      font-weight: 500;
      letter-spacing: -0.02em;
      font-size: clamp(42px, 5.2vw, 78px);
      line-height: 0.98;
      color: #fff;
    }

    .dsl-body{
      margin:0 0 30px 0;
      max-width: 520px;
      font: 400 18px/1.85 system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif;
      color: var(--dsl-muted);
    }

    .dsl-btn{
      display:inline-flex;
      align-items:center;
      gap:10px;
      padding: 14px 22px;
      border-radius: 999px;
      background: var(--dsl-purple);
      color:#fff;
      text-decoration:none;
      font: 600 16px/1 system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif;
      width: fit-content;
      box-shadow: 0 14px 30px rgba(109,99,214,.35);
      transition: transform .15s ease, background .15s ease;
    }
    .dsl-btn:hover{ transform: translateY(-1px); background: var(--dsl-purple-2); }

    .dsl-btn svg{ width:18px; height:18px; display:block; }

    /* Responsive */
    @media (max-width: 980px){
      .dsl-raf-inner{ grid-template-columns: 1fr; }
      .dsl-raf-right{ padding: 34px; }
      .dsl-raf-left{ padding: 24px; }
      .dsl-body{ max-width: 100%; }
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