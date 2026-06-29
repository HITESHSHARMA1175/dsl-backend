<?php
  // Home page
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>DSL Clinic</title>
  <meta name="description" content="DSL Clinic - Premium treatments and consultations." />

  <!-- If you already load Inter elsewhere, you can remove this -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

  <style>
    :root{
      --page-bg:#ffffff;
      --ink:#0b1b2a;
      --muted:#516072;
      --line:rgba(11,27,42,.10);
      --cta:#6b5bd2;
      --cta2:#7a6be6;
      --dark:#0b0b0b;
    }
    *{box-sizing:border-box}
    body{margin:0; font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif; background:var(--page-bg); color:var(--ink);}
    a{color:inherit; text-decoration:none}
    main{display:block}

    /* Offers section */
    .offers{
      background:var(--dark);
      color:#fff;
      padding:56px 0 44px;
    }
    .offers__inner{
      width:100%;
      max-width:100%;
      margin:0;
      padding:0 40px;
    }
    .offers__kicker{
      margin:0 0 10px;
      font-weight:800;
      letter-spacing:.22em;
      text-transform:uppercase;
      font-size:14px;
      color:rgba(255,255,255,.75);
    }
    .offers__head{
      display:flex;
      align-items:flex-end;
      justify-content:space-between;
      gap:18px;
      margin-bottom:22px;
    }
    .offers__title{
      margin:0;
      font-family: ui-serif, Georgia, "Times New Roman", Times, serif;
      font-weight:500;
      font-size:64px;
      line-height:1.02;
      letter-spacing:-.02em;
    }
    .offers__controls{
      display:flex;
      align-items:center;
      gap:10px;
      flex:0 0 auto;
    }
    .offers__viewall{
      color:rgba(255,255,255,.75);
      font-weight:700;
      text-decoration:underline;
      text-underline-offset:4px;
    }
    .offers__btn{
      width:44px;
      height:44px;
      border-radius:999px;
      border:1px solid rgba(255,255,255,.22);
      background:rgba(255,255,255,.06);
      color:#fff;
      display:inline-flex;
      align-items:center;
      justify-content:center;
      cursor:pointer;
      transition:transform .15s ease, background .15s ease, border-color .15s ease;
    }
    .offers__btn:hover{transform:translateY(-1px); background:rgba(255,255,255,.09); border-color:rgba(255,255,255,.30);}

    .carousel{
      position:relative;
    }
    .carousel__track{
      display:flex;
      gap:18px;
      overflow:auto;
      scroll-snap-type:x mandatory;
      -webkit-overflow-scrolling:touch;
      padding-bottom:16px;
    }
    .carousel__track::-webkit-scrollbar{height:8px;}
    .carousel__track::-webkit-scrollbar-thumb{background:rgba(255,255,255,.18); border-radius:999px;}
    .carousel__track::-webkit-scrollbar-track{background:rgba(255,255,255,.06); border-radius:999px;}

    .offer{
      flex:0 0 min(420px, 86vw);
      scroll-snap-align:start;
      border-radius:16px;
      overflow:hidden;
      background:rgba(255,255,255,.04);
      border:1px solid rgba(255,255,255,.10);
      position:relative;
      min-height:520px;
      box-shadow:0 28px 60px rgba(0,0,0,.35);
    }

    /* Original placeholder visual (no hotlink) */
    .offer__media{
      position:absolute;
      inset:0;
      background:
        radial-gradient(900px 520px at 20% 20%, rgba(255,255,255,.20), transparent 55%),
        radial-gradient(700px 420px at 80% 10%, rgba(107,91,210,.35), transparent 55%),
        linear-gradient(135deg, rgba(255,255,255,.08), rgba(255,255,255,.02));
    }
    .offer__media::after{
      content:"";
      position:absolute;
      inset:0;
      background:linear-gradient(180deg, rgba(0,0,0,.12), rgba(0,0,0,.75) 70%, rgba(0,0,0,.88));
    }

    .offer__tag{
      position:absolute;
      top:14px;
      left:14px;
      z-index:2;
      padding:6px 10px;
      border-radius:999px;
      font-weight:800;
      font-size:12px;
      color:#fff;
      background:rgba(231, 76, 60, .95);
      box-shadow:0 10px 22px rgba(0,0,0,.35);
    }

    .offer__body{
      position:absolute;
      left:22px;
      right:22px;
      bottom:22px;
      z-index:2;
    }

    .offer__category{
      margin:0 0 10px;
      font-weight:800;
      font-size:16px;
      letter-spacing:.02em;
      color:rgba(255,255,255,.86);
    }

    .offer__name{
      margin:0 0 14px;
      font-family: ui-serif, Georgia, "Times New Roman", Times, serif;
      font-size:44px;
      line-height:1.05;
      font-weight:500;
      letter-spacing:-.02em;
    }

    .offer__priceRow{
      display:flex;
      align-items:flex-end;
      gap:12px;
      flex-wrap:wrap;
      margin:0 0 16px;
    }

    .offer__from{
      font-size:12px;
      font-weight:900;
      letter-spacing:.18em;
      text-transform:uppercase;
      color:rgba(255,255,255,.70);
      width:100%;
      margin-bottom:-6px;
    }

    .offer__price{
      font-family: ui-serif, Georgia, "Times New Roman", Times, serif;
      font-size:52px;
      line-height:1;
      font-weight:500;
    }

    .offer__price small{font-size:20px; opacity:.85;}

    .offer__was{
      color:rgba(255,255,255,.62);
      font-weight:700;
      font-size:14px;
      text-decoration:line-through;
      text-decoration-thickness:2px;
      text-underline-offset:2px;
      transform:translateY(-6px);
    }

    .offer__cta{
      display:inline-flex;
      align-items:center;
      justify-content:center;
      height:46px;
      padding:0 22px;
      border-radius:999px;
      font-weight:800;
      font-size:14px;
      color:#fff;
      background:linear-gradient(135deg, var(--cta), var(--cta2));
      box-shadow:0 16px 34px rgba(107,91,210,.30);
      border:1px solid rgba(255,255,255,.12);
      transition:transform .15s ease, filter .15s ease;
    }
    .offer__cta:hover{transform:translateY(-1px); filter:saturate(1.05) brightness(1.05);}

    .carousel__dots{
      display:flex;
      justify-content:center;
      gap:10px;
      margin-top:18px;
    }
    .dot{
      width:72px;
      height:3px;
      border-radius:999px;
      background:rgba(255,255,255,.18);
    }
    .dot.is-active{background:rgba(255,255,255,.70);}

    @media (max-width: 980px){
      .offers{padding:44px 0 36px;}
      .offers__title{font-size:46px;}
      .offer{min-height:500px;}
    }

    @media (max-width: 560px){
      .offers__inner{padding:0 16px;}
      .offers__head{align-items:flex-start;}
      .offers__title{font-size:40px;}
      .offers__controls{gap:8px;}
      .offers__btn{width:42px; height:42px;}
      .offer__name{font-size:36px;}
      .offer__price{font-size:46px;}
      .dot{width:56px;}
    }

    /* Full-width promo banner (anti-wrinkle subscription style) */
    .promo{
      width:100%;
      background:#0b0b0b;
      padding:0;
    }

    .promo__surface{
      width:100%;
      background:linear-gradient(180deg, rgba(255,255,255,.05), rgba(255,255,255,0)),
                 radial-gradient(900px 420px at 50% 10%, rgba(255,255,255,.08), transparent 60%),
                 #3d385b;
      border-top:1px solid rgba(255,255,255,.10);
      border-bottom:1px solid rgba(255,255,255,.10);
      padding:92px 0;
    }

    .promo__inner{
      width:100%;
      max-width:100%;
      margin:0;
      padding:0 40px;
      display:flex;
      align-items:center;
      justify-content:center;
      text-align:center;
    }

    .promo__content{max-width:980px;}

    .promo__eyebrow{
      margin:0 0 18px;
      text-transform:uppercase;
      letter-spacing:.28em;
      font-weight:900;
      font-size:14px;
      color:rgba(255,255,255,.78);
    }

    .promo__title{
      margin:0 0 28px;
      font-family: ui-serif, Georgia, "Times New Roman", Times, serif;
      font-weight:500;
      font-size:76px;
      line-height:1.02;
      letter-spacing:-.02em;
      color:#fff;
    }

    .promo__cta{
      display:inline-flex;
      align-items:center;
      justify-content:center;
      height:52px;
      padding:0 34px;
      border-radius:999px;
      font-weight:800;
      font-size:15px;
      color:#fff;
      background:linear-gradient(135deg, var(--cta), var(--cta2));
      border:1px solid rgba(255,255,255,.14);
      box-shadow:0 18px 40px rgba(107,91,210,.28);
      transition:transform .15s ease, filter .15s ease;
    }
    .promo__cta:hover{transform:translateY(-1px); filter:brightness(1.06) saturate(1.05);}

    @media (max-width: 980px){
      .promo__surface{padding:78px 0;}
      .promo__title{font-size:56px;}
    }

    @media (max-width: 560px){
      .promo__inner{padding:0 16px;}
      .promo__surface{padding:64px 0;}
      .promo__title{font-size:44px;}
      .promo__cta{height:50px; padding:0 28px;}
    }

    /* Treatments carousel (full width, premium clean) */
    .treatments{
      width:100%;
      background:#ffffff;
      padding:56px 0 54px;
    }

    .treatments__inner{
      width:100%;
      max-width:100%;
      margin:0;
      padding:0 40px;
    }

    .treatments__kicker{
      margin:0 0 10px;
      font-weight:800;
      letter-spacing:.22em;
      text-transform:uppercase;
      font-size:14px;
      color:#6b5bd2;
    }

    .treatments__head{
      display:flex;
      align-items:flex-end;
      justify-content:space-between;
      gap:18px;
      margin-bottom:22px;
    }

    .treatments__title{
      margin:0;
      font-family: ui-serif, Georgia, "Times New Roman", Times, serif;
      font-weight:500;
      font-size:64px;
      line-height:1.02;
      letter-spacing:-.02em;
      color:var(--ink);
    }

    .treatments__controls{
      display:flex;
      align-items:center;
      gap:10px;
      flex:0 0 auto;
    }

    .treatments__btn{
      width:44px;
      height:44px;
      border-radius:999px;
      border:1px solid rgba(11,27,42,.12);
      background:#f2f3f6;
      color:var(--ink);
      display:inline-flex;
      align-items:center;
      justify-content:center;
      cursor:pointer;
      transition:transform .15s ease, background .15s ease, border-color .15s ease;
    }
    .treatments__btn:hover{transform:translateY(-1px); background:#eceef3; border-color:rgba(11,27,42,.18);}

    .tcarousel__track{
      display:flex;
      gap:18px;
      overflow:auto;
      scroll-snap-type:x mandatory;
      -webkit-overflow-scrolling:touch;
      padding-bottom:16px;
    }

    .tcarousel__track::-webkit-scrollbar{height:8px;}
    .tcarousel__track::-webkit-scrollbar-thumb{background:rgba(11,27,42,.18); border-radius:999px;}
    .tcarousel__track::-webkit-scrollbar-track{background:rgba(11,27,42,.06); border-radius:999px;}

    .tcard{
      flex:0 0 min(520px, 90vw);
      scroll-snap-align:start;
      border-radius:18px;
      overflow:hidden;
      position:relative;
      height:520px;
      background:#e9e9ee;
      border:1px solid rgba(11,27,42,.10);
      box-shadow:0 22px 52px rgba(11,27,42,.14);
    }

    /* Original placeholder “photo-like” surface */
    .tcard__media{
      position:absolute;
      inset:0;
      background:
        radial-gradient(700px 520px at 30% 20%, rgba(255,255,255,.60), rgba(255,255,255,0) 60%),
        radial-gradient(600px 420px at 80% 10%, rgba(107,91,210,.38), rgba(107,91,210,0) 60%),
        linear-gradient(135deg, rgba(0,0,0,.08), rgba(0,0,0,0));
    }
    .tcard__media::after{
      content:"";
      position:absolute;
      inset:0;
      background:linear-gradient(180deg, rgba(0,0,0,.06), rgba(0,0,0,.52) 72%, rgba(0,0,0,.70));
    }

    .tcard__body{
      position:absolute;
      left:22px;
      right:22px;
      bottom:22px;
      z-index:2;
      color:#fff;
    }

    .tcard__title{
      margin:0 0 16px;
      font-family: ui-serif, Georgia, "Times New Roman", Times, serif;
      font-size:52px;
      line-height:1.04;
      font-weight:500;
      letter-spacing:-.02em;
      text-shadow:0 14px 40px rgba(0,0,0,.40);
    }

    .tcard__cta{
      display:inline-flex;
      align-items:center;
      justify-content:center;
      height:46px;
      padding:0 22px;
      border-radius:999px;
      font-weight:800;
      font-size:14px;
      color:var(--ink);
      background:#ffffff;
      border:1px solid rgba(255,255,255,.65);
      box-shadow:0 18px 40px rgba(0,0,0,.22);
      transition:transform .15s ease, filter .15s ease;
    }
    .tcard__cta:hover{transform:translateY(-1px); filter:brightness(1.02);}

    .treatments__dots{
      display:flex;
      justify-content:center;
      gap:10px;
      margin-top:18px;
    }

    .tdot{
      width:72px;
      height:3px;
      border-radius:999px;
      background:rgba(11,27,42,.14);
    }
    .tdot.is-active{background:rgba(11,27,42,.42);}

    @media (max-width: 980px){
      .treatments{padding:44px 0 44px;}
      .treatments__title{font-size:46px;}
      .tcard{height:500px;}
      .tcard__title{font-size:44px;}
    }

    @media (max-width: 560px){
      .treatments__inner{padding:0 16px;}
      .treatments__head{align-items:flex-start;}
      .treatments__title{font-size:40px;}
      .treatments__btn{width:42px; height:42px;}
      .tcard{height:460px;}
      .tcard__title{font-size:38px;}
      .tdot{width:56px;}
    }
    /* Personalised plans CTA (full width, dark, centered) */
    .plans{
      width:100%;
      background:var(--dark);
      color:#fff;
      padding:0;
    }

    .plans__surface{
      width:100%;
      background:
        radial-gradient(900px 520px at 50% 18%, rgba(255,255,255,.06), transparent 60%),
        linear-gradient(180deg, rgba(255,255,255,.04), rgba(255,255,255,0) 35%),
        var(--dark);
      border-top:1px solid rgba(255,255,255,.10);
      border-bottom:1px solid rgba(255,255,255,.10);
      padding:96px 0 94px;
    }

    .plans__inner{
      width:100%;
      max-width:100%;
      margin:0;
      padding:0 40px;
      display:flex;
      justify-content:center;
      text-align:center;
    }

    .plans__content{max-width:980px;}

    .plans__kicker{
      margin:0 0 22px;
      text-transform:uppercase;
      letter-spacing:.32em;
      font-weight:900;
      font-size:13px;
      color:rgba(107,91,210,.95);
    }

    .plans__title{
      margin:0 0 34px;
      font-family: ui-serif, Georgia, "Times New Roman", Times, serif;
      font-weight:500;
      font-size:74px;
      line-height:1.03;
      letter-spacing:-.02em;
      color:#fff;
    }

    .plans__title em{
      font-style:italic;
      font-weight:500;
    }

    .plans__cta{
      display:inline-flex;
      align-items:center;
      justify-content:center;
      height:56px;
      padding:0 34px;
      border-radius:999px;
      font-weight:800;
      font-size:15px;
      color:#fff;
      background:transparent;
      border:1.5px solid rgba(255,255,255,.55);
      box-shadow:0 18px 44px rgba(0,0,0,.28);
      transition:transform .15s ease, background .15s ease, border-color .15s ease;
    }

    .plans__cta:hover{
      transform:translateY(-1px);
      background:rgba(255,255,255,.06);
      border-color:rgba(255,255,255,.70);
    }

    @media (max-width: 980px){
      .plans__surface{padding:78px 0 76px;}
      .plans__title{font-size:54px;}
    }

    @media (max-width: 560px){
      .plans__inner{padding:0 16px;}
      .plans__surface{padding:64px 0 62px;}
      .plans__title{font-size:42px;}
      .plans__cta{height:54px; padding:0 28px;}
    }
    /* Proof / stats + reels grid (full width) */
    .proof{width:100%; background:#ffffff;}

    .stats{
      width:100%;
      background:#f3f4f8;
      border-top:1px solid rgba(11,27,42,.08);
      border-bottom:1px solid rgba(11,27,42,.08);
      padding:44px 0 40px;
    }

    .stats__inner{
      width:100%;
      max-width:100%;
      margin:0;
      padding:0 40px;
    }

    .stats__grid{
      display:grid;
      grid-template-columns:repeat(4, minmax(0, 1fr));
      gap:26px;
      align-items:end;
    }

    .stat{display:flex; flex-direction:column; gap:10px; text-align:center;}

    .stat__value{
      margin:0;
      font-family: ui-serif, Georgia, "Times New Roman", Times, serif;
      font-weight:500;
      font-size:72px;
      line-height:1;
      letter-spacing:-.02em;
      color:var(--ink);
    }

    .stat__label{
      margin:0;
      text-transform:uppercase;
      letter-spacing:.18em;
      font-weight:900;
      font-size:12px;
      color:rgba(11,27,42,.58);
    }

    .reels{
      width:100%;
      background:#ffffff;
      padding:0;
    }

    .reels__inner{
      width:100%;
      max-width:100%;
      margin:0;
      padding:0;
    }

    .reels__grid{
      display:grid;
      grid-template-columns:repeat(4, minmax(0, 1fr));
      gap:8px;
      padding:0 40px 54px;
    }

    .reel{
      position:relative;
      border-radius:18px;
      overflow:hidden;
      aspect-ratio: 4 / 5;
      background:#e7e7ee;
      border:1px solid rgba(11,27,42,.10);
      box-shadow:0 18px 48px rgba(11,27,42,.10);
      cursor:pointer;
      display:block;
    }

    /* “Video-like” original placeholders */
    .reel__media{
      position:absolute; inset:0;
      background:
        radial-gradient(900px 620px at 30% 25%, rgba(255,255,255,.55), rgba(255,255,255,0) 62%),
        radial-gradient(700px 520px at 80% 20%, rgba(107,91,210,.35), rgba(107,91,210,0) 62%),
        linear-gradient(135deg, rgba(0,0,0,.08), rgba(0,0,0,0));
      transform:scale(1.02);
      transition:transform .25s ease;
    }

    .reel__media::after{
      content:"";
      position:absolute; inset:0;
      background:linear-gradient(180deg, rgba(0,0,0,.10), rgba(0,0,0,.35) 55%, rgba(0,0,0,.55));
    }

    .reel:hover .reel__media{transform:scale(1.06);}

    .reel__play{
      position:absolute;
      left:50%; top:50%;
      transform:translate(-50%, -50%);
      width:64px; height:64px;
      border-radius:999px;
      background:rgba(0,0,0,.35);
      border:1px solid rgba(255,255,255,.35);
      display:flex;
      align-items:center;
      justify-content:center;
      backdrop-filter: blur(6px);
      box-shadow:0 18px 44px rgba(0,0,0,.25);
      z-index:2;
    }

    .reel__play svg{width:20px; height:20px; fill:#fff; transform:translateX(2px);}

    .reel__caption{
      position:absolute;
      left:16px; right:16px; bottom:14px;
      color:#fff;
      z-index:2;
      font-weight:800;
      font-size:14px;
      letter-spacing:.01em;
      text-shadow:0 10px 24px rgba(0,0,0,.35);
    }

    /* Modal */
    .vmodal{position:fixed; inset:0; z-index:5000; display:none;}
    .vmodal.is-open{display:block;}
    .vmodal__backdrop{position:absolute; inset:0; background:rgba(0,0,0,.62);}
    .vmodal__panel{
      position:absolute;
      left:50%; top:50%;
      transform:translate(-50%, -50%);
      width:min(920px, 92vw);
      background:#0b0b0b;
      border:1px solid rgba(255,255,255,.12);
      border-radius:18px;
      box-shadow:0 30px 80px rgba(0,0,0,.50);
      overflow:hidden;
    }
    .vmodal__top{
      display:flex; align-items:center; justify-content:space-between;
      padding:14px 16px;
      border-bottom:1px solid rgba(255,255,255,.10);
      color:#fff;
    }
    .vmodal__title{margin:0; font-weight:800; font-size:14px; letter-spacing:.14em; text-transform:uppercase; opacity:.9;}
    .vmodal__close{
      width:44px; height:44px;
      border-radius:14px;
      border:1px solid rgba(255,255,255,.14);
      background:rgba(255,255,255,.06);
      color:#fff;
      cursor:pointer;
      font-size:18px;
    }
    .vmodal__body{padding:0; aspect-ratio:16/9; position:relative;}
    .vmodal__placeholder{
      position:absolute; inset:0;
      display:flex; flex-direction:column;
      align-items:center; justify-content:center;
      gap:10px;
      color:rgba(255,255,255,.85);
      text-align:center;
      padding:28px;
      background:
        radial-gradient(900px 520px at 30% 20%, rgba(255,255,255,.10), transparent 60%),
        radial-gradient(700px 420px at 80% 10%, rgba(107,91,210,.25), transparent 60%),
        #0b0b0b;
    }
    .vmodal__placeholder strong{color:#fff; font-size:18px;}
    .vmodal__placeholder p{margin:0; max-width:560px; line-height:1.5;}

    @media (max-width: 980px){
      .stats__grid{grid-template-columns:repeat(2, minmax(0, 1fr));}
      .stat__value{font-size:60px;}
      .reels__grid{grid-template-columns:repeat(2, minmax(0, 1fr)); padding:0 16px 44px;}
      .stats__inner{padding:0 16px;}
    }

    @media (max-width: 560px){
      .stats{padding:34px 0 30px;}
      .stat__value{font-size:52px;}
      .reels__grid{gap:10px;}
      .reel{border-radius:16px;}
    }

    /* Therapy-for-all style statement (full width, lilac) */
    .story{
      width:100%;
      background:#7f7fe6; /* premium lilac */
      color:#fff;
      padding:0;
    }

    .story__surface{
      width:100%;
      padding:96px 0 92px;
      background:
        radial-gradient(900px 520px at 20% 10%, rgba(255,255,255,.12), transparent 60%),
        radial-gradient(900px 520px at 80% 0%, rgba(0,0,0,.08), transparent 58%),
        linear-gradient(180deg, rgba(255,255,255,.04), rgba(255,255,255,0) 55%),
        #7f7fe6;
    }

    .story__inner{
      width:100%;
      max-width:100%;
      margin:0;
      padding:0 40px;
    }

    .story__kicker{
      margin:0 0 24px;
      font-weight:600;
      font-size:28px;
      letter-spacing:-.01em;
      opacity:.95;
    }

    .story__title{
      margin:0;
      font-family: ui-serif, Georgia, "Times New Roman", Times, serif;
      font-weight:500;
      font-size:84px;
      line-height:1.04;
      letter-spacing:-.02em;
      max-width:1320px;
    }

    .story__title em{
      font-style:italic;
      font-weight:500;
      opacity:.98;
    }

    .story__ctaRow{margin-top:34px;}

    .story__cta{
      display:inline-flex;
      align-items:center;
      justify-content:center;
      height:54px;
      padding:0 28px;
      border-radius:999px;
      font-weight:800;
      font-size:15px;
      color:#fff;
      background:transparent;
      border:1.6px solid rgba(255,255,255,.55);
      box-shadow:0 18px 44px rgba(0,0,0,.18);
      transition:transform .15s ease, background .15s ease, border-color .15s ease;
    }

    .story__cta:hover{
      transform:translateY(-1px);
      background:rgba(255,255,255,.08);
      border-color:rgba(255,255,255,.75);
    }

    @media (max-width: 980px){
      .story__surface{padding:78px 0 74px;}
      .story__kicker{font-size:22px;}
      .story__title{font-size:58px;}
    }

    @media (max-width: 560px){
      .story__inner{padding:0 16px;}
      .story__surface{padding:62px 0 58px;}
      .story__kicker{font-size:18px; margin-bottom:18px;}
      .story__title{font-size:40px; line-height:1.06;}
      .story__cta{height:52px; padding:0 22px; font-size:14px;}
    }

    /* What's new and trending / Featured at Thérapie (full width, 3 cards) */
    .featured{
      width:100%;
      background:#ffffff;
      padding:58px 0 64px;
    }

    .featured__inner{
      width:100%;
      max-width:100%;
      margin:0;
      padding:0 40px;
    }

    .featured__kicker{
      margin:0 0 10px;
      font-weight:800;
      letter-spacing:.22em;
      text-transform:uppercase;
      font-size:14px;
      color:#6b5bd2;
    }

    .featured__title{
      margin:0 0 26px;
      font-family: ui-serif, Georgia, "Times New Roman", Times, serif;
      font-weight:500;
      font-size:64px;
      line-height:1.02;
      letter-spacing:-.02em;
      color:var(--ink);
    }

    .featured__grid{
      display:grid;
      grid-template-columns:repeat(3, minmax(0, 1fr));
      gap:18px;
      align-items:stretch;
    }

    .fcard{
      position:relative;
      border-radius:18px;
      overflow:hidden;
      min-height:520px;
      background:#e9e9ee;
      border:1px solid rgba(11,27,42,.10);
      box-shadow:0 22px 52px rgba(11,27,42,.12);
      isolation:isolate;
    }

    /* default media (can be overridden via style="background-image:url(...)" ) */
    .fcard__media{
      position:absolute;
      inset:0;
      background:
        radial-gradient(900px 620px at 30% 25%, rgba(255,255,255,.55), rgba(255,255,255,0) 62%),
        radial-gradient(700px 520px at 82% 18%, rgba(107,91,210,.30), rgba(107,91,210,0) 62%),
        linear-gradient(135deg, rgba(0,0,0,.10), rgba(0,0,0,0));
      background-size:cover;
      background-position:center;
      transform:scale(1.01);
      transition:transform .25s ease;
    }

    .fcard:hover .fcard__media{transform:scale(1.05);}

    .fcard__media::after{
      content:"";
      position:absolute;
      inset:0;
      background:linear-gradient(180deg, rgba(0,0,0,.12), rgba(0,0,0,.30) 48%, rgba(0,0,0,.55));
      z-index:0;
    }

    .fcard__tag{
      position:absolute;
      top:14px;
      left:14px;
      z-index:2;
      padding:6px 10px;
      border-radius:999px;
      font-weight:900;
      font-size:12px;
      letter-spacing:.02em;
      color:#fff;
      background:rgba(231, 76, 60, .95);
      box-shadow:0 12px 28px rgba(0,0,0,.25);
      user-select:none;
    }

    .fcard__body{
      position:absolute;
      left:22px;
      right:22px;
      bottom:22px;
      z-index:2;
      color:#fff;
    }

    .fcard__headline{
      margin:0 0 18px;
      font-family: ui-serif, Georgia, "Times New Roman", Times, serif;
      font-weight:500;
      font-size:52px;
      line-height:1.04;
      letter-spacing:-.02em;
      text-shadow:0 14px 40px rgba(0,0,0,.35);
      max-width:520px;
    }

    .fcard__cta{
      display:inline-flex;
      align-items:center;
      justify-content:center;
      height:46px;
      padding:0 22px;
      border-radius:999px;
      font-weight:800;
      font-size:14px;
      color:var(--ink);
      background:#ffffff;
      border:1px solid rgba(255,255,255,.70);
      box-shadow:0 18px 40px rgba(0,0,0,.18);
      transition:transform .15s ease, filter .15s ease;
    }

    .fcard__cta:hover{transform:translateY(-1px); filter:brightness(1.02);}

    .fcard__media::after{
      content:"";
      position:absolute;
      inset:0;
      background:linear-gradient(180deg, rgba(0,0,0,.12), rgba(0,0,0,.30) 48%, rgba(0,0,0,.55));
      z-index:0;
    }

    .fcard__tag{
      position:absolute;
      top:14px;
      left:14px;
      z-index:2;
      padding:6px 10px;
      border-radius:999px;
      font-weight:900;
      font-size:12px;
      letter-spacing:.02em;
      color:#fff;
      background:rgba(231, 76, 60, .95);
      box-shadow:0 12px 28px rgba(0,0,0,.25);
      user-select:none;
    }

    .fcard__body{
      position:absolute;
      left:22px;
      right:22px;
      bottom:22px;
      z-index:2;
      color:#fff;
    }

    .fcard__headline{
      margin:0 0 18px;
      font-family: ui-serif, Georgia, "Times New Roman", Times, serif;
      font-weight:500;
      font-size:52px;
      line-height:1.04;
      letter-spacing:-.02em;
      text-shadow:0 14px 40px rgba(0,0,0,.35);
      max-width:520px;
    }

    .fcard__cta{
      display:inline-flex;
      align-items:center;
      justify-content:center;
      height:46px;
      padding:0 22px;
      border-radius:999px;
      font-weight:800;
      font-size:14px;
      color:var(--ink);
      background:#ffffff;
      border:1px solid rgba(255,255,255,.70);
      box-shadow:0 18px 40px rgba(0,0,0,.18);
      transition:transform .15s ease, filter .15s ease;
    }

    .fcard__cta:hover{transform:translateY(-1px); filter:brightness(1.02);}

    @media (max-width: 980px){
      .featured{padding:46px 0 54px;}
      .featured__title{font-size:46px;}
      .fcard{min-height:500px;}
      .fcard__headline{font-size:44px;}
      .featured__grid{grid-template-columns:1fr;}
      /* mobile: horizontal snap list like therapie */
      .featured__grid{
        display:flex;
        gap:16px;
        overflow:auto;
        scroll-snap-type:x mandatory;
        -webkit-overflow-scrolling:touch;
        padding-bottom:14px;
      }
      .featured__grid::-webkit-scrollbar{height:8px;}
      .featured__grid::-webkit-scrollbar-thumb{background:rgba(11,27,42,.18); border-radius:999px;}
      .featured__grid::-webkit-scrollbar-track{background:rgba(11,27,42,.06); border-radius:999px;}
      .fcard{flex:0 0 min(560px, 88vw); scroll-snap-align:start;}
    }

    @media (max-width: 560px){
      .featured__inner{padding:0 16px;}
      .featured__title{font-size:40px;}
      .fcard{min-height:460px; border-radius:16px;}
      .fcard__headline{font-size:38px;}
    }
    /* Our Locations (full width, 3 location cards) */
    .locations{
      width:100%;
      background:#ffffff;
      padding:58px 0 70px;
    }

    .locations__inner{
      width:100%;
      max-width:100%;
      margin:0;
      padding:0 40px;
    }

    .locations__kicker{
      margin:0 0 10px;
      font-weight:800;
      letter-spacing:.22em;
      text-transform:uppercase;
      font-size:14px;
      color:#6b5bd2;
    }

    .locations__head{
      display:flex;
      align-items:flex-end;
      justify-content:space-between;
      gap:18px;
      margin-bottom:22px;
    }

    .locations__title{
      margin:0;
      font-family: ui-serif, Georgia, "Times New Roman", Times, serif;
      font-weight:500;
      font-size:64px;
      line-height:1.02;
      letter-spacing:-.02em;
      color:var(--ink);
    }

    .locations__viewall{
      color:#6b5bd2;
      font-weight:800;
      text-decoration:none;
    }

    .locations__grid{
      display:grid;
      grid-template-columns:repeat(3, minmax(0, 1fr));
      gap:18px;
      align-items:stretch;
    }

    .lcard{
      border-radius:18px;
      overflow:hidden;
      background:#f3f4f8;
      border:1px solid rgba(11,27,42,.10);
      box-shadow:0 22px 52px rgba(11,27,42,.10);
      display:flex;
      flex-direction:column;
      min-height:560px;
    }

    .lcard__media{
      position:relative;
      height:270px;
      background:#e9e9ee;
      overflow:hidden;
    }

    .lcard__media img{
      width:100%;
      height:100%;
      object-fit:cover;
      display:block;
      transform:scale(1.01);
      transition:transform .35s ease;
    }

    .lcard:hover .lcard__media img{transform:scale(1.05);}

    .lcard__body{
      padding:26px 26px 24px;
      background:#ffffff;
      flex:1;
      display:flex;
      flex-direction:column;
      gap:14px;
    }

    .lcard__name{
      margin:0;
      font-weight:800;
      font-size:22px;
      color:var(--ink);
    }

    .lcard__addr{
      margin:0;
      color:rgba(11,27,42,.70);
      font-weight:600;
      font-size:14px;
      line-height:1.55;
    }

    .lcard__phone{
      display:flex;
      align-items:center;
      gap:10px;
      color:rgba(11,27,42,.70);
      font-weight:700;
      font-size:14px;
      margin-top:-2px;
    }

    .lcard__icon{
      width:18px;
      height:18px;
      opacity:.75;
      flex:0 0 auto;
    }

    .lcard__footer{
      margin-top:auto;
      padding-top:8px;
    }

    .lcard__cta{
      display:inline-flex;
      align-items:center;
      justify-content:center;
      height:46px;
      padding:0 22px;
      border-radius:999px;
      font-weight:800;
      font-size:14px;
      color:var(--ink);
      background:#ffffff;
      border:1.5px solid rgba(11,27,42,.40);
      box-shadow:0 18px 40px rgba(0,0,0,.08);
      transition:transform .15s ease, background .15s ease, border-color .15s ease;
      width:max-content;
    }

    .lcard__cta:hover{
      transform:translateY(-1px);
      background:#f7f8fb;
      border-color:rgba(11,27,42,.55);
    }

    /* tablet/mobile: snap carousel like therapie */
    @media (max-width: 980px){
      .locations{padding:46px 0 56px;}
      .locations__inner{padding:0 16px;}
      .locations__title{font-size:46px;}

      .locations__grid{
        display:flex;
        gap:16px;
        overflow:auto;
        scroll-snap-type:x mandatory;
        -webkit-overflow-scrolling:touch;
        padding-bottom:14px;
      }
      .locations__grid::-webkit-scrollbar{height:8px;}
      .locations__grid::-webkit-scrollbar-thumb{background:rgba(11,27,42,.18); border-radius:999px;}
      .locations__grid::-webkit-scrollbar-track{background:rgba(11,27,42,.06); border-radius:999px;}

      .lcard{flex:0 0 min(620px, 88vw); scroll-snap-align:start;}
      .lcard__media{height:260px;}
    }

    @media (max-width: 560px){
      .locations__title{font-size:40px;}
      .lcard{min-height:520px; border-radius:16px;}
      .lcard__body{padding:22px 18px 20px;}
      .lcard__media{height:230px;}
      .lcard__name{font-size:20px;}
    }
    /* As seen in (full width, beige logos row) */
    .seen{
      width:100%;
      background:#efe4d7;
      color:var(--ink);
      padding:0;
    }

    .seen__surface{
      width:100%;
      padding:54px 0 52px;
      border-top:1px solid rgba(11,27,42,.08);
      border-bottom:1px solid rgba(11,27,42,.08);
      background:
        radial-gradient(900px 520px at 20% 10%, rgba(255,255,255,.28), transparent 60%),
        radial-gradient(900px 520px at 80% 0%, rgba(0,0,0,.04), transparent 60%),
        #efe4d7;
    }

    .seen__inner{
      width:100%;
      max-width:100%;
      margin:0;
      padding:0 40px;
    }

    .seen__kicker{
      margin:0 0 26px;
      text-align:center;
      text-transform:uppercase;
      letter-spacing:.28em;
      font-weight:900;
      font-size:13px;
      color:rgba(11,27,42,.72);
    }

    .seen__row{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:54px;
      flex-wrap:nowrap;
    }

    .seen__logo{
      display:flex;
      align-items:center;
      justify-content:center;
      min-height:48px;
      opacity:.95;
      user-select:none;
      filter:contrast(1.02);
    }

    .seen__logo svg{height:42px; width:auto; display:block;}

    /* tablet/mobile: horizontal scroll like therapie */
    @media (max-width: 980px){
      .seen__inner{padding:0 16px;}
      .seen__surface{padding:46px 0 44px;}
      .seen__row{
        justify-content:flex-start;
        gap:44px;
        overflow:auto;
        -webkit-overflow-scrolling:touch;
        scroll-snap-type:x mandatory;
        padding-bottom:10px;
      }
      .seen__row::-webkit-scrollbar{height:8px;}
      .seen__row::-webkit-scrollbar-thumb{background:rgba(11,27,42,.18); border-radius:999px;}
      .seen__row::-webkit-scrollbar-track{background:rgba(11,27,42,.06); border-radius:999px;}
      .seen__logo{flex:0 0 auto; scroll-snap-align:center;}
      .seen__logo svg{height:40px;}
    }

    @media (max-width: 560px){
      .seen__kicker{margin-bottom:20px;}
      .seen__logo svg{height:38px;}
    }
  </style>
</head>
<body>

<?php include('header.php'); ?>

<main id="main">

  <!-- Sale now on / Most Popular Offers (original implementation, no hotlinked images) -->
  <section class="offers" aria-label="Most popular offers">
    <div class="offers__inner">
      <p class="offers__kicker">Sale now on</p>
      <div class="offers__head">
        <h2 class="offers__title">Most Popular Offers</h2>
        <div class="offers__controls">
          <a class="offers__viewall" href="offers.php">View all</a>
          <button class="offers__btn" type="button" data-offers-prev aria-label="Previous offers">‹</button>
          <button class="offers__btn" type="button" data-offers-next aria-label="Next offers">›</button>
        </div>
      </div>

      <div class="carousel" data-offers>
        <div class="carousel__track" data-offers-track tabindex="0" aria-label="Offers carousel">

          <article class="offer" aria-label="Anti-Wrinkle Injections - 3 Area Package">
            <div class="offer__media" aria-hidden="true"></div>
            <div class="offer__tag">New Client Offer!</div>
            <div class="offer__body">
              <p class="offer__category">Anti-Wrinkle Injections</p>
              <h3 class="offer__name">3 Area Package</h3>
              <div class="offer__priceRow">
                <div class="offer__from">From</div>
                <div class="offer__price">£189<small>.00</small></div>
              </div>
              <a class="offer__cta" href="offers.php">Book now</a>
            </div>
          </article>

          <article class="offer" aria-label="Laser Hair Removal - Full Body excluding face">
            <div class="offer__media" aria-hidden="true" style="background:
              radial-gradient(900px 520px at 25% 25%, rgba(255,255,255,.18), transparent 56%),
              radial-gradient(700px 420px at 85% 18%, rgba(27,120,200,.38), transparent 58%),
              linear-gradient(135deg, rgba(255,255,255,.08), rgba(255,255,255,.02));"></div>
            <div class="offer__body">
              <p class="offer__category">Laser Hair Removal</p>
              <h3 class="offer__name">Full Body <span style="opacity:.85; font-weight:500;">(excluding face)</span></h3>
              <div class="offer__priceRow">
                <div class="offer__from">From</div>
                <div class="offer__price">£129<small>.95</small></div>
              </div>
              <a class="offer__cta" href="offers.php">Book now</a>
            </div>
          </article>

          <article class="offer" aria-label="Anti-Wrinkle Injections - Buy 2 Areas Get 1 FREE">
            <div class="offer__media" aria-hidden="true" style="background:
              radial-gradient(900px 520px at 20% 20%, rgba(255,255,255,.18), transparent 56%),
              radial-gradient(700px 420px at 80% 10%, rgba(231, 76, 60, .32), transparent 60%),
              linear-gradient(135deg, rgba(255,255,255,.08), rgba(255,255,255,.02));"></div>
            <div class="offer__tag" style="background:rgba(231, 76, 60, .95);">3 for 2!</div>
            <div class="offer__body">
              <p class="offer__category">Anti-Wrinkle Injections</p>
              <h3 class="offer__name">Buy 2 Areas, Get 1 FREE</h3>
              <div class="offer__priceRow">
                <div class="offer__from">From</div>
                <div class="offer__price">£245<small>.00</small></div>
                <div class="offer__was">was £344.00</div>
              </div>
              <a class="offer__cta" href="offers.php">Book now</a>
            </div>
          </article>

          <article class="offer" aria-label="Laser Hair Removal - Any Bikini and Underarm">
            <div class="offer__media" aria-hidden="true" style="background:
              radial-gradient(900px 520px at 18% 22%, rgba(255,255,255,.16), transparent 58%),
              radial-gradient(700px 420px at 84% 16%, rgba(107,91,210,.35), transparent 58%),
              linear-gradient(135deg, rgba(255,255,255,.08), rgba(255,255,255,.02));"></div>
            <div class="offer__body">
              <p class="offer__category">Laser Hair Removal</p>
              <h3 class="offer__name">Any Bikini &amp; Underarm</h3>
              <div class="offer__priceRow">
                <div class="offer__from">From</div>
                <div class="offer__price">£29<small>.95</small></div>
              </div>
              <a class="offer__cta" href="offers.php">Book now</a>
            </div>
          </article>

        </div>

        <div class="carousel__dots" aria-hidden="true">
          <span class="dot is-active"></span>
          <span class="dot"></span>
          <span class="dot"></span>
          <span class="dot"></span>
        </div>
      </div>

    </div>
  </section>

  <!-- Full-width promo banner (original content) -->
  <section class="promo" aria-label="Featured subscription">
    <div class="promo__surface">
      <div class="promo__inner">
        <div class="promo__content">
          <p class="promo__eyebrow">NO STRESS. JUST FLAWLESS RESULTS</p>
          <h2 class="promo__title">Our new Anti-Wrinkle Subscription</h2>
          <a class="promo__cta" href="offers.php">Learn More</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Begin your journey / Explore Our Treatments (original implementation) -->
  <section class="treatments" aria-label="Explore our treatments">
    <div class="treatments__inner">
      <p class="treatments__kicker">BEGIN YOUR JOURNEY</p>
      <div class="treatments__head">
        <h2 class="treatments__title">Explore Our Treatments</h2>
        <div class="treatments__controls">
          <button class="treatments__btn" type="button" data-treat-prev aria-label="Previous treatments">‹</button>
          <button class="treatments__btn" type="button" data-treat-next aria-label="Next treatments">›</button>
        </div>
      </div>

      <div class="tcarousel" data-treat>
        <div class="tcarousel__track" data-treat-track tabindex="0" aria-label="Treatments carousel">

          <article class="tcard" aria-label="Laser Hair Removal for Women">
            <div class="tcard__media" aria-hidden="true" style="background:
              radial-gradient(700px 520px at 30% 20%, rgba(255,255,255,.62), rgba(255,255,255,0) 60%),
              radial-gradient(620px 420px at 78% 16%, rgba(219, 186, 255, .55), rgba(219, 186, 255, 0) 62%),
              linear-gradient(135deg, rgba(0,0,0,.10), rgba(0,0,0,0));"></div>
            <div class="tcard__body">
              <h3 class="tcard__title">Laser Hair Removal<br/>For Women</h3>
              <a class="tcard__cta" href="treatments.php">Explore</a>
            </div>
          </article>

          <article class="tcard" aria-label="Laser Hair Removal for Men">
            <div class="tcard__media" aria-hidden="true" style="background:
              radial-gradient(700px 520px at 28% 18%, rgba(255,255,255,.58), rgba(255,255,255,0) 60%),
              radial-gradient(620px 420px at 82% 18%, rgba(107,91,210,.45), rgba(107,91,210,0) 62%),
              linear-gradient(135deg, rgba(0,0,0,.10), rgba(0,0,0,0));"></div>
            <div class="tcard__body">
              <h3 class="tcard__title">Laser Hair Removal<br/>For Men</h3>
              <a class="tcard__cta" href="treatments.php">Explore</a>
            </div>
          </article>

          <article class="tcard" aria-label="Cosmetic Injections">
            <div class="tcard__media" aria-hidden="true" style="background:
              radial-gradient(700px 520px at 30% 20%, rgba(255,255,255,.62), rgba(255,255,255,0) 60%),
              radial-gradient(620px 420px at 78% 14%, rgba(27,120,200,.40), rgba(27,120,200,0) 62%),
              linear-gradient(135deg, rgba(0,0,0,.10), rgba(0,0,0,0));"></div>
            <div class="tcard__body">
              <h3 class="tcard__title">Cosmetic<br/>Injections</h3>
              <a class="tcard__cta" href="treatments.php">Explore</a>
            </div>
          </article>

          <article class="tcard" aria-label="Skin Treatments">
            <div class="tcard__media" aria-hidden="true" style="background:
              radial-gradient(700px 520px at 30% 20%, rgba(255,255,255,.60), rgba(255,255,255,0) 60%),
              radial-gradient(620px 420px at 78% 14%, rgba(231, 76, 60, .30), rgba(231, 76, 60, 0) 62%),
              linear-gradient(135deg, rgba(0,0,0,.10), rgba(0,0,0,0));"></div>
            <div class="tcard__body">
              <h3 class="tcard__title">Skin<br/>Treatments</h3>
              <a class="tcard__cta" href="treatments.php">Explore</a>
            </div>
          </article>

        </div>

        <div class="treatments__dots" aria-hidden="true">
          <span class="tdot is-active"></span>
          <span class="tdot"></span>
          <span class="tdot"></span>
          <span class="tdot"></span>
        </div>
      </div>

    </div>
  </section>

  <!-- Personalised Plans (original content) -->
  <section class="plans" aria-label="Personalised plans">
    <div class="plans__surface">
      <div class="plans__inner">
        <div class="plans__content">
          <p class="plans__kicker">PERSONALISED PLANS</p>
          <h2 class="plans__title">Let our team of experts build tailored treatments <em>just for you.</em></h2>
          <a class="plans__cta" href="appointment.php">Book a free consultation</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Proof: Stats + Reels (original, placeholder visuals) -->
  <section class="proof" aria-label="Clinic results and stories">

    <div class="stats" aria-label="Clinic statistics">
      <div class="stats__inner">
        <div class="stats__grid">
          <div class="stat">
            <p class="stat__value">85+</p>
            <p class="stat__label">CLINICS GLOBALLY</p>
          </div>
          <div class="stat">
            <p class="stat__value">200+</p>
            <p class="stat__label">QUALIFIED DOCTORS</p>
          </div>
          <div class="stat">
            <p class="stat__value">20+</p>
            <p class="stat__label">YEARS IN BUSINESS</p>
          </div>
          <div class="stat">
            <p class="stat__value">10 million+</p>
            <p class="stat__label">TREATMENTS DELIVERED</p>
          </div>
        </div>
      </div>
    </div>

    <div class="reels" aria-label="Patient stories">
      <div class="reels__inner">
        <div class="reels__grid">

          <a class="reel" href="#" data-reel="A patient shares their first consultation experience" aria-label="Play story 1">
            <div class="reel__media" aria-hidden="true"></div>
            <div class="reel__play" aria-hidden="true">
              <svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
            </div>
            <div class="reel__caption">First consultation • what to expect</div>
          </a>

          <a class="reel" href="#" data-reel="A clinician explains how personalised plans are created" aria-label="Play story 2">
            <div class="reel__media" aria-hidden="true" style="background:
              radial-gradient(900px 620px at 35% 25%, rgba(255,255,255,.55), rgba(255,255,255,0) 62%),
              radial-gradient(700px 520px at 78% 20%, rgba(27,120,200,.30), rgba(27,120,200,0) 62%),
              linear-gradient(135deg, rgba(0,0,0,.08), rgba(0,0,0,0));"></div>
            <div class="reel__play" aria-hidden="true">
              <svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
            </div>
            <div class="reel__caption">Personalised plans • built by experts</div>
          </a>

          <a class="reel" href="#" data-reel="Before & after style results overview (placeholder)" aria-label="Play story 3">
            <div class="reel__media" aria-hidden="true" style="background:
              radial-gradient(900px 620px at 32% 25%, rgba(255,255,255,.55), rgba(255,255,255,0) 62%),
              radial-gradient(700px 520px at 80% 20%, rgba(231, 76, 60, .22), rgba(231, 76, 60, 0) 62%),
              linear-gradient(135deg, rgba(0,0,0,.08), rgba(0,0,0,0));"></div>
            <div class="reel__play" aria-hidden="true">
              <svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
            </div>
            <div class="reel__caption">Results • real outcomes over time</div>
          </a>

          <a class="reel" href="#" data-reel="A quick review about the clinic experience" aria-label="Play story 4">
            <div class="reel__media" aria-hidden="true" style="background:
              radial-gradient(900px 620px at 30% 25%, rgba(255,255,255,.55), rgba(255,255,255,0) 62%),
              radial-gradient(700px 520px at 82% 20%, rgba(107,91,210,.28), rgba(107,91,210,0) 62%),
              linear-gradient(135deg, rgba(0,0,0,.08), rgba(0,0,0,0));"></div>
            <div class="reel__play" aria-hidden="true">
              <svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
            </div>
            <div class="reel__caption">Reviews • why patients return</div>
          </a>

        </div>
      </div>
    </div>

  </section>

  <!-- Thérapie for all (statement section) -->
  <section class="story" aria-label="Clinic story">
    <div class="story__surface">
      <div class="story__inner">
        <p class="story__kicker">Thérapie for all</p>
        <h2 class="story__title">
          We first opened our doors 20 years ago and now <em>we are proud</em> to have become Europe&apos;s No.1<br/>
          Medical Aesthetic Clinic.
        </h2>
        <div class="story__ctaRow">
          <a class="story__cta" href="about.php">Read our story</a>
        </div>
      </div>
    </div>
  </section>

  <!-- What's new and trending / Featured at Thérapie -->
  <section class="featured" aria-label="What's new and trending">
    <div class="featured__inner">
      <p class="featured__kicker">WHAT'S NEW AND TRENDING</p>
      <h2 class="featured__title">Featured at Thérapie</h2>

      <div class="featured__grid" aria-label="Featured cards">

        <article class="fcard" aria-label="Get 3 treatments of 3 areas annually, and save 15%">
          <!-- Replace background-image url below with your real image when ready -->
          <div class="fcard__media" aria-hidden="true" style="background-image:url('https://therapieclinic.com/_next/image?url=%2Fassets%2Foffers%2Foffers%2Fevegrn-anti-wrinkle-exiting.webp&w=1536&q=75');"></div>
          <div class="fcard__tag">NEW!</div>
          <div class="fcard__body">
            <h3 class="fcard__headline">Get 3 treatments of<br/>3 areas annually,<br/>and save 15%.</h3>
            <a class="fcard__cta" href="#">Learn More</a>
          </div>
        </article>

        <article class="fcard" aria-label="The next evolution of skincare with SKIN+ Packages">
          <div class="fcard__media" aria-hidden="true" style="background-image:url('https://therapieclinic.com/_next/image?url=%2Fassets%2Foffers%2Foffers%2FusBodyFace.webp&w=1536&q=75');"></div>
          <div class="fcard__tag">NEW!</div>
          <div class="fcard__body">
            <h3 class="fcard__headline">The next evolution<br/>of skincare with<br/>SKIN+ Packages</h3>
            <a class="fcard__cta" href="#">Buy Now</a>
          </div>
        </article>

        <article class="fcard" aria-label="We're opening 5 New Clinics Across the UK">
          <div class="fcard__media" aria-hidden="true" style="background-image:url('https://therapieclinic.com/_next/image?url=%2Fassets%2Foffers%2Foffers%2Flower-legs-any-bikini-underarms.webp&w=1536&q=75');"></div>
          <div class="fcard__tag">New Clinics!</div>
          <div class="fcard__body">
            <h3 class="fcard__headline">We’re opening 5<br/>New Clinics Across<br/>the UK!</h3>
            <a class="fcard__cta" href="#">Find Your Clinic</a>
          </div>
        </article>

      </div>
    </div>
  </section>

  <!-- Our Locations (like therapie) -->
  <section class="locations" aria-label="Our locations">
    <div class="locations__inner">
      <p class="locations__kicker">FIND A CLINIC NEAR YOU</p>
      <div class="locations__head">
        <h2 class="locations__title">Our Locations</h2>
        <a class="locations__viewall" href="locations.php">View all</a>
      </div>

      <div class="locations__grid" aria-label="Location cards">

        <article class="lcard" aria-label="Angel clinic">
          <div class="lcard__media">
            <img src="https://therapieclinic.com/_next/image?url=%2Fassets%2Fhome%2Flocations%2Fangel.webp&w=1536&q=75" alt="Angel clinic" loading="lazy" />
          </div>
          <div class="lcard__body">
            <h3 class="lcard__name">Angel</h3>
            <p class="lcard__addr">35 Parkfield St, Angel Central Shopping Centre, London, N1 0PS, United Kingdom</p>
            <div class="lcard__phone">
              <svg class="lcard__icon" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2a1 1 0 011.01-.24c1.12.37 2.33.57 3.58.57a1 1 0 011 1V20a1 1 0 01-1 1C10.85 21 3 13.15 3 3a1 1 0 011-1h3.5a1 1 0 011 1c0 1.25.2 2.46.57 3.58a1 1 0 01-.24 1.01l-2.21 2.2z"/></svg>
              <span>+44 020 8114 0311</span>
            </div>
            <div class="lcard__footer">
              <a class="lcard__cta" href="locations.php">Get directions</a>
            </div>
          </div>
        </article>

        <article class="lcard" aria-label="Bath clinic">
          <div class="lcard__media">
            <img src="https://therapieclinic.com/_next/image?url=%2Fassets%2Fhome%2Flocations%2Fbath.webp&w=1536&q=75" alt="Bath clinic" loading="lazy" />
          </div>
          <div class="lcard__body">
            <h3 class="lcard__name">Bath</h3>
            <p class="lcard__addr">SU32, 12, Southgate Place, Bath, BA1 1AP, United Kingdom</p>
            <div class="lcard__phone">
              <svg class="lcard__icon" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2a1 1 0 011.01-.24c1.12.37 2.33.57 3.58.57a1 1 0 011 1V20a1 1 0 01-1 1C10.85 21 3 13.15 3 3a1 1 0 011-1h3.5a1 1 0 011 1c0 1.25.2 2.46.57 3.58a1 1 0 01-.24 1.01l-2.21 2.2z"/></svg>
              <span>+44 01225 435188</span>
            </div>
            <div class="lcard__footer">
              <a class="lcard__cta" href="locations.php">Get directions</a>
            </div>
          </div>
        </article>

        <article class="lcard" aria-label="Belfast clinic">
          <div class="lcard__media">
            <img src="https://therapieclinic.com/_next/image?url=%2Fassets%2Fhome%2Flocations%2Fbelfast.webp&w=1536&q=75" alt="Belfast clinic" loading="lazy" />
          </div>
          <div class="lcard__body">
            <h3 class="lcard__name">Belfast</h3>
            <p class="lcard__addr">40 Ann St, 36, Belfast, BT1 4EG, United Kingdom</p>
            <div class="lcard__phone">
              <svg class="lcard__icon" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2a1 1 0 011.01-.24c1.12.37 2.33.57 3.58.57a1 1 0 011 1V20a1 1 0 01-1 1C10.85 21 3 13.15 3 3a1 1 0 011-1h3.5a1 1 0 011 1c0 1.25.2 2.46.57 3.58a1 1 0 01-.24 1.01l-2.21 2.2z"/></svg>
              <span>+44 028 9163 8401</span>
            </div>
            <div class="lcard__footer">
              <a class="lcard__cta" href="locations.php">Get directions</a>
            </div>
          </div>
        </article>

      </div>
    </div>
  </section>

  <!-- As seen in (logos row like therapie) -->
  <section class="seen" aria-label="As seen in">
    <div class="seen__surface">
      <div class="seen__inner">
        <p class="seen__kicker">AS SEEN IN</p>

        <div class="seen__row" aria-label="Publications">
          <!-- NOTE: These are lightweight SVG wordmarks so you don’t need external image files. Replace later with your own brand assets if needed. -->

          <div class="seen__logo" aria-label="ELLE">
            <svg viewBox="0 0 260 60" role="img" aria-label="ELLE" xmlns="http://www.w3.org/2000/svg">
              <text x="0" y="44" font-family="ui-serif, Georgia, 'Times New Roman', Times, serif" font-size="48" letter-spacing="14" fill="#0b1b2a">ELLE</text>
            </svg>
          </div>

          <div class="seen__logo" aria-label="Forbes">
            <svg viewBox="0 0 260 60" role="img" aria-label="Forbes" xmlns="http://www.w3.org/2000/svg">
              <text x="0" y="46" font-family="ui-serif, Georgia, 'Times New Roman', Times, serif" font-size="52" font-weight="600" fill="#0b1b2a">Forbes</text>
            </svg>
          </div>

          <div class="seen__logo" aria-label="The Sunday Times">
            <svg viewBox="0 0 360 60" role="img" aria-label="The Sunday Times" xmlns="http://www.w3.org/2000/svg">
              <text x="0" y="24" font-family="ui-serif, Georgia, 'Times New Roman', Times, serif" font-size="22" font-weight="700" fill="#0b1b2a">THE SUNDAY TIMES</text>
              <path d="M3 32h354" stroke="#0b1b2a" stroke-opacity=".35" stroke-width="2"/>
              <text x="0" y="54" font-family="system-ui, -apple-system, Segoe UI, Roboto, Arial" font-size="12" letter-spacing="4" fill="#0b1b2a" opacity=".8">FEATURED</text>
            </svg>
          </div>

          <div class="seen__logo" aria-label="VOGUE">
            <svg viewBox="0 0 280 60" role="img" aria-label="VOGUE" xmlns="http://www.w3.org/2000/svg">
              <text x="0" y="46" font-family="ui-serif, Georgia, 'Times New Roman', Times, serif" font-size="52" letter-spacing="2" fill="#0b1b2a">VOGUE</text>
            </svg>
          </div>

          <div class="seen__logo" aria-label="SHEERLUXE">
            <svg viewBox="0 0 300 60" role="img" aria-label="SHEERLUXE" xmlns="http://www.w3.org/2000/svg">
              <text x="0" y="44" font-family="system-ui, -apple-system, Segoe UI, Roboto, Arial" font-size="22" font-weight="700" letter-spacing="6" fill="#0b1b2a">SHEERLUXE</text>
            </svg>
          </div>

        </div>
      </div>
    </div>
  </section>

  <!-- Video modal (UI placeholder) -->
  <div class="vmodal" id="vmodal" aria-hidden="true">
    <div class="vmodal__backdrop" data-vclose></div>
    <div class="vmodal__panel" role="dialog" aria-modal="true" aria-label="Video preview">
      <div class="vmodal__top">
        <p class="vmodal__title">Video preview</p>
        <button class="vmodal__close" type="button" aria-label="Close" data-vclose>✕</button>
      </div>
      <div class="vmodal__body">
        <div class="vmodal__placeholder" id="vmodalText">
          <strong>Placeholder video</strong>
          <p>This is a UI-only preview. You can replace this with your own MP4 files later and we’ll wire up real playback.</p>
        </div>
      </div>
    </div>
  </div>

</main>

<?php include('footer.php'); ?>

<script>
  (function(){
    const track = document.querySelector('[data-offers-track]');
    const prev = document.querySelector('[data-offers-prev]');
    const next = document.querySelector('[data-offers-next]');
    const dots = Array.from(document.querySelectorAll('.carousel__dots .dot'));

    if(!track) return;

    const getCardWidth = () => {
      const card = track.querySelector('.offer');
      if(!card) return 320;
      const styles = window.getComputedStyle(track);
      const gap = parseFloat(styles.columnGap || styles.gap || '18') || 18;
      return card.getBoundingClientRect().width + gap;
    };

    const scrollByCard = (dir) => {
      track.scrollBy({ left: dir * getCardWidth(), behavior: 'smooth' });
    };

    prev && prev.addEventListener('click', () => scrollByCard(-1));
    next && next.addEventListener('click', () => scrollByCard(1));

    // Update dots based on nearest card
    const updateDots = () => {
      const cards = Array.from(track.querySelectorAll('.offer'));
      if(!cards.length || !dots.length) return;
      const left = track.scrollLeft;
      const w = getCardWidth();
      const idx = Math.max(0, Math.min(cards.length - 1, Math.round(left / w)));
      dots.forEach((d,i) => d.classList.toggle('is-active', i === idx));
    };

    track.addEventListener('scroll', () => {
      window.requestAnimationFrame(updateDots);
    }, {passive:true});

    // Keyboard support
    track.addEventListener('keydown', (e) => {
      if(e.key === 'ArrowRight') { e.preventDefault(); scrollByCard(1); }
      if(e.key === 'ArrowLeft') { e.preventDefault(); scrollByCard(-1); }
    });

    updateDots();
  })();

  (function(){
    const track = document.querySelector('[data-treat-track]');
    const prev = document.querySelector('[data-treat-prev]');
    const next = document.querySelector('[data-treat-next]');
    const dots = Array.from(document.querySelectorAll('.treatments__dots .tdot'));

    if(!track) return;

    const getCardWidth = () => {
      const card = track.querySelector('.tcard');
      if(!card) return 360;
      const styles = window.getComputedStyle(track);
      const gap = parseFloat(styles.columnGap || styles.gap || '18') || 18;
      return card.getBoundingClientRect().width + gap;
    };

    const scrollByCard = (dir) => {
      track.scrollBy({ left: dir * getCardWidth(), behavior: 'smooth' });
    };

    prev && prev.addEventListener('click', () => scrollByCard(-1));
    next && next.addEventListener('click', () => scrollByCard(1));

    const updateDots = () => {
      const cards = Array.from(track.querySelectorAll('.tcard'));
      if(!cards.length || !dots.length) return;
      const left = track.scrollLeft;
      const w = getCardWidth();
      const idx = Math.max(0, Math.min(cards.length - 1, Math.round(left / w)));
      dots.forEach((d,i) => d.classList.toggle('is-active', i === idx));
    };

    track.addEventListener('scroll', () => {
      window.requestAnimationFrame(updateDots);
    }, {passive:true});

    track.addEventListener('keydown', (e) => {
      if(e.key === 'ArrowRight') { e.preventDefault(); scrollByCard(1); }
      if(e.key === 'ArrowLeft') { e.preventDefault(); scrollByCard(-1); }
    });

    updateDots();
  })();
  (function(){
    const modal = document.getElementById('vmodal');
    const text = document.getElementById('vmodalText');
    const closeEls = modal ? modal.querySelectorAll('[data-vclose]') : [];
    const reels = Array.from(document.querySelectorAll('[data-reel]'));

    if(!modal || !text || !reels.length) return;

    const setOpen = (open) => {
      modal.classList.toggle('is-open', open);
      modal.setAttribute('aria-hidden', open ? 'false' : 'true');
      document.documentElement.style.overflow = open ? 'hidden' : '';
    };

    reels.forEach((a) => {
      a.addEventListener('click', (e) => {
        e.preventDefault();
        const msg = a.getAttribute('data-reel') || 'Video preview';
        text.innerHTML = `
          <strong>Placeholder video</strong>
          <p>${msg}</p>
          <p style="opacity:.85">(Replace with your own videos later — this section is ready.)</p>
        `;
        setOpen(true);
      });
    });

    closeEls.forEach(el => el.addEventListener('click', () => setOpen(false)));

    document.addEventListener('keydown', (e) => {
      if(e.key === 'Escape' && modal.classList.contains('is-open')) setOpen(false);
    });
  })();
</script>

</body>
</html>
