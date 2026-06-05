<!doctype html>
<html lang="en">


<!-- Mirrored from themesdesign.in/webadmin/layouts/contacts-profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 23 Jul 2023 18:05:18 GMT -->

<head>

    <meta charset="utf-8" />
    <title>Profile | webadmin - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

</head>

@include('partials.style')
<style>
    .fw-bold {
        display: flex;
        margin-right: 200px;
        margin-left: 135px;
    }

    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        color: black;
        min-width: 30px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        padding: 5px;
        margin-right: 20px;
        margin-bottom: 0;
        z-index: 1;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }

    .object-center {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .profile-pic {
        color: transparent;
        transition: all 0.3s ease;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        transition: all 0.3s ease;
    }

    .profile-pic input {
        display: none;
    }

    .profile-pic img {
        position: absolute;
        object-fit: cover;
        width: 165px;
        height: 165px;
        box-shadow: 0 0 10px 0 rgba(255, 255, 255, 0.35);
        border-radius: 100px;
        z-index: 0;
    }

    .profile-pic .-label {
        cursor: pointer;
        height: 165px;
        width: 165px;
    }

    .profile-pic:hover .-label {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: rgba(0, 0, 0, 0.8);
        z-index: 10000;
        color: rgb(250, 250, 250);
        transition: background-color 0.2s ease-in-out;
        border-radius: 100px;
        margin-bottom: 0;
    }

    .profile-pic span {
        display: inline-flex;
        padding: 0.2em;
        height: 2em;
    }
</style>

<body data-layout-mode="bordered" data-topbar="dark" data-sidebar="dark">

    <!-- <body data-layout="horizontal"> -->

    <!-- Begin page -->
    <div id="layout-wrapper">

        @include('partials.header')
        <!-- ========== Left Sidebar Start ========== -->
        @include('partials.navbar')
        <!-- Left Sidebar End -->
        @include('partials.horizontal_head')


        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-xxl-12">
                            <div class="card">
                                <div class="card-body p-0">
                                    <div class="user-profile-img">
                                        <img src="assets/images/pattern-bg.jpg"
                                            class="profile-img profile-foreground-img rounded-top"
                                            style="height: 120px;" alt="">
                                        <div class="overlay-content rounded-top">
                                            <div>
                                                <div class="user-nav p-3">
                                                    <div class="d-flex justify-content-end">
                                                        <div class="dropdown">
                                                            <span><i
                                                                    class="bx bx-dots-vertical text-white font-size-20"></i></span>
                                                            <div class="dropdown-content" style="margin-right: 40px">
                                                                <p style="margin-bottom: 0rem;"><a href=""
                                                                        style="text-decoration: none;"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#myModal">Edit</a></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end user-profile-img -->


                                    <div class="p-4 pt-0">

                                        <div class="mt-n5 position-relative text-center border-bottom pb-3">
                                            <img src="assets/images/pngegg.png" style="background:whitesmoke"
                                                id="profile_img" alt=""
                                                class="avatar-xl rounded-circle img-thumbnail">

                                            <div class="mt-3">
                                                <h5 class="mb-1" id="name1"></h5>
                                                {{-- <p class="text-muted mb-0">
                                                    <i class="bx bxs-star text-warning font-size-14"></i>
                                                    <i class="bx bxs-star text-warning font-size-14"></i>
                                                    <i class="bx bxs-star text-warning font-size-14"></i>
                                                    <i class="bx bxs-star text-warning font-size-14"></i>
                                                    <i class="bx bxs-star-half text-warning font-size-14"></i>
                                                </p> --}}
                                            </div>

                                        </div>

                                        <div class="table-responsive mt-3 border-bottom pb-3">
                                            <table
                                                class="table align-middle table-sm table-nowrap table-borderless table-centered mb-0"
                                                style="display:flex;justify-content: center;">
                                                <tbody>
                                                    <tr>
                                                        <th class="fw-bold">
                                                            Name :</th>
                                                        <td class="text-muted" id="name">New Your City</td>
                                                    </tr>
                                                    <!-- end tr -->
                                                    <tr>
                                                        <th class="fw-bold">
                                                            Email :</th>
                                                        <td class="text-muted" id="email">New Your</td>
                                                    </tr>
                                                    <!-- end tr -->

                                                </tbody><!-- end tbody -->
                                            </table>
                                        </div>




                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                    <!-- end row -->



                    <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel"
                        aria-hidden="true" data-bs-scroll="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <!-- <h5 class="modal-title" id="myModalLabel">Create Impact</h5> -->
                                    <h5 class="modal-title" id="myModalLabel">
                                        <h5 id="labelc">Edit</h5>
                                        <br>
                                        <h5>Profile</h5>
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-3 row">
                                                <div class="profile-pic">
                                                    <label class="-label" for="file">
                                                        <span class="glyphicon glyphicon-camera"></span>
                                                        <span>Change Image</span>
                                                    </label>
                                                    <input id="file" type="file" onchange="loadFile(event)"
                                                        style="background-color:black;" />
                                                    <img src="" id="output" width="200" />
                                                </div>

                                            </div>
                                            <div class="mb-3 row">


                                                <label for="example-text-input" class="col-md-2 col-form-label">First
                                                    Name</label>
                                                <div class="col-md-10">
                                                    <input class="form-control" type="text"
                                                        placeholder="Enter First Name" id="firstname">
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="example-text-input" class="col-md-2 col-form-label">Last
                                                    Name</label>
                                                <div class="col-md-10">
                                                    <input class="form-control" type="text"
                                                        placeholder="Enter Last Name" id="lastname">
                                                </div>
                                            </div>
                                            <div class="mb-3 row" style="display: flex;align-items: center;">
                                                <label class="form-label col-2" for="password-input">Password</label>
                                                <div
                                                    class="position-relative auth-pass-inputgroup input-custom-icon col-10">
                                                    <div>
                                                        <input type="password" class="form-control" name="password"
                                                            id="password-input" placeholder="Enter password">
                                                        <button type="button"
                                                            class="btn btn-link position-absolute h-100 end-0 top-0"
                                                            id="password-addon" style="margin-right: 15px;">
                                                            <i class="mdi mdi-eye-outline font-size-18 text-muted"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-3 row">
                                                <div class="col-md-10">
                                                    <input class="form-control" type="hidden" id="profile_id"
                                                        name="hidden" value="{{ Auth::user()->id }}">
                                                    <!-- <input type="hidden" id="postId" name="postId" value="34657" /> -->
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary waves-effect"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="button" id="button" onclick="update()" name="button"
                                        data-bs-dismiss="modal" class="btn btn-primary waves-effect waves-light">Save
                                        changes</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div>



                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


        </div>
        <!-- end main content-->
        <!-- end main content-->
        @include('partials.footer')
    </div>
    <!-- END layout-wrapper -->
    @include('partials.right_bar')
    </div>
    <!-- END layout-wrapper -->

    @include('partials.script')
    <!-- JAVASCRIPT -->


</body>
<!-- JAVASCRIPT -->
<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/libs/metismenujs/metismenujs.min.js"></script>
<script src="assets/libs/simplebar/simplebar.min.js"></script>
<script src="assets/libs/eva-icons/eva.min.js"></script>

<!-- apexcharts -->
<script src="assets/libs/apexcharts/apexcharts.min.js"></script>
<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/libs/metismenujs/metismenujs.min.js"></script>
<script src="assets/libs/simplebar/simplebar.min.js"></script>
<script src="assets/libs/eva-icons/eva.min.js"></script>

<script src="assets/js/pages/pass-addon.init.js"></script>
<script src="assets/js/pages/profile.init.js"></script>

<script src="assets/js/app.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"
    integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous">
</script>

<script>
    // $(document).ready(function() {
    //     $('#layout-mode-dark').attr('checked', true);
    //
    // });
    var loadFile = function(event) {
        var image = document.getElementById("output");
        image.src = URL.createObjectURL(event.target.files[0]);
    };


    function fetchtable() {
        const settings = {
            "async": true,
            "crossDomain": true,
            "url": "/api/users/{{ Auth::user()->id }}",
            "method": "GET",
            "headers": {
                "Accept": "*/*",
                "User-Agent": "Thunder Client (https://www.thunderclient.com)"
            }
        };

        $.ajax(settings).done(function(response) {
            console.log(response);

            $('#name').html(response[0]['first_name'] + ' ' + response[0]['last_name']);
            $('#name1').html(response[0]['name']);
            $('#email').html(response[0]['email']);
            // $("#profile_id").val(response[0]['id']);
            var ret = response[0]['photo_url'].replace("documents/", "");

            if (ret != "") {
                var image_sm = document.getElementById('profile_img').src =
                    "http://demo.p2ptrack360.com/api/profile/" + ret;
            }


        });
    }
    fetchtable()

    function update() {
        var form = new FormData();
        form.append("firstname", $("#firstname").val());
        form.append("lastname", $("#lastname").val());
        form.append("password", $('#password-input').val());
        form.append("id", $("#profile_id").val());
        form.append("profile", document.getElementById("file").files[0]);
        var settings = {
            "url": "api/users/profile_update",
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
                    console.log(response);


                    // console.log("Request was successful");


                    Swal.fire(
                        'Success!',
                        'Profile updated Successfully',
                        'success'
                    )
                },
                // Add more status code handlers as needed

            },
            success: function(data) {
                $('#myModal').modal('hide');
                fetchtable();
                // Additional success handling if needed
            },
            error: function(xhr, textStatus, errorThrown) {
                console.log(xhr)
                Swal.fire(
                    'Server Error!',
                    'Profile Not updated',
                    'error'
                )

                // console.log("Request failed with status code: " + xhr.status);
            }
        });

    }
</script>



<!-- Mirrored from themesdesign.in/webadmin/layouts/contacts-profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 23 Jul 2023 18:05:20 GMT -->

</html>
