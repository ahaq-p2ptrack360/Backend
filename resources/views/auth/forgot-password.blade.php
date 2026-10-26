{{-- <x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('generate.otp') }}">
            @csrf

            <div class="block">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button>
                    {{ __('Email Password Reset Link') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout> --}}
<!doctype html>
<html lang="en">


<!-- Mirrored from themesdesign.in/webadmin/layouts/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 23 Jul 2023 18:05:53 GMT -->

<head>

    <meta charset="utf-8" />
    <title>Login | webadmin - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">


</head>


<body>

    <!-- <body data-layout="horizontal"> -->

    <div class="authentication-bg min-vh-100">
        <div class="bg-overlay bg-light"></div>
        <div class="container">
            <div class="d-flex flex-column min-vh-100 px-3 pt-4">
                <div class="row justify-content-center my-auto">
                    <div class="col-md-8 col-lg-6 col-xl-5">

                        <div class="mb-4 pb-2">
                            <a href="index.html" class="d-block auth-logo">
                                <img src="assets/images/logo-dark.png" alt="" height="30"
                                    class="auth-logo-dark me-start">
                                <img src="assets/images/logo-light.png" alt="" height="30"
                                    class="auth-logo-light me-start">
                            </a>
                        </div>

                        <div class="card">
                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5>Welcome Back !</h5>
                                    <p class="text-muted">Sign in to continue to webadmin.</p>
                                </div>

                                <div class="p-2 mt-4">
                                    <form method="POST"  action="{{ route('generate.otp') }}">
                                        @csrf

                                        <div class="mb-3">
                                            <label class="form-label" for="username">Email</label>
                                            <div class="position-relative input-custom-icon">
                                                <p id="email_error"></p>
                                                <input type="text" class="form-control" name="email" id="email"
                                                    placeholder="Enter Email">
                                                <span class="bx bx-user"></span>
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="mt-3">
                                            <button class="btn btn-primary w-100 waves-effect waves-light"
                                                type="submit" >Send Code</button>
                                        </div>



                                    </form>
                                </div>

                            </div>
                        </div>

                    </div><!-- end col -->
                </div><!-- end row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center p-4">
                            <p>©
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> webadmin. Crafted with <i
                                    class="mdi mdi-heart text-danger"></i> by <a
                                    href="https://1.envato.market/themesdesign" target="_blank">Themesdesign</a>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div><!-- end container -->
    </div>
    <!-- end authentication section -->

    <!-- JAVASCRIPT -->
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenujs/metismenujs.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/eva-icons/eva.min.js"></script>

    <script src="assets/js/pages/pass-addon.init.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>


    <script>
        function sendmail() {
            email = $('#email').val();

            var settings = {
                "url": "api/forgot_pass/" + email,
                "method": "GET",
                "timeout": 0,
            };
            $.ajax({
                ...settings,
                statusCode: {
                    200: function(response) {
                        // alert(response[0]['about']);
                        if(response==""){
                            Swal.fire(
                                        'Error!',
                                        'Invalid Email',
                                        'error'
                                    )
                        }
                        else{
                        var settings = {
                            "url": "api/sendbasicemail/"+response[0]['about'] +"/"+  email,
                            "method": "GET",
                            "timeout": 0,

                        };
                        $.ajax({
                            ...settings,
                            statusCode: {
                                200: function(response) {


                                    Swal.fire(
                                        'Success!',
                                        'Email Send Successfully',
                                        'success'
                                    )
                                },
                                // Add more status code handlers as needed
                            },
                            success: function(data) {
                                // Additional success handling if needed
                                window.location.href = '/login'

                            },
                            error: function(xhr, textStatus, errorThrown) {
                                Swal.fire(
                                    'Email Not Send!',
                                    '',
                                    'error'
                                )

                                // console.log("Request failed with status code: " + xhr.status);
                            }
                        });
                    }
                    },

                    // Add more status code handlers as needed
                },
            });

        }
    </script>

</body>


<!-- Mirrored from themesdesign.in/webadmin/layouts/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 23 Jul 2023 18:05:53 GMT -->

</html>
