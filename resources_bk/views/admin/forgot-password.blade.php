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

</head>

<body class="ltr main-body leftmenu error-1">

    <!-- Loader -->
    <div id="global-loader">
        <img src="{{ asset('assets/img/loader.svg') }}" class="loader-img" alt="Loader">
    </div>
    <!-- End Loader -->

    <!-- Page -->
    <div class="page main-signin-wrapper">

        <!-- Row -->
        <div class="row signpages text-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="row row-sm">
                        <div class="col-lg-6 col-xl-5 d-none d-lg-block text-center bg-primary details">
                            <div class="mt-5 pt-4 p-2 pos-absolute">
                                <img src="{{ asset('assets/img/brand/logo-light.png') }}"
                                    class="d-lg-none header-brand-img text-start float-start mb-4 error-logo-light"
                                    alt="logo">
                                <img src="{{ asset('assets/img/brand/logo.png') }}"
                                    class=" d-lg-none header-brand-img text-start float-start mb-4 error-logo"
                                    alt="logo">
                                <div class="clearfix"></div>
                                <img src="{{ asset('assets/img/Logo_SH_Grey210324.png') }}" class=" mb-0" alt="user" style="width:70%">
                                <!--<img src="{{ asset('assets/img/Logo_SH_Grey.png') }}" class=" mb-0" alt="user" style="width:70%">-->
                                <h5 class="mt-4 text-white">Forgot Password</h5>
                                <span class="tx-white-6 tx-13 mb-5 mt-xl-0"></span>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-7 col-xs-12 col-sm-12 login_form ">
                            <div class="main-container container-fluid">
                                <div class="row row-sm">
                                    <div class="card-body mt-2 mb-2">
                                        <img src="{{ asset('assets/img/brand/logo.png') }}"
                                            class=" d-lg-none header-brand-img text-start float-start mb-4"
                                            alt="logo">
                                        <div class="clearfix"></div>
                                        <form id="loginForm">
                                            <span class="text-danger text-center" id="Error"></span>

                                            @csrf
                                            <h5 class="text-start mb-2">Forgot Password</h5>
                                            <p class="mb-4 text-muted tx-13 ms-0 text-start"></p>
                                            <div class="form-group text-start">
                                                <label>Email</label>
                                                <input class="form-control" name="email" id="email"
                                                    placeholder="Enter your email" type="text">
                                                <p id="emailErr"></p>
                                            </div>
                                            
                                            <a href="#"
                                                class="btn ripple btn-main-primary btn-block" id="userLogin">Submit</a>
                                        </form>
                                        <div class="text-start mt-2 mb-5 ms-0">
                                            <div class="mb-1"><a href="{{ route('admin.login') }}">Sign In?</a></div>
                                            <!--<div>Don't have an account? <a href="signup.html">Register Here</a></div>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Row -->

    </div>
    <!-- End Page -->

    <!-- Jquery js-->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

    <!-- Bootstrap js-->
    <script src="{{ asset('assets/plugins/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- Select2 js-->
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.js') }}"></script>

    <!-- Perfect-scrollbar js -->
    <script src="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>

    <!-- Color Theme js -->
    <script src="{{ asset('assets/js/themeColors.js') }}"></script>

    <!-- Custom js -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <script>
        $(document).ready(function() {
            $("#userLogin").click(function(e) {
                /**Ajax code**/
                // $('.loader').show();
                e.preventDefault();
                $('.errors').text('');
                $.ajax({
                    method: 'post',
                    url: "{{ route('forgot-password') }}",
                    data: $('#loginForm').serialize(),
                    dataType: "json",
                    beforeSend: function() {
                        $('#userLogin').text('Please Wait...')
                    },
                    //add success option with following callback function
                    success: function(res, textStatus, xhr) {
                        // console.log(res.status)
                        $('#userLogin').text('Submit');
                        if (res.status == 'success') {
                           // window.location.href = "{{ route('dashboard') }}";
                           $("#Error").html(
                                '<span class="text-success errors" >' +res.message + '</span>');

                        }

                        // console.log(res);
                    },

                    error: function(response) {
                        $('#userLogin').text('Submit');
                        console.log(response);
                        $('.errors').empty();
                        if (response.responseJSON.error) {
                            if (response.responseJSON.error.email) {
                                $("#email").after(
                                    '<span class="text-danger errors" style="color:red">' +
                                    response.responseJSON.error.email + '</span>');
                            }
                        } else if (response.responseJSON.message) {
                            $("#Error").html(
                                '<span class="text-danger errors" style="color:red">' +
                                response.responseJSON.message + '</span>');
                        }
                    }
                });
            });
        });
    </script>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#togglePassword").click(function () {
                var passwordField = $("#password");
                var passwordFieldType = passwordField.attr('type');
                if (passwordFieldType === 'password') {
                    passwordField.attr('type', 'text');
                    $("#togglePassword i").removeClass("bi-eye").addClass("bi-eye-slash");
                } else {
                    passwordField.attr('type', 'password');
                    $("#togglePassword i").removeClass("bi-eye-slash").addClass("bi-eye");
                }
            });
        });
    </script>

</body>

</html>
