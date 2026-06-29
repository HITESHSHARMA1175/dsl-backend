<script src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('assets/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.js') }}"></script>
<script>
    //[editor Javascript]

    //Project:	Rhythm Admin - Responsive Admin Template
    //Primary use:   Used only for the wysihtml5 Editor 


    //Add text editor
    $(function() {
        "use strict";

        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('editor1')

        $('.textarea').wysihtml5();

    });
</script>

@isset($property_info)
    <script>
        $(document).ready(function() {
            getPropertySubCatByCat('',{!! json_encode($property_info->property_sub_category ?? []) !!})
                
            getPropertySubCondByCond('', {!! json_encode($property_info->skin_sub_condition ?? []) !!});

        });
    </script>
@endisset

<script>
    function getPropertySubCondByCond(selectElement2, checkedSubCategory) {
        let selectElement = document.getElementById("skin_condition");
        let CategoryIds = Array.from(selectElement.selectedOptions).map(option => option.value);
        $('#skin_sub_condition').empty();
        return $.ajax({
            url: "{{ route('getPropertySubCondByCond') }}",
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                category_ids: CategoryIds,
                checkedSubCategory: checkedSubCategory
            },
            beforeSend: function(res) {
                $('#skin_sub_condition').html('<option  value="">Loading...</option>');
            },
            success: function(res) {
                $('#skin_sub_condition').html(res.data);
            },
            error: function(res) {
                $('#skin_sub_condition').html('<option value="">Select</option>');
            }
        })
    }
    function getPropertySubCatByCat(selectElement2,checkedSubCategory) {
        let selectElement = document.getElementById("category");
        let CategoryIds = Array.from(selectElement.selectedOptions).map(option => option.value);
        //console.log(CategoryIds); // Logs the selected IDs
        $('#sub_category').empty();
        return $.ajax({
            url: "{{ route('getPropertySubCatByCat') }}",
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                category_ids: CategoryIds,
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
    
</script>

<script>
    $(document).ready(function() {
        var maxField = 4; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        // var fieldHTML = '<div><input type="text" name="field_name[]" value=""/><a href="javascript:void(0);" class="remove_button">Remove</a></div>'; //New input field html 
        var x = 1; //Initial field counter is 1

        //Once add button is clicked
        $(addButton).click(function() {
            //Check maximum number of input fields
            if (x < maxField) {
                x++; //Increment field counter

                var fieldHTML = `<div class="row row-sm"><div class="col-lg-11 col-md-11">
                                            <div class="row">
                                                <div class="col-sm-3 mg-t-10">
                                                    <div class="form-group mb-0">
                                                        <label class="form-label"> Relation</label>
                                                        <input class="form-control" name="address" type="text"
                                                            required>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3 mg-t-10">
                                                    <div class="form-group mb-0">
                                                        <label class="form-label"> Name</label>
                                                        <input class="form-control" name="address" type="text"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3 mg-t-10">
                                                    <div class="form-group mb-0">
                                                        <label class="form-label"> Mobile </label>
                                                        <input class="form-control" name="address" type="text"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3 mg-t-10">
                                                    <div class="form-group mb-0">
                                                        <label class="form-label"> Gender </label>
                                                        <select class="form-control select2" name="gender" required>
                                                            <option value="">Select</option>
                                                            <option value="Male">
                                                                Male</option>
                                                            <option value="Female">
                                                                Female</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-1 col-md-1 mg-t-35">
                                            <a href="javascript:void(0);" class="btn btn-danger remove_button">Remove</a>
                                        </div></div>`;

                $(wrapper).append(fieldHTML); //Add field html
            } else {
                alert('You Maximum add 4 Options.')
            }
        });

        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e) {
            e.preventDefault();
            $(this).parent('div').parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });
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


{{-- update property page --}}
@isset($propertyimages)
    <script>
        $(function() {

            let preloaded = [
                @foreach ($propertyimages as $item)
                    {
                        id: '{{ $item->id }}',
                        src: '{{ asset('uploads/property/' . $item->image) }}'
                    },
                @endforeach
            ];

            console.log(preloaded);

            $('.input-images-2').imageUploader({
                imagesInputName: 'photos',
                preloadedInputName: 'old',
                preloaded: preloaded,
                maxSize: 2 * 1024 * 1024,
                maxFiles: 10,
                extensions: ['.jpg', '.jpeg', '.png'],
                mimes: ['image/jpeg', 'image/png']
            });
        });
    </script>
@endisset

{{-- update property page --}}
