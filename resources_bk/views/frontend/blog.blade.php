<?php
// blog.php
// Uses shared header/footer endpoints:
// https://mobileemilocker.com/DSL/header
// https://mobileemilocker.com/DSL/footer

function dsl_fetch_partial(string $url): string {
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

$dsl_header = dsl_fetch_partial('https://mobileemilocker.com/DSL/header');
if ($dsl_header === '' && file_exists(__DIR__ . '/header.php')) {
    ob_start();
    include __DIR__ . '/header.php';
    $dsl_header = ob_get_clean();
}

//echo $dsl_header;
?>

@include('frontend.partials.header')

  <style>
    :root{
      --bg: #f4f4f6;
      --card: #ffffff;
      --text: #111827;
      --muted: #6b7280;
      --pill-bg: #6f63d9; /* therapie-like purple */
      --pill-bg-2: #7a6ee3;
      --radius: 18px;
      --shadow: 0 10px 30px rgba(16,24,40,.10);
      --border: rgba(17,24,39,.08);
    }

    *{box-sizing:border-box;}
    body{
      margin:0;
      font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji","Segoe UI Emoji";
      color:var(--text);
      background:var(--bg);
    }

    /* FULL-WIDTH SECTION */
    .blog-strip{
      width:100%;
      padding:48px 0;
    }

    .blog-container{
      width:100%;
      max-width: 1400px;
      margin:0 auto;
      padding:0 28px;
    }

    .blog-grid{
      display:grid;
      grid-template-columns: repeat(4, minmax(0, 1fr));
      gap:24px;
      align-items:stretch;
    }

    @media (max-width: 1200px){
      .blog-grid{ grid-template-columns: repeat(3, minmax(0, 1fr)); }
    }
    @media (max-width: 900px){
      .blog-grid{ grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (max-width: 560px){
      .blog-container{ padding:0 16px; }
      .blog-grid{ grid-template-columns: 1fr; }
    }

    .blog-card{
      background:var(--card);
      border-radius: var(--radius);
      overflow:hidden;
      box-shadow: var(--shadow);
      border: 1px solid var(--border);
      display:flex;
      flex-direction:column;
      min-height: 520px;
    }

    .blog-media{
      position:relative;
      height: 220px;
      background:#e5e7eb;
    }

    .blog-media img{
      width:100%;
      height:100%;
      object-fit:cover;
      display:block;
    }

    .blog-pills{
      position:absolute;
      top:16px;
      left:16px;
      display:flex;
      gap:10px;
      flex-wrap:wrap;
      z-index:2;
    }

    .pill{
      font-size: 13px;
      line-height: 1;
      padding:10px 14px;
      border-radius: 999px;
      color:#fff;
      background: var(--pill-bg);
      box-shadow: 0 6px 16px rgba(111,99,217,.20);
      white-space:nowrap;
    }
    .pill.alt{ background: var(--pill-bg-2); }

    .blog-body{
      padding:22px 22px 20px;
      display:flex;
      flex-direction:column;
      gap:14px;
      flex:1;
      background:#fff;
    }

    .blog-date{
      color: var(--muted);
      font-size: 15px;
    }

    .blog-title{
      font-weight: 800;
      font-size: 24px;
      line-height: 1.15;
      margin:0;
      color:#0f172a;
      letter-spacing: -0.2px;
    }

    .blog-excerpt{
      margin:0;
      color:#111827;
      font-size: 15.5px;
      line-height: 1.75;
      opacity:.95;
    }

    .blog-link{
      margin-top:auto;
      display:inline-flex;
      align-items:center;
      gap:10px;
      text-decoration:none;
      color:#4338ca;
      font-weight:700;
      font-size:15px;
    }

    .blog-link:hover{ text-decoration:underline; }

    /* Optional section heading (can remove if you don't want) */
    .blog-head{
      display:flex;
      justify-content:space-between;
      align-items:flex-end;
      gap:16px;
      margin-bottom:18px;
    }

    .blog-head h2{
      margin:0;
      font-size: 40px;
      letter-spacing:-.5px;
      line-height:1.05;
      color:#0b1220;
    }

    .blog-head p{
      margin:0;
      color:var(--muted);
      max-width: 700px;
      line-height:1.6;
    }

    @media (max-width: 900px){
      .blog-head{ flex-direction:column; align-items:flex-start; }
      .blog-head h2{ font-size: 34px; }
    }
  </style>

  <!-- BLOG SECTION (100% width) -->
  <section class="blog-strip">
    <div class="blog-container">

      <div class="blog-head">
        <div>
          <h2>Latest from our blog</h2>
          <p>Doctor-led, safe, effective. Explore guides, FAQs, and results stories.</p>
        </div>
      </div>

      <div class="blog-grid">

        @foreach ($blogs as $item)
        
            @php
                if(session('app_locale')=='cn'){
                    $profile11 = !empty($item->profile_cn) ? $item->profile_cn : $item->profile;
                    $profile_alt11 = $item->profile_cn_alt;
                    $title11 = $item->title_cn;
                    $description11 = $item->description_cn;
                }
                elseif(session('app_locale')=='ar'){
                    $profile11 = !empty($item->profile_ar) ? $item->profile_ar : $item->profile;
                    $profile_alt11 = $item->profile_ar_alt;
                    $title11 = $item->title_ar;
                    $description11 = $item->description_ar;
                }
                else{
                    $profile11 = $item->profile;
                    $profile_alt11 = $item->profile_alt;
                    $title11 = $item->title;
                    $description11 = $item->description;
                }
            @endphp
        
            <article class="blog-card">
                
                <div class="blog-media">
                    <div class="blog-pills">
                        <span class="pill">Blog</span>
                        <!--<span class="pill alt">Latest</span>-->
                    </div>
        
                    <img 
                        src="{{ !empty($profile11) ? asset('uploads/blog/' . $profile11) : asset('uploads/userimage/no-blog.jpg') }}" 
                        alt="{{ $profile_alt11 }}"
                        loading="lazy"
                    />
                </div>
        
                <div class="blog-body">
                    <div class="blog-date">
                        {{ \Carbon\Carbon::parse($item->blog_date)->format('F d, Y') }}
                    </div>
        
                    <h3 class="blog-title">
                        {{ $title11 }}
                    </h3>
        
                    <p class="blog-excerpt">
                        {{ \Illuminate\Support\Str::limit(strip_tags($description11), 110) }}
                    </p>
        
                    <a class="blog-link" href="{{ url('/' . $item->blog_slug ) }}">
                        Read more →
                    </a>
                </div>
        
            </article>
        
        @endforeach
        
        </div>

    </div>
  </section>

@include('frontend.partials.footer')
