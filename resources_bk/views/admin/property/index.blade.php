@extends('admin.layout.app')
@section('content')
    <!-- Main Content-->
    <div class="main-content side-content pt-0">

        <div class="main-container container-fluid">
            <div class="inner-body">

                <!-- Page Header -->
                <div class="page-header">
                    <div>
                        <h2 class="main-content-title tx-24 mg-b-5">Service List ({{ @$propertyCount }})</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Service </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Service List </li>
                        </ol>
                    </div>
                    <div class="d-flex">
                        <div class="justify-content-center">
                            {{-- <button type="button" class="btn btn-white btn-icon-text my-2 me-2" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                <i class="fe fe-download me-2"></i> Import
                            </button> --}}

                            <a href="{{ route('property.create') }}" type="button"
                                class="btn btn-primary my-2 btn-icon-text"> <i class="fe fe-plus me-2"></i> Add Service</a>
                        </div>
                    </div>
                </div>
                <!-- End Page Header -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card custom-card">
                            <div class="card-body py-3">
                                <form action="{{ route('property.index') }}" method="get">
                                    <!--@csrf-->
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control form-control" placeholder="Search..."
                                                aria-controls="example1" name="searchtext"
                                                value="{{ $request->searchtext }}">
                                        </div>

                                        <!--<div class="col-sm-3 ">
                                            <select class="form-control select2" name="parent_id">
                                                <option value="">All Service</option>
                                                @foreach ($services as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $request->parent_id == $item->id ? 'selected' : '' }}>
                                                        {{ $item->property_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>-->

                                        <div class="col-sm-3 ">
                                            <select class="form-control select2" name="category" id="category"
                                                onchange="getPropertySubCatByCat(this.value, '')">
                                                <option value="">Service category</option>
                                                @foreach ($categories as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $request->category == $item->id ? 'selected' : '' }}>
                                                        {{ $item->category_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-3 ">
                                            <select class="form-control select2" name="sub_category" id="sub_category">
                                                <option value="">Service sub category</option>
                                                @foreach ($subcategories as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $request->sub_category == $item->id ? 'selected' : '' }}>
                                                        {{ $item->category_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-2 my-2">
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
                                    <table class="table table-striped table-bordered  mb-0">
                                        <thead>
                                            <tr>
                                                {{-- <th><label class="ckbox"><input type="checkbox"
                                                            value="5"><span></span></label></th> --}}
                                                <th>ID</th>
                                                <th>Image</th>
                                                <th>Parent service</th>
                                                <th>Title</th>
                                                <th>Price</th>
                                                <th>Discount</th>
                                                <th>Offer Status</th>

                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($properties) > 0)
                                                @foreach ($properties as $item)
                                                    <tr>

                                                        <td>
                                                            {{ $item->id }}
                                                        </td>
                                                        <td><img alt="avatar" class="rounded me-3"
                                                                src="{{ !empty($item->profile) ? asset('uploads/property/' . $item->profile) : asset('frontend/images/simg.jpg') }}"
                                                                style="width:60px"></td>
                                                        <td>
                                                            @if ($item->property_category > 0)
                                                                {{ @$item->getPropertyCategory->category_name }}
                                                            @else
                                                                NA
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{ @$item->property_name }}
                                                        </td>
                                                        <td>
                                                            {{ @$item->price }}
                                                        </td>
                                                        <td>
                                                            {{ @$item->discounted_price }}
                                                        </td>
                                                        <td>
                                                            <div class="main-toggle-group-demo">
                                                                <a href="{{ url('admin/property_offer_status/' . $item->id) }}"
                                                                    onclick="return confirm('Are you want to {{ $item->offer_status == 1 ? 'Disable' : 'Enable' }}?')">
                                                                    <div
                                                                        class="main-toggle main-toggle-success {{ $item->offer_status == 1 ? 'on' : 'off' }}">
                                                                        <span></span>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                            <!--@if ($item->status == '1')
                                                                <span class="text-success">Active</span>
                                                            @else
                                                                <span class="text-danger">In-Active</span>
                                                            @endif-->
                                                        </td>


                                                        <td>
                                                            <div class="main-toggle-group-demo">
                                                                <a href="{{ url('admin/property_status/' . $item->id) }}"
                                                                    onclick="return confirm('Are you want to {{ $item->status == 1 ? 'Disable' : 'Enable' }}?')">
                                                                    <div
                                                                        class="main-toggle main-toggle-success {{ $item->status == 1 ? 'on' : 'off' }}">
                                                                        <span></span>
                                                                    </div>
                                                                </a>
                                                            </div>

                                                            <a href="{{ route('property.edit', $item->id) }}"
                                                                class="btn ripple btn-info btn-xs w-100 mt-1 mb-1">Edit
                                                            </a>
                                                            <br>

                                                            {{-- <a href="{{ route('property.show', $item->id) }}"
                                                                class="btn ripple btn-primary btn-xs w-100">View History
                                                            </a>
                                                            <br> --}}

                                                            <a href="javasctipt:void(0)"
                                                                class="btn ripple btn-danger btn-xs w-100"
                                                                onclick="event.preventDefault(); if (confirm('Are you sure you want to delete?')) { document.getElementById('delete-item-form{{ $item->id }}').submit(); }">
                                                                Delete
                                                            </a>
                                                            <form id="delete-item-form{{ $item->id }}"
                                                                action="{{ route('property.destroy', $item->id) }}"
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
                                    {!! $properties->onEachSide(5)->appends(request()->input())->links('pagination::bootstrap-4') !!}
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

    <div class="modal" id="exampleModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title" id="doc_modal_title">Import Service</h6><button aria-label="Close"
                        class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('propertyImportdata') }}" method="POST" id="MasterForm" class="checkout-tab"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-lg-4">
                                <div>
                                    <label for="MasterValueIcon" class="form-label">Upload CSV</label>
                                    <input type="file" class="form-control" name="file" id="file"
                                        accept="csv/*">
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

                            <img src="https://newadmin.webkype.com/assets/img/pngs/default-img.gif" id="img_file_link"
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

    <script>
        $(document).ready(function() {

            $("#project").select2({
                placeholder: "Project",
            });

            $("#state").select2({
                placeholder: "State",
            });

            $("#city").select2({
                placeholder: "City",
            });

        });

        function getPriceProId(property_id) {
            $('#price_pro_id').val(property_id);
        }
    </script>

    <script>
        function getPropertySubCatByCat(category_id, checkedSubCategory) {
            var CategoryId = '';
            if (category_id != undefined && category_id != '') {
                CategoryId = category_id;
            } else {
                CategoryId = $('#category').val();
            }
            $('#sub_category').empty();
            return $.ajax({
                url: "{{ route('getPropertySubCatByCat') }}",
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    category_id: CategoryId,
                    checkedSubCategory: checkedSubCategory
                },
                beforeSend: function(res) {
                    $('#sub_category').html('<option  value="">Loading...</option>');
                },
                success: function(res) {
                    $('#sub_category').html(res.data);
                },
                error: function(res) {
                    $('#sub_category').html('<option value="">Select</option>');
                }
            })
        }


        function getUserDocumentDetail(user_id, doc_type) {
            return $.ajax({
                url: "{{ route('getUserDocumentDetail') }}",
                type: 'get',
                data: {
                    // "_token": "{{ csrf_token() }}",
                    user_id: user_id,
                    doc_type: doc_type,
                },
                success: function(res) {
                    console.log(res)
                    $('#doc_modal_title').text(res.title);
                    $('#card_number').text(res.card_number);
                    $('#img_file_link').attr('src', res.file_link);
                }
            })
        }

        function getProRoomId(property_id, room_id) {
            $('#inv_property_id').val(property_id);
            $('#inv_room_id').val(room_id);
        }
    </script>


    @include('admin.property.include.ajaxCode')
@endsection
