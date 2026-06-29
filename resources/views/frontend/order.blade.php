

@include('frontend.partials.header')

<style>
  :root{
    --order-history-bg:#f4f4f8;
    --order-history-card:#ffffff;
    --order-history-text:#10131b;
    --order-history-muted:#6b7280;
    --order-history-line:#e6e7ee;
    --order-history-shadow:0 18px 44px rgba(15,23,42,.06);
  }

  body.order-history-body{
    background:
      radial-gradient(circle at top left, rgba(111,99,246,.05), transparent 24%),
      linear-gradient(180deg,#fafafe 0%,#f3f3f8 100%);
    background-attachment:fixed;
  }

  .order-history-page{
    min-height:calc(100vh - 160px);
  }

  .order-history-hero{
    background:#fff;
    padding:34px 16px 42px;
  }

  .order-history-wrap{
    width:min(960px,calc(100% - 32px));
    margin:0 auto;
  }

  .order-history-back{
    display:inline-flex;
    align-items:center;
    gap:10px;
    color:#1f2937;
    text-decoration:none;
    font-size:18px;
    font-weight:500;
    margin-bottom:18px;
  }

  .order-history-back svg{
    width:18px;
    height:18px;
    stroke:currentColor;
    fill:none;
    stroke-width:2.2;
    stroke-linecap:round;
    stroke-linejoin:round;
  }

  .order-history-title{
    margin:0;
    font-size:72px;
    letter-spacing:-0.06em;
    line-height:.96;
    font-weight:500;
    color:#0d1020;
  }

  .order-history-content{
    padding:42px 16px 72px;
  }

  .order-history-card{
    background:rgba(255,255,255,.9);
    border:1px solid rgba(255,255,255,.7);
    border-radius:20px;
    min-height:204px;
    display:flex;
    align-items:center;
    justify-content:center;
    text-align:center;
    padding:36px 24px;
    box-shadow:var(--order-history-shadow);
    backdrop-filter:blur(10px);
    -webkit-backdrop-filter:blur(10px);
  }

  .order-history-card__text{
    margin:0;
    font-size:18px;
    line-height:1.5;
    color:#111827;
    font-weight:500;
  }

  @media (max-width: 991px){
    .order-history-title{
      font-size:60px;
    }
  }

  @media (max-width: 767px){
    .order-history-hero{
      padding:28px 14px 28px;
    }

    .order-history-content{
      padding:28px 14px 48px;
    }

    .order-history-wrap{
      width:min(100%, calc(100% - 8px));
    }

    .order-history-back{
      font-size:16px;
      gap:8px;
      margin-bottom:14px;
    }

    .order-history-title{
      font-size:46px;
      line-height:1;
    }

    .order-history-card{
      border-radius:18px;
      min-height:170px;
      padding:28px 18px;
    }

    .order-history-card__text{
      font-size:17px;
    }
  }
</style>

<script>
  document.body.classList.add('order-history-body');
</script>

<main class="order-history-page">
  <section class="order-history-hero">
    <div class="order-history-wrap">
      <a href="{{ route('my-account') }}" class="order-history-back">
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 18l-6-6 6-6"></path></svg>
        <span>Account</span>
      </a>

      <h1 class="order-history-title">Order History</h1>
    </div>
  </section>

  <section class="order-history-content">
    <div class="order-history-wrap">
      <div class="order-history-card">
        <p class="order-history-card__text">No orders found.</p>
      </div>
    </div>
  </section>
</main>


@include('frontend.partials.footer')