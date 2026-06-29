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

        <form action="{{ route('redurl.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="main-container container-fluid">
                <div class="inner-body">

                    <!-- Page Header  -->
                    <div class="page-header">
                        <div>
                            <h2 class="main-content-title tx-24 mg-b-5">Add Redirect URL</h2>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Redirect URL </a></li>
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
                                        <h6 class="main-content-label mb-1">Redirect URL Info</h6>
                                    </div>
                                    <div class="row row-sm">


                                        <div class="col-sm-12 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Old URL: Redirect To<span class="text-danger">*</span> (Ex: URL is "https://dslclinic.com/acne"  add only "acne")</label>
                                                <input class="form-control" name="old_url" type="text" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Redirect To<span class="text-danger">*</span> (Ex: URL is "https://dslclinic.com/acne"  add only "acne")</label>
                                                <input class="form-control" name="redirect_url" type="text" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Short Description<span class="text-danger"></span> </label>
                                                <input class="form-control" name="short_description" type="text" >
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

    
@endsection
