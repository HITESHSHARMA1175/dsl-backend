<?php
/**
 * DSL Clinic Header (original implementation inspired by clean clinic layouts)
 * - Full-width sticky header
 * - Desktop dropdown menus (hover/focus)
 * - Mobile hamburger with slide-in drawer + expandable submenus
 * - Accessible: aria attributes, keyboard focus, skip link
 */
?>

<!-- Skip link for accessibility -->
<a class="skip-link" href="#main">Skip to content</a>

<!-- Optional top announcement bar -->
<div class="topbar" role="region" aria-label="Announcements">
  <div class="topbar__inner">
    <div class="topbar__rotator" aria-live="polite">
      <a class="topbar__msg is-active" href="offers.php">Refer a friend, you both get £50 off. <span class="topbar__u">See details</span></a>
      <a class="topbar__msg" href="offers.php">Special Offers! <span class="topbar__u">View Offers</span></a>
      <a class="topbar__msg" href="reviews.php">Over 80,000 five star reviews. <span class="topbar__u">See reviews</span></a>
    </div>
    <div class="topbar__dots" aria-hidden="true">
      <span class="dot is-active"></span>
      <span class="dot"></span>
      <span class="dot"></span>
    </div>
  </div>
</div>

<header class="site-header" id="siteHeader">
  <div class="header-inner">

    <!-- Logo -->
    <a class="brand" href="/" aria-label="Go to homepage">
      <span class="brand__logo" aria-hidden="true">
        <img src="https://dslclinic.com/frontend/images/logo-plc.jpeg" alt="DSL Clinic" loading="eager" />
      </span>
    </a>

    <!-- Desktop nav -->
    <nav class="nav" aria-label="Primary navigation">
      <ul class="nav__list">

        <li class="nav__item has-submenu">
          <a class="nav__link" href="treatments.php" aria-haspopup="true" aria-expanded="false">TREATMENTS</a>
          <ul class="submenu" aria-label="Treatments submenu">
            <li><a href="service-detail.php?slug=injectables">Injectables</a></li>
            <li><a href="service-detail.php?slug=laser-hair-removal">Laser Hair Removal</a></li>
            <li><a href="service-detail.php?slug=skin-treatments">Skin Treatments</a></li>
            <li><a href="service-detail.php?slug=body-treatments">Body Treatments</a></li>
            <li><a href="service-detail.php?slug=laser-tattoo-removal">Laser Tattoo Removal</a></li>
          </ul>
        </li>

        <li class="nav__item"><a class="nav__link" href="pricing.php">PRICING</a></li>
        <li class="nav__item"><a class="nav__link" href="reviews.php">REVIEWS</a></li>
        <li class="nav__item"><a class="nav__link" href="locations.php">LOCATIONS</a></li>
        <li class="nav__item"><a class="nav__link" href="shop.php">SHOP</a></li>

      </ul>
    </nav>

    <!-- Right actions -->
    <div class="header-actions">

      <div class="header-icons">
        <!-- Cart Icon -->
        <div class="icon-btn cart-icon">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M6 6h15l-1.5 9h-13z"/>
            <path d="M6 6L5 3H2"/>
          </svg>
          <span class="cart-badge">2</span>
        </div>

        <!-- User Icon -->
        <div class="icon-btn">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="7" r="4"/>
            <path d="M5.5 21a6.5 6.5 0 0 1 13 0"/>
          </svg>
        </div>

        <!-- UK Flag -->
        <div class="flag-icon">
          <img src="https://flagcdn.com/w40/gb.png" alt="UK" />
        </div>
      </div>

      <a class="btn btn--primary header-cta" href="appointment.php">Free Consultation</a>

      <!-- Mobile hamburger -->
      <button class="hamburger" type="button" aria-label="Open menu" aria-controls="mobileNav" aria-expanded="false">
        <span class="hamburger__bars" aria-hidden="true">
          <span class="hamburger__bar"></span>
        </span>
      </button>
    </div>
  </div>
</header>

<!-- Mobile drawer -->
<div class="drawer" id="mobileNav" aria-hidden="true">
  <div class="drawer__backdrop" data-drawer-close></div>
  <div class="drawer__panel" role="dialog" aria-modal="true" aria-label="Mobile navigation">
    <div class="drawer__top">
      <a class="drawer__brand" href="/" aria-label="Go to homepage">
        <img src="https://dslclinic.com/frontend/images/logo-plc.jpeg" alt="DSL Clinic" loading="eager" />
      </a>
      <button class="drawer__close" type="button" aria-label="Close menu" data-drawer-close>✕</button>
    </div>

    <nav class="mnav" aria-label="Mobile navigation">

      <button class="mnav__toggle" type="button" aria-expanded="false" aria-controls="m_treatments">
        TREATMENTS <span aria-hidden="true">▾</span>
      </button>
      <div class="mnav__submenu" id="m_treatments" hidden>
        <a href="service-detail.php?slug=injectables">Injectables</a>
        <a href="service-detail.php?slug=laser-hair-removal">Laser Hair Removal</a>
        <a href="service-detail.php?slug=skin-treatments">Skin Treatments</a>
        <a href="service-detail.php?slug=body-treatments">Body Treatments</a>
        <a href="service-detail.php?slug=laser-tattoo-removal">Laser Tattoo Removal</a>
      </div>

      <a class="mnav__link" href="pricing.php">PRICING</a>
      <a class="mnav__link" href="reviews.php">REVIEWS</a>
      <a class="mnav__link" href="locations.php">LOCATIONS</a>
      <a class="mnav__link" href="shop.php">SHOP</a>

      <div class="mnav__cta">
        <a class="btn btn--primary header-cta" href="appointment.php">Free Consultation</a>
      </div>
    </nav>
  </div>
</div>

<style>
  :root{
    --bg:#ffffff;
    --ink:#0b1b2a;
    --muted:#516072;
    --line:rgba(11,27,42,.10);
    --primary:#0f4c81;
    --primary2:#1b78c8;
    --surface:#f6f9fc;
    --shadow:0 12px 30px rgba(11,27,42,.10);
    --radius:16px;
    --navText:#0c1520;
    --navHover:#0c1520;
    --navLetter:1.2px;
  }

  *{box-sizing:border-box}
  .topbar, .site-header, .drawer{font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;}
  a{color:inherit;text-decoration:none}
  a:focus-visible, button:focus-visible{outline:3px solid rgba(27,120,200,.45); outline-offset:3px; border-radius:10px;}

  .skip-link{
    position:absolute; left:-999px; top:10px;
    background:var(--ink); color:#fff; padding:10px 14px;
    border-radius:12px; z-index:9999;
  }
  .skip-link:focus{left:10px;}

  .topbar{width:100%; background: #000; border-bottom:1px solid var(--line);}
  .topbar__inner{
    width:100%;
    max-width:100%;
    margin:0;
    padding:10px 20px;
    display:flex;
    gap:14px;
    align-items:center;
    justify-content:center;
  }

  .topbar__rotator{
    position:relative;
    display:flex;
    align-items:center;
    justify-content:center;
    min-height:18px;
    width:100%;
    max-width:900px;
    overflow:hidden;
  }

  .topbar__msg{
    position:absolute;
    left:0;
    right:0;
    margin:0 auto;
    text-align:center;
    color: #fff;
    font-size:14px;
    line-height:1.3;
    font-weight:600;
    opacity:0;
    transform:translateY(8px);
    transition:opacity .35s ease, transform .35s ease;
    white-space:nowrap;
    text-overflow:ellipsis;
    overflow:hidden;
    padding:0 10px;
  }

  .topbar__msg:hover{color:var(--ink);}

  .topbar__msg.is-active{
    opacity:1;
    transform:translateY(0);
  }

  .topbar__u{
    text-decoration:underline;
    text-underline-offset:3px;
    text-decoration-thickness:2px;
    text-decoration-color:rgba(12,21,32,.25);
  }

  .topbar__dots{
    display:flex;
    gap:6px;
    align-items:center;
  }
  .topbar__dots .dot{
    width:6px;
    height:6px;
    border-radius:999px;
    background:rgba(12,21,32,.20);
  }
  .topbar__dots .dot.is-active{
    background:rgba(12,21,32,.55);
  }

  @media (max-width: 640px){
    .topbar__inner{padding:10px 12px;}
    .topbar__dots{display:none;}
    .topbar__msg{font-size:13px;}
  }

  .site-header{
    width:100%;
    position:sticky;
    top:0;
    z-index:1000;
    background:#fff;
    border-bottom:1px solid var(--line);
  }
  .site-header.is-scrolled{box-shadow:0 10px 25px rgba(11,27,42,.08)}

  .header-inner{
    width:100%;
    max-width:100%;
    margin:0;
    padding:14px 20px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:14px;
  }

  .brand{display:flex; align-items:center; gap:10px; min-width:140px;}
  .brand__logo{display:flex; align-items:center; justify-content:center; max-height:44px;}
  .brand__logo img{height:44px; width:auto; display:block; object-fit:contain;}

  .nav{display:flex; align-items:center; flex:1; justify-content:center;}
  .nav__list{list-style:none; padding:0; margin:0; display:flex; align-items:center; gap:6px;}
  .nav__item{position:relative;}
  .nav__link{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:10px 14px;
    border-radius:999px;
    color:var(--navText);
    font-weight:700;
    font-size:13px;
    letter-spacing:var(--navLetter);
    text-transform:uppercase;
    transition:opacity .2s ease, text-decoration-color .2s ease;
    text-decoration:underline;
    text-decoration-thickness:2px;
    text-underline-offset:8px;
    text-decoration-color:transparent;
  }
  .nav__link:hover{
    opacity:.85;
    text-decoration-color:rgba(12,21,32,.35);
  }

  .has-submenu > .nav__link::after{
    content:"▾";
    font-size:11px;
    opacity:.65;
    transform:translateY(1px);
    margin-left:2px;
  }

  .submenu{
    position:absolute;
    left:0;
    top:calc(100% + 10px);
    min-width:240px;
    background:var(--bg);
    border:1px solid var(--line);
    box-shadow:var(--shadow);
    border-radius:14px;
    padding:8px;
    list-style:none;
    margin:0;
    opacity:0;
    transform:translateY(-6px);
    pointer-events:none;
    transition:opacity .18s ease, transform .18s ease;
  }
  .submenu li a{
    display:flex;
    padding:10px 12px;
    border-radius:12px;
    color:var(--ink);
    font-weight:650;
    font-size:14px;
    transition:background .18s ease, opacity .18s ease;
  }
  .submenu li a:hover{background:rgba(12,21,32,.06); opacity:.9;}

  .nav__item.has-submenu:hover .submenu,
  .nav__item.has-submenu:focus-within .submenu{
    opacity:1;
    transform:translateY(0);
    pointer-events:auto;
  }

  .header-actions{display:flex; align-items:center; gap:10px; justify-content:flex-end;}

  .header-icons{
    display:flex;
    align-items:center;
    gap:18px;
    margin-right:20px;
  }

  .icon-btn{
    position:relative;
    width:36px;
    height:36px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:50%;
    cursor:pointer;
  }

  .icon-btn svg{stroke:#0c1520;}

  .cart-badge{
    position:absolute;
    top:-6px;
    right:-6px;
    background:#e53935;
    color:#fff;
    font-size:12px;
    font-weight:700;
    width:20px;
    height:20px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:50%;
  }

  .flag-icon img{
    width:28px;
    height:28px;
    border-radius:50%;
    object-fit:cover;
  }

  .header-cta{
    height:52px;
    padding:0 28px;
    border-radius:40px;
    font-size:16px;
    font-weight:700;
    background:linear-gradient(135deg,#6b5bd2,#7a6be6);
    box-shadow:none;
  }

  .header-cta:hover{transform:none; opacity:.95;}

  /* ===== Mobile responsiveness (UPDATED) ===== */
  @media (max-width:980px){
    .header-icons{display:none;}

    /* tighter header spacing */
    .header-inner{padding:12px 12px; gap:10px;}
    .brand{min-width:auto;}
    .brand__logo img{height:38px;}

    /* keep CTA but make it compact */
    .header-cta{height:44px; padding:0 18px; font-size:14px; border-radius:999px;}

    /* hamburger always visible on mobile */
    .nav{display:none;}

    /* topbar align center on mobile */
    .topbar__inner{flex-direction:row; align-items:center; justify-content:center;}
  }

  @media (max-width:520px){
    /* hide CTA in header on very small screens to prevent overflow */
    .header-cta{display:none;}

    .header-inner{padding:10px 10px;}
    .brand__logo img{height:36px;}

    /* keep hamburger compact */
    .hamburger{width:42px; height:42px; border-radius:14px;}
  }

  .btn{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    height:42px;
    padding:0 16px;
    border-radius:15px;
    border:1px solid transparent;
    font-weight:700;
    font-size:14px;
    transition:transform .15s ease, box-shadow .15s ease, background .2s ease, color .2s ease, border-color .2s ease;
    will-change:transform;
  }
  .btn--primary{background:linear-gradient(135deg, var(--primary), var(--primary2)); color:#fff; box-shadow:0 10px 18px rgba(15,76,129,.18);}
  .btn--primary:hover{transform:translateY(-1px); box-shadow:0 14px 26px rgba(15,76,129,.22);}
  .btn--ghost{background:rgba(15,76,129,.07); color:var(--ink); border-color:rgba(15,76,129,.14);}
  .btn--ghost:hover{background:rgba(15,76,129,.11);}

  .hamburger{
    display:inline-flex;
    width:44px;
    height:44px;
    border-radius:14px;
    border:1px solid var(--line);
    background:rgba(255,255,255,.7);
    align-items:center;
    justify-content:center;
    cursor:pointer;
  }

  /* Hide hamburger on desktop (desktop uses the full nav) */
  @media (min-width:981px){
    .hamburger{display:none;}
  }
  .hamburger__bars{
    width:20px;
    height:14px;
    position:relative;
    display:block;
  }
  .hamburger__bars::before,
  .hamburger__bars::after{
    content:"";
    position:absolute;
    left:0;
    width:20px;
    height:2px;
    background:var(--ink);
    border-radius:2px;
  }
  .hamburger__bars::before{top:0;}
  .hamburger__bars::after{bottom:0;}
  .hamburger__bar{
    position:absolute;
    left:0;
    right:0;
    top:50%;
    transform:translateY(-50%);
    height:2px;
    background:var(--ink);
    border-radius:2px;
    display:block;
  }

  /* Drawer */
  .drawer{position:fixed; inset:0; z-index:2000; display:none;}
  .drawer.is-open{display:block;}
  .drawer__backdrop{position:absolute; inset:0; background:rgba(0,0,0,.35);}
  .drawer__panel{
    position:absolute;
    left:0;
    top:0;
    height:100%;
    width:min(420px, 92vw);
    background:var(--bg);
    border-left:0;
    border-right:1px solid var(--line);
    box-shadow:var(--shadow);
    transform:translateX(-100%);
    transition:transform .22s ease;
    display:flex;
    flex-direction:column;
  }
  .drawer.is-open .drawer__panel{transform:translateX(0);}
  .drawer.is-open .drawer__backdrop{backdrop-filter: blur(2px);}
  .drawer__top{display:flex; align-items:center; justify-content:space-between; padding:14px 16px; border-bottom:1px solid var(--line);}
  .drawer__brand img{height:38px; width:auto; display:block; object-fit:contain;}
  .drawer__close{width:42px; height:42px; border-radius:14px; border:1px solid var(--line); background:rgba(15,76,129,.06); cursor:pointer; font-size:18px;}

  .mnav{padding:10px 16px 18px; overflow:auto;}

  /* UPDATED: uppercase links in mobile drawer */
  .mnav__link{
    display:block;
    padding:12px 12px;
    border-radius:14px;
    font-weight:800;
    color:var(--ink);
    text-transform:uppercase;
    letter-spacing:1.1px;
  }
  .mnav__link:hover{background:rgba(15,76,129,.08); color:var(--primary);}

  .mnav__toggle{
    width:100%;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:12px 12px;
    border-radius:14px;
    border:1px solid rgba(11,27,42,.08);
    background:var(--surface);
    font-weight:800;
    color:var(--ink);
    cursor:pointer;
    margin-top:10px;
  }
  .mnav__submenu{padding:8px 8px 0 8px;}
  .mnav__submenu a{display:block; padding:10px 12px; border-radius:12px; color:var(--muted); font-weight:700;}
  .mnav__submenu a:hover{background:rgba(27,120,200,.10); color:var(--primary2);}

  /* UPDATED: premium CTA area */
  .mnav__cta{
    display:grid;
    gap:12px;
    margin-top:18px;
    padding-top:14px;
    border-top:1px solid var(--line);
  }
</style>

<script>
  (function(){
    const header = document.getElementById('siteHeader');
    const drawer = document.getElementById('mobileNav');
    const burger = document.querySelector('.hamburger');
    const closeEls = drawer ? drawer.querySelectorAll('[data-drawer-close]') : [];

    // Sticky shadow on scroll
    const onScroll = () => {
      if(!header) return;
      header.classList.toggle('is-scrolled', window.scrollY > 6);
    };
    window.addEventListener('scroll', onScroll, {passive:true});
    onScroll();

    // Desktop submenu aria-expanded helper
    document.querySelectorAll('.nav__item.has-submenu').forEach((li) => {
      const a = li.querySelector(':scope > a');
      if(!a) return;
      li.addEventListener('mouseenter', () => a.setAttribute('aria-expanded','true'));
      li.addEventListener('mouseleave', () => a.setAttribute('aria-expanded','false'));
      li.addEventListener('focusin', () => a.setAttribute('aria-expanded','true'));
      li.addEventListener('focusout', (e) => {
        if(!li.contains(e.relatedTarget)) a.setAttribute('aria-expanded','false');
      });
    });

    // Drawer open/close
    const setDrawer = (open) => {
      if(!drawer || !burger) return;
      drawer.classList.toggle('is-open', open);
      drawer.setAttribute('aria-hidden', open ? 'false' : 'true');
      burger.setAttribute('aria-expanded', open ? 'true' : 'false');
      document.documentElement.style.overflow = open ? 'hidden' : '';
    };

    if(burger){
      burger.addEventListener('click', () => {
        const isOpen = drawer.classList.contains('is-open');
        setDrawer(!isOpen);
      });
    }

    closeEls.forEach(el => el.addEventListener('click', () => setDrawer(false)));

    // Close on ESC
    document.addEventListener('keydown', (e) => {
      if(e.key === 'Escape' && drawer && drawer.classList.contains('is-open')) setDrawer(false);
    });

    // Mobile submenu toggles
    document.querySelectorAll('.mnav__toggle').forEach(btn => {
      btn.addEventListener('click', () => {
        const id = btn.getAttribute('aria-controls');
        const panel = id ? document.getElementById(id) : null;
        const expanded = btn.getAttribute('aria-expanded') === 'true';
        btn.setAttribute('aria-expanded', expanded ? 'false' : 'true');
        if(panel) panel.hidden = expanded;
      });
    });

    // Topbar rotator
    const msgs = Array.from(document.querySelectorAll('.topbar__msg'));
    const dots = Array.from(document.querySelectorAll('.topbar__dots .dot'));
    let idx = 0;

    const showMsg = (i) => {
      msgs.forEach((m, k) => m.classList.toggle('is-active', k === i));
      dots.forEach((d, k) => d.classList.toggle('is-active', k === i));
    };

    if (msgs.length > 1) {
      showMsg(0);
      setInterval(() => {
        idx = (idx + 1) % msgs.length;
        showMsg(idx);
      }, 3200);
    }
  })();
</script>