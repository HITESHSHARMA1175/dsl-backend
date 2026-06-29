

@include('frontend.partials.header')

<style>
  /* Page base */
  .dsl-page-wrap{width:100%;}

  /* Full width section */
  .finance-hero{
    width:100%;
    background:#ffffff;
    padding:72px 0;
  }
  .finance-hero__inner{
    width:100%;
    max-width:1400px;
    margin:0 auto;
    padding:0 48px;
    display:grid;
    grid-template-columns: 1.1fr 1fr;
    gap:72px;
    align-items:center;
  }

  .finance-hero__media{
    width:100%;
  }
  .finance-hero__img{
    width:100%;
    height:auto;
    display:block;
    border-radius:2px;
    object-fit:cover;
  }

  .finance-hero__eyebrow{
    font-size:14px;
    letter-spacing:0.14em;
    text-transform:uppercase;
    color:#6a63e6;
    font-weight:600;
    margin:0 0 18px;
  }

  .finance-hero__title{
    margin:0 0 22px;
    font-family: Georgia, 'Times New Roman', Times, serif;
    font-weight:500;
    line-height:1.05;
    font-size:64px;
    color:#111111;
  }

  .finance-hero__text{
    margin:0;
    font-size:18px;
    line-height:1.9;
    color:#5a5a5a;
    max-width:56ch;
  }

  /* Omni finance example section */
  .omni-example{
    width:100%;
    background:#3f3b55; /* deep purple like reference */
    padding:84px 0 92px;
    color:#ffffff;
  }
  .omni-example__inner{
    width:100%;
    max-width:1400px;
    margin:0 auto;
    padding:0 48px;
    display:flex;
    flex-direction:column;
    align-items:center;
  }
  .omni-example__title{
    margin:0 0 42px;
    text-align:center;
    font-family: Georgia, 'Times New Roman', Times, serif;
    font-weight:500;
    line-height:1.12;
    font-size:58px;
    color:#ffffff;
  }
  .omni-example__card{
    width:100%;
    max-width:980px;
  }
  .omni-example__label{
    font-size:18px;
    font-weight:600;
    margin:0 0 10px;
    color:#ffffff;
  }
  .omni-example__sub{
    margin:0 0 18px;
    font-size:16px;
    color:rgba(255,255,255,0.85);
  }
  .omni-example__table{
    width:100%;
    border-collapse:collapse;
    table-layout:fixed;
    border-top:2px solid rgba(255,255,255,0.65);
  }
  .omni-example__table tr{
    border-bottom:2px solid rgba(255,255,255,0.25);
  }
  .omni-example__table td{
    padding:22px 22px;
    font-size:18px;
    color:rgba(255,255,255,0.92);
    vertical-align:middle;
  }
  .omni-example__table td:first-child{
    width:68%;
  }
  .omni-example__table td:last-child{
    width:32%;
    text-align:right;
    font-weight:600;
    color:#ffffff;
  }
  .omni-example__row--alt td{
    background:rgba(255,255,255,0.06);
  }
  .omni-example__note{
    margin:18px 0 0;
    font-size:14px;
    color:rgba(255,255,255,0.75);
    text-align:left;
  }

  /* How It Works (Buy Now, Pay Later) */
  .omni-how{
    width:100%;
    background:#ffffff;
    padding:88px 0;
  }
  .omni-how__inner{
    width:100%;
    max-width:1400px;
    margin:0 auto;
    padding:0 48px;
    display:grid;
    grid-template-columns:1.1fr 1fr;
    gap:72px;
    align-items:center;
  }
  .omni-how__eyebrow{
    font-size:14px;
    letter-spacing:0.14em;
    text-transform:uppercase;
    color:#6a63e6;
    font-weight:600;
    margin:0 0 18px;
  }
  .omni-how__title{
    margin:0 0 22px;
    font-family: Georgia, 'Times New Roman', Times, serif;
    font-weight:500;
    line-height:1.05;
    font-size:64px;
    color:#111111;
  }
  .omni-how__text{
    margin:0;
    font-size:18px;
    line-height:1.9;
    color:#5a5a5a;
    max-width:60ch;
  }
  .omni-how__media img{
    width:100%;
    height:auto;
    display:block;
  }

  /* Finance FAQ Section */
  .finance-faq{
    width:100%;
    background:#ffffff;
    padding:96px 0;
  }
  .finance-faq__inner{
    width:100%;
    max-width:1200px;
    margin:0 auto;
    padding:0 48px;
  }
  .finance-faq__title{
    text-align:center;
    margin:0 0 60px;
    font-family: Georgia, 'Times New Roman', Times, serif;
    font-weight:500;
    font-size:58px;
    line-height:1.15;
    color:#111111;
  }
  .finance-faq__list{
    width:100%;
  }
  .finance-faq__item{
    border-bottom:1px solid #e5e5e5;
  }
  .finance-faq__question{
    width:100%;
    background:none;
    border:none;
    text-align:left;
    padding:26px 0;
    font-size:20px;
    font-weight:500;
    cursor:pointer;
    position:relative;
  }
  .finance-faq__question::after{
    content:"+";
    position:absolute;
    right:0;
    top:50%;
    transform:translateY(-50%);
    font-size:22px;
  }
  .finance-faq__item.active .finance-faq__question::after{
    content:"−";
  }
  .finance-faq__answer{
    max-height:0;
    overflow:hidden;
    transition:max-height 0.3s ease;
  }
  .finance-faq__answer p{
    margin:0 0 24px;
    font-size:17px;
    line-height:1.8;
    color:#5a5a5a;
  }
  .finance-faq__item.active .finance-faq__answer{
    max-height:200px;
  }

  @media (max-width:900px){
    .omni-how{padding:64px 0;}
    .omni-how__inner{
      grid-template-columns:1fr;
      gap:40px;
      padding:0 28px;
    }
    .omni-how__title{font-size:42px;}
    .omni-how__text{font-size:16px;}
  }

  /* Responsive */
  @media (max-width: 1100px){
    .finance-hero__inner{gap:48px; padding:0 28px;}
    .finance-hero__title{font-size:54px;}
    .omni-example__title{font-size:50px;}
  }
  @media (max-width: 900px){
    .finance-hero{padding:56px 0;}
    .finance-hero__inner{
      grid-template-columns: 1fr;
      gap:32px;
    }
    .finance-hero__title{font-size:44px;}
    .finance-hero__text{font-size:16px;}
    .omni-example{padding:64px 0 72px;}
    .omni-example__inner{padding:0 28px;}
    .omni-example__title{font-size:40px; margin-bottom:32px;}
    .omni-example__table td{padding:18px 16px; font-size:16px;}
  }
  @media (max-width: 520px){
    .finance-hero__inner{padding:0 18px;}
    .finance-hero__title{font-size:38px;}
    .omni-example__inner{padding:0 18px;}
    .omni-example__title{font-size:34px;}
  }
</style>

<div class="dsl-page-wrap">
  <section class="finance-hero">
    <div class="finance-hero__inner">
      <div class="finance-hero__media">
        <img
          class="finance-hero__img"
          src="https://therapieclinic.com/_next/image?url=%2Fassets%2Ffinance-options%2Ffinance-options.webp&w=1024&q=75"
          alt="Finance options"
          loading="lazy"
        />
      </div>

      <div class="finance-hero__content">
        <p class="finance-hero__eyebrow">A SMARTER WAY TO SHOP AND PAY</p>
        <h1 class="finance-hero__title">Flexible Payment<br/>Options with Omni<br/>Finance</h1>
        <p class="finance-hero__text">
          At DSL Clinic, we believe everyone deserves access to high-quality aesthetic care without
          breaking the bank. That’s why we’ve teamed up with Omni Capital Retail Finance, a leading UK
          finance specialist, to give you flexible payment options. Whether you’re investing in laser hair
          removal, skin rejuvenation, or injectables, you can spread the cost so your journey is
          comfortable and tailored to you.
        </p>
      </div>
    </div>
  </section>

  <section class="omni-example">
    <div class="omni-example__inner">
      <h2 class="omni-example__title">Representative Example of<br/>How Omni Finance Works</h2>

      <div class="omni-example__card">
        <p class="omni-example__label">0% finance</p>
        <p class="omni-example__sub">over 10 Months</p>

        <table class="omni-example__table" aria-label="Representative example table">
          <tbody>
            <tr>
              <td>Goods Price</td>
              <td>£750.00</td>
            </tr>
            <tr class="omni-example__row--alt">
              <td>Initial Payment <em style="font-style:italic; color:rgba(255,255,255,0.85);">from £9.99</em></td>
              <td>£10.00</td>
            </tr>
            <tr>
              <td>Total Amount of Credit</td>
              <td>£740.00</td>
            </tr>
            <tr class="omni-example__row--alt">
              <td>10 Monthly Payments</td>
              <td>£74.00</td>
            </tr>
            <tr>
              <td>Total Amount Payable</td>
              <td>£750.00</td>
            </tr>
            <tr class="omni-example__row--alt">
              <td>Cost of Credit</td>
              <td>£0.00</td>
            </tr>
            <tr>
              <td>Agreement Duration</td>
              <td>10 Months</td>
            </tr>
            <tr class="omni-example__row--alt">
              <td>Representative APR</td>
              <td>0% APR</td>
            </tr>
          </tbody>
        </table>

        <p class="omni-example__note">Representative example shown for illustration only.</p>
      </div>
    </div>
  </section>

  <section class="omni-how">
    <div class="omni-how__inner">
      <div class="omni-how__content">
        <p class="omni-how__eyebrow">BUY NOW, PAY LATER</p>
        <h2 class="omni-how__title">How It Works</h2>
        <p class="omni-how__text">
          Spreading the cost of your purchase couldn't be easier. Simply add your chosen items to your basket
          and you will then be guided through a quick online application with Omni Capital Retail Finance,
          our trusted finance partner. The form only takes a couple of minutes to complete, and you will
          receive an instant decision on whether you have been accepted or if your application needs further
          review. Once approved, just sign your agreement digitally and that is it.
        </p>
      </div>

      <div class="omni-how__media">
        <img
          src="https://therapieclinic.com/_next/image?url=%2Fassets%2Ffinance-options%2Fomni-capital.webp&w=1024&q=75"
          alt="Omni Capital Retail Finance"
          loading="lazy"
        />
      </div>
    </div>
  </section>

  <section class="finance-faq">
    <div class="finance-faq__inner">
      <h2 class="finance-faq__title">Frequently Asked Questions</h2>

      <div class="finance-faq__list">
        <div class="finance-faq__item">
          <button class="finance-faq__question">Am I eligible to apply for finance?</button>
          <div class="finance-faq__answer">
            <p>You must be 18 or over, a UK resident, and meet Omni Capital’s lending criteria. Final approval is subject to status and affordability checks.</p>
          </div>
        </div>

        <div class="finance-faq__item">
          <button class="finance-faq__question">Will a credit search be registered against me if I apply?</button>
          <div class="finance-faq__answer">
            <p>Yes, Omni Capital may perform a credit check as part of the application process. This may be recorded on your credit file.</p>
          </div>
        </div>

        <div class="finance-faq__item">
          <button class="finance-faq__question">What happens after I have submitted my application?</button>
          <div class="finance-faq__answer">
            <p>You will receive an instant decision in most cases. If approved, you can review and sign your agreement digitally.</p>
          </div>
        </div>

        <div class="finance-faq__item">
          <button class="finance-faq__question">What happens if my application is accepted?</button>
          <div class="finance-faq__answer">
            <p>Once accepted, simply complete the digital agreement and your finance plan will be activated according to the agreed schedule.</p>
          </div>
        </div>

        <div class="finance-faq__item">
          <button class="finance-faq__question">What happens if my application is referred to an Underwriter?</button>
          <div class="finance-faq__answer">
            <p>Your application may require additional review. Omni Capital may contact you for further information before making a final decision.</p>
          </div>
        </div>

        <div class="finance-faq__item">
          <button class="finance-faq__question">What happens if my application is declined?</button>
          <div class="finance-faq__answer">
            <p>If declined, you can discuss alternative payment options with our clinic team.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script>
    document.addEventListener("DOMContentLoaded", function(){
      const items = document.querySelectorAll(".finance-faq__item");
      items.forEach(item=>{
        const btn = item.querySelector(".finance-faq__question");
        btn.addEventListener("click", function(){
          item.classList.toggle("active");
        });
      });
    });
  </script>
</div>

@include('frontend.partials.footer')