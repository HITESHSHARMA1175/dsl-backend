@extends('admin.layout.app')
@section('content')
    <!-- Main Content-->
    <div class="main-content side-content pt-0">

        <div class="main-container container-fluid">
            <div class="inner-body">

                <!-- Page Header -->
                <div class="page-header">
                    <div>
                        <h2 class="main-content-title tx-24 mg-b-5">Add Banner</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Banner </a></li>
                        </ol>
                    </div>
                    <div class="d-flex">
                        <div class="justify-content-center">

                            {{-- <button type="button" class="btn btn-primary my-2 btn-icon-text">
                                <i class="fe fe-download-cloud me-2"></i> Print
                            </button> --}}
                        </div>
                    </div>
                </div>
                <!-- End Page Header -->
                <form action="{{ route('banner.store') }}" method="post" enctype="multipart/form-data"
                    data-parsley-validate="">
                    @csrf

                    <!-- Row -->
                    <div class="row row-sm">


                        <div class="col-xl-12 col-lg-12 col-md-12">
                            
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div>
                                        <h6 class="main-content-label mb-3">Other INFO</h6>
                                    </div>
                                    <div class="">
                                        <div class="row row-sm ">
 

                                            <div class="col-sm-6 form-group">
                                                <label class="form-label">Banner Type</label>
                                                <select class="form-control select select2" name="banner_type" id="banner_type" required>
                                                    <option value="">Select</option>
                                                    <option value="Home Top Banner" >Home Top Banner</option>
                                                    <option value="Category Details Top Banner" >Category Details Top Banner</option>
                                                    <option value="Conatct Top Banner" >Conatct Top Banner</option>
                                                    <option value="About Top Banner" >About Top Banner</option>
                                                    <option value="Refund Policy Top Banner" >Refund Policy Top Banner</option>
                                                    <option value="Term & Condition Top Banner" >Term & Condition Top Banner</option>
                                                    <option value="Privacy Policy Top Banner" >Privacy Policy Top Banner</option>
                                                    <option value="Shop Top Banner" >Shop Top Banner</option>
                                                    <option value="Category Top Banner" >Category Top Banner</option>
                                                    <option value="Offer Top Banner" >Offer Top Banner</option>
                                                </select>
                                            </div>


                                            <div class="col-lg-6 form-group">
                                                <label class="form-label">Banner Name: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" name="banner_name" value="{{ old('banner_name') }}"
                                                    placeholder="Enter" type="text" required>
                                                @error('banner_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-lg-6 form-group">
                                                <label class="form-label">URL: <span
                                                        class="tx-danger"></span></label>
                                                <input class="form-control" name="banner_url" value="{{ old('banner_url') }}"
                                                    placeholder="Enter" type="text" >
                                                @error('banner_url')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>



                                        </div>

                                    </div>

                                </div>
                            </div>
                            
                            <div class="row row-sm">
                                <div class="col-lg-3 col-md-3">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div>
                                                <h6 class="main-content-label mb-4">Banner Image (English)</h6>
                                            </div>
                                            <div class="">
                                                <div class="row row-sm">
                                                    <div class="col-sm-12 col-md-12">
                                                        <input type="file" class="dropify" name="profile"
                                                            data-default-file="{{ asset('assets/img/media/1.jpg') }}"
                                                            data-height="188" accept="image/*" />
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-9 col-md-9">
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
                            <div class="row row-sm">
                                <div class="col-lg-3 col-md-3">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div>
                                                <h6 class="main-content-label mb-4">Banner Image (Chinese)</h6>
                                            </div>
                                            <div class="">
                                                <div class="row row-sm">
                                                    <div class="col-sm-12 col-md-12">
                                                        <input type="file" class="dropify" name="profile_cn"
                                                            data-default-file="{{ asset('assets/img/media/1.jpg') }}"
                                                            data-height="188" accept="image/*" />
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-9 col-md-9">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div>
                                                <h6 class="main-content-label  mb-3">Banner Description (Chinese)</h6>
                                            </div>
                                            <div class="row row-sm">
                                                <div class="col-md-12 col-lg-12 col-sm-12 form-group">
                                                    <textarea class="form-control textarea"  name="description_cn" id="editor1_cn" placeholder="" rows="8"></textarea>
																
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-lg-3 col-md-3">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div>
                                                <h6 class="main-content-label mb-4">Banner Image (Arabic)</h6>
                                            </div>
                                            <div class="">
                                                <div class="row row-sm">
                                                    <div class="col-sm-12 col-md-12">
                                                        <input type="file" class="dropify" name="profile_ar"
                                                            data-default-file="{{ asset('assets/img/media/1.jpg') }}"
                                                            data-height="188" accept="image/*" />
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-9 col-md-9">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div>
                                                <h6 class="main-content-label  mb-3">Banner Description (Arabic)</h6>
                                            </div>
                                            <div class="row row-sm">
                                                <div class="col-md-12 col-lg-12 col-sm-12 form-group">
                                                    <textarea class="form-control textarea"  name="description_ar" id="editor1_ar" placeholder="" rows="8"></textarea>
																
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row row-sm">
                                <div class="col-12 mb-3">
                                    <input type="submit" class="btn btn-primary" value="Submit">
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- End Row -->
                </form>

            </div>
        </div>
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
 
    <script>
       
        $(function() {
            $('.input-images-1').imageUploader({
                imagesInputName: 'photos',
                preloadedInputName: 'old',
                maxSize: 2 * 1024 * 1024,
                maxFiles: 10,
                extensions: ['.jpg', '.jpeg', '.png'],
                mimes: ['image/jpeg', 'image/png']
            });
        });
    </script>
@endsection
