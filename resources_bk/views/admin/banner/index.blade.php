@extends('admin.layout.app')
@section('content')
    <!-- Main Content-->
    <div class="main-content side-content pt-0">

        <div class="main-container container-fluid">
            <div class="inner-body">

                <!-- Page Header -->
                <div class="page-header">
                    <div>
                        <h2 class="main-content-title tx-24 mg-b-5">Banner List ({{ @$bannersCount }})</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Banner </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Banner List </li>
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
                            <a href="{{ route('banner.create') }}" type="button"
                                class="btn btn-primary my-2 btn-icon-text">
                                <i class="fe fe-plus me-2"></i> Add Banner</a>
                        </div>
                    </div>
                </div>
                <!-- End Page Header -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card custom-card">
                            <div class="card-body py-3">
                                <form action="{{ route('banner.index') }}" method="get">
                                    <!--@csrf-->
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control form-control" placeholder="Search..."
                                                aria-controls="example1" name="searchtext"
                                                value="{{ $request->searchtext }}">
                                        </div>

                                        <div class="col-sm-3 ">
                                            <select class="form-control select2" name="banner_type" id="banner_type">
                                                <option value="">Banner Type</option>
                                                <option value="Home Top Banner" {{ $request->banner_type == 'Home Top Banner' ? 'selected' : '' }}>Home Top Banner</option>
                                                <option value="Category Details Top Banner" {{ $request->banner_type == 'Category Details Top Banner' ? 'selected' : '' }}>Category Details Top Banner</option>
                                                <option value="Conatct Top Banner" {{ $request->banner_type == 'Conatct Top Banner' ? 'selected' : '' }}>Conatct Top Banner</option>
                                                <option value="About Top Banner" {{ $request->banner_type == 'About Top Banner' ? 'selected' : '' }}>About Top Banner</option>
                                                <option value="Refund Policy Top Banner" {{ $request->banner_type == 'Refund Policy Top Banner' ? 'selected' : '' }}>Refund Policy Top Banner</option>
                                                <option value="Term & Condition Top Banner" {{ $request->banner_type == 'Term & Condition Top Banner' ? 'selected' : '' }}>Term & Condition Top Banner</option>
                                                <option value="Privacy Policy Top Banner" {{ $request->banner_type == 'Privacy Policy Top Banner' ? 'selected' : '' }}>Privacy Policy Top Banner</option>
                                                <option value="Shop Top Banner" {{ $request->banner_type == 'Shop Top Banner' ? 'selected' : '' }}>Shop Top Banner</option>
                                                <option value="Category Top Banner" {{ $request->banner_type == 'Category Top Banner' ? 'selected' : '' }}>Category Top Banner</option>
                                                
                                            </select>
                                        </div>
                                        
                                        <div class="col-sm-2">
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

                                                <th>ID</th>
                                                <th>Banner Type</th>
                                                <th>Banner Name</th>
                                                <th>Banner Image</th>
                                                <th width="10%">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($banners as $item)
                                                <tr>
                                                    <td>
                                                        BAN-{{ $item->id }}
                                                    </td>
                                                    
                                                    <td>
                                                        <p class="mb-0">
                                                            {{ $item->banner_type }}
                                                        </p>
                                                    </td>

                                                    <td>
                                                        <p class="mb-0">
                                                           {{ $item->banner_name }}
                                                        </p>
                                                    </td>

                                                    <td>
                                                        @if(!empty($item->profile))
                                                        <img alt="avatar" class="rounded me-3"
                                                            src="{{ !empty($item->profile) ? asset('uploads/banner/' . $item->profile) : asset('uploads/userimage/no-banner.jpg') }}"
                                                            style="width:60px">
                                                        @else
                                                        NA
                                                        @endif
                                                    </td>

                                                    <td>
                                                        <div class="main-toggle-group-demo">

                                                            <a href="{{ url('admin/banner_status/' . $item->id) }}"
                                                                onclick="return confirm('Are you want to {{ $item->status == 1 ? 'Disable' : 'Enable' }}?')">
                                                                <div
                                                                    class="main-toggle main-toggle-success {{ $item->status == 1 ? 'on' : 'off' }}">
                                                                    <span></span>
                                                                </div>
                                                            </a>


                                                        </div>

                                                        <a href="{{ route('banner.edit', $item->id) }}"
                                                            class="btn ripple btn-info btn-xs w-100">Edit</a>
                                                        <br>
                                                        @if($item->banner_type != 'Home Section')   
                                                        <a href="#" class="btn ripple btn-danger btn-xs w-100"
                                                            onclick="event.preventDefault(); if (confirm('Are you sure you want to delete?')) { document.getElementById('delete-item-form{{ $item->id }}').submit(); }">
                                                            Delete
                                                        </a>
                                                        <form id="delete-item-form{{ $item->id }}"
                                                            action="{{ route('banner.destroy', $item->id) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                        @endif
                                                    </td>

                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-end mt-2">
                                    {!! $banners->onEachSide(5)->appends(request()->input())->links('pagination::bootstrap-4') !!}
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
