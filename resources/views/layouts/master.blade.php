<!doctype html>
<html lang="en">

    
<!-- Mirrored from themesdesign.in/webadmin/layouts/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 23 Jul 2023 18:04:41 GMT -->
<head>

        <meta charset="utf-8" />
        <title>Dashboard | webadmin - Admin & Dashboard Template</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="api-bearer-token" content="{{ session('api_bearer_token', '') }}">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesdesign" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

        <!-- plugin css -->
        <link href="{{ asset('assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- Bootstrap Css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    </head>

    
    <body data-layout-mode="bordered" data-topbar="dark" data-sidebar="dark">

    <!-- <body data-layout="horizontal"> -->

        <!-- Begin page -->
        <div id="layout-wrapper">

            
            @include("partials.header")
            <!-- ========== Left Sidebar Start ========== -->
            @include("partials.navbar")
            <!-- Left Sidebar End -->
            @include("partials.horizontal_head")


            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            @yield('content')
            <!-- end main content-->
            @include("partials.footer")
        </div>
        <!-- END layout-wrapper -->
        @include("partials.right_bar")
        <!-- Right Sidebar -->
       
        <!-- JAVASCRIPT -->
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/libs/metismenujs/metismenujs.min.js') }}"></script>
        <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/libs/eva-icons/eva.min.js') }}"></script>

        <!-- apexcharts -->
        <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>

        <!-- Vector map-->
        <script src="{{ asset('assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
        <script src="{{ asset('assets/libs/jsvectormap/maps/world-merc.js') }}"></script>
        
        <script src="{{ asset('assets/js/pages/dashboard.init.js') }}"></script>

        <script src="{{ asset('assets/js/app.js') }}"></script>

        <script>
            (function () {
                const token = document.querySelector('meta[name="api-bearer-token"]')?.content;
                if (!token) return;

                const addBearerHeader = (url, headers) => {
                    try {
                        if (new URL(url, window.location.href).origin === window.location.origin) {
                            headers.set('Authorization', `Bearer ${token}`);
                        }
                    } catch (error) {
                        // Ignore malformed or non-HTTP request URLs.
                    }
                    return headers;
                };

                if (window.jQuery) {
                    window.jQuery.ajaxPrefilter((options, originalOptions, jqXHR) => {
                        addBearerHeader(options.url, {
                            set: (name, value) => jqXHR.setRequestHeader(name, value)
                        });
                    });
                }

                if (window.fetch) {
                    const originalFetch = window.fetch.bind(window);
                    window.fetch = (input, init = {}) => {
                        const headers = new Headers(init.headers || (input instanceof Request ? input.headers : undefined));
                        addBearerHeader(input instanceof Request ? input.url : input, headers);
                        return originalFetch(input, { ...init, headers });
                    };
                }
            })();
        </script>

    </body>


<!-- Mirrored from themesdesign.in/webadmin/layouts/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 23 Jul 2023 18:05:08 GMT -->
</html>