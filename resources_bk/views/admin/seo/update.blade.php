@extends('admin.layout.app')
@section('content')
    <!-- Main Content-->
    <div class="main-content side-content pt-0">

        <div class="main-container container-fluid">
            <div class="inner-body">

                <!-- Page Header -->
                <div class="page-header">
                    <div>
                        <h2 class="main-content-title tx-24 mg-b-5">Edit Seo</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Seo </a></li>
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
                <form action="{{ route('seo.update', $seo_info->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Row -->
                    <div class="row row-sm">


                        <div class="col-xl-12 col-lg-12 col-md-12">
                            
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div>
                                        <h6 class="main-content-label mb-3">SEO INFO</h6>
                                    </div>
                                    <div class="">
                                        <div class="row row-sm ">

                                            <div class="col-lg-12 form-group">
                                                <label class="form-label">Page URL: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" name="pageurl" value="{{ $seo_info->pageurl }}"
                                                    placeholder="Enter" type="text" required readonly>
                                                @error('pageurl')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-lg-12 form-group">
                                                <label class="form-label">Page Title: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" name="title" value="{{ $seo_info->title }}"
                                                    placeholder="Enter" type="text" required>
                                                @error('title')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            
                                            

                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div>
                                        <h6 class="main-content-label mb-3">SEO INFO</h6>
                                    </div>
                                    <div class="">
                                        <div class="row row-sm ">


                                            
                                            <div class="col-lg-12 form-group">
                                                <label class="form-label">Meta Title: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" name="meta_title" value="{{ $seo_info->meta_title }}"
                                                    placeholder="Enter" type="text" required >
                                                @error('meta_title')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-lg-12 form-group">
                                                <label class="form-label">Meta Keywords: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" name="meta_keywords" value="{{ $seo_info->meta_keywords }}"
                                                    placeholder="Enter" type="text" required>
                                                @error('meta_keywords')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-lg-12 form-group">
                                                <label class="form-label">Meta Description: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" name="meta_description" value="{{ $seo_info->meta_description }}"
                                                    placeholder="Enter" type="text" required>
                                                @error('meta_description')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-lg-12 form-group">
                                                <label class="form-label">SEO Script: <span
                                                        class="tx-danger"></span></label>
                                                <textarea class="form-control textarea"  name="meta_scripts" id="meta_scripts" placeholder="" rows="8">{{ $seo_info->meta_scripts }}</textarea>
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
	CKEDITOR.replace('editor2')
	CKEDITOR.replace('editor3')
	
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
