@extends('admin.layout.app')
@section('content')
    
    <!-- Main Content-->
        <div class="main-content side-content pt-0">
            <div class="main-container container-fluid">
                <div class="inner-body">
                    <!-- Page Header -->
                    <div class="page-header">
                        <div>
                            <h2 class="main-content-title tx-24 mg-b-5">Add Seller</h2>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Internal Seller </a></li>
                            </ol>
                        </div>
                        <!--<div class="d-flex">
                        <div class="justify-content-center">

                            <button type="button" class="btn btn-primary my-2 btn-icon-text" onclick="printDiv('contentToPrint')">
                                <i class="fe fe-download-cloud me-2"></i> Print
                            </button>
                        </div>
                    </div>--></div>
                    <!-- End Page Header -->
                    <form action="https://admin.dsl.co.in/admin/employee" method="post" enctype="multipart/form-data" data-parsley-validate="" id="contentToPrint">
                        <input type="hidden" name="_token" value="mBCiUT5quy5O1SmkDO9RU7OHrVX5KAIEBQozFZY1" autocomplete="off">
                        <!-- Row -->
                        <div class="row row-sm">
                            <!-- <div class="col-xl-4 col-lg-4 col-md-4">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div>
                                            <h6 class="main-content-label mb-4">PROFILE PHOTO</h6> </div>
                                        <div class="">
                                            <div class="row row-sm">
                                                <div class="col-sm-12 col-md-12">
                                                    <input type="file" class="dropify" name="profile" data-default-file="" data-height="200" accept="image/*" /> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <div class="col-lg-12">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div>
                                            <h6 class="main-content-label mb-3">Seller Details</h6> </div>
                                        <div class="">
                                            <div class="row row-sm">
                                                <div class="col-lg-6 form-group">
                                                    <label class="form-label">First Name: <span class="tx-danger">*</span></label>
                                                    <input class="form-control" name="first_name" value="" placeholder="Enter First Name" type="text"> </div>
                                                <div class="col-lg-6 form-group">
                                                    <label class="form-label"> ⁠Last Name: <span class="tx-danger">*</span></label>
                                                    <input class="form-control" name="last_name" value="" placeholder="Enter ⁠Last Name" type="text"> </div>
                                                <div class="col-lg-6 form-group">
                                                    <label class="form-label">Email ID: <span class="tx-danger"></span></label>
                                                    <input class="form-control" name="email" value="" placeholder="Enter " type="email"> </div>
                                                <div class="col-lg-6 form-group">
                                                    <label class="form-label">Mobile No: <span class="tx-danger">*</span></label>
                                                    <input class="form-control" name="mobile_no" value="" placeholder="Enter " type="number"> </div>
                                                
                                                <div class="col-lg-6">
                                                    <label class="form-label">Gender: <span class="tx-danger"></span></label>
                                                    <select class="form-control select2" name="gender">
                                                        <option value="">Select</option>
                                                        <option value="Male"> Male</option>
                                                        <option value="Female"> Female</option>
                                                    </select>
                                                </div>
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Row -->
                        <!-- Row -->
                        <div class="row row-sm">
                            <div class="col-lg-12 col-md-12">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div>
                                            <h6 class="main-content-label mb-1">Seller Shop Details</h6> </div>
                                        <div class="row row-sm">
                                            <div class="col-sm-6 mg-t-10">
                                                <div class="form-group mb-0">
                                                    <label class="form-label"> ⁠Shop Name</label>
                                                    <input class="form-control" value="" name="address" type="text"> </div>
                                            </div>
                                            <div class="col-sm-6 mg-t-10">
                                                <div class="form-group mb-0">
                                                    <label class="form-label"> ⁠⁠Shop GST Number</label>
                                                    <input class="form-control" value="" name="address" type="text"> </div>
                                            </div>
                                            <div class="col-sm-6 mg-t-10">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">⁠⁠Shop Pan Number</label>
                                                    <input class="form-control" value="" name="address" type="text"> </div>
                                            </div>
                                            <div class="col-sm-6 mg-t-10">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">Shop Business Number</label>
                                                    <input class="form-control" value="" name="address" type="text"> </div>
                                            </div>
                                            
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Row -->
                        <div class="row row-sm">
                            <div class="col-lg-12 col-md-12">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div>
                                            <h6 class="main-content-label mb-1">Shop Address</h6> </div>
                                        <div class="row row-sm">
                                               
                                            <div class="col-sm-6 mg-t-10">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">State <span class="tx-danger"></span></label>
                                                    <select class="form-control select2" name="gender">
                                                        <option value="">Select</option>
                                                        <option value="Male"> State</option>
                                                        <option value="Female"> State</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 mg-t-10">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">City <span class="tx-danger"></span></label>
                                                    <select class="form-control select2" name="gender">
                                                        <option value="">Select</option>
                                                        <option value="Male"> City</option>
                                                        <option value="Female"> City</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 mg-t-10">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">⁠ Pin Code</label>
                                                    <input class="form-control" value="" name="address" type="text"> </div>
                                            </div>
                                            <div class="col-sm-6 mg-t-10">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">Shop Fulll Address</label>
                                                    <input class="form-control" value="" name="address" type="text"> </div>
                                            </div>
                                            
                                            
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
                                            <h6 class="main-content-label mb-1">Bank Account Details⁠</h6> </div>
                                        <div class="row row-sm">
                                           
                                           
                                            <div class="col-sm-6 mg-t-10">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">Account Holder Name</label>
                                                    <input class="form-control" name="Account Holder Name" value="" type="text"> </div>
                                            </div>
                                            <div class="col-sm-6 mg-t-10">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">⁠Bank Account Number</label>
                                                    <input class="form-control" name="⁠Bank Account Number" value="" type="text"> </div>
                                            </div>
                                            <div class="col-sm-6 mg-t-10">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">⁠IFSC Code</label>
                                                    <input class="form-control" name="⁠Bank Account Number" value="" type="text"> </div>
                                            </div>
                                            <div class="col-sm-6 mg-t-10">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">Branch Adresss</label>
                                                    <input class="form-control" name="⁠Bank Account Number" value="" type="text"> </div>
                                            </div>
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
                                            <h6 class="main-content-label mb-1">Seller KYC Documents ⁠</h6> </div>
                                        <div class="row row-sm">
                                           
                                           
                                            <div class="col-sm-6 mg-t-10">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">Enter Aadhar Number</label>
                                                    <input class="form-control" name="Account Holder Name" value="" type="text"> </div>
                                            </div>
                                            <div class="col-sm-6 mg-t-10">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">⁠Upload Aadhar Card</label>
                                                    <input class="form-control" name="⁠Bank Account Number" value="" type="file"> </div>
                                            </div>
                                            <div class="col-sm-6 mg-t-10">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">Enter Pan Number</label>
                                                    <input class="form-control" name="⁠Bank Account Number" value="" type="text"> </div>
                                            </div>
                                            <div class="col-sm-6 mg-t-10">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">Upload Pan Card</label>
                                                    <input class="form-control" name="⁠Bank Account Number" value="" type="file"> </div>
                                            </div>
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
                                            <h6 class="main-content-label mb-1">Shop Documents ⁠</h6> </div>
                                        <div class="row row-sm">
                                           
                                           
                                            <div class="col-sm-6 mg-t-10">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">Shop GST</label>
                                                    <input class="form-control" name="Account Holder Name" value="" type="text"> </div>
                                            </div>
                                           
                                            <div class="col-sm-6 mg-t-10">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">⁠Pan Card</label>
                                                    <input class="form-control" name="⁠Bank Account Number" value="" type="text"> </div>
                                            </div>
                                            <div class="col-sm-6 mg-t-10">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">⁠Shop Images</label>
                                                    <input class="form-control" name="⁠Bank Account Number" value="" type="file"> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Row -->
                        <div class="row row-sm">
                            <div class="col-12 mb-3">
                                <input type="submit" class="btn btn-primary" value="Submit"> </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Main Content-->

   
@endsection
