@include('frontend.partials.header')

<style>
.special-hero {
    width: 100%;
    padding: 80px 60px;
    background: #f3f3f5;
}

.special-hero .subtitle {
    font-size: 18px;
    color: #6c63ff;
    letter-spacing: 1px;
    margin-bottom: 20px;
}

.special-hero h1 {
    font-size: 72px;
    line-height: 1.1;
    font-weight: 500;
    color: #0f172a;
    margin-bottom: 40px;
}

.filter-tabs {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.filter-tabs button {
    padding: 14px 28px;
    border-radius: 40px;
    border: none;
    background: #e6e6eb;
    font-size: 18px;
    cursor: pointer;
    transition: 0.3s ease;
}

.filter-tabs button.active {
    background: #111;
    color: #fff;
}

@media (max-width: 992px) {
    .special-hero {
        padding: 60px 30px;
    }

    .special-hero h1 {
        font-size: 48px;
    }

    .filter-tabs {
        gap: 12px;
    }

    .filter-tabs button {
        font-size: 16px;
        padding: 10px 20px;
    }
}

/* Offers grid (below hero) */
.offers-wrap{
    width:100%;
    background:#f6f6f8;
    padding:40px 60px 80px;
}

.offers-banner{
    width:100%;
    background: linear-gradient(90deg, rgba(107,99,255,0.25) 0%, rgba(107,99,255,0.10) 45%, rgba(107,99,255,0.25) 100%);
    border-radius:0;
    padding:26px 28px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:24px;
}

.offers-banner .left{
    display:flex;
    flex-direction:column;
    gap:6px;
}
.offers-banner .left .kicker{
    font-size:16px;
    font-weight:700;
    letter-spacing:1.2px;
    color:#111;
    text-transform:uppercase;
}
.offers-banner .left .title{
    font-size:44px;
    line-height:1.05;
    font-weight:700;
    color:#111;
}
.offers-banner .left .sub{
    font-size:16px;
    letter-spacing:1.2px;
    color:#111;
    text-transform:uppercase;
    opacity:0.8;
}

.offers-banner .price{
    display:flex;
    align-items:flex-end;
    gap:14px;
    color:#111;
    white-space:nowrap;
}
.offers-banner .price .fromOnly{
    font-size:12px;
    font-weight:700;
    letter-spacing:1px;
    text-transform:uppercase;
    opacity:0.85;
}
.offers-banner .price .big{
    font-size:86px;
    line-height:0.9;
    font-weight:800;
}
.offers-banner .price .per{
    font-size:12px;
    font-weight:700;
    letter-spacing:1px;
    text-transform:uppercase;
    opacity:0.85;
    padding-bottom:10px;
}

.offers-banner .cta{
    padding:14px 28px;
    border-radius:999px;
    border:none;
    background:#6c63ff;
    color:#fff;
    font-size:18px;
    font-weight:700;
    cursor:pointer;
}

.offer-grid{
    width:100%;
    display:grid;
    grid-template-columns:repeat(4, 1fr);
    gap:0;
    border:1px solid #e7e7ee;
    border-top:none;
    background:#fff;
}

.offer-card{
    border-right:1px solid #e7e7ee;
    display:flex;
    flex-direction:column;
    min-height:560px;
}
.offer-card:last-child{border-right:none;}

.offer-card .media{
    position:relative;
    height:280px;
    overflow:hidden;
    background:#ddd;
}
.offer-card .media img{
    width:100%;
    height:100%;
    object-fit:cover;
    display:block;
}
.offer-card .media::after{
    content:"";
    position:absolute;
    inset:0;
    background:linear-gradient(180deg, rgba(0,0,0,0.05) 0%, rgba(0,0,0,0.45) 60%, rgba(0,0,0,0.55) 100%);
}

.offer-tag{
    position:absolute;
    top:14px;
    left:14px;
    z-index:2;
    font-size:14px;
    padding:8px 12px;
    border-radius:999px;
    font-weight:700;
    color:#fff;
    background:#e11d48;
}
.offer-pill{
    position:absolute;
    top:14px;
    right:14px;
    z-index:2;
    font-size:14px;
    padding:7px 12px;
    border-radius:999px;
    font-weight:700;
    color:#fff;
    background:rgba(17,17,17,0.45);
    border:1px solid rgba(255,255,255,0.35);
    backdrop-filter: blur(6px);
}

.offer-headline{
    position:absolute;
    left:18px;
    right:18px;
    bottom:16px;
    z-index:2;
    color:#fff;
}
.offer-headline h3{
    margin:0;
    font-size:40px;
    line-height:1.05;
    font-weight:500;
}
.offer-headline .cat{
    margin-top:10px;
    font-size:16px;
    font-weight:600;
    opacity:0.95;
}

.offer-body{
    padding:22px 22px 26px;
    display:flex;
    flex-direction:column;
    gap:14px;
    flex:1;
}

.price-row{
    display:flex;
    align-items:flex-end;
    gap:14px;
}
.price-row .from{
    font-size:14px;
    color:#6b7280;
}
.price-row .price{
    font-size:44px;
    font-weight:800;
    color:#0f172a;
    line-height:1;
}
.price-row .price small{
    font-size:16px;
    font-weight:700;
}
.price-row .was{
    font-size:14px;
    color:#ef4444;
    text-decoration: line-through;
    font-weight:700;
    padding-bottom:8px;
}

.offer-desc{
    color:#6b7280;
    font-size:16px;
    line-height:1.6;
    margin:0;
}

.offer-actions{
    margin-top:auto;
}
.offer-actions a{
    display:inline-block;
    padding:12px 22px;
    border-radius:999px;
    background:#6c63ff;
    color:#fff;
    text-decoration:none;
    font-weight:700;
}

@media (max-width: 1200px){
    .offer-grid{grid-template-columns:repeat(2, 1fr);}
    .offer-card{border-right:none; border-bottom:1px solid #e7e7ee;}
    .offer-card:nth-child(2n+1){border-right:1px solid #e7e7ee;}
    .offer-card:nth-last-child(-n+2){border-bottom:none;}
}

@media (max-width: 768px){
    .offers-wrap{padding:28px 16px 60px;}
    .offers-banner{flex-direction:column; align-items:flex-start;}
    .offers-banner .left .title{font-size:34px;}
    .offers-banner .price .big{font-size:72px;}
    .offer-grid{grid-template-columns:1fr;}
    .offer-card{border-right:none; border-bottom:1px solid #e7e7ee;}
    .offer-card:last-child{border-bottom:none;}
    .offer-headline h3{font-size:34px;}
}
</style>

<section class="special-hero">
    <div class="subtitle">Special Offers</div>
    <h1>Save up to 75% on Treatments!</h1>

    <div class="filter-tabs">
        <button class="active">All</button>
        <button>Cosmetic Injections</button>
        <button>Laser Hair Removal</button>
        <button>Skin Treatments</button>
        <button>Body</button>
    </div>
</section>

<section class="offers-wrap">
    <div class="offers-banner">
        <div class="left">
            <div class="kicker">NEW</div>
            <div class="title">Anti-Wrinkle Subscription</div>
            <div class="sub">3 AREAS X 3 TIMES ANNUALLY + £99 SIGN UP FEE</div>
        </div>

        <div class="price">
            <div>
                <div class="fromOnly">£ FROM ONLY</div>
            </div>
            <div class="big">45</div>
            <div class="per">PER MONTH</div>
        </div>

        <button class="cta" type="button">Book now</button>
    </div>

    <div class="offer-grid">
        <!-- Card 1 -->
        <article class="offer-card">
            <div class="media">
                <span class="offer-tag">New Client Offer!</span>
                <span class="offer-pill">Anti-Wrinkle</span>
                <img src="https://therapieclinic.com/_next/image?url=%2Fassets%2Foffers%2Foffers%2Fevegrn-anti-wrinkle-exiting.webp&w=1536&q=75" alt="3 Area Package" />
                <div class="offer-headline">
                    <h3>3 Area Package</h3>
                    <div class="cat">Anti-Wrinkle Injections</div>
                </div>
            </div>
            <div class="offer-body">
                <div class="price-row">
                    <div>
                        <div class="from">From</div>
                        <div class="price">£189<small>.00</small></div>
                    </div>
                    <div class="was">WAS £245.00</div>
                </div>
                <p class="offer-desc">New Client Offer! Anti-wrinkle injections are administered in precise doses to targeted areas on the face by our doctor-led team.</p>
                <div class="offer-actions">
                    <a href="#">Book now</a>
                </div>
            </div>
        </article>

        <!-- Card 2 -->
        <article class="offer-card">
            <div class="media">
                <span class="offer-pill">Laser Hair Removal</span>
                <img src="https://therapieclinic.com/_next/image?url=%2Fassets%2Foffers%2Foffers%2FusBodyFace.webp&w=1536&q=75" alt="Full Body (excluding face)" />
                <div class="offer-headline">
                    <h3>Full Body (excluding face)</h3>
                    <div class="cat">Laser Hair Removal</div>
                </div>
            </div>
            <div class="offer-body">
                <div class="price-row">
                    <div>
                        <div class="from">From</div>
                        <div class="price">£129<small>.95</small></div>
                    </div>
                </div>
                <p class="offer-desc">Experience head-to-toe smoothness with our full-body laser hair removal treatment, designed for long-lasting results and effortlessly silky skin.</p>
                <div class="offer-actions">
                    <a href="#">Buy now</a>
                </div>
            </div>
        </article>

        <!-- Card 3 -->
        <article class="offer-card">
            <div class="media">
                <span class="offer-tag" style="background:#ef4444;">3 for 2!</span>
                <span class="offer-pill">Anti-Wrinkle</span>
                <img src="https://therapieclinic.com/_next/image?url=%2Fassets%2Foffers%2Foffers%2Fvi-peel.webp&w=1536&q=75" alt="Buy 2 Areas, Get 1 FREE" />
                <div class="offer-headline">
                    <h3>Buy 2 Areas, Get 1 FREE</h3>
                    <div class="cat">Anti-Wrinkle Injections</div>
                </div>
            </div>
            <div class="offer-body">
                <div class="price-row">
                    <div>
                        <div class="from">From</div>
                        <div class="price">£245<small>.00</small></div>
                    </div>
                    <div class="was">WAS £344.00</div>
                </div>
                <p class="offer-desc">Administered by our experienced, doctor-led team, anti-wrinkle injections are precisely targeted to refresh and rejuvenate your facial features.</p>
                <div class="offer-actions">
                    <a href="#">Book now</a>
                </div>
            </div>
        </article>

        <!-- Card 4 -->
        <article class="offer-card">
            <div class="media">
                <span class="offer-pill">Laser Hair Removal</span>
                <img src="https://therapieclinic.com/_next/image?url=%2Fassets%2Foffers%2Foffers%2Flower-legs-any-bikini-underarms.webp&w=1536&q=75" alt="Any Bikini & Underarm" />
                <div class="offer-headline">
                    <h3>Any Bikini &amp; Underarm</h3>
                    <div class="cat">Laser Hair Removal</div>
                </div>
            </div>
            <div class="offer-body">
                <div class="price-row">
                    <div>
                        <div class="from">From</div>
                        <div class="price">£29<small>.95</small></div>
                    </div>
                </div>
                <p class="offer-desc">Achieve a flawlessly smooth bikini line and underarms with our advanced laser hair removal treatment.</p>
                <div class="offer-actions">
                    <a href="#">Buy now</a>
                </div>
            </div>
        </article>
    </div>
</section>

@include('frontend.partials.footer')