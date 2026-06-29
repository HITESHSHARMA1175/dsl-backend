@extends('admin.layout.app')
@section('content')
    <!-- Main Content-->
    <div class="main-content side-content pt-0">

        <div class="main-container container-fluid">
            <div class="inner-body">

                <!-- Page Header -->
                <div class="page-header">
                    <div>
                        <h2 class="main-content-title tx-24 mg-b-5">Edit Condition</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Condition </a></li>
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
                <form action="{{ route('skincondition.update', $skincondition_info->id) }}" method="post"
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
                                                <h6 class="main-content-label mb-4">Condition Small Image</h6>
                                            </div>
                                            <div class="">
                                                <div class="row row-sm">
                                                    <div class="col-sm-12 col-md-12">
                                                        <input type="file" class="dropify" name="icon"
                                                            data-default-file="{{ !empty($skincondition_info->icon) ? asset('uploads/servicecat/' . $skincondition_info->icon) : asset('assets/img/media/1.jpg') }}"
                                                            data-height="188" accept="image/*" />
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div>
                                                <h6 class="main-content-label mb-4">Condition Large Image</h6>
                                            </div>
                                            <div class="">
                                                <div class="row row-sm">
                                                    <div class="col-sm-12 col-md-12">
                                                        <input type="file" class="dropify" name="icon_large"
                                                            data-default-file="{{ !empty($skincondition_info->icon_large) ? asset('uploads/servicecat/' . $skincondition_info->icon_large) : asset('assets/img/media/1.jpg') }}"
                                                            data-height="188" accept="image/*" />
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div>
                                                <h6 class="main-content-label  mb-3">Condition Details</h6>
                                            </div>
                                            <div class="col-sm-12 form-group d-none">
                                                <label class="form-label">Service Main Condition: <span
                                                        class="tx-danger"></span></label>
                                                <select class="form-control select select2" name="main_category" id="main_category" >
                                                    <option value="">Select</option>
                                                    @foreach ($maincategories as $item)
                                                        <option value="{{ $item->id }}" {{ $skincondition_info->main_category == $item->id ? 'selected' : '' }}>{{ $item->category_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-12 form-group">
                                                <label class="form-label">Show in the Header: <span
                                                        class="tx-danger"></span></label>
                                                <select class="form-control select select2" name="is_top" id="is_top" >
                                                    
                                                    <option value="0" {{ $skincondition_info->is_top == '0' ? 'selected' : '' }}>No</option>
                                                    <option value="1" {{ $skincondition_info->is_top == '1' ? 'selected' : '' }}>Yes</option>
                                                    
                                                </select>
                                            </div>
                                            <div class="col-lg-12 form-group">
                                                <label class="form-label">Condition Name: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" name="category_name" value="{{ $skincondition_info->category_name }}"
                                                    placeholder="Enter" type="text" required>
                                                @error('category_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-lg-12 form-group">
                                                <label class="form-label">Short Description: <span
                                                        class="tx-danger"></span></label>
                                                <input class="form-control" name="description" value="{{ $skincondition_info->description }}"
                                                    placeholder="Enter" type="text" >
                                                @error('description')
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
                                                <input class="form-control" name="meta_title" value="{{ $skincondition_info->meta_title }}"
                                                    placeholder="Enter" type="text" required>
                                                @error('meta_title')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-lg-12 form-group">
                                                <label class="form-label">Meta Keywords: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" name="meta_keywords" value="{{ $skincondition_info->meta_keywords }}"
                                                    placeholder="Enter" type="text" required>
                                                @error('meta_keywords')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-lg-12 form-group">
                                                <label class="form-label">Meta Description: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" name="meta_description" value="{{ $skincondition_info->meta_description }}"
                                                    placeholder="Enter" type="text" required>
                                                @error('meta_description')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-lg-12 form-group">
                                                <label class="form-label">SEO Script: <span
                                                        class="tx-danger"></span></label>
                                                <textarea class="form-control textarea"  name="meta_scripts" id="meta_scripts" placeholder="" rows="8">{{ $skincondition_info->meta_scripts }}</textarea>
                                            </div>
                                            
                                            

                                        </div>

                                    </div>

                                </div>
                            </div>
                            
                            <div class="card custom-card">
                                <div class="card-body">
                                    
                                    <div class="col-lg-12 col-md-12 ">
                                        <div>
                                            <h6 class="main-content-label  mb-3">Desctiption</h6>
                                        </div>
                                        <div class="row row-sm">
                                            <div class="col-md-12 col-lg-12 col-sm-12 form-group">
                                                <textarea class="form-control textarea"  name="description3" id="description3" placeholder="" rows="8">{{ $skincondition_info->description3 }}</textarea>
															
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <label class="form-label">Youtube Link: <span
                                                class="tx-danger"></span></label>
                                        <input class="form-control" name="youtube_link" value="{{ $skincondition_info->youtube_link }}"
                                            placeholder="Enter" type="text" >
                                        @error('youtube_link')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-3 mg-t-10">
                                        <div class="form-group mb-0">
                                            <label class="form-label">Description Image</label>
                                            <input class="form-control" name="icon2" type="file" >
                                        </div>
                                        @if($skincondition_info->icon2!='')
                                        <img style="width: 200px;" src="{{ asset('uploads/servicecat/' . $skincondition_info->icon2) }}">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card custom-card ">
                                <div class="card-body">

                                    <div>
                                        <h6 class="main-content-label mb-1">Box Data</h6>
                                    </div>
                                    <div class="row row-sm">


                                        <div class="col-sm-3 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Image 1</label>
                                                <input class="form-control" name="image1" type="file" >
                                            </div>
                                            @if($skincondition_info->image1!='')
                                            <img style="width: 200px;" src="{{ asset('uploads/servicecat/' . $skincondition_info->image1) }}">
                                            @endif
                                        </div>
                                        <div class="col-sm-3 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Image 2</label>
                                                <input class="form-control" name="image2" type="file" >
                                            </div>
                                            @if($skincondition_info->image2!='')
                                            <img style="width: 200px;" src="{{ asset('uploads/servicecat/' . $skincondition_info->image2) }}">
                                            @endif
                                        </div>
                                        <div class="col-sm-3 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Image 3</label>
                                                <input class="form-control" name="image3" type="file" >
                                            </div>
                                            @if($skincondition_info->image3!='')
                                            <img style="width: 200px;" src="{{ asset('uploads/servicecat/' . $skincondition_info->image3) }}">
                                            @endif
                                        </div>
                                        <div class="col-sm-3 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Image 4</label>
                                                <input class="form-control" name="image4" type="file" >
                                            </div>
                                            @if($skincondition_info->image4!='')
                                            <img style="width: 200px;" src="{{ asset('uploads/servicecat/' . $skincondition_info->image4) }}">
                                            @endif
                                        </div>


                                    </div>
                                </div>
                            </div>
                            
                            
                            
                            <hr style="border: 2px solid;">
                            
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
                                                            data-default-file="{{ !empty($skincondition_info->icon_cn) ? asset('uploads/servicecat/' . $skincondition_info->icon_cn) : asset('assets/img/media/1.jpg') }}"
                                                            data-height="188" accept="image/*" />
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div>
                                                <h6 class="main-content-label mb-4"> Large Image (Chinese)</h6>
                                            </div>
                                            <div class="">
                                                <div class="row row-sm">
                                                    <div class="col-sm-12 col-md-12">
                                                        <input type="file" class="dropify" name="icon_large_cn"
                                                            data-default-file="{{ !empty($skincondition_info->icon_large_cn) ? asset('uploads/servicecat/' . $skincondition_info->icon_large_cn) : asset('assets/img/media/1.jpg') }}"
                                                            data-height="188" accept="image/*" />
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div>
                                                <h6 class="main-content-label  mb-3">Condition Details</h6>
                                            </div>
                                            
                                            <div class="col-lg-12 form-group">
                                                <label class="form-label">Condition Name (Chinese): <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" name="category_name_cn" value="{{ $skincondition_info->category_name_cn }}"
                                                    placeholder="Enter" type="text" >
                                                @error('category_name_cn')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-lg-12 form-group ">
                                                <label class="form-label">Short Description (Chinese): <span
                                                        class="tx-danger"></span></label>
                                                <input class="form-control" name="description_cn" value="{{ $skincondition_info->description_cn }}"
                                                    placeholder="Enter" type="text" >
                                                @error('description_cn')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="card custom-card">
                                <div class="card-body">
                                    
                                    
                                    <div class="col-lg-12 col-md-12">
                                        <div>
                                            <h6 class="main-content-label  mb-3">Desctiption (Chinese)</h6>
                                        </div>
                                        <div class="row row-sm">
                                            <div class="col-md-12 col-lg-12 col-sm-12 form-group">
                                                <textarea class="form-control textarea"  name="description3_cn" id="description3_cn" placeholder="" rows="8">{{ $skincondition_info->description3_cn }}</textarea>
															
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <label class="form-label">Youtube Link (Chinese): <span
                                                class="tx-danger"></span></label>
                                        <input class="form-control" name="youtube_link_cn" value="{{ $skincondition_info->youtube_link_cn }}"
                                            placeholder="Enter" type="text" >
                                        @error('youtube_link')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-3 mg-t-10">
                                        <div class="form-group mb-0">
                                            <label class="form-label">Description Image (Chinese)</label>
                                            <input class="form-control" name="icon2_cn" type="file" >
                                        </div>
                                        @if($skincondition_info->icon2_cn!='')
                                        <img style="width: 200px;" src="{{ asset('uploads/servicecat/' . $skincondition_info->icon2_cn) }}">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <hr style="border: 2px solid;">
                            
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
                                                            data-default-file="{{ !empty($skincondition_info->icon_ar) ? asset('uploads/servicecat/' . $skincondition_info->icon_ar) : asset('assets/img/media/1.jpg') }}"
                                                            data-height="188" accept="image/*" />
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div>
                                                <h6 class="main-content-label mb-4"> Large Image (Arabic)</h6>
                                            </div>
                                            <div class="">
                                                <div class="row row-sm">
                                                    <div class="col-sm-12 col-md-12">
                                                        <input type="file" class="dropify" name="icon_large_ar"
                                                            data-default-file="{{ !empty($skincondition_info->icon_large_ar) ? asset('uploads/servicecat/' . $skincondition_info->icon_large_ar) : asset('assets/img/media/1.jpg') }}"
                                                            data-height="188" accept="image/*" />
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div>
                                                <h6 class="main-content-label  mb-3">Condition Details</h6>
                                            </div>
                                            
                                            <div class="col-lg-12 form-group">
                                                <label class="form-label">Condition Name (Arabic): <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" name="category_name_ar" value="{{ $skincondition_info->category_name_ar }}"
                                                    placeholder="Enter" type="text" >
                                                @error('category_name_ar')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-lg-12 form-group ">
                                                <label class="form-label">Short Description (Arabic): <span
                                                        class="tx-danger"></span></label>
                                                <input class="form-control" name="description_ar" value="{{ $skincondition_info->description_ar }}"
                                                    placeholder="Enter" type="text" >
                                                @error('description_ar')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="card custom-card">
                                <div class="card-body">
                                    
                                    
                                    <div class="col-lg-12 col-md-12">
                                        <div>
                                            <h6 class="main-content-label  mb-3">Desctiption (Arabic)</h6>
                                        </div>
                                        <div class="row row-sm">
                                            <div class="col-md-12 col-lg-12 col-sm-12 form-group">
                                                <textarea class="form-control textarea"  name="description3_ar" id="description3_ar" placeholder="" rows="8">{{ $skincondition_info->description3_ar }}</textarea>
															
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <label class="form-label">Youtube Link (Arabic): <span
                                                class="tx-danger"></span></label>
                                        <input class="form-control" name="youtube_link_ar" value="{{ $skincondition_info->youtube_link_ar }}"
                                            placeholder="Enter" type="text" >
                                        @error('youtube_link')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-3 mg-t-10">
                                        <div class="form-group mb-0">
                                            <label class="form-label">Description Image (Arabic)</label>
                                            <input class="form-control" name="icon2_ar" type="file" >
                                        </div>
                                        @if($skincondition_info->icon2_ar!='')
                                        <img style="width: 200px;" src="{{ asset('uploads/servicecat/' . $skincondition_info->icon2_ar) }}">
                                        @endif
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
