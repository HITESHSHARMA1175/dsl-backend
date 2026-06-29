<?php
// Simple, fast, dependency-free reviews carousel (auto slider + animation)
// Edit/add reviews here.


$reviews = $reviews->toArray();

function render_stars($count)
{
  $count = max(0, min(5, (int)$count));
  $out = '';
  for ($i = 0; $i < 5; $i++) {
    $out .= '<span class="star" aria-hidden="true">' . ($i < $count ? '★' : '☆') . '</span>';
  }
  return $out;
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Reviews</title>

<style>
  /* --- Scope all styles to this page only --- */
  .reviews-section, .reviews-section * { box-sizing: border-box; }

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

  /* Section Layout */
  .reviews-section {
    width: 100%;
    padding: 100px 0 140px;
    background: var(--bg);
    overflow: hidden;
  }
  .reviews-wrap {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 24px;
    text-align: center;
  }
  .reviews-topline {
    font-size: 14px;
    font-weight: 600;
    letter-spacing: 0.15em;
    color: var(--purple);
    margin-bottom: 16px;
    text-transform: uppercase;
  }
  .reviews-title {
    font-family: 'Canela', serif;
    font-size: clamp(36px, 5vw, 64px);
    color: #fff;
    margin: 0 0 64px;
    line-height: 1.1;
  }

  /* Carousel */
  .carousel {
    position: relative;
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
  }
  .carousel-viewport {
    overflow: hidden;
    width: 100%;
    padding: 20px 0; /* space for box shadows */
  }
  .carousel-track {
    display: flex;
    gap: 24px;
    /* Will be translated by JS */
  }

  /* Nav Buttons */
  .nav-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: var(--card);
    border: 1px solid var(--border);
    backdrop-filter: blur(8px);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 10;
    transition: all 0.2s ease;
    box-shadow: 0 8px 24px rgba(0,0,0,0.5);
  }
  .nav-btn:hover {
    background: var(--purple);
    color: #000;
    border-color: var(--purple);
  }
  .nav-btn svg {
    width: 24px;
    height: 24px;
  }
  .nav-btn.prev { left: -28px; }
  .nav-btn.next { right: -28px; }

  /* Review Cards */
  .review-card {
    flex: 0 0 calc(33.333% - 16px); /* 3 cards on desktop */
    min-width: 320px;
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 24px;
    padding: 32px;
    backdrop-filter: blur(16px);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: auto;
    align-self: stretch;
    min-height: 400px;
    box-shadow: var(--shadow);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    text-align: left;
  }
  .review-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 32px 64px rgba(212, 175, 55, 0.15);
  }

  .card-head {
    display: flex;
    margin-bottom: 24px;
  }
  .name {
    font-size: 22px;
    font-family: 'Canela', serif;
    font-weight: 600;
    margin-bottom: 8px;
    color: #fff;
  }
  .stars {
    color: var(--purple);
    font-size: 18px;
    margin-bottom: 8px;
    display: flex;
    gap: 4px;
  }
  .meta {
    font-size: 14px;
    color: var(--muted);
    display: flex;
    gap: 8px;
  }
  .meta span:last-child {
    opacity: 0.7;
  }

  .text {
    font-size: 16px;
    line-height: 1.6;
    color: var(--muted);
    font-style: italic;
    flex-grow: 1;
    margin-bottom: 32px;
  }
  .text::before {
    content: "“";
    font-family: 'Canela', serif;
    font-size: 48px;
    color: var(--border);
    line-height: 0;
    position: relative;
    top: 16px;
    left: -8px;
  }

  .brand-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid var(--border);
    padding-top: 16px;
    font-size: 14px;
  }
  .brand-row span:first-child {
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .brand-row span:first-child::before {
    content: "";
    display: inline-block;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #4285F4; /* Google Blue */
  }
  .brand-sub {
    color: var(--muted);
  }

  /* Dots */
  .dots {
    display: flex;
    justify-content: center;
    gap: 12px;
    margin-top: 48px;
  }
  .dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    border: none;
    cursor: pointer;
    padding: 0;
    transition: all 0.3s ease;
  }
  .dot:hover {
    background: rgba(255, 255, 255, 0.5);
  }
  .dot.is-active {
    background: var(--purple);
    transform: scale(1.2);
  }

  /* Responsive */
  @media (max-width: 1024px) {
    .review-card {
      flex: 0 0 calc(50% - 12px); /* 2 cards */
    }
  }
  @media (max-width: 768px) {
    .nav-btn { display: none; } /* hide arrows on mobile */
    .review-card {
      flex: 0 0 85%; /* 1 card, peek at next */
    }
  }
</style>

</head>

<body>
@include('frontend.partials.header')
  <!-- Reviews Section (Full Width) -->
  <section class="reviews-section" aria-label="Reviews">
    <div class="reviews-wrap">
      <div class="reviews-topline">YOU MAKE US LOOK GOOD</div>
      <h2 class="reviews-title">What Our Clients Say</h2>

      <div class="carousel" id="reviewsCarousel">
        <button class="nav-btn prev" type="button" aria-label="Previous reviews">
          <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </button>
        <button class="nav-btn next" type="button" aria-label="Next reviews">
          <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </button>

        <div class="carousel-viewport">
          <div class="carousel-track" id="reviewsTrack">
            <?php foreach ($reviews as $r): ?>
              <article class="review-card" role="group" aria-label="Review by <?php echo htmlspecialchars($r['name']); ?>">
                <div>
                  <div class="card-head">
                    <div>
                      <div class="name"><?php echo htmlspecialchars($r['name']); ?></div>
                      <div class="stars" aria-label="<?php echo (int)$r['stars']; ?> out of 5 stars">
                        <?php echo render_stars($r['stars']); ?>
                      </div>
                      <div class="meta">
                        <!-- <span><?php echo htmlspecialchars($r['location']); ?></span> -->
                        <span>DSL Clinic</span>
                        <span><?php echo htmlspecialchars($r['date']); ?></span>
                      </div>
                    </div>
                  </div>

                  <div class="text"><?php echo htmlspecialchars($r['text']); ?></div>
                </div>

                <div class="brand-row" aria-label="Source">
                  <span style="font-weight:800; letter-spacing:-.02em;">Google</span>
                  <span class="brand-sub">Official Review</span>
                </div>
              </article>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="dots" id="reviewsDots" aria-label="Carousel pagination"></div>
      </div>
    </div>
  </section>

  <script>
    (function () {
      const root = document.getElementById('reviewsCarousel');
      const track = document.getElementById('reviewsTrack');
      const dotsWrap = document.getElementById('reviewsDots');
      const btnPrev = root.querySelector('.nav-btn.prev');
      const btnNext = root.querySelector('.nav-btn.next');

      if (!root || !track) return;

      // --- Settings (tune if needed) ---
      const AUTO_MS = 2800; // auto slide interval
      const TRANSITION_MS = 520;

      // Make an infinite loop by cloning the first N slides.
      const slides = Array.from(track.children);
      const total = slides.length;
      const cloneCount = Math.min(3, total); // enough to cover desktop view

      for (let i = 0; i < cloneCount; i++) {
        const clone = slides[i].cloneNode(true);
        clone.setAttribute('data-clone', '1');
        track.appendChild(clone);
      }

      let index = 0;
      let slideW = 0;
      let gap = 18;
      let timer = null;
      let isHovering = false;

      function readGap() {
        const cs = getComputedStyle(track);
        const g = cs.columnGap || cs.gap || '0px';
        const val = parseFloat(g);
        return Number.isFinite(val) ? val : 0;
      }

      function measure() {
        const first = track.children[0];
        if (!first) return;
        const rect = first.getBoundingClientRect();
        slideW = rect.width;
        gap = readGap();
        applyTransform(false);
      }

      function applyTransform(animate = true) {
        const x = -1 * index * (slideW + gap);
        if (animate) {
          track.style.transition = `transform ${TRANSITION_MS}ms ease`;
        } else {
          track.style.transition = 'none';
        }
        track.style.transform = `translate3d(${x}px, 0, 0)`;
        updateDots();
      }

      function normalizeIndex() {
        // When we pass the real last slide, jump back seamlessly.
        if (index >= total) {
          index = 0;
          applyTransform(false);
          // force reflow then animate next moves
          void track.offsetHeight;
        }
        if (index < 0) {
          index = total - 1;
          applyTransform(false);
          void track.offsetHeight;
        }
      }

      function next() {
        index += 1;
        applyTransform(true);
      }

      function prev() {
        index -= 1;
        if (index < 0) {
          // jump to end (last real slide) then animate backwards look
          index = total - 1;
          applyTransform(true);
          return;
        }
        applyTransform(true);
      }

      function startAuto() {
        stopAuto();
        timer = setInterval(() => {
          if (isHovering) return;
          next();
        }, AUTO_MS);
      }

      function stopAuto() {
        if (timer) clearInterval(timer);
        timer = null;
      }

      function buildDots() {
        dotsWrap.innerHTML = '';
        const dotsCount = Math.min(total, 8); // keep dots manageable
        // If many reviews, show dots for first 8 and still loop.
        for (let i = 0; i < dotsCount; i++) {
          const b = document.createElement('button');
          b.className = 'dot' + (i === 0 ? ' is-active' : '');
          b.type = 'button';
          b.setAttribute('aria-label', `Go to review ${i + 1}`);
          b.addEventListener('click', () => {
            index = i;
            applyTransform(true);
          });
          dotsWrap.appendChild(b);
        }
      }

      function updateDots() {
        const dots = Array.from(dotsWrap.children);
        if (!dots.length) return;
        const dotsCount = dots.length;
        const active = Math.min(index % total, dotsCount - 1);
        dots.forEach((d, i) => d.classList.toggle('is-active', i === active));
      }

      // Events
      btnNext.addEventListener('click', () => {
        next();
        startAuto();
      });
      btnPrev.addEventListener('click', () => {
        prev();
        startAuto();
      });

      root.addEventListener('mouseenter', () => { isHovering = true; });
      root.addEventListener('mouseleave', () => { isHovering = false; });

      track.addEventListener('transitionend', () => {
        normalizeIndex();
      });

      // Touch / drag support (basic)
      let startX = 0;
      let dragging = false;

      root.addEventListener('pointerdown', (e) => {
        // only left click/touch
        if (e.pointerType === 'mouse' && e.button !== 0) return;
        dragging = true;
        startX = e.clientX;
        stopAuto();
        track.style.transition = 'none';
        root.setPointerCapture?.(e.pointerId);
      });

      root.addEventListener('pointermove', (e) => {
        if (!dragging) return;
        const dx = e.clientX - startX;
        const x = -1 * index * (slideW + gap) + dx;
        track.style.transform = `translate3d(${x}px, 0, 0)`;
      });

      function endDrag(e) {
        if (!dragging) return;
        dragging = false;
        const dx = e.clientX - startX;
        const threshold = Math.min(120, slideW * 0.25);
        if (dx < -threshold) index += 1;
        else if (dx > threshold) index -= 1;
        applyTransform(true);
        startAuto();
      }

      root.addEventListener('pointerup', endDrag);
      root.addEventListener('pointercancel', endDrag);

      // Init
      buildDots();
      measure();
      startAuto();

      // Re-measure on resize
      let resizeT = null;
      window.addEventListener('resize', () => {
        clearTimeout(resizeT);
        resizeT = setTimeout(() => {
          measure();
        }, 120);
      });
    })();
  </script>
@include('frontend.partials.footer')
</body>

</html>
