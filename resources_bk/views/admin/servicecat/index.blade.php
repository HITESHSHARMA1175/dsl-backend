@extends('admin.layout.app')
@section('content')
    <!-- Main Content-->
    <div class="main-content side-content pt-0">

        <div class="main-container container-fluid">
            <div class="inner-body">

                <!-- Page Header -->
                <div class="page-header">
                    <div>
                        <h2 class="main-content-title tx-24 mg-b-5">Category List ({{ @$servicecatsCount }})</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Category </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Category List </li>
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
                            <a href="{{ route('servicecat.create') }}" type="button"
                                class="btn btn-primary my-2 btn-icon-text">
                                <i class="fe fe-plus me-2"></i> Add Category</a>
                        </div>
                    </div>
                </div>
                <!-- End Page Header -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card custom-card">
                            <div class="card-body py-3">
                                <form action="{{ route('servicecat.index') }}" method="get">
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
                                    <form method="POST" action="{{ route('servicecat_sorting') }}">
                                    @csrf
                                    <table class="table table-striped table-bordered text-nowrap mb-0">
                                        <thead>
                                            <tr>

                                                <th>ID</th>
                                                <th>Category Name</th>
                                                <th>Category Image</th>
                                                <th>Sort</th>
                                                <th width="10%">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($servicecats as $item)
                                                <tr>
                                                    <td>
                                                        CAT-{{ $item->id }}
                                                    </td>
                                                    
                                                    <td>
                                                        <p class="mb-0">
                                                            {{ $item->category_name }}
                                                        </p>
                                                    </td>

                                                   
                                                    <td>
                                                        @if(!empty($item->icon))
                                                        <img alt="avatar" class="rounded me-3"
                                                            src="{{ !empty($item->icon) ? asset('uploads/servicecat/' . $item->icon) : asset('uploads/userimage/no-servicecat.jpg') }}"
                                                            style="width:60px">
                                                        @else
                                                        NA
                                                        @endif
                                                    </td>
                                                    
                                                    <td>
                                                        <input type="number" name="sorting[{{ $item->id }}]" 
                                                               value="{{ $item->sorting_order }}" min="1" 
                                                               style="width: 80px;" />
                                                    </td>

                                                    <td>
                                                        <div class="main-toggle-group-demo">

                                                            <a href="{{ url('admin/servicecat_status/' . $item->id) }}"
                                                                onclick="return confirm('Are you want to {{ $item->status == 1 ? 'Disable' : 'Enable' }}?')">
                                                                <div
                                                                    class="main-toggle main-toggle-success {{ $item->status == 1 ? 'on' : 'off' }}">
                                                                    <span></span>
                                                                </div>
                                                            </a>


                                                        </div>

                                                        <a href="{{ route('servicecat.edit', $item->id) }}"
                                                            class="btn ripple btn-info btn-xs w-100">Edit</a>
                                                        <br>
                                                        @if($item->servicecat_type != 'Home Section')   
                                                        <a href="#" class="btn ripple btn-danger btn-xs w-100" 
                                                           onclick="submitDeleteForm('{{ $item->id }}', '{{ route('servicecat.destroy', $item->id) }}')">
                                                           Delete
                                                        </a>
                                                        @endif
                                                    </td>

                                                </tr>
                                            @endforeach
                                            
                                            
                                        </tbody>
                                    </table>
                                    <button type="submit" class="btn btn-primary mt-1" style="float:right; margin-right: 160px;">Update Sorting</button>
                                    </form>
                                </div>

                                <div class="d-flex justify-content-end mt-2">
                                    {!! $servicecats->onEachSide(5)->appends(request()->input())->links('pagination::bootstrap-4') !!}
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

    <!-- Single shared form -->
    <form id="delete-item-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
    
    <script>
        function submitDeleteForm(id, actionUrl) {
            // Confirm with the user
            if (confirm('Are you sure you want to delete this item?')) {
                // Get the existing form
                const form = document.getElementById('delete-item-form');
                
                // Update the form action URL
                form.action = actionUrl;
                
                // Submit the form
                form.submit();
            }
        }
    </script>

 
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
