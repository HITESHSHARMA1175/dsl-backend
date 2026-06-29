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

        <form action="{{ route('property.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="main-container container-fluid">
                <div class="inner-body">

                    <!-- Page Header  -->
                    <div class="page-header">
                        <div>
                            <h2 class="main-content-title tx-24 mg-b-5">Add Service</h2>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Service </a></li>
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
                        <div class="col-lg-12 col-md-12">
                            <div class="card custom-card">
                                <div class="card-body">

                                    <div>
                                        <h6 class="main-content-label mb-1">Service Info</h6>
                                    </div>
                                    <div class="row row-sm">


                                        <div class="col-sm-3 mg-t-10" style="display:none;">
                                            <label class="form-label">Service Type</label>
                                            <select class="form-control select select2" name="parent_id" >
                                                <option value="0">Main Service</option>
                                                @foreach ($services as $item)
                                                    <option value="{{ $item->id }}">{{ $item->property_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-6 mg-t-10">
                                            <label class="form-label">Select Condition</label>
                                            <select class="form-control select select2" name="skin_condition[]" id="skin_condition"
                                            onchange="getPropertySubCondByCond(this,'')" multiple>
                                                <option value="">Select</option>
                                                @foreach ($conditions as $item)
                                                    <option value="{{ $item->id }}">{{ $item->category_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-6 mg-t-10" >
                                            <label class="form-label">Service Sub Condition</label>
                                            <select class="form-control select select2" name="skin_sub_condition[]"
                                                id="skin_sub_condition" multiple>
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6 mg-t-10">
                                            <label class="form-label">Service Category<span class="tx-danger"></span></label>
                                            <select class="form-control select select2" name="category[]" id="category"
                                                onchange="getPropertySubCatByCat(this,'')" multiple>
                                                <option value="">Select</option>
                                                @foreach ($categories as $item)
                                                    <option value="{{ $item->id }}">{{ $item->category_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-6 mg-t-10" >
                                            <label class="form-label">Service Sub Category</label>
                                            <select class="form-control select select2" name="sub_category[]"
                                                id="sub_category" multiple>
                                                <option value="">Select</option>
                                            </select>
                                        </div>


                                        <div class="col-sm-12 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Service Title<span class="tx-danger">*</span></label>
                                                <input class="form-control" name="property_name" type="text" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Short Description</label>
                                                <textarea class="form-control" name="description" type="text"></textarea>
                                            </div>
                                        </div>



                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-12 col-md-12">
                            <div class="card custom-card">
                                <div class="card-body">

                                    <div>
                                        <h6 class="main-content-label mb-1">Map Product</h6>
                                    </div>
                                    <div class="row row-sm">

                                        <div class="col-sm-6 mg-t-10">
                                            <label class="form-label">Service Products</label>
                                            <select class="form-control select select2" name="addon_id[]"  multiple>
                                                @foreach ($addons as $item)
                                                    <option value="{{ $item->id }}">{{ $item->addon_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12">
                            <div class="card custom-card">
                                <div class="card-body">

                                    <div>
                                        <h6 class="main-content-label mb-1">Perform Task</h6>
                                    </div>
                                    <div class="row row-sm">


                                        <div class="col-sm-4 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Duration to Perform Task (In Minutes)</label>
                                                <input class="form-control" name="duration" type="number" >
                                            </div>
                                        </div>

                                        <div class="col-sm-4 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Members Required to Perform Task</label>
                                                <input class="form-control" name="number_of_members_required"
                                                    type="number" value="1">
                                            </div>
                                        </div>

                                        <div class="col-sm-4 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Max Quantity allowed for services</label>
                                                <input class="form-control" name="max_quantity_allowed" type="number" value="1">
                                            </div>
                                        </div>



                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12">
                            <div class="card custom-card">
                                <div class="card-body">

                                    <div>
                                        <h6 class="main-content-label mb-1">Price Details</h6>
                                    </div>
                                    <div class="row row-sm">

                                        <div class="col-sm-4 mg-t-10 ">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Session<span class="tx-danger">*</span></label>
                                                <input class="form-control" name="session1" type="number" min="1" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Price<span class="tx-danger">*</span></label>
                                                <input class="form-control" name="price" type="number" value="0" min="1" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-4 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Discount</label>
                                                <input class="form-control" name="discounted_price" type="number" value="0">
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-4 mg-t-10 ">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Session</label>
                                                <input class="form-control" name="session2" type="number"  >
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mg-t-10 ">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Price Per Session</label>
                                                <input class="form-control" name="price2" type="number" value="0" >
                                            </div>
                                        </div>

                                        <div class="col-sm-4 mg-t-10 ">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Discount Per Session</label>
                                                <input class="form-control" name="discounted_price2" type="number" value="0" >
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-4 mg-t-10 ">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Session</label>
                                                <input class="form-control" name="session3" type="number"  >
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mg-t-10 ">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Price Per Session</label>
                                                <input class="form-control" name="price3" type="number" value="0" >
                                            </div>
                                        </div>

                                        <div class="col-sm-4 mg-t-10 ">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Discount Per Session</label>
                                                <input class="form-control" name="discounted_price3" type="number" value="0" >
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-4 mg-t-10 ">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Session</label>
                                                <input class="form-control" name="session4" type="number"  >
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mg-t-10 ">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Price Per Session</label>
                                                <input class="form-control" name="price4" type="number" value="0" >
                                            </div>
                                        </div>

                                        <div class="col-sm-4 mg-t-10 ">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Discount Per Session</label>
                                                <input class="form-control" name="discounted_price4" type="number" value="0" >
                                            </div>
                                        </div>



                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div>
                                        <h6 class="main-content-label  mb-3">Service Description</h6>
                                    </div>
                                    <div class="row row-sm">
                                        <div class="col-md-12 col-lg-12 col-sm-12 form-group">
                                            <textarea class="form-control textarea" name="long_description" id="editor2" placeholder="" rows="8"></textarea>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div>
                                        <h6 class="main-content-label mb-4">Main Image</h6>
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
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div>
                                        <h6 class="main-content-label mb-4">Offer Image</h6>
                                    </div>
                                    <div class="">
                                        <div class="row row-sm">
                                            <div class="col-sm-12 col-md-12">
                                                <input type="file" class="dropify" name="offer_image"
                                                    data-default-file="{{ asset('assets/img/media/1.jpg') }}"
                                                    data-height="200" accept="image/*" />
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
                                        <h6 class="main-content-label  mb-3">Uploads Other Images</h6>
                                    </div>
                                    <div class="row row-sm">
                                        <div class="col-md-12 col-lg-12 col-sm-12 form-group">
                                            <label class="form-label">Upload Image</label>
                                            <div class="input-images-1" style="padding-top: .5rem;"></div>
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

    <script>
        $(document).ready(function() {

            //$(".rentNoDiv").show();

            $(".rentDiv").hide();

            /*$(".js-example-theme-single").select2({
              theme: "classic"
            });*/

            $("#owner").select2({
                theme: "classic"
                //placeholder: "Select",
                //dropdownParent: $('#showEditModal')
                // dropdownParent: $("#exampleModal")
            });
            $("#builder").select2({
                theme: "classic"
                //placeholder: "Select",
                //dropdownParent: $('#showEditModal')
                // dropdownParent: $("#exampleModal")
            });
            $("#society").select2({
                theme: "classic"
                //placeholder: "Select",
                //dropdownParent: $('#showEditModal')
                // dropdownParent: $("#exampleModal")
            });


        });
    </script>

    @include('admin.property.include.ajaxCode')
@endsection
