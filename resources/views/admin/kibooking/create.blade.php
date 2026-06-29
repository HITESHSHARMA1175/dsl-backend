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

        <form action="{{ route('addon.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="main-container container-fluid">
                <div class="inner-body">

                    <!-- Page Header  -->
                    <div class="page-header">
                        <div>
                            <h2 class="main-content-title tx-24 mg-b-5">Add Addon</h2>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Addon </a></li>
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
                                        <h6 class="main-content-label mb-1">Addon Info</h6>
                                    </div>
                                    <div class="row row-sm">


                                        <div class="col-sm-6 mg-t-10">
                                            <label class="form-label">Service</label>
                                            <select class="form-control select select2" name="parent_id" required>
                                                <option value="">Select Service</option>
                                                @foreach ($services as $item)
                                                    <option value="{{ $item->id }}">{{ $item->property_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>



                                        <div class="col-sm-6 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Addon Title</label>
                                                <input class="form-control" name="addon_name" type="text">
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
                                        <h6 class="main-content-label mb-1">Perform Task</h6>
                                    </div>
                                    <div class="row row-sm">


                                        <div class="col-sm-4 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Duration to Perform Task (In Minutes)</label>
                                                <input class="form-control" name="duration" type="number">
                                            </div>
                                        </div>

                                        <div class="col-sm-4 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Members Required to Perform Task</label>
                                                <input class="form-control" name="number_of_members_required"
                                                    type="number">
                                            </div>
                                        </div>

                                        <div class="col-sm-4 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Max Quantity allowed for services</label>
                                                <input class="form-control" name="max_quantity_allowed" type="number">
                                            </div>
                                        </div>



                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8 col-md-8">
                            <div class="card custom-card">
                                <div class="card-body">

                                    <div>
                                        <h6 class="main-content-label mb-1">Price Details</h6>
                                    </div>
                                    <div class="row row-sm">


                                        <div class="col-sm-4 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Price</label>
                                                <input class="form-control" name="price" type="text">
                                            </div>
                                        </div>

                                        <div class="col-sm-4 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Discounted Price</label>
                                                <input class="form-control" name="discounted_price" type="text">
                                            </div>
                                        </div>



                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-4">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div>
                                        <h6 class="main-content-label mb-4">Addon Image</h6>
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

    @include('admin.addon.include.ajaxCode')
@endsection
