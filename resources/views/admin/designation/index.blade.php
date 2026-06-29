@extends('admin.layout.app')
@section('content')
    <!-- Main Content-->
    <div class="main-content side-content pt-0">

        <div class="main-container container-fluid">
            <div class="inner-body">

                <!-- Page Header -->
                <div class="page-header">
                    <div>
                        <h2 class="main-content-title tx-24 mg-b-5">Areas List</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Areas </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Areas List </li>
                        </ol>
                    </div>
                    <div class="d-flex">
                        <div class="justify-content-center">
                            {{-- <button type="button" class="btn btn-white btn-icon-text my-2 me-2">
                                <i class="fe fe-download me-2"></i> Import
                            </button> --}}

                            {{-- <button type="button" class="btn btn-primary my-2 btn-icon-text  me-2">
                                <i class="fe fe-download-cloud me-2"></i> Download Report
                            </button> --}}
                            <a href="javascript:void(0)" class="btn btn-primary my-2 btn-icon-text"
                                onclick="EditMaster(null)"> <i class="fe fe-plus me-2"></i> Add
                                Area</a>
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
                                    <table class="table table-striped table-bordered text-nowrap mb-0">
                                        <thead>
                                            <tr>

                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($designations as $item)
                                                <tr>
                                                    <td>
                                                        AREA-{{ $item->id }}
                                                    </td>

                                                    <td>
                                                        {{ $item->name }}
                                                    </td>


                                                    <td style="width:8%">

                                                        {{-- <a href="{{ url('admin/master_status/' . $item->id) }}"
                                                            onclick="return confirm('Are you want to {{ $item->status == 1 ? 'Disable' : 'Enable' }}?')"
                                                            class="btn ripple btn-{{ $item->status == 1 ? 'info' : 'secondary' }} btn-xs w-100">{{ $item->status == 1 ? 'Enable' : 'Desable' }}</a>
                                                        <br> --}}
                                                        <a href="javasctipt:void(0)"
                                                            onclick="EditMaster({{ $item }})"
                                                            class="btn
                                                            ripple btn-info btn-xs w-100">Edit</a>
                                                        <br>

                                                        <a href="#" class="btn ripple btn-danger btn-xs w-100"
                                                            onclick="event.preventDefault(); if (confirm('Are you sure you want to delete it?')) { document.getElementById('delete-item-form{{ $item->id }}').submit(); }">
                                                            Delete
                                                        </a>
                                                        <form id="delete-item-form{{ $item->id }}"
                                                            action="{{ route('areas.destroy', $item->id) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>

                                                    </td>
                                                </tr>
                                            @endforeach
                                            @if (empty($designations))
                                                <tr>
                                                    <td class="text-center" colspan="3">No Data Found.</td>
                                                </tr>
                                            @endif

                                        </tbody>
                                    </table>
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
                       Areas Modal Modal 
========================================================================== --}}

    <!-- Large Modal -->
    <div class="modal" id="exampleModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title" id="doc_modal_title">Area</h6><button aria-label="Close"
                        class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('areas.store') }}" method="POST" id="MasterForm" class="checkout-tab"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <h6>Add Area</h6>
                            </div>
                            <!--end col-->
                            <div class="col-lg-12">
                                <div>
                                    <input type="hidden" name="DesignationID" class="form-control" id="DesignationID">
                                    <label for="firstName" class="form-label">Area Name</label>
                                    <input type="text" name="name" class="form-control" id="MasterHead" required>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="d-flex align-items-start gap-3 mt-3">
                                    <button type="submit" class="btn btn-primary  ms-auto"
                                        data-nexttab="pills-bill-address-tab"> Save</button>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--End Large Modal -->
    <!--end modal-->
    <!--End Large Modal -->
    {{-- =======================================================================
                   end of  get document Modal 
========================================================================== --}}

    <script>
        function EditMaster(data) {
            $('#MasterForm')[0].reset()
            if (data !== null) {
                $('#DesignationID').val(data.id);
                $('#MasterHead').val(data.name);
            }
            $('#exampleModal').modal('show');
        }
    </script>
@endsection
