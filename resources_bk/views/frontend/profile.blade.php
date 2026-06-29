

@include('frontend.partials.header')

<style>
  :root{
    --profile-bg:#f4f4f8;
    --profile-card:#ffffff;
    --profile-text:#10131b;
    --profile-muted:#6b7280;
    --profile-line:#e6e7ee;
    --profile-shadow:0 18px 44px rgba(15,23,42,.06);
    --profile-black:#17181c;
    --profile-green:#22c55e;
    --profile-toggle-off:#e4e7ee;
  }

  body.profile-page-body{
    background:
      radial-gradient(circle at top left, rgba(111,99,246,.05), transparent 24%),
      linear-gradient(180deg,#fafafe 0%,#f3f3f8 100%);
    background-attachment:fixed;
  }

  .profile-page{
    min-height:calc(100vh - 160px);
    background:transparent;
  }

  .profile-hero{
    background:#fff;
    padding:34px 16px 42px;
  }

  .profile-wrap{
    width:min(960px, calc(100% - 32px));
    margin:0 auto;
  }

  .profile-back{
    display:inline-flex;
    align-items:center;
    gap:10px;
    color:#1f2937;
    text-decoration:none;
    font-size:18px;
    line-height:1.4;
    font-weight:500;
    margin-bottom:18px;
    animation:profileFadeUp .55s ease both;
  }

  .profile-back svg{
    width:18px;
    height:18px;
    stroke:currentColor;
    fill:none;
    stroke-width:2.2;
    stroke-linecap:round;
    stroke-linejoin:round;
  }

  .profile-title{
    margin:0;
    font-size:72px;
    line-height:.96;
    letter-spacing:-0.06em;
    font-weight:500;
    color:#0d1020;
    animation:profileFadeUp .65s ease .08s both;
  }

  .profile-content{
    padding:42px 16px 72px;
  }

  .profile-section{
    margin-bottom:36px;
    animation:profileCardFade .7s ease .14s both;
  }

  .profile-section__title{
    margin:0 0 16px;
    font-size:22px;
    line-height:1.2;
    font-weight:700;
    color:#10131b;
  }

  .profile-card{
    background:rgba(255,255,255,.88);
    border:1px solid rgba(255,255,255,.7);
    border-radius:20px;
    box-shadow:var(--profile-shadow);
    backdrop-filter:blur(10px);
    -webkit-backdrop-filter:blur(10px);
    overflow:hidden;
  }

  .profile-card--padded{
    padding:26px 26px 28px;
  }

  .profile-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:12px 26px;
  }

  .profile-field{
    min-width:0;
  }

  .profile-inputbox,
  .profile-selectbox,
  .profile-phonebox,
  .profile-datebox{
    min-height:62px;
    border:1px solid #d7dae3;
    border-radius:14px;
    background:#fff;
    padding:12px 14px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:10px;
    transition:border-color .18s ease, box-shadow .18s ease, transform .18s ease;
  }

  .profile-inputbox:focus-within,
  .profile-selectbox:focus-within,
  .profile-phonebox:focus-within,
  .profile-datebox:focus-within{
    border-color:rgba(111,99,246,.45);
    box-shadow:0 0 0 4px rgba(111,99,246,.08);
    transform:translateY(-1px);
  }

  .profile-meta{
    min-width:0;
    flex:1 1 auto;
  }

  .profile-label{
    display:block;
    font-size:12px;
    line-height:1.25;
    color:#73798a;
    margin-bottom:6px;
    font-weight:500;
  }

  .profile-value,
  .profile-placeholder{
    display:block;
    font-size:16px;
    line-height:1.35;
    color:#111827;
    font-weight:500;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
  }

  .profile-placeholder{
    color:#111827;
  }

  .profile-input,
  .profile-select,
  .profile-date-input,
  .profile-phone-input{
    width:100%;
    border:none;
    outline:none;
    background:transparent;
    font-size:16px;
    line-height:1.35;
    color:#111827;
    font-weight:500;
    padding:0;
    margin:0;
    font-family:inherit;
  }

  .profile-input::placeholder,
  .profile-phone-input::placeholder,
  .profile-date-input::placeholder{
    color:#9aa0ad;
  }

  .profile-select{
    appearance:none;
    -webkit-appearance:none;
    -moz-appearance:none;
    cursor:pointer;
  }

  .profile-date-input{
    cursor:pointer;
  }

  .profile-date-input::-webkit-calendar-picker-indicator{
    position:absolute;
    inset:0;
    width:100%;
    height:100%;
    opacity:0;
    cursor:pointer;
  }

  .profile-datebox{
    position:relative;
  }

  .profile-phonebox{
    justify-content:flex-start;
    gap:12px;
  }

  .profile-flag{
    font-size:24px;
    line-height:1;
    flex:0 0 auto;
  }

  .profile-phone-prefix{
    display:inline-flex;
    align-items:center;
    gap:6px;
    white-space:nowrap;
    font-size:16px;
    color:#111827;
    font-weight:500;
    flex:0 0 auto;
  }

  .profile-phonebox .profile-meta{
    min-width:0;
    flex:1 1 auto;
  }

  .profile-phone-prefix svg,
  .profile-datebox svg,
  .profile-selectbox svg{
    width:18px;
    height:18px;
    stroke:currentColor;
    fill:none;
    stroke-width:2;
    stroke-linecap:round;
    stroke-linejoin:round;
    color:#6b7280;
    flex:0 0 auto;
  }

  .profile-actions{
    display:flex;
    justify-content:flex-end;
    margin-top:22px;
  }

  .profile-save{
    min-width:200px;
    min-height:58px;
    border:none;
    border-radius:999px;
    background:linear-gradient(180deg,#232328 0%,#121216 100%);
    color:#fff;
    font-size:16px;
    font-weight:700;
    cursor:pointer;
    box-shadow:0 14px 28px rgba(0,0,0,.16);
    transition:transform .18s ease, box-shadow .18s ease, filter .18s ease;
  }

  .profile-save:hover{
    transform:translateY(-2px);
    box-shadow:0 18px 34px rgba(0,0,0,.2);
    filter:brightness(1.01);
  }

  .profile-addresses{
    display:grid;
  }

  .profile-address{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:20px;
    padding:28px 28px 24px;
    border-bottom:1px solid var(--profile-line);
  }

  .profile-address:last-child{
    border-bottom:none;
  }

  .profile-address__title{
    margin:0 0 10px;
    font-size:22px;
    line-height:1.2;
    font-weight:600;
    color:#10131b;
  }

  .profile-address__lines{
    margin:0;
    font-size:16px;
    line-height:1.65;
    color:#111827;
    white-space:pre-line;
  }

  .profile-address__actions{
    display:flex;
    gap:10px;
    flex:0 0 auto;
  }

  .profile-btn-outline,
  .profile-btn-soft{
    min-width:84px;
    min-height:54px;
    padding:0 22px;
    border-radius:999px;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
    transition:transform .18s ease, box-shadow .18s ease, background .18s ease;
  }

  .profile-btn-outline{
    border:1.5px solid #5a5b60;
    background:#fff;
    color:#2b2b31;
  }

  .profile-btn-soft{
    border:none;
    background:#f1f1f4;
    color:#2b2b31;
  }

  .profile-btn-outline:hover,
  .profile-btn-soft:hover{
    transform:translateY(-1px);
    box-shadow:0 10px 22px rgba(15,23,42,.06);
  }

  .profile-notify{
    padding:28px 28px 18px;
  }

  .profile-notify__group + .profile-notify__group{
    border-top:1px solid var(--profile-line);
    margin-top:26px;
    padding-top:26px;
  }

  .profile-notify__title{
    margin:0 0 24px;
    font-size:22px;
    line-height:1.2;
    font-weight:600;
    color:#10131b;
  }

  .profile-notify__item{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:18px;
    margin-bottom:24px;
  }

  .profile-notify__item:last-child{
    margin-bottom:0;
  }

  .profile-notify__label{
    margin:0 0 6px;
    font-size:16px;
    line-height:1.35;
    color:#6b7280;
    font-weight:500;
  }

  .profile-notify__desc{
    margin:0;
    font-size:16px;
    line-height:1.5;
    color:#111827;
  }

  .profile-switch{
    position:relative;
    display:inline-flex;
    align-items:center;
    width:48px;
    height:28px;
    flex:0 0 auto;
  }

  .profile-switch input{
    position:absolute;
    opacity:0;
    pointer-events:none;
  }

  .profile-switch span{
    position:relative;
    display:block;
    width:48px;
    height:28px;
    border-radius:999px;
    background:var(--profile-toggle-off);
    transition:background .18s ease;
  }

  .profile-switch span::after{
    content:"";
    position:absolute;
    top:3px;
    left:3px;
    width:22px;
    height:22px;
    border-radius:50%;
    background:#fff;
    box-shadow:0 2px 6px rgba(15,23,42,.12);
    transition:transform .18s ease;
  }

  .profile-switch input:checked + span{
    background:var(--profile-green);
  }

  .profile-switch input:checked + span::after{
    transform:translateX(20px);
  }

  @keyframes profileFadeUp{
    from{
      opacity:0;
      transform:translateY(18px);
    }
    to{
      opacity:1;
      transform:translateY(0);
    }
  }

  @keyframes profileCardFade{
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
    .profile-title{
      font-size:60px;
    }
  }

  @media (max-width: 767px){
    .profile-hero{
      padding:28px 14px 28px;
    }

    .profile-content{
      padding:28px 14px 48px;
    }

    .profile-wrap{
      width:min(100%, calc(100% - 8px));
    }

    .profile-back{
      font-size:16px;
      gap:8px;
      margin-bottom:14px;
    }

    .profile-title{
      font-size:46px;
      line-height:1;
    }

    .profile-section{
      margin-bottom:26px;
    }

    .profile-section__title{
      font-size:18px;
      margin-bottom:12px;
    }

    .profile-card--padded,
    .profile-notify{
      padding:18px;
    }

    .profile-grid{
      grid-template-columns:1fr;
      gap:10px;
    }

    .profile-inputbox,
    .profile-selectbox,
    .profile-phonebox,
    .profile-datebox{
      min-height:58px;
      border-radius:14px;
      padding:10px 12px;
    }

    .profile-value,
    .profile-placeholder,
    .profile-phone-prefix,
    .profile-address__lines,
    .profile-notify__desc,
    .profile-input,
    .profile-select,
    .profile-date-input,
    .profile-phone-input{
      font-size:15px;
    }

    .profile-actions{
      margin-top:16px;
    }

    .profile-save{
      width:100%;
      min-width:100%;
      min-height:54px;
      font-size:15px;
    }

    .profile-address{
      flex-direction:column;
      align-items:flex-start;
      padding:22px 18px;
    }

    .profile-address__title,
    .profile-notify__title{
      font-size:18px;
    }

    .profile-address__actions{
      width:100%;
    }

    .profile-btn-outline,
    .profile-btn-soft{
      flex:1 1 0;
      min-height:50px;
      min-width:0;
      font-size:15px;
      padding:0 14px;
    }

    .profile-notify__item{
      gap:12px;
      margin-bottom:20px;
    }

    .profile-notify__label{
      font-size:15px;
    }
  }
</style>

<script>
  document.body.classList.add('profile-page-body');
</script>

<main class="profile-page">
  <section class="profile-hero">
    <div class="profile-wrap">
      <a class="profile-back" href="{{ route('my-account') }}">
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 18l-6-6 6-6"></path></svg>
        <span>Account</span>
      </a>
      <h1 class="profile-title">Profile</h1>
    </div>
  </section>

  <section class="profile-content">
    <div class="profile-wrap">
      <section class="profile-section">
        <h2 class="profile-section__title">Personal Details</h2>
        <div class="profile-card profile-card--padded">
          <form class="profile-form" id="profileForm" action="#" method="post">
            
            <div class="profile-grid">
	<!-- First Name -->
	<div class="profile-field">
		<div class="profile-inputbox">
			<div class="profile-meta"> <span class="profile-label">First Name</span>
				<input class="profile-input" type="text" name="first_name" id="first_name" value="{{ Auth::guard('customer')->user()->first_name }}" placeholder="First Name"> </div>
		</div>
	</div>
	<!-- Last Name -->
	<div class="profile-field">
		<div class="profile-inputbox">
			<div class="profile-meta"> <span class="profile-label">Last Name</span>
				<input class="profile-input" type="text" name="last_name" id="last_name" value="{{ Auth::guard('customer')->user()->last_name }}" placeholder="Last Name"> </div>
		</div>
	</div>
	<!-- Mobile -->
	<div class="profile-field">
		<div class="profile-phonebox">
			<div class="profile-meta"> <span class="profile-label">Phone number</span>
				<input class="profile-phone-input" type="tel" name="mobile" id="mobile" value="{{ Auth::guard('customer')->user()->mobile }}" placeholder="Phone number" maxlength="10"> </div>
		</div>
	</div>
	<!-- Email -->
	<div class="profile-field">
		<div class="profile-inputbox">
			<div class="profile-meta"> <span class="profile-label">Email</span>
				<input class="profile-input" type="email" name="email" id="email" value="{{ Auth::guard('customer')->user()->email }}" placeholder="Email" readonly> </div>
		</div>
	</div>
	<!-- DOB -->
	<div class="profile-field">
		<div class="profile-datebox">
			<div class="profile-meta"> <span class="profile-label">Date of birth (optional)</span>
				<input class="profile-date-input" type="date" name="dob" id="dob" value="{{ Auth::guard('customer')->user()->dob }}"> </div>
		</div>
	</div>
	<!-- Gender -->
	<div class="profile-field">
		<div class="profile-selectbox">
			<div class="profile-meta"> <span class="profile-label">Gender (optional)</span>
				<select class="profile-select" name="gender" id="gender">
					<option value="">Select gender</option>
					<option value="Male" {{ Auth::guard( 'customer')->user()->gender == 'Male' ? 'selected' : '' }}>Male</option>
					<option value="Female" {{ Auth::guard( 'customer')->user()->gender == 'Female' ? 'selected' : '' }}>Female</option>
				</select>
			</div>
		</div>
	</div>
</div>
<!-- Message -->
<div class="px-4" id="subitMessage"></div>
<!-- Button -->
<div class="profile-actions">
	<button class="profile-save" type="button" onclick="updateProfile()"> Save changes </button>
</div>
            
            
          </form>
        </div>
      </section>

      <section class="profile-section">
        <h2 class="profile-section__title">Addresses</h2>
        <div class="profile-card">
          <div class="profile-addresses">
            <div class="profile-address">
              <div>
                <h3 class="profile-address__title">Shipping</h3>
                <p class="profile-address__lines">Aditya Gupta
Noida, Noida,
Arizona, United States Of America
201301
918882653043</p>
              </div>
              <div class="profile-address__actions">
                <button class="profile-btn-outline" type="button">Edit</button>
                <button class="profile-btn-soft" type="button">Delete</button>
              </div>
            </div>

            <div class="profile-address">
              <div>
                <h3 class="profile-address__title">Billing</h3>
                <p class="profile-address__lines">Aditya Gupta
Noida, Noida,
Arizona, United States Of America
201301</p>
              </div>
              <div class="profile-address__actions">
                <button class="profile-btn-outline" type="button">Edit</button>
                <button class="profile-btn-soft" type="button">Delete</button>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="profile-section">
        <h2 class="profile-section__title">Notification Preferences</h2>
        <div class="profile-card">
          <div class="profile-notify">
            <div class="profile-notify__group">
              <h3 class="profile-notify__title">Email</h3>

              <div class="profile-notify__item">
                <div>
                  <p class="profile-notify__label">Reminders</p>
                  <p class="profile-notify__desc">Email reminders about your appointments.</p>
                </div>
                <label class="profile-switch">
                  <input type="checkbox" checked>
                  <span></span>
                </label>
              </div>

              <div class="profile-notify__item">
                <div>
                  <p class="profile-notify__label">Marketing updates</p>
                  <p class="profile-notify__desc">Email updates about offers, products and services.</p>
                </div>
                <label class="profile-switch">
                  <input type="checkbox" checked>
                  <span></span>
                </label>
              </div>
            </div>

            <div class="profile-notify__group">
              <h3 class="profile-notify__title">SMS</h3>

              <div class="profile-notify__item">
                <div>
                  <p class="profile-notify__label">Reminders</p>
                  <p class="profile-notify__desc">SMS reminders about your appointments.</p>
                </div>
                <label class="profile-switch">
                  <input type="checkbox" checked>
                  <span></span>
                </label>
              </div>

              <div class="profile-notify__item">
                <div>
                  <p class="profile-notify__label">Marketing updates</p>
                  <p class="profile-notify__desc">SMS updates about offers, products and services.</p>
                </div>
                <label class="profile-switch">
                  <input type="checkbox">
                  <span></span>
                </label>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </section>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  (function(){
    const dobInput = document.getElementById('profileDob');

    if (dobInput) {
      const openDatePicker = () => {
        if (typeof dobInput.showPicker === 'function') {
          dobInput.showPicker();
        } else {
          dobInput.focus();
          dobInput.click();
        }
      };

      const dateBox = dobInput.closest('.profile-datebox');
      if (dateBox) {
        dateBox.addEventListener('click', function(e){
          if (e.target.tagName !== 'INPUT') {
            openDatePicker();
          }
        });
      }
    }
  })();
</script>


<script>


    function addUserAddress(address_type,address_id,country,state,city,address) {
        
        if(address_type!=''){
            
            $("#newAdressModal").modal('show');
            $("#address_type").val(address_type);
            $("#address_id").val(address_id);
            $("#country").val(country);
            $("#state").val(state);
            $("#city").val(city);
            $("#address").val(address);
            
        }else{
            
            $("#newAdressModal").modal('show');
            $("#address_type").val('');
            $("#address_id").val('');
            $("#country").val('');
            $("#state").val('');
            $("#city").val('');
            $("#address").val('');
            
        }
    }

    
    function updateAddress() {
        
        var address_id = $('#address_id').val();
        var address_type = $('#address_type').val();
        var country = $('#country').val();
        var state = $('#state').val();
        var city = $('#city').val();
        var address = $('#address').val();
        
        if (address_type == '') {
            
            $('#address_type').focus();
            //alert('Enter address_type.');
            return false;
        } else {
        }
        
        if (country == '') {
            $('#country').focus();
            //alert('Enter country.');
            return false;
        } else {
        }
        
        if (state == '') {
            $('#state').focus();
            //alert('Enter state.');
            return false;
        } else {
        }
        
        if (city == '') {
            $('#city').focus();
            //alert('Enter city.');
            return false;
        } else {
        }
        
        if (address == '') {
            $('#address').focus();
            //alert('Enter address.');
            return false;
        } else {
        }
        
        
        
        return $.ajax({
            url: "{{ route('updateAddress') }}",
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                address_id: address_id,
                address_type: address_type,
                country: country,
                state: state,
                city: city,
                address: address
            },
            beforeSend: function(res) {
                //$('#state').html('<option value="">Loading...</option>');
            },
            success: function(res) {
                //console.log(res);
                if(res.status=='success'){
                   
                    $('#subitAddMessage').html('<div id="alertMessage" class="alert alert-success" role="alert">Address updated successfully!</div>');
                    window.location.reload();
                }else{
                    $('#subitAddMessage').html('<div id="alertMessage" class="alert alert-danger" role="alert">Something went wrong!</div>');  
                }
            }
        })
    }
    
    
    function updateProfile() {
        
        var first_name = $('#first_name').val();
        var last_name = $('#last_name').val();
        var email = $('#email').val();
        var mobile = $('#mobile').val();
        var dob = $('#dob').val();
        var gender = $('#gender').val();
        
        if (first_name == '') {
            
            $('#first_name').focus();
            //alert('Enter first name.');
            return false;
        } else {
        }
        
        /*if (email == '') {
            $('#email').focus();
            //alert('Enter email.');
            return false;
        } else {
        }*/
        
        if (mobile == '') {
            $('#mobile').focus();
            //alert('Enter mobile.');
            return false;
        } else {
        }
        
        
        
        return $.ajax({
            url: "{{ route('updateProfile') }}",
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                first_name: first_name,
                last_name: last_name,
                email: email,
                mobile: mobile,
                dob: dob,
                gender: gender
            },
            beforeSend: function(res) {
                //$('#state').html('<option value="">Loading...</option>');
            },
            success: function(res) {
                //console.log(res);
                if(res.status=='success'){
                    /*$('#first_name').val('');
                    $('#last_name').val('');
                    $('#email').val('');
                    $('#mobile').val('');
                    $('#dob').val('');
                    $('#gender').val('');*/
                    
                    $('#subitMessage').html('<div id="alertMessage" class="alert alert-success" role="alert">Profile updated successfully!</div>');
                    window.location.reload();
                }else{
                    $('#subitMessage').html('<div id="alertMessage" class="alert alert-danger" role="alert">Something went wrong!</div>');  
                }
            }
        })
    }
    
</script>

@include('frontend.partials.footer')