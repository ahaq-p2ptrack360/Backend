<!doctype html>
<html lang="en">


<!-- Mirrored from themesdesign.in/webadmin/layouts/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 23 Jul 2023 18:04:41 GMT -->

<head>

    <meta charset="utf-8" />
    <title>Customers | Service Manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" /> --}}
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    @include('partials.style')
</head>
<style>
    .pac-container {
        z-index: 9999;
        /* Adjust the z-index value as needed */
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
    
    .btn-background {
    background-color: white; /* Example color for Copy button */
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
                <div id="liveAlertPlaceholder"></div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-2">

                                            <h4 class="card-title mb-0 pt-3">Accounts</h4>
                                        </div>
                                        <div class="col-md-6">
                                            {{-- <button type="button" class="btn btn-soft-primary waves-effect waves-light"  data-bs-toggle="modal" data-bs-target="#myModal">
                                                     Add New
                                                </button> --}}
                                            <button class="btn btn-soft-primary waves-effect waves-light" type="button"
                                                data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                                                aria-controls="offcanvasRight"><i
                                                    class="bx bxs-add-to-queue font-size-16 align-middle me-2"></i>Add
                                                New</button>
                                            {{-- <button type="button" class="btn btn-primary waves-effect waves-light">Add New</button> --}}
                                        </div>
                                    </div>

                                </div><!-- end card header -->
                                <div class="card-body">
                                    <table id="myTable">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Address</th>
                                                <th>City</th>
                                                <th>State</th>
                                                <th>Country</th>
                                                <th>Created At</th>
                                                <th>Edit</th>
                                                <th>Status</th>
                                                {{-- <th>DELETE</th> --}}
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
    <div class="offcanvas offcanvas-end w-50" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 class="modal-title" id="myModalLabel">
                <h5 id="labelc">Create Account</h5>

            </h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <hr>
        <div class="offcanvas-body">
            <div class="row">
                <div class="row">
                    <div class="mb-3 row">
                        <div class="profile-pic">
                            <label class="-label" for="file">
                                <span class="glyphicon glyphicon-camera"></span>
                                <span>Change Image</span>
                            </label>
                            <input id="file" type="file" onchange="loadFile(event)"
                                style="background-color:black;" />
                            <img src="{{ asset('assets/images/product.png') }}" id="output" width="200" />
                        </div>

                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-firstname" class="form-label">First Name</label>
                            <input type="text" class="form-control" placeholder="Enter First Name" id="first_name">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-email" class="form-label">Last Name</label>
                            <input type="text" class="form-control" placeholder="Enter Last Name" id="last_name">
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-email" class="form-label">Email</label>
                            <input type="text" class="form-control" placeholder="Enter Email" id="email">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-password" class="form-label">Phone No</label>
                            <input type="text" class="form-control" placeholder="Enter Phone No" id="phone_no">
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-password" class="form-label">Address</label>
                            <input type="text" class="form-control" placeholder="Enter Address" id="address">
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-password" class="form-label">City</label>
                            <input type="text" class="form-control" placeholder="Enter City" id="city">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-password" class="form-label">State</label>
                            <input type="text" class="form-control" placeholder="Enter State" id="state">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-password" class="form-label">Country</label>
                            <input type="text" class="form-control" placeholder="Enter Country" id="country">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-inputZip" class="form-label">Business Unit</label>
                            <div class="col-md-12">
                                <select class="form-control" id="bu"
                                    placeholder="This is a search placeholder">

                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="row">
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
                {{-- <div class="col-12">
                    <div class="mb-3 row">

                        <!-- <div>
                            <button type="button" class="btn btn-primary waves-effect waves-light" style="
                            height: 35px;
                            width: 100px;
                            margin-bottom: 10px;
                            font-size: small;
                        ">Select
                                all</button>
                            <button type="button" class="btn btn-primary waves-effect waves-light" style="
                            height: 35px;
                            width: 100px;
                            margin-bottom: 8px;
                            font-size: small;
                        ">Deselect
                                all</button>
                        </div> -->

                    </div>
                </div> --}}
                <!-- <div class="card-body">
                    <div>
                        <form action="#" class="dropzone dz-clickable">

                            <div class="dz-message needsclick">
                                <div class="mb-3">
                                    <i class="display-4 text-muted mdi mdi-cloud-upload"></i>
                                </div>

                                <h4>Drop files here or click to upload.</h4>
                            </div>
                        </form>
                    </div>
                </div> -->
                <div class="col-12">
                    <div class="mb-3 row">
                        {{-- <label for="example-text-input" class="col-md-2 col-form-label">Domain Members</label> --}}
                        <div class="col-md-6">
                            <div id="fields">
                                <input class="form-control" type="hidden" id="hidden" name="hidden"
                                    value="0">
                            </div>
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

    @include('partials.script')
</body>
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNyJWb04pByaU1CTmimoWNl3b86VV6qZ8&callback=initAutocomplete&libraries=places&v=weekly"
    defer></script>
<script>
    // alert({{Auth::user()->company_id}})
    var table;
    var type;
    var select_bu, subtype_s;
    var loadFile = function(event) {
        var image = document.getElementById("output");
        image.src = URL.createObjectURL(event.target.files[0]);
    };

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
                $('#address').val(localAddress);


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

        select_bu = new Choices("#bu", {
            removeItemButton: !0,
        })
        // $.ajax({
        //     url: ("{{ Auth::user()->company_id == 0 }}"?"api/designations":"api/designations/company/{{ Auth::user()->company_id }}"),
        //     type: 'GET',
        //     dataType: 'json',
        //     success: function(response) {
        //         type = new Choices("#type", {
        //             removeItemButton: !0,
        //         })
        //         type.clearChoices();
        //         console.log(response);
        //         type.setChoices(response,
        //             'id',
        //             'title',
        //             false, );
        //     }
        // });
        $.ajax({
            url: "{{ Auth::user()->company_id == 0 }}" ? "api/business_units" :
                "api/company_customer_r/{{ Auth::user()->company_id }}",
            type: 'GET',
            dataType: 'json',
            success: function(response) {

                select_bu.clearChoices();
                console.log(response);
                select_bu.setChoices(response,
                    'id',
                    'name',
                    false, );
            }
        });


        // $("#addfield").click(function() {
        //     var newRowAdd =
        //         '<div id="row" class="row"><div class="input-group m-3">' +
        //         '<div class="col-3"><div class="input-group-prepend">' +
        //         '<button type="button" id="DeleteRow" class="btn btn-outline-danger waves-effect waves-light m-1">Delete</button>' +
        //         '<i class="bi bi-trash"></i></button></div> </div>' +
        //         '<div class="col-4"><div class="input-group-prepend m-1"><input class="form-control" type="text" placeholder="Additional Field"></div> </div><div class="col-1"></div>' +
        //         '<div class="col-4"><select class="form-control " data-trigger name="choices-single-default" id="choices-single-default" placeholder=""><option>String</option><option>Number</option><option>Text</option></select> </div> </div>' +
        //         '';

        //     $('#fields').append(newRowAdd);
        //     // alert("The paragraph was clicked.");
        // });


        // $("body").on("click", "#DeleteRow", function() {
        //     $(this).parents("#row").remove();
        // })
        table = $('#myTable').DataTable({
            dom: 'Bfrtip',


            buttons: [{
                    extend: 'copy',
                    text: '<i class="fas fa-copy"></i>',
                    titleAttr: 'Copy',
                    className:'btn-background'

                },
                {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel"></i>',
                    titleAttr: 'Excel',
                    className:'btn-background'

                },
                {
                    extend: 'csv',
                    text: '<i class="fas fa-file-csv"></i>',
                    titleAttr: 'CSV',
                    className:'btn-background'

                },
                {
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf"></i>',
                    titleAttr: 'PDF',
                    className:'btn-background'

                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i>',
                    titleAttr: 'Print',
                    className:'btn-background'

                }]

        });
        fetchtable();
    });



    function fetchtable() {


        var settings = {
            "url": ("{{ Auth::user()->company_id == 0 }}" ? "api/super_admin_customer" :
                "api/customers/{{ Auth::user()->company_id }}"),
            "method": "GET",
            "timeout": 0,
        };

        $.ajax(settings).done(function(response) {
            console.log(response);
            table.clear().draw();
            $.each(response, function(index, data) {
                table.row.add([
                    index + 1,
                    data.first_name,
                    data.last_name,
                    data.email,
                    data.phone_no,
                    data.address,
                    data.city,
                    data.state,
                    data.country,
                    data.created_at,
                    '<button type="button"id="edit" name="edit" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"  onclick="editData(' +
                    data.id +
                    ')"  class="btn btn-soft-warning waves-effect waves-light"><i class="bx bx-edit-alt font-size-16 align-middle"></i></button>',
                    `<label class="switch">
    <input type="checkbox" ${data.active == 1 ? "checked" : ""} onchange="updatestatus(${data.id}, this)">
    <span class="slider round"></span>
</label>`
                    // '<button type="button" id="delete" name="delete" onclick="deleteData(' +
                    // data.id +
                    // ')" class="btn btn-soft-danger waves-effect waves-light"><i class="bx bx-trash-alt font-size-16 align-middle"></i></button>'
                ]).draw(false);
            });
        });
    }


    function submit() {
        var update_id = document.getElementById("hidden").value;
        console.log(update_id);
        if (update_id == 0) {
            var form = new FormData();
            form.append("first_name", document.getElementById("first_name").value);
            form.append("last_name", document.getElementById("last_name").value);
            form.append("email", document.getElementById("email").value);
            form.append("phone_no", document.getElementById("phone_no").value);
            form.append("address", document.getElementById("address").value);
            form.append("city", document.getElementById("city").value);
            form.append("state", document.getElementById("state").value);
            form.append("country", document.getElementById("country").value);
            form.append("company_id", '{{ Auth::user()->company_id }}');
            form.append("bu_id", document.getElementById("bu").value);
            form.append("profile", document.getElementById("file").files[0]);


            var settings = {
                "url": "api/store_customers",
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
                        $('#myModal').modal('hide');
                        console.log("Request was successful");
                        $('#fetchres').find('input:text').val('');
                        document.getElementById('hidden').value = "";
                        fetchtable();
                        Swal.fire(
                            'Success!',
                            'Customer Created Successfully',
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
                    Swal.fire(
                        'Server Error!',
                        'Customer Not Created',
                        'error'
                    )
                }
            });
        } else {
            var form = new FormData();
            form.append("first_name", document.getElementById("first_name").value);
            form.append("last_name", document.getElementById("last_name").value);
            form.append("email", document.getElementById("email").value);
            form.append("phone_no", document.getElementById("phone_no").value);
            form.append("address", document.getElementById("address").value);
            form.append("city", document.getElementById("city").value);
            form.append("state", document.getElementById("state").value);
            form.append("country", document.getElementById("country").value);
            form.append("company_id", '{{ Auth::user()->company_id }}');
            form.append("bu_id", document.getElementById("bu").value);
            form.append("profile", document.getElementById("file").files[0]);





            var settings = {
                "url": "api/update_customers/" + update_id + "",
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
                        $('#myModal').modal('hide');
                        $('#fetchres').find('input:text').val('');
                        document.getElementById('hidden').value = "0";


                        fetchtable();
                        Swal.fire(
                            'Success!',
                            'Customer updated Successfully',
                            'success'
                        )
                    },
                },
                success: function(data) {
                    // Additional success handling if needed
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log(xhr)
                    console.log(textStatus)
                    console.log(errorThrown)
                    Swal.fire(
                        'Server Error!',
                        'Customer Not updated',
                        'error'
                    )
                }
            });



            // alert("Update Records Here");

        }
    }

    function editData(id) {
        // alert(id);
        var settings = {
            "url": "api/show_customer/" + id + "",
            "method": "GET",
            "timeout": 0,
            // "headers": {
            // "Content-Type": "application/json"
            // },
            // "data": JSON.stringify({
            //     "first_name": document.getElementById("name").value,
            //     "last_name": document.getElementById("last_name").value,
            //     "company": {{ Auth::user()->company_id }},
            //     "email": document.getElementById("email").value,
            //     "password": document.getElementById("password").value,
            //     "designation_id": subtype_val

            // }),
        };

        $.ajax({
            ...settings,
            statusCode: {
                200: function(response) {
                    console.log(response);

                    document.getElementById('hidden').value = response[0]['id'];
                    document.getElementById("first_name").value = response[0]["first_name"];
                    document.getElementById("last_name").value = response[0]["last_name"];
                    document.getElementById("email").value = response[0]["email"];
                    document.getElementById("phone_no").value = response[0]["phone_no"];
                    document.getElementById("address").value = response[0]["address"];
                    document.getElementById("city").value = response[0]["city"];
                    document.getElementById("state").value = response[0]["state"];
                    document.getElementById("country").value = response[0]["country"];
                    select_bu.setChoiceByValue(response[0]['bu_id']);
           
                    var ret = response[0]['profile_img'].replace("documents/", "");
                    document.getElementById('output').src =
                        "http://demo.p2ptrack360.com/api/profile/" + ret;



                    // document.getElementById("lbelc").innerHTML = 'Update'


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
        var settings = {
            "url": "api/users/" + id + "",
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
                        'User Deleted Successfully',
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
                    'User Unit Not Deleted',
                    'error'
                )

                // console.log("Request failed with status code: " + xhr.status);
            }
        });
    }
    function updatestatus(id, element) {
    var isChecked = $(element).prop('checked') ? 1 : 0;

    var form = new FormData();
    form.append("id", id);
    form.append("active", isChecked);

    $.ajax({
        url: "api/updatecusstatus",
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
