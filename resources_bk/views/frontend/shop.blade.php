

<?php
// DSL Shop page (Therapie-style layout)
// Header/Footer should come from your DSL header/footer templates.
// If your project uses different include paths, adjust the include lines below.

// Prefer local includes (recommended)
// These files should render the header/footer like:
// https://mobileemilocker.com/DSL/header
// https://mobileemilocker.com/DSL/footer

?>
<style>
  body{margin: 0px !important;}
</style>
@include('frontend.partials.header')

<main class="dsl-shop" role="main">
  <!-- Hero (optional) -->
  <section class="shop-hero" aria-label="Shop hero">
    <div class="shop-hero__inner">
      <div class="shop-hero__copy">
        <h1 class="shop-hero__title">Skin care<br/>products</h1>
      </div>
    </div>
  </section>

  <section class="shop-wrap">
    <!-- Left Filter Sidebar -->
    <aside class="shop-filters" aria-label="Browse by filters">
      <h2 class="filters-title">Browse by</h2>

      <div class="filter-group" data-accordion>
        <button class="filter-head" type="button" aria-expanded="false">
          <span>Product Range</span>
          <span class="chev" aria-hidden="true"></span>
        </button>
        <div class="filter-body" hidden>
          <label class="check"><input type="checkbox" value="antioxidant" data-filter="range"> Antioxidant</label>
          <label class="check"><input type="checkbox" value="glycolic" data-filter="range"> Glycolic</label>
          <label class="check"><input type="checkbox" value="peptide" data-filter="range"> Peptide</label>
          <label class="check"><input type="checkbox" value="retinol" data-filter="range"> Retinol</label>
          <label class="check"><input type="checkbox" value="salicylic" data-filter="range"> Salicylic</label>
          <label class="check"><input type="checkbox" value="vitamin-c" data-filter="range"> Vitamin C</label>
        </div>
      </div>

      <div class="filter-group" data-accordion>
        <button class="filter-head" type="button" aria-expanded="false">
          <span>Product Type</span>
          <span class="chev" aria-hidden="true"></span>
        </button>
        <div class="filter-body" hidden>
          <label class="check"><input type="checkbox" value="cleanser" data-filter="type"> Cleanser</label>
          <label class="check"><input type="checkbox" value="eye-cream" data-filter="type"> Eye Cream</label>
          <label class="check"><input type="checkbox" value="moisturiser" data-filter="type"> Moisturiser</label>
          <label class="check"><input type="checkbox" value="spf" data-filter="type"> SPF</label>
          <label class="check"><input type="checkbox" value="serum" data-filter="type"> Serum</label>
          <label class="check"><input type="checkbox" value="mask" data-filter="type"> Mask</label>
        </div>
      </div>

      <div class="filter-group" data-accordion>
        <button class="filter-head" type="button" aria-expanded="false">
          <span>Skin Type</span>
          <span class="chev" aria-hidden="true"></span>
        </button>
        <div class="filter-body" hidden>
          <label class="check"><input type="checkbox" value="aging" data-filter="skin"> Aging</label>
          <label class="check"><input type="checkbox" value="dry" data-filter="skin"> Dry</label>
          <label class="check"><input type="checkbox" value="normal" data-filter="skin"> Normal</label>
          <label class="check"><input type="checkbox" value="oily" data-filter="skin"> Oily</label>
          <label class="check"><input type="checkbox" value="sensitive" data-filter="skin"> Sensitive</label>
        </div>
      </div>

      <div class="filter-group" data-accordion>
        <button class="filter-head" type="button" aria-expanded="false">
          <span>Skin Concerns</span>
          <span class="chev" aria-hidden="true"></span>
        </button>
        <div class="filter-body" hidden>
          <label class="check"><input type="checkbox" value="brightening" data-filter="concern"> Brightening</label>
          <label class="check"><input type="checkbox" value="acne" data-filter="concern"> Acne</label>
          <label class="check"><input type="checkbox" value="pigmentation" data-filter="concern"> Pigmentation</label>
          <label class="check"><input type="checkbox" value="anti-aging" data-filter="concern"> Anti-aging</label>
          <label class="check"><input type="checkbox" value="hydration" data-filter="concern"> Hydration</label>
        </div>
      </div>

      <div class="filter-group" data-accordion>
        <button class="filter-head" type="button" aria-expanded="true">
          <span>All Products</span>
          <span class="chev" aria-hidden="true"></span>
        </button>
        <div class="filter-body" data-all-products>
          <button class="btn-link" type="button" id="clearFilters">Clear filters</button>
        </div>
      </div>
    </aside>

    <!-- Product Grid -->
    <section class="shop-products" aria-label="Products">
      <div class="shop-products__head">
        <h2 class="products-title">Products</h2>
      </div>

      <div class="products-grid" id="productsGrid">

@foreach ($addons as $item)

    @php
        // 🔥 Locale based image logic
        if(session('app_locale')=='cn'){
            if(!empty($item->profile_cn)){
                $profile11 = $item->profile_cn;
            }else{
                $profile11 = $item->profile;
            }
        }elseif(session('app_locale')=='ar'){
            if(!empty($item->profile_ar)){
                $profile11 = $item->profile_ar;
            }else{
                $profile11 = $item->profile;
            }
        }else{
            $profile11 = $item->profile;
        }

        $imagePath = !empty($profile11) 
            ? asset('uploads/addon/' . $profile11) 
            : asset('assets/img/media/1.jpg');
    @endphp

    <article class="product-card"
        data-name="{{ $item->addon_name }}"
        data-price="{{ $item->price }}"
        data-img="{{ $imagePath }}"
    >

        {{-- Product Image --}}
        <a class="product-media" href="{{ route('shop-details', $item->id) }}">
            <img 
                src="{{ $imagePath }}" 
                alt="{{ $item->addon_name }}" 
                loading="lazy"
            >
            <span class="view-product">View product →</span>
        </a>

        {{-- Product Name --}}
        <h3 class="product-name">
            {{ Str::limit($item->addon_name, 50) }}
        </h3>

        {{-- Category --}}
        <div style="font-size:13px; color:#777;">
            {{ @$item->getAddonCategory->MasterValue ?? 'General' }}
        </div>

        {{-- Price --}}
        <div class="product-price">
            £{{ number_format($item->price, 2) }}
        </div>

        {{-- Add to Cart --}}
        <button 
    class="btn-primary add-to-cart-btn" 
    type="button"
    data-id="{{ $item->id }}"
    data-name="{{ $item->addon_name }}"
    data-price="{{ $item->price }}"
    data-img="{{ $imagePath }}"
>
    Add to bag
</button>

    </article>

@endforeach

</div>

      <div class="no-results" id="noResults" hidden>
        No products match your filters.
      </div>
    </section>
  </section>


</main>

<style>
  /* --- Scope all styles to this page only --- */
  .dsl-shop,
  .dsl-shop *{box-sizing:border-box;}

  /* --- Layout (100% width) --- */
  .dsl-shop{
    display:block;
    width:100%;
    max-width:none;
    margin:0;
    font-family: system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;
    color:#111;
    overflow-x:hidden;
  }

  .dsl-shop .shop-hero{background:#f3f2f6; width:100%;}
  .dsl-shop .shop-hero__inner{width:100%; margin:0 auto; padding:28px clamp(16px,3vw,48px) 22px;}
  .dsl-shop .shop-hero__title{margin:0; font-weight:600; letter-spacing:-0.03em; font-size:44px; line-height:1.05;}

  .dsl-shop .shop-wrap{width:100%; margin:0 auto; padding:18px clamp(16px,3vw,48px); display:grid; grid-template-columns: 280px 1fr; gap:36px;}

  /* Filters */
  .dsl-shop .filters-title{margin:10px 0 18px; font-size:18px; font-weight:600;}
  .dsl-shop .filter-group{border-bottom:1px solid #e9e9ee; padding:10px 0;}
  .dsl-shop .filter-head{width:100%; display:flex; align-items:center; justify-content:space-between; gap:10px; border:0; background:transparent; padding:10px 0; cursor:pointer; font-size:15px; font-weight:600; text-align:left;}
  .dsl-shop .filter-body{padding:6px 0 12px;}
  .dsl-shop .check{display:flex; align-items:center; gap:10px; padding:6px 0; font-size:14px; color:#222;}
  .dsl-shop .check input{width:16px; height:16px;}
  .dsl-shop .btn-link{border:0; background:transparent; color:#4b4bff; cursor:pointer; font-weight:600; padding:0; font-size:13px;}

  .dsl-shop .chev{width:18px; height:18px; display:inline-block; position:relative;}
  .dsl-shop .chev:before,.dsl-shop .chev:after{content:""; position:absolute; top:50%; left:50%; width:10px; height:2px; background:#111; transform-origin:center;}
  .dsl-shop .chev:before{transform:translate(-50%,-50%) rotate(45deg);}
  .dsl-shop .chev:after{transform:translate(-50%,-50%) rotate(-45deg);}
  .dsl-shop .filter-head[aria-expanded="true"] .chev:before{transform:translate(-50%,-50%) rotate(-45deg);} 
  .dsl-shop .filter-head[aria-expanded="true"] .chev:after{transform:translate(-50%,-50%) rotate(45deg);} 

  /* Products */
  .dsl-shop .products-title{margin:10px 0 18px; font-size:20px; font-weight:650;}
  .dsl-shop .products-grid{display:grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap:34px 34px;}

  .dsl-shop .product-card{display:flex; flex-direction:column; align-items:center; text-align:center;}
  .dsl-shop .product-media{
    position:relative;
    width:100%;
    display:block;
    aspect-ratio: 4 / 3;
    border-radius:12px;
    overflow:hidden;
    background:#fff;
    text-decoration:none;
    cursor:pointer;
  }
  .dsl-shop .product-media img{width:100%; height:100%; object-fit:contain; display:block; filter: drop-shadow(0 20px 25px rgba(0,0,0,0.08));}
  .dsl-shop .view-product{
    position:absolute;
    left:50%;
    top:50%;
    transform:translate(-50%,-50%) scale(0.98);
    background:#fff;
    border:1px solid rgba(17,17,17,0.28);
    color:#111;
    border-radius:999px;
    padding:10px 18px;
    font-size:14px;
    font-weight:650;
    box-shadow:0 10px 28px rgba(0,0,0,0.10);
    opacity:0;
    transition:opacity .15s ease, transform .15s ease;
    white-space:nowrap;
  }
  /* --- Bag drawer --- */
  .dsl-shop .bag-overlay{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.45);
    opacity:0;
    transition:opacity .18s ease;
    z-index:9998;
  }
  .dsl-shop.is-bag-open .bag-overlay{opacity:1;}

  .dsl-shop .bag-drawer{
    position:fixed;
    top:0;
    right:0;
    height:100vh;
    width:min(440px, 92vw);
    background:#fff;
    border-left:1px solid #e9e9ee;
    box-shadow:-20px 0 40px rgba(0,0,0,0.12);
    transform:translateX(100%);
    transition:transform .22s ease;
    z-index:9999;
    display:flex;
    flex-direction:column;
  }
  .dsl-shop.is-bag-open .bag-drawer{transform:translateX(0);}

  .dsl-shop .bag-head{
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:18px 18px;
    border-bottom:1px solid #eee;
  }
  .dsl-shop .bag-title{margin:0; font-size:22px; font-weight:700;}
  .dsl-shop .bag-close{
    width:36px; height:36px;
    border-radius:999px;
    border:1px solid #e7e7ef;
    background:#fff;
    font-size:22px;
    line-height:1;
    cursor:pointer;
  }

  .dsl-shop .bag-items{padding:8px 18px 18px; overflow:auto; flex:1;}
  .dsl-shop .bag-item{
    display:grid;
    grid-template-columns:64px 1fr auto;
    gap:14px;
    padding:14px 0;
    border-bottom:1px solid #f0f0f5;
    align-items:center;
  }
  .dsl-shop .bag-thumb{
    width:64px; height:64px;
    border:1px solid #ededf4;
    border-radius:10px;
    display:flex;
    align-items:center;
    justify-content:center;
    overflow:hidden;
    background:#fff;
  }
  .dsl-shop .bag-thumb img{width:100%; height:100%; object-fit:contain;}
  .dsl-shop .bag-meta{min-width:0;}
  .dsl-shop .bag-name{font-weight:650; font-size:14px; margin:0 0 6px;}
  .dsl-shop .bag-controls{display:flex; align-items:center; gap:10px;}
  .dsl-shop .qty{
    display:inline-flex;
    align-items:center;
    border:1px solid #e7e7ef;
    border-radius:10px;
    overflow:hidden;
    height:34px;
  }
  .dsl-shop .qty button{
    width:34px; height:34px;
    border:0; background:#fff; cursor:pointer;
    font-size:18px;
  }
  .dsl-shop .qty span{min-width:30px; text-align:center; font-weight:650; font-size:13px;}
  .dsl-shop .bag-remove{
    border:0;
    background:transparent;
    color:#d11;
    cursor:pointer;
    font-weight:650;
    font-size:13px;
  }
  .dsl-shop .bag-price{font-weight:700; font-size:14px; white-space:nowrap;}

  .dsl-shop .bag-footer{
    border-top:1px solid #eee;
    padding:16px 18px 18px;
    background:#fff;
  }
  .dsl-shop .bag-subtotal{display:flex; align-items:baseline; justify-content:space-between; gap:12px;}
  .dsl-shop .bag-subtotal__label{font-weight:700; font-size:18px;}
  .dsl-shop .bag-subtotal__value{font-weight:800; font-size:20px;}
  .dsl-shop .bag-note{margin-top:6px; color:#666; font-size:12.5px;}
  .dsl-shop .bag-checkout{
    display:flex;
    align-items:center;
    justify-content:center;
    margin-top:14px;
    height:52px;
    border-radius:999px;
    background:#111;
    color:#fff;
    text-decoration:none;
    font-weight:750;
    font-size:15px;
  }
  .dsl-shop .bag-checkout:hover{opacity:.92;}

  /* Keep the hover “View product” button clickable */
  .dsl-shop .view-product{pointer-events:none;}
  .dsl-shop .product-media:hover .view-product,
  .dsl-shop .product-media:focus-visible .view-product,
  .dsl-shop .product-media:focus-within .view-product{
    opacity:1;
    transform:translate(-50%,-50%) scale(1);
  }
  /* On touch devices (no hover), keep the button visible */
  @media (hover: none){
    .dsl-shop .view-product{
      opacity:1;
      transform:translate(-50%,-50%) scale(1);
    }
  }

  .dsl-shop .product-media.ph{background:linear-gradient(180deg,#fafafe,#f2f2f9);} 
  .dsl-shop .ph__box{display:none;}
  .dsl-shop .product-media.ph .ph__box{display:block; position:absolute; inset:18px; border-radius:12px; background:linear-gradient(90deg,#f0f0f6,#f7f7fb,#f0f0f6); background-size:200% 100%; animation:shimmer 1.4s infinite;}
  @keyframes shimmer{0%{background-position:200% 0}100%{background-position:-200% 0}}

  .dsl-shop .badge{position:absolute; top:12px; left:12px; background:#fff; border:1px solid #e6e6ef; border-radius:999px; font-size:12px; padding:6px 10px; box-shadow:0 6px 20px rgba(0,0,0,0.06);}

  .dsl-shop .product-name{margin:14px 0 6px; font-size:15px; font-weight:650; line-height:1.3; max-width:260px;}
  .dsl-shop .product-price{font-size:15px; font-weight:650; margin-bottom:12px;}

  .dsl-shop .btn-primary{border:0; background:#111; color:#fff; border-radius:999px; padding:12px 20px; font-weight:650; font-size:14px; cursor:pointer; min-width:180px;}
  .dsl-shop .btn-primary:hover{opacity:.92;}

  .dsl-shop .no-results{padding:18px; border:1px dashed #e0e0ea; border-radius:12px; color:#333; background:#fafafe;}

  /* Responsive */
  @media (max-width: 1100px){
    .dsl-shop .products-grid{grid-template-columns: repeat(2, minmax(0, 1fr));}
    .dsl-shop .shop-wrap{grid-template-columns: 260px 1fr; gap:26px;}
  }
  @media (max-width: 900px){
    .dsl-shop .shop-wrap{grid-template-columns: 1fr;}
    .dsl-shop .shop-filters{order:2;}
    .dsl-shop .shop-products{order:1;}
  }
  @media (max-width: 520px){
    .dsl-shop .shop-hero__title{font-size:34px;}
    .dsl-shop .products-grid{grid-template-columns: 1fr; gap:26px;}
    .dsl-shop .btn-primary{min-width: 220px;}
  }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
  
function money(amount) {
    return '£' + parseFloat(amount).toFixed(2);
}

$(document).on('click', '.add-to-cart-btn', function (e) {
    e.preventDefault();

    let button = $(this);

    $.ajax({
        url: "{{ route('add.to.cart') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            product_id: button.data('id'),
            name: button.data('name'),
            price: button.data('price'),
            image: button.data('img'),
             type: 'product',
            session: button.data('session') || null
        },
        success: function (res) {

            let html = '';

            res.items.forEach(function (item) {

                let qty = item.qty;
                let price = item.price;

                html += `
                <div class="cart-drawer__item" data-id="${item.product_id}">
                    
                    <div class="cart-drawer__thumb">
                        <img src="${item.image || ''}" alt="${item.product_name}">
                    </div>

                    <div class="cart-drawer__meta">
                        <p class="cart-drawer__name">${item.product_name}</p>

                        <div class="cart-drawer__actions">
                            <div class="cart-drawer__qty">
                                <button type="button" data-cart-qty="dec">−</button>
                                <span>${qty}</span>
                                <button type="button" data-cart-qty="inc">+</button>
                            </div>

                            <button type="button" class="cart-drawer__remove">Remove</button>
                        </div>
                    </div>

                    <div class="cart-drawer__price">
                        ${money(price * qty)}
                    </div>

                </div>
                `;
            });

            // ✅ Update drawer items
            $('#cartDrawerItems').html(html);

            // ✅ Update cart badge
            $('#cartDrawerSubtotal').text(money(res.subtotal));

    // ✅ Update cart badge
    $('.cart-badge').text(res.count);

            // ✅ Open drawer
            $('#cartDrawer').addClass('is-open').attr('aria-hidden', 'false');

        }
    });
});

  // Shop page JS (scoped)
  (function(){
    const $ = (s, r=document) => r.querySelector(s);
    const $$ = (s, r=document) => Array.from(r.querySelectorAll(s));

    // Accordions
    $$('[data-accordion]').forEach(group => {
      const head = $('.filter-head', group);
      const body = $('.filter-body', group);

      // If aria-expanded is true, keep open
      const isOpen = head.getAttribute('aria-expanded') === 'true';
      if (!isOpen) body.hidden = true;

      head.addEventListener('click', () => {
        const open = head.getAttribute('aria-expanded') === 'true';
        head.setAttribute('aria-expanded', String(!open));
        body.hidden = open;
      });
    });

    // Filtering
    const grid = $('#productsGrid');
    const cards = $$('.product-card', grid);
    const noResults = $('#noResults');

    function getSelectedValues(key){
      return $$(`input[data-filter="${key}"]:checked`).map(i => i.value);
    }

    function matchesAny(value, selected){
      if (selected.length === 0) return true;
      return selected.includes(value);
    }

    function applyFilters(){
      const selected = {
        range: getSelectedValues('range'),
        type: getSelectedValues('type'),
        skin: getSelectedValues('skin'),
        concern: getSelectedValues('concern')
      };

      let visibleCount = 0;
      cards.forEach(card => {
        const ok =
          matchesAny(card.dataset.range, selected.range) &&
          matchesAny(card.dataset.type, selected.type) &&
          matchesAny(card.dataset.skin, selected.skin) &&
          matchesAny(card.dataset.concern, selected.concern);

        card.style.display = ok ? '' : 'none';
        if (ok) visibleCount++;
      });

      noResults.hidden = visibleCount !== 0;
    }

    $$('input[data-filter]').forEach(i => i.addEventListener('change', applyFilters));

    // Clear filters
    const clearBtn = $('#clearFilters');
    if (clearBtn) {
      clearBtn.addEventListener('click', () => {
        $$('input[data-filter]:checked').forEach(i => i.checked = false);
        applyFilters();
      });
    }

    // Bag drawer (simple client-side cart)
    const shopRoot = document.querySelector('.dsl-shop');
    const bagOverlay = document.querySelector('.bag-overlay');
    const bagDrawer = document.querySelector('.bag-drawer');
    const bagItemsEl = document.getElementById('bagItems');
    const bagSubtotalEl = document.getElementById('bagSubtotal');

    const cart = new Map(); // key: name, value: {name, price, img, qty}

    function money(v){
      return '£' + (Math.round(v * 100) / 100).toFixed(2);
    }

    function openBag(){
      shopRoot.classList.add('is-bag-open');
      if (bagOverlay) bagOverlay.hidden = false;
      if (bagDrawer) bagDrawer.setAttribute('aria-hidden', 'false');
      // prevent background scroll
      document.documentElement.style.overflow = 'hidden';
      document.body.style.overflow = 'hidden';
    }

    function closeBag(){
      shopRoot.classList.remove('is-bag-open');
      if (bagOverlay) bagOverlay.hidden = true;
      if (bagDrawer) bagDrawer.setAttribute('aria-hidden', 'true');
      document.documentElement.style.overflow = '';
      document.body.style.overflow = '';
    }

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && shopRoot.classList.contains('is-bag-open')) closeBag();
    });

    document.querySelectorAll('[data-bag-close]').forEach(el => {
      el.addEventListener('click', closeBag);
    });

    // function renderBag(){
    //   if (!bagItemsEl) return;

    //   const items = Array.from(cart.values());
    //   bagItemsEl.innerHTML = '';

    //   let subtotal = 0;
    //   items.forEach(item => {
    //     subtotal += item.price * item.qty;

    //     const row = document.createElement('div');
    //     row.className = 'bag-item';
    //     row.innerHTML = `
    //       <div class="bag-thumb"><img src="${item.img}" alt="${item.name}"></div>
    //       <div class="bag-meta">
    //         <p class="bag-name">${item.name}</p>
    //         <div class="bag-controls">
    //           <div class="qty" role="group" aria-label="Quantity">
    //             <button type="button" data-qty="dec" aria-label="Decrease">−</button>
    //             <span aria-live="polite">${item.qty}</span>
    //             <button type="button" data-qty="inc" aria-label="Increase">+</button>
    //           </div>
    //           <button type="button" class="bag-remove" data-remove>Remove</button>
    //         </div>
    //       </div>
    //       <div class="bag-price">${money(item.price * item.qty)}</div>
    //     `;

    //     // Wire qty controls
    //     row.querySelector('[data-qty="inc"]').addEventListener('click', () => {
    //       item.qty += 1;
    //       cart.set(item.name, item);
    //       renderBag();
    //     });
    //     row.querySelector('[data-qty="dec"]').addEventListener('click', () => {
    //       item.qty -= 1;
    //       if (item.qty <= 0) cart.delete(item.name);
    //       else cart.set(item.name, item);
    //       renderBag();
    //     });
    //     row.querySelector('[data-remove]').addEventListener('click', () => {
    //       cart.delete(item.name);
    //       renderBag();
    //     });

    //     bagItemsEl.appendChild(row);
    //   });

    //   if (bagSubtotalEl) bagSubtotalEl.textContent = money(subtotal);

    //   // Empty state
    //   if (items.length === 0){
    //     bagItemsEl.innerHTML = '<div style="padding:18px 0; color:#555;">Your bag is empty.</div>';
    //   }
    // }

    // // Add to bag: add item and open drawer
    // $$('[data-add]').forEach(btn => {
    //   btn.addEventListener('click', () => {
    //     const card = btn.closest('.product-card');
    //     if (!card) return;

    //     const name = card.getAttribute('data-name') || $('.product-name', card)?.textContent?.trim() || 'Product';
    //     const img = card.getAttribute('data-img') || $('img', card)?.getAttribute('src') || '';
    //     const price = parseFloat(card.getAttribute('data-price') || '0') || 0;

    //     const existing = cart.get(name);
    //     if (existing) existing.qty += 1;
    //     else cart.set(name, { name, img, price, qty: 1 });

    //     renderBag();
    //     openBag();
    //   });
    // });

    // Initial
    applyFilters();
  })();
</script>

@include('frontend.partials.footer')