@extends('admin.layout.app')
@section('content')
    <!-- Main Content-->
    <div class="main-content side-content pt-0">

        <div class="main-container container-fluid">
            <div class="inner-body">

                <!-- Page Header -->
                <div class="page-header">
                    <div>
                        <h2 class="main-content-title tx-24 mg-b-5">Seo List ({{ @$seosCount }})</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Seo </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Seo List </li>
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
                            </button>
                            <a href="{{ route('seo.create') }}" type="button"
                                class="btn btn-primary my-2 btn-icon-text">
                                <i class="fe fe-plus me-2"></i> Add Seo</a>  --}}
                        </div>
                    </div>
                </div>
                <!-- End Page Header -->

                <!--<div class="row">
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
                </div>-->
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
                                                <th>Page URL</th>
                                                <th>Page Name</th>
                                                <th>Updated Date</th>
                                                <th width="10%">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($seos as $item)
                                                <tr>
                                                    <td>
                                                        SEO-{{ $item->id }}
                                                    </td>
                                                    
                                                    <td>
                                                        <p class="mb-0">
                                                            <a href="{{ $item->pageurl }}" ?>{{ $item->pageurl }}</a>
                                                        </p>
                                                    </td>
                                                    
                                                    <td>
                                                        <p class="mb-0">
                                                            {{ $item->title }}
                                                        </p>
                                                    </td>
                                                    
                                                   
                                                    <td>
                                                        <p class="mb-0">
                                                           {{ $item->updated_at }}
                                                        </p>
                                                    </td>

                                                    <td>
                                                        <!--<div class="main-toggle-group-demo">

                                                            <a href="{{ url('admin/seo_status/' . $item->id) }}"
                                                                onclick="return confirm('Are you want to {{ $item->status == 1 ? 'Disable' : 'Enable' }}?')">
                                                                <div
                                                                    class="main-toggle main-toggle-success {{ $item->status == 1 ? 'on' : 'off' }}">
                                                                    <span></span>
                                                                </div>
                                                            </a>


                                                        </div>-->

                                                        <a href="{{ route('seo.edit', $item->id) }}" class="btn ripple btn-info btn-xs w-100">Edit</a><br>
                                                            
                                                        <!--<a href="javasctipt:void(0)"
                                                            class="btn ripple btn-danger btn-xs w-100"
                                                            onclick="event.preventDefault(); if (confirm('Are you sure you want to delete?')) { document.getElementById('delete-item-form{{ $item->id }}').submit(); }">
                                                            Delete
                                                        </a>
                                                        <form id="delete-item-form{{ $item->id }}"
                                                            action="{{ route('seo.destroy', $item->id) }}"
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
                                    {!! $seos->onEachSide(5)->appends(request()->input())->links('pagination::bootstrap-4') !!}
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
