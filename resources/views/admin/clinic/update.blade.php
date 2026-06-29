@extends('admin.layout.app')
@section('content')
    <!-- Main Content-->
    <div class="main-content side-content pt-0">

        <form action="{{ route('clinic.update', $clinic_info->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="main-container container-fluid">
                <div class="inner-body">

                    <!-- Page Header -->
                    <div class="page-header">
                        <div>
                            <h2 class="main-content-title tx-24 mg-b-5">Edit Clinic</h2>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Clinic </a></li>
                            </ol>
                        </div>
                        <div class="d-flex">
                            <div class="justify-content-center">
                                {{-- 
                                <button type="button" class="btn btn-primary my-2 btn-icon-text">
                                    <i class="fe fe-download-cloud me-2"></i> Print
                                </button> --}}
                            </div>
                        </div>
                    </div>
                    <!-- End Page Header -->
                    <!-- Row -->
                    <div class="row row-sm">
                        <div class="col-lg-12 col-md-12">
                            <div class="card custom-card">
                                <div class="card-body">

                                    <div>
                                        <h6 class="main-content-label mb-1">Clinic Info</h6>
                                    </div>
                                    <div class="row row-sm">


                                        <div class="col-sm-4 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Clinic Name</label>
                                                <input class="form-control" name="clinic_name" value="{{ $clinic_info->clinic_name }}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Clinic Email</label>
                                                <input class="form-control" name="clinic_email" value="{{ $clinic_info->clinic_email }}" type="text">
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="col-sm-4 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Clinic Phone</label>
                                                <input class="form-control" name="clinic_phone" value="{{ $clinic_info->clinic_phone }}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Whatsapp</label>
                                                <input class="form-control" name="clinic_whatsapp" value="{{ $clinic_info->clinic_whatsapp }}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Clinic ALT Phone</label>
                                                <input class="form-control" name="clinic_alt_phone" value="{{ $clinic_info->clinic_alt_phone }}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Clinic Website</label>
                                                <input class="form-control" name="clinic_website" value="{{ $clinic_info->clinic_website }}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Clinic Timezone</label>
                                                <input class="form-control" name="clinic_timezone" value="{{ $clinic_info->clinic_timezone }}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-8 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Clinic Address</label>
                                                <input class="form-control" name="address" value="{{ $clinic_info->address }}" type="text">
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-12 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Google Map</label>
                                                <input class="form-control" name="google_map" value="{{ $clinic_info->google_map }}" type="text">
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-6 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Metro Station Name</label>
                                                <input class="form-control" name="metro_name" value="{{ $clinic_info->metro_name }}" type="text">
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-6 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Metro Station Text</label>
                                                <input class="form-control" name="metro_text" value="{{ $clinic_info->metro_text }}" type="text">
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-6 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Railway Station Name</label>
                                                <input class="form-control" name="railway_name" value="{{ $clinic_info->railway_name }}" type="text">
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-6 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Railway Station Text</label>
                                                <input class="form-control" name="railway_text" value="{{ $clinic_info->railway_text }}" type="text">
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="col-sm-4 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Monday To Friday</label>
                                                <input class="form-checkbox" name="mon_to_fry" type="checkbox" value="1" {{ $clinic_info->mon_to_fry == 1 ? 'checked' : '' }}> Open
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Clinic Start Time</label>
                                                <input class="form-control" name="clinic_start_time" value="{{ $clinic_info->clinic_start_time }}" type="time">
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Clinic Close Time</label>
                                                <input class="form-control" name="clinic_close_time" value="{{ $clinic_info->clinic_close_time }}" type="time">
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-4 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Saturday</label>
                                                <input class="form-checkbox" name="sat" type="checkbox" value="1" {{ $clinic_info->sat == 1 ? 'checked' : '' }}> Open
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Clinic Start Time</label>
                                                <input class="form-control" name="sat_start_time" value="{{ $clinic_info->sat_start_time }}" type="time">
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Clinic Close Time</label>
                                                <input class="form-control" name="sat_close_time" value="{{ $clinic_info->sat_close_time }}" type="time">
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-4 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Sunday</label>
                                                <input class="form-checkbox" name="sun" type="checkbox" value="1" {{ $clinic_info->sun == 1 ? 'checked' : '' }}> Open
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Clinic Start Time</label>
                                                <input class="form-control" name="sun_start_time" value="{{ $clinic_info->sun_start_time }}" type="time">
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Clinic Close Time</label>
                                                <input class="form-control" name="sun_close_time" value="{{ $clinic_info->sun_close_time }}" type="time">
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        <div class="col-sm-4 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Clinic Image</label>
                                                <input class="form-control" name="profile" type="file">
                                            </div>
                                            @if($clinic_info->profile!='')
                                            <img style="width:100px;" src="{{ asset('uploads/clinic/' . $clinic_info->profile) }}">
                                            @endif
                                        </div>
                
                                        
                
                                    </div>
                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Row -->




                </div>
                <!-- End Row -->


                <div class="row row-sm">
                    <div class="col-12 mb-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- End Main Content-->

    <script>
        $(document).ready(function() {
            if ('{{ $clinic_info->is_for_rent }}' == 'Yes') {
                $(".rentDiv").show();
            } else {
                $(".rentDiv").hide();
            }

        });
    </script>


    @include('admin.clinic.include.ajaxCode')
@endsection
