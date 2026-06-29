@extends('admin.layout.app')
@section('content')
    @php
        use App\Models\InventoryCategory;
    @endphp
    <!-- Main Content-->
    <div class="main-content side-content pt-0">

        <div class="main-container container-fluid">
            <div class="inner-body">

                <!-- Page Header -->
                <div class="page-header">
                    <div>
                        <h2 class="main-content-title tx-24 mg-b-5">Inventory Catgory</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Inventory Catgory</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Inventory Catgory List </li>
                        </ol>
                    </div>
                    <div class="d-flex">
                        <div class="justify-content-center">

                            <a href="javascript:void(0)" class="btn btn-primary my-2 btn-icon-text" onclick="clearmodal()"
                                data-bs-toggle="modal" data-bs-target="#exampleModal"> <i class="fe fe-plus me-2"></i> Add
                                Category</a>
                        </div>
                    </div>
                </div>
                <!-- End Page Header -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card custom-card">
                            <div class="card-body py-3">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input type="search" class="form-control form-control" placeholder="Search..."
                                            aria-controls="example1">
                                    </div>
                                    <div class="col-sm-2">
                                        <select class="form-control select2">
                                            <option label="Choose one">Gender</option>
                                            <option value="Firefox">Male</option>
                                            <option value="Chrome">Female</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <select class="form-control select2">
                                            <option label="Choose one">Status</option>
                                            <option value="Firefox">Active</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <select class="form-control select2">
                                            <option label="Choose one">Department</option>
                                            <option value="Firefox"></option>
                                        </select>
                                    </div>
                                </div>
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

                                                <th>##</th>
                                                <th> Category Name</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($categories as $key => $item)
                                                @php
                                                    $totalSubMenus = InventoryCategory::where('parent_id', $item->id)->get();
                                                @endphp
                                                <tr>
                                                    <td>
                                                        {{ $key + 1 }}
                                                    </td>

                                                    <td class="fw-medium">
                                                        {{ @$item->category_name }}
                                                        @if (count($totalSubMenus) != 0)
                                                            <p> <a href="{{ route('inventorycategory', $item->id) }}"
                                                                    class="text-info"> Sub
                                                                    Category
                                                                    ({{ count($totalSubMenus) }})
                                                                </a>
                                                            </p>
                                                        @endif

                                                    </td>
                                                    <td style="width:8%">

                                                        {{-- <a href="{{ url('admin/master_values_status/' . $item->id) }}"
                                                            onclick="return confirm('Are you want to {{ $item->status == 1 ? 'Disable' : 'Enable' }}?')"
                                                            class="btn ripple btn-{{ $item->status == 1 ? 'info' : 'secondary' }} btn-xs w-100">{{ $item->status == 1 ? 'Enable' : 'Desable' }}</a>
                                                        <br> --}}
                                                        <a href="javasctipt:void(0)"
                                                            onclick="editmapcategory({{ $item->id }})"
                                                            class="btn
                                                            ripple btn-info btn-xs w-100"
                                                            data-bs-toggle="modal" data-bs-target="#exampleModal">Edit</a>
                                                        <br>

                                                        <a href="{{ route('deleteInventoryCategory', $item->id) }}"
                                                            class="btn ripple btn-danger btn-xs w-100"
                                                            onclick="(confirm('Are you sure you want to delete?'))">
                                                            Delete
                                                        </a>
                                                        {{-- <form id="delete-item-form"
                                                            action="{{ route('deleteInventoryCategory', $item->id) }}"
                                                            method="get" style="display: none;">
                                                            @csrf
                                                            
                                                        </form> --}}

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
                    <h6 class="modal-title" id="doc_modal_title">Map Category</h6><button aria-label="Close"
                        class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('saveInventoryCategory') }}" method="POST" id="MasterForm" class="checkout-tab"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <h6> Category</h6>
                            </div>
                            <div class="col-lg-4">
                                <div>
                                    <input type="hidden" class="form-control" id="Category_id" name="Category_id"
                                        value="">
                                    <label for="firstName" class="form-label">Parent Category</label>
                                    <select class="form-control" id="parent_category" name="parent_category"
                                        aria-label="Default select example" required>
                                        <option value="">---select---</option>
                                        <option value="0">Parent</option>
                                        @foreach ($drop_categories as $row)
                                            <option value="{{ $row->id }}">{{ $row->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-lg-8">
                                <div>
                                    <label for="firstName" class="form-label">Category Name</label>
                                    <input type="text" name="category_name" id="category_name" class="form-control">

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
        function editmapcategory(id) {

            jQuery.ajax({
                type: 'GET',
                url: "{{ url('admin/editInventoryCategory') }}?id=" + id,
                dataType: 'html',
                success: function(data) {
                    var x = JSON.parse(data);
                    $('#Category_id').val(x.id);
                    $('#parent_category').val(x.parent_id);
                    $('#category_name').val(x.category_name);
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
