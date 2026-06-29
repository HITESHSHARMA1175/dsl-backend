@extends('admin.layout.app')
@section('content')
    <!-- Main Content-->
    <div class="main-content side-content pt-0">

        <div class="main-container container-fluid">
            <div class="inner-body">

                <!-- Page Header -->
                <div class="page-header">
                    <div>
                        <h2 class="main-content-title tx-24 mg-b-5">Kiosk Booking List ({{ @$kibookingCount }})</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Kiosk Booking </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Kiosk Booking List </li>
                        </ol>
                    </div>
                    <div class="d-flex">
                        <div class="justify-content-center">
                            {{-- <button type="button" class="btn btn-white btn-icon-text my-2 me-2" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                <i class="fe fe-download me-2"></i> Import
                            </button> --}}

                            {{-- <a href="{{ route('kibooking.create') }}" type="button" class="btn btn-primary my-2 btn-icon-text">
                                <i class="fe fe-plus me-2"></i> Add Kiosk Booking</a>  --}}
                        </div>
                    </div>
                </div>
                <!-- End Page Header -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card custom-card">
                            <div class="card-body py-3">
                                <form action="{{ route('kibooking.index') }}" method="get">
                                    <!--@csrf-->
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control form-control" placeholder="Search..."
                                                aria-controls="example1" name="searchtext"
                                                value="{{ $request->searchtext }}">
                                        </div>

                                        <div class="col-sm-3 ">
                                            <select class="form-control select2" name="parent_id">
                                                <option value="">Service</option>
                                                @foreach ($services as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $request->parent_id == $item->id ? 'selected' : '' }}>
                                                        {{ $item->property_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-sm-2 ">
                                            <button type="submit" class="btn btn-primary  btn-icon-text"> <i
                                                    class="fe fe-search me-2"></i> Search</button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Row -->
                <div class="row row-sm">
                    <div class="col-lg-12">
                        <div class="card custom-card">
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered text-nowrap mb-0">
                                        <thead>
                                            <tr>
                                                {{-- <th><label class="ckbox"><input type="checkbox"
                                                            value="5"><span></span></label></th> --}}
                                                <th>ID</th>
                                                <th>User Details</th>
                                                
                                                <th>Professional Details</th>
                                                
                                                <th>Services</th>
                                                
                                                <th>Addons</th>
                                                
                                                <!--<th>Slot</th>-->
                                                
                                                <th>Slot</th>
                                                
                                                <th>Payment</th>
                                                
                                                <th>Booking Date</th>

                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($kibookings) > 0)
                                                @foreach ($kibookings as $item)
                                                    <tr>

                                                        <td>
                                                            {{ $item->id }}
                                                        </td>
                                                        <td>        
                                                            {{ @$item->getKiBookingUser->first_name }} {{ @$item->getKiBookingUser->last_name }}<br>
                                                            {{ @$item->getKiBookingUser->email }}
                                                        </td>
                                                        <td>        
                                                            {{ @$item->getKiBookingProfessional->professional_name }}<br>
                                                            {{ @$item->getKiBookingProfessional->email }}<br>
                                                            {{ @$item->getKiBookingProfessional->mobile }}
                                                        </td>
                                                        <td><!--property_name-->
                                                            @foreach (@$item->getKiBookinService() as $items)
                                                            <span class="btn ripple btn-info btn-xs w-100 mb-1">{{ $items->property_name }}</span><br>
                                                            @endforeach
                                                        </td>
                                                        <td><!--addon_name-->
                                                            
                                                            @foreach (@$item->getKiBookinAddon() as $itema)
                                                            <span class="btn ripple btn-info btn-xs w-100 mb-1">{{ $itema->addon_name }}</span><br>
                                                            @endforeach
                                                        </td>
                                                        <!--<td>
                                                            {{ $item->slot_date }}<br>
                                                            {{ $item->slot_time }}<br>
                                                        </td>-->
                                                        <td>
                                                            Clinic: {{ $item->getKiBookingClinic->clinic_name ?? 'NA' }}<br>
                                                            Date: {{ $item->selected_date }}<br>
                                                            Time: {{ $item->selected_time }}
                                                        </td>
                                                        <td>
                                                            Status: Done<br>
                                                            Payment Method: {{ $item->payment_method }}<br>
                                                            Tr ID: {{ $item->payment_method_id }}
                                                        </td>
                                                        <td>
                                                          {{ $item->created_at }}
                                                        </td>
                                                        <!--<td>
                                                            @if ($item->status == '1')
                                                                <span class="text-success">Active</span>
                                                            @else
                                                                <span class="text-danger">In-Active</span>
                                                            @endif
                                                        </td>-->


                                                        <td>
                                                            {{-- <div class="main-toggle-group-demo">
                                                                <a href="{{ url('admin/kibooking_status/' . $item->id) }}"
                                                                    onclick="return confirm('Are you want to {{ $item->status == 1 ? 'Disable' : 'Enable' }}?')">
                                                                    <div
                                                                        class="main-toggle main-toggle-success {{ $item->status == 1 ? 'on' : 'off' }}">
                                                                        <span></span>
                                                                    </div>
                                                                </a>
                                                            </div> --}}

                                                            {{-- <a href="{{ route('kibooking.edit', $item->id) }}"
                                                                class="btn ripple btn-info btn-xs w-100">Edit
                                                            </a>
                                                            <br> --}}

                                                            {{-- <a href="{{ route('kibooking.show', $item->id) }}"
                                                                class="btn ripple btn-primary btn-xs w-100">View History
                                                            </a>
                                                            <br> --}}

                                                            <a href="javasctipt:void(0)"
                                                                class="btn ripple btn-danger btn-xs w-100"
                                                                onclick="event.preventDefault(); if (confirm('Are you sure you want to delete?')) { document.getElementById('delete-item-form{{ $item->id }}').submit(); }">
                                                                Delete
                                                            </a>
                                                            <form id="delete-item-form{{ $item->id }}"
                                                                action="{{ route('kibooking.destroy', $item->id) }}"
                                                                method="post" style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>

                                                        </td>

                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr class="text-center">
                                                    <td colspan="7"> Data Not Found.</td>
                                                </tr>
                                            @endif

                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-end mt-2">
                                    {!! $kibookings->onEachSide(5)->appends(request()->input())->links('pagination::bootstrap-4') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Row -->
            </div>
        </div>
    </div>
    <!-- End Main Content-->

    {{-- =======================================================================
                       get document Modal 
========================================================================== --}}


    @include('admin.kibooking.include.ajaxCode')
@endsection
