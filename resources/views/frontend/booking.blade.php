

@include('frontend.partials.header')

<style>
  :root{
    --bookings-bg:#f4f4f8;
    --bookings-card:#ffffff;
    --bookings-text:#10131b;
    --bookings-muted:#6b7280;
    --bookings-line:#e6e7ee;
    --bookings-pill:#ededf2;
    --bookings-pill-active:#ffffff;
    --bookings-shadow:0 18px 44px rgba(15,23,42,.06);
  }

  body.my-bookings-body{
    background:
      radial-gradient(circle at top left, rgba(111,99,246,.05), transparent 24%),
      linear-gradient(180deg, #fafafe 0%, #f3f3f8 100%);
    background-attachment:fixed;
  }

  .my-bookings-page{
    background:transparent;
    min-height:calc(100vh - 160px);
  }

  .my-bookings-hero{
    background:#fff;
    padding:34px 16px 42px;
  }

  .my-bookings-wrap{
    width:min(960px, calc(100% - 32px));
    margin:0 auto;
  }

  .my-bookings-back{
    display:inline-flex;
    align-items:center;
    gap:10px;
    color:#1f2937;
    text-decoration:none;
    font-size:18px;
    line-height:1.4;
    font-weight:500;
    margin-bottom:18px;
    animation:bookingsFadeUp .55s ease both;
  }

  .my-bookings-back svg{
    width:18px;
    height:18px;
    stroke:currentColor;
    fill:none;
    stroke-width:2.2;
    stroke-linecap:round;
    stroke-linejoin:round;
  }

  .my-bookings-title{
    margin:0;
    font-size:72px;
    line-height:.96;
    letter-spacing:-0.06em;
    font-weight:500;
    color:#0d1020;
    animation:bookingsFadeUp .65s ease .08s both;
  }

  .my-bookings-content{
    padding:42px 16px 72px;
  }

  .my-bookings-tabs,
  .my-bookings-tabpanel{
    animation:bookingsCardFade .7s ease .14s both;
  }

  .my-bookings-tabs{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:0;
    background:var(--bookings-pill);
    border-radius:999px;
    padding:0;
    margin-bottom:34px;
    overflow:hidden;
  }

  .my-bookings-tab{
    min-height:62px;
    border:none;
    background:transparent;
    color:#4b5563;
    font-size:20px;
    font-weight:500;
    cursor:pointer;
    border-radius:999px;
    transition:background .18s ease, color .18s ease, box-shadow .18s ease;
  }

  .my-bookings-tab.is-active{
    background:var(--bookings-pill-active);
    color:#111827;
    box-shadow:0 6px 16px rgba(15,23,42,.04);
  }

  .my-bookings-tabpanel{
    display:none;
  }

  .my-bookings-tabpanel.is-active{
    display:block;
  }

  .my-bookings-empty,
  .my-bookings-card{
    background:rgba(255,255,255,.88);
    border:1px solid rgba(255,255,255,.7);
    border-radius:20px;
    box-shadow:var(--bookings-shadow);
    backdrop-filter:blur(10px);
    -webkit-backdrop-filter:blur(10px);
  }

  .my-bookings-empty{
    text-align:center;
    padding:62px 28px 60px;
  }

  .my-bookings-empty__title{
    margin:0;
    font-size:18px;
    line-height:1.55;
    color:#111827;
    font-weight:600;
  }

  .my-bookings-empty__text{
    margin:14px 0 0;
    font-size:16px;
    line-height:1.6;
    color:#6b7280;
  }

  .my-bookings-empty__cta{
    margin-top:28px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:228px;
    min-height:54px;
    padding:0 28px;
    border:1.5px solid #3f3f46;
    border-radius:999px;
    background:#fff;
    color:#27272a;
    text-decoration:none;
    font-size:16px;
    font-weight:600;
    transition:transform .18s ease, box-shadow .18s ease, background .18s ease;
  }

  .my-bookings-empty__cta:hover{
    transform:translateY(-2px);
    box-shadow:0 12px 24px rgba(15,23,42,.08);
    background:#fafafa;
  }

  .my-bookings-card{
    padding:30px 28px 26px;
  }

  .my-bookings-card__date{
    margin:0;
    font-size:22px;
    line-height:1.25;
    font-weight:700;
    color:#141824;
    letter-spacing:-0.03em;
  }

  .my-bookings-card__clinic{
    margin:8px 0 26px;
    font-size:14px;
    line-height:1.4;
    font-weight:500;
    letter-spacing:0;
    color:#666c79;
    text-transform:uppercase;
  }

  .my-bookings-card__row{
    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    gap:24px;
  }

  .my-bookings-card__service{
    margin:0;
    font-size:18px;
    line-height:1.4;
    font-weight:500;
    color:#111827;
  }

  .my-bookings-card__staff{
    margin:8px 0 0;
    font-size:14px;
    line-height:1.45;
    color:#6b7280;
  }

  .my-bookings-card__time{
    white-space:nowrap;
    font-size:18px;
    line-height:1.4;
    font-weight:600;
    color:#555b67;
    padding-bottom:4px;
  }

  @keyframes bookingsFadeUp{
    from{
      opacity:0;
      transform:translateY(18px);
    }
    to{
      opacity:1;
      transform:translateY(0);
    }
  }

  @keyframes bookingsCardFade{
    from{
      opacity:0;
      transform:translateY(22px);
    }
    to{
      opacity:1;
      transform:translateY(0);
    }
  }

  @media (max-width: 991px){
    .my-bookings-title{
      font-size:60px;
    }
  }

  @media (max-width: 767px){
    .my-bookings-hero{
      padding:28px 14px 28px;
    }

    .my-bookings-content{
      padding:28px 14px 48px;
    }

    .my-bookings-wrap{
      width:min(100%, calc(100% - 8px));
    }

    .my-bookings-back{
      font-size:16px;
      margin-bottom:14px;
      gap:8px;
    }

    .my-bookings-title{
      font-size:46px;
      line-height:1;
    }

    .my-bookings-tabs{
      margin-bottom:22px;
    }

    .my-bookings-tab{
      min-height:56px;
      font-size:18px;
    }

    .my-bookings-empty{
      border-radius:18px;
      padding:42px 18px 38px;
    }

    .my-bookings-empty__title{
      font-size:17px;
    }

    .my-bookings-empty__text{
      font-size:14px;
    }

    .my-bookings-empty__cta{
      min-width:100%;
      min-height:50px;
      font-size:15px;
    }

    .my-bookings-card{
      border-radius:18px;
      padding:22px 18px 20px;
    }

    .my-bookings-card__date{
      font-size:18px;
    }

    .my-bookings-card__clinic{
      margin:6px 0 18px;
      font-size:12px;
    }

    .my-bookings-card__row{
      flex-direction:column;
      align-items:flex-start;
      gap:12px;
    }

    .my-bookings-card__service{
      font-size:17px;
    }

    .my-bookings-card__staff{
      font-size:13px;
    }

    .my-bookings-card__time{
      font-size:16px;
      padding-bottom:0;
    }
  }
</style>

<script>
  document.body.classList.add('my-bookings-body');
</script>

<main class="my-bookings-page">
  <section class="my-bookings-hero">
    <div class="my-bookings-wrap">
      <a class="my-bookings-back" href="{{ route('my-account') }}">
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 18l-6-6 6-6"></path></svg>
        <span>Account</span>
      </a>
      <h1 class="my-bookings-title">My Bookings</h1>
    </div>
  </section>

  <section class="my-bookings-content">
    <div class="my-bookings-wrap">
      <div class="my-bookings-tabs" role="tablist" aria-label="Bookings tabs">
        <button class="my-bookings-tab is-active" type="button" role="tab" aria-selected="true" aria-controls="upcomingPanel" id="upcomingTab" data-tab="upcoming">Upcoming</button>
        <button class="my-bookings-tab" type="button" role="tab" aria-selected="false" aria-controls="previousPanel" id="previousTab" data-tab="previous">Previous</button>
      </div>

      <div class="my-bookings-tabpanel is-active" id="upcomingPanel" role="tabpanel" aria-labelledby="upcomingTab">
        <div class="my-bookings-empty">
          <h2 class="my-bookings-empty__title">You have no upcoming appointments.</h2>
          <p class="my-bookings-empty__text">When you book an appointment with us, your upcoming appointments will appear here.</p>
          <a class="my-bookings-empty__cta" href="#">Make a booking</a>
        </div>
      </div>

      <div class="my-bookings-tabpanel" id="previousPanel" role="tabpanel" aria-labelledby="previousTab">
        @foreach ($orders as $item)

        @php
            $date = $item->slot_date ? $item->slot_date : $item->selected_date;
            $time = $item->slot_time ? $item->slot_time : $item->selected_time;
        
            $formatted_date = \Carbon\Carbon::parse($date)->format('l, dS M Y');
        @endphp
        <div class="my-bookings-card">
          <h2 class="my-bookings-card__date">{{ $formatted_date }}</h2>
          <p class="my-bookings-card__clinic">{{ @$item->getKiBookingProfessional->professional_name }}</p>

          <div class="my-bookings-card__row">
            <div>
              <!-- SERVICES -->
                @foreach (@$item->getKiBookinService() as $service)
                    <p class="my-bookings-card__service">
                        {{ $service->property_name }}
                    </p>
                @endforeach
              <p class="my-bookings-card__staff">{{ @$item->getKiBookingProfessional->professional_name }}</p>
            </div>
            <div class="my-bookings-card__time">{{ $time }}</div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>
</main>

<script>
  (function(){
    const tabs = Array.from(document.querySelectorAll('.my-bookings-tab'));
    const panels = Array.from(document.querySelectorAll('.my-bookings-tabpanel'));

    if (!tabs.length || !panels.length) return;

    const activateTab = (key) => {
      tabs.forEach((tab) => {
        const active = tab.dataset.tab === key;
        tab.classList.toggle('is-active', active);
        tab.setAttribute('aria-selected', active ? 'true' : 'false');
      });

      panels.forEach((panel) => {
        const active = panel.id === (key === 'upcoming' ? 'upcomingPanel' : 'previousPanel');
        panel.classList.toggle('is-active', active);
      });
    };

    tabs.forEach((tab) => {
      tab.addEventListener('click', () => activateTab(tab.dataset.tab));
    });
  })();
</script>


@include('frontend.partials.footer')