

<?php
/**
 * DSL Clinic - Locations (original page)
 * - Full-width header + topbar rotator
 * - Locations layout: search/list (left) + map (right)
 * - Filter button opens modal
 * - Vanilla JS filtering + map focus
 * - Footer: premium dark, 100% width
 */
 //print_r($clinics);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="Find a DSL Clinic location near you. Search locations, view details and get directions." />
  <title>Locations | DSL Clinic</title>

  <!-- Google Font (lightweight) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    :root{
      --bg:#ffffff;
      --ink:#0b1b2a;
      --muted:#566579;
      --line:rgba(11,27,42,.10);
      --surface:#f6f9fc;
      --shadow:0 12px 30px rgba(11,27,42,.10);
      --radius:16px;
      --primary:#0f4c81;
      --primary2:#1b78c8;
      --accent:#6b5bd2;
      --accent2:#7a6be6;
      --good:#1d9a49;
      --dark:#0b0b0c;
      --dark2:#121214;
      --darkLine:rgba(255,255,255,.12);
    }

    *{box-sizing:border-box}
    html,body{height:100%}
    body{
      margin:0;
      font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
      color:var(--ink);
      background:var(--bg);
    }
    a{color:inherit;text-decoration:none}
    button,input{font:inherit}
    img{max-width:100%;display:block}

    a:focus-visible, button:focus-visible, input:focus-visible{
      outline:3px solid rgba(27,120,200,.45);
      outline-offset:3px;
      border-radius:12px;
    }

    /* Skip link */
    .skip-link{
      position:absolute; left:-999px; top:10px;
      background:var(--ink); color:#fff; padding:10px 14px;
      border-radius:12px; z-index:9999;
    }
    .skip-link:focus{left:10px;}

    /* ===== Topbar (announcement rotator) ===== */
    .topbar{width:100%; background:#0f1012; color:#fff;}
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
      max-width:980px;
      overflow:hidden;
    }
    .topbar__msg{
      position:absolute;
      left:0; right:0;
      margin:0 auto;
      text-align:center;
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
      color:rgba(255,255,255,.92);
    }
    .topbar__msg:hover{color:#fff;}
    .topbar__msg.is-active{opacity:1; transform:translateY(0)}
    .topbar__u{
      text-decoration:underline;
      text-underline-offset:3px;
      text-decoration-thickness:2px;
      text-decoration-color:rgba(255,255,255,.55);
    }
    .topbar__dots{display:flex; gap:6px; align-items:center;}
    .topbar__dots .dot{width:6px;height:6px;border-radius:999px;background:rgba(255,255,255,.22)}
    .topbar__dots .dot.is-active{background:rgba(255,255,255,.60)}

    @media (max-width:640px){
      .topbar__inner{padding:10px 12px}
      .topbar__dots{display:none}
      .topbar__msg{font-size:13px}
    }

    /* ===== Header (same style as your header component) ===== */
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
    .brand__logo img{height:44px; width:auto; object-fit:contain;}

    .nav{display:flex; align-items:center; flex:1; justify-content:center;}
    .nav__list{list-style:none; padding:0; margin:0; display:flex; align-items:center; gap:6px;}
    .nav__item{position:relative;}
    .nav__link{
      display:inline-flex;
      align-items:center;
      gap:8px;
      padding:10px 14px;
      border-radius:999px;
      color:#0c1520;
      font-weight:700;
      font-size:13px;
      letter-spacing:1.2px;
      text-transform:uppercase;
      transition:opacity .2s ease, text-decoration-color .2s ease;
      text-decoration:underline;
      text-decoration-thickness:2px;
      text-underline-offset:8px;
      text-decoration-color:transparent;
    }
    .nav__link:hover{opacity:.85; text-decoration-color:rgba(12,21,32,.35)}

    .has-submenu > .nav__link::after{content:"▾"; font-size:11px; opacity:.65; transform:translateY(1px); margin-left:2px;}

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
    .nav__item.has-submenu:focus-within .submenu{opacity:1; transform:translateY(0); pointer-events:auto;}

    .header-actions{display:flex; align-items:center; gap:10px; justify-content:flex-end;}

    .header-icons{display:flex; align-items:center; gap:18px; margin-right:20px;}
    .icon-btn{position:relative; width:36px; height:36px; display:flex; align-items:center; justify-content:center; border-radius:50%; cursor:pointer;}
    .icon-btn svg{stroke:#0c1520}
    .cart-badge{position:absolute; top:-6px; right:-6px; background:#e53935; color:#fff; font-size:12px; font-weight:700; width:20px; height:20px; display:flex; align-items:center; justify-content:center; border-radius:50%;}
    .flag-icon img{width:28px; height:28px; border-radius:50%; object-fit:cover;}

    .btn{
      display:inline-flex;
      align-items:center;
      justify-content:center;
      height:42px;
      padding:0 16px;
      border-radius:999px;
      border:1px solid transparent;
      font-weight:700;
      font-size:14px;
      transition:transform .15s ease, box-shadow .15s ease, background .2s ease, opacity .2s ease;
      will-change:transform;
    }
    .btn--primary{background:linear-gradient(135deg, var(--accent), var(--accent2)); color:#fff; box-shadow:none;}
    .btn--primary:hover{opacity:.95}

    .header-cta{height:52px; padding:0 28px; border-radius:40px; font-size:16px; font-weight:700;}

    /* Hamburger */
    .hamburger{
      display:none;
      width:44px;
      height:44px;
      border-radius:14px;
      border:1px solid var(--line);
      background:rgba(255,255,255,.7);
      align-items:center;
      justify-content:center;
      cursor:pointer;
    }
    .hamburger__bars{width:18px; height:12px; position:relative; display:block;}
    .hamburger__bars::before,
    .hamburger__bars::after{content:""; position:absolute; left:0; width:18px; height:2px; background:var(--ink); border-radius:2px;}
    .hamburger__bars::before{top:1px;}
    .hamburger__bars::after{top:9px;}

    /* Drawer */
    .drawer{position:fixed; inset:0; z-index:2000; display:none;}
    .drawer.is-open{display:block;}
    .drawer__backdrop{position:absolute; inset:0; background:rgba(0,0,0,.35);}
    .drawer__panel{
      position:absolute;
      right:0;
      top:0;
      height:100%;
      width:min(420px, 92vw);
      background:var(--bg);
      border-left:1px solid var(--line);
      box-shadow:var(--shadow);
      transform:translateX(100%);
      transition:transform .22s ease;
      display:flex;
      flex-direction:column;
    }
    .drawer.is-open .drawer__panel{transform:translateX(0);}
    .drawer__top{display:flex; align-items:center; justify-content:space-between; padding:14px 16px; border-bottom:1px solid var(--line);}
    .drawer__brand img{height:38px; width:auto; object-fit:contain;}
    .drawer__close{width:42px; height:42px; border-radius:14px; border:1px solid var(--line); background:rgba(15,76,129,.06); cursor:pointer; font-size:18px;}

    .mnav{padding:10px 16px 18px; overflow:auto;}
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
      text-transform:uppercase;
      letter-spacing:1.1px;
    }
    .mnav__submenu{padding:8px 8px 0 8px;}
    .mnav__submenu a{display:block; padding:10px 12px; border-radius:12px; color:var(--muted); font-weight:700;}
    .mnav__submenu a:hover{background:rgba(27,120,200,.10); color:var(--primary2);}

    .mnav__cta{display:grid; gap:12px; margin-top:18px; padding-top:14px; border-top:1px solid var(--line);}

    @media (max-width:980px){
      .header-icons{display:none;}
      .nav{display:none;}
      .hamburger{display:inline-flex;}
      .header-inner{padding:12px 12px; gap:10px;}
      .brand{min-width:auto;}
      .brand__logo img{height:38px;}
      .header-cta{height:44px; padding:0 18px; font-size:14px; border-radius:999px;}
    }
    @media (max-width:520px){
      .header-cta{display:none;}
      .brand__logo img{height:36px;}
    }

    /* ===== Page shell ===== */
    main{width:100%;}
    .page{width:100%; padding:34px 0 18px;}
    .page__inner{width:100%; max-width:100%; padding:0 20px;}

    .page__title{
      font-family: ui-serif, Georgia, "Times New Roman", Times, serif;
      font-weight:500;
      letter-spacing:-.02em;
      font-size:56px;
      line-height:1.05;
      margin:10px 0 18px;
    }

    /* ===== Locations layout ===== */
    .loc{
      display:grid;
      grid-template-columns: 520px 1fr;
      gap:0;
      border-top:1px solid rgba(11,27,42,.08);
    }

    .loc__panel{
      background:#fff;
      border-right:1px solid rgba(11,27,42,.08);
      min-height: calc(100vh - 190px);
    }

    .loc__panelInner{padding:18px 0 0;}

    .searchRow{
      display:grid;
      grid-template-columns: 1fr 44px;
      gap:12px;
      padding:0 20px 14px;
      align-items:center;
    }

    .search{
      height:46px;
      border-radius:10px;
      border:1px solid rgba(11,27,42,.18);
      padding:0 14px;
      font-size:15px;
      outline:none;
      background:#fff;
    }

    .filterBtn{
      width:44px;
      height:44px;
      border-radius:999px;
      border:1px solid rgba(11,27,42,.12);
      background:#fff;
      display:flex;
      align-items:center;
      justify-content:center;
      cursor:pointer;
      box-shadow:0 6px 18px rgba(11,27,42,.08);
    }

    .list{border-top:1px solid rgba(11,27,42,.08);}

    .locItem{
      padding:18px 20px;
      border-bottom:1px solid rgba(11,27,42,.08);
      display:grid;
      grid-template-columns: 1fr 18px;
      gap:10px;
      cursor:pointer;
      transition:background .15s ease;
    }
    .locItem:hover{background:rgba(15,76,129,.04);}
    .locItem.is-active{background:rgba(107,91,210,.10);}

    .locName{font-weight:800; font-size:18px; margin:0 0 6px;}
    .locAddr{margin:0; color:var(--muted); font-weight:500; line-height:1.45;}

    .locMeta{margin-top:10px; display:flex; gap:8px; align-items:center; flex-wrap:wrap; color:var(--muted); font-weight:600;}
    .badgeOpen{color:var(--good); font-weight:800;}

    .chev{display:flex; align-items:center; justify-content:center; color:rgba(11,27,42,.55);}

    .loc__map{
      min-height: calc(100vh - 190px);
      background:#f0f2f5;
      position:relative;
    }

    .mapFrame{
      position:absolute;
      inset:0;
      width:100%;
      height:100%;
      border:0;
    }

    /* Mobile */
    @media (max-width: 980px){
      .page__title{font-size:44px;}
      .loc{grid-template-columns:1fr;}
      .loc__panel{border-right:none; min-height:auto;}
      .loc__map{height:360px; min-height:360px;}
    }
    @media (max-width: 520px){
      .page__inner{padding:0 12px;}
      .page__title{font-size:38px;}
      .searchRow{padding:0 12px 14px;}
      .locItem{padding:16px 12px;}
    }

    /* ===== Modal (Filter locations) ===== */
    .modal{position:fixed; inset:0; display:none; z-index:3000;}
    .modal.is-open{display:block;}
    .modal__backdrop{position:absolute; inset:0; background:rgba(0,0,0,.55);}
    .modal__panel{
      position:relative;
      width:min(520px, 92vw);
      margin:0 auto;
      top:50%;
      transform:translateY(-50%);
      background:#fff;
      border-radius:14px;
      box-shadow:0 20px 60px rgba(0,0,0,.25);
      padding:18px;
    }
    .modal__head{display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:12px;}
    .modal__title{font-size:20px; font-weight:800; margin:0;}
    .modal__close{
      width:40px; height:40px;
      border-radius:999px;
      border:1px solid rgba(11,27,42,.14);
      background:#fff;
      cursor:pointer;
      font-size:18px;
      display:flex; align-items:center; justify-content:center;
    }
    .filterList{display:grid; gap:10px; padding:6px 0 0;}
    .filterOpt{
      width:100%;
      text-align:left;
      padding:14px 14px;
      border-radius:10px;
      border:1px solid rgba(11,27,42,.16);
      background:#fff;
      font-weight:700;
      cursor:pointer;
    }
    .filterOpt:hover{background:rgba(15,76,129,.05);}

    /* ===== Footer (premium dark, 100% width) ===== */
    .site-footer{width:100%; background:linear-gradient(180deg, #0b0b0c, #0a0a0b); color:rgba(255,255,255,.88);}
    .footer__inner{width:100%; max-width:100%; padding:46px 22px 22px;}

    .footerTop{
      display:grid;
      grid-template-columns: 1.1fr 1fr 1fr 1.2fr;
      gap:36px;
      align-items:start;
    }

    .fTitle{font-weight:800; font-size:18px; margin:0 0 14px; color:#fff;}
    .fList{list-style:none; padding:0; margin:0; display:grid; gap:10px;}
    .fList a{color:rgba(255,255,255,.72); font-weight:600;}
    .fList a:hover{color:#fff;}

    .appBox{display:grid; gap:14px;}
    .appBadges{display:flex; gap:12px; flex-wrap:wrap;}
    .badge{
      display:inline-flex;
      align-items:center;
      gap:10px;
      padding:12px 14px;
      border-radius:10px;
      border:1px solid var(--darkLine);
      background:rgba(255,255,255,.04);
      min-width:180px;
    }
    .badge small{display:block; font-size:11px; color:rgba(255,255,255,.65); font-weight:700;}
    .badge strong{display:block; font-size:14px; color:#fff; font-weight:800;}

    .pay{margin-top:18px;}
    .payRow{display:flex; gap:10px; flex-wrap:wrap;}
    .payIcon{
      width:54px; height:34px;
      border-radius:8px;
      background:#fff;
      display:flex; align-items:center; justify-content:center;
      color:#111;
      font-weight:900;
      font-size:12px;
    }

    .footerMid{
      margin-top:34px;
      padding-top:18px;
      border-top:1px solid var(--darkLine);
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:14px;
      flex-wrap:wrap;
    }

    .region{
      display:flex;
      align-items:center;
      gap:12px;
      color:rgba(255,255,255,.78);
      font-weight:700;
    }
    .region img{width:26px; height:26px; border-radius:50%;}

    .social{display:flex; gap:16px; align-items:center;}
    .social a{
      width:40px; height:40px;
      border-radius:999px;
      border:1px solid var(--darkLine);
      background:rgba(255,255,255,.04);
      display:flex; align-items:center; justify-content:center;
      color:#fff;
      transition:transform .15s ease, background .15s ease;
    }
    .social a:hover{transform:translateY(-1px); background:rgba(255,255,255,.08);}

    .copyright{margin:14px 0 0; color:rgba(255,255,255,.55); font-weight:600;}

    .footerBrand{display:flex; align-items:center; gap:12px; margin-bottom:12px;}
    .footerBrand img{height:38px; width:auto; object-fit:contain; filter:brightness(1.05) contrast(1.05);}

    @media (max-width: 980px){
      .footerTop{grid-template-columns:1fr 1fr;}
    }
    @media (max-width: 620px){
      .footerTop{grid-template-columns:1fr;}
      .footer__inner{padding:38px 14px 18px;}
      .footerMid{justify-content:flex-start;}
    }

  </style>
</head>
<body>

  <a class="skip-link" href="#main">Skip to content</a>

  <!-- Top announcement bar -->
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

  <!-- Header include -->
    @include('frontend.partials.header')
    
  <!-- Main -->
  <main id="main">
    <section class="page" aria-label="Locations">
      <div class="page__inner">
        <h1 class="page__title">Our Locations</h1>
      </div>

      <div class="loc" role="region" aria-label="Locations finder">

        <!-- Left panel -->
        <aside class="loc__panel" aria-label="Locations list">
          <div class="loc__panelInner">

            <div class="searchRow">
              <input id="locSearch" class="search" type="search" placeholder="Search locations" aria-label="Search locations" autocomplete="off" />

              <button class="filterBtn" type="button" id="openFilters" aria-label="Filter locations" title="Filter locations">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                  <path d="M4 6h16"/>
                  <path d="M7 12h10"/>
                  <path d="M10 18h4"/>
                </svg>
              </button>
            </div>

            <div class="list" id="locList" aria-live="polite"></div>

          </div>
        </aside>

        <!-- Map -->
        <section class="loc__map" aria-label="Map">
          <iframe
            id="mapFrame"
            class="mapFrame"
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            title="Map"
            src="https://www.google.com/maps?q=United%20Kingdom&output=embed">
          </iframe>
        </section>

      </div>
    </section>
  </main>

  <!-- Filter modal -->
  <div class="modal" id="filtersModal" aria-hidden="true">
    <div class="modal__backdrop" data-modal-close></div>
    <div class="modal__panel" role="dialog" aria-modal="true" aria-label="Filter locations">
      <div class="modal__head">
        <h2 class="modal__title">Filter locations</h2>
        <button class="modal__close" type="button" aria-label="Close" data-modal-close>×</button>
      </div>

      <div class="filterList">
        <button class="filterOpt" type="button" data-filter="near">Show all locations near me</button>
        <button class="filterOpt" type="button" data-filter="IE">Show all locations in Ireland</button>
        <button class="filterOpt" type="button" data-filter="UK">Show all locations in UK</button>
        <button class="filterOpt" type="button" data-filter="USA">Show all locations in USA</button>
      </div>
    </div>
  </div>

  <!-- Footer include -->
    @include('frontend.partials.footer')
    
    
<script>
const LOCS = @json($locs);
</script>

<script>
(function(){

  const header = document.getElementById('siteHeader');
  const drawer = document.getElementById('mobileNav');
  const burger = document.querySelector('.hamburger');
  const closeEls = drawer ? drawer.querySelectorAll('[data-drawer-close]') : [];

  // Sticky shadow
  const onScroll = () => header && header.classList.toggle('is-scrolled', window.scrollY > 6);
  window.addEventListener('scroll', onScroll, {passive:true});
  onScroll();

  // Desktop submenu
  document.querySelectorAll('.nav__item.has-submenu').forEach((li) => {
    const a = li.querySelector(':scope > a');
    if(!a) return;
    li.addEventListener('mouseenter', () => a.setAttribute('aria-expanded','true'));
    li.addEventListener('mouseleave', () => a.setAttribute('aria-expanded','false'));
  });

  // Drawer
  const setDrawer = (open) => {
    if(!drawer || !burger) return;
    drawer.classList.toggle('is-open', open);
    document.documentElement.style.overflow = open ? 'hidden' : '';
  };

  burger?.addEventListener('click', () => setDrawer(!drawer.classList.contains('is-open')));
  closeEls.forEach(el => el.addEventListener('click', () => setDrawer(false)));

  // Topbar rotator
  const msgs = Array.from(document.querySelectorAll('.topbar__msg'));
  let idx = 0;
  if (msgs.length > 1) {
    setInterval(() => {
      msgs.forEach((m,i)=>m.classList.toggle('is-active', i === idx));
      idx = (idx + 1) % msgs.length;
    }, 3200);
  }

  // ============================
  // ✅ Dynamic Locations
  // ============================

  const listEl = document.getElementById('locList');
  const searchEl = document.getElementById('locSearch');
  const mapEl = document.getElementById('mapFrame');

  if(!listEl || !mapEl) return; // safety

  let activeId = LOCS.length ? LOCS[0].id : null;
  let activeCountryFilter = null;

  const mapTo = (q) => {
    mapEl.src = `https://www.google.com/maps?q=${encodeURIComponent(q)}&output=embed`;
  };

  const render = () => {
    const term = (searchEl?.value || '').toLowerCase();

    const filtered = LOCS.filter(l => {
      const matchSearch = !term || (l.name + ' ' + l.address).toLowerCase().includes(term);
      const matchCountry = !activeCountryFilter || l.country === activeCountryFilter;
      return matchSearch && matchCountry;
    });

    if(filtered.length && !filtered.find(x => x.id === activeId)){
      activeId = filtered[0].id;
    }

    listEl.innerHTML = filtered.map(l => `
      <div class="locItem ${l.id === activeId ? 'is-active' : ''}" data-id="${l.id}">
        <div>
        <a href="/locations/${l.slug}" >
          <p class="locName">${l.name}</p>
          <p class="locAddr">${l.address}</p>
          <div class="locMeta">
            <span class="badgeOpen">${l.status}</span>
            <span>•</span>
            <span>${l.closes}</span>
          </div>
          </a>
        </div>
        <div class="chev">›</div>
      </div>
    `).join('');

    const active = filtered.find(x => x.id === activeId);
    if(active) mapTo(active.q);
  };

  const setActive = (id) => {
    activeId = id;
    render();
  };

  // Click
  listEl.addEventListener('click', (e) => {
    const item = e.target.closest('.locItem');
    if(item){
      setActive(item.dataset.id);
    }
  });

  // Search
  searchEl?.addEventListener('input', render);

  // Filter modal
  const modal = document.getElementById('filtersModal');
  const openBtn = document.getElementById('openFilters');

  openBtn?.addEventListener('click', () => modal.classList.add('is-open'));

  modal?.addEventListener('click', (e) => {

    if(e.target.hasAttribute('data-modal-close')){
      modal.classList.remove('is-open');
    }

    const btn = e.target.closest('[data-filter]');
    if(!btn) return;

    const f = btn.getAttribute('data-filter');

    if(f === 'near'){
      navigator.geolocation?.getCurrentPosition(pos => {
        mapTo(`${pos.coords.latitude},${pos.coords.longitude}`);
        modal.classList.remove('is-open');
      });
      return;
    }

    activeCountryFilter = f;
    modal.classList.remove('is-open');
    render();
  });

  // INIT
  render();

})();
</script>
</body>
</html>