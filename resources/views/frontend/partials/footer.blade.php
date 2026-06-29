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
        <section class="dsl-footer__col" aria-label="Sitemap">
          <h3 class="dsl-footer__title">Sitemap</h3>
          <ul class="dsl-footer__list">
            <li><a href="sitemap">Sitemap</a></li>
            <li><a href="locations">Locations</a></li>
          </ul>
        </section>


      <!-- Utility -->
      <section class="dsl-footer__col dsl-footer__util" aria-label="Apps and payments">

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
        <div class="dsl-footer__bottomLeft" style="display: flex; flex-direction: row; align-items: center; flex-wrap: wrap; gap: 32px;">
          <button class="region" type="button" aria-label="Change region" style="margin: 0; padding: 6px 10px;">
            <span class="region__flag" aria-hidden="true">
              <img src="https://flagcdn.com/w40/gb.png" alt="" loading="lazy" />
            </span>
            <span class="region__text">Change region</span>
          </button>
          
          <div class="copyright" style="margin: 0; padding-top: 2px;">
            <span>© 2026 DSL Clinic. All rights reserved.</span>
          </div>

          <div class="copyright" style="margin: 0; padding-top: 2px;">
            <a href="https://devolyt.com" target="_blank" style="color: rgba(255, 255, 255, 0.50); text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.5)'"><span>Design & Developed by Devolyt Technologies</span></a>
          </div>
        </div>

        <div class="footer-bottom">
          <div class="social" aria-label="Social links">
            <a class="social__a" href="https://www.facebook.com/p/DSL-Skin-Clinic-61562353342275/"
              aria-label="Facebook">
              <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                <path
                  d="M13.5 22v-8h2.7l.4-3H13.5V9.1c0-.9.3-1.6 1.6-1.6h1.7V4.8c-.3 0-1.3-.1-2.5-.1-2.5 0-4.2 1.5-4.2 4.3V11H7.6v3h2.5v8h3.4z" />
              </svg>
            </a>
            <a class="social__a" href="https://www.instagram.com/dslaserclinic/" aria-label="Instagram">
              <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                <path
                  d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5zm10 2H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3zm-5 4.5A5.5 5.5 0 1 1 6.5 14 5.5 5.5 0 0 1 12 8.5zm0 2A3.5 3.5 0 1 0 15.5 14 3.5 3.5 0 0 0 12 10.5zM18 6.6a1 1 0 1 1-1 1 1 1 0 0 1 1-1z" />
              </svg>
            </a>
            <a class="social__a" href="https://www.youtube.com/@dslclinicuk" aria-label="YouTube">
              <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                <path
                  d="M21.6 7.2a3 3 0 0 0-2.1-2.1C17.7 4.6 12 4.6 12 4.6s-5.7 0-7.5.5A3 3 0 0 0 2.4 7.2 31.4 31.4 0 0 0 2 12a31.4 31.4 0 0 0 .4 4.8 3 3 0 0 0 2.1 2.1c1.8.5 7.5.5 7.5.5s5.7 0 7.5-.5a3 3 0 0 0 2.1-2.1A31.4 31.4 0 0 0 22 12a31.4 31.4 0 0 0-.4-4.8zM10 15.5v-7l6 3.5-6 3.5z" />
              </svg>
            </a>
          </div>
        </div>
      </div>



  
  </div>
</footer>
