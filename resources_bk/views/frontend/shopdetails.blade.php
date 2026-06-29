

<?php
// product-detail-page.php
// Standalone product detail page (Thérapie-style) with responsive full-width layout and a right-side Bag drawer.
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Product Detail</title>

  <style>
    :root{
      --bg:#ffffff;
      --text:#111827;
      --muted:#6b7280;
      --line:#e5e7eb;
      --pill:#f3f4f6;
      --black:#111111;
      --btn:#111111;
      --btnText:#ffffff;
      --accent:#6d63ff;
    }

    *{box-sizing:border-box;}
    html,body{height:100%;}
    body{
      margin:0;
      font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji","Segoe UI Emoji";
      color:var(--text);
      background:var(--bg);
    }
    a{color:inherit; text-decoration:none;}

    /* Top announcement */
    .topbar{
      width:100%;
      background:#111;
      color:#fff;
      font-size:14px;
      padding:10px 16px;
      display:flex;
      justify-content:center;
      align-items:center;
      gap:8px;
    }
    .topbar a{color:#fff; text-decoration:underline;}

    /* Header */
    header{
      width:100%;
      border-bottom:1px solid var(--line);
      background:#fff;
    }
    .header-inner{
      width:100%;
      padding:16px 24px;
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:16px;
    }
    .brand{
      display:flex;
      align-items:center;
      gap:10px;
      min-width:160px;
    }
    .brand-mark{
      width:34px;
      height:34px;
      border-radius:10px;
      background:linear-gradient(135deg,#8b5cf6,#6366f1);
    }
    .brand-name{
      font-size:22px;
      letter-spacing:.5px;
      font-weight:600;
    }

    nav{
      display:flex;
      align-items:center;
      gap:28px;
      flex:1;
      justify-content:center;
      min-width:320px;
    }
    .nav-item{
      font-weight:600;
      font-size:14px;
      letter-spacing:.6px;
      color:#111827;
      text-transform:uppercase;
      opacity:.9;
    }
    .nav-item:hover{opacity:1;}

    .hdr-actions{
      display:flex;
      align-items:center;
      gap:14px;
      min-width:220px;
      justify-content:flex-end;
    }
    .icon-btn{
      width:38px;
      height:38px;
      border-radius:999px;
      border:1px solid var(--line);
      background:#fff;
      display:flex;
      align-items:center;
      justify-content:center;
      cursor:pointer;
      position:relative;
    }
    .icon-dot{
      position:absolute;
      top:-6px;
      right:-6px;
      width:22px;
      height:22px;
      border-radius:999px;
      background:#ef4444;
      color:#fff;
      font-size:12px;
      display:flex;
      align-items:center;
      justify-content:center;
      border:2px solid #fff;
    }
    .cta{
      padding:12px 16px;
      border-radius:999px;
      background:var(--accent);
      color:#fff;
      font-weight:700;
      font-size:14px;
      border:none;
      cursor:pointer;
      white-space:nowrap;
    }

    /* Main layout */
    main{
      width:100%;
    }
    .page{
      width:100%;
      padding:26px 24px 40px;
    }

    .breadcrumb{
      width:100%;
      color:var(--muted);
      font-size:15px;
      margin:10px 0 22px;
    }
    .breadcrumb a{color:var(--muted);}

    .product-grid{
      width:100%;
      display:grid;
      grid-template-columns: 1.1fr .9fr;
      gap:56px;
      align-items:start;
    }

    /* Left image */
    .product-media{
      width:100%;
      display:flex;
      justify-content:center;
      align-items:flex-start;
      padding:10px 0;
    }
    .product-media img{
      width:min(460px, 90%);
      height:auto;
      display:block;
      filter: drop-shadow(0 22px 28px rgba(0,0,0,.18));
      border-radius:10px;
      background:#fff;
    }

    /* Right summary */
    .product-summary{
      width:100%;
    }
    .title{
      font-family: ui-serif, Georgia, Cambria, "Times New Roman", Times, serif;
      font-size:64px;
      line-height:0.95;
      font-weight:500;
      margin:0 0 18px;
      letter-spacing:-.5px;
    }
    .price{
      font-size:28px;
      font-weight:700;
      margin:0 0 18px;
    }
    .qty-row{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:18px;
      margin:10px 0 14px;
    }
    .qty-label{
      font-weight:700;
      font-size:18px;
    }
    .qty-box{
      display:flex;
      align-items:center;
      border:1px solid var(--line);
      border-radius:10px;
      overflow:hidden;
      background:#fff;
    }
    .qty-btn{
      width:42px;
      height:40px;
      border:none;
      background:#fff;
      cursor:pointer;
      font-size:18px;
    }
    .qty-btn:hover{background:#fafafa;}
    .qty-val{
      width:44px;
      text-align:center;
      font-weight:700;
      font-size:16px;
    }

    .primary-btn{
      width:100%;
      height:56px;
      border-radius:999px;
      border:none;
      background:var(--btn);
      color:var(--btnText);
      font-weight:800;
      font-size:16px;
      cursor:pointer;
    }
    .primary-btn:hover{opacity:.92;}
    .shipping{
      margin-top:10px;
      text-align:center;
      color:var(--muted);
      font-size:14px;
    }

    .info-block{
      margin-top:34px;
      border-top:1px solid var(--line);
      padding-top:22px;
    }
    .k{
      font-weight:800;
      font-size:22px;
      margin:0 0 6px;
    }
    .v{
      margin:0 0 22px;
      color:#111827;
      font-size:18px;
      line-height:1.5;
    }
    .v.small{font-size:16px; color:#111827;}
    ul.bullets{margin:12px 0 0 18px;}
    ul.bullets li{margin:6px 0;}

    /* Footer */
    footer{
      width:100%;
      border-top:1px solid var(--line);
      background:#fff;
    }
    .footer-inner{
      width:100%;
      padding:30px 24px;
      display:grid;
      grid-template-columns: 1.2fr 1fr 1fr 1fr;
      gap:24px;
    }
    .f-title{font-weight:800; margin-bottom:10px;}
    .f-link{display:block; color:var(--muted); margin:6px 0; font-size:14px;}
    .f-link:hover{color:#111827;}
    .copyright{
      border-top:1px solid var(--line);
      padding:14px 24px;
      color:var(--muted);
      font-size:13px;
      display:flex;
      justify-content:space-between;
      gap:12px;
      flex-wrap:wrap;
    }

    /* Bag drawer */
    .overlay{
      position:fixed;
      inset:0;
      background:rgba(0,0,0,.55);
      opacity:0;
      pointer-events:none;
      transition:opacity .18s ease;
      z-index:60;
    }
    .overlay.open{opacity:1; pointer-events:auto;}

    .drawer{
      position:fixed;
      top:0;
      right:0;
      height:100vh;
      width:min(460px, 92vw);
      background:#fff;
      transform:translateX(100%);
      transition:transform .22s ease;
      z-index:70;
      display:flex;
      flex-direction:column;
      border-left:1px solid var(--line);
    }
    .drawer.open{transform:translateX(0);}

    .drawer-head{
      padding:18px 18px;
      display:flex;
      align-items:center;
      justify-content:space-between;
      border-bottom:1px solid var(--line);
    }
    .drawer-title{font-weight:900; font-size:22px;}
    .drawer-close{
      width:38px; height:38px;
      border-radius:999px;
      border:1px solid var(--line);
      background:#fff;
      cursor:pointer;
      font-size:18px;
    }

    .drawer-body{
      padding:16px 18px;
      overflow:auto;
      flex:1;
    }
    .bag-item{
      display:grid;
      grid-template-columns: 68px 1fr auto;
      gap:12px;
      padding:14px 0;
      border-bottom:1px solid var(--line);
      align-items:center;
    }
    .bag-thumb{
      width:68px;
      height:68px;
      border:1px solid var(--line);
      border-radius:10px;
      display:flex;
      align-items:center;
      justify-content:center;
      overflow:hidden;
      background:#fff;
    }
    .bag-thumb img{width:100%; height:100%; object-fit:contain;}
    .bag-name{font-weight:800; font-size:15px; margin-bottom:6px;}
    .bag-controls{display:flex; align-items:center; gap:10px;}
    .mini-qty{
      display:flex;
      align-items:center;
      border:1px solid var(--line);
      border-radius:10px;
      overflow:hidden;
    }
    .mini-qty button{
      width:32px; height:30px; border:none; background:#fff; cursor:pointer;
    }
    .mini-qty span{
      width:34px; text-align:center; font-weight:800; font-size:14px;
    }
    .bag-price{font-weight:900; white-space:nowrap;}

    .drawer-foot{
      padding:16px 18px 18px;
      border-top:1px solid var(--line);
      background:#fff;
    }
    .subtotal-row{
      display:flex;
      align-items:flex-end;
      justify-content:space-between;
      gap:10px;
      margin-bottom:12px;
    }
    .sub-label{font-weight:900;}
    .sub-note{color:var(--muted); font-size:13px; margin-top:3px;}
    .checkout-btn{
      width:100%;
      height:56px;
      border-radius:999px;
      border:none;
      background:var(--btn);
      color:var(--btnText);
      font-weight:900;
      font-size:16px;
      cursor:pointer;
    }

    /* Responsive */
    @media (max-width: 980px){
      nav{display:none;}
      .header-inner{padding:14px 16px;}
      .page{padding:22px 16px 34px;}
      .product-grid{grid-template-columns:1fr; gap:28px;}
      .title{font-size:46px;}
      .product-media img{width:min(420px, 92%);} 
      .footer-inner{grid-template-columns:1fr 1fr;}
    }

    @media (max-width: 520px){
      .brand-name{font-size:18px;}
      .cta{display:none;}
      .hdr-actions{min-width:auto;}
      .title{font-size:38px;}
      .footer-inner{grid-template-columns:1fr;}
    }
  </style>
</head>
<body>
  @include('frontend.partials.header')

  <main>
    <div class="page">
      <div class="breadcrumb">
        <a href="{{ route('shop') }}">Products</a> &nbsp;/&nbsp; <span id="crumbName"><span>{{ $addondetails->addon_name }}</span></span>
      </div>

      <section class="product-grid" aria-label="Product details">
        <!-- Left: image -->
        <div class="product-media">
            @php
                if(session('app_locale')=='cn' && !empty($addondetails->profile_cn)){
                    $profile = $addondetails->profile_cn;
                }elseif(session('app_locale')=='ar' && !empty($addondetails->profile_ar)){
                    $profile = $addondetails->profile_ar;
                }else{
                    $profile = $addondetails->profile;
                }
            
                $imagePath = !empty($profile)
                    ? asset('uploads/addon/'.$profile)
                    : asset('assets/img/media/1.jpg');
            @endphp
            
            <img id="productImg" src="{{ $imagePath }}" alt="{{ $addondetails->addon_name }}" onerror="this.style.filter='none'; this.style.boxShadow='none';">
          
        </div>

        <!-- Right: content -->
        <div class="product-summary">
          <h1 class="title" id="productTitle">{!! nl2br(e($addondetails->addon_name)) !!}</h1>
          <p class="price" id="productPrice">£{{ number_format($addondetails->price, 2) }}</p>

          <div class="qty-row">
            <div class="qty-label">Quantity</div>
            <div class="qty-box" aria-label="Quantity selector">
              <button class="qty-btn" type="button" id="qtyMinus" aria-label="Decrease quantity">−</button>
              <div class="qty-val" id="qtyVal" aria-live="polite">1</div>
              <button class="qty-btn" type="button" id="qtyPlus" aria-label="Increase quantity">+</button>
            </div>
          </div>

          <button 
    class="primary-btn" 
    type="button" 
    id="addToBagBtn"
    data-id="{{ $addondetails->id }}"
    data-name="{{ $addondetails->addon_name }}"
    data-price="{{ $addondetails->price }}"
    data-img="{{ $imagePath }}"
>
    Add to bag
</button>
          <div class="shipping">Free shipping on orders over £50</div>

          <div class="info-block">
            {{ $addondetails->description ?? 'No description available' }}
          </div>
        </div>
      </section>
    </div>
  </main>

  @include('frontend.partials.footer')

  <!-- Bag Drawer -->
  <div class="overlay" id="overlay" aria-hidden="true"></div>

  <aside class="drawer" id="drawer" aria-label="Bag" aria-hidden="true">
    <div class="drawer-head">
      <div class="drawer-title">Bag</div>
      <button class="drawer-close" type="button" id="closeDrawer" aria-label="Close">×</button>
    </div>

    <div class="drawer-body" id="bagBody">
      <!-- items injected by JS -->
    </div>

    <div class="drawer-foot">
      <div class="subtotal-row">
        <div>
          <div class="sub-label">Bag subtotal:</div>
          <div class="sub-note">Delivery and discounts are added at checkout.</div>
        </div>
        <div class="sub-label" id="subtotal">£0.00</div>
      </div>
      <button class="checkout-btn" type="button" onclick="window.location.href='checkout.php'">Checkout →</button>
    </div>
  </aside>


<script>
let qty = 1;

// ➕ Increase
$('#qtyPlus').click(function () {
    qty++;
    $('#qtyVal').text(qty);
});

// ➖ Decrease
$('#qtyMinus').click(function () {
    if (qty > 1) {
        qty--;
        $('#qtyVal').text(qty);
    }
});

// 🛒 Add to cart from PDP
$('#addToBagBtn').click(function () {

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
            qty: qty
        },
        success: function (res) {

            // ✅ Use your existing function
            renderCart(res);

            // ✅ Open drawer (your existing function)
            setCartOpens(true);

            // ✅ Reset qty
            qty = 1;
            $('#qtyVal').text(1);
        }
    });

});
function money(amount) {
    return '£' + parseFloat(amount).toFixed(2);
}


const setCartOpens = (open) => {
  if (!cartDrawer) return;

  cartDrawer.classList.toggle('is-open', open);
  cartDrawer.setAttribute('aria-hidden', open ? 'false' : 'true');

  if (cartOverlay) cartOverlay.hidden = !open;

  document.documentElement.style.overflow = open ? 'hidden' : '';
};

// ✅ CLOSE: button + overlay + ESC
document.addEventListener('click', function (e) {
  if (e.target.matches('[data-cart-close]') || e.target === cartOverlay) {
    setCartOpens(false);
  }
});

document.addEventListener('keydown', function (e) {
  if (e.key === 'Escape') {
    setCartOpens(false);
  }
});
function renderCart(res) {

    let html = '';

    if (res.items.length > 0) {

        $('#cartDrawerEmpty').attr('hidden', true); // hide empty msg

        res.items.forEach(function (item) {

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
                            <span>${item.qty}</span>
                            <button type="button" data-cart-qty="inc">+</button>
                        </div>

                        <button type="button" class="cart-drawer__remove">Remove</button>
                    </div>
                </div>

                <div class="cart-drawer__price">
                    ${money(item.price * item.qty)}
                </div>

            </div>
            `;
        });

    } else {
        html = '';
        $('#cartDrawerEmpty').removeAttr('hidden'); // show empty msg
    }

    // ✅ Set items
    $('#cartDrawerItems').html(html);

    // ✅ Update subtotal (YOUR MAIN REQUIREMENT 🔥)
    $('#cartDrawerSubtotal').text(money(res.subtotal));

    // ✅ Update cart badge
    $('.cart-badge').text(res.count);
}
</script>
  <script>
    // --- Simple demo cart state (client-side) ---
    const state = {
      items: []
    };

    const product = {
      id: 'antioxidant-gel-cleanser',
      name: 'Antioxidant Gel Cleanser',
      price: 34.95,
      img: document.getElementById('productImg').getAttribute('src')
    };

    const fmt = (n) => `£${n.toFixed(2)}`;

    const overlay = document.getElementById('overlay');
    const drawer = document.getElementById('drawer');
    const bagCount = document.getElementById('bagCount');
    const bagBody = document.getElementById('bagBody');
    const subtotalEl = document.getElementById('subtotal');

    function openDrawer(){
      overlay.classList.add('open');
      drawer.classList.add('open');
      overlay.setAttribute('aria-hidden','false');
      drawer.setAttribute('aria-hidden','false');
      renderBag();
    }
    function closeDrawer(){
      overlay.classList.remove('open');
      drawer.classList.remove('open');
      overlay.setAttribute('aria-hidden','true');
      drawer.setAttribute('aria-hidden','true');
    }

    document.getElementById('openBagBtn').addEventListener('click', openDrawer);
    document.getElementById('closeDrawer').addEventListener('click', closeDrawer);
    overlay.addEventListener('click', closeDrawer);
    document.addEventListener('keydown', (e)=>{ if(e.key==='Escape') closeDrawer(); });

    // Qty controls
    const qtyVal = document.getElementById('qtyVal');
    let qty = 1;
    document.getElementById('qtyMinus').addEventListener('click', ()=>{
      qty = Math.max(1, qty - 1);
      qtyVal.textContent = String(qty);
    });
    document.getElementById('qtyPlus').addEventListener('click', ()=>{
      qty = Math.min(99, qty + 1);
      qtyVal.textContent = String(qty);
    });

    // Add to bag
    document.getElementById('addToBagBtn').addEventListener('click', ()=>{
      const existing = state.items.find(i=>i.id===product.id);
      if(existing){
        existing.qty += qty;
      } else {
        state.items.push({ ...product, qty });
      }
      qty = 1;
      qtyVal.textContent = '1';
      updateCount();
      openDrawer();
    });

    function updateCount(){
      const count = state.items.reduce((a,i)=>a+i.qty,0);
      bagCount.textContent = String(count);
    }

    function calcSubtotal(){
      return state.items.reduce((a,i)=>a + i.price * i.qty, 0);
    }

    function changeItemQty(id, delta){
      const it = state.items.find(i=>i.id===id);
      if(!it) return;
      it.qty = Math.max(1, it.qty + delta);
      renderBag();
      updateCount();
    }

    function removeItem(id){
      state.items = state.items.filter(i=>i.id!==id);
      renderBag();
      updateCount();
    }

    function renderBag(){
      if(state.items.length===0){
        bagBody.innerHTML = `<p style="color:#6b7280; margin:10px 0;">Your bag is empty.</p>`;
        subtotalEl.textContent = fmt(0);
        return;
      }

      bagBody.innerHTML = state.items.map(i=>{
        return `
          <div class="bag-item">
            <div class="bag-thumb"><img src="${i.img}" alt="${i.name}" /></div>
            <div>
              <div class="bag-name">${i.name}</div>
              <div class="bag-controls">
                <div class="mini-qty" aria-label="Item quantity">
                  <button type="button" onclick="changeItemQty('${i.id}', -1)">−</button>
                  <span>${i.qty}</span>
                  <button type="button" onclick="changeItemQty('${i.id}', 1)">+</button>
                </div>
                <button type="button" onclick="removeItem('${i.id}')" style="border:none;background:#fff;color:#ef4444;cursor:pointer;font-weight:800;">🗑</button>
              </div>
            </div>
            <div class="bag-price">${fmt(i.price)}</div>
          </div>
        `;
      }).join('');

      subtotalEl.textContent = fmt(calcSubtotal());
    }

    // init
    updateCount();
  </script>
</body>
</html>