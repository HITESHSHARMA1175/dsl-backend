<?php
/**
 * DSL Clinic Footer (original, premium dark layout)
 * - 3 link columns + utility column (app + payments)
 * - Bottom bar: region selector + social icons + copyright
 * - Responsive: stacks cleanly on mobile
 */
?>

<footer class="dsl-footer" aria-label="Site footer">
  <div class="dsl-footer__inner">

    <div class="dsl-footer__grid">
      <div class="dsl-footer__brand" aria-label="Footer brand">
        <img class="dsl-footer__logo" src="https://dslclinic.com/frontend/images/logo-plc.jpeg" alt="DSL Clinic" loading="lazy" />
      </div>

      <!-- Explore -->
      <section class="dsl-footer__col" aria-label="Explore">
        <h3 class="dsl-footer__title">Explore</h3>
        <ul class="dsl-footer__list">
          <li><a href="hair-transplant"> Hair Transplant</a></li>
          <li><a href="laser-hair-removal-for-mens">Laser Hair Removal for Men's</a></li>
          <li><a href="laser-tattoo-removal">Laser Tattoo Removal</a></li>
          <li><a href="skin-whitening">Skin Whitening</a></li>
          <li><a href="body-sculpting-package">Body Sculpting Package</a></li>
          <li><a href="shop">Shop Product</a></li>
          
        </ul>
      </section>

      <!-- Customer Care -->
      <section class="dsl-footer__col" aria-label="Customer care">
        <h3 class="dsl-footer__title">Customer Care</h3>
        <ul class="dsl-footer__list">
          <li><a href="faq">FAQ</a></li>
          <li><a href="referral">Refer a friend</a></li>
          <li><a href="finance-options">Finance Options</a></li>
          <li><a href="privacy-policy">Privacy</a></li>
          <li><a href="terms-conditions">Policies</a></li>
        </ul>
      </section>

      <!-- Company -->
      <section class="dsl-footer__col" aria-label="Company">
        <h3 class="dsl-footer__title">Company</h3>
        <ul class="dsl-footer__list">
          <li><a href="about">About</a></li>
          <li><a href="locations">Locations</a></li>
          <li><a href="reviews">Reviews</a></li>
          <li><a href="blog">Blog</a></li>
      
        </ul>
      </section>

      <!-- Utility -->
      <section class="dsl-footer__col dsl-footer__util" aria-label="Apps and payments">
        <div class="dsl-footer__block">
          <h3 class="dsl-footer__title">Download our app</h3>
          <div class="dsl-footer__badges" role="group" aria-label="App download badges">
            <a class="badge" href="#" aria-label="Download on the App Store">
              <span class="badge__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M16.365 1.43c0 1.14-.417 2.21-1.233 3.03-.86.86-2.29 1.53-3.51 1.43-.16-1.23.35-2.52 1.19-3.37.83-.85 2.31-1.46 3.55-1.09zM20.66 17.04c-.45 1.03-.66 1.49-1.24 2.4-.8 1.25-1.93 2.81-3.33 2.82-1.24.01-1.56-.81-3.25-.8-1.7.01-2.05.82-3.29.8-1.4-.01-2.48-1.39-3.28-2.64-2.27-3.5-2.5-7.61-1.11-9.75.99-1.54 2.57-2.44 4.06-2.44 1.52 0 2.48.83 3.74.83 1.23 0 1.98-.83 3.73-.83 1.33 0 2.73.73 3.72 1.98-3.26 1.79-2.73 6.5.25 7.63z"/></svg>
              </span>
              <span class="badge__text">
                <span class="badge__kicker">Download on the</span>
                <span class="badge__brand">App Store</span>
              </span>
            </a>

            <a class="badge" href="#" aria-label="Get it on Google Play">
              <span class="badge__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M3.53 2.53c-.33.33-.53.79-.53 1.3v16.34c0 .51.2.97.53 1.3l9.4-9.4-9.4-9.54z"/><path d="M14.07 12l2.62-2.62-3.18-1.84-1.82 1.82L14.07 12z"/><path d="M14.07 12l-2.38 2.38 1.82 1.82 3.18-1.84L14.07 12z"/><path d="M16.69 14.62l3.78-2.19c.56-.33.56-1.14 0-1.47l-3.78-2.19L13.51 12l3.18 2.62z"/></svg>
              </span>
              <span class="badge__text">
                <span class="badge__kicker">Get it on</span>
                <span class="badge__brand">Google Play</span>
              </span>
            </a>
          </div>
        </div>

        <div class="dsl-footer__block">
          <h3 class="dsl-footer__title">Payment methods accepted</h3>
          <div class="dsl-footer__payments" role="list" aria-label="Payment methods">
            <span class="pay" role="listitem" aria-label="Visa">VISA</span>
            <span class="pay" role="listitem" aria-label="Mastercard">MC</span>
            <span class="pay" role="listitem" aria-label="Apple Pay">Pay</span>
            <span class="pay" role="listitem" aria-label="Google Pay">GPay</span>
            <span class="pay" role="listitem" aria-label="Klarna">Klarna</span>
            <span class="pay" role="listitem" aria-label="Clearpay">Clearpay</span>
          </div>
        </div>
      </section>
    </div>

    <div class="dsl-footer__divider" aria-hidden="true"></div>

    <div class="dsl-footer__bottom">
      <div class="dsl-footer__bottomLeft">
        <button class="region" type="button" aria-label="Change region">
          <span class="region__flag" aria-hidden="true">
            <img src="https://flagcdn.com/w40/gb.png" alt="" loading="lazy" />
          </span>
          <span class="region__text">Change region</span>
        </button>

        <div class="copyright">
          <span>© <?php echo date('Y'); ?> DSL Clinic. All rights reserved.</span>
        </div>
      </div>

      <div class="footer-bottom">

    

    <div class="social" aria-label="Social links">
      <a class="social__a" href="https://www.facebook.com/p/DSL-Skin-Clinic-61562353342275/" aria-label="Facebook">
          <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M13.5 22v-8h2.7l.4-3H13.5V9.1c0-.9.3-1.6 1.6-1.6h1.7V4.8c-.3 0-1.3-.1-2.5-.1-2.5 0-4.2 1.5-4.2 4.3V11H7.6v3h2.5v8h3.4z"/></svg>
        </a>
        <a class="social__a" href="https://www.instagram.com/dslaserclinic/" aria-label="Instagram">
          <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5zm10 2H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3zm-5 4.5A5.5 5.5 0 1 1 6.5 14 5.5 5.5 0 0 1 12 8.5zm0 2A3.5 3.5 0 1 0 15.5 14 3.5 3.5 0 0 0 12 10.5zM18 6.6a1 1 0 1 1-1 1 1 1 0 0 1 1-1z"/></svg>
        </a>
       <!--  <a class="social__a" href="#" aria-label="TikTok">
          <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M16 3c.5 2.9 2.6 5 5 5v3c-1.9 0-3.6-.6-5-1.7V16a6 6 0 1 1-6-6c.4 0 .7 0 1 .1v3.2c-.3-.1-.6-.2-1-.2a3 3 0 1 0 3 3V3h3z"/></svg>
        </a -->
        <a class="social__a" href="https://www.youtube.com/@dslclinicuk" aria-label="YouTube">
          <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M21.6 7.2a3 3 0 0 0-2.1-2.1C17.7 4.6 12 4.6 12 4.6s-5.7 0-7.5.5A3 3 0 0 0 2.4 7.2 31.4 31.4 0 0 0 2 12a31.4 31.4 0 0 0 .4 4.8 3 3 0 0 0 2.1 2.1c1.8.5 7.5.5 7.5.5s5.7 0 7.5-.5a3 3 0 0 0 2.1-2.1A31.4 31.4 0 0 0 22 12a31.4 31.4 0 0 0-.4-4.8zM10 15.5v-7l6 3.5-6 3.5z"/></svg>
        </a>
       <!--  <a class="social__a" href="#" aria-label="LinkedIn">
          <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M6.6 6.8A2.1 2.1 0 1 1 6.6 2.6a2.1 2.1 0 0 1 0 4.2zM4.7 21.4V8.7h3.8v12.7H4.7zM10.7 8.7h3.6v1.7h.1c.5-1 1.8-2 3.7-2 4 0 4.7 2.6 4.7 6v7h-3.8v-6.2c0-1.5 0-3.4-2.1-3.4-2.1 0-2.4 1.6-2.4 3.3v6.3h-3.8V8.7z"/></svg>
        </a> -->
    </div>
    <div class="copyright">
        <a href="https://devolyt.com" target="_blank"><span>Design & Developed by Devolyt Technologies</span></a>
    </div>

</div>
     <!--  <div class="social" aria-label="Social links">
        <div>
        <a class="social__a" href="#" aria-label="Facebook">
          <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M13.5 22v-8h2.7l.4-3H13.5V9.1c0-.9.3-1.6 1.6-1.6h1.7V4.8c-.3 0-1.3-.1-2.5-.1-2.5 0-4.2 1.5-4.2 4.3V11H7.6v3h2.5v8h3.4z"/></svg>
        </a>
        <a class="social__a" href="#" aria-label="Instagram">
          <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5zm10 2H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3zm-5 4.5A5.5 5.5 0 1 1 6.5 14 5.5 5.5 0 0 1 12 8.5zm0 2A3.5 3.5 0 1 0 15.5 14 3.5 3.5 0 0 0 12 10.5zM18 6.6a1 1 0 1 1-1 1 1 1 0 0 1 1-1z"/></svg>
        </a>
        <a class="social__a" href="#" aria-label="TikTok">
          <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M16 3c.5 2.9 2.6 5 5 5v3c-1.9 0-3.6-.6-5-1.7V16a6 6 0 1 1-6-6c.4 0 .7 0 1 .1v3.2c-.3-.1-.6-.2-1-.2a3 3 0 1 0 3 3V3h3z"/></svg>
        </a>
        <a class="social__a" href="#" aria-label="YouTube">
          <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M21.6 7.2a3 3 0 0 0-2.1-2.1C17.7 4.6 12 4.6 12 4.6s-5.7 0-7.5.5A3 3 0 0 0 2.4 7.2 31.4 31.4 0 0 0 2 12a31.4 31.4 0 0 0 .4 4.8 3 3 0 0 0 2.1 2.1c1.8.5 7.5.5 7.5.5s5.7 0 7.5-.5a3 3 0 0 0 2.1-2.1A31.4 31.4 0 0 0 22 12a31.4 31.4 0 0 0-.4-4.8zM10 15.5v-7l6 3.5-6 3.5z"/></svg>
        </a>
        <a class="social__a" href="#" aria-label="LinkedIn">
          <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M6.6 6.8A2.1 2.1 0 1 1 6.6 2.6a2.1 2.1 0 0 1 0 4.2zM4.7 21.4V8.7h3.8v12.7H4.7zM10.7 8.7h3.6v1.7h.1c.5-1 1.8-2 3.7-2 4 0 4.7 2.6 4.7 6v7h-3.8v-6.2c0-1.5 0-3.4-2.1-3.4-2.1 0-2.4 1.6-2.4 3.3v6.3h-3.8V8.7z"/></svg>
        </a>
      </div>
          <div class="copyright">
          <span>© <?php echo date('Y'); ?> DSL Clinic. All rights reserved.</span>
        </div>
      </div> -->

    </div>
  </div>
</footer>

<style>
  .footer-bottom {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
}



.footer-bottom {
    display: flex;
    flex-direction: column;
}
  .dsl-footer{
    width:100%;
    background:#0a0a0a;
    color:#fff;
  }

  .dsl-footer__inner{
    width:100%;
    max-width:100%;
    margin:0;
    padding:64px 84px 34px;
  }

  .dsl-footer__grid{
    display:grid;
    grid-template-columns: 1.2fr 1.2fr 1.05fr 1.6fr;
    column-gap:84px;
    row-gap:44px;
    align-items:start;
  }

  .dsl-footer__brand{
    grid-column:1 / -1;
    margin:0 0 6px;
  }

  .dsl-footer__logo{
    height:44px;
    width:auto;
    display:block;
    object-fit:contain;
    filter:brightness(1.05) contrast(1.02);
  }

  .dsl-footer__title{
    margin:0 0 18px;
    font-size:20px;
    line-height:1.2;
    font-weight:800;
    letter-spacing:.2px;
    color:#ffffff;
  }

  .dsl-footer__list{
    list-style:none;
    padding:0;
    margin:0;
    display:grid;
    gap:14px;
  }

  .dsl-footer__list a{
    color:rgba(255,255,255,.70);
    font-weight:600;
    font-size:18px;
    line-height:1.25;
    transition:color .18s ease, opacity .18s ease, transform .18s ease;
  }

  .dsl-footer__list a:hover{
    color:#ffffff;
    opacity:1;
    transform:translateX(2px);
  }

  .dsl-footer__util .dsl-footer__block{margin-bottom:32px;}

  .dsl-footer__badges{
    display:flex;
    gap:14px;
    flex-wrap:wrap;
  }

  .badge{
    display:flex;
    align-items:center;
    gap:12px;
    padding:12px 14px;
    border-radius:10px;
    border:1px solid rgba(255,255,255,.22);
    background:rgba(255,255,255,.04);
    transition:background .18s ease, border-color .18s ease, transform .18s ease;
  }

  .badge:hover{
    background:rgba(255,255,255,.06);
    border-color:rgba(255,255,255,.30);
    transform:translateY(-1px);
  }

  .badge__icon{display:inline-flex; color:#fff; opacity:.95;}
  .badge__text{display:flex; flex-direction:column; line-height:1.05;}
  .badge__kicker{font-size:11px; opacity:.78; font-weight:700;}
  .badge__brand{font-size:14px; font-weight:900; letter-spacing:.2px; color:#fff;}

  .dsl-footer__payments{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
    align-items:center;
  }

  .pay{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    height:34px;
    min-width:58px;
    padding:0 12px;
    border-radius:8px;
    background:#ffffff;
    color:#0a0a0a;
    font-weight:900;
    letter-spacing:.25px;
    font-size:12px;
  }

  .dsl-footer__divider{
    margin:40px 0 22px;
    height:1px;
    background:rgba(255,255,255,.14);
  }

  .dsl-footer__bottom{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:20px;
  }

  .dsl-footer__bottomLeft{
    display:flex;
    flex-direction:column;
    gap:14px;
  }

  .region{
    display:inline-flex;
    align-items:center;
    gap:14px;
    background:transparent;
    border:0;
    color:rgba(255,255,255,.78);
    padding:8px 6px;
    border-radius:12px;
    cursor:pointer;
    font-size:16px;
    font-weight:650;
    transition:background .18s ease, color .18s ease;
  }

  .region:hover{background:rgba(255,255,255,.06); color:#fff;}
  .region__flag img{width:26px; height:26px; border-radius:999px; object-fit:cover; display:block;}

  .social{
    display:flex;
    align-items:center;
    gap:18px;
    justify-content:flex-end;
  }

  .social__a{
    width:44px;
    height:44px;
    border-radius:999px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    background:transparent;
    border:0;
    color:rgba(255,255,255,.86);
    transition:transform .18s ease, opacity .18s ease;
  }

  .social__a:hover{transform:translateY(-1px); opacity:1;}

  .copyright{
    color:rgba(255,255,255,.50);
    font-weight:600;
    font-size:14px;
  }

  /* Responsive */
  @media (max-width: 1200px){
    .dsl-footer__inner{padding:56px 40px 30px;}
    .dsl-footer__grid{column-gap:44px;}
  }

  @media (max-width: 980px){
    .dsl-footer__inner{padding:48px 18px 24px;}
    .dsl-footer__grid{grid-template-columns:1fr 1fr; column-gap:28px; row-gap:34px;}
    .dsl-footer__util{grid-column:1 / -1;}
  }

  @media (max-width: 560px){
    .dsl-footer__grid{grid-template-columns:1fr; row-gap:24px;}
    .dsl-footer__title{font-size:18px;}
    .dsl-footer__list a{font-size:17px;}
    .badge{width:100%; justify-content:flex-start;}
    .dsl-footer__divider{margin:28px 0 18px;}
    .dsl-footer__bottom{flex-direction:column; align-items:flex-start; gap:18px;}
    .social{gap:14px;}
    .social__a{width:42px; height:42px;}
  }
</style>