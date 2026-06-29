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
    :root {
      --container-pad: clamp(16px, 3vw, 40px);
      --brand: #6b63d8;
      --ink: #111;
      --muted: #6b7280;
      --card: #fff;
      --bg: #fff;
      --shadow: 0 14px 30px rgba(0, 0, 0, .08);
      --radius: 18px;
    }

    * { box-sizing: border-box; }

    body {
      margin: 0;
      font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji";
      background: var(--bg);
      color: var(--ink);
    }

    /* FULL WIDTH SECTION */
    .reviews-section {
      width: 100%;
      padding: 70px 0 80px;
      background: #fff;
      overflow: hidden;
    }

    .reviews-wrap {
      width: 100%;
      padding: 0 var(--container-pad);
    }

    .reviews-topline {
      text-align: center;
      font-size: 13px;
      letter-spacing: .22em;
      text-transform: uppercase;
      color: var(--brand);
      font-weight: 700;
      margin-bottom: 10px;
    }

    .reviews-title {
      text-align: center;
      font-family: ui-serif, Georgia, "Times New Roman", Times, serif;
      font-size: clamp(34px, 5vw, 62px);
      line-height: 1.02;
      font-weight: 500;
      margin: 0 0 28px;
    }

    .carousel {
      position: relative;
      width: 100%;
    }

    .carousel-viewport {
      overflow: hidden;
      width: 100%;
      border-radius: 0;
    }

    .carousel-track {
      display: flex;
      align-items: stretch;
      gap: 18px;
      will-change: transform;
      transform: translate3d(0, 0, 0);
    }

    .review-card {
      flex: 0 0 auto;
      width: min(360px, calc(100vw - (var(--container-pad) * 2) - 14px));
      background: var(--card);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      padding: 22px 22px 18px;
      border: 1px solid rgba(0, 0, 0, .06);
      min-height: 230px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    @media (min-width: 900px) {
      .review-card { width: 380px; }
    }

    .card-head {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 14px;
      margin-bottom: 12px;
    }

    .name {
      font-weight: 700;
      font-size: 18px;
      line-height: 1.15;
    }

    .meta {
      margin-top: 6px;
      font-size: 13px;
      color: var(--muted);
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .stars {
      display: inline-flex;
      gap: 2px;
      color: #c5a200;
      font-size: 14px;
      line-height: 1;
      margin-top: 2px;
      white-space: nowrap;
    }

    .star { font-size: 14px; }

    .text {
      font-size: 15px;
      line-height: 1.6;
      color: #111;
      margin: 12px 0 18px;
      display: -webkit-box;
      -webkit-line-clamp: 6;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .brand-row {
      display: flex;
      align-items: center;
      justify-content: flex-start;
      gap: 10px;
      color: #111;
      font-weight: 700;
      font-size: 22px;
    }

    .brand-sub {
      font-weight: 600;
      font-size: 12px;
      color: var(--muted);
      margin-left: 2px;
    }

    /* Nav buttons (like Therapie arrows) */
    .nav-btn {
      position: absolute;
      top: -64px;
      right: 0;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 44px;
      height: 44px;
      border-radius: 999px;
      border: 1px solid rgba(0, 0, 0, .10);
      background: rgba(245, 245, 245, .85);
      color: #111;
      cursor: pointer;
      user-select: none;
      transition: transform .12s ease, background .12s ease;
    }

    .nav-btn:hover { transform: translateY(-1px); background: rgba(235, 235, 235, .95); }
    .nav-btn:active { transform: translateY(0); }

    .nav-btn.prev { right: 56px; }
    .nav-btn.next { right: 0; }

    .nav-btn svg { width: 18px; height: 18px; }

    /* Dots */
    .dots {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-top: 20px;
    }

    .dot {
      width: 42px;
      height: 3px;
      border-radius: 999px;
      background: rgba(0, 0, 0, .10);
      border: none;
      cursor: pointer;
      padding: 0;
    }

    .dot.is-active { background: rgba(0, 0, 0, .55); }

    /* Respect reduced motion */
    @media (prefers-reduced-motion: reduce) {
      .carousel-track { transition: none !important; }
      .nav-btn { transition: none !important; }
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
                        <span><?php echo htmlspecialchars($r['location']); ?></span>
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
