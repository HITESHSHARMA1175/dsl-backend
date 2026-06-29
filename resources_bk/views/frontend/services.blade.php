@extends('frontend.layout.app')

@section('content')

<?php use App\Models\CheckedService; ?>
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY"></script>
    <style>
        #map {
            height: 500px;
            width: 100%;
        }
    </style>
<style> 
.fixed-right {
    width: 405px;
    /*position: fixed;*/
    /*top: 10%;*/
    /*right: 0;*/
    max-height:500px;
    /* transform: translateY(-50%); */
    /* width: 200px; */
    /* background-color: #f1f1f1; */
    /* padding: 10px; */
    /* box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); */
    /* border-left: 2px solid #ccc; */
    /*z-index: 1000;*/
}

.fixed-right-box {
    max-height: 500px;
    overflow: auto;
}

.scrollslider {
    height: 500px;
    overflow: auto;
}




</style>   
    <section class="heroSectionCarosal pb-0">
 
       <div id="heroCarouselContainer">
        <div class="heroCarousel">
          @foreach ($home_top_banner as $item)  
          <div><img src="{{ !empty($item->profile) ? asset('uploads/banner/' . $item->profile) : asset('uploads/userimage/no-banner.jpg') }}" alt="Slide 1"></div>
          @endforeach
        </div>
        <button class="heroCarousel-arrow prev">&#10094;</button>
        <button class="heroCarousel-arrow next">&#10095;</button>
      </div>
     </section>
   <section id="photos" style="margin-top: 120px; display:none;">
                 <div class="container mt-5" >
                     <div class="row">
                         <!-- Salon Name, Ratings, and Info -->
                         <div class="col-12 mb-3">
                             <h1 class="fw-bold"> Diamond Skin - Doctor Led Aesthetic and Laser Clinic</h1>
                             <div class="d-flex align-items-center">
                                 <span class="text-muted me-2">5.0</span>
                                 <span class="text-warning me-2">⭐⭐⭐⭐⭐</span>
                                 <a href="#" class="text-primary me-2">(2,760)</a>
                                 <span class="text-muted">• Open until 19:00 • City Centre, Nicosia</span>
                                 <a href="#" class="text-primary ms-2">Get directions</a>
                                </div>
                            </div>
                            
                            <!-- Main Image and Thumbnails -->
                            <div class="col-lg-8">
                                <div class="main-image">
                                    <img src="https://images.fresha.com/locations/location-profile-images/53477/2038856/f66a89a6-63d6-4a7a-921b-5b5cfa226a4f-HairEtcStudio-CY-Nicosia-CityCentre-Fresha.jpg?class=venue-gallery-large&dpr=2" class="img-fluid rounded" alt="Salon Image">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="row g-2">
                                    <div class="col-6 col-lg-12">
                                        <img src="https://images.fresha.com/locations/location-profile-images/53477/2038857/4346391c-4cc3-44a6-a3e6-dca88b4e229a.jpg?class=venue-gallery-small&dpr=2" class="img-fluid rounded" alt="Salon Thumbnail 1">
                                    </div>
                                    <div class="col-6 col-lg-12">
                                        <img src="https://images.fresha.com/locations/location-profile-images/53477/2038858/0a035d43-7fc6-478c-8932-a6e222d95d71.jpg?class=venue-gallery-small&dpr=2" class="img-fluid rounded" alt="Salon Thumbnail 2">
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-light w-100 rounded shadow-sm">See all images</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>


        <div class="services_select pb-5">
            <div class="container">

                <div class="row">
                    <div class="col-lg-8 scrollslider" >
                        <!--<nav id="navbar-example2" class="navbar bg-body-tertiary mb-3" style="display: unset;">
                            <div class="nav nav-pills" style="display: unset;">
                                <div class="services-select-slider">
                                    @foreach ($categories as $item)  
                                    <div class="nav-item">
                                        <a class="nav-link services-select-box" href="#scrollspyHeading{{ $item->id }}">{{ $item->category_name }}</a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </nav>-->
                        

                        <div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-root-margin="0px 0px 170px" data-bs-smooth-scroll="true" class="scrollspy-example bg-body-tertiary p-3 rounded-2" tabindex="0">
                        
                                @foreach ($service_categories as $item)  
                                <div class="">
                                    <h3>{{ $item->category_name }}</h3>
                                    <p>{{ $item->description }}</p>
                                    <div id="scrollspyHeading{{ $item->id }}">
                                            @foreach ($item->categoryServices as $serviceitem) 
                                            <?php 
                                            $system = CheckedService::where('stype', 'service')->where('sid', $serviceitem->id)->where('system_id', session('uuid'))->first(); 
                                            
                                            //$systemId = $system ? $system->id : 'Not Found'; // Check if $system is not null and get the id
                                            //echo $systemId; // Print the ID
                                            ?>
                                            <div>
                                                <div class="inner_child_box position-relative {{ $system ? 'selected active' : '' }}" sid="{{ $serviceitem->id }}" sname="{{ $serviceitem->property_name }}"
                                                sdur="{{ $serviceitem->duration }}" sdesc="{{ $serviceitem->description }}" sprice="{{ $serviceitem->price }}">
                                                    <div class="modaltarget"  data-bs-toggle="modal" data-bs-target="#exampleModalToggle"></div>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <p class="color-text1">{{ $serviceitem->property_name }}</p>
                                                            <p class="color-text">{{ $serviceitem->duration }} Minutes</p>
                                                            <p class="color-text">{{ $serviceitem->description }}</p>
                                                            <p class="color-text1 mt-2">£{{ $serviceitem->price }}</p>
                                                        </div>
                                                        <div class="selectbtn">
                                                            <a href="#" onclick="addRemoveService('service','{{ $serviceitem->id }}')" style="display:{{ $system ? 'none' : 'block' }};" class="btn btn-outline-dark book-btn">Book</a>
                                                            <i class="fa fa-check check-icon" onclick="addRemoveService('service','{{ $serviceitem->id }}')" style="display:{{ $system ? 'block' : 'none' }};"></i> <!-- Check icon initially hidden -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                            
                                    </div>
                                </div>
                                @endforeach
                                
                                    <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Dermatologist Consultation</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <input type="hidden" id="sid">
                                                            <p class="color-text1" id="sname">Dermatologist Consultation - Doctor services</p>
                                                            <p class="color-text"  id="sdur">1 hr</p>
                                                            <p class="color-text"  id="sdesc">Doctor consultation fee £100</p>
                                                            <p class="color-text1 mt-2"  id="sprice">£250</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0 d-block text-center">
                                                    <div>
                                                        <a href="#" id="buttonModal" onclick="addRemoveService('service','')" class="btn btn-dark add-book"data-bs-dismiss="modal" aria-label="Close">Book</a>
                                                    </div>
                                                    <!--<div>
                                                        <a href="#" class="btn btn-outline-dark remove-unselect" data-bs-dismiss="modal" aria-label="Close">Remove</a>
                                                    </div>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                            </div>
         

                            

                                </div>

                            
                            <div class="col-lg-4  " >
                            <div class=" fixed-right " id="fixedDiv">
                                <div class="card total-continue fixed-right-box shadow-sm doctor-sec" >
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
                                            </div>

                                            <hr>-->
                                            
                                            <div class="total-continue p-4" >
                                            <div id="selectedServices">
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
                                                  <hr class="dropdown-divider2">
                                                  <div class="d-flex justify-content-between center-box2">
                                                    <div>
                                                      <p>Total</p>
                                                    </div>
                                                    <p>£{{ $totalprice }}</p>
                                                  </div>
                                              </div>
                                              <a href="{{ url('addon') }}" class="btn btnform">Continue</a>
                                            </div>


                                            <!--<div class="p-4">-->
                                                
                                                
                                            <!--    <div class="d-flex align-items-center mb-2 fs-5 fw-light">-->
                                            <!--       <i class="fa-regular fa-clock me-2" style="color: #000000;"></i> <span class="text-success fw-light me-1">open</span> until 17:00-->
                                            <!--    </div>-->
                                            <!--    <div class="d-flex align-items-center fs-5 fw-lighter">-->
                                            <!--        <i class="fa-solid fa-location-dot me-2" style="color: #000000;"></i>-->
                                            <!--        <p class="mb-0">17D, Themistokli Dervi Str., "THE CITY HOUSE" Bld., Semi Basement, City Centre, Nicosia</p>-->
                                            <!--    </div>-->
                                            <!--    <a href="#" class="text-decoration-none text-primary">Get directions</a>-->
                                            <!--</div>-->

                                            <!--<hr>-->
                                            <!--<div class="p-4 mb-4">-->
                                            <!--    <div class="d-flex justify-content-between p-2">-->
                                            <!--        <div class="">-->
                                            <!--            <h6 class="fw-bold mb-0">Memberships</h6>-->
                                            <!--            <small>Buy a bundle of appointments.</small>-->
                                            <!--        </div>-->
                                            <!--        <a href="#" class="btn btn-outline-dark p-2 px-4">Buy</a>-->
                                            <!--    </div>-->
                                            <!--    <div class="d-flex justify-content-between mt-3 p-2">-->
                                            <!--        <div>-->
                                            <!--            <h6 class="fw-bold mb-0">Gift Cards</h6>-->
                                            <!--            <small>Treat yourself or a friend to future visits.</small>-->
                                            <!--        </div>-->
                                            <!--        <a href="#" class="btn btn-outline-dark  p-2 px-4">Buy</a>-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                        
                    </div>
                    
                    <section id="team">
                        
                        <div class="container">
                        <div class="row">
                            <h2>Team</h2>
                             
                             @foreach ($teams as $item)
                            <div class="col-3 mt-4 text-center">
                                <div class="imgContainer">
                                    <img class="TeamMember_image" src="{{ !empty($item->profile) ? asset('uploads/team/' . $item->profile) : asset('assets/img/media/1.jpg') }}" alt="">
                                </div>
                                
                                <div class="fs-6 fw-semibold">{{ @$item->team_name }}</div>
                                <div class="fs-6 fw-lighter">{{ @$item->profession }}</div>
                            </div>
                            @endforeach
                        </div>
                        </div>
                    </section>
                            

                               

                    <section id="mapCard">
                        
                        <div class="container my-5">

                            <div class="card map-card" onclick="window.open('https://maps.app.goo.gl/J7hVhLH2cUQf1QSw7', '_blank')">
                        
                                <iframe class="Google_mapURLCard" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3502.0717330163375!2d77.36868628807353!3d28.627612121577155!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390ce5574455d57b%3A0xf19bca2bae503f87!2sIconic%20Tower!5e0!3m2!1sen!2sin!4v1729937116350!5m2!1sen!2sin"  height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                                <div class="card-body">
                                    <h5 class="card-title">Visit Our Location</h5>
                                    <p class="card-text">123 Main Street, Your City</p>
                                </div>
                            </div>
                            </div>
                    </section>
                    
                    <section id="carosal_area" class="d-none">
                        <div class="container my-5">
                            <h2>Venues Nearby</h2>
                            <div class="venue-carousel">
                                <div class="">
                                    <div class="card mx-2">
                                        <img src="https://images.fresha.com/locations/location-profile-images/436078/2084323/f31d2a84-1bb2-4ea2-8e8f-33ce8fd47442-Aplomb-CY-Nicosia-Nicosia-Fresha.jpg?class=venue-gallery-large&dpr=2" class="card-img-top" alt="Venue 1">
                                        <div class="card-body">
                                            <h5 class="card-title">Aplomb</h5>
                                            <p class="card-text">5.0 ★ (449)</p>
                                            <p>Andrea Michalakopoulou 25</p>
                                            <span class="badge bg-secondary">Hair Salon</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="card mx-2">
                                        <img src="https://images.fresha.com/locations/location-profile-images/775061/2239080/6778098f-a757-4578-92c0-fdfd8942626c-BlossieHairandBeauty-CY-Fresha.jpg?class=venue-gallery-large&dpr=2" class="card-img-top" alt="Venue 2">
                                        <div class="card-body">
                                            <h5 class="card-title">Blossie Hair and Beauty</h5>
                                            <p class="card-text">5.0 ★ (226)</p>
                                            <p>Katson, Κατσον, Λευκωσία</p>
                                            <span class="badge bg-secondary">Hair Salon</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="card mx-2">
                                        <img src="https://images.fresha.com/locations/location-profile-images/1006610/1571901/bdb2b6dd-9567-401b-831b-7bee734a7b9e-Cassiecuts-CY-Nicosia-Nicosia-CityCentre-Fresha.jpg?class=venue-gallery-large&dpr=2" class="card-img-top" alt="Venue 3">
                                        <div class="card-body">
                                            <h5 class="card-title">Alchemy Hair Salon</h5>
                                            <p class="card-text">5.0 ★ (197)</p>
                                            <p>Ayious Omologites, Nicosia</p>
                                            <span class="badge bg-secondary">Hair Salon</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="card mx-2">
                                        <img src="https://images.fresha.com/locations/location-profile-images/346837/399219/abf31bf9-85d3-4b9d-b40f-a825d3415ce8.jpg?class=venue-gallery-large&dpr=2" class="card-img-top" alt="Venue 4">
                                        <div class="card-body">
                                            <h5 class="card-title">Lycoriana Pet Shop</h5>
                                            <p class="card-text">5.0 ★ (30)</p>
                                            <p>John Kennedy Avenue 35, Nicosia</p>
                                            <span class="badge bg-secondary">Hair Salon</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="card mx-2">
                                        <img src="https://images.fresha.com/locations/location-profile-images/407291/1767281/80b0ed69-c5f5-4d7f-b281-2e2cd12740ec.jpg?class=venue-gallery-large&dpr=2" class="card-img-top" alt="Venue 5">
                                        <div class="card-body">
                                            <h5 class="card-title">Lycoriana Pet Shop</h5>
                                            <p class="card-text">5.0 ★ (30)</p>
                                            <p>John Kennedy Avenue 35, Nicosia</p>
                                            <span class="badge bg-secondary">Hair Salon</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Add more cards as needed -->
                            </div>
                        </div>
                    </section>
                </div>







<script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/js/slick.js') }}"></script>
    <script src="{{ asset('frontend/js/all.min.js') }}"></script>


<script>
    
    function addRemoveService(stype,sid,uuid) {
        
        
        if (sid == '') {
            sid = $('#sid').val();
        } 
        
        return $.ajax({
            url: "{{ route('addRemoveService') }}",
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                sid: sid,
                stype: stype,
               
            },
            beforeSend: function(res) {
                //$('#state').html('<option value="">Loading...</option>');
            },
            success: function(res) { 
                console.log(res);
                $('#selectedServices').html(res.abc);
                // if(res.status=='success'){
                //     $('#sid').val('');
                    
                //     $('#subitMessage').html('<div id="alertMessage" class="alert alert-success" role="alert">Form submitted successfully!</div>');
                // }else{
                //     $('#subitMessage').html('<div id="alertMessage" class="alert alert-danger" role="alert">Something went wrong!</div>');  
                // }
            }
        })
    }
    
</script>

<script>

$(document).ready(function () {
    var selectedBoxes = [];  // Track all selected boxes
    var currentModalBox = null;  // Track the box that triggered the modal

    // Trigger modal and save the current box context
    $('.modaltarget').on('click', function (e) {
        if (!$(e.target).hasClass('book-btn')) {
            currentModalBox = $(this).closest('.inner_child_box');  // Save the box context
            //alert(currentModalBox.attr('class'));
            
            var sid = currentModalBox.attr('sid');
            var sname = currentModalBox.attr('sname');
            var sdur = currentModalBox.attr('sdur');
            var sdesc = currentModalBox.attr('sdesc');
            var sprice = currentModalBox.attr('sprice');
            
            $('#sid').val(sid);
            $('#sname').html(sname);
            $('#exampleModalToggleLabel').html(sname);
            $('#sdur').html(sdur+' minutes');
            $('#sdesc').html(sdesc);
            $('#sprice').html('£'+sprice);
            
            if (currentModalBox.hasClass('active')) {
                $('#buttonModal').html('Remove');
                $('#buttonModal').addClass('btn-danger');
            } else {
                $('#buttonModal').html('Add Service');
                $('#buttonModal').removeClass('btn-danger');
            }
            
            $('#exampleModalToggle').modal('show');
        }
    });

    // Handle the Book button click
    $('.book-btn').on('click', function (e) {
        e.preventDefault();
        var parentBox = $(this).closest('.inner_child_box'); 
        toggleSelection(parentBox);
    });

    // Handle the Add Book button click inside the modal
    $('.add-book').on('click', function (e) {
        e.preventDefault();
        if (currentModalBox) {
            toggleSelection(currentModalBox);
            $('#exampleModalToggle').modal('hide');  // Close the modal
        }
    });

    // Handle the Remove button click inside the modal
    $('.remove-unselect').on('click', function (e) {
        e.preventDefault();
        if (currentModalBox) {
            unselectBox(currentModalBox);
            $('#exampleModalToggle').modal('hide');  // Close the modal
        }
    });

    // Handle the Check icon click (toggle back to "Book" button)
    $('.check-icon').on('click', function (e) {
        e.preventDefault();
        var parentBox = $(this).closest('.inner_child_box');
        unselectBox(parentBox);
    });

    // Function to toggle selection state
    function toggleSelection(box) {
        if (box.hasClass('selected')) {
            unselectBox(box);  // If already selected, unselect it
        } else {
            selectBox(box);  // Otherwise, select it
        }
    }

    // Function to select a box
    function selectBox(box) {
        if (!selectedBoxes.includes(box[0])) {  // Check if not already selected
            box.addClass('selected active');  // Add active classes
            box.find('.book-btn').hide();  // Hide the "Book" button
            box.find('.check-icon').show();  // Show the check icon
            selectedBoxes.push(box[0]);  // Add box to the selected array
        }
    }

    // Function to unselect a box
    function unselectBox(box) {
        box.removeClass('selected active');  // Remove active classes
        box.find('.book-btn').show();  // Show the "Book" button
        box.find('.check-icon').hide();  // Hide the check icon
        selectedBoxes = selectedBoxes.filter(item => item !== box[0]);  // Remove from array
    }
});




        $('.services-select-slider').slick({
        dots: false,
        autoplay: false,
        arrows:true,
        infinite: false,
        slidesToShow: 4,
        slidesToScroll: 3,
        responsive: [
            {
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1,
                infinite: false,
                dots: false
            }
            },
            {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1
            }
            },
            {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
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
            
            
         // Set the first box as active on page load
    $('.services-select-box').first().addClass('active');

    // Click event for services-select-box
    $('.services-select-box').on('click', function() {
        // Remove active class from all boxes
        $('.services-select-box').removeClass('active');
        // Add active class to the clicked box
        $(this).addClass('active');

        // Get the text of the clicked box's p tag
        const selectedText = $(this).find('p').text();
        
        // Find the corresponding h3 element in scroll_inner_box
        const targetH3 = $('.scroll_inner_box h3').filter(function() {
            return $(this).text() === selectedText;
        });

        // Scroll to the corresponding h3 if found
        if (targetH3.length) {
            $('html, body').animate({
                scrollTop: targetH3.offset().top - 150 // Adjust offset as needed
            }, 10); // Duration of the scroll animation
        }
    });
    
    
    // Scroll event listener
    $(window).on('scroll', function() {
        let activeFound = false;

        // Loop through each h3 in scroll_inner_box
        $('.scroll_inner_box h3').each(function() {
            const h3OffsetTop = $(this).offset().top;
            const scrollPosition = $(window).scrollTop();
            const windowHeight = $(window).height();

            // Check if the h3 is in view
            if (h3OffsetTop < scrollPosition + windowHeight / 2 && h3OffsetTop + $(this).outerHeight() > scrollPosition + windowHeight / 2) {
                const h3Text = $(this).text();

                // Loop through services-select-box and match the text
                $('.services-select-box').each(function() {
                    if ($(this).find('p').text() === h3Text) {
                        // Remove active from all boxes and set active to the matched box
                        $('.services-select-box').removeClass('active');
                        $(this).addClass('active');
                        activeFound = true;
                        return false; // Break the loop once a match is found
                    }
                });
                return false; // Break the loop once an h3 match is found in view
            }
        });
    });
        
        
        
   let isAddingPlus = false; // Flag to check if the add button was clicked

// Click event for add button
$('.add_plus_btn').on('click', function(e) {
    e.preventDefault(); // Prevent the default anchor behavior
    isAddingPlus = true; // Set the flag to true when the add button is clicked

    // Find the parent .inner_child_box
    const $innerChildBox = $(this).closest('.inner_child_box');

    // Toggle the active class to change the border
    $innerChildBox.toggleClass('active');

    // Change the <a> tag content to a tick mark
    if ($innerChildBox.hasClass('active')) {
        $(this).html('✓'); // Change the content to a tick mark
        $(this).addClass('active'); // Add the active class for styling
    } else {
        $(this).html('<i class="fa-solid fa-plus"></i>'); // Change back to the plus icon
        $(this).removeClass('active'); // Remove the active class
    }

    // Optionally, you can re-enable modal opening after a delay
    setTimeout(() => {
        isAddingPlus = false; // Reset flag after 3 seconds or as needed
    }, 3000); // Adjust delay time as needed
});

let currentInnerChildBox = null; // Store the clicked .inner_child_box

// When a .scroll_inner_box is clicked
$('.inner_child_box').on('click', function() {
    if (!isAddingPlus) { // Check if add button was not clicked
        // Store the closest .inner_child_box for later use
        currentInnerChildBox = $(this).closest('.inner_child_box');

        // Open the modal
        $('#myModal').modal('show');
    }
});

// Open modal click event


// Reset the flag when modal is closed
$('#myModal').on('hidden.bs.modal', function () {
    isAddingPlus = false; // Reset flag when modal is closed
});

// When the .add_to_book button is clicked inside the modal
$('.add_to_book').on('click', function(e) {
    e.preventDefault(); // Prevent the default behavior

    // Assign the clicked button to a variable
    const $addToBookButton = $(this);

    if (currentInnerChildBox) { // Check if a .inner_child_box is stored
        // Toggle the active class on the stored .inner_child_box
        currentInnerChildBox.toggleClass('active');

        // Change the button content inside the stored .inner_child_box
        const $addPlusBtn = currentInnerChildBox.find('.add_plus_btn');
        
        // Update the inner button state based on the inner child box's state
        if (currentInnerChildBox.hasClass('active')) {
            $addPlusBtn.html('✓'); // Change to tick mark
            $addPlusBtn.addClass('active'); // Add active class for styling
        } else {
            $addPlusBtn.html('<i class="fa-solid fa-plus"></i>'); // Revert to plus icon
            $addPlusBtn.removeClass('active'); // Remove active class
        }

        // Check if the add_to_book button has the 'active' class
        if ($addToBookButton.hasClass('active')) {
            // If it does, revert to the default state
            $addToBookButton.html('Add to book'); // Change button text back
            $addToBookButton.removeClass('active'); // Remove active class
        } else {
            // If it doesn't, set it to active
            $addToBookButton.html('Remove'); // Change button text to "Remove"
            $addToBookButton.addClass('active'); // Add active class
        }

        // Close the modal
        $('#myModal').modal('hide');
    }

    // Clear the reference after use
    currentInnerChildBox = null;
});
            });

            window.addEventListener('scroll', () => {
  const nav = document.getElementById('mainNav');
  if (window.scrollY > 900) {
    nav.classList.remove('d-none');
  } else {
    nav.classList.add('d-none');
  }
});


document.addEventListener("DOMContentLoaded", () => {
  const sections = document.querySelectorAll("section");
  const navLinks = document.querySelectorAll("#mainNav .nav-link");

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        const sectionID = entry.target.id;
        
        if (entry.isIntersecting) {
          navLinks.forEach((link) => link.classList.remove("activeNav"));
          
          const activeLink = document.querySelector(`#mainNav .nav-link[href="#${sectionID}"]`);
          if (activeLink) activeLink.classList.add("activeNav");
        }
      });
    },
    { threshold: 1 }
  );

  sections.forEach((section) => observer.observe(section));

  window.addEventListener("scroll", () => {
    const nav = document.getElementById("mainNav");
    if (window.scrollY > 300) {
      nav.classList.remove("d-none");
    } else {
      nav.classList.add("d-none");
    }
  });
});

$(document).ready(function(){
            $('.venue-carousel').slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                infinite: false,
                prevArrow: '<button type="button" class="slick-prev arrowCarosalPrev"></button>',
                nextArrow: '<button type="button" class="slick-next arrowCarosalNext"></button>',
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });

            $('.venue-carousel').on('afterChange', function(event, slick, currentSlide){
                $('.arrowCarosalPrev').toggle(currentSlide > 0);
                $('.arrowCarosalNext').toggle(currentSlide < slick.slideCount - slick.options.slidesToShow);
            });

            $('.arrowCarosalPrev').hide();
        });

    </script>



<!-- Include jQuery and Bootstrap JS if not already included -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function () {
    
    if({{ $id }}==0 && {{ $catid }}!=0){
        
        const outerDiv = document.querySelector('.scrollslider'); // Parent scrollable container
        const targetDiv = document.querySelector(`div[id="scrollspyHeading{{ $catid }}"]`);
        
        if (outerDiv && targetDiv) {
            // Get the offset of the target div relative to the parent container
            const rect = targetDiv.getBoundingClientRect();
            const outerRect = outerDiv.getBoundingClientRect();
            const offset = rect.top - outerRect.top - 60; // Adjusting for the required offset
        
            // Scroll the parent container
            outerDiv.scrollTo({
                top: outerDiv.scrollTop + offset,
                behavior: 'smooth',
            });
        
            // Uncomment for debugging
            // targetDiv.style.border = "2px solid red";
            // outerDiv.style.border = "2px solid blue";
        } else {
            console.error("OuterDiv or TargetDiv not found.");
        }

        
    }else{
        
        const outerDiv = document.querySelector('.scrollslider'); // Parent scrollable container
        const targetDiv = document.querySelector('div[sid="{{ $id }}"]');
        
        if (outerDiv && targetDiv) {
            // Get the offset of the target div relative to the parent container
            const rect = targetDiv.getBoundingClientRect();
            const outerRect = outerDiv.getBoundingClientRect();
            const offset = rect.top - outerRect.top - 30; // Adjusting for the required offset
        
            // Scroll the parent container
            outerDiv.scrollTo({
                top: outerDiv.scrollTop + offset,
                behavior: 'smooth',
            });
        
            // Uncomment for debugging
            // targetDiv.style.border = "2px solid red";
            // outerDiv.style.border = "2px solid blue";
        } else {
            console.error("OuterDiv or TargetDiv not found.");
        }
    
        
    }
   
    
});




</script>

<script>
    function initMap() {
        const locations = [
            { name: "Wembley", address: "348 High Road Wembley HA9 6AZ", lat: 51.552525, lng: -0.296779 },
            { name: "Ladbroke Grove", address: "758 Harrow Road North Kensington NW10 5LE", lat: 51.530944, lng: -0.220243 },
            { name: "Harley Street", address: "102 Harley Street W1G 7JB", lat: 51.521922, lng: -0.148611 },
            { name: "Knightsbridge", address: "20 Beauchamp Place Knightsbridge SW3 1NQ", lat: 51.499688, lng: -0.160719 }
        ];

        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 12,
            center: { lat: 51.509865, lng: -0.118092 }, // Center of London
        });

        locations.forEach((location) => {
            const marker = new google.maps.Marker({
                position: { lat: location.lat, lng: location.lng },
                map,
                title: location.name,
            });

            const infowindow = new google.maps.InfoWindow({
                content: `<h3>${location.name}</h3><p>${location.address}</p>`,
            });

            marker.addListener("click", () => {
                infowindow.open(map, marker);
            });
        });
    }

    window.onload = initMap;
</script>




  
@endsection

