@extends('admin.layout.app')
@section('content')
    <!-- Main Content-->
    <div class="main-content side-content pt-0">

        <div class="main-container container-fluid">
            <div class="inner-body">

                <!-- Page Header -->
                <div class="page-header">
                    <div>
                        <h2 class="main-content-title tx-24 mg-b-5">Edit Category</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Category </a></li>
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
                <form action="{{ route('servicesubcat.update', $servicesubcat_info->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Row -->
                    <div class="row row-sm">


                        <div class="col-xl-12 col-lg-12 col-md-12">
                            
                            <div class="row row-sm">
                                
                                <div class="col-lg-3 col-md-3">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div>
                                                <h6 class="main-content-label mb-4">Category Small Image</h6>
                                            </div>
                                            <div class="">
                                                <div class="row row-sm">
                                                    <div class="col-sm-12 col-md-12">
                                                        <input type="file" class="dropify" name="icon"
                                                            data-default-file="{{ !empty($servicesubcat_info->icon) ? asset('uploads/servicesubcat/' . $servicesubcat_info->icon) : asset('assets/img/media/1.jpg') }}"
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
                                                <h6 class="main-content-label  mb-3">Category Details</h6>
                                            </div>
                                            <div class="col-sm-12 form-group">
                                                <label class="form-label">Parent Category: <span
                                                        class="tx-danger">*</span></label>
                                                <select class="form-control select select2" name="parent_id[]" id="parent_id" multiple required>
                                                     @foreach ($parentcategories as $item)
                                                        <option value="{{ $item->id }}" 
                                                            {{ !empty($servicesubcat_info->parent_ids) && in_array($item->id, json_decode($servicesubcat_info->parent_ids, true)) ? 'selected' : '' }}>
                                                            {{ $item->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-12 form-group">
                                                <label class="form-label">Category Name: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" name="category_name" value="{{ $servicesubcat_info->category_name }}"
                                                    placeholder="Enter" type="text" required>
                                                @error('category_name')
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
                                                <h6 class="main-content-label mb-4"> Small Image (Chinese)</h6>
                                            </div>
                                            <div class="">
                                                <div class="row row-sm">
                                                    <div class="col-sm-12 col-md-12">
                                                        <input type="file" class="dropify" name="icon_cn"
                                                            data-default-file="{{ !empty($servicesubcat_info->icon_cn) ? asset('uploads/servicesubcat/' . $servicesubcat_info->icon_cn) : asset('assets/img/media/1.jpg') }}"
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
                                                <h6 class="main-content-label  mb-3">Category Details</h6>
                                            </div>
                                            
                                            <div class="col-lg-12 form-group">
                                                <label class="form-label">Category Name (Chinese): <span
                                                        class="tx-danger"></span></label>
                                                <input class="form-control" name="category_name_cn" value="{{ $servicesubcat_info->category_name_cn }}"
                                                    placeholder="Enter" type="text" >
                                                @error('category_name_cn')
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
                                                <h6 class="main-content-label mb-4"> Small Image (Arabic)</h6>
                                            </div>
                                            <div class="">
                                                <div class="row row-sm">
                                                    <div class="col-sm-12 col-md-12">
                                                        <input type="file" class="dropify" name="icon_ar"
                                                            data-default-file="{{ !empty($servicesubcat_info->icon_ar) ? asset('uploads/servicesubcat/' . $servicesubcat_info->icon_ar) : asset('assets/img/media/1.jpg') }}"
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
                                                <h6 class="main-content-label  mb-3">Category Details</h6>
                                            </div>
                                            
                                            <div class="col-lg-12 form-group">
                                                <label class="form-label">Category Name (Arabic): <span
                                                        class="tx-danger"></span></label>
                                                <input class="form-control" name="category_name_ar" value="{{ $servicesubcat_info->category_name_ar }}"
                                                    placeholder="Enter" type="text" >
                                                @error('category_name_ar')
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
	CKEDITOR.replace('description3')
	CKEDITOR.replace('description3_cn')
	CKEDITOR.replace('description3_ar')
	
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
