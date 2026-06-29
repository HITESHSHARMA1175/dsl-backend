@extends('admin.layout.app')
@section('content')
    <!-- Main Content-->

    <style>
        .select2-container .select2-selection--single {
            height: 38px !important;
        }

        .select2-container--classic .select2-selection--single .select2-selection__arrow {
            height: 36px !important;
        }
    </style>

    <div class="main-content side-content pt-0">

        <form action="{{ route('team.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="main-container container-fluid">
                <div class="inner-body">

                    <!-- Page Header  -->
                    <div class="page-header">
                        <div>
                            <h2 class="main-content-title tx-24 mg-b-5">Add Team</h2>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Team </a></li>
                            </ol>
                        </div>
                        <div class="d-flex">
                            <div class="justify-content-center">


                            </div>
                        </div>
                    </div>
                    <!-- End Page Header -->
                    <!-- Row -->
                    <div class="row row-sm">

                        <div class="col-xl-4 col-lg-4 col-md-4">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div>
                                        <h6 class="main-content-label mb-4">Team Image</h6>
                                    </div>
                                    <div class="">
                                        <div class="row row-sm">
                                            <div class="col-sm-12 col-md-12">
                                                <input type="file" class="dropify" name="profile"
                                                    data-default-file="{{ asset('assets/img/media/1.jpg') }}"
                                                    data-height="200" accept="image/*" />
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div>
                                        <h6 class="main-content-label mb-4">Banner Image</h6>
                                    </div>
                                    <div class="">
                                        <div class="row row-sm">
                                            <div class="col-sm-12 col-md-12">
                                                <input type="file" class="dropify" name="banner"
                                                    data-default-file="{{ asset('assets/img/media/1.jpg') }}"
                                                    data-height="200" accept="image/*" />
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div>
                                        <h6 class="main-content-label mb-4">Banner Image (Urdu)</h6>
                                    </div>
                                    <div class="">
                                        <div class="row row-sm">
                                            <div class="col-sm-12 col-md-12">
                                                <input type="file" class="dropify" name="banner_cn"
                                                    data-default-file="{{ asset('assets/img/media/1.jpg') }}"
                                                    data-height="200" accept="image/*" />
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div>
                                        <h6 class="main-content-label mb-4">Banner Image (Arabic)</h6>
                                    </div>
                                    <div class="">
                                        <div class="row row-sm">
                                            <div class="col-sm-12 col-md-12">
                                                <input type="file" class="dropify" name="banner_ar"
                                                    data-default-file="{{ asset('assets/img/media/1.jpg') }}"
                                                    data-height="200" accept="image/*" />
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6 mg-t-10 d-none">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Designation: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" name="designation" type="text">
                                            </div>
                                            @error('designation')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                            </div>
                        </div>

                        <div class="col-lg-8 col-md-8">
                            <div class="card custom-card">
                                <div class="card-body">

                                    <div>
                                        <h6 class="main-content-label mb-1">Team Info</h6>
                                    </div>
                                    <div class="row row-sm">

                                        <div class="col-sm-6 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Name: <span class="tx-danger">*</span></label>
                                                <input class="form-control" name="team_name" type="text">
                                            </div>
                                            @error('team_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Email: <span class="tx-danger">*</span></label>
                                                <input class="form-control" name="email" type="email">
                                            </div>
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Mobile: <span class="tx-danger">*</span></label>
                                                <input class="form-control" name="mobile" type="text">
                                            </div>
                                            @error('mobile')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6 mg-t-10">
                                            <label class="form-label">Gender: <span class="tx-danger">*</span></label>
                                            <select class="form-control select2" name="gender">
                                                <option value="">Select</option>
                                                <option value="Male" {{ old('gender') == 'Male' ? 'Selected' : '' }}>
                                                    Male</option>
                                                <option value="Female" {{ old('gender') == 'Female' ? 'Selected' : '' }}>
                                                    Female</option>
                                            </select>
                                            @error('gender')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6 mg-t-10 d-none">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Designation: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" name="designation" type="text">
                                            </div>
                                            @error('designation')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Profession: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" name="profession" type="text">
                                            </div>
                                            @error('profession')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-sm-12 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Description: <span
                                                        class="tx-danger"></span></label>
                                                <input class="form-control" name="description" type="text">
                                            </div>
                                            @error('description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-sm-12 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Description (Urdu): <span
                                                        class="tx-danger"></span></label>
                                                <input class="form-control" name="description_cn" type="text">
                                            </div>
                                            @error('description_cn')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-sm-12 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Description (Arabic): <span
                                                        class="tx-danger"></span></label>
                                                <input class="form-control" name="description_ar" type="text">
                                            </div>
                                            @error('description_ar')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        
                                        <div class="card custom-card">
                                            <div class="card-body">
                                                <div>
                                                    <h6 class="main-content-label  mb-3">Banner Description (English)</h6>
                                                </div>
                                                <div class="row row-sm">
                                                    <div class="col-md-12 col-lg-12 col-sm-12 form-group">
                                                        <textarea class="form-control textarea"  name="description" id="editor1" placeholder="" rows="8"></textarea>
    																
                                                    </div>
                                                </div>
                                            </div>
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
                        {{-- <a href="employee-profile.html" class="btn btn-primary" type="submit">Submit</a> --}}
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- End Main Content-->

<script src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('assets/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>

//[editor Javascript]

//Project:	Rhythm Admin - Responsive Admin Template
//Primary use:   Used only for the wysihtml5 Editor 


//Add text editor
    $(function () {
    "use strict";

    // Replace the <textarea id="editor1"> with a CKEditor
	// instance, using default configuration.
	CKEDITOR.replace('editor1')
	CKEDITOR.replace('editor1_cn')
	CKEDITOR.replace('editor1_ar')
	
	$('.textarea').wysihtml5();		
	
  });


</script> 

   
@endsection
