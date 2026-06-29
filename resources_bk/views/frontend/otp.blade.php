

@include('frontend.partials.header')

<style>
  :root{
    --signin-bg:#f3f3f7;
    --signin-card:#ffffff;
    --signin-text:#111827;
    --signin-muted:#6b7280;
    --signin-line:#d9dbe3;
    --signin-black:#151515;
    --signin-link:#5b5ce9;
  }

  body.signin-page-body{
    background:var(--signin-bg);
  }

  .signin-page{
    min-height:calc(100vh - 160px);
    background:var(--signin-bg);
    padding:48px 16px 36px;
  }

  .signin-shell{
    max-width:1180px;
    margin:0 auto;
    display:flex;
    justify-content:center;
    align-items:flex-start;
  }

  .signin-card{
    width:100%;
    max-width:560px;
    background:var(--signin-card);
    border-radius:22px;
    padding:42px 44px 34px;
    box-shadow:0 10px 30px rgba(15, 23, 42, 0.06);
    position:relative;
  }

  .signin-close{
    position:absolute;
    top:20px;
    right:20px;
    width:42px;
    height:42px;
    border:none;
    background:#f2f2f5;
    border-radius:999px;
    display:flex;
    align-items:center;
    justify-content:center;
    cursor:pointer;
    color:#5d616d;
    font-size:22px;
    line-height:1;
  }

  .signin-close:hover{
    background:#e9e9ee;
  }

  .signin-logo{
    display:flex;
    justify-content:center;
    margin-bottom:22px;
  }

  .signin-logo img{
    width:168px;
    max-width:100%;
    height:auto;
    display:block;
  }

  .signin-title{
    margin:0;
    text-align:center;
    font-size:30px;
    line-height:1.14;
    font-weight:700;
    color:var(--signin-text);
    letter-spacing:-0.03em;
  }

  .signin-subtitle{
    margin:12px 0 0;
    text-align:center;
    font-size:15px;
    line-height:1.5;
    color:var(--signin-muted);
  }

  .signin-form{
    margin-top:34px;
  }

  .signin-field{
    margin-bottom:18px;
  }

  .signin-label{
    display:block;
    font-size:14px;
    line-height:1.4;
    font-weight:600;
    color:#374151;
    margin-bottom:10px;
  }

  .signin-input{
    width:100%;
    height:64px;
    border:1px solid var(--signin-line);
    border-radius:16px;
    background:#fff;
    padding:0 20px;
    font-size:15px;
    color:var(--signin-text);
    outline:none;
    transition:border-color .18s ease, box-shadow .18s ease;
  }

  .signin-input::placeholder{
    color:#8b909a;
  }

  .signin-input:focus{
    border-color:#b8becc;
    box-shadow:0 0 0 4px rgba(91,92,233,.08);
  }

  .signin-btn,
  .signin-google{
    width:100%;
    min-height:62px;
    border-radius:999px;
    font-size:15px;
    font-weight:700;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:12px;
    cursor:pointer;
    text-decoration:none;
    transition:transform .16s ease, box-shadow .16s ease, background .16s ease, border-color .16s ease;
  }

  .signin-btn{
    border:none;
    background:linear-gradient(180deg,#1c1c1f,#101012);
    color:#fff;
    box-shadow:0 10px 24px rgba(0,0,0,.14);
  }

  .signin-btn:hover,
  .signin-google:hover{
    transform:translateY(-1px);
  }

  .signin-divider{
    display:flex;
    align-items:center;
    gap:18px;
    margin:26px 0;
    color:#6f7380;
    font-size:15px;
    font-weight:600;
  }

  .signin-divider::before,
  .signin-divider::after{
    content:"";
    flex:1;
    height:1px;
    background:#d7d9e0;
  }

  .signin-google{
    border:1px solid #2a2a2a;
    background:#fff;
    color:#2c2f38;
  }

  .signin-google svg{
    width:22px;
    height:22px;
    flex:0 0 auto;
  }

  .signin-bottom{
    text-align:center;
    margin-top:32px;
    font-size:15px;
    color:#232632;
  }

  .signin-bottom a,
  .signin-region-link,
  .signin-footer a{
    color:var(--signin-link);
    font-weight:600;
    text-decoration:none;
  }

  .signin-bottom a:hover,
  .signin-region-link:hover,
  .signin-footer a:hover{
    text-decoration:underline;
  }

  .signin-footer{
    max-width:560px;
    margin:26px auto 0;
    text-align:center;
    color:#9a9daa;
    font-size:14px;
    line-height:1.7;
  }

  .signin-region-line{
    margin-top:2px;
  }

  .signin-modal{
    position:fixed;
    inset:0;
    display:none;
    align-items:center;
    justify-content:center;
    padding:20px;
    background:rgba(17, 19, 24, .55);
    z-index:2500;
  }

  .signin-modal.is-open{
    display:flex;
  }

  .signin-modal__dialog{
    width:100%;
    max-width:540px;
    background:#fff;
    border-radius:24px;
    overflow:hidden;
    box-shadow:0 26px 70px rgba(0,0,0,.24);
  }

  .signin-modal__head{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:16px;
    padding:26px 26px 20px;
  }

  .signin-modal__title{
    margin:0;
    font-size:28px;
    line-height:1.1;
    font-weight:700;
    color:#10131b;
    letter-spacing:-0.03em;
  }

  .signin-modal__close{
    width:44px;
    height:44px;
    border:none;
    border-radius:999px;
    background:#f1f1f5;
    color:#5a5f6d;
    font-size:22px;
    cursor:pointer;
  }

  .signin-modal__body{
    padding:26px 26px 28px;
    border-top:1px solid #efeff4;
  }

  .signin-current-region{
    text-align:center;
    margin-bottom:34px;
  }

  .signin-current-region .flag-emoji{
    display:block;
    font-size:62px;
    line-height:1;
    margin-bottom:18px;
  }

  .signin-current-region p{
    margin:0;
    font-size:18px;
    line-height:1.5;
    color:#111827;
  }

  .signin-current-region strong{
    font-weight:700;
  }

  .signin-region-label{
    display:block;
    margin-bottom:14px;
    font-size:15px;
    color:#6b7280;
  }

  .signin-region-list{
    display:grid;
    gap:10px;
  }

  .signin-region-option{
    width:100%;
    min-height:74px;
    border:1px solid #d6d8e1;
    border-radius:14px;
    background:#fff;
    display:flex;
    align-items:center;
    gap:14px;
    padding:16px 18px;
    font-size:16px;
    font-weight:600;
    color:#1f2937;
    cursor:pointer;
    text-align:left;
  }

  .signin-region-option:hover{
    border-color:#bcc2d0;
    background:#fafafe;
  }

  .signin-region-option .flag-emoji{
    font-size:34px;
    line-height:1;
    flex:0 0 auto;
  }

  @media (max-width: 767px){
    .signin-page{
      padding:28px 12px 28px;
    }

    .signin-card{
      max-width:100%;
      padding:34px 20px 28px;
      border-radius:18px;
    }

    .signin-close{
      top:14px;
      right:14px;
      width:38px;
      height:38px;
      font-size:20px;
    }

    .signin-logo img{
      width:148px;
    }

    .signin-title{
      font-size:24px;
    }

    .signin-subtitle{
      font-size:14px;
    }

    .signin-input{
      height:58px;
      border-radius:14px;
      padding:0 16px;
    }

    .signin-btn,
    .signin-google{
      min-height:56px;
      font-size:14px;
    }

    .signin-modal__head{
      padding:22px 18px 16px;
    }

    .signin-modal__title{
      font-size:24px;
    }

    .signin-modal__body{
      padding:20px 18px 22px;
    }

    .signin-region-option{
      min-height:68px;
      padding:14px 16px;
      font-size:15px;
    }
  }
</style>

<script>
  document.body.classList.add('signin-page-body');
</script>

<main class="signin-page">
  <div class="signin-shell">
    <section class="signin-card" aria-labelledby="signinTitle">
      <button class="signin-close" type="button" aria-label="Close sign in" onclick="window.location.href='{{ url('/') }}';">×</button>

      <div class="signin-logo">
        <img src="https://dslclinic.com/frontend/images/Diamond%20Skin.png" alt="DSL logo">
      </div>

      <h1 class="signin-title" id="signinTitle">Enter OTP</h1>
      <p class="signin-subtitle">OTP has been sent on your email id.</p>

      <form class="signin-form" action="{{ url('verify-otp') }}" method="post">
          @csrf
        <div class="signin-field"> <label class="signin-label" for="otp">Enter OTP</label> 
        <input class="signin-input" type="number" id="otp" name="otp" placeholder="Enter OTP" required > </div> 
        @if(session('error')) 
        <div style="color:red; margin-bottom:10px;"> {{ session('error') }} </div> 
        @endif 
        <!-- Hidden Email --> 
        <input type="hidden" name="email" value="{{ session('email') }}" > 
        <!-- Hidden Password --> 
        <input type="hidden" name="password" value="1234" > <button class="signin-btn" type="submit"> 
        @if(session('app_locale')=='cn') جاری رکھیں @elseif(session('app_locale')=='ar') يكمل @else Continue @endif </button>

        
      </form>

      <div class="signin-bottom">
        Try with another account? <a href="{{ url('login') }}">Sign in</a>
      </div>
    </section>
  </div>

  <div class="signin-footer">
    <div>© 2026 Valterous Limited. All rights reserved.</div>
    <div class="signin-region-line">
      DSL Clinic USA. <a class="signin-region-link" href="#" id="changeRegionLink">Change region?</a>
    </div>
  </div>
</main>

<div class="signin-modal" id="regionModal" aria-hidden="true">
  <div class="signin-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="regionModalTitle">
    <div class="signin-modal__head">
      <h2 class="signin-modal__title" id="regionModalTitle">Change region</h2>
      <button class="signin-modal__close" type="button" aria-label="Close change region dialog" id="regionModalClose">×</button>
    </div>

    <div class="signin-modal__body">
      <div class="signin-current-region">
        <span class="flag-emoji">🇺🇸</span>
        <p>Your region is set to <strong>USA</strong></p>
      </div>

      <span class="signin-region-label">Choose a different region:</span>

      <div class="signin-region-list">
        <button class="signin-region-option" type="button">
          <span class="flag-emoji">🇮🇪</span>
          <span>Ireland</span>
        </button>

        <button class="signin-region-option" type="button">
          <span class="flag-emoji">🇬🇧</span>
          <span>United Kingdom</span>
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  (function(){
    const modal = document.getElementById('regionModal');
    const openBtn = document.getElementById('changeRegionLink');
    const closeBtn = document.getElementById('regionModalClose');

    if (!modal || !openBtn || !closeBtn) return;

    const openModal = function(e){
      if (e) e.preventDefault();
      modal.classList.add('is-open');
      modal.setAttribute('aria-hidden', 'false');
      document.body.style.overflow = 'hidden';
    };

    const closeModal = function(){
      modal.classList.remove('is-open');
      modal.setAttribute('aria-hidden', 'true');
      document.body.style.overflow = '';
    };

    openBtn.addEventListener('click', openModal);
    closeBtn.addEventListener('click', closeModal);

    modal.addEventListener('click', function(e){
      if (e.target === modal) closeModal();
    });

    document.addEventListener('keydown', function(e){
      if (e.key === 'Escape' && modal.classList.contains('is-open')) {
        closeModal();
      }
    });
  })();
</script>


@include('frontend.partials.footer')