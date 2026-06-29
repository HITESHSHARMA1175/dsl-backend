@extends('admin.layout.app')
@section('content')
    <!-- Main Content-->
    <div class="main-content side-content pt-0">

        <form action="{{ route('addon.update', $addon_info->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="main-container container-fluid">
                <div class="inner-body">

                    <!-- Page Header -->
                    <div class="page-header">
                        <div>
                            <h2 class="main-content-title tx-24 mg-b-5">Edit Addon</h2>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Addon </a></li>
                            </ol>
                        </div>
                        <div class="d-flex">
                            <div class="justify-content-center">
                                {{-- 
                                <button type="button" class="btn btn-primary my-2 btn-icon-text">
                                    <i class="fe fe-download-cloud me-2"></i> Print
                                </button> --}}
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
                                            <label class="form-label">Addon Category</label>
                                            <select class="form-control select select2" name="parent_id" required>
                                                <option value="">Select Category</option>
                                                @foreach ($addoncats as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $addon_info->parent_id == $item->id ? 'selected' : '' }}>
                                                        {{ $item->MasterValue }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-sm-6 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Addon Title</label>
                                                <input class="form-control" name="addon_name"
                                                    value="{{ $addon_info->addon_name }}" type="text">
                                            </div>
                                        </div>

                                        <div class="col-sm-12 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Short Description</label>
                                                <textarea class="form-control" name="description" type="text">{{ $addon_info->description }}</textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12" style="display:none;">
                            <div class="card custom-card">
                                <div class="card-body">

                                    <div>
                                        <h6 class="main-content-label mb-1">Perform Task</h6>
                                    </div>
                                    <div class="row row-sm">


                                        <div class="col-sm-4 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Duration to Perform Task (In Minutes)</label>
                                                <input class="form-control" name="duration"
                                                    value="{{ $addon_info->duration }}" type="number">
                                            </div>
                                        </div>

                                        <div class="col-sm-4 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Members Required to Perform Task</label>
                                                <input class="form-control" name="number_of_members_required"
                                                    value="{{ $addon_info->number_of_members_required }}" type="number">
                                            </div>
                                        </div>

                                        <div class="col-sm-4 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Max Quantity allowed for services</label>
                                                <input class="form-control" name="max_quantity_allowed"
                                                    value="{{ $addon_info->max_quantity_allowed }}" type="number">
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
                                                <input class="form-control" name="price" value="{{ $addon_info->price }}"
                                                    type="text">
                                            </div>
                                        </div>

                                        <div class="col-sm-4 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Discounted Price</label>
                                                <input class="form-control" name="discounted_price"
                                                    value="{{ $addon_info->discounted_price }}" type="text">
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
                                        <h6 class="main-content-label mb-4">Main Image</h6>
                                    </div>
                                    <div class="">
                                        <div class="row row-sm">
                                            <div class="col-sm-12 col-md-12">
                                                <input type="file" class="dropify" name="profile"
                                                    data-default-file="{{ !empty($addon_info->profile) ? asset('uploads/addon/' . $addon_info->profile) : asset('assets/img/media/1.jpg') }}"
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
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- End Main Content-->

    <script>
        $(document).ready(function() {
            if ('{{ $addon_info->is_for_rent }}' == 'Yes') {
                $(".rentDiv").show();
            } else {
                $(".rentDiv").hide();
            }

        });
    </script>


    @include('admin.addon.include.ajaxCode')
@endsection
