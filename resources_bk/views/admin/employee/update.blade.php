@extends('admin.layout.app')
@section('content')
    <!-- Main Content-->
    <div class="main-content side-content pt-0">

        <div class="main-container container-fluid">
            <div class="inner-body">

                <!-- Page Header -->
                <div class="page-header">
                    <div>
                        <h2 class="main-content-title tx-24 mg-b-5">Update Staff</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Internal Staff </a></li>
                        </ol>
                    </div>
                    <!--<div class="d-flex">
                        <div class="justify-content-center">

                            <button type="button" class="btn btn-primary my-2 btn-icon-text" onclick="printDiv('contentToPrint')">
                                <i class="fe fe-download-cloud me-2"></i> Print
                            </button>
                        </div>
                    </div>-->
                </div>
                <!-- End Page Header -->
                <form action="{{ route('employee.update', $user->id) }}" method="post" enctype="multipart/form-data"
                    data-parsley-validate="" id="contentToPrint">

                    @csrf
                    @method('PUT')

                    <!-- Row -->
                    <div class="row row-sm">

                        <div class="col-xl-4 col-lg-4 col-md-4">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div>
                                        <h6 class="main-content-label mb-4">PROFILE PHOTO</h6>
                                    </div>
                                    <div class="">
                                        <div class="row row-sm">
                                            <div class="col-sm-12 col-md-12">
                                                <input type="file" class="dropify" name="profile"
                                                    data-default-file="{{ !empty($user->profile) ? asset('uploads/userimage/' . $user->profile) : '' }}"
                                                    data-height="200" accept="image/*" />
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-8 col-lg-8 col-md-8">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div>
                                        <h6 class="main-content-label mb-3">BASIC INFO</h6>
                                    </div>
                                    <div class="">
                                        <div class="row row-sm">
                                            <div class="col-lg-6 form-group">
                                                <label class="form-label">Full Name: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" name="first_name"
                                                    value="{{ $user->first_name }}" placeholder="Enter full name"
                                                    type="text">
                                                @error('first_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-lg-6 form-group">
                                                <label class="form-label">Email ID: <span class="tx-danger"></span></label>
                                                <input class="form-control" name="email" value="{{ $user->email }}"
                                                    placeholder="Enter " type="email">
                                                @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-lg-6 form-group">
                                                <label class="form-label">Mobile No: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" name="mobile_no" value="{{ $user->mobile_no }}"
                                                    placeholder="Enter " type="number">
                                                @error('mobile_no')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            
                                            
                                            
                                            <div class="col-lg-6 form-group">
                                                <label class="form-label">Password: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" name="password" value="{{ $user->password_copy }}"
                                                    placeholder="Enter " type="text">
                                                @error('password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            
                                            @if(@auth()->user()->is_sub_admin==1)
                                            <div class="col-sm-6 form-group" style="pointer-events: none;">
                                                <label class="form-label">Area: <span
                                                        class="tx-danger">*</span></label>
                                                <select class="form-control select select2" name="designation">
                                                    <option value="">Select</option>
                                                    @foreach ($designations as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ auth()->user()->is_sub_admin ? 'Selected' : '' }}>
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('designation')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            @else
                                            <div class="col-sm-6 form-group">
                                                <label class="form-label">Area: <span
                                                        class="tx-danger">*</span></label>
                                                <select class="form-control select select2" name="designation">
                                                    <option value="">Select</option>
                                                    @foreach ($designations as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ $user->designation == $item->id ? 'Selected' : '' }}>
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('designation')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            @endif
                                            
                                            <div class="col-lg-6">
                                                <label class="form-label">Gender: <span class="tx-danger"></span></label>
                                                <select class="form-control select2" name="gender">
                                                    <option value="">Select</option>
                                                    <option value="Male" {{ $user->gender == 'Male' ? 'Selected' : '' }}>
                                                        Male</option>
                                                    <option value="Female"
                                                        {{ $user->gender == 'Female' ? 'Selected' : '' }}>
                                                        Female</option>
                                                </select>
                                                @error('gender')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div><!-- col-4 -->

                                            <div class="col-lg-6">
                                                <label class="form-label">Date of Birth: <span
                                                        class="tx-danger"></span></label>
                                                <div class="input-group">
                                                    <div class="input-group-text border-end-0">
                                                        <i class="fe fe-calendar lh--9 op-6"></i>
                                                    </div>
                                                    <input class="form-control fc-datepicker" name="dob"
                                                        placeholder="MM/DD/YYYY" value="{{ $user->dob }}"
                                                        type="text">
                                                </div>
                                                @error('dob')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
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
                                        <h6 class="main-content-label mb-1">Address Details</h6>
                                    </div>
                                    <div class="row row-sm">
                                        <div class="col-sm-12 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label"> Full Address</label>
                                                <input class="form-control" value="{{ $user->address }}" name="address"
                                                    type="text">
                                            </div>
                                            @error('address')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6 mg-t-10">
                                            <label class="form-label">Country</label>
                                            <select class="form-control select select2" name="country" id="country"
                                                onchange="getStateByCountryId(this.value,null)">
                                                <option value="">Select</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}"
                                                        {{ $user->country == $country->id ? 'Selected' : '' }}>
                                                        {{ $country->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('country')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6 mg-t-10">
                                            <label class="form-label">State</label>
                                            <select class="form-control select select2" name="state" id="state"
                                                onchange="getCitisByStateId(this.value,null)">
                                                <option value="">Select</option>
                                            </select>
                                            @error('state')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6 mg-t-10">
                                            <label class="form-label">City</label>
                                            <select class="form-control select select2" name="city" id="city">
                                                <option value="">Select</option>
                                            </select>
                                            @error('city')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-sm-6 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Pin Code</label>
                                                <input class="form-control" name="pincode" value="{{ $user->pincode }}"
                                                    type="text">
                                            </div>
                                            @error('pincode')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- End Row -->



                    <div class="row row-sm">
                        <div class="col-12 mb-3">
                            <input type="submit" class="btn btn-primary" value="Submit">
                            {{-- <a href="employee-profile.html" class="btn btn-primary" type="submit">Submit</a> --}}
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- End Main Content-->
    
    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
    
    <script>
        $(document).ready(function() {
            let country_id = $('#country').val();
            getStateByCountryId(country_id, {{ $user->state }})
                .then(function() {
                    var state_id = $('#state').val();
                    // $('#property').val(property_id)
                    getCitisByStateId(state_id, {{ $user->city }});
                });
        });
    </script>
    <script>
        // State list onchange of country field
        function getStateByCountryId(country_id, checkedState) {
            var counId = '';
            if (country_id != undefined && country_id != '') {
                counId = country_id;
            } else {
                counId = $('#country').val();
            }
            $('#state').empty();
            return $.ajax({
                url: "{{ route('getState') }}",
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    counId: counId,
                    checkedState: checkedState
                },
                beforeSend: function(res) {
                    $('#state').html('<option  value="">Loading...</option>');
                },
                success: function(res) {
                    $('#state').html(res.data);
                }
            })
        }

        // State list onchange of country field

        function getCitisByStateId(state_id, checkedCity) {
            var stateId = "";
            if (state_id != undefined && state_id != '') {
                stateId = state_id;
            } else {
                stateId = $('#state').val();
            }

            console.log(stateId);
            $('#city').empty();
            $.ajax({
                url: "{{ route('getcities') }}",
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    stateId: stateId,
                    checkedCity: checkedCity
                },
                beforeSend: function(res) {
                    $('#city').html('<option value="">Loading...</option>');
                },
                success: function(res) {
                    $('#city').html(res.data);
                }
            })
        }
    </script>
@endsection
