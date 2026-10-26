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

        <form method="POST" action="{{ route('password.email') }}">
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

                                        @csrf

                                        <div class="mb-3 row" style="display: flex;align-items: center;">
                                            <label class="form-label col-2" for="password-input">Password</label>
                                            <div
                                                class="position-relative auth-pass-inputgroup input-custom-icon col-10">
                                                <div>
                                                    <input type="password" class="form-control" name="password"
                                                        id="password" placeholder="Enter password">
                                                    <button type="button"
                                                        class="btn btn-link position-absolute h-100 end-0 top-0"
                                                        id="password-addon" style="margin-right: 15px;">
                                                        <i class="mdi mdi-eye-outline font-size-18 text-muted"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row" style="display: flex;align-items: center;">
                                            <label class="form-label col-2" for="password-input">Confirm
                                                Password</label>
                                            <div
                                                class="position-relative auth-pass-inputgroup input-custom-icon col-10">
                                                <div>
                                                    <input type="password" class="form-control" name="password"
                                                        id="confirm_password" placeholder="Enter password">
                                                    <button type="button"
                                                        class="btn btn-link position-absolute h-100 end-0 top-0"
                                                        id="password-addon" style="margin-right: 15px;">
                                                        <i class="mdi mdi-eye-outline font-size-18 text-muted"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            <button class="btn btn-primary w-100 waves-effect waves-light"
                                                type="button" onclick="submit()">Send Link</button>
                                        </div>




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
        function submit() {
            var form = new FormData();
            var currentUrl = window.location.href;

            // Split the URL into segments using '/'
            var urlSegments = currentUrl.split('/');

            // Get the third entity (index 2) from the URL
            var thirdEntity = urlSegments[2];
            form.append("password", $('#password').val());
            form.append("email", "" + thirdEntity + "");
            var settings = {
                "url": "api/reset/"+thirdEntity,
                "method": "POST",
                "timeout": 0,
                "processData": false,
                "mimeType": "multipart/form-data",
                "contentType": false,
                "data": form
            };

            $.ajax({
                ...settings,
                statusCode: {
                    200: function(response) {

                        Swal.fire(
                            'Success!',
                            'Password Reset Successfully',
                            'success'
                        )
                    },
                },
                success: function(data) {
                    // $('#myModal').reset();
                    // Additional success handling if needed
                },
                error: function(xhr, textStatus, errorThrown) {
                    Swal.fire(
                        'Server Error!',
                        'Password Not Reset',
                        'error'
                    )
                }
            });






            // alert("Update Records Here");

        }
    </script>

</body>


<!-- Mirrored from themesdesign.in/webadmin/layouts/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 23 Jul 2023 18:05:53 GMT -->

</html>
