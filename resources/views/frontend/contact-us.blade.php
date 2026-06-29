@extends('frontend.layout.app')

@section('content')

<style>
  .booking-option {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 45px; /* Increase the width to match design */
  height: 45px; /* Increase height for better proportions */
  border-radius: 50%;
  background-color: #1e3a4d; /* Dark Blue */
  color: white;
  font-size: 24px;
  transition: 0.3s;
  margin-left: 10px;
  margin-top: 10px;
}

.booking-option i {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  height: 100%;
}

.booking-option:hover {
  background-color: #152636;
  color: white;
}

.booking-text {
  font-size: 14px;
  margin-top: 8px;
  color: #1e3a4d; /* Text color */
  text-align: center;
}

  </style>

<div class="breadcrumb-cell" aria-label="breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ol class="breadcrumb mb-0">
                        <a href="{{ url('/') }}"> Home </a> &gt; 
                        @if(session('app_locale')=='cn')
                        ہم سے رابطہ کریں۔
                        @elseif(session('app_locale')=='ar')
                        اتصل بنا
                        @else
                        Contact Us
                        @endif
                    </ol>
                </div>
            </div>
        </div>
    </div>
    

 <section style="">
    
<div class="container">
    <h2 class="mb-1 fw-semibold text-center" >
        @if(session('app_locale')=='cn')
        ہم سے رابطہ کریں۔
        @elseif(session('app_locale')=='ar')
        اتصل بنا
        @else
        Contact Us
        @endif
    </h2>
    
    
<div class="container py-5">
<div class="row">
    @foreach ($clinics as $item)
	<div class="col-lg-4 mb-3">
		<div id="bank-clinic-20-eastcheap" class="card text-center shadow ">
			<h2 class="h3 card-title p-3">{{ $item->clinic_name }}</h2> 
			<div style="height:231px; overflow: hidden;">
			<img src="{{ asset('uploads/clinic/'.$item->profile) }}" class="card-img-top img-fluid mb-3 " style="width: 100%;
  
  object-fit: contain; " alt="Peek house entrance">
  </div>
			<span style="margin-top: -48px;">
			    <img style="width:40px; height:55px;" src="{{ asset('frontend/images/ic-clinic-pin.webp') }}">
			</span>
			<div class="card-body"> 
        	    <address>
                    <a href="{{ $item->google_map }}" 
                       target="_blank" rel="noopener" class="d-block mb-3" style="height: 42px; align-items: center; display: flex ;">
                      {{ $item->address }}
                    </a>
                </address>
				<p class="mb-2"><img style="width:40px; height:40px;" src="{{ asset('frontend/images/ic-clinic-times.webp') }}"></p>
				<p class="mb-2">Mon-Fri: @if($item->mon_to_fry=='1')
                        				{{ \Carbon\Carbon::parse($item->clinic_start_time)->format('H:i') }}-{{ \Carbon\Carbon::parse($item->clinic_close_time)->format('H:i') }}
                        				@else Closed @endif
					<br>Sat: @if($item->sat=='1')
            				{{ \Carbon\Carbon::parse($item->sat_start_time)->format('H:i') }}-{{ \Carbon\Carbon::parse($item->sat_close_time)->format('H:i') }}
            				@else Closed @endif
					<br>Sun: @if($item->sun=='1')
            				{{ \Carbon\Carbon::parse($item->sun_start_time)->format('H:i') }}-{{ \Carbon\Carbon::parse($item->sun_close_time)->format('H:i') }}
            				@else Closed @endif</p>
				<h3 class="h5 mt-4">Book Your Free Consultation</h3>
				<div class="d-flex justify-content-center gap-3">
                    <!-- In-clinic -->
                    <div class="text-center">
                      <a href="{{ url('book-free-consultation') }}" 
                         target="_blank" class="booking-option">
                        <i class="fas fa-map-marker-alt"></i>
                      </a>
                      <p class="booking-text">In-clinic</p>
                    </div>
                
                    <!-- By Phone -->
                    <div class="text-center">
                      <a href="tel:{{ $item->clinic_phone }}" 
                         target="_blank" class="booking-option">
                        <i class="fas fa-phone"></i>
                      </a>
                      <p class="booking-text">By Phone</p>
                    </div>
                
                    <!-- By Video -->
                    <!--<div class="text-center">
                      <a href="{{ url('book-free-consultation') }}" 
                         target="_blank" class="booking-option">
                        <i class="fas fa-video"></i>
                      </a>
                      <p class="booking-text">By Video</p>
                    </div>-->
                
                    <!-- WhatsApp -->
                    <div class="text-center">
                      <a href="https://wa.me/{{ $item->clinic_whatsapp }}?text=Can%20you%20please%20help%20with%20my%20enquiry?" 
                         target="_blank" class="booking-option">
                        <i class="fab fa-whatsapp"></i>
                      </a>
                      <p class="booking-text">WhatsApp</p>
                    </div>
                  </div>

				<p class="h5 my-3">Call Us: <a href="tel:{{ $item->clinic_phone }}">{{ $item->clinic_phone }}</a></p>
				<a href="{{ url('book-free-consultation') }}" class="bigbtn primary-btn btn"> Book Free Consultation</a>
				
				<hr>
				<div style="height:250px;">
				    @if($item->metro_name!='')
    				<p class="mb-2"><img style="width:62px; height:51px;" src="{{ asset('frontend/images/ic-clinic-tube.png') }}"></p>
    				<p class="underground"> <strong style="font-weight: 1000 !important;">{{ $item->metro_name }}</strong><br>{{ $item->metro_text }}</p>
    				@endif
    				@if($item->railway_name!='')
    				<p class="mb-2"><img style="width:62px; height:51px;" src="{{ asset('frontend/images/ic-clinic-train.png') }}"></p>
    				<p class="underground"> <strong style="font-weight: 1000 !important;">{{ $item->railway_name }}</strong><br>{{ $item->railway_text }}</p>
    				@endif
				</div>
			</div>
		</div>
	</div>
	@endforeach
</div>
</div>

</div>
</section>


<script>
    
    function consultationFormSave() {
        
        var first_name = $('#first_name').val();
        var last_name = $('#last_name').val();
        var email = $('#email').val();
        var mobile = $('#mobile').val();
        var clinic = $('#clinic').val();
        var service = $('#service').val();
        var selected_date = $('#selected_date').val();
        var selected_time = $('#selected_time').val();
        var message = $('#message').val();
        
        if (first_name == '') {
            
            $('#first_name').focus();
            //alert('Enter first name.');
            return false;
        } else {
        }
        
        if (email == '') {
            $('#email').focus();
            //alert('Enter email.');
            return false;
        } else {
        }
        
        if (mobile == '') {
            $('#mobile').focus();
            //alert('Enter mobile.');
            return false;
        } else {
        }
        
        if (clinic == '') {
            $('#clinic').focus();
            //alert('Enter clinic.');
            return false;
        } else {
        }
        
        if (service == '') {
            $('#service').focus();
            //alert('Enter service.');
            return false;
        } else {
        }
        
        if (message == '') {
            $('#message').focus();
            //alert('Enter message.');
            return false;
        } else {
        }
        
        
        return $.ajax({
            url: "{{ route('consultationFormSave') }}",
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                ctype: 'form',
                first_name: first_name,
                last_name: last_name,
                email: email,
                mobile: mobile,
                clinic: clinic,
                service: service,
                message: message
            },
            beforeSend: function(res) {
                //$('#state').html('<option value="">Loading...</option>');
            },
            success: function(res) {
                //alert(res.status); 
                if(res.status=='success'){
                    $('#first_name').val('');
                    $('#last_name').val('');
                    $('#email').val('');
                    $('#mobile').val('');
                    $('#clinic').val('');
                    $('#service').val('');
                    $('#message').val('');
                    
                    $('#subitMessage').html('<div id="alertMessage" class="alert alert-success" role="alert">Form submitted successfully!</div>');
                }else{
                    $('#subitMessage').html('<div id="alertMessage" class="alert alert-danger" role="alert">Something went wrong!</div>');  
                }
                
            }
        })
    }
    
</script>

 
@endsection

