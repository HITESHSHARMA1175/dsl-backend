

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
  /* --- Scope all styles to this page only --- */
  .page, .page * { box-sizing: border-box; }

  :root{
      --bg:#05070a;
      --text:#ffffff;
      --muted:#a0aab2;
      --border:rgba(212, 175, 55, 0.15);
      --card:rgba(11, 27, 42, .45);
      --purple:#D4AF37;
      --pill:rgba(255, 255, 255, 0.1);
      --shadow:0 24px 50px rgba(212, 175, 55, 0.1);
      --radius:16px;
  }

  body {
    background: #05070a !important;
    font-family: 'Outfit', sans-serif !important;
    color: #fff !important;
    margin: 0 !important;
  }

  /* Page Layout */
  .page__title {
    font-family: 'Canela', serif;
    font-size: clamp(36px, 5vw, 64px);
    color: #D4AF37;
    text-align: center;
    margin: 60px 24px 40px;
  }

  .loc {
    display: flex;
    max-width: 1400px;
    margin: 0 auto 100px;
    height: 75vh;
    min-height: 600px;
    background: var(--card);
    backdrop-filter: blur(16px);
    border: 1px solid var(--border);
    border-radius: 24px;
    overflow: hidden;
    box-shadow: var(--shadow);
  }

  /* Left Panel */
  .loc__panel {
    width: 450px;
    background: rgba(11, 27, 42, 0.6);
    border-right: 1px solid var(--border);
    display: flex;
    flex-direction: column;
  }
  .loc__panelInner {
    display: flex;
    flex-direction: column;
    height: 100%;
  }

  /* Search & Filters */
  .searchRow {
    display: flex;
    gap: 12px;
    padding: 24px;
    border-bottom: 1px solid var(--border);
  }
  .search {
    flex: 1;
    padding: 16px;
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    background: rgba(0, 0, 0, 0.3);
    color: #fff;
    font-family: 'Outfit', sans-serif;
    font-size: 16px;
    transition: all 0.2s;
  }
  .search:focus {
    outline: none;
    border-color: #D4AF37;
    background: rgba(0, 0, 0, 0.5);
  }
  .filterBtn {
    width: 54px;
    height: 54px;
    border-radius: 12px;
    background: rgba(212, 175, 55, 0.1);
    border: 1px solid rgba(212, 175, 55, 0.3);
    color: #D4AF37;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
  }
  .filterBtn:hover {
    background: #D4AF37;
    color: #000;
  }

  /* List Items */
  .list {
    flex: 1;
    overflow-y: auto;
    padding: 16px;
  }
  /* Custom Scrollbar for list */
  .list::-webkit-scrollbar {
    width: 6px;
  }
  .list::-webkit-scrollbar-track {
    background: rgba(0,0,0,0.1);
  }
  .list::-webkit-scrollbar-thumb {
    background: rgba(212, 175, 55, 0.3);
    border-radius: 10px;
  }
  .locItem {
    padding: 20px;
    margin-bottom: 16px;
    border-radius: 16px;
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid transparent;
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    transition: all 0.2s;
  }
  .locItem:hover {
    background: rgba(255, 255, 255, 0.08);
  }
  .locItem.is-active {
    background: rgba(212, 175, 55, 0.1);
    border-color: rgba(212, 175, 55, 0.3);
  }
  .locItem > div {
    width: 100%;
  }
  .locItem a {
    text-decoration: none;
    color: inherit;
    display: block;
  }
  .locName {
    font-family: 'Canela', serif;
    font-size: 24px;
    color: #fff;
    margin: 0 0 8px;
  }
  .locAddr {
    font-size: 14px;
    color: #a0aab2;
    margin: 0 0 16px;
    line-height: 1.4;
  }
  .locMeta {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 12px;
    color: #fff;
    font-weight: 600;
  }
  .badgeOpen {
    background: rgba(40, 167, 69, 0.2);
    color: #28a745;
    border: 1px solid rgba(40, 167, 69, 0.3);
    padding: 4px 8px;
    border-radius: 4px;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 10px;
  }
  .chev {
    font-size: 32px;
    color: #D4AF37;
    padding-left: 16px;
    line-height: 1;
  }

  /* Map Container */
  .loc__map {
    flex: 1;
    height: 100%;
    position: relative;
  }
  .mapFrame {
    width: 100%;
    height: 100%;
    border: none;
    filter: invert(90%) hue-rotate(180deg); /* Simple dark mode trick for Google maps */
  }

  /* Modals */
  .modal {
    position: fixed;
    inset: 0;
    z-index: 9999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 24px;
  }
  .modal.is-open {
    display: flex;
  }
  .modal__backdrop {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.8);
    backdrop-filter: blur(4px);
  }
  .modal__panel {
    position: relative;
    width: 100%;
    max-width: 500px;
    background: #0b1b2a;
    border: 1px solid var(--border);
    border-radius: 24px;
    padding: 32px;
    z-index: 1;
    box-shadow: var(--shadow);
  }
  .modal__head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
  }
  .modal__title {
    font-family: 'Canela', serif;
    font-size: 32px;
    color: #D4AF37;
    margin: 0;
  }
  .modal__close {
    background: none;
    border: none;
    font-size: 36px;
    color: #fff;
    cursor: pointer;
    line-height: 1;
    transition: color 0.2s;
  }
  .modal__close:hover {
    color: #D4AF37;
  }
  .filterList {
    display: flex;
    flex-direction: column;
    gap: 12px;
  }
  .filterOpt {
    padding: 16px;
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid transparent;
    color: #fff;
    text-align: left;
    font-size: 16px;
    font-family: 'Outfit', sans-serif;
    cursor: pointer;
    transition: all 0.2s;
  }
  .filterOpt:hover {
    background: rgba(212, 175, 55, 0.1);
    border-color: rgba(212, 175, 55, 0.3);
    color: #D4AF37;
  }

  /* Responsive */
  @media (max-width: 900px) {
    .loc {
      flex-direction: column-reverse;
      height: auto;
      min-height: unset;
    }
    .loc__panel {
      width: 100%;
      border-right: none;
      border-top: 1px solid var(--border);
      height: 500px;
    }
    .loc__map {
      height: 400px;
      flex: none;
    }
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
console.log(filtered);
    listEl.innerHTML = filtered.map(l => `
      <div class="locItem ${l.id === activeId ? 'is-active' : ''}" data-id="${l.id}">
        <div>
        <a href="/locations/${l.id}" >
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