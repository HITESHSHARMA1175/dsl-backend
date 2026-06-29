@extends('frontend.layout.app')

@section('content')

   <section id="photos" style="margin-top: 120px;">
                 <div class="container mt-5">
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
                    <nav id="navbar-example2" class="navbar bg-body-tertiary px-3 mb-3">
                        <a class="navbar-brand" href="#">Navbar</a>                        <ul class="nav nav-pills">
                            <li class="nav-item">
                            <a class="nav-link" href="#scrollspyHeading1">First</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="#scrollspyHeading2">Second</a>
                            </li>
                            <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Dropdown</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#scrollspyHeading3">Third</a></li>
                                <li><a class="dropdown-item" href="#scrollspyHeading4">Fourth</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#scrollspyHeading5">Fifth</a></li>
                            </ul>
                            </li>
                        </ul>
                        </nav>
                        <div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true" class="scrollspy-example bg-body-tertiary p-3 rounded-2" tabindex="0">
                        <h4 id="scrollspyHeading1">First heading</h4>
                        <p>First heading This is some placeholder content for the scrollspy page. Note that as you scroll down the page, the appropriate navigation link is highlighted. It's repeated throughout the component example. We keep adding some more example copy here to emphasize the scrolling and highlighting.</p>
                        <h4 id="scrollspyHeading2">Second heading</h4>
                        <p>Second heading This is some placeholder content for the scrollspy page. Note that as you scroll down the page, the appropriate navigation link is highlighted. It's repeated throughout the component example. We keep adding some more example copy here to emphasize the scrolling and highlighting.</p>
                        <h4 id="scrollspyHeading3">Third heading</h4>
                        <p>Third heading This is some placeholder content for the scrollspy page. Note that as you scroll down the page, the appropriate navigation link is highlighted. It's repeated throughout the component example. We keep adding some more example copy here to emphasize the scrolling and highlighting.

Fourth heading
This is some placeholder content for the scrollspy page. Note that as you scroll down the page, the appropriate navigation link is highlighted. It's repeated throughout the component example. We keep adding some more example copy here to emphasize the scrolling and highlighting.</p>
                        <h4 id="scrollspyHeading4">Fourth heading</h4>
                        <p>Fourth heading
This is some placeholder content for the scrollspy page. Note that as you scroll down the page, the appropriate navigation link is highlighted. It's repeated throughout the component example. We keep adding some more example copy here to emphasize the scrolling and highlighting.</p>
                        <h4 id="scrollspyHeading5">Fifth heading</h4>
                        <p>Fifth heading
This is some placeholder content for the scrollspy page. Note that as you scroll down the page, the appropriate navigation link is highlighted. It's repeated throughout the component example. We keep adding some more example copy here to emphasize the scrolling and highlighting.</p>
                        </div>
                </div>
        





                <div class="row">
                    <div class="col-lg-8">
                        <h2>services</h2>
                               
          
          
                        <div class="services-select-slider">
                            <a href="#featured">
                            <div class="services-select-box">
                                <p>Featured</p>
                            </div>
                            </a>
                            
                            <a href="#permanent_makeup">
                            <div class="services-select-box">
                                
                                <p>Permanent Make UP</p>
                            </div>
                            </a>
                            <div class="services-select-box">
                                <p>summer Specials</p>
                            </div>
                            <div class="services-select-box">
                                <p>Fraxel Laser - With Doctor Rolla</p>
                            </div>
                            <div class="services-select-box">
                                <p>Featured</p>
                            </div>
                            <div class="services-select-box">
                                <p>Permanent Make UP</p>
                            </div>
                            <div class="services-select-box">
                                <p>summer Specials</p>
                            </div>
                            <div class="services-select-box">
                                <p>Fraxel Laser - With Doctor Rolla</p>
                            </div>
                            <div class="services-select-box">
                                <p>Autumn Offer</p>
                            </div>
                            <div class="services-select-box">
                                <p>summer Specials</p>
                            </div>
                            <div class="services-select-box">
                                <p>Fraxel Laser - With Doctor Rolla</p>
                            </div>
                            <div class="services-select-box">
                                <p>Featured</p>
                            </div>
                            <div class="services-select-box">
                                <p>summer Specials</p>
                            </div>
                            <div class="services-select-box">
                                <p>Fraxel Laser - With Doctor Rolla</p>
                            </div>
                        </div>
                        
                        <section id="services">
                        <div class="scroll_box py-3" id="featured">

                            <div class="scroll_inner_box"> 
                                <h3>Autumn Offer</h3>
                                <p>Profhilo is an injectable treatment containing one of the highest concentrations of stabilised hyaluronic acid available on the cosmetic surgery market.</p>
                                <div class="inner_child_box">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="color-text1">Dermatologist Consultation - Doctor</p>
                                            <p class="color-text">1 hr</p>
                                            <p class="color-text">Doctor consultation fee Ã‚Â£100</p>
                                            <p class="color-text1 mt-2">Ã‚Â£250</p>

                                        </div>
                                        <div>
                                            <a href="#" class="btn btn-outline-dark">Book</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="inner_child_box">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="color-text1">Dermatologist Consultation - Doctor</p>
                                            <p class="color-text">1 hr</p>
                                            <p class="color-text">Doctor consultation fee Ã‚Â£100</p>
                                            <p class="color-text1 mt-2">Ã‚Â£250</p>

                                        </div>
                                        <div>
                                            <a href="#" class="btn btn-outline-dark">Book</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="inner_child_box">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="color-text1">Dermatologist Consultation - Doctor</p>
                                            <p class="color-text">1 hr</p>
                                            <p class="color-text">Doctor consultation fee Ã‚Â£100</p>
                                            <p class="color-text1 mt-2">Ã‚Â£250</p>

                                        </div>
                                        <div>
                                            <a href="#" class="btn btn-outline-dark">Book</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="inner_child_box">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="color-text1">Dermatologist Consultation - Doctor</p>
                                            <p class="color-text">1 hr</p>
                                            <p class="color-text">Doctor consultation fee Ã‚Â£100</p>
                                            <p class="color-text1 mt-2">Ã‚Â£250</p>

                                        </div>
                                        <div>
                                            <a href="#" class="btn btn-outline-dark">Book</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            
                            <div class="scroll_box py-3" id="permanent_makeup">

                            <div class="scroll_inner_box"> 
                                <h3>Autumn Offer</h3>
                                <p>Profhilo is an injectable treatment containing one of the highest concentrations of stabilised hyaluronic acid available on the cosmetic surgery market.</p>
                                <div class="inner_child_box">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="color-text1">Dermatologist Consultation - Doctor</p>
                                            <p class="color-text">1 hr</p>
                                            <p class="color-text">Doctor consultation fee Ã‚Â£100</p>
                                            <p class="color-text1 mt-2">Ã‚Â£250</p>

                                        </div>
                                        <div>
                                            <a href="#" class="btn btn-outline-dark">Book</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="inner_child_box">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="color-text1">Dermatologist Consultation - Doctor</p>
                                            <p class="color-text">1 hr</p>
                                            <p class="color-text">Doctor consultation fee Ã‚Â£100</p>
                                            <p class="color-text1 mt-2">Ã‚Â£250</p>

                                        </div>
                                        <div>
                                            <a href="#" class="btn btn-outline-dark">Book</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="inner_child_box">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="color-text1">Dermatologist Consultation - Doctor</p>
                                            <p class="color-text">1 hr</p>
                                            <p class="color-text">Doctor consultation fee Ã‚Â£100</p>
                                            <p class="color-text1 mt-2">Ã‚Â£250</p>

                                        </div>
                                        <div>
                                            <a href="#" class="btn btn-outline-dark">Book</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="inner_child_box">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="color-text1">Dermatologist Consultation - Doctor</p>
                                            <p class="color-text">1 hr</p>
                                            <p class="color-text">Doctor consultation fee Ã‚Â£100</p>
                                            <p class="color-text1 mt-2">Ã‚Â£250</p>

                                        </div>
                                        <div>
                                            <a href="#" class="btn btn-outline-dark">Book</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </section>
                        

                            <section id="team">
                                <div class="row">
                                    <h2>Team</h2>
                                    <div class="col-3 mt-4 text-center">
                                        <div class="imgContainer">
                                            <img class="TeamMember_image" src="https://cdn-partners-api.fresha.com/employee-avatars/processed/1224/medium/da4a0181-06f0-470f-ade1-daa328b35e40-0E3A9751.jpg?class=square128" alt="">
                                        </div>
                                        <div class="rating_container text-center">
                                            5.0 ⭐
                                        </div>
                                        <div class="fs-6 fw-semibold">MARIOS</div>
                                        <div class="fs-6 fw-lighter">CREATIVE DIRECTOR</div>
                                    </div>
                                    <div class="col-3 mt-4 text-center">
                                        <div class="imgContainer">
                                            <img class="TeamMember_image" src="https://cdn-partners-api.fresha.com/employee-avatars/processed/127530/medium/4b939303-c7fb-4ab5-a81e-cfe40b6707e3-Screenshot_20220127-103417_Gallery.jpg?class=square128" alt="">
                                        </div>
                                        <div class="rating_container text-center">
                                            5.0 ⭐
                                        </div>
                                        <div class="fs-6 fw-semibold">MARIOS</div>
                                        <div class="fs-6 fw-lighter">CREATIVE DIRECTOR</div>
                                    </div>
                                    <div class="col-3 mt-4 text-center">
                                        <div class="imgContainer">
                                            <img class="TeamMember_image" src="https://cdn-partners-api.fresha.com/employee-avatars/processed/1426/medium/8c8d3cee-92ca-44c1-9c99-19c0b41a2298-0E3A9892.jpg?class=square128" alt="">
                                        </div>
                                        <div class="rating_container text-center">
                                            5.0 ⭐
                                        </div>
                                        <div class="fs-6 fw-semibold">MARIOS</div>
                                        <div class="fs-6 fw-lighter">CREATIVE DIRECTOR</div>
                                    </div>
                                    <div class="col-3 mt-4 text-center">
                                        <div class="imgContainer">
                                            <img class="TeamMember_image" src="https://cdn-partners-api.fresha.com/employee-avatars/processed/1416/medium/fdb841a1-c9ba-497f-9609-534c2d71c7fc-0E3A9785.jpg?class=square128" alt="">
                                        </div>
                                        <div class="rating_container text-center">
                                            5.0 ⭐
                                        </div>
                                        <div class="fs-6 fw-semibold">MARIOS</div>
                                        <div class="fs-6 fw-lighter">CREATIVE DIRECTOR</div>
                                    </div>
                                    <div class="col-3 mt-4 text-center">
                                        <div class="imgContainer">
                                            <img class="TeamMember_image" src="https://cdn-partners-api.fresha.com/employee-avatars/processed/71356/medium/dac26367-58d0-451c-9a2a-85d36b70ba34-IMG-16f6196eba241cf4a81d783248a78e6b-V.jpg?class=square128" alt="">
                                        </div>
                                        <div class="rating_container text-center">
                                            5.0 ⭐
                                        </div>
                                        <div class="fs-6 fw-semibold">MARIOS</div>
                                        <div class="fs-6 fw-lighter">CREATIVE DIRECTOR</div>
                                    </div>
                                    <div class="col-3 mt-4 text-center">
                                        <div class="imgContainer">
                                            <img class="TeamMember_image" src="https://cdn-partners-api.fresha.com/employee-avatars/processed/114636/medium/77fee141-cf3e-43a0-a126-9d0bd51e9c06-0E3A9615.jpg?class=square128" alt="">
                                        </div>
                                        <div class="rating_container text-center">
                                            5.0 ⭐
                                        </div>
                                        <div class="fs-6 fw-semibold">MARIOS</div>
                                        <div class="fs-6 fw-lighter">CREATIVE DIRECTOR</div>
                                    </div>
                                    <div class="col-3 mt-4 text-center">
                                        <div class="imgContainer">
                                            <img class="TeamMember_image" src="https://cdn-partners-api.fresha.com/employee-avatars/processed/114636/medium/77fee141-cf3e-43a0-a126-9d0bd51e9c06-0E3A9615.jpg?class=square128" alt="">
                                        </div>
                                        <div class="rating_container text-center">
                                            5.0 ⭐
                                        </div>
                                        <div class="fs-6 fw-semibold">MARIOS</div>
                                        <div class="fs-6 fw-lighter">CREATIVE DIRECTOR</div>
                                    </div>
                                    <div class="col-3 mt-4 text-center">
                                        <div class="imgContainer">
                                            <img class="TeamMember_image" src="https://cdn-partners-api.fresha.com/employee-avatars/processed/114636/medium/77fee141-cf3e-43a0-a126-9d0bd51e9c06-0E3A9615.jpg?class=square128" alt="">
                                        </div>
                                        <div class="rating_container text-center">
                                            5.0 ⭐
                                        </div>
                                        <div class="fs-6 fw-semibold">MARIOS</div>
                                        <div class="fs-6 fw-lighter">CREATIVE DIRECTOR</div>
                                    </div>
                                </div>
                            </section>
                            

                                <section id="reviews">
                                    <div class="container mt-2 pt-2">
                                        <div class="row">
                                            <h3>Reviews</h3>
                                            <div class="d-flex align-items-center">
                                                <span class="fs-3">★★★★★</span>
                                                <span class="ms-2">5.0 <a href="#">(2,762)</a></span>
                                            </div>
                                            
                                            <!-- Review Cards -->
                                            <div class="col-6">
                                              <div class="review-card p-3 mb-3">
                                                <strong>Nayia A.</strong><br>
                                                <small>Fri, 25 Oct, 2024 at 4:44 pm</small>
                                                <p>★★★★★<br>each time you get out fresher. thanks</p>
                                              </div>
                                              </div>
                                            <div class="col-6">
                                              <div class="review-card p-3 mb-3">
                                                <strong>Niki L.</strong><br>
                                                <small>Tue, 22 Oct, 2024 at 5:04 pm</small>
                                                <p>★★★★★<br>Great as always 👌</p>
                                              </div>
                                              </div>
                                            <div class="col-6">
                                              <div class="review-card p-3 mb-3">
                                                <strong>Niki L.</strong><br>
                                                <small>Tue, 22 Oct, 2024 at 5:04 pm</small>
                                                <p>★★★★★<br>Great as always 👌</p>
                                              </div>
                                              </div>
                                            <div class="col-6">
                                              <div class="review-card p-3 mb-3">
                                                <strong>Niki L.</strong><br>
                                                <small>Tue, 22 Oct, 2024 at 5:04 pm</small>
                                                <p>★★★★★<br>Great as always 👌</p>
                                              </div>
                                              </div>
                                            <div class="col-6">
                                              <div class="review-card p-3 mb-3">
                                                <strong>Niki L.</strong><br>
                                                <small>Tue, 22 Oct, 2024 at 5:04 pm</small>
                                                <p>★★★★★<br>Great as always 👌</p>
                                              </div>
                                              </div>
                                            <div class="col-6">
                                              <div class="review-card p-3 mb-3">
                                                <strong>Niki L.</strong><br>
                                                <small>Tue, 22 Oct, 2024 at 5:04 pm</small>
                                                <p>★★★★★<br>Great as always 👌</p>
                                              </div>
                                              </div>
                                            <div class="col-6">
                                              <button class="btn btn-outline-secondary">See all</button>
                                              </div>
                                            </div>
                                          </div>
                                </section>


                                <section id="about">
                                    <div class="row">
                                        <h2>About</h2>
                                        <div class="text-start">
                                            <p>Hair Etc. Studio offers the most unique hair experience in Cyprus. We are a team of creators working with people on a daily basis to make sure their image and well-being is kept at its best. We don’t just do hair, we focus on the person and provide solutions that positively affect their daily mood and life. We value our clients and strive to exceed your expectations. The Studio provides its guests with a private and relaxing environment that helps them disconnect from their everyday lives.</p>
                                        </div>
                                        </div>
                                    </section>


                                    <section id="timings">
                                        <div class="container mt-2 pt-2">
                                            <div class="row">
                                                <div class="col-6">
                                                  <div class=" p-3 mb-3">
                                                    <h5><strong>Opening times</strong></h5><br>
                                                   <div class="row justify-content-between">
                                                    <div class="col-6">
                                                        <div class="d-flex align-items-center mt-3">
                                                            <div class="timing_dot_close"></div>
                                                            <span class="ms-2">Monday</span>
                                                        </div>
                                                        <div class="d-flex align-items-center mt-3">
                                                            <div class="timing_dot"></div>
                                                            <span class="ms-2">Tuesday</span>
                                                        </div>
                                                        <div class="d-flex align-items-center mt-3">
                                                            <div class="timing_dot"></div>
                                                            <span class="ms-2">Wednesday</span>
                                                        </div>
                                                        <div class="d-flex align-items-center mt-3">
                                                            <div class="timing_dot"></div>
                                                            <span class="ms-2">Thusday</span>
                                                        </div>
                                                        <div class="d-flex align-items-center mt-3">
                                                            <div class="timing_dot"></div>
                                                            <span class="ms-2">Friday</span>
                                                        </div>
                                                        <div class="d-flex align-items-center mt-3">
                                                            <div class="timing_dot"></div>
                                                            <span class="ms-2">saturday</span>
                                                        </div>
                                                        <div class="d-flex align-items-center mt-3">
                                                            <div class="timing_dot_close"></div>
                                                            <span class="ms-2">sunday</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 text-end">
                                                        <div class="flex mt-3">
                                                            <span>Close</span>
                                                        </div>
                                                        <div class="flex mt-3">
                                                            <span>09:00 - 19:00</span>
                                                        </div>
                                                        <div class="flex mt-3">
                                                            <span>09:00 - 19:00</span>
                                                        </div>
                                                        <div class="flex mt-3">
                                                            <span>09:00 - 19:00</span>
                                                        </div>
                                                        <div class="flex mt-3">
                                                            <span>09:00 - 19:00</span>
                                                        </div>
                                                        <div class="flex mt-3">
                                                            <span>09:00 - 19:00</span>
                                                        </div>
                                                        <div class="flex mt-3">
                                                            <span>Close</span>
                                                        </div>
                                                    </div>
                                                   </div>
                                                  </div>
                                                  </div>
                                                  <div class="col-6">
                                                    <div class=" p-3 mb-3">
                                                      <h4>Additional information</h4><br>
                                                      <p class="fw-light"><i class="fa-solid fa-check me-2" style="color: #000000;"></i>Instant Confirmation</p>
                                                      <p class="fw-light"><i class="fa-solid fa-wallet me-2" style="color: #000000;"></i>Pay by app</p>
                                                    </div>
                                                    </div>
                                                </div>
                                              </div>
                                    </section>
                                    <section id="mapCard">
                                        <div class="container my-5">
    
                                            <div class="card map-card" onclick="window.open('https://maps.app.goo.gl/J7hVhLH2cUQf1QSw7', '_blank')">
                                        
                                                <iframe class="Google_mapURLCard" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3502.0717330163375!2d77.36868628807353!3d28.627612121577155!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390ce5574455d57b%3A0xf19bca2bae503f87!2sIconic%20Tower!5e0!3m2!1sen!2sin!4v1729937116350!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                                                </iframe>
                                                <div class="card-body">
                                                    <h5 class="card-title">Visit Our Location</h5>
                                                    <p class="card-text">123 Main Street, Your City</p>
                                                </div>
                                            </div>
                                            </div>
                                    </section>

                                </div>

                            
                            <div class="col-lg-4 mt-4">
                                <div class="card total-continue shadow-sm doctor-sec">
                                    <div class="">
                                        <div class="card-body p-0">
                                            <div class="p-4">
                                                <h5 class="card-title fw-bold">Diamond Skin - Doctor Led Aesthetic and Laser Clinic</h5>
                                                <div class="d-flex align-items-center mb-2 fs-5">
                                                    <span class="me-2 fw-bold">5.0</span>
                                                    <span class="text-warning me-1">&#9733; &#9733; &#9733; &#9733; &#9733;</span>
                                                    <a href="#" class="text-decoration-none text-primary ms-1">(2,762)</a>
                                                    
                                                </div>
                                                <div>
                                                          <p>UK, 348 High Road, Wembley</p>
                                                </div>
                                                <!--<span class="badge my-3 p-3 px-4" style="border-radius: 1.6rem; border: 1px solid #8e74ff; background-color: #f7f6ff; color: #8e74ff;">Featured</span>-->
                                                <!--<a href="#" class="btn btn-dark w-100 py-2 fs-5">Book now</a>-->
                                            </div>

                                            <hr>
                                            
                                            <div class="total-continue p-4">

  <div class="d-flex justify-content-between center-box mb-3">
    <div>
      <p>Dermatologist Consultation - Doctor</p>
      <span>1 hr with any professional</span>
    </div>
    <p>£250</p>
  </div>
  <div class="d-flex justify-content-between center-box mb-3">
    <div>
      <p>Full Face Fraxel</p>
      <span>1 hr with any professional</span>
    </div>
    <p>£500</p>
  </div>
  <div class="d-flex justify-content-between center-box mb-3">
    <div>
      <p>Brazilian &amp; Underarms</p>
      <span>30 mins with any professional</span>
    </div>
    <p>£49</p>
  </div>
  <hr class="dropdown-divider2">
  <div class="d-flex justify-content-between center-box2">
    <div>
      <p>Total</p>
    </div>
    <p>£250</p>
  </div>
  <a href="select-time.php" class="btn btnform">Continue</a>
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
 
                    <section id="carosal_area">
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



  
@endsection

