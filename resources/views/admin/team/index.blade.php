@extends('admin.layout.app')
@section('content')
    <!-- Main Content-->
    <div class="main-content side-content pt-0">

        <div class="main-container container-fluid">
            <div class="inner-body">

                <!-- Page Header -->
                <div class="page-header">
                    <div>
                        <h2 class="main-content-title tx-24 mg-b-5">Team List ({{ @$teamCount }})</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Team </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Team List </li>
                        </ol>
                    </div>
                    <div class="d-flex">
                        <div class="justify-content-center">
                            {{-- <button type="button" class="btn btn-white btn-icon-text my-2 me-2" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                <i class="fe fe-download me-2"></i> Import
                            </button> --}}

                            <a href="{{ route('team.create') }}" type="button"
                                class="btn btn-primary my-2 btn-icon-text">
                                <i class="fe fe-plus me-2"></i> Add Team</a>
                        </div>
                    </div>
                </div>
                <!-- End Page Header -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card custom-card">
                            <div class="card-body py-3">
                                <form action="{{ route('team.index') }}" method="get">
                                    <!--@csrf-->
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control form-control" placeholder="Search..."
                                                aria-controls="example1" name="searchtext"
                                                value="{{ $request->searchtext }}">
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
                                                <th>Image</th>
                                                <th>Basic Details</th>
                                                
                                                <th>Profession</th>
                                                <th>Status</th>

                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($teams) > 0)
                                                @foreach ($teams as $item)
                                                    <tr>

                                                        <td>
                                                            {{ $item->id }}
                                                        </td>
                                                        <td><img alt="avatar" class="rounded me-3"
                                                                src="{{ !empty($item->profile) ? asset('uploads/team/' . $item->profile) : asset('assets/img/media/1.jpg') }}"
                                                                style="width:60px"></td>
                                                        
                                                        <td>
                                                            <b>Name: </b>{{ @$item->team_name }}<br>
                                                            <b>Email: </b>{{ @$item->email }}<br>
                                                            <b>Mobile: </b>{{ @$item->mobile }}<br>
                                                            <b>Gender: </b>{{ @$item->gender }}<br>
                                                        </td>
                                                        
                                                        <td>
                                                            {{ @$item->profession }}
                                                        </td>
                                                        <td>
                                                            @if ($item->status == '1')
                                                                <span class="text-success">Active</span>
                                                            @else
                                                                <span class="text-danger">In-Active</span>
                                                            @endif
                                                        </td>


                                                        <td>
                                                            <div class="main-toggle-group-demo">
                                                                <a href="{{ url('admin/team_status/' . $item->id) }}"
                                                                    onclick="return confirm('Are you want to {{ $item->status == 1 ? 'Disable' : 'Enable' }}?')">
                                                                    <div
                                                                        class="main-toggle main-toggle-success {{ $item->status == 1 ? 'on' : 'off' }}">
                                                                        <span></span>
                                                                    </div>
                                                                </a>
                                                            </div>

                                                            <a href="{{ route('team.edit', $item->id) }}"
                                                                class="btn ripple btn-info btn-xs w-100">Edit
                                                            </a>
                                                            <br>

                                                            {{-- <a href="{{ route('team.show', $item->id) }}"
                                                                class="btn ripple btn-primary btn-xs w-100">View History
                                                            </a>
                                                            <br> --}}

                                                            <a href="javasctipt:void(0)"
                                                                class="btn ripple btn-danger btn-xs w-100"
                                                                onclick="event.preventDefault(); if (confirm('Are you sure you want to delete?')) { document.getElementById('delete-item-form{{ $item->id }}').submit(); }">
                                                                Delete
                                                            </a>
                                                            <form id="delete-item-form{{ $item->id }}"
                                                                action="{{ route('team.destroy', $item->id) }}"
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
                                    {!! $teams->onEachSide(5)->appends(request()->input())->links('pagination::bootstrap-4') !!}
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


@endsection
