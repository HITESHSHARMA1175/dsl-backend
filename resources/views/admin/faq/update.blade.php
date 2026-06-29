@extends('admin.layout.app')
@section('content')
    <!-- Main Content-->
    <div class="main-content side-content pt-0">

        <div class="main-container container-fluid">
            <div class="inner-body">

                <!-- Page Header -->
                <div class="page-header">
                    <div>
                        <h2 class="main-content-title tx-24 mg-b-5">Edit Faq</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Faq </a></li>
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
                <form action="{{ route('faq.update', $faq_info->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Row -->
                    <div class="row row-sm">


                        <div class="col-xl-12 col-lg-12 col-md-12">
                            
                            <div class="card custom-card">
                                <div class="card-body">

                                    <div>
                                        <h6 class="main-content-label mb-1">FAQ For</h6>
                                    </div>
                                    <div class="row row-sm">


                                        <div class="col-sm-4 mg-t-10">
                                            <label class="form-label">Service Category</label>
                                            <select class="form-control select select2" name="category_id" id="category_id" required>
                                                <option value="">Select</option>
                                                @foreach ($categories as $item)
                                                    <option value="{{ $item->id }}" {{ $faq_info->category_id == $item->id ? 'selected' : '' }}>{{ $item->category_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        

                                    </div>
                                </div>
                            </div>
                        
                        
                            <div class="row row-sm">
                                <div class="col-lg-12 col-md-12">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div>
                                                <h6 class="main-content-label  mb-3">Faq Details</h6>
                                            </div>
                                            <div class="col-lg-12 form-group">
                                                <label class="form-label">Question: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" name="question" value="{{ $faq_info->question }}"
                                                    placeholder="Enter" type="text"  required>
                                                @error('question')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-lg-12 form-group">
                                                <label class="form-label">Answer: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" name="answer" value="{{ $faq_info->answer }}"
                                                    placeholder="Enter" type="text" required>
                                                @error('answer')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-sm ">
                                <div class="col-lg-12 col-md-12">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div>
                                                <h6 class="main-content-label  mb-3">Faq Details (Chinese)</h6>
                                            </div>
                                            <div class="col-lg-12 form-group">
                                                <label class="form-label">Question: <span
                                                        class="tx-danger"></span></label>
                                                <input class="form-control" name="question_cn" value="{{ $faq_info->question_cn }}"
                                                    placeholder="Enter" type="text" >
                                                @error('question_cn')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-lg-12 form-group">
                                                <label class="form-label">Answer: <span
                                                        class="tx-danger"></span></label>
                                                <input class="form-control" name="answer_cn" value="{{ $faq_info->answer_cn }}"
                                                    placeholder="Enter" type="text" >
                                                @error('answer_cn')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-sm ">
                                <div class="col-lg-12 col-md-12">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div>
                                                <h6 class="main-content-label  mb-3">Faq Details (Arabic)</h6>
                                            </div>
                                            <div class="col-lg-12 form-group">
                                                <label class="form-label">Question: <span
                                                        class="tx-danger"></span></label>
                                                <input class="form-control" name="question_ar" value="{{ $faq_info->question_ar }}"
                                                    placeholder="Enter" type="text" dir="ltr">
                                                @error('question_ar')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-lg-12 form-group">
                                                <label class="form-label">Answer: <span
                                                        class="tx-danger"></span></label>
                                                <input class="form-control" name="answer_ar" value="{{ $faq_info->answer_ar }}"
                                                    placeholder="Enter" type="text" dir="ltr">
                                                @error('answer_ar')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
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
