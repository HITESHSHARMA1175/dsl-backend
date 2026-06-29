@extends('admin.layout.app')
@section('content')
    <!-- Main Content-->
    <div class="main-content side-content pt-0">

        <div class="main-container container-fluid">
            <div class="inner-body">

                <!-- Page Header -->
                <div class="page-header">
                    <div>
                        <h2 class="main-content-title tx-24 mg-b-5">Master Value</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Master Value</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Master Value List </li>
                        </ol>
                    </div>
                    <div class="d-flex">
                        <div class="justify-content-center">

                            <a href="javascript:void(0)" class="btn btn-primary my-2 btn-icon-text" onclick="clearmodal()"
                                data-bs-toggle="modal" data-bs-target="#exampleModal"> <i class="fe fe-plus me-2"></i> Add
                                Master</a>
                        </div>
                    </div>
                </div>
                <!-- End Page Header -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card custom-card">
                            <div class="card-body py-3">
                                <form action="{{ route('mastervalues.index') }}" method="get">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <input type="text" name="search_text" value="{{ $request->search_text }}" class="form-control form-control" placeholder="Search..."
                                            aria-controls="example1">
                                    </div>
                                    <div class="col-sm-3">
                                        <select class="form-control select2" name="master">
                                            <option value="">Master</option>
                                            @foreach ($master as $item)
                                                <option value="{{ $item->id }}" {{ $request->master == $item->id ? 'selected' : '' }}>
                                                    {{ $item->MasterHead }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    
                                    <div class="col-sm-2">
                                        <button type="submit"
                                        class="btn btn-primary  btn-icon-text"> <i class="fe fe-plus me-2"></i> Search</button>
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

                                                <th>ID</th>
                                                <th>Photo</th>
                                                <th>Master Head</th>
                                                <th>Master Value</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($master_values as $item)
                                                <tr>
                                                    <td>
                                                        MV-{{ $item->id }}
                                                    </td>
                                                    <td>
                                                        <img alt="avatar" class=" me-3"
                                                            src="{{ !empty($item->MasterIcon) ? asset('uploads/master/' . $item->MasterIcon) : asset('uploads/no-image.png') }}"
                                                            style="width:60px">
                                                    </td>
                                                    <td class="fw-medium">
                                                        {{ @$item->master->MasterHead }}</td>
                                                    <td>
                                                        {{ $item->MasterValue }}
                                                    </td>


                                                    <td style="width:8%">

                                                        <a href="{{ url('admin/master_values_status/' . $item->id) }}"
                                                            onclick="return confirm('Are you want to {{ $item->status == 1 ? 'Disable' : 'Enable' }}?')"
                                                            class="btn ripple btn-{{ $item->status == 1 ? 'info' : 'secondary' }} btn-xs w-100">{{ $item->status == 1 ? 'Enable' : 'Desable' }}</a>
                                                        <br>
                                                        <a href="javasctipt:void(0)"
                                                            onclick="editmastervalue({{ $item->id }})"
                                                            class="btn
                                                            ripple btn-info btn-xs w-100"
                                                            data-bs-toggle="modal" data-bs-target="#exampleModal">Edit
                                                            Master</a>
                                                        <br>

                                                        <a href="javasctipt:void(0)"
                                                            class="btn ripple btn-danger btn-xs w-100"
                                                            onclick="event.preventDefault(); if (confirm('Are you sure you want to delete?')) { document.getElementById('delete-item-form{{ $item->id }}').submit(); }">
                                                            Delete
                                                        </a>
                                                        <form id="delete-item-form{{ $item->id }}"
                                                            action="{{ route('mastervalues.destroy', $item->id) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>

                                                    </td>
                                                </tr>
                                            @endforeach

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
                       MAster Modal Modal 
========================================================================== --}}

    <!-- Large Modal -->
    <div class="modal" id="exampleModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title" id="doc_modal_title">Master Value</h6><button aria-label="Close"
                        class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('mastervalues.store') }}" method="POST" id="MasterForm" class="checkout-tab"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <h6>Add Master Value</h6>
                            </div>
                            <div class="col-lg-4">
                                <div>
                                    <input type="hidden" class="form-control" id="MasterValueid" name="MasterValueid"
                                        value="">
                                    <label for="firstName" class="form-label">Master Head</label>
                                    <select class="form-control" id="MasterHead" name="MasterHead"
                                        aria-label="Default select example" required>
                                        <option value="">---select---</option>
                                        @foreach ($master as $row)
                                            <option value="{{ $row->id }}">{{ $row->MasterHead }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-lg-4">
                                <div>
                                    <label for="firstName" class="form-label">Master Values</label>
                                    <input type="text" name="MasterValue" class="form-control" id="MasterValue"
                                        required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div>
                                    <label for="MasterValueIcon" class="form-label">Master Icon</label>
                                    <input type="file" class="form-control" name="MasterValueIcon"
                                        id="MasterValueIcon" accept="image/*">
                                </div>
                            </div>
                            <!--end col-->
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
        function editmastervalue(id) {

            jQuery.ajax({
                type: 'GET',
                url: "{{ url('admin/editmastervalue') }}?id=" + id,
                dataType: 'html',
                success: function(data) {
                    var x = JSON.parse(data);
                    $('#MasterValueid').val(x.id);
                    $('#MasterHead').val(x.MasterHead);
                    $('#MasterValue').val(x.MasterValue);
                }
            }); //ajax close

        }

        function clearmodal() {
            $('#MasterValueid').val('');
            $('#MasterHead').val('');
            $('#MasterValue').val('');

        }
    </script>
@endsection
