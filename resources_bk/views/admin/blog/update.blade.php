@extends('admin.layout.app')
@section('content')
    <!-- Main Content-->
    <div class="main-content side-content pt-0">

        <div class="main-container container-fluid">
            <div class="inner-body">

                <!-- Page Header -->
                <div class="page-header">
                    <div>
                        <h2 class="main-content-title tx-24 mg-b-5">Edit Blog</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Blog </a></li>
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
                <form action="{{ route('blog.update', $blog_info->id) }}" method="post"
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
                                                <label class="form-label">Blog Slug: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" name="blog_slug" value="{{ $blog_info->blog_slug }}"
                                                    placeholder="Enter" type="text" required>
                                                @error('blog_slug')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-lg-12 form-group">
                                                <label class="form-label">Added Date: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" name="blog_date" value="{{ $blog_info->blog_date }}"
                                                    placeholder="Enter" type="date" required>
                                                @error('blog_date')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-lg-12 form-group">
                                                <label class="form-label">Meta Title: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" name="meta_title" value="{{ $blog_info->meta_title }}"
                                                    placeholder="Enter" type="text" required>
                                                @error('meta_title')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-lg-12 form-group">
                                                <label class="form-label">Meta Keywords: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" name="meta_keywords" value="{{ $blog_info->meta_keywords }}"
                                                    placeholder="Enter" type="text" required>
                                                @error('meta_keywords')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-lg-12 form-group">
                                                <label class="form-label">Meta Description: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" name="meta_description" value="{{ $blog_info->meta_description }}"
                                                    placeholder="Enter" type="text" required>
                                                @error('meta_description')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-lg-12 form-group">
                                                <label class="form-label">SEO Script: <span
                                                        class="tx-danger"></span></label>
                                                <textarea class="form-control textarea"  name="meta_scripts" id="meta_scripts" placeholder="" rows="8">{{ $blog_info->meta_scripts }}</textarea>
                                            </div>
                                            
                                            

                                        </div>

                                    </div>

                                </div>
                            </div>
                            
                            
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div>
                                        <h6 class="main-content-label mb-3">Blog INFO</h6>
                                    </div>
                                    <div class="">
                                        <div class="row row-sm ">

                                            <div class="col-lg-12 form-group d-none">
                                                <label class="form-label">Blog Category: <span class="tx-danger">*</span></label>
                                                <select class="form-control select select2" name="blog_category" >
                                                    <option value="">Select</option>
                                                    @foreach ($blog_category as $item)
                                                        <option value="{{ $item->id }}" {{ $blog_info->blog_category == $item->id ? 'selected' : '' }}>{{ $item->MasterValue }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-12 form-group">
                                                <label class="form-label">Blog Title: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" name="title" value="{{ $blog_info->title }}"
                                                    placeholder="Enter" type="text" required>
                                                @error('title')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            
                                            

                                        </div>

                                    </div>

                                </div>
                            </div>
                            
                            <div class="row row-sm">
                                
                                <div class="col-lg-12 col-md-12">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div>
                                                <h6 class="main-content-label  mb-3">Blog Description</h6>
                                            </div>
                                            <div class="row row-sm">
                                                <div class="col-md-12 col-lg-12 col-sm-12 form-group">
                                                    <textarea class="form-control textarea"  name="description" id="editor1" placeholder="" rows="8" >{{ $blog_info->description }}</textarea>
																
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div>
                                                <h6 class="main-content-label mb-4">Small Image</h6>
                                            </div>
                                            <div class="">
                                                <div class="row row-sm">
                                                    <div class="col-sm-12 col-md-12">
                                                        <input type="file" class="dropify" name="profile"
                                                            data-default-file="{{ !empty($blog_info->profile) ? asset('uploads/blog/' . $blog_info->profile) : asset('assets/img/media/1.jpg') }}"
                                                            data-height="188" accept="image/*" />
                                                    </div>
                                                    <div class="col-sm-12 col-md-12">
                                                        <label class="form-label">Image Name: <span
                                                                class="tx-danger"></span></label>
                                                        <input class="form-control" name="profile_name" value="{{ $blog_info->profile_name }}"
                                                            placeholder="Enter" type="text" >
                                                    </div>
                                                    <div class="col-sm-12 col-md-12">
                                                        <label class="form-label">Image Alt Tag: <span
                                                                class="tx-danger"></span></label>
                                                        <input class="form-control" name="profile_alt" value="{{ $blog_info->profile_alt }}"
                                                            placeholder="Enter" type="text" >
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
                                                <h6 class="main-content-label mb-4">Large Image</h6>
                                            </div>
                                            <div class="">
                                                <div class="row row-sm">
                                                    <div class="col-sm-12 col-md-12">
                                                        <input type="file" class="dropify" name="profile2"
                                                            data-default-file="{{ !empty($blog_info->profile2) ? asset('uploads/blog/' . $blog_info->profile2) : asset('assets/img/media/1.jpg') }}"
                                                            data-height="188" accept="image/*" />
                                                    </div>
                                                    <div class="col-sm-12 col-md-12">
                                                        <label class="form-label">Image Name: <span
                                                                class="tx-danger"></span></label>
                                                        <input class="form-control" name="profile2_name" value="{{ $blog_info->profile2_name }}"
                                                            placeholder="Enter" type="text" >
                                                    </div>
                                                    <div class="col-sm-12 col-md-12">
                                                        <label class="form-label">Image Alt Tag: <span
                                                                class="tx-danger"></span></label>
                                                        <input class="form-control" name="profile2_alt" value="{{ $blog_info->profile2_alt }}"
                                                            placeholder="Enter" type="text" >
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <hr class="p-1">
                            
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div>
                                        <h6 class="main-content-label mb-3">Blog INFO (Urdu)</h6>
                                    </div>
                                    <div class="">
                                        <div class="row row-sm ">

                                            <div class="col-lg-12 form-group">
                                                <label class="form-label">Blog Title: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" name="title_cn" value="{{ $blog_info->title_cn }}"
                                                    placeholder="Enter" type="text" required>
                                                @error('title_cn')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            
                                            

                                        </div>

                                    </div>

                                </div>
                            </div>
                            
                            
                            <div class="row row-sm">
                                
                                <div class="col-lg-12 col-md-12">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div>
                                                <h6 class="main-content-label  mb-3">Blog Description (Urdu)</h6>
                                            </div>
                                            <div class="row row-sm">
                                                <div class="col-md-12 col-lg-12 col-sm-12 form-group">
                                                    <textarea class="form-control textarea"  name="description_cn" id="editor2" placeholder="" rows="8" >{{ $blog_info->description_cn }}</textarea>
																
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div>
                                                <h6 class="main-content-label mb-4">Small Image (Urdu)</h6>
                                            </div>
                                            <div class="">
                                                <div class="row row-sm">
                                                    <div class="col-sm-12 col-md-12">
                                                        <input type="file" class="dropify" name="profile_cn"
                                                            data-default-file="{{ !empty($blog_info->profile_cn) ? asset('uploads/blog/' . $blog_info->profile_cn) : asset('assets/img/media/1.jpg') }}"
                                                            data-height="188" accept="image/*" />
                                                    </div>
                                                    <div class="col-sm-12 col-md-12">
                                                        <label class="form-label">Image Name: <span
                                                                class="tx-danger"></span></label>
                                                        <input class="form-control" name="profile_cn_name" value="{{ $blog_info->profile_cn_name }}"
                                                            placeholder="Enter" type="text" >
                                                    </div>
                                                    <div class="col-sm-12 col-md-12">
                                                        <label class="form-label">Image Alt Tag: <span
                                                                class="tx-danger"></span></label>
                                                        <input class="form-control" name="profile_cn_alt" value="{{ $blog_info->profile_cn_alt }}"
                                                            placeholder="Enter" type="text" >
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
                                                <h6 class="main-content-label mb-4">Large Image (Urdu)</h6>
                                            </div>
                                            <div class="">
                                                <div class="row row-sm">
                                                    <div class="col-sm-12 col-md-12">
                                                        <input type="file" class="dropify" name="profile2_cn"
                                                            data-default-file="{{ !empty($blog_info->profile2_cn) ? asset('uploads/blog/' . $blog_info->profile2_cn) : asset('assets/img/media/1.jpg') }}"
                                                            data-height="188" accept="image/*" />
                                                    </div>
                                                    <div class="col-sm-12 col-md-12">
                                                        <label class="form-label">Image Name: <span
                                                                class="tx-danger"></span></label>
                                                        <input class="form-control" name="profile2_cn_name" value="{{ $blog_info->profile2_cn_name }}"
                                                            placeholder="Enter" type="text" >
                                                    </div>
                                                    <div class="col-sm-12 col-md-12">
                                                        <label class="form-label">Image Alt Tag: <span
                                                                class="tx-danger"></span></label>
                                                        <input class="form-control" name="profile2_cn_alt" value="{{ $blog_info->profile2_cn_alt }}"
                                                            placeholder="Enter" type="text" >
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <hr class="p-1">
                            
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div>
                                        <h6 class="main-content-label mb-3">Blog INFO (Arabic)</h6>
                                    </div>
                                    <div class="">
                                        <div class="row row-sm ">

                                            <div class="col-lg-12 form-group">
                                                <label class="form-label">Blog Title: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" name="title_ar" value="{{ $blog_info->title_ar }}"
                                                    placeholder="Enter" type="text" required>
                                                @error('title_ar')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            
                                            

                                        </div>

                                    </div>

                                </div>
                            </div>
                            
                            <div class="row row-sm">
                                
                                <div class="col-lg-12 col-md-12">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div>
                                                <h6 class="main-content-label  mb-3">Blog Description (Arabic)</h6>
                                            </div>
                                            <div class="row row-sm">
                                                <div class="col-md-12 col-lg-12 col-sm-12 form-group">
                                                    <textarea class="form-control textarea"  name="description_ar" id="editor3" placeholder="" rows="8" >{{ $blog_info->description_ar }}</textarea>
																
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div>
                                                <h6 class="main-content-label mb-4">Small Image (Arabic)</h6>
                                            </div>
                                            <div class="">
                                                <div class="row row-sm">
                                                    <div class="col-sm-12 col-md-12">
                                                        <input type="file" class="dropify" name="profile_ar"
                                                            data-default-file="{{ !empty($blog_info->profile_ar) ? asset('uploads/blog/' . $blog_info->profile_ar) : asset('assets/img/media/1.jpg') }}"
                                                            data-height="188" accept="image/*" />
                                                    </div>
                                                    <div class="col-sm-12 col-md-12">
                                                        <label class="form-label">Image Name: <span
                                                                class="tx-danger"></span></label>
                                                        <input class="form-control" name="profile_ar_name" value="{{ $blog_info->profile_ar_name }}"
                                                            placeholder="Enter" type="text" >
                                                    </div>
                                                    <div class="col-sm-12 col-md-12">
                                                        <label class="form-label">Image Alt Tag: <span
                                                                class="tx-danger"></span></label>
                                                        <input class="form-control" name="profile_ar_alt" value="{{ $blog_info->profile_ar_alt }}"
                                                            placeholder="Enter" type="text" >
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
                                                <h6 class="main-content-label mb-4">Large Image (Arabic)</h6>
                                            </div>
                                            <div class="">
                                                <div class="row row-sm">
                                                    <div class="col-sm-12 col-md-12">
                                                        <input type="file" class="dropify" name="profile2_ar"
                                                            data-default-file="{{ !empty($blog_info->profile2_ar) ? asset('uploads/blog/' . $blog_info->profile2_ar) : asset('assets/img/media/1.jpg') }}"
                                                            data-height="188" accept="image/*" />
                                                    </div>
                                                    <div class="col-sm-12 col-md-12">
                                                        <label class="form-label">Image Name: <span
                                                                class="tx-danger"></span></label>
                                                        <input class="form-control" name="profile2_ar_name" value="{{ $blog_info->profile2_ar_name }}"
                                                            placeholder="Enter" type="text" >
                                                    </div>
                                                    <div class="col-sm-12 col-md-12">
                                                        <label class="form-label">Image Alt Tag: <span
                                                                class="tx-danger"></span></label>
                                                        <input class="form-control" name="profile2_ar_alt" value="{{ $blog_info->profile2_ar_alt }}"
                                                            placeholder="Enter" type="text" >
                                                    </div>

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
