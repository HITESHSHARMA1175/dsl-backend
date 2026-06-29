@extends('admin.layout.app')
@section('content')
    <!-- Main Content-->
    <div class="main-content side-content pt-0">

        <div class="main-container container-fluid">
            <div class="inner-body">

                <!-- Page Header -->
                <div class="page-header">
                    <div>
                        <h2 class="main-content-title tx-24 mg-b-5">Customer EMI List</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">HRMS </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Customer EMI List </li>
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
                                    class="fe fe-plus me-2"></i> Add Customer EMI</a> --}}
                        </div>
                    </div>
                </div>
                <!-- End Page Header -->

                
                <!-- Row -->
                <div class="row row-sm">
                    <div class="col-lg-12">
                        <div class="card custom-card">
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered  mb-0">
                                        <thead>
                                            <tr>
                                                
                                                <!--<th><b>ID</b></th>-->
                                                
                                                <th><b>EMI</b></th>
                                                <th><b>EMI Date</b></th>
                                                <th><b>EMI Amount</b></th>
                                                <th><b>EMI Status</b></th>
                                                
                                                <!--<th><b>Actions</b></th>-->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($customer_emis as $key=>$item)
                                                <tr>
                                                   
                                                    <!--<td>
                                                        EMI-{{ $item->id }}<br>
                                                    </td>-->
                                                    <td>
                                                        Installment #{{$key+1}}
                                                    </td>
                                                    <td>
                                                        <p class="mb-0">
                                                            <b>{{ $item->emi_start_date }}</b>
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0">
                                                            <b>₹{{ $item->emi_amount }}</b> 
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0">
                                                            <b>{{ $item->payment_status }}</b> 
                                                        </p>
                                                    </td>
                                                    
                                                   
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end mt-2">
                                
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
