@extends('frontend.layout.app')

@section('content')

<?php use App\Models\CheckedService; ?>

  

        <div class="mt-5 pt-5">
            <!--<div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Services</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Professional</li>
                        </ol>
                        </nav>
                    </div>
                </div>
            </div>-->
        </div>
        <div class="services_select selcet-time pb-5">
            <div class="container-fluid">
                <div class="row">
                    
                    
                    <div class="col-lg-8">
                        <h2>Select professional</h2>

                        <div class="row">
                            <!--<div class="col-md-4">
                                <a href="#"class="professional_box">
                                    <div class="box_prof">
                                     <i class="fa-solid fa-users"></i>
                                     <p>Any professional</p>
                                     <span>for maximum availability</span>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="#"class="professional_box">
                                    <div class="box_prof">
                                    <i class="fa-solid fa-user-plus"></i>
                                     <p>Select professional per service</p>
                                    </div>
                                </a>
                            </div>-->
                            
                            @foreach ($professionals as $item) 
                            <div class="col-md-4 mb-2">
                                <a href="javascript:void(0)" class="professional_box" id="professional-{{ $item->id }}" onclick="selectProfessional('{{ $item->id }}','professional-{{ $item->id }}')">
                                    <div class="box_prof">
                                        <div class="img_box_professional">
                                            <img src="{{ !empty($item->profile) ? asset('uploads/professional/' . $item->profile) : asset('frontend/images/dummyuser.png') }}" alt="" style="height:75px; width:75px;">
                                            <p>4.8  <i class="fa-solid fa-star"></i></p>
                                        </div>
                                     <p>{{ $item->professional_name }}</p>
                                     <span>{{ $item->designation }}, {{ $item->profession }}</span>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                        
                        
                        <!--<a href="#" class="select_time_any_prof mb-4"> 
                            <span class="user_icon-prof1">
                                <i class="fa-regular fa-user"></i>
                            </span>
                            <p>Any professional</p>
                            <span class="user_icon-prof">
                                <i class="fa-solid fa-angle-down"></i>
                            </span>
                        </a>-->
                        
                        <h2 class="mb-3">Select time</h2>

                        <h6><b>{{ $currentMonth }}</b></h6>
                        <div class="time-select-slider">
                               
                              @foreach ($dates as $date)
                               <div>
                                  <div class="cercailtime" id="{{ $date['date'] }}-{{ $date['day'] }}" pdate="{{ $date['day'] }}" pdate="{{ $date['date'] }}" 
                                  pslot_date="{{ $date['slot_date'] }}" proid="0" onclick="selectedDate('{{ $date['date'] }}-{{ $date['day'] }}')">
                                      <p>{{ $date['date'] }}</p>
                                  </div>
                                    <span>{{ $date['day'] }}</span>
                               </div>
                               @endforeach
                            
                        </div>
                        <div class="scroll_box py-3">
                            <div class="scroll_inner_box" id="availableSlot"> 
                             
                                
                          
                            </div>
                      
                        </div>
                    </div>
                    
                    <div class="col-lg-4 mt-4">
                        <div class="card total-continue shadow-sm doctor-sec">
                            <div class="">
                                <div class="card-body p-0">
                                    <!--<div class="p-4">
                                        <h5 class="card-title fw-bold">Diamond Skin - Doctor Led Aesthetic and Laser Clinic</h5>
                                        <div class="d-flex align-items-center mb-2 fs-5">
                                            <span class="me-2 fw-bold">5.0</span>
                                            <span class="text-warning me-1">&#9733; &#9733; &#9733; &#9733; &#9733;</span>
                                            <a href="#" class="text-decoration-none text-primary ms-1">(2,762)</a>
                                            
                                        </div>
                                        <div>
                                                  <p>UK, 348 High Road, Wembley</p>
                                        </div>
                                        
                                    </div>-->
                                    
                                      <div class="total-continue p-4">
                                      <b>Services</b>
                                      <hr class="dropdown-divider2">  
                                      <?php $totalprice = 0; ?>
                                      @foreach($systems as $system)
                                      <?php 
                                      $checked_service = $system->getCheckedService;
                                      $totalprice = $totalprice+$checked_service->price;
                                      ?>
                                      <div class="d-flex justify-content-between center-box mb-3">
                                        <div>
                                          <p>{{ $checked_service->property_name }}</p>
                                          <span>{{ $checked_service->duration }} minutes</span>
                                        </div>
                                        <p>£{{ $checked_service->price }}</p>
                                      </div>
                                      @endforeach
                                      <b>Addons</b>
                                      <hr class="dropdown-divider2">
                                      @foreach($addonsystems as $addonsystem)
                                      <?php 
                                      $checked_addon = $addonsystem->getCheckedAddon;
                                      $totalprice = $totalprice+$checked_addon->price;
                                      ?>
                                      <div class="d-flex justify-content-between center-box mb-3">
                                        <div>
                                          <p>{{ $checked_addon->addon_name }}</p>
                                          <!--<span>{{ $checked_addon->duration }} minutes</span>-->
                                        </div>
                                        <p>£{{ $checked_addon->price }}</p>
                                      </div>
                                      @endforeach
                                      
                                      <hr class="dropdown-divider2">
                                      <div class="d-flex justify-content-between center-box2">
                                        <div>
                                          <p>Total</p>
                                        </div>
                                        <p>£{{ $totalprice }}</p>
                                      </div>
                                      <a href="javascript:void(0)" class="btn btnform" onclick="saveSelectedData()">Continue</a>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                            
                            
                </div>
            </div>
        </div>
                </div>







<script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/js/slick.js') }}"></script>
    <script src="{{ asset('frontend/js/all.min.js') }}"></script>


<script>
    
    function selectProfessional(professional_id) {
        
        $('.professional_box').removeClass('active');
        $('#professional-'+professional_id).addClass('active');
        $('.cercailtime').attr('proid', professional_id);
        
        if ($('.slick-slide').hasClass('slick-current')) {
            const activeElement = $('.slick-current .cercailtime');
            const id = activeElement.attr('id'); 
            const pdate = activeElement.attr('pdate');
            const pslotDate = activeElement.attr('pslot_date');
            const proid = activeElement.attr('proid');
            
            timeSlot(proid,pslotDate);
        }
        
    }
    
    function selectedDate(date_id) {
        // Remove 'slick-current' class from all '.slick-slide' elements
        $('.slick-slide').removeClass('slick-current');
    
        // Find the target element by ID and add 'slick-current' to its parent '.slick-slide'
        const targetElement = $('#' + date_id);
        if (targetElement.length > 0) {
            targetElement.closest('.slick-slide').addClass('slick-current');
        } else {
            console.error('Target element not found for ID:', date_id);
            return; // Exit the function if the target element is not found
        }
    
        // Check if any '.slick-slide' now has the 'slick-current' class
        const activeSlide = $('.slick-slide.slick-current');
        if (activeSlide.length > 0) {
            const activeElement = activeSlide.find('.cercailtime');
            if (activeElement.length > 0) {
                // Retrieve attributes from the active '.cercailtime' element
                const id = activeElement.attr('id');
                const pdate = activeElement.attr('pdate');
                const pslotDate = activeElement.attr('pslot_date');
                const proid = activeElement.attr('proid');
                if(proid=='0'){
                    alert('Please select professional.');
                    return false;
                }
                // Call the timeSlot function with the appropriate arguments
                timeSlot(proid, pslotDate);
            } else {
                console.error('No .cercailtime element found inside slick-current.');
            }
        } else {
            console.error('No .slick-slide with slick-current class found.');
        }
    }

    
    function timeSlot(professional_id,sdate) {
        
        
        return $.ajax({
            url: "{{ route('timeSlot') }}",
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                professional_id: professional_id,
                sdate: sdate,
               
            },
            beforeSend: function(res) {
                //$('#state').html('<option value="">Loading...</option>');
            },
            success: function(res) { 
                console.log(res);
                $('#availableSlot').html(res.abc);
                // if(res.status=='success'){
                //     $('#sid').val('');
                    
                //     $('#subitMessage').html('<div id="alertMessage" class="alert alert-success" role="alert">Form submitted successfully!</div>');
                // }else{
                //     $('#subitMessage').html('<div id="alertMessage" class="alert alert-danger" role="alert">Something went wrong!</div>');  
                // }
            }
        })
    }
    
    function selectTimeSlot(slot_id) {
        
        $('.inner_child_box').removeClass('active');
        $('#slot-'+slot_id).addClass('active');
        
    }
    
    function saveSelectedData() {
        
        if ($('.professional_box').hasClass('active')) {
            //alert('professional');
        }else{
            alert('Please select professional');
            return false;
        }
        
        if ($('.slick-slide').hasClass('slick-current')) {
            const activeElement = $('.slick-current .cercailtime');
            var id = activeElement.attr('id'); 
            var pdate = activeElement.attr('pdate');
            var pslotDate = activeElement.attr('pslot_date');
            var proid = activeElement.attr('proid');
            
        }else{
            alert('Please select date');
            return false;
        }
        
        if ($('.inner_child_box').hasClass('active')) {
            const activeSlot = $('.inner_child_box.active'); // Target the element with both classes
            var slot_id = activeSlot.attr('slot_id'); 
            var slot_time = activeSlot.attr('slot_time');
        
            /*if (slot_id && slot_time) {
                alert(`Slot ID: ${slot_id}, Slot Time: ${slot_time}`);
            } else {
                alert('Slot ID or Slot Time is missing.');
            }*/
        } else {
            alert('Please select time');
            return false;
        }
        
        return $.ajax({
            url: "{{ route('saveSelectedData') }}",
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                professional_id: proid,
                slot_date: pslotDate,
                slot_id: slot_id,
                slot_time: slot_time,
               
            },
            beforeSend: function(res) {
                //$('#state').html('<option value="">Loading...</option>');
            },
            success: function(res) { 
                //console.log(res);
                //$('#availableSlot').html(res.abc);
                if(res.status=='success'){
                    window.location.href = 'checkout';
                }else{
                    $('#subitMessage').html('<div id="alertMessage" class="alert alert-danger" role="alert">Something went wrong!</div>');  
                }
            }
        })
        
    }
    
</script>

 <script>
        $('.time-select-slider').slick({
        dots: false,
        autoplay: false,
        arrows:true,
        infinite: false,
        slidesToShow: 9,
        slidesToScroll: 1,
        responsive: [
            {
            breakpoint: 1024,
            settings: {
                slidesToShow: 9,
                slidesToScroll: 1,
                infinite: false,
                dots: false
            }
            },
            {
            breakpoint: 600,
            settings: {
                slidesToShow: 5,
                slidesToScroll: 1
            }
            },
            {
            breakpoint: 480,
            settings: {
                slidesToShow: 4,
                slidesToScroll: 1
            }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
        });
        $(document).ready(function() {

            $(window).scroll(function() {
                if ($(window).scrollTop() > 100) {
                    $('header').css("background", "#fff");
                } else {
                    $('header').css("background", "transparent");
                }
            });

            });
            
    </script>



  
@endsection

