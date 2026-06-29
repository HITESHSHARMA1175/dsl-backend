

@include('frontend.partials.header')



<style>
  :root{
    --account-home-bg:#f4f4f8;
    --account-home-card:#ffffff;
    --account-home-text:#10131b;
    --account-home-muted:#6b7280;
    --account-home-line:#e6e7ee;
    --account-home-purple:#6f63f6;
    --account-home-purple-dark:#5d52ea;
    --account-home-shadow:0 18px 44px rgba(15,23,42,.06);
  }

  body.my-account-body{
    background:
      radial-gradient(circle at top left, rgba(111,99,246,.06), transparent 24%),
      linear-gradient(180deg, #fafafe 0%, #f3f3f8 100%);
    background-attachment:fixed;
  }

  .my-account-page{
    background:transparent;
    min-height:calc(100vh - 160px);
  }

  .my-account-hero{
    background:#fff;
    padding:54px 16px 42px;
  }

  .my-account-wrap{
    width:min(960px, calc(100% - 32px));
    margin:0 auto;
  }

  .my-account-greeting{
    margin:0 0 14px;
    font-size:16px;
    line-height:1.5;
    color:#1f2937;
    font-weight:500;
    animation:accountHeroFade .6s ease both;
  }

  .my-account-title{
    margin:0;
    font-size:72px;
    line-height:.96;
    letter-spacing:-0.06em;
    font-weight:500;
    color:#0d1020;
    animation:accountHeroFade .7s ease .08s both;
  }

  .my-account-content{
    padding:44px 16px 70px;
  }

  .my-account-panel,
  .my-account-manage{
    animation:accountCardFade .7s ease .16s both;
  }

  .my-account-panel{
    background:rgba(255,255,255,.84);
    border:1px solid rgba(255,255,255,.7);
    border-radius:20px;
    padding:64px 28px 60px;
    text-align:center;
    box-shadow:var(--account-home-shadow);
    backdrop-filter:blur(10px);
    -webkit-backdrop-filter:blur(10px);
  }

  .my-account-panel__text{
    margin:0;
    font-size:18px;
    line-height:1.55;
    color:#111827;
    font-weight:500;
  }

  .my-account-panel__cta{
    margin-top:26px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:270px;
    min-height:52px;
    padding:0 28px;
    border:none;
    border-radius:999px;
    background:linear-gradient(180deg, var(--account-home-purple), var(--account-home-purple-dark));
    color:#fff;
    font-size:16px;
    font-weight:700;
    text-decoration:none;
    box-shadow:0 14px 28px rgba(111,99,246,.22);
    transition:transform .18s ease, box-shadow .18s ease, filter .18s ease;
    position:relative;
    overflow:hidden;
  }

  .my-account-panel__cta::before{
    content:"";
    position:absolute;
    inset:0;
    background:linear-gradient(120deg, transparent 0%, rgba(255,255,255,.18) 24%, transparent 48%);
    transform:translateX(-140%);
    transition:transform .7s ease;
  }

  .my-account-panel__cta:hover{
    transform:translateY(-2px);
    box-shadow:0 18px 34px rgba(111,99,246,.28);
    filter:brightness(1.01);
  }

  .my-account-panel__cta:hover::before{
    transform:translateX(140%);
  }

  .my-account-manage{
    margin-top:26px;
  }

  .my-account-manage__title{
    margin:0 0 16px;
    font-size:22px;
    line-height:1.2;
    color:#10131b;
    font-weight:700;
  }

  .my-account-list{
    background:rgba(255,255,255,.86);
    border:1px solid rgba(255,255,255,.7);
    border-radius:18px;
    overflow:hidden;
    box-shadow:var(--account-home-shadow);
    backdrop-filter:blur(10px);
    -webkit-backdrop-filter:blur(10px);
  }

  .my-account-item{
    display:flex;
    align-items:center;
    gap:18px;
    width:100%;
    padding:24px 28px;
    text-decoration:none;
    background:#fff;
    color:inherit;
    border-bottom:1px solid var(--account-home-line);
    transition:background .16s ease, transform .16s ease;
  }

  .my-account-item:last-child{
    border-bottom:none;
  }

  .my-account-item:hover{
    background:#fcfcff;
  }

  .my-account-item__icon{
    width:40px;
    height:40px;
    flex:0 0 40px;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#111827;
  }

  .my-account-item__icon svg{
    width:34px;
    height:34px;
    stroke:currentColor;
    fill:none;
    stroke-width:1.8;
    stroke-linecap:round;
    stroke-linejoin:round;
  }

  .my-account-item__body{
    flex:1 1 auto;
    min-width:0;
  }

  .my-account-item__title{
    margin:0;
    font-size:20px;
    line-height:1.25;
    font-weight:600;
    color:#111827;
  }

  .my-account-item__desc{
    margin:8px 0 0;
    font-size:16px;
    line-height:1.45;
    color:#707789;
  }

  .my-account-item__arrow{
    flex:0 0 auto;
    color:#6b7280;
    display:flex;
    align-items:center;
    justify-content:center;
  }

  .my-account-item__arrow svg{
    width:22px;
    height:22px;
    stroke:currentColor;
    fill:none;
    stroke-width:2;
    stroke-linecap:round;
    stroke-linejoin:round;
  }

  @keyframes accountHeroFade{
    from{
      opacity:0;
      transform:translateY(18px);
    }
    to{
      opacity:1;
      transform:translateY(0);
    }
  }

  @keyframes accountCardFade{
    from{
      opacity:0;
      transform:translateY(22px);
    }
    to{
      opacity:1;
      transform:translateY(0);
    }
  }

  @media (max-width: 991px){
    .my-account-title{
      font-size:60px;
    }
  }

  @media (max-width: 767px){
    .my-account-hero{
      padding:38px 14px 28px;
    }

    .my-account-content{
      padding:28px 14px 48px;
    }

    .my-account-wrap{
      width:min(100%, calc(100% - 8px));
    }

    .my-account-greeting{
      font-size:15px;
      margin-bottom:10px;
    }

    .my-account-title{
      font-size:44px;
      line-height:1;
    }

    .my-account-panel{
      border-radius:18px;
      padding:42px 18px 38px;
    }

    .my-account-panel__text{
      font-size:16px;
    }

    .my-account-panel__cta{
      min-width:100%;
      min-height:50px;
      padding:0 20px;
      font-size:15px;
    }

    .my-account-manage{
      margin-top:22px;
    }

    .my-account-manage__title{
      font-size:18px;
      margin-bottom:12px;
    }

    .my-account-list{
      border-radius:16px;
    }

    .my-account-item{
      padding:18px 16px;
      gap:14px;
    }

    .my-account-item__icon{
      width:34px;
      height:34px;
      flex-basis:34px;
    }

    .my-account-item__icon svg{
      width:28px;
      height:28px;
    }

    .my-account-item__title{
      font-size:17px;
    }

    .my-account-item__desc{
      margin-top:6px;
      font-size:14px;
    }
  }
</style>

<script>
  document.body.classList.add('my-account-body');
</script>

<main class="my-account-page">
  <section class="my-account-hero">
    <div class="my-account-wrap">
      <p class="my-account-greeting">Good morning, {{ Auth::guard('customer')->user()->first_name }}</p>
      <h1 class="my-account-title">My Account</h1>
    </div>
  </section>

  <section class="my-account-content">
    <div class="my-account-wrap">
      <div class="my-account-panel">
        <p class="my-account-panel__text">You have no upcoming appointments.</p>
        <a class="my-account-panel__cta" href="#">Book an appointment</a>
      </div>

      <div class="my-account-manage">
        <h2 class="my-account-manage__title">Manage</h2>

        <div class="my-account-list">
          <a class="my-account-item" href="{{ route('booking') }}">
            <div class="my-account-item__icon" aria-hidden="true">
              <svg viewBox="0 0 24 24">
                <rect x="3" y="5" width="18" height="16" rx="2"></rect>
                <path d="M16 3v4"></path>
                <path d="M8 3v4"></path>
                <path d="M3 10h18"></path>
              </svg>
            </div>
            <div class="my-account-item__body">
              <h3 class="my-account-item__title">My Bookings</h3>
              <p class="my-account-item__desc">Manage your upcoming appointments and history</p>
            </div>
            <div class="my-account-item__arrow" aria-hidden="true">
              <svg viewBox="0 0 24 24"><path d="M9 6l6 6-6 6"></path></svg>
            </div>
          </a>

          <a class="my-account-item" href="{{ route('course') }}">
            <div class="my-account-item__icon" aria-hidden="true">
              <svg viewBox="0 0 24 24">
                <path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3z"></path>
                <path d="M12 3v18"></path>
                <path d="M4 7.5L12 12l8-4.5"></path>
              </svg>
            </div>
            <div class="my-account-item__body">
              <h3 class="my-account-item__title">My Courses</h3>
              <p class="my-account-item__desc">View purchased treatments and book appointments</p>
            </div>
            <div class="my-account-item__arrow" aria-hidden="true">
              <svg viewBox="0 0 24 24"><path d="M9 6l6 6-6 6"></path></svg>
            </div>
          </a>

          <a class="my-account-item" href="{{ route('order') }}">
            <div class="my-account-item__icon" aria-hidden="true">
              <svg viewBox="0 0 24 24">
                <path d="M6 8h12l1 11H5L6 8z"></path>
                <path d="M9 8a3 3 0 0 1 6 0"></path>
              </svg>
            </div>
            <div class="my-account-item__body">
              <h3 class="my-account-item__title">My Order History</h3>
              <p class="my-account-item__desc">Manage recent orders and view previous purchases</p>
            </div>
            <div class="my-account-item__arrow" aria-hidden="true">
              <svg viewBox="0 0 24 24"><path d="M9 6l6 6-6 6"></path></svg>
            </div>
          </a>

          <a class="my-account-item" href="{{ route('profile') }}">
            <div class="my-account-item__icon" aria-hidden="true">
              <svg viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="3"></circle>
                <path d="M19.4 15a1.7 1.7 0 0 0 .34 1.87l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06A1.7 1.7 0 0 0 15 19.4a1.7 1.7 0 0 0-1 .73 1.7 1.7 0 0 1-3 0 1.7 1.7 0 0 0-1-.73 1.7 1.7 0 0 0-1.87.34l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06A1.7 1.7 0 0 0 4.6 15a1.7 1.7 0 0 0-.73-1 1.7 1.7 0 0 1 0-3 1.7 1.7 0 0 0 .73-1 1.7 1.7 0 0 0-.34-1.87l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06A1.7 1.7 0 0 0 9 4.6a1.7 1.7 0 0 0 1-.73 1.7 1.7 0 0 1 3 0 1.7 1.7 0 0 0 1 .73 1.7 1.7 0 0 0 1.87-.34l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06A1.7 1.7 0 0 0 19.4 9c0 .37.13.72.37 1a1.7 1.7 0 0 1 0 3c-.24.28-.37.63-.37 1z"></path>
              </svg>
            </div>
            <div class="my-account-item__body">
              <h3 class="my-account-item__title">Profile Settings</h3>
              <p class="my-account-item__desc">Manage your account information</p>
            </div>
            <div class="my-account-item__arrow" aria-hidden="true">
              <svg viewBox="0 0 24 24"><path d="M9 6l6 6-6 6"></path></svg>
            </div>
          </a>
        </div>
      </div>
    </div>
  </section>
</main>


@include('frontend.partials.footer')