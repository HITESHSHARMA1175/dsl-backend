

@include('frontend.partials.header')

<style>
  :root{
    --courses-bg:#f4f4f8;
    --courses-card:#ffffff;
    --courses-text:#10131b;
    --courses-muted:#6b7280;
    --courses-line:#e6e7ee;
    --courses-shadow:0 18px 44px rgba(15,23,42,.06);
  }

  body.my-courses-body{
    background:
      radial-gradient(circle at top left, rgba(111,99,246,.05), transparent 24%),
      linear-gradient(180deg,#fafafe 0%,#f3f3f8 100%);
    background-attachment:fixed;
  }

  .my-courses-page{
    min-height:calc(100vh - 160px);
  }

  .my-courses-hero{
    background:#fff;
    padding:34px 16px 42px;
  }

  .my-courses-wrap{
    width:min(960px,calc(100% - 32px));
    margin:0 auto;
  }

  .my-courses-back{
    display:inline-flex;
    align-items:center;
    gap:10px;
    color:#1f2937;
    text-decoration:none;
    font-size:18px;
    font-weight:500;
    margin-bottom:18px;
  }

  .my-courses-back svg{
    width:18px;
    height:18px;
    stroke:currentColor;
    fill:none;
    stroke-width:2.2;
  }

  .my-courses-title{
    margin:0;
    font-size:72px;
    letter-spacing:-0.06em;
    font-weight:500;
    color:#0d1020;
  }

  .my-courses-content{
    padding:42px 16px 72px;
  }

  .my-courses-card{
    background:rgba(255,255,255,.9);
    border:1px solid rgba(255,255,255,.7);
    border-radius:20px;
    padding:62px 28px 60px;
    text-align:center;
    box-shadow:var(--courses-shadow);
    backdrop-filter:blur(10px);
  }

  .my-courses-card__title{
    margin:0;
    font-size:18px;
    font-weight:600;
    color:#111827;
  }

  .my-courses-card__desc{
    margin:14px 0 0;
    font-size:16px;
    color:#6b7280;
  }

  .my-courses-card__btn{
    margin-top:28px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:230px;
    min-height:54px;
    border-radius:999px;
    border:1.5px solid #3f3f46;
    background:#fff;
    color:#27272a;
    font-size:16px;
    font-weight:600;
    text-decoration:none;
    transition:.2s ease;
  }

  .my-courses-card__btn:hover{
    transform:translateY(-2px);
    box-shadow:0 12px 24px rgba(15,23,42,.08);
    background:#fafafa;
  }

  @media(max-width:767px){
    .my-courses-title{
      font-size:44px;
    }

    .my-courses-card{
      padding:42px 18px 38px;
    }

    .my-courses-card__btn{
      width:100%;
      min-height:50px;
      font-size:15px;
    }
  }
</style>

<script>
  document.body.classList.add('my-courses-body');
</script>

<main class="my-courses-page">

  <section class="my-courses-hero">
    <div class="my-courses-wrap">

      <a href="{{ route('my-account') }}" class="my-courses-back">
        <svg viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"></path></svg>
        Account
      </a>

      <h1 class="my-courses-title">My Courses</h1>

    </div>
  </section>


  <section class="my-courses-content">
    <div class="my-courses-wrap">

      <div class="my-courses-card">

        <h2 class="my-courses-card__title">
          You have not purchased any treatments.
        </h2>

        <p class="my-courses-card__desc">
          When you purchase treatments, they will appear here for you to book your sessions.
        </p>

        <a href="#" class="my-courses-card__btn">
          Shop treatments
        </a>

      </div>

    </div>
  </section>

</main>

@include('frontend.partials.footer')