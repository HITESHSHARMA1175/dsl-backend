@extends('admin.layout.app')
@section('content')
    <!-- Main Content-->
    <div class="main-content side-content pt-0">

        <div class="main-container container-fluid">
            <div class="inner-body">

                <!-- Page Header -->
                <div class="page-header">
                    <div>
                        <h2 class="main-content-title tx-24 mg-b-5">Model List ({{ @$modelsCount }})</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Model </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Model List </li>
                        </ol>
                    </div>
                    <div class="d-flex">
                        <div class="justify-content-center">
                            {{-- <button type="button" class="btn btn-white btn-icon-text my-2 me-2" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                <i class="fe fe-download me-2"></i> Import
                            </button> --}}


                            {{-- <button type="button" class="btn btn-primary my-2 btn-icon-text  me-2">
                                <i class="fe fe-download-cloud me-2"></i> Download Report
                            </button> --}}
                            <a href="{{ route('models.create') }}" type="button"
                                class="btn btn-primary my-2 btn-icon-text">
                                <i class="fe fe-plus me-2"></i> Add Model</a>
                        </div>
                    </div>
                </div>
                <!-- End Page Header -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card custom-card">
                            <div class="card-body py-3">
                                <form action="{{ route('models.index') }}" method="get">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <input type="text" name="search_text" value="{{ $request->search_text }}" class="form-control form-control" placeholder="Search..."
                                            aria-controls="example1">
                                    </div>
                                    <div class="col-sm-3">
                                        <select class="form-control select2" name="brand">
                                            <option value="">Brand </option>
                                            @foreach ($brands as $item)
                                                <option value="{{ $item->id }}" {{ $request->brand == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}</option>
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

                                                <th><b>ID</b></th>
                                                <th><b>Brand Photo</b></th>
                                                <th><b>Brand Name</b></th>
                                                <th><b>Model Name</b></th>
                                                <th width="15%"><b>Actions</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($models as $item)
                                                <tr>
                                                    <td>
                                                        MODEL-{{ $item->id }}
                                                    </td>
                                                    <td>
                                                        @if(!empty(@$item->getModelBrand->profile))
                                                        <img alt="avatar" class="rounded me-3"
                                                            src="{{ !empty($item->getModelBrand->profile) ? asset('uploads/mobile/' . $item->getModelBrand->profile) : asset('uploads/userimage/no-banner.jpg') }}"
                                                            style="width:60px">
                                                        @else
                                                        NA
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <p class="mb-0">
                                                           <b>{{ @$item->getModelBrand->name }}</b>
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0">
                                                           <b>{{ $item->name }}</b>
                                                        </p>
                                                    </td>

                                                    <td>
                                                        
                                                        <a href="{{ route('models.edit', $item->id) }}" class="btn ripple btn-info btn-xs w-100">Edit</a>
                                                        <br>
                                                        <a href="#" class="btn ripple btn-danger btn-xs w-100 mt-1"
                                                            onclick="event.preventDefault(); if (confirm('Are you sure you want to delete?')) { document.getElementById('delete-item-form{{ $item->id }}').submit(); }">
                                                            Delete
                                                        </a>
                                                        <form id="delete-item-form{{ $item->id }}"
                                                            action="{{ route('models.destroy', $item->id) }}"
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

                                <div class="d-flex justify-content-end mt-2">
                                    {!! $models->onEachSide(5)->appends(request()->input())->links('pagination::bootstrap-4') !!}
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

 
    <script>
        
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
    </script>
@endsection
