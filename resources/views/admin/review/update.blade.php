@extends('admin.layout.app')
@section('content')
    <!-- Main Content-->
    <div class="main-content side-content pt-0">

        <div class="main-container container-fluid">
            <div class="inner-body">

                <!-- Page Header -->
                <div class="page-header">
                    <div>
                        <h2 class="main-content-title tx-24 mg-b-5">Edit Review</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Review </a></li>
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
                <form action="{{ route('reviews.update', $review_info->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Row -->
                    <div class="row row-sm">


                       
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            
                            <div class="card custom-card">
                                <div class="card-body">
                                        <div>
                                           
                                        <div class="">
                                            <div class="row row-sm">
                                                <div class="col-lg-4 form-group">
                                                    <label class="form-label">Full Name: <span class="tx-danger">*</span></label>
                                                    <input class="form-control" name="full_name" value="{{ $review_info->full_name }}" placeholder="Enter" type="text" required> 
                                                </div>
                                                <div class="col-lg-4 form-group">
                                                    <label class="form-label">Rating: <span class="tx-danger">*</span></label>
                                                    <select class="form-control select select2" name="rating" required>
                                                        <option value="">Select</option>
                                                        
                                                        <option value="1" {{ $review_info->rating == '1' ? 'selected' : '' }}>1</option>
                                                        <option value="2" {{ $review_info->rating == '2' ? 'selected' : '' }}>2</option>
                                                        <option value="3" {{ $review_info->rating == '3' ? 'selected' : '' }}>3</option>
                                                        <option value="4" {{ $review_info->rating == '4' ? 'selected' : '' }}>4</option>
                                                        <option value="5" {{ $review_info->rating == '5' ? 'selected' : '' }}>5</option>
                                                        
                                                    </select>
                                                </div>
                                                <div class="col-lg-4 form-group">
                                                    <label class="form-label">Date: <span class="tx-danger"></span></label>
                                                    <input class="form-control" name="adddate" value="{{ $review_info->adddate }}" placeholder="Enter" type="date" > 
                                                </div>
                                                <div class="col-lg-12 form-group">
                                                    <label class="form-label">Enter Review Title: <span class="tx-danger">*</span></label>
                                                    <input class="form-control" name="title" value="{{ $review_info->title }}" placeholder="Enter" type="text" required> 
                                                </div>
                                                <div class="col-lg-12 form-group">
                                                    <label class="form-label">Enter Review: <span class="tx-danger">*</span></label>
                                                    <input class="form-control" name="description" value="{{ $review_info->description }}" placeholder="Enter" type="text" required> 
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
