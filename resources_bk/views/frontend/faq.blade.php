

<?php

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>FAQs</title>

  <style>
    /* Page: 100% width + responsive */
    :root{
      --bg: #ffffff;
      --muted-bg: #f3f4f7;
      --card-bg: #ffffff;
      --text: #0f172a;
      --muted: #475569;
      --border: #e5e7eb;
      --shadow: 0 6px 22px rgba(15, 23, 42, 0.06);
      --radius: 16px;
    }

    html, body { height: 100%; }
    body{
      margin: 0;
      padding: 0;
      width: 100%;
      background: var(--bg);
      color: var(--text);
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Inter, Helvetica, Arial, sans-serif;
      line-height: 1.4;
    }

    /* Ensure header/footer don’t overlap content */
    .dsl-page{
      width: 100%;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .dsl-main{
      width: 100%;
      flex: 1 0 auto;
    }

    /* Hero */
    .faq-hero{
      width: 100%;
      padding: 64px 20px 44px;
      text-align: center;
      background: #fff;
    }

    .faq-hero h1{
      margin: 0;
      font-family: Georgia, "Times New Roman", Times, serif;
      font-weight: 500;
      letter-spacing: -0.02em;
      font-size: clamp(34px, 4.6vw, 78px);
      line-height: 1.05;
    }

    .faq-hero p{
      margin: 18px 0 0;
      color: var(--muted);
      font-size: 16px;
    }

    /* Section background like screenshot */
    .faq-section{
      width: 100%;
      background: var(--muted-bg);
      padding: 54px 20px 70px;
    }

    /* Keep content centered while page stays 100% wide */
    .faq-container{
      width: 100%;
      max-width: 1220px;
      margin: 0 auto;
    }

    .faq-grid{
      display: grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: 26px;
    }

    @media (max-width: 1100px){
      .faq-grid{ grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media (max-width: 640px){
      .faq-hero{ padding: 48px 16px 34px; }
      .faq-section{ padding: 40px 16px 56px; }
      .faq-grid{ grid-template-columns: 1fr; gap: 18px; }
    }

    .faq-card{
      background: var(--card-bg);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      padding: 24px 24px 20px;
      min-height: 270px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .faq-card h3{
      margin: 0 0 12px;
      font-size: 22px;
      font-weight: 700;
    }

    .faq-links{
      margin: 0;
      padding: 0;
      list-style: none;
    }

    .faq-links li{ margin: 0 0 10px; }

    .faq-links a{
      color: var(--muted);
      text-decoration: none;
      font-size: 15px;
    }

    .faq-links a:hover{ text-decoration: underline; }

    .faq-card .card-footer{
      margin-top: 18px;
    }

    .btn-viewall{
      display: inline-flex;
      align-items: center;
      gap: 10px;
      padding: 12px 18px;
      border-radius: 999px;
      border: 1px solid #94a3b8;
      background: #fff;
      color: #0f172a;
      font-weight: 500;
      text-decoration: none;
      width: fit-content;
      transition: transform 120ms ease, box-shadow 120ms ease;
    }

    .btn-viewall:hover{
      transform: translateY(-1px);
      box-shadow: 0 10px 26px rgba(15, 23, 42, 0.08);
    }

    .btn-viewall .arrow{
      font-size: 18px;
      line-height: 1;
    }

    /* Small helper if header/footer CSS conflicts */
    .dsl-reset *{ box-sizing: border-box; }
  </style>
</head>
<body>
  <div class="dsl-page dsl-reset">

    <!-- Header include -->
    @include('frontend.partials.header')

    <main class="dsl-main">
      <section class="faq-hero">
        <h1>How can we help you?</h1>
        <p>Browse our frequently asked questions below for help.</p>
      </section>

      <section class="faq-section">
        <div class="faq-container">
            <div class="faq-grid">

            @foreach($categories as $category)
            
              <article class="faq-card">
                
                <div>
                  <!-- Parent Category -->
                  <h3>{{ $category->category_name }}</h3>
            
                  <ul class="faq-links">
            
                    @foreach($category->subcategories as $sub)
                      <li>
                        <a href="#">
                          {{ $sub->category_name }}
                        </a>
                      </li>
                    @endforeach
            
                  </ul>
                </div>
            
                <div class="card-footer">
                  <a class="btn-viewall" href="#">
                    <span>View all</span> <span class="arrow">→</span>
                  </a>
                </div>
            
              </article>
            
            @endforeach
            
            </div>
        </div>
      </section>
    </main>

    <!-- Footer include -->
    @include('frontend.partials.footer')

  </div>
</body>
</html>