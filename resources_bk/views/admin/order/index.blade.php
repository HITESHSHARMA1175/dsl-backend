@extends('admin.layout.app')
@section('content')
    <!-- Main Content-->
    <div class="main-content side-content pt-0">

        <div class="main-container container-fluid">
            <div class="inner-body">

                <!-- Page Header -->
                <div class="page-header">
                    <div>
                        <h2 class="main-content-title tx-24 mg-b-5">Order List ({{ @$orderCount }})</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Order </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Order List </li>
                        </ol>
                    </div>
                    <div class="d-flex">
                        <div class="justify-content-center">
                            {{-- <button type="button" class="btn btn-white btn-icon-text my-2 me-2" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                <i class="fe fe-download me-2"></i> Import
                            </button> --}}

                            {{-- <a href="{{ route('order.create') }}" type="button" class="btn btn-primary my-2 btn-icon-text">
                                <i class="fe fe-plus me-2"></i> Add Order</a>  --}}
                        </div>
                    </div>
                </div>
                <!-- End Page Header -->

                <div class="row d-none">
                    <div class="col-lg-12">
                        <div class="card custom-card">
                            <div class="card-body py-3">
                                <form action="{{ route('order.index') }}" method="get">
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
                                                
                                                <th>Order Details</th>
                                                
                                                <th>Billing Address</th>
                                                
                                                
                                                <th>Order Amount</th>
                                                
                                                <th>Payment</th>
                                                
                                                <th>Add date</th>
                                                
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($orders) > 0)
                                                @foreach ($orders as $item)
                                                    <tr>

                                                        <td>
                                                            {{ $item->id }}
                                                        </td>
                                                        <td>        
                                                            {{ @$item->getOrderUser->first_name }} {{ @$item->getOrderUser->last_name }}<br>
                                                            {{ @$item->getOrderUser->mobile }}
                                                        </td>
                                                        <td>
                                                            Company: {{ $item->billing_company }}<br>
                                                            Country: {{ $item->billing_country }}<br>
                                                            Phone: {{ $item->billing_phone }}<br>
                                                            Email: {{ $item->billing_email }}<br>
                                                            Address: {{ $item->billing_address_1 }}
                                                        </td>
                                                        <td>        
                                                            <?php $cartDetails = json_decode($item->cart_details, true); ?>

                                                            @if (!empty($cartDetails) && is_array($cartDetails))
                                                                @foreach ($cartDetails as $detail)
                                                                <img src="{{ !empty($detail['get_checked_addon']['profile']) ? asset('uploads/addon/' . $detail['get_checked_addon']['profile']) : asset('assets/img/media/1.jpg') }}" 
                                                                 alt="Custom Product" style="width:40px">
                                                                    {{ $detail['get_checked_addon']['addon_name'] ?? 'No addon name available' }} <br> ( £{{ $detail['get_checked_addon']['price'] }} 
                                                                    <span class="text-primary">X</span> {{ $detail['item'] }} qty <span class="text-primary">=</span>
                                                                    £<?php echo $detail['get_checked_addon']['price']*$detail['item']; ?> )
                                                                <br>
                                                                @if (!$loop->last)
                                                                <hr>
                                                                @endif
                                                                @endforeach
                                                            @endif
                                                        </td>
                                                        <td>        
                                                            £{{ $item->order_amount }}
                                                        </td>
                                                        
                                                        
                                                        <td>
                                                            Status: Done<br>
                                                            Payment Method: {{ $item->payment_method }}<br>
                                                            Tr ID: {{ $item->payment_method_id }}
                                                        </td>
                                                        <td>
                                                            {{ $item->created_at }}
                                                        </td>


                                                        <td>
                                                            {{-- <div class="main-toggle-group-demo">
                                                                <a href="{{ url('admin/order_status/' . $item->id) }}"
                                                                    onclick="return confirm('Are you want to {{ $item->status == 1 ? 'Disable' : 'Enable' }}?')">
                                                                    <div
                                                                        class="main-toggle main-toggle-success {{ $item->status == 1 ? 'on' : 'off' }}">
                                                                        <span></span>
                                                                    </div>
                                                                </a>
                                                            </div> --}}

                                                            {{-- <a href="{{ route('order.edit', $item->id) }}"
                                                                class="btn ripple btn-info btn-xs w-100">Edit
                                                            </a>
                                                            <br> --}}

                                                            {{-- <a href="{{ route('order.show', $item->id) }}"
                                                                class="btn ripple btn-primary btn-xs w-100">View History
                                                            </a>
                                                            <br> --}}

                                                            <a href="javasctipt:void(0)"
                                                                class="btn ripple btn-danger btn-xs w-100"
                                                                onclick="event.preventDefault(); if (confirm('Are you sure you want to delete?')) { document.getElementById('delete-item-form{{ $item->id }}').submit(); }">
                                                                Delete
                                                            </a>
                                                            <form id="delete-item-form{{ $item->id }}"
                                                                action="{{ route('order.destroy', $item->id) }}"
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
                                    {!! $orders->onEachSide(5)->appends(request()->input())->links('pagination::bootstrap-4') !!}
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


    @include('admin.order.include.ajaxCode')
@endsection
