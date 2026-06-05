<!doctype html>
<html lang="en">


<!-- Mirrored from themesdesign.in/webadmin/layouts/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 23 Jul 2023 18:04:41 GMT -->

<head>

    <meta charset="utf-8" />
    <title>Company | Service Manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" /> --}}
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    @include('partials.style')
    <Style>
        /*
.offcanvas-body [data-bs-title="check"] {
      z-index: 9999; /* or a higher value based on your layout */
        /* } */
        .tooltip {
            z-index: 9999;
        }

        .pac-container {
            z-index: 9999;
            /* Adjust the z-index value as needed */
        }

        input[switch]:checked+label:after {
            left: 70px;
            background-color: #f5f6f8;
        }

        #dropbox {
            border: 2px dashed #ccc;
            width: 100%;
            height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            position: relative;
            over-flow: hidden;
        }

        #image-preview-container {
            display: none;
            max-width: 100%;
            max-height: 200px;
            position: relative;

        }

        #image-preview {
            max-width: 200px;
            max-height: 150px;
            border-radius: 30px;

        }

        #image-preview:hover {
            opacity: 0.3;
            transition: 0.5s;
        }

        #remove-button {
            display: none;
            background: #ff0000;
            color: #fff;
            border: none;
            border-radius: 50%;
            padding: 5px 10px;
            cursor: pointer;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        #image-name {
            display: none;
            text-align: center;
            margin-top: 5px;
        }

        .btn-background {
            background-color: white;
            /* Example color for Copy button */
            color: black;
        }
        .switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  height: 20px;
  width: 48px;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 13px;
  width: 14px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

    </Style>
</head>


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
                <div id="liveAlertPlaceholder"></div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-2">

                                            <h4 class="card-title mb-0 pt-3">Company</h4>
                                        </div>
                                        <div class="col-md-6">
                                            {{-- <button type="button" class="btn btn-soft-primary waves-effect waves-light"  data-bs-toggle="modal" data-bs-target="#myModal">
                                                     Add New
                                                </button> --}}
                                            <button class="btn btn-soft-primary waves-effect waves-light" type="button" onclick="showcanvas()"><i class="bx bxs-add-to-queue font-size-16 align-middle me-2"></i>Add
                                                New</button>
                                            {{-- <button type="button" class="btn btn-primary waves-effect waves-light">Add New</button> --}}
                                        </div>
                                    </div>

                                </div><!-- end card header -->
                                <div class="card-body">
                                    <table id="myTable">
                                        <thead>
                                            <tr>
                                                <th>S.No </th>

                                                <th>Company Name</th>
                                                <th>Email</th>
                                                <th>No. Of Users</th>
                                                <th>Package</th>
                                                <th>Created At</th>
                                                <th>Edit</th>
                                                <th>Status</th>
                                                {{-- <th>Delete</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>


                    <!-- end row -->

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


        </div>
        <!-- end main content-->
        @include('partials.footer')
    </div>
    <!-- END layout-wrapper -->
    @include('partials.right_bar')
    <!-- Right Sidebar -->

    <!-- JAVASCRIPT -->
    <!-- right offcanvas -->
    <div class="offcanvas offcanvas-end w-75" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasRightLabel">Create Company</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <hr>

        <div class="offcanvas-body">
            <div class="row">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-firstname" class="form-label">Enter First Name</label>
                            <input type="text" class="form-control" placeholder="Enter First Name" id="first_name">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-firstname" class="form-label">Enter Middle Name</label>
                            <input type="text" class="form-control" placeholder="Enter Middle Name" id="middle_name">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-firstname" class="form-label">Enter Last Name</label>
                            <input type="text" class="form-control" placeholder="Enter Last Name" id="last_name">
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-email" class="form-label">Enter Mobile Number</label>
                            <input type="text" class="form-control" placeholder="Enter Mobile Number" id="mobile_number">
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-phone" class="form-label">Enter Company Name</label>
                            <input type="text" class="form-control" placeholder="Enter Company Name" id="company_name">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-inputCity" class="form-label">Enter Email</label>
                            <input type="text" class="form-control" placeholder="Enter Email" id="email">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-inputZip" class="form-label">Support Email</label>
                            <input type="text" class="form-control" placeholder="Enter Email" id="support_email">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-inputCity" class="form-label">Registration Number</label>
                            <input type="text" class="form-control" placeholder="Enter Registration Number" id="reg_number">
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-inputZip" class="form-label">Telephone</label>
                            <input type="text" class="form-control" placeholder="Enter Telephone" id="telephone">
                        </div>
                    </div>
                </div>
                <div class="row">


                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-State" class="form-label">Support Contact</label>
                            <input type="text" class="form-control" placeholder="Enter Contact" id="support_contact">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-Latitude" class="form-label">Website</label>
                            <input type="text" class="form-control" placeholder="Enter Website" id="website">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-State" class="form-label">Number of Licences</label>
                            <input type="text" class="form-control" placeholder="Enter Number of Licences" id="license">
                        </div>
                    </div>
                </div>

                <div class="row">

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
                                <select class="form-control" name="choices-single-default" id="domain" placeholder="Select Domain" onchange="addtional_fields(this.value)">

                                </select>
                            </div>
                        </div>
                    </div>




                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-Country" class="form-label">Subscription Package
                                <i class="bx bxs-info-circle" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Trial Period Is Only Eligible For 15 Days!">

                                </i>

                            </label>
                            <select class="form-control" placeholder="Select Subscription Package" id="subscription">
                                <option value=""></option>


                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-Country" class="form-label">Country</label>
                            <input type="text" class="form-control" placeholder="Enter Country" id="country">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-inputZip" class="form-label">State/Province</label>
                            <input type="text" class="form-control" placeholder="Enter State/Province" id="state">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-State" class="form-label">City</label>
                            <input type="text" class="form-control" placeholder="Enter City" id="city">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-State" class="form-label">Address 1</label>
                            <input type="text" class="form-control" placeholder="Enter Address 1" id="address1">
                        </div>
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
                <div class="row">

                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-Country" class="form-label">Address 2</label>
                            <input type="text" class="form-control" placeholder="Enter Address 2" id="address2">
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-inputZip" class="form-label">Latitude</label>
                            <input type="text" class="form-control" placeholder="Enter Latitude" id="lat">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-State" class="form-label">Longitude</label>
                            <input type="text" class="form-control" placeholder="Enter Longitude" id="lng">
                        </div>
                    </div>
                </div>

                <div class="row" id="newfields">
                </div>

                <div class="row">
                    <div class="col-md-12">


                        <input id="pac-input" class="form-control w-75" type="text" placeholder="Search Box" />

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
                <div class="row">
                    <div id="dropbox">
                        <p id="message">Drag and drop an image here (PNG, JPG, JPEG)</p>
                        <input type="file" id="fileInput" accept=".png, .jpg, .jpeg" style="display: none;">
                        <div id="image-preview-container">
                            <img id="image-preview">
                            <button id="remove-button" onclick="removeImage()">x</button>
                        </div>
                        <div id="image-name"></div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="mb-3 row">
                    <div class="col-md-10">
                        <input class="form-control" type="hidden" id="hidden" name="hidden" value="0">
                        <!-- <input type="hidden" id="postId" name="postId" value="34657" /> -->
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="mb-3 row">
                    <label for="example-text-input" class="col-md-10 col-form-label"></label>
                    <div class="col-md-2">

                        <button type="button" onclick="save()" class="btn btn-primary waves-effect waves-light">Save</button>
                    </div>
                </div>
            </div>
        </div>


    </div>
    @include('partials.script')
</body>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous">
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNyJWb04pByaU1CTmimoWNl3b86VV6qZ8&callback=initAutocomplete&libraries=places&v=weekly" defer></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
-->
<script> 
    var domain, table, subscription;



    function showcanvas() {
        var offcanvasRight = new bootstrap.Offcanvas(document.getElementById('offcanvasRight'));

        offcanvasRight.show();
    }

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
    $(document).ready(function() {
        // $('[data-bs-toggle="tooltip"]').tooltip();

        // var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        // var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        //     return new bootstrap.Tooltip(tooltipTriggerEl)})


        $("#addfield").click(function() {
            var newRowAdd =
                '<div id="row" class="row"><div class="input-group m-3">' +
                '<div class="col-3"><div class="input-group-prepend">' +
                '<button type="button" id="DeleteRow" class="btn btn-outline-danger waves-effect waves-light m-1">Delete</button>' +
                '<i class="bi bi-trash"></i></button></div> </div>' +
                '<div class="col-4"><div class="input-group-prepend m-1"><input class="form-control" type="text" placeholder="Additional Field"></div> </div><div class="col-1"></div>' +
                '<div class="col-4"><select class="form-control " data-trigger name="choices-single-default" id="choices-single-default" placeholder=""><option>String</option><option>Number</option><option>Text</option></select> </div> </div>' +
                '';

            $('#fields').append(newRowAdd);
            // alert("The paragraph was clicked.");
        });

        // new Choices("#com_channel", {
        //     removeItemButton: !0,
        // })

        domain = new Choices("#domain", {
            removeItemButton: !0,
        });

        subscription = new Choices("#subscription", {

            removeItemButton: !0,
        });

        $.ajax({
            url: "api/domains",
            type: 'GET',
            dataType: 'json',
            success: function(response) {

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

                console.log(response);
                subscription.setChoices(response,
                    'id',
                    'title',
                    false, );
            }
        });
        $("body").on("click", "#DeleteRow", function() {
            $(this).parents("#row").remove();
        })
        table = $('#myTable').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'copy',
                    text: '<i class="fas fa-copy"></i>',
                    titleAttr: 'Copy',
                    className: 'btn-background'

                },
                {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel"></i>',
                    titleAttr: 'Excel',
                    className: 'btn-background'

                },
                {
                    extend: 'csv',
                    text: '<i class="fas fa-file-csv"></i>',
                    titleAttr: 'CSV',
                    className: 'btn-background'

                },
                {
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf"></i>',
                    titleAttr: 'PDF',
                    className: 'btn-background'

                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i>',
                    titleAttr: 'Print',
                    className: 'btn-background'

                }
            ]


        });
        fetchtable();
    });

    function fetchtable() {
        var settings = {
            "url": "api/companies",
            "method": "GET",
            "timeout": 0,
        };

        $.ajax(settings).done(function(response) {
            console.log(response);
            table.clear().draw();
            $.each(response, function(index, data) {
                table.row.add([
                    index + 1,
                    data.name,
                    data.email,
                    '10',
                    'Silver Package',
                    data.created_at,
                    '<button type="button"id="edit" name="edit" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" onclick="editData(' +
                    data.id +
                    ')"  class="btn btn-soft-warning waves-effect waves-light"><i class="bx bx-edit-alt font-size-16 align-middle"></i></button>',
                    `<label class="switch">
    <input type="checkbox" ${data.active == 1 ? "checked" : ""} onchange="updatestatus(${data.id}, this)">
    <span class="slider round"></span>
</label>`,
                    // '<button type="button" id="delete" name="delete" onclick="deleteData(' +
                    // data.id +
                    // ')" class="btn btn-soft-danger waves-effect waves-light"><i class="bx bx-trash-alt font-size-16 align-middle"></i></button>'
                ]).draw(false);
            });
        });
    }

    function save() {
        var update_id = document.getElementById("hidden").value;

        if (update_id == 0) {
            // var settings = {
            //     "url": "api/companies",
            //     "method": "POST",
            //     "timeout": 0,
            //     "headers": {
            //         "Content-Type": "application/json"
            //     },
            //     "data": JSON.stringify({
            //         "name": document.getElementById("company_name").value,
            //         "email": document.getElementById("email").value,
            //         "telephon": document.getElementById("telephone").value,
            //         "mobile": document.getElementById("mobile_number").value,
            //         "address_1": document.getElementById("address1").value,
            //         "address_2": document.getElementById("address2").value,
            //         "city_id": document.getElementById("city").value,
            //         "state_id": document.getElementById("state").value,
            //         "country_id": document.getElementById("country").value,
            //         "zipcode": "321",
            //         "status": 1,
            //         "registration_number": document.getElementById("reg_number").value,
            //         "first_name": document.getElementById("first_name").value,
            //         "middle_name": document.getElementById("middle_name").value,
            //         "last_name": document.getElementById("last_name").value,
            //         "website": document.getElementById("website").value,
            //         "communication": "Com",
            //         "datalines": "dataline",
            //         "telebox": "Telebox",
            //         "profile" : document.getElementById("fileInput").files[0],
            //         "domain_id": document.getElementById("domain").value,
            //         "licences": document.getElementById("license").value,
            //         "latitude": document.getElementById("lat").value,
            //         "longitude": document.getElementById("lng").value,
            //         "support_email": document.getElementById("support_email").value,
            //         "support_contact": document.getElementById("support_contact").value,
            //         "subscription_id": document.getElementById("subscription").value,
            var form = new FormData();
            form.append("name", document.getElementById("company_name").value);
            form.append("email", document.getElementById("email").value);
            form.append("telephon", document.getElementById("telephone").value);
            form.append("mobile", document.getElementById("mobile_number").value);
            form.append("address_1", document.getElementById("address1").value);
            form.append("address_2", document.getElementById("address2").value);
            form.append("city_id", document.getElementById("city").value);
            form.append("state_id", document.getElementById("state").value);
            form.append("country_id", document.getElementById("country").value);
            form.append("zipcode", "321");
            form.append("status", "1");
            form.append("registration_number", document.getElementById("reg_number").value);
            form.append("first_name", document.getElementById("first_name").value);
            form.append("middle_name", document.getElementById("middle_name").value);
            form.append("last_name", document.getElementById("last_name").value);
            form.append("website", document.getElementById("website").value);
            form.append("communication", "com");
            form.append("datalines", "dataline");
            form.append("telebox", "Telebox");
            form.append("domain_id", document.getElementById("domain").value);
            form.append("licences", document.getElementById("license").value);
            form.append("latitude", document.getElementById("lat").value);
            form.append("longitude", document.getElementById("lng").value);
            form.append("support_email", document.getElementById("support_email").value);
            form.append("support_contact", document.getElementById("support_contact").value);
            form.append("subscription_id", document.getElementById("subscription").value);
            form.append("profile", document.getElementById("fileInput").files[0]);

            var settings = {
                "url": "api/companies",
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
                        // getemail=$('#email').val()

                        // var settings = {
                        //     "url": "api/sendbasicemail/"+getemail,
                        //     "method": "GET",
                        //     "timeout": 0,
                        // };

                        // $.ajax({
                        //     ...settings,
                        //     statusCode: {
                        //         200: function(response) {
                        //             alert('email Send successfully!');
                        //         }
                        //     }
                        // })

                        if ($('#newfields').children().length > 0) {
                            // The div has child elements
                            console.log("Div has children.");
                            var responseObject = JSON.parse(response);

                            // Access the "id" property
                            cid = responseObject.id;

                            // Iterate through input elements with class 'data-input'
                            $('.multi_text').each(function() {
                                var inputVal = $(this).val();
                                var dataId = $(this).data('id');
                                console.log('data-id ' + dataId);
                                var formdata = new FormData();
                                formdata.append("field_id", dataId);
                                formdata.append("domain_id", document.getElementById(
                                    "domain").value);
                                formdata.append("company_id", cid);
                                formdata.append("field_data", inputVal);
                                var settings = {
                                    "url": "api/domain_data",
                                    "method": "POST",
                                    "timeout": 0,
                                    "processData": false,
                                    "mimeType": "multipart/form-data",
                                    "contentType": false,
                                    "data": formdata
                                };

                                $.ajax(settings).done(function(response) {
                                    console.log(response);
                                }); // Get the value of the current input
                            });

                        } else {
                            // The div has no child elements
                            console.log("Div has no children.");
                        }

                        $('#offcanvasRight').offcanvas('hide');
                        $('#image-name').css('display', 'none');
                        $("#remove-button").css('display', 'none');

                        // domain.clearChoices();
                        // domain.setValue([0]);
                        $('#image-preview').attr('src', '');
                        // subscription.clearChoices();
                        // subscription.setValue([0]);

                        $("#offcanvasRight :input").val("");
                        // $('#offcanvasRight').reset();
                        console.log("Request was successful");
                        // document.getElementById('example-text-input').value = "";
                        document.getElementById('hidden').value = "";



                        Swal.fire(
                            'Success!',
                            'Company Created Successfully',
                            'success'
                        )
                    },

                },
                success: function(data) {
                    // $('#myModal').reset();
                    // Additional success handling if needed
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log(xhr)
                    console.log(textStatus)
                    console.log(errorThrown)

                    console.log(errorThrown);
                    Swal.fire(
                        'Server Error!',
                        'Company Not Created',
                        'error'
                    )

                    // console.log("Request failed with status code: " + xhr.status);
                }
            });
        } else {


            var settings = {
                "url": "api/companies/" + update_id + "",
                "method": "PUT",
                "timeout": 0,
                "headers": {
                    "Content-Type": "application/json"
                },
                "data": JSON.stringify({
                    "name": document.getElementById("company_name").value,
                    "email": document.getElementById("email").value,
                    "telephon": document.getElementById("telephone").value,
                    "mobile": document.getElementById("mobile_number").value,
                    "address_1": document.getElementById("address1").value,
                    "address_2": document.getElementById("address2").value,
                    "city_id": document.getElementById("city").value,
                    "state_id": document.getElementById("state").value,
                    "country_id": document.getElementById("country").value,
                    "registration_number": document.getElementById("reg_number")
                        .value,
                    "first_name": document.getElementById("first_name").value,
                    "middle_name": document.getElementById("middle_name").value,
                    "last_name": document.getElementById("last_name").value,
                    "website": document.getElementById("website").value,
                    "licences": document.getElementById("license").value,
                    "latitude": document.getElementById("lat").value,
                    "longitude": document.getElementById("lng").value,
                    "support_email": document.getElementById("support_email").value,
                    "support_contact": document.getElementById("support_contact")
                        .value,
                    "subscription_id": document.getElementById('subscription')
                        .value,
                    "domain_id": document.getElementById('domain').value,

                }),
            };

            $.ajax({
                ...settings,
                statusCode: {
                    200: function(response) {
                        console.log(response);
                        $('#offcanvasRight').modal('hide');

                        document.getElementById('hidden').value = "";
                        // console.log("Request was successful");


                        Swal.fire(
                            'Success!',
                            'Company updated Successfully',
                            'success'
                        )
                    },
                    // Add more status code handlers as needed
                },
                success: function(data) {
                    // Additional success handling if needed
                },
                error: function(xhr, textStatus, errorThrown) {
                    Swal.fire(
                        'Server Error!',
                        'Company Not updated',
                        'error'
                    )

                    // console.log("Request failed with status code: " + xhr.status);
                }
            });

        }
    }


    function editData(id) {
        // alert(id);
        var settings = {
            "url": "api/companies/" + id + "",
            "method": "GET",
            "timeout": 0,
        };

        $.ajax({
            ...settings,
            statusCode: {
                200: function(response) {
                    // console.log(response[0]['title']);
                    document.getElementById('hidden').value = response[0]['id'];
                    console.log(response[0]['id'])
                    document.getElementById('company_name').value = response[0]['name'];
                    document.getElementById('email').value = response[0]['email'];
                    document.getElementById('telephone').value = response[0][
                        'telephon'
                    ];
                    document.getElementById('mobile_number').value = response[0][
                        'mobile'
                    ];
                    document.getElementById('address1').value = response[0][
                        'address_1'
                    ];
                    document.getElementById('address2').value = response[0][
                        'address_2'
                    ];
                    document.getElementById('city').value = response[0]['city_id'];
                    document.getElementById('state').value = response[0]['state_id'];
                    document.getElementById('country').value = response[0][
                        'country_id'
                    ];
                    document.getElementById('reg_number').value = response[0][
                        'registration_number'
                    ];
                    document.getElementById('first_name').value = response[0][
                        'first_name'
                    ];
                    document.getElementById('middle_name').value = response[0][
                        'middle_name'
                    ];
                    document.getElementById('last_name').value = response[0][
                        'last_name'
                    ];
                    document.getElementById('website').value = response[0]['website'];
                    document.getElementById('license').value = response[0]['licences'];
                    document.getElementById('lat').value = response[0]['latitude'];
                    document.getElementById('lng').value = response[0]['longitude'];
                    document.getElementById('support_email').value = response[0][
                        'support_email'
                    ];
                    document.getElementById('support_contact').value = response[0][
                        'support_contact'
                    ];

                    document.getElementById('domain').value = response[0]['domain_id'];
                    // document.getElementById('subscription').value = response[0]['subscription_id'];
                    console.log(response[0]['domain_id'])
                    console.log('sb ' + response[0]['subscription_id'])

                    subscription.setChoiceByValue(response[0]['subscription_id'])
                    domain.setChoiceByValue(response[0]['domain_id'])



                    // $("#parent").val(response[0]['marketing_manager']);
                    // $("#store").val(response[0]['store_manager']);
                    // $('#myModal').modal('show');
                    // document.getElementById("labelc").innerHTML = 'Update'


                },
                // Add more status code handlers as needed
            },
            success: function(data) {
                // Additional success handling if needed
            },
            error: function(xhr, textStatus, errorThrown) {
                Swal.fire(
                    'Server Error!',
                    '',
                    'error'
                )

                // console.log("Request failed with status code: " + xhr.status);
            }
        });

    }

    function deleteData(id) {

        // alert(id);
        var settings = {
            "url": "api/companies/" + id + "",
            "method": "DELETE",
            "timeout": 0,
        };

        $.ajax({
            ...settings,
            statusCode: {
                200: function(response) {
                    console.log(response);
                    // $('#myModal').modal('hide');
                    // console.log("Request was successful");
                    fetchtable();
                    Swal.fire(
                        'Success!',
                        'Company Deleted Successfully',
                        'success'
                    )
                },
                // Add more status code handlers as needed
            },
            success: function(data) {
                // Additional success handling if needed
            },
            error: function(xhr, textStatus, errorThrown) {
                Swal.fire(
                    'Server Error!',
                    'Company Not Deleted',
                    'error'
                )

                // console.log("Request failed with status code: " + xhr.status);
            }
        });
    };
    const dropbox = document.getElementById('dropbox');
    const imagePreviewContainer = document.getElementById('image-preview-container');
    const imagePreview = document.getElementById('image-preview');
    const removeButton = document.getElementById('remove-button');
    const imageName = document.getElementById('image-name');

    function showDisplayElements() {
        imagePreviewContainer.style.display = 'block';
        removeButton.style.display = 'block';
        imageName.style.display = 'block';
        message.style.display = 'none';
    }

    function updateImageName(file) {
        imageName.textContent = file.name;
    }

    dropbox.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropbox.style.backgroundColor = '#f2f2f2';
    });

    dropbox.addEventListener('dragleave', () => {
        dropbox.style.backgroundColor = '';
    });

    dropbox.addEventListener('drop', (e) => {
        e.preventDefault();
        dropbox.style.backgroundColor = '';

        const file = e.dataTransfer.files[0];
        if (file) {
            const allowedExtensions = ['image/png', 'image/jpg', 'image/jpeg'];
            if (allowedExtensions.includes(file.type)) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    imagePreview.src = event.target.result;
                    updateImageName(file);
                    showDisplayElements();
                };
                reader.readAsDataURL(file);
            } else {
                alert('Invalid file type. Please upload a PNG, JPG, or JPEG image.');
            }
        }
    });

    // Open file input when clicking the dropbox
    dropbox.addEventListener('click', () => {
        document.getElementById('fileInput').click();
    });

    // Handle file input change event
    document.getElementById('fileInput').addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            const allowedExtensions = ['image/png', 'image/jpg', 'image/jpeg'];
            if (allowedExtensions.includes(file.type)) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    imagePreview.src = event.target.result;
                    updateImageName(file);
                    showDisplayElements();
                    messages = $('#message').text(
                        'Drag and drop an image here (PNG, JPG, JPEG)');


                };
                reader.readAsDataURL(file);
            } else {
                messages = $('#message').html(
                    '<p style="color:red;">Invalid file type. Please upload a PNG, JPG, or JPEG image.</p>'
                );

            }
        }
    });


    function removeImage() {
        imagePreviewContainer.style.display = 'none';
        removeButton.style.display = 'none';
        imageName.style.display = 'none';
        message.style.display = 'block';
        document.getElementById('fileInput').value = null;
    }

    function addtional_fields(id) {

        $('#newfields').empty()
        console.log("id" + id);
        var settings = {
            "url": "api/domain_field/" + id + "",
            "method": "GET",
            "timeout": 0,
        };

        $.ajax(settings).done(function(response) {
            console.log(response);
            console.log("id" + id);
            // alert("id" + id)
            for (i = 0; i < response.length; i++) {
                console.log(response[i]['name']);
                var field_type;
                if (response[i]['type'] == "Text") {
                    field_type = "text";
                    var newrow =
                        '<div class="col-6">' +
                        ' <label for="formrow-inputState" class="form-label">' + response[i][
                            'name'
                        ] +
                        '</label>' +
                        ' <input name="name2[]" class="form-control multi_text" id="' + i +
                        '" data-id="' +
                        response[i]
                        ['id'] + '" type="' + field_type + '" placeholder="' + response[i][
                            'name'
                        ] +
                        '"></div>';

                } else if (response[i]['type'] == "String") {
                    field_type = "text";
                    var newrow =
                        '<div class="col-6">' +
                        ' <label for="formrow-inputState" class="form-label">' + response[i][
                            'name'
                        ] +
                        '</label>' +
                        ' <input name="name2[]" class="form-control multi_text" id="' + i +
                        '" data-id="' +
                        response[i]
                        ['id'] + '" type="' + field_type + '" placeholder="' + response[i][
                            'name'
                        ] +
                        '"></div>';

                } else if (response[i]['type'] == "Number") {
                    field_type = "number";
                    var newrow =
                        '<div class="col-6">' +
                        ' <label for="formrow-inputState" class="form-label">' + response[i][
                            'name'
                        ] +
                        '</label>' +
                        ' <input name="name2[]" class="form-control multi_text" id="' + i +
                        '" data-id="' +
                        response[i]
                        ['id'] + '"  type="' + field_type + '" placeholder="' + response[i][
                            'name'
                        ] +
                        '"></div>';

                } else if (response[i]['type'] == "Boolean") {
                    field_type = "Select";
                    var newrow =
                        '<div class="col-6">' +
                        '<label for="formrow-inputState" class="form-label">' + response[i][
                            'name'
                        ] +
                        '</label>' +
                        '<select name="name2[]" id="' + i + '" data-id="' + response[i]['id'] +
                        '" class="form-control multi_text" placeholder="' + response[i][
                            'name'
                        ] + '">' +
                        '<option value="1">Yes</option>' +
                        '<option value="0">No</option>' +
                        '</select></div>'
                } else {
                    field_type = "text";
                    var newrow =
                        '<div class="col-6">' +
                        ' <label for="formrow-inputState" class="form-label">' + response[i][
                            'name'
                        ] +
                        '</label>' +
                        ' <input name="name2[]" class="form-control multi_text" id="' + i +
                        '" data-id="' +
                        response[i]
                        ['id'] + '"  type="' + field_type + '" placeholder="' + response[i][
                            'name'
                        ] +
                        '"></div>';

                }
                //   document.getElementById('modalbody').innerHTML(newrow);
                $('#newfields').append(newrow)
            }
        });
    }
    function updatestatus(id, element) {
    var isChecked = $(element).prop('checked') ? 1 : 0;

    var form = new FormData();
    form.append("id", id);
    form.append("active", isChecked);

    $.ajax({
        url: "api/updatecompstatus",
        method: "POST",
        data: form,
        processData: false,
        contentType: false,
        mimeType: "multipart/form-data",
        timeout: 0,
        success: function(response) {
            Swal.fire(
                'Success!',
                'Status updated successfully',
                'success'
            );
            fetchtable();

        },
        error: function(xhr, textStatus, errorThrown) {
            Swal.fire(
                'Server Error!',
                'Failed to update status',
                'error'
            );
            // console.error("Request failed:", xhr.status, textStatus, errorThrown);
        }
    });
}
</script>

</html>