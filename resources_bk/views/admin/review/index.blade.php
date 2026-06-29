@extends('admin.layout.app')
@section('content')
    <!-- Main Content-->
    <div class="main-content side-content pt-0">

        <div class="main-container container-fluid">
            <div class="inner-body">

                <!-- Page Header -->
                <div class="page-header">
                    <div>
                        <h2 class="main-content-title tx-24 mg-b-5">Review List ({{ @$reviewsCount }})</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Review </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Review List </li>
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
                            <a href="{{ route('reviews.create') }}" type="button"
                                class="btn btn-primary my-2 btn-icon-text">
                                <i class="fe fe-plus me-2"></i> Add Review</a>
                        </div>
                    </div>
                </div>
                <!-- End Page Header -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card custom-card">
                            <div class="card-body py-3">
                                <form action="{{ route('reviews.index') }}" method="get">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <input type="text" name="search_text" value="{{ $request->search_text }}" class="form-control form-control" placeholder="Search..."
                                            aria-controls="example1">
                                    </div>
                                    <!--<div class="col-sm-3">-->
                                    <!--    <select class="form-control select2" name="brand">-->
                                    <!--        <option value="">Brand </option>-->
                                    <!--        @foreach ($brands as $item)-->
                                    <!--            <option value="{{ $item->id }}" {{ $request->brand == $item->id ? 'selected' : '' }}>-->
                                    <!--                {{ $item->name }}</option>-->
                                    <!--        @endforeach-->
                                    <!--    </select>-->
                                    <!--</div>-->
                                    
                                    
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
                                    <table class="table table-striped table-bordered  mb-0">
                                        <thead>
                                            <tr>

                                                <th><b>ID</b></th>
                                                <th width="25%"><b>Review details</b></th>
                                                <th><b>Review</b></th>
                                                <th width="15%"><b>Actions</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($reviews as $item)
                                                <tr>
                                                    <td>
                                                        REV-{{ $item->id }}
                                                    </td>
                                                   
                                                    <td>
                                                        <p class="mb-0">
                                                           <b>Full Name: </b>{{ $item->full_name }}<br>
                                                           <b>Rating: </b>{{ $item->rating }}<br>
                                                           <b>Title: </b>{{ $item->title }}<br>
                                                           
                                                        </p>
                                                    </td>
                                                    
                                                    <td>
                                                        <p class="mb-0">
                                                           {{ $item->description }}
                                                           
                                                        </p>
                                                    </td>

                                                    <td>
                                                        
                                                        <a href="{{ route('reviews.edit', $item->id) }}" class="btn ripple btn-info btn-xs w-100">Edit</a>
                                                        <br>
                                                        <a href="#" class="btn ripple btn-danger btn-xs w-100 mt-1"
                                                            onclick="event.preventDefault(); if (confirm('Are you sure you want to delete?')) { document.getElementById('delete-item-form{{ $item->id }}').submit(); }">
                                                            Delete
                                                        </a>
                                                        <form id="delete-item-form{{ $item->id }}"
                                                            action="{{ route('reviews.destroy', $item->id) }}"
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
                                    {!! $reviews->onEachSide(5)->appends(request()->input())->links('pagination::bootstrap-4') !!}
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
