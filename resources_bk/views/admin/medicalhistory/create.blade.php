@extends('admin.layout.app')
@section('content')
    <!-- Main Content-->
    <div class="main-content side-content pt-0">

        <div class="main-container container-fluid">
            <div class="inner-body">

                <!-- Page Header -->
                <div class="page-header">
                    <div>
                        <h2 class="main-content-title tx-24 mg-b-5">Add Medical History Value</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Medical History Value </a></li>
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
                <form action="{{ route('medicalhistory.store') }}" method="post" enctype="multipart/form-data"
                    data-parsley-validate="">
                    @csrf

                    <!-- Row -->
                    <div class="row row-sm">


                        <div class="col-xl-12 col-lg-12 col-md-12">
                            
                            <div class="card custom-card">
                                <div class="card-body">
                                        <div>
                                           
                                        <div class="">
                                            <div class="row row-sm">
                                                <div class="col-lg-12 form-group">
                                                    <label class="form-label">Medical History: <span class="tx-danger">*</span></label>
                                                    <select class="form-control select select2" name="medical_history" required>
                                                        <option value="">Select</option>
                                                        @foreach ($medical_historys as $item)
                                                            <option value="{{ $item->id }}">{{ $item->MasterValue }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-lg-12 form-group">
                                                    <label class="form-label">Enter Medical History Value: <span class="tx-danger">*</span></label>
                                                    <input class="form-control" name="name" placeholder="" type="text" required> 
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
