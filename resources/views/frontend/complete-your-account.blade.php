

@include('frontend.partials.header')


<style>
  :root{
    --account-bg:#f4f4f8;
    --account-card:rgba(255,255,255,.84);
    --account-card-solid:#ffffff;
    --account-text:#111827;
    --account-muted:#6b7280;
    --account-line:#d9dbe3;
    --account-link:#5b5ce9;
    --account-shadow:0 22px 70px rgba(15, 23, 42, 0.10);
    --account-shadow-soft:0 10px 24px rgba(15, 23, 42, 0.06);
  }

  body.complete-account-body{
    background:
      radial-gradient(circle at top left, rgba(91,92,233,.08), transparent 28%),
      radial-gradient(circle at top right, rgba(17,24,39,.05), transparent 24%),
      linear-gradient(180deg, #f7f7fb 0%, #f2f2f7 100%);
    background-attachment:fixed;
  }

  .complete-account-page{
    min-height:calc(100vh - 160px);
    background:transparent;
    padding:56px 16px 42px;
    position:relative;
    overflow:hidden;
  }

  .complete-account-page::before,
  .complete-account-page::after{
    content:"";
    position:absolute;
    border-radius:999px;
    pointer-events:none;
    filter:blur(12px);
    opacity:.55;
  }

  .complete-account-page::before{
    width:260px;
    height:260px;
    background:radial-gradient(circle, rgba(91,92,233,.14) 0%, rgba(91,92,233,0) 72%);
    top:48px;
    left:max(10px, calc(50% - 420px));
  }

  .complete-account-page::after{
    width:240px;
    height:240px;
    background:radial-gradient(circle, rgba(17,24,39,.08) 0%, rgba(17,24,39,0) 72%);
    bottom:34px;
    right:max(10px, calc(50% - 390px));
  }

  .complete-account-shell{
    max-width:1180px;
    margin:0 auto;
    display:flex;
    justify-content:center;
    align-items:flex-start;
    position:relative;
    z-index:1;
  }

  .complete-account-card{
    width:100%;
    max-width:560px;
    background:var(--account-card);
    border:1px solid rgba(255,255,255,.65);
    border-radius:26px;
    padding:42px 34px 34px;
    box-shadow:var(--account-shadow);
    position:relative;
    overflow:hidden;
    backdrop-filter:blur(16px);
    -webkit-backdrop-filter:blur(16px);
    animation:accountCardFloat .7s ease both;
  }

  .complete-account-card::before{
    content:"";
    position:absolute;
    inset:0;
    background:linear-gradient(135deg, rgba(255,255,255,.35), rgba(255,255,255,0) 42%);
    pointer-events:none;
  }

  .complete-account-card::after{
    content:"";
    position:absolute;
    top:-120px;
    right:-120px;
    width:220px;
    height:220px;
    border-radius:50%;
    background:radial-gradient(circle, rgba(91,92,233,.10) 0%, rgba(91,92,233,0) 70%);
    pointer-events:none;
  }

  .complete-account-close{
    position:absolute;
    top:20px;
    right:20px;
    width:42px;
    height:42px;
    border:1px solid rgba(17,24,39,.05);
    background:rgba(242,242,245,.86);
    border-radius:999px;
    display:flex;
    align-items:center;
    justify-content:center;
    cursor:pointer;
    color:#5d616d;
    font-size:22px;
    line-height:1;
    backdrop-filter:blur(8px);
    -webkit-backdrop-filter:blur(8px);
    transition:transform .18s ease, background .18s ease, box-shadow .18s ease;
    z-index:2;
  }

  .complete-account-close:hover{
    background:#ececf2;
    transform:translateY(-1px);
    box-shadow:0 8px 18px rgba(15,23,42,.10);
  }

  .complete-account-logo{
    display:flex;
    justify-content:center;
    margin-bottom:22px;
    animation:accountFadeUp .7s ease .08s both;
  }

  .complete-account-logo img{
    width:168px;
    max-width:100%;
    height:auto;
    display:block;
  }

  .complete-account-title{
    margin:0;
    text-align:center;
    font-size:32px;
    line-height:1.1;
    font-weight:700;
    color:var(--account-text);
    letter-spacing:-0.04em;
    animation:accountFadeUp .7s ease .14s both;
  }

  .complete-account-subtitle{
    margin:12px 0 0;
    text-align:center;
    font-size:15px;
    line-height:1.5;
    color:var(--account-muted);
    animation:accountFadeUp .7s ease .2s both;
  }

  .complete-account-form{
    margin-top:30px;
    animation:accountFadeUp .7s ease .26s both;
  }

  .complete-account-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:12px;
    margin-bottom:14px;
  }

  .complete-account-field{
    margin-bottom:14px;
  }

  .complete-account-input,
  .complete-account-static,
  .complete-account-phone{
    width:100%;
    min-height:64px;
    border:1px solid rgba(17,24,39,.10);
    border-radius:18px;
    background:rgba(255,255,255,.90);
    padding:0 18px;
    font-size:15px;
    color:var(--account-text);
    outline:none;
    transition:border-color .18s ease, box-shadow .18s ease, background .18s ease, transform .18s ease;
    box-shadow:inset 0 1px 0 rgba(255,255,255,.65);
  }

  .complete-account-input::placeholder{
    color:#8b909a;
  }

  .complete-account-input:focus,
  .complete-account-phone:focus-within{
    border-color:rgba(91,92,233,.34);
    background:#fff;
    box-shadow:0 0 0 4px rgba(91,92,233,.08), 0 12px 24px rgba(91,92,233,.06);
    transform:translateY(-1px);
  }

  .complete-account-static{
    padding:12px 16px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
  }

  .complete-account-static__meta{
    min-width:0;
  }

  .complete-account-static__label,
  .complete-account-phone__label{
    display:block;
    font-size:12px;
    line-height:1.25;
    color:#73798a;
    margin-bottom:6px;
    font-weight:600;
  }

  .complete-account-static__value{
    display:block;
    font-size:16px;
    line-height:1.35;
    color:#4b5563;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
  }

  .complete-account-change{
    color:var(--account-link);
    font-size:15px;
    font-weight:700;
    text-decoration:none;
    flex:0 0 auto;
  }

  .complete-account-change:hover,
  .complete-account-footer a:hover,
  .complete-account-region-link:hover,
  .complete-account-check a:hover{
    text-decoration:underline;
  }

  .complete-account-phone{
    display:flex;
    align-items:center;
    gap:12px;
    padding:12px 16px;
  }

  .complete-account-phone__left{
    display:flex;
    align-items:center;
    gap:10px;
    flex:0 0 auto;
    padding-right:10px;
  }

  .complete-account-flag{
    font-size:28px;
    line-height:1;
  }

  .complete-account-dial{
    font-size:16px;
    font-weight:600;
    color:#111827;
    white-space:nowrap;
  }

  .complete-account-phone__right{
    flex:1 1 auto;
    min-width:0;
  }

  .complete-account-phone__input{
    width:100%;
    border:none;
    outline:none;
    background:transparent;
    font-size:16px;
    color:#111827;
    padding:0;
    margin:0;
  }

  .complete-account-phone__input::placeholder{
    color:#9ca3af;
  }

  .complete-account-checks{
    margin-top:8px;
    display:grid;
    gap:12px;
  }

  .complete-account-check{
    display:flex;
    align-items:flex-start;
    gap:10px;
    color:#5f6575;
    font-size:15px;
    line-height:1.5;
  }

  .complete-account-check input{
    appearance:none;
    -webkit-appearance:none;
    width:20px;
    height:20px;
    margin:1px 0 0;
    border-radius:6px;
    border:1.5px solid #6b7280;
    background:#fff;
    cursor:pointer;
    position:relative;
    flex:0 0 auto;
    transition:border-color .16s ease, background .16s ease, box-shadow .16s ease;
  }

  .complete-account-check input:checked{
    background:#1f2937;
    border-color:#1f2937;
    box-shadow:0 8px 16px rgba(31,41,55,.14);
  }

  .complete-account-check input:checked::after{
    content:"";
    position:absolute;
    left:6px;
    top:2px;
    width:5px;
    height:10px;
    border:solid #fff;
    border-width:0 2px 2px 0;
    transform:rotate(45deg);
  }

  .complete-account-check label{
    cursor:pointer;
  }

  .complete-account-check a,
  .complete-account-footer a,
  .complete-account-region-link{
    color:var(--account-link);
    font-weight:600;
    text-decoration:none;
  }

  .complete-account-btn{
    width:100%;
    min-height:60px;
    margin-top:24px;
    border:none;
    border-radius:999px;
    font-size:15px;
    font-weight:700;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:12px;
    cursor:pointer;
    text-decoration:none;
    position:relative;
    overflow:hidden;
    transition:transform .18s ease, box-shadow .18s ease, background .18s ease, opacity .18s ease;
    isolation:isolate;
    background:linear-gradient(180deg, #232328 0%, #121216 100%);
    color:#fff;
    box-shadow:0 14px 28px rgba(0,0,0,.18);
  }

  .complete-account-btn::before{
    content:"";
    position:absolute;
    inset:0;
    background:linear-gradient(120deg, transparent 0%, rgba(255,255,255,.18) 24%, transparent 48%);
    transform:translateX(-140%);
    transition:transform .65s ease;
    z-index:-1;
  }

  .complete-account-btn::after{
    content:"";
    position:absolute;
    inset:1px;
    border-radius:inherit;
    background:linear-gradient(180deg, rgba(255,255,255,.08), rgba(255,255,255,0));
    pointer-events:none;
  }

  .complete-account-btn:hover:not(:disabled){
    transform:translateY(-2px) scale(1.01);
    box-shadow:0 18px 34px rgba(0,0,0,.22);
  }

  .complete-account-btn:hover:not(:disabled)::before{
    transform:translateX(140%);
  }

  .complete-account-btn:disabled{
    background:#d4d4d8;
    color:#ffffff;
    box-shadow:none;
    cursor:not-allowed;
    opacity:1;
  }

  .complete-account-footer{
    max-width:560px;
    margin:26px auto 0;
    text-align:center;
    color:#9a9daa;
    font-size:14px;
    line-height:1.7;
    position:relative;
    z-index:1;
    animation:accountFadeUp .7s ease .38s both;
  }

  .complete-account-region-line{
    margin-top:2px;
  }

  .complete-account-modal{
    position:fixed;
    inset:0;
    display:none;
    align-items:center;
    justify-content:center;
    padding:20px;
    background:rgba(17, 19, 24, .55);
    z-index:2500;
  }

  .complete-account-modal.is-open{
    display:flex;
  }

  .account-loader-modal{
    position:fixed;
    inset:0;
    display:none;
    align-items:center;
    justify-content:center;
    padding:20px;
    background:rgba(17, 19, 24, .58);
    z-index:2600;
  }

  .account-loader-modal.is-open{
    display:flex;
  }

  .account-loader-modal__dialog{
    width:100%;
    max-width:680px;
    min-height:320px;
    background:rgba(255,255,255,.96);
    border-radius:28px;
    box-shadow:0 30px 80px rgba(0,0,0,.24);
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    text-align:center;
    padding:40px 32px;
    position:relative;
    overflow:hidden;
    backdrop-filter:blur(10px);
    -webkit-backdrop-filter:blur(10px);
  }

  .account-loader-modal__dialog::before{
    content:"";
    position:absolute;
    inset:0;
    background:linear-gradient(135deg, rgba(255,255,255,.46), rgba(255,255,255,0) 42%);
    pointer-events:none;
  }

  .account-loader-spinner{
    width:54px;
    height:54px;
    border-radius:50%;
    border:4px solid rgba(17,24,39,.10);
    border-top-color:#a1a1aa;
    animation:accountLoaderSpin 1s linear infinite;
    margin-bottom:26px;
  }

  .account-loader-title{
    margin:0;
    font-size:24px;
    line-height:1.25;
    font-weight:600;
    color:#111827;
    letter-spacing:-0.02em;
  }

  .account-loader-text{
    margin:20px 0 0;
    font-size:15px;
    line-height:1.6;
    color:#5f6575;
  }

  .account-loader-text a{
    color:var(--account-link);
    font-weight:700;
    text-decoration:none;
  }

  .account-loader-text a:hover{
    text-decoration:underline;
  }

  .complete-account-modal__dialog{
    width:100%;
    max-width:540px;
    background:#fff;
    border-radius:24px;
    overflow:hidden;
    box-shadow:0 26px 70px rgba(0,0,0,.24);
  }

  .complete-account-modal__head{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:16px;
    padding:26px 26px 20px;
  }

  .complete-account-modal__title{
    margin:0;
    font-size:28px;
    line-height:1.1;
    font-weight:700;
    color:#10131b;
    letter-spacing:-0.03em;
  }

  .complete-account-modal__close{
    width:44px;
    height:44px;
    border:none;
    border-radius:999px;
    background:#f1f1f5;
    color:#5a5f6d;
    font-size:22px;
    cursor:pointer;
  }

  .complete-account-modal__body{
    padding:26px 26px 28px;
    border-top:1px solid #efeff4;
  }

  .complete-account-current-region{
    text-align:center;
    margin-bottom:34px;
  }

  .complete-account-current-region .flag-emoji{
    display:block;
    font-size:62px;
    line-height:1;
    margin-bottom:18px;
  }

  .complete-account-current-region p{
    margin:0;
    font-size:18px;
    line-height:1.5;
    color:#111827;
  }

  .complete-account-current-region strong{
    font-weight:700;
  }

  .complete-account-region-label{
    display:block;
    margin-bottom:14px;
    font-size:15px;
    color:#6b7280;
  }

  .complete-account-region-list{
    display:grid;
    gap:10px;
  }

  .complete-account-region-option{
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

  .complete-account-region-option:hover{
    border-color:#bcc2d0;
    background:#fafafe;
  }

  .complete-account-region-option .flag-emoji{
    font-size:34px;
    line-height:1;
    flex:0 0 auto;
  }

  @keyframes accountCardFloat{
    from{
      opacity:0;
      transform:translateY(22px) scale(.985);
    }
    to{
      opacity:1;
      transform:translateY(0) scale(1);
    }
  }

  @keyframes accountFadeUp{
    from{
      opacity:0;
      transform:translateY(16px);
    }
    to{
      opacity:1;
      transform:translateY(0);
    }
  }

  @keyframes accountLoaderSpin{
    to{
      transform:rotate(360deg);
    }
  }

  @media (max-width: 767px){
    .complete-account-page{
      padding:28px 12px 28px;
    }

    .complete-account-card{
      max-width:100%;
      padding:34px 20px 28px;
      border-radius:20px;
    }

    .complete-account-close{
      top:14px;
      right:14px;
      width:38px;
      height:38px;
      font-size:20px;
    }

    .complete-account-logo img{
      width:148px;
    }

    .complete-account-title{
      font-size:26px;
    }

    .complete-account-subtitle{
      font-size:14px;
    }

    .complete-account-grid{
      grid-template-columns:1fr;
      gap:10px;
      margin-bottom:10px;
    }

    .complete-account-input,
    .complete-account-static,
    .complete-account-phone{
      min-height:58px;
      border-radius:16px;
      padding-left:16px;
      padding-right:16px;
    }

    .complete-account-static{
      align-items:flex-start;
      flex-direction:column;
      gap:8px;
    }

    .complete-account-static__value,
    .complete-account-phone__input,
    .complete-account-dial{
      font-size:15px;
    }

    .complete-account-btn{
      min-height:56px;
      font-size:14px;
    }

    .complete-account-modal__head{
      padding:22px 18px 16px;
    }

    .complete-account-modal__title{
      font-size:24px;
    }

    .complete-account-modal__body{
      padding:20px 18px 22px;
    }

    .complete-account-region-option{
      min-height:68px;
      padding:14px 16px;
      font-size:15px;
    }

    .account-loader-modal__dialog{
      max-width:100%;
      min-height:260px;
      border-radius:22px;
      padding:32px 20px;
    }

    .account-loader-spinner{
      width:46px;
      height:46px;
      margin-bottom:22px;
    }

    .account-loader-title{
      font-size:20px;
    }

    .account-loader-text{
      font-size:14px;
    }
  }
</style>

<script>
  document.body.classList.add('complete-account-body');
</script>

<main class="complete-account-page">
  <div class="complete-account-shell">
    <section class="complete-account-card" aria-labelledby="completeAccountTitle">
      <button class="complete-account-close" type="button" aria-label="Close complete account" onclick="window.location.href='{{ url('/') }}';">×</button>

      <div class="complete-account-logo">
        <img src="https://dslclinic.com/frontend/images/Diamond%20Skin.png" alt="DSL Clinic Clinic">
      </div>

      <h1 class="complete-account-title" id="completeAccountTitle">Complete your account</h1>
      <p class="complete-account-subtitle">Please complete your details below</p>

      <form class="complete-account-form" action="#" method="post" id="completeAccountForm">
        <div class="complete-account-grid">
          <div class="complete-account-field">
            <input class="complete-account-input" type="text"  name="first_name" id="first_name" value="{{ Auth::guard('customer')->user()->first_name }}" placeholder="First Name" required>
          </div>
          <div class="complete-account-field">
            <input class="complete-account-input" type="text" name="last_name" id="last_name" value="{{ Auth::guard('customer')->user()->last_name }}" placeholder="Last Name" required>
          </div>
        </div>

        <div class="complete-account-field">
          <div class="complete-account-static">
            <div class="complete-account-static__meta">
              <span class="complete-account-static__label">Email</span>
              <span class="complete-account-static__value">{{ Auth::guard('customer')->user()->email }}</span>
            </div>
            <a href="{{ url('/logout') }}" class="complete-account-change">Change?</a>
          </div>
        </div>

        <div class="complete-account-field">
          <div class="complete-account-phone">
            <!--<div class="complete-account-phone__left">-->
            <!--  <span class="complete-account-flag">🇺🇸</span>-->
            <!--  <span class="complete-account-dial">+1</span>-->
            <!--</div>-->
            <div class="complete-account-phone__right">
              <span class="complete-account-phone__label">Phone number</span>
              <input class="complete-account-phone__input" type="tel" name="mobile" id="mobile" value="{{ Auth::guard('customer')->user()->mobile }}" placeholder="Enter phone number" required>
            </div>
          </div>
        </div>

        <div class="complete-account-checks">
          <div class="complete-account-check">
            <input type="checkbox" id="promoConsent" name="promo_consent" required>
            <label for="promoConsent">Send me promotions and special offers</label>
          </div>

          <div class="complete-account-check">
            <input type="checkbox" id="termsConsent" name="terms_consent" required>
            <label for="termsConsent">I agree to DSL Clinic <a href="#">terms and conditions</a></label>
          </div>
        </div>
        
        <div class="complete-account-checks">
          <div class="px-4" id="subitMessage"></div>
        </div>
        
        <button class="complete-account-btn" type="button" id="completeAccountBtn" onclick="updateProfile()">Continue</button>
        
      </form>
    </section>
  </div>

  <div class="complete-account-footer">
    <div>© 2026 Valterous Limited. All rights reserved.</div>
    <div class="complete-account-region-line">
      DSL Clinic USA. <a class="complete-account-region-link" href="#" id="changeRegionLink">Change region?</a>
    </div>
  </div>
</main>


<div class="complete-account-modal" id="regionModal" aria-hidden="true">
  <div class="complete-account-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="regionModalTitle">
    <div class="complete-account-modal__head">
      <h2 class="complete-account-modal__title" id="regionModalTitle">Change region</h2>
      <button class="complete-account-modal__close" type="button" aria-label="Close change region dialog" id="regionModalClose">×</button>
    </div>

    <div class="complete-account-modal__body">
      <div class="complete-account-current-region">
        <span class="flag-emoji">🇺🇸</span>
        <p>Your region is set to <strong>USA</strong></p>
      </div>

      <span class="complete-account-region-label">Choose a different region:</span>

      <div class="complete-account-region-list">
        <button class="complete-account-region-option" type="button">
          <span class="flag-emoji">🇮🇪</span>
          <span>Ireland</span>
        </button>

        <button class="complete-account-region-option" type="button">
          <span class="flag-emoji">🇬🇧</span>
          <span>United Kingdom</span>
        </button>
      </div>
    </div>
  </div>
</div>

<div class="account-loader-modal" id="accountLoaderModal" aria-hidden="true">
  <div class="account-loader-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="accountLoaderTitle">
    <div class="account-loader-spinner" aria-hidden="true"></div>
    <h2 class="account-loader-title" id="accountLoaderTitle">Setting up your account ...</h2>
    <p class="account-loader-text">If you are not automatically redirected, <a href="my-account.php">click here</a> to continue</p>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    
    function updateProfile() {
        
        var first_name = $('#first_name').val();
        var last_name = $('#last_name').val();
        var email = $('#email').val();
        var mobile = $('#mobile').val();
        var dob = '';
        var gender = '';
        
        var promo_consent = $('#promoConsent').is(':checked') ? 1 : 0;
        var terms_consent = $('#termsConsent').is(':checked') ? 1 : 0;

        if (first_name == '') {
            $('#subitMessage').html('<div style="color: red;">Enter first name</div>');
            $('#first_name').focus();
            //alert('Enter first name.');
            return false;
        } else {
        }
        
        /*if (email == '') {
            $('#email').focus();
            //alert('Enter email.');
            return false;
        } else {
        }*/
        
        if (mobile == '') {
            $('#subitMessage').html('<div style="color: red;">Enter mobile</div>');
            $('#mobile').focus();
            //alert('Enter mobile.');
            return false;
        } else {
        }
        
        
        if(promo_consent == 0)
        {
            $('#subitMessage').html('<div style="color: red;">Please allow promotions</div>');
            $('#promoConsent').focus();
            return false;
        }
        
        if(terms_consent == 0)
        {
            $('#subitMessage').html('<div style="color: red;">Please accept term & conditions</div>');
            $('#termsConsent').focus();
            return false;
        }
        
        
        
        return $.ajax({
            url: "{{ route('updateProfile') }}",
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                first_name: first_name,
                last_name: last_name,
                email: email,
                mobile: mobile,
                dob: dob,
                gender: gender
            },
            beforeSend: function(res) {
                //$('#state').html('<option value="">Loading...</option>');
            },
            success: function(res) {
                //console.log(res);
                if(res.status=='success'){
                    /*$('#first_name').val('');
                    $('#last_name').val('');
                    $('#email').val('');
                    $('#mobile').val('');
                    $('#dob').val('');
                    $('#gender').val('');*/
                    
                    $('#subitMessage').html('<div id="alertMessage" class="alert alert-success" role="alert">Profile updated successfully!</div>');
                    //window.location.reload();
                    window.location.href = "/profile";
                }else{
                    $('#subitMessage').html('<div id="alertMessage" class="alert alert-danger" role="alert">Something went wrong!</div>');  
                }
            }
        })
    }
    
</script>

<script>
//   (function(){
//     const body = document.body;
//     const modal = document.getElementById('regionModal');
//     const openBtn = document.getElementById('changeRegionLink');
//     const closeBtn = document.getElementById('regionModalClose');
//     const form = document.getElementById('completeAccountForm');
//     const firstName = document.getElementById('firstName');
//     const lastName = document.getElementById('lastName');
//     const phoneNumber = document.getElementById('phoneNumber');
//     const termsConsent = document.getElementById('termsConsent');
//     const submitBtn = document.getElementById('completeAccountBtn');
//     const loaderModal = document.getElementById('accountLoaderModal');

//     const toggleButtonState = function(){
//       const ready =
//         firstName.value.trim() !== '' &&
//         lastName.value.trim() !== '' &&
//         phoneNumber.value.trim() !== '' &&
//         termsConsent.checked;

//       submitBtn.disabled = !ready;
//     };

//     [firstName, lastName, phoneNumber, termsConsent].forEach((field) => {
//       field.addEventListener('input', toggleButtonState);
//       field.addEventListener('change', toggleButtonState);
//     });

//     toggleButtonState();

//     if (form) {
//       form.addEventListener('submit', function(e){
//         e.preventDefault();

//         if (submitBtn.disabled) {
//           return;
//         }

//         if (loaderModal) {
//           loaderModal.classList.add('is-open');
//           loaderModal.setAttribute('aria-hidden', 'false');
//         }

//         body.style.overflow = 'hidden';
//         submitBtn.disabled = true;

//         setTimeout(function(){
//           window.location.href = 'my-account.php';
//         }, 5000);
//       });
//     }

//     if (modal && openBtn && closeBtn) {
//       const openModal = function(e){
//         if (e) e.preventDefault();
//         modal.classList.add('is-open');
//         modal.setAttribute('aria-hidden', 'false');
//         body.style.overflow = 'hidden';
//       };

//       const closeModal = function(){
//         modal.classList.remove('is-open');
//         modal.setAttribute('aria-hidden', 'true');
//         body.style.overflow = '';
//       };

//       openBtn.addEventListener('click', openModal);
//       closeBtn.addEventListener('click', closeModal);

//       modal.addEventListener('click', function(e){
//         if (e.target === modal) closeModal();
//       });

//       document.addEventListener('keydown', function(e){
//         if (e.key === 'Escape' && modal.classList.contains('is-open')) {
//           closeModal();
//         }
//       });
//     }
//   })();
</script>

@include('frontend.partials.footer')