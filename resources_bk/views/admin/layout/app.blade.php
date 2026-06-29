<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="description" content="Dsl">
    <meta name="author" content="Dsl">
    <meta name="keywords" content="Dsl">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/img/brand/favicon.ico') }}" type="image/x-icon" />

    <!-- Title -->
    <title>Dsl</title>

    <!-- Bootstrap css-->
    <link id="style" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />

    <!-- Icons css-->
    <link href="{{ asset('assets/plugins/web-fonts/icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/web-fonts/font-awesome/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/web-fonts/plugin.css') }}" rel="stylesheet" />

    <!-- Style css-->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <!-- Select2 css -->
    <!-- <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">-->

    <!-- Mutipleselect css-->
    <link rel="stylesheet" href="{{ asset('assets/plugins/multipleselect/multiple-select.css') }}">

    <!-- Internal Daterangepicker css-->
    <link href="{{ asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">

    <!-- InternalFileupload css-->
    <link href="{{ asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />

    <!-- InternalFancy uploader css-->
    <link href="{{ asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />

    <!-- Internal TelephoneInput css-->
    <link rel="stylesheet" href="{{ asset('assets/plugins/telephoneinput/telephoneinput.css') }}">
    <!--Bootstrap-datepicker css-->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css') }}">

    <!-- Internal Datetimepicker-slider css -->
    <link href="{{ asset('assets/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css') }}" rel="stylesheet">

    <!-- Internal Specturm-color picker css-->
    <link href="{{ asset('assets/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">

    <!-- Internal Ion.rangeslider css-->
    <link href="{{ asset('assets/plugins/ion-rangeslider/css/ion.rangeSlider.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/ion-rangeslider/css/ion.rangeSlider.skinFlat.css') }}" rel="stylesheet">

    <!-- Toastr css-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"
        type="text/css" />

    {{-- Image Uploader --}}
    <link rel="stylesheet" href="{{ asset('assets/image-uploader/dist/image-uploader.min.css') }}">

    <!-- Jquery js-->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>

<body class="ltr main-body horizontalmenu">

    <!-- Loader -->
    <div id="global-loader">
        <img src="{{ asset('assets/img/loader.svg') }}" class="loader-img" alt="Loader">
    </div>
    <!-- End Loader -->

    <style>
        .main-navbar {
            /*background-color: #1b6298;*/
            /*background-color: #d99a39;*/
            background-color: #020700;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #ccc !important;
        }
    </style>

    <!-- Page -->
    <div class="page">

        <!-- Main Header-->
        @include('admin.layout.header')
        <!-- End Main Header-->

        <!-- Sidemenu -->
        @include('admin.layout.sidebar')
        <!-- End Sidemenu -->

        @yield('content')

        <!-- Main Footer -->
        @include('admin.layout.footer')
        <!-- End Main Footer -->

        <!-- Sidemenu -->
        @include('admin.layout.sidemenu')
        <!-- End Sidemenu -->


    </div>
    <!-- End Page -->

    <!-- Back-to-top -->
    <a href="#top" id="back-to-top"><i class="fe fe-arrow-up"></i></a>


    <!-- Bootstrap js-->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Jquery-Ui js-->
    <script src="{{ asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>

    <!-- Internal Daternagepicker js-->
    <script src="{{ asset('assets/plugins/bootstrap-daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    <!-- Internal Fileuploads js-->
    <script src="{{ asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>

    <!-- InternalFancy uploader js-->
    <script src="{{ asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>

    <!-- Internal Form-elements js-->
    <script src="{{ asset('assets/js/advanced-form-elements.js') }}"></script>

    <!-- Internal TelephoneInput js-->
    <script src="{{ asset('assets/plugins/telephoneinput/telephoneinput.js') }}"></script>
    <script src="{{ asset('assets/plugins/telephoneinput/inttelephoneinput.js') }}"></script>

    <!-- Perfect-scrollbar js -->
    <script src="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>

    <!-- Sidemenu js -->
    <script src="{{ asset('assets/plugins/sidemenu/sidemenu.js') }}" id="leftmenu"></script>
    <!--Bootstrap-datepicker js-->
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>

    <!-- Internal jquery-simple-datetimepicker js -->
    <script src="{{ asset('assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js') }}"></script>

    <!-- COLOR PICKER JS -->
    <script src="{{ asset('assets/plugins/pickr-master/pickr.es5.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/picker.js') }}"></script> --}}
    <!-- Sidebar js -->
    <script src="{{ asset('assets/plugins/sidebar/sidebar.js') }}"></script>

    <!-- Select2 js-->
    <!--<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>-->
    <!--<script src="{{ asset('assets/js/select2.js') }}"></script>-->

    <!-- Color Theme js -->
    <script src="{{ asset('assets/js/themeColors.js') }}"></script>

    <!-- Sticky js -->
    <script src="{{ asset('assets/js/sticky.js') }}"></script>

    <!-- Custom js -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>



    <!-- Bootstrap js-->
    <script src="{{ asset('assets/plugins/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- Internal Jquery-Ui js-->
    <script src="{{ asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>

    <!-- Internal Jquery.maskedinput js-->
    <script src="{{ asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>

    <!-- Internal Specturm-colorpicker js-->
    <script src="{{ asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>

    <!-- Internal Ion-rangeslider js-->
    <script src="{{ asset('assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>


    <!-- Internal Form-elements js-->
    <script src="{{ asset('assets/js/form-elements.js') }}"></script>


    {{-- Image Uploader --}}
    <script type="text/javascript" src="{{ asset('assets/image-uploader/dist/image-uploader.min.js') }}"></script>


    <!-- Toster   js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    {{-- show toastr message --}}
    <script>
        $(document).ready(function() {
            // toastr.success('demp', 'Success!');
            @if (Session::has('success'))
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                }
                toastr.success('{{ Session::get('success') }}', 'Success!');
            @endif

            @if (Session::has('error'))
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                }
                toastr.error('{{ Session::get('error') }}', 'Error!');
            @endif

        })
    </script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</body>

</html>
