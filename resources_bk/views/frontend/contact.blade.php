@extends('frontend.layout.app')

@section('content')

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
    
<section class="banner-hero p-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 p-0">
                    <div class="homepage-slider-banner">
                    @foreach ($home_top_banner as $item)  
                    
                    <?php 
                    if(session('app_locale')=='cn'){
                        if($item->profile_cn!=''){
                        $profile11 = $item->profile_cn;
                        }else{
                        $profile11 = $item->profile;
                        }
                    }elseif(session('app_locale')=='ar'){
                        if($item->profile_ar!=''){
                        $profile11 = $item->profile_ar;
                        }else{
                        $profile11 = $item->profile;
                        }
                    }else{
                        $profile11 = $item->profile;
                    }
                    ?>
                    
                    
                    <a href="#">
                        <img src="{{ !empty($profile11) ? asset('uploads/banner/' . $profile11) : asset('uploads/userimage/no-banner.jpg') }}" alt="">
                    </a>
                    @endforeach
                </div>
                </div>
            </div>
        </div>
        
    </section>
    
 <section >
    
<div class="container mt-1" >
    @if(session('app_locale')=='cn')
    <h2 class="mb-1 fw-semibold" >اپنی مفت مشاورت کا بندوبست کریں۔</h2>
    <p class="mb-1">آپ کے فارم کو پُر کرنے کے کچھ ہی دیر بعد ہمارا ایک دوستانہ مشیر آپ کو معلومات فراہم کرنے اور اپنی مشاورت بُک کرنے کے لیے کال کرے گا۔ ابھی کال کریں یا نیچے بک کریں۔</p>
    
    @elseif(session('app_locale')=='ar')
    <h2 class="mb-1 fw-semibold" >احجز استشارتك المجانية</h2>
    <p class="mb-1">بعد تعبئة النموذج مباشرةً، سيتصل بك أحد مستشارينا الودودين لتقديم المعلومات وحجز استشارتك. اتصل الآن أو احجز أدناه.</p>
   
    @else
    <h2 class="mb-1 fw-semibold" >Arrange Your Free Consultation</h2>
    <p class="mb-1">Shortly after you fill-up the form one of our friendly advisors will call you to offer information and book your consultation. Call now or book below.</p>
    
    @endif
    
    <div class="container py-5" style="display:none;">
    <div class="col-lg-12 mx-auto">
        <div class="card shadow p-4">
            <form class="ContantForm" method="post" action="">
                <div class="row g-3 row-gap">
                    <div class="col-md-6">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" placeholder="First Name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" placeholder="Last Name" required>
                    </div>
                </div>

                <div class="row g-3 row-gap">
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" placeholder="Email Address" required>
                    </div>
                    <div class="col-md-6">
                        <label for="mobile" class="form-label">Telephone Number</label>
                        <input type="tel" class="form-control" id="mobile" placeholder="Telephone Number" required>
                    </div>
                </div>

                <div class="row g-3 row-gap">
                    <div class="col-md-6">
                        <label for="clinic" class="form-label">Select a Clinic</label>
                        <select class="form-select" id="clinic" required>
                            <option value="">Select a Clinic</option>
                            @foreach ($clinics as $item)
                                <option value="{{ $item->id }}">{{ $item->clinic_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="service" class="form-label">Choose a Service</label>
                        <select class="form-select" id="service" required>
                            <option value="">Choose a Service</option>
                            @foreach ($categories as $item)
                                <option value="{{ $item->id }}">{{ $item->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                </div>
                
                <div class="row g-3 row-gap">
                    <div class="col-md-6">
                        <label for="selected_date" class="form-label">Select Date</label>
                        <input type="date" class="form-control" id="selected_date" name="selected_date" value="{{ date("Y-m-d") }}" min="{{ date("Y-m-d") }}" required >
                    </div>
                    <div class="col-md-6">
                        <label for="selected_time" class="form-label">Select Time</label>
                        <input type="time" class="form-control" id="selected_time" name="selected_time" value="{{ date("H:i:s") }}" min="{{ date("H:i:s") }}" required >
                    </div>
                    
                </div>

                <div class="mb-3 row-gap">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" rows="4" placeholder="Message" required></textarea>
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <button type="button" onclick="consultationFormSave()" class="btn btn-dark px-4">SUBMIT</button>
                    <p class="text-muted mt-md-0 mt-3">All your information is 100% secured.</p>
                </div>
                <div id="subitMessage" class="mt-3"></div>
            </form>
        </div>
    </div>
    </div>

</div>


<div class="container">
<iframe src="https://widgets.dslclinic.com/widget/booking/1VfAHyenJ0vG9Y6GCYuV" style="width: 100%;border:none;overflow: hidden;" scrolling="no" id="455QfUgABEwEQuKZWThq_1744021763443"></iframe><br><script src="https://widgets.dslclinic.com/js/form_embed.js" type="text/javascript"></script>
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

