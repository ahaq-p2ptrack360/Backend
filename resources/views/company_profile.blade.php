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
    .pac-container {
            z-index: 9999;
            /* Adjust the z-index value as needed */
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
                                                            <div class="dropdown-content" style="margin-right: 40px"
                                                                onclick="showcanvas()">
                                                                <p style="margin-bottom: 0rem;"><a href="#"
                                                                        style="text-decoration: none;">Edit</a></p>
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


                                               
                                                    <!-- <div class="row">
                                                        <div class="col-6">
                                                            @if (session('success'))
                                                                <script>
                                                                    alert("{{ session('success') }}");
                                                                </script>
                                                                {{-- <div style="color: green;">{{ session('success') }}</div> --}}
                                                            @endif
                                                            <button type="button" class="btn btn-soft-primary"
                                                                data-bs-toggle="modal" data-bs-target="#myModal">Import
                                                                Excel</button>
                                                        </div>
                                                        <div class="col-6">
                                                            <a href="{{ asset('assets/images/Excel Format.zip') }}"
                                                                class="btn btn-soft-primary">Excel Format</a>
                                                        </div>
                                                    </div> -->

                                                    <div class="row justify-content-end">
    <div class="col-auto">
        @if (session('success'))
            <script>
                alert("{{ session('success') }}");
            </script>
            {{-- <div style="color: green;">{{ session('success') }}</div> --}}
        @endif
    </div>
    <div class="col-auto">
        <button type="button" class="btn btn-soft-primary" data-bs-toggle="modal" data-bs-target="#myModal">Import Lagacy</button>
    </div>
    <div class="col-auto">
        <a href="{{ asset('assets/images/Excel Format.zip') }}" class="btn btn-soft-primary">Base Format</a>
    </div>
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
                                                        <td class="text-muted" id="name"></td>
                                                    </tr>
                                                    <!-- end tr -->
                                                    <tr>
                                                        <th class="fw-bold">
                                                            Email :</th>
                                                        <td class="text-muted" id="email"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="fw-bold">
                                                            Support Email :</th>
                                                        <td class="text-muted" id="s_email"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="fw-bold">
                                                            Telephone NO :</th>
                                                        <td class="text-muted" id="tele"></td>
                                                    </tr>
                                                    <!-- end tr -->
                                                    <tr>
                                                        <th class="fw-bold">
                                                            Mobile NO :</th>
                                                        <td class="text-muted" id="mobile_no"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="fw-bold">
                                                            Support Contact :</th>
                                                        <td class="text-muted" id="s_contact"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="fw-bold">
                                                            Address 1 :</th>
                                                        <td class="text-muted" id="add1"></td>
                                                    </tr>
                                                    <!-- end tr -->
                                                    <tr>
                                                        <th class="fw-bold">
                                                            Address 2 :</th>
                                                        <td class="text-muted" id="add2"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="fw-bold">
                                                            City :</th>
                                                        <td class="text-muted" id="city"></td>
                                                    </tr>
                                                    <!-- end tr -->
                                                    <tr>
                                                        <th class="fw-bold">
                                                            State :</th>
                                                        <td class="text-muted" id="state"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="fw-bold">
                                                            Country :</th>
                                                        <td class="text-muted" id="country"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="fw-bold">
                                                            Latitude :</th>
                                                        <td class="text-muted" id="lat"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="fw-bold">
                                                            Longitude :</th>
                                                        <td class="text-muted" id="long"></td>
                                                    </tr>
                                                    <!-- end tr -->
                                                    <tr>
                                                        <th class="fw-bold">
                                                            Registration NO :</th>
                                                        <td class="text-muted" id="reg_no"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="fw-bold">
                                                            Website :</th>
                                                        <td class="text-muted" id="website"></td>
                                                    </tr>
                                                    <!-- end tr -->
                                                    <tr>
                                                        <th class="fw-bold">
                                                            Doamin :</th>
                                                        <td class="text-muted" id="domain"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="fw-bold">
                                                            No Of Licenes :</th>
                                                        <td class="text-muted" id="n_o_licence"></td>
                                                    </tr>
                                                    <!-- end tr -->

                                                    <!-- end tr -->


                                                    <tr>
                                                        <th class="fw-bold">
                                                            Subscription :</th>
                                                        <td class="text-muted" id="sub"></td>
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
                    <div class="offcanvas offcanvas-end w-75" tabindex="-1" id="offcanvasRight"
                        aria-labelledby="offcanvasRightLabel">
                        <div class="offcanvas-header">
                            <h5 id="offcanvasRightLabel">Update Company Profile</h5>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <hr>

                        <div class="offcanvas-body">
                            <div class="row">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="profile-pic">
                                            <label class="-label" for="file">
                                                <span class="glyphicon glyphicon-camera"></span>
                                                <span>Change Image</span>
                                            </label>
                                            <input id="file" type="file" onchange="loadFile1(event)"
                                                style="background-color:black;" />
                                            <img src="" id="outputCompany" width="200" />
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="formrow-email" class="form-label">Enter Mobile Number</label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter Mobile Number" id="mobile_number">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="formrow-inputZip" class="form-label">Support Email</label>
                                            <input type="text" class="form-control" placeholder="Enter Email"
                                                id="support_email">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="formrow-inputCity" class="form-label">Registration
                                                Number</label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter Registration Number" id="reg_number">
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="formrow-inputZip" class="form-label">Telephone</label>
                                            <input type="text" class="form-control" placeholder="Enter Telephone"
                                                id="telephone">
                                        </div>
                                    </div>



                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="formrow-State" class="form-label">Support Contact</label>
                                            <input type="text" class="form-control" placeholder="Enter Contact"
                                                id="support_contact">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="formrow-Latitude" class="form-label">Website</label>
                                            <input type="text" class="form-control" placeholder="Enter Website"
                                                id="website_">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="formrow-State" class="form-label">Number of Licences</label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter Number of Licences" id="license">
                                        </div>
                                    </div>


                                    {{-- <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="formrow-Longitude" class="form-label">Communication Channel</label>
                                            <div class="col-md-12">
                                                <select class="form-control" name="choices-single-default" id="com_channel"
                                                    placeholder="Select Communication Channel">
                                                    <option value="Call">Call</option>
                                                    <option value="Website">SMS</option>
                                                    <option value="Email">Email</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div> --}}

                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="formrow-city" class="form-label">Domain</label>
                                            <div class="col-md-12">
                                                <select class="form-control" id="domainS"
                                                    placeholder="Select Domain">

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="formrow-Country" class="form-label">Subscription Package
                                                <i class="bx bxs-info-circle" data-bs-toggle="tooltip"
                                                    data-bs-placement="right"
                                                    data-bs-title="Trial Period Is Only Eligible For 15 Days!">

                                                </i>

                                            </label>
                                            <select class="form-control" placeholder="Select Subscription Package"
                                                id="subscription">
                                                <option value=""></option>


                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="formrow-Country" class="form-label">Country</label>
                                            <input type="text" class="form-control" placeholder="Enter Country"
                                                id="country_">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="formrow-inputZip" class="form-label">State/Province</label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter State/Province" id="state_">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="formrow-State" class="form-label">City</label>
                                            <input type="text" class="form-control" placeholder="Enter City"
                                                id="city_">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="formrow-State" class="form-label">Address 1</label>
                                            <input type="text" class="form-control" placeholder="Enter Address 1"
                                                id="address1">
                                        </div>
                                    </div>


                                    {{-- <div class="row"> --}}
                                    {{-- <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="formrow-Country" class="form-label">Data Lines</label>
                                            <input type="text" class="form-control" placeholder="Enter Data Line" id="datalines">
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="formrow-inputZip" class="form-label">Telebox</label>
                                            <input type="text" class="form-control" placeholder="Enter Telebox" id="telebox">
                                        </div>
                                    </div> --}}

                                    {{-- </div> --}}


                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="formrow-Country" class="form-label">Address 2</label>
                                            <input type="text" class="form-control" placeholder="Enter Address 2"
                                                id="address2">
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="formrow-inputZip" class="form-label">Latitude</label>
                                            <input type="text" class="form-control" placeholder="Enter Latitude"
                                                id="lat_">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="formrow-State" class="form-label">Longitude</label>
                                            <input type="text" class="form-control" placeholder="Enter Longitude"
                                                id="lng">
                                        </div>
                                    </div>

                                    <div class="col-md-12">


                                        <input id="pac-input" class="form-control w-75" type="text"
                                            placeholder="Search Box" />

                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">

                                            <div class="custom-file">
                                                <label for="map">Select Location on
                                                    Map</label>

                                                <div id="map" style="height: 200px;width:100%;"></div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-12">
                                <div class="mb-3 row">
                                    <div class="col-md-10">
                                        <input class="form-control" type="hidden" id="hiddenid" name="hidden"
                                            value="0">
                                        <input class="form-control" type="hidden" id="hidden_file" name="hidden"
                                        >
                                        <!-- <input type="hidden" id="postId" name="postId" value="34657" /> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3 row">
                                    <label for="example-text-input" class="col-md-10 col-form-label"></label>
                                    <div class="col-md-2">

                                        <button type="button" onclick="submit()"
                                            class="btn btn-primary waves-effect waves-light">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>



                  


                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


        </div>
        <!-- end main content-->
        <!-- end main content-->


        <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel"
                                        aria-hidden="true" data-bs-scroll="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <!-- <h5 class="modal-title" id="myModalLabel">Create Impact</h5> -->
                                                    <h5 class="modal-title" id="myModalLabel">
                                                        <h5 id="labelc">Import </h5>
                                                        <br>
                                                        <h5> Excel</h5>
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body" style="padding: 20px 40px 20px 20px;">
                                                    <div class="row">

                                                        <form method="POST" class="mb-4"
                                                            enctype="multipart/form-data"
                                                            action="{{ route('bu_import') }}">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-12 mb-3">
                                                                    <h4 class="card-title mb-0 pt-3">Bussiness
                                                                        Units
                                                                    </h4>

                                                                </div>
                                                                <div class="col-md-10">
                                                                    <input type="file" class="form-control"
                                                                        name="excel_file">

                                                                </div>
                                                                <div class="col-md-2"> <button type="submit"
                                                                        class="btn btn-soft-primary">Upload</button>
                                                                </div>

                                                            </div>


                                                        </form>



                                                        <br>

                                                        <form method="POST" class="mb-4"
                                                            enctype="multipart/form-data" action="{{ route('users') }}">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-12 mb-3">
                                                                    <h4 class="card-title mb-0 pt-3">Users
                                                                    </h4>

                                                                </div>
                                                                <div class="col-md-10">
                                                                    <input type="file" class="form-control"
                                                                        name="excel_file">

                                                                </div>
                                                                <div class="col-md-2"> <button type="submit"
                                                                        class="btn btn-soft-primary">Upload</button>
                                                                </div>

                                                            </div>


                                                        </form>

                                                        <br>

                                                        <form method="POST" class="mb-4"
                                                            enctype="multipart/form-data" action="{{ route('group') }}">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-12 mb-3">
                                                                    <h4 class="card-title mb-0 pt-3">Group
                                                                        Designation
                                                                    </h4>

                                                                </div>
                                                                <div class="col-md-10">
                                                                    <input type="file" class="form-control"
                                                                        name="excel_file">

                                                                </div>
                                                                <div class="col-md-2"> <button type="submit"
                                                                        class="btn btn-soft-primary">Upload</button>
                                                                </div>

                                                            </div>


                                                        </form>
                                                        <br>
                                                        <form method="POST" class="mb-4"
                                                            enctype="multipart/form-data"
                                                            action="{{ route('tickets') }}">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-12 mb-3">
                                                                    <h4 class="card-title mb-0 pt-3">Tickets
                                                                    </h4>

                                                                </div>

                                                                <div class="col-md-10">
                                                                    <input type="file" class="form-control"
                                                                        name="excel_file">

                                                                </div>
                                                                <div class="col-md-2"> <button type="submit"
                                                                        class="btn btn-soft-primary">Upload</button>
                                                                </div>

                                                            </div>


                                                        </form>



                                                    </div>
                                                </div>

                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div>
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
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNyJWb04pByaU1CTmimoWNl3b86VV6qZ8&callback=initAutocomplete&libraries=places&v=weekly"
    defer></script>
<script>
    var domain, subscription;


    $.ajax({
        url: "api/domains",
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            domain = new Choices("#domainS", {
                removeItemButton: !0,
            });

            console.log(response);
            domain.setChoices(response,
                'id',
                'title',
                false, );
        }
    });

    $.ajax({

        url: "api/subscription-packages",
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            subscription = new Choices("#subscription", {

                removeItemButton: !0,
            });
            console.log(response);
            subscription.setChoices(response,
                'id',
                'title',
                false, );
        }
    });
    // $(document).ready(function() {
    //     $('#layout-mode-dark').attr('checked', true);
    //
    function initAutocomplete() {
        const map = new google.maps.Map(document.getElementById("map"), {
            center: {
                lat: -33.8688,
                lng: 151.2195
            },
            zoom: 13,
            mapTypeId: "roadmap",
        });
        // Create the search box and link it to the UI element.
        const input = document.getElementById("pac-input");
        const searchBox = new google.maps.places.SearchBox(input);

        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        // Bias the SearchBox results towards current map's viewport.
        map.addListener("bounds_changed", () => {
            searchBox.setBounds(map.getBounds());
        });

        let markers = [];

        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener("places_changed", () => {
            const places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }

            // Clear out the old markers.
            markers.forEach((marker) => {
                marker.setMap(null);
            });
            markers = [];

            // For each place, get the icon, name and location.
            const bounds = new google.maps.LatLngBounds();

            places.forEach((place) => {
                if (!place.geometry || !place.geometry.location) {
                    console.log("Returned place contains no geometry");
                    return;
                }
                const lat = place.geometry.location.lat();
                const lng = place.geometry.location.lng();
                let city = "";
                let state = "";
                let country = "";
                let localAddress = "";
                let houseNumber = "";

                // Extract address components for city, state, country, local address, and house number.
                place.address_components.forEach((component) => {
                    if (component.types.includes("locality")) {
                        city = component.long_name;
                    } else if (component.types.includes("administrative_area_level_1")) {
                        state = component.long_name;
                    } else if (component.types.includes("country")) {
                        country = component.long_name;
                    } else if (component.types.includes("neighborhood") || component.types
                        .includes("sublocality_level_1")) {
                        localAddress = component.long_name;
                    } else if (component.types.includes("street_number")) {
                        houseNumber = component.long_name;
                    } else if (component.types.includes("route")) {
                        houseNumber += " " + component.long_name;
                    }
                });
                $('#city').val(city);
                $('#state').val(state);
                $('#country').val(country);
                $('#address2').val(localAddress);
                $('#address1').val(houseNumber);
                $('#lat').val(lat);
                $('#lng').val(lng);

                console.log("City: " + city);
                console.log("State: " + state);
                console.log("Country: " + country);
                console.log("Local Address: " + localAddress);
                console.log("House Number: " + houseNumber);
                console.log("Latitude: " + lat);
                console.log("Longitude: " + lng);


                const icon = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25),
                };

                // Create a marker for each place.
                markers.push(
                    new google.maps.Marker({
                        map,
                        icon,
                        title: place.name,
                        position: place.geometry.location,
                    }),
                );
                console.log(place.formatted_address)
                if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });
            map.fitBounds(bounds);
        });
    }

    window.initAutocomplete = initAutocomplete;
    // });
    function showcanvas() {
        $('#offcanvasRight').offcanvas('show');
        // $('#name').val(response[0]['name']);
        // $('#email').val(response[0]['email']);
        const settings = {
            "async": true,
            "crossDomain": true,
            "url": "api/company_profile/{{ Auth::user()->company_id }}",
            "method": "GET",

        };

        $.ajax(settings).done(function(response) {
            console.log(response);

        $('#support_email').val(response[0]['support_email']);
        $('#telephone').val(response[0]['telephon']);
        $('#mobile_number').val(response[0]['mobile']);
        $('#support_contact').val(response[0]['support_contact']);
        $('#address1').val(response[0]['address_1']);
        $('#address2').val(response[0]['address_2']);
        $('#city_').val(response[0]['city_id']);
        $('#state_').val(response[0]['state_id']);
        $('#country_').val(response[0]['country_id']);
        $('#lat_').val(response[0]['latitude']);
        $('#lng').val(response[0]['longitude']);
        $('#reg_number').val(response[0]['registration_number']);
        $('#website_').val(response[0]['website']);
        domain.setChoiceByValue(response[0]['domain_id']);
        $('#license').val(response[0]['licences']);
        subscription.setChoiceByValue(response[0]['subscription_id']);
        // $("#profile_id").val(response[0]['id']);
        var ret = response[0]['profile'].replace("documents/", "");
        
        if (ret != "") {
            var image_sm = document.getElementById('outputCompany').src =
                "http://demo.p2ptrack360.com/api/profile/" + ret;
        }

    });


    }

    var loadFile = function(event) {
        var image = document.getElementById("output");
        image.src = URL.createObjectURL(event.target.files[0]);
    };
    var loadFile1 = function(event) {
        var image = document.getElementById("outputCompany");
        image.src = URL.createObjectURL(event.target.files[0]);
    };


    function fetchtable() {
        const settings = {
            "async": true,
            "crossDomain": true,
            "url": "api/company_profile/{{ Auth::user()->company_id }}",
            "method": "GET",
            "headers": {
                "Accept": "*/*",
                "User-Agent": "Thunder Client (https://www.thunderclient.com)"
            }
        };

        $.ajax(settings).done(function(response) {
            console.log(response);

            $('#name').html(response[0]['name']);
            $('#email').html(response[0]['email']);
            $('#s_email').html(response[0]['support_email']);
            $('#tele').html(response[0]['telephon']);
            $('#mobile_no').html(response[0]['mobile']);
            $('#s_contact').html(response[0]['support_contact']);
            $('#add1').html(response[0]['address_1']);
            $('#add2').html(response[0]['address_2']);
            $('#city').html(response[0]['city_id']);
            $('#state').html(response[0]['state_id']);
            $('#country').html(response[0]['country_id']);
            $('#lat').html(response[0]['latitude']);
            $('#long').html(response[0]['longitude']);
            $('#reg_no').html(response[0]['registration_number']);
            $('#website').html(response[0]['website']);
            $('#domain').html(response[0]['domain']);
            $('#n_o_licence').html(response[0]['licences']);
            $('#sub').html(response[0]['subscription']);
            $('#hidden_file').val(response[0]['profile']);
            $('#hiddenid').val(response[0]['id']);
            // $("#profile_id").val(response[0]['id']);
            var ret = response[0]['profile'].replace("documents/", "");

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
                Swal.fire(
                    'Server Error!',
                    'Profile Not updated',
                    'error'
                )

                // console.log("Request failed with status code: " + xhr.status);
            }
        });

    }
    function submit(){
        var domain_id = $('#domainS').find(":selected").val();
        var subscription_id = $('#subscription').find(":selected").val();


        var form=  new FormData();
            form.append("telephon", $('#telephone').val());
            form.append("id", $('#hiddenid').val());
            form.append("mobile", $('#mobile_number').val());
            form.append("address_1",$('#address1').val());
            form.append("address_2", $('#address2').val());
            form.append("city_id", $('#city_').val());
            form.append("state_id", $('#state_').val());
            form.append("country_id",$('#country_').val());
            form.append("registration_number", $('#reg_number').val());
      
            form.append("website_", $('#website_').val());
            form.append("domain_id", domain_id);
            form.append("licences",$('#license').val());
            form.append("latitude", $('#lat_').val());
            form.append("longitude", $('#lng').val());
            form.append("support_email", $('#support_email').val());
            form.append("support_contact", $('#support_contact').val());
            form.append("subscription_id", subscription_id);
            var file=document.getElementById("file").files[0];
            console.log(file)
            if(file){
                console.log('if')
                form.append("profile", file);

            }
            else{
                console.log('else')

                form.append("profile", $('#hidden_file').val());

            }


            var settings = {
                "url": "api/com_pro_update",
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




                        Swal.fire(
                            'Success!',
                            'Profile Updated Successfully',
                            'success'
                        )
                        $('#offcanvasRight').offcanvas('hide');
                        fetchtable();
                    },
                    // Add more status code handlers as needed
                },
                success: function(data) {
                    // $('#myModal').reset();
                    // Additional success handling if needed

                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log(xhr)
                    Swal.fire(
                        'Server Error!',
                        'Profile Not Updated',
                        'error'
                    )

                    // console.log("Request failed with status code: " + xhr.status);
                }
            });
    }
</script>



<!-- Mirrored from themesdesign.in/webadmin/layouts/contacts-profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 23 Jul 2023 18:05:20 GMT -->

</html>
