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
  /* --- Scope all styles to this page only --- */
  .blog-strip, .blog-strip * { box-sizing: border-box; }

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

  /* Section Layout */
  .blog-strip {
    width: 100%;
    padding: 100px 0 140px;
    background: var(--bg);
  }
  .blog-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 24px;
  }

  /* Header */
  .blog-head {
    text-align: center;
    margin-bottom: 64px;
  }
  .blog-head h2 {
    font-family: 'Canela', serif;
    font-size: clamp(36px, 5vw, 64px);
    color: var(--purple);
    margin: 0 0 16px;
    line-height: 1.1;
  }
  .blog-head p {
    font-size: 18px;
    color: var(--muted);
    max-width: 600px;
    margin: 0 auto;
  }

  /* Grid Layout */
  .blog-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
    gap: 32px;
  }

  /* Card Layout */
  .blog-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 24px;
    overflow: hidden;
    backdrop-filter: blur(16px);
    display: flex;
    flex-direction: column;
    height: 100%;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 8px 32px rgba(0,0,0,0.2);
  }
  .blog-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow);
  }

  /* Card Image */
  .blog-media {
    position: relative;
    width: 100%;
    aspect-ratio: 16 / 10;
    overflow: hidden;
    border-bottom: 1px solid var(--border);
  }
  .blog-media img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
  }
  .blog-card:hover .blog-media img {
    transform: scale(1.05);
  }

  /* Badges */
  .blog-pills {
    position: absolute;
    top: 16px;
    left: 16px;
    display: flex;
    gap: 8px;
    z-index: 2;
  }
  .pill {
    background: rgba(0, 0, 0, 0.6);
    color: #fff;
    padding: 6px 14px;
    border-radius: 99px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border: 1px solid rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(4px);
  }

  /* Card Content */
  .blog-body {
    padding: 32px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
  }
  .blog-date {
    font-size: 14px;
    color: var(--purple);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    margin-bottom: 16px;
  }
  .blog-title {
    font-family: 'Canela', serif;
    font-size: 26px;
    color: #fff;
    margin: 0 0 16px;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
  .blog-excerpt {
    font-size: 16px;
    color: var(--muted);
    line-height: 1.6;
    margin: 0 0 32px;
    flex-grow: 1;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
  .blog-link {
    display: inline-flex;
    align-items: center;
    color: var(--purple);
    text-decoration: none;
    font-weight: 600;
    font-size: 16px;
    transition: opacity 0.2s ease;
    margin-top: auto;
  }
  .blog-link:hover {
    opacity: 0.8;
  }

  /* Responsive Adjustments */
  @media (max-width: 768px) {
    .blog-grid {
      grid-template-columns: 1fr;
    }
    .blog-media {
      aspect-ratio: 4 / 3;
    }
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
