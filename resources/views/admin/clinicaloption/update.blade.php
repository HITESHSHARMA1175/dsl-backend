@extends('admin.layout.app')
@section('content')
    <!-- Main Content-->
    <div class="main-content side-content pt-0">

        <div class="main-container container-fluid">
            <div class="inner-body">

                <!-- Page Header -->
                <div class="page-header">
                    <div>
                        <h2 class="main-content-title tx-24 mg-b-5">Edit Clinical Option Value</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Clinical Option Value </a></li>
                        </ol>
                    </div>
                    <div class="d-flex">
                        <div class="justify-content-center">

                            {{-- <button type="button" class="btn btn-primary my-2 btn-icon-text">
                                <i class="fe fe-download-cloud me-2"></i> Print
                            </button> --}}
                        </div>
                    </div>
                </div>
                <!-- End Page Header -->
                <form action="{{ route('clinicaloption.update', $clinicaloption_info->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Row -->
                    <div class="row row-sm">


                       
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            
                            <div class="card custom-card">
                                <div class="card-body">
                                        <div>
                                           
                                        <div class="">
                                            <div class="row row-sm">
                                                <div class="col-lg-4 form-group">
                                                    <label class="form-label">Clinical Option: <span class="tx-danger">*</span></label>
                                                    <select class="form-control select select2" name="clinical_option" required>
                                                        <option value="">Select</option>
                                                        @foreach ($clinical_options as $item)
                                                            <option value="{{ $item->id }}" {{ $clinicaloption_info->clinical_option == $item->id ? 'selected' : '' }}>{{ $item->MasterValue }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-lg-4 form-group">
                                                    <label class="form-label">Enter Clinical Option Value: <span class="tx-danger">*</span></label>
                                                    <input class="form-control" name="name" value="{{ $clinicaloption_info->name }}" placeholder="" type="text" required> 
                                                </div>
                                                <div class="col-lg-4 form-group">
                                                    <label class="form-label">If Add Child: </label>
                                                    <button type="button" class="btn btn-success add-subcategory">
                                                        <i class="fa fa-plus"></i> Add Child
                                                    </button>
                                                </div>
                                                
                                            </div>
                                            
                                            <div id="subcategory-container">
                                                <div class="row subcategory-row">
                                                    
                                                   
                                                    @foreach ($clinicaloptions as $item)
                                                    <div class="col-lg-4 form-group">
                                                        <div class="d-flex align-items-center">
                                                            <input class="form-control me-2" name="oldchilds[{{ $item->id }}]" placeholder="Enter " value="{{ $item->name }}" type="text" required="">
                                                            <button type="button" class="btn btn-danger btn-sm p-2 " onclick="event.preventDefault(); if (confirm('Are you sure you want to delete?')) { document.getElementById('delete-item-form{{ $item->id }}').submit(); }">
                                                                <i class="fa fa-minus"></i>
                                                            </button>
                                                            <form id="delete-item-form{{ $item->id }}"
                                                                action="{{ route('clinicaloption.destroy', $item->id) }}"
                                                                method="POST" style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row row-sm">
                                <div class="col-12 mb-3">
                                    <input type="submit" class="btn btn-primary" value="Submit">
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- End Row -->
                </form>

            </div>
        </div>
    </div>
    <!-- End Main Content-->
    
<script src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('assets/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>



<!-- JavaScript for Dynamic Fields -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const subcategoryContainer = document.getElementById("subcategory-container");

        // Function to create a new subcategory field
        function createSubcategoryField() {
            const subcategoryField = document.createElement("div");
            subcategoryField.className = "col-lg-4 form-group";
            subcategoryField.innerHTML = `
                <div class="d-flex align-items-center">
                    <input class="form-control me-2" name="childs[]" placeholder="Enter " type="text" required>
                    <button type="button" class="btn btn-danger btn-sm p-2 remove-subcategory">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            `;
            return subcategoryField;
        }

        // Add button event listener
        document.querySelector(".add-subcategory").addEventListener("click", function () {
            // Get the last row in the container
            let lastRow = subcategoryContainer.querySelector(".subcategory-row:last-child");

            // If no rows exist or the last row already has three fields, create a new row
            if (!lastRow || lastRow.querySelectorAll(".form-group").length >= 3) {
                lastRow = document.createElement("div");
                lastRow.className = "row subcategory-row mb-3";
                subcategoryContainer.appendChild(lastRow);
            }

            // Add a new subcategory field to the last row
            lastRow.appendChild(createSubcategoryField());
        });

        // Event delegation for removing a subcategory field
        subcategoryContainer.addEventListener("click", function (event) {
            if (event.target.closest(".remove-subcategory")) {
                const row = event.target.closest(".subcategory-row");
                const field = event.target.closest(".form-group");

                if (field) {
                    field.remove();
                }

                // If the row becomes empty, remove the row itself
                if (row && row.querySelectorAll(".form-group").length === 0) {
                    row.remove();
                }
            }
        });
    });
</script>


<script>

//[editor Javascript]

//Project:	Rhythm Admin - Responsive Admin Template
//Primary use:   Used only for the wysihtml5 Editor 


//Add text editor
    $(function () {
    "use strict";

    // Replace the <textarea id="editor1"> with a CKEditor
	// instance, using default configuration.
	CKEDITOR.replace('editor1')
	
	$('.textarea').wysihtml5();		
	
  });


</script>     
    
    
    <script>
       
        $(function() {
            $('.input-images-1').imageUploader({
                imagesInputName: 'photos',
                preloadedInputName: 'old',
                maxSize: 2 * 1024 * 1024,
                maxFiles: 10,
                extensions: ['.jpg', '.jpeg', '.png'],
                mimes: ['image/jpeg', 'image/png']
            });
        });
    </script>


@endsection
