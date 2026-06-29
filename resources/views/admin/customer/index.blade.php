@extends('admin.layout.app')
@section('content')
    <!-- Main Content-->
    <div class="main-content side-content pt-0">

        <div class="main-container container-fluid">
            <div class="inner-body">

                <!-- Page Header -->
                <div class="page-header">
                    <div>
                        <h2 class="main-content-title tx-24 mg-b-5">Customer List ({{ @$customersCount }})</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">HRMS </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Customer List </li>
                        </ol>
                    </div>
                    <div class="d-flex">
                        <div class="justify-content-center">
                            {{-- <button type="button" class="btn btn-white btn-icon-text my-2 me-2">
                                <i class="fe fe-download me-2"></i> Import
                            </button>

                            <button type="button" class="btn btn-primary my-2 btn-icon-text  me-2">
                                <i class="fe fe-download-cloud me-2"></i> Download Report
                            </button>
                            <a href="add-employee.html" type="button" class="btn btn-primary my-2 btn-icon-text"> <i
                                    class="fe fe-plus me-2"></i> Add Customer</a> --}}
                        </div>
                    </div>
                </div>
                <!-- End Page Header -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card custom-card">
                            <div class="card-body py-3">
                                <form action="{{ route('customer.index') }}" method="get">
                                <!--@csrf-->
                                <div class="row">
                                    
                                    <div class="col-sm-4">
                                        <input class="form-control" placeholder="Search..." name="search_text" value="{{ @$request->search_text }}">
                                    </div>
                                    
                                    <div class="col-sm-2 ">
                                        <button type="submit"
                                        class="btn btn-primary  btn-icon-text"> <i class="fe fe-search me-2"></i> Search</button>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <!--<a href="{{ route('customer.create') }}" class="btn btn-primary btn-icon-text newbtn">Create Customer</a>-->
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
                                    <table class="table table-striped table-bordered  mb-0">
                                        <thead>
                                            <tr>
                                                
                                                <th><b>ID</b></th>
                                                <!--<th><b>Photo</b></th>-->
                                                <th><b>Name</b></th>
                                                <th><b>Email</b></th>
                                                <th><b>Mobile</b></th>
                                                <th><b>Gender</b></th>
                                                
                                                <th><b>Actions</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($customers as $item)
                                                <tr>
                                                   
                                                    <td>
                                                        CUS-{{ $item->id }}<br>
                                                    </td>
                                                    <!--<td><img alt="avatar" class="rounded-circle me-3"
                                                            src="{{ !empty($item->profile) ? asset('uploads/userimage/' . $item->profile) : asset('assets/img/media/user-img4.jpg') }}"
                                                            style="width:60px"></td>-->
                                                    <td>
                                                        <p class="mb-0">
                                                            {{ $item->first_name }} {{ $item->last_name }}
                                                        </p>
                                                    </td>
                                                    
                                                    <td>
                                                        <p class="mb-0">
                                                            {{ $item->email }}
                                                        </p>
                                                    </td>
                                                    
                                                    <td>
                                                        <p class="mb-0">
                                                            {{ $item->mobile }}
                                                        </p>
                                                    </td>
                                                    
                                                    
                                                    <td>
                                                        <p class="mb-0">
                                                            {{ $item->gender }}
                                                        </p>
                                                    </td>
                                                    
                                                    
                                                    <td>
                                                        
                                                  
                                                        <a href="{{ url('admin/customer-address/' . $item->id) }}"
                                                            class="btn ripple  btn-xs w-100 mb-1 btn-primary">
                                                            View Address</a>
                                                        <br>
                                                         
                                                        <!--<a href="{{ url('admin/customer_desable/' . $item->id) }}"
                                                            class="btn ripple  btn-xs w-100 mb-1 {{ $item->status == 1 ? 'btn-success' : 'btn-danger' }}">
                                                            {{ $item->status == 1 ? 'Block' : 'Unblock' }}</a>
                                                        <br>-->
                                                        
                                                        
                                                        <!--<a href="{{ route('customer.edit', $item->id) }}"
                                                            class="btn ripple btn-info btn-xs w-100 mb-1">Edit
                                                            Profile</a>
                                                        <br>-->
                                                        
                                                        
                                                        <!--<a href="javasctipt:void(0)"
                                                            class="btn ripple btn-danger btn-xs w-100"
                                                            onclick="event.preventDefault(); if (confirm('Are you sure you want to delete?')) { document.getElementById('delete-item-form{{ $item->id }}').submit(); }">
                                                            Delete
                                                        </a>
                                                        <form id="delete-item-form{{ $item->id }}"
                                                            action="{{ route('customer.destroy', $item->id) }}"
                                                            method="post" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>-->
                                                               
                                                            
                                                    </td>

                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end mt-2">
                                {!! $customers->onEachSide(5)->appends(request()->input())->links('pagination::bootstrap-4') !!}
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
    <!-- Large Modal -->
    <div class="modal" id="modaldemo-id">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title" id="doc_modal_title"></h6><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h6>Card Number: <span id=""></span></h6>

                            <img src="https://newadmin.dsl.com/assets/img/pngs/default-img.gif" id="img_file_link"
                                style="width:100%;">
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>
    <!--End Large Modal -->
    {{-- =======================================================================
                   end of  get document Modal 
========================================================================== --}}

    
@endsection
