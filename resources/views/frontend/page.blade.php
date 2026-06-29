@extends('frontend.layout.app')
@section('content')
    <!-- == main content starts == -->
    <div id="dtr-main-content">

        {{-- hero section starts
             ==================================================  --}}
        <section id="home" class="dtr-section dtr-box-layout dtr-hero-section-top-padding">
            <!-- dtr-bg-shapes-type-1 : Class for shapes to background. Easy to change image color, refer local help doc -->
            <div class="dtr-box-wrapper-round dtr-bg-shapes-type-1 bg-white">

                <!--===== row 1 starts =====-->
                <div class="row">

                    @if (!empty($pageDetails->image))
                        <!-- column 1 starts -->
                        <div class="col-12 col-md-12"
                            style="background-image: url({{ asset('frontend/assets/images/img-1.jpg') }});">
                            <img src="{{ !empty($pageDetails->image) ? asset('footer/' . $pageDetails->image) : asset('assets/images/no.png') }}"
                                alt="">
                        </div>
                        <!-- column 1 ends -->
                    @endif


                    <!-- column 2 starts -->
                    <div class="col-12 col-md-12 dtr-py-100 dtr-sm-p-50 dtr-px-100">

                        <!-- intro text -->
                        <h1>{{ @$pageDetails->name }}</h1>
                        <p>{!! isset($pageDetails) ? @$pageDetails->content : '' !!} </p>



                    </div>
                    <!-- column 2 ends -->



                </div>
                <!--===== row 1 ends =====-->

            </div>
        </section>
        {{--  hero section ends
         ================================================== --}}

    </div>
    <!-- == main content ends == -->
@endsection
