<!doctype html>
<html lang="en">


<!-- Mirrored from themesdesign.in/webadmin/layouts/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 23 Jul 2023 18:04:41 GMT -->

<head>

    <meta charset="utf-8" />
    <title>Business Unit | Service Manager</title>
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
    .btn-background {
    background-color: white; /* Example color for Copy button */
    color: black;
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

                                            <h4 class="card-title mb-0 pt-3">Business Unit</h4>
                                        </div>
                                        <div class="col-md-4">
                                            {{-- <button type="button" class="btn btn-soft-primary waves-effect waves-light"  data-bs-toggle="modal" data-bs-target="#myModal">
                                                     Add New
                                                </button> --}}
                                            <button class="btn btn-soft-primary waves-effect waves-light" type="button"
                                                onclick="showcanvas()"><i
                                                    class="bx bxs-add-to-queue font-size-16 align-middle me-2"></i>Add
                                                New</button>
                                            {{-- <button type="button" class="btn btn-primary waves-effect waves-light">Add New</button> --}}
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                </div>
                                             

                                            </div>
                                        </div>
                                    </div>
                                    


                                </div><!-- end card header -->
                                <div class="card-body">
                                    <table id="myTable">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Company</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Created At</th>
                                                <th>Edit</th>
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
    <div class="offcanvas offcanvas-end w-75" tabindex="-1" id="offcanvasRight"
        aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasRightLabel">Create Business Units</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <hr>
        <div class="offcanvas-body" id="fetch_results">
            <div class="row">

                <div class="row">
                    <div class="col-lg-4">
                        <div class="mb-3">
                        

                            <label for="formrow-firstname" class="form-label">Enter Name</label>
                            <input type="text" class="form-control" placeholder="Enter Name" id="name">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-email" class="form-label">Enter Email</label>
                            <input type="text" class="form-control" placeholder="Enter Email" id="email">
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" placeholder="Enter Phone" id="phone">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-inputCity" class="form-label">Alternate Phone</label>
                            <input type="text" class="form-control" placeholder="Enter Alternate Phone"
                                id="aphone">
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
                            <label for="formrow-State" class="form-label">State</label>
                            <input type="text" class="form-control" placeholder="Enter State" id="state">
                        </div>
                    </div>




                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-city" class="form-label">City</label>
                            <input type="text" class="form-control" placeholder="Enter City" id="city">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-inputCity" class="form-label">Address 1</label>
                            <input type="text" class="form-control" placeholder="Enter Address 1" id="ad1">
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-inputZip" class="form-label">Address 2</label>
                            <input type="text" class="form-control" placeholder="Enter Address 2" id="ad2">
                        </div>
                    </div>


                </div>
                <div class="row">

                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-Longitude" class="form-label">Longitude</label>
                            <input type="text" class="form-control" placeholder="Enter Longitude" id="lng">
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-Latitude" class="form-label">Latitude</label>
                            <input type="text" class="form-control" placeholder="Enter Latitude" id="lat">
                        </div>
                    </div>
                    {{-- <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-inputZip" class="form-label">Zip</label>
                            <input type="text" class="form-control" placeholder="Enter Zip" id="zip">
                        </div>
                    </div> --}}
                    <div class="col-4" id="marketingdiv">
                        <div class="mb-3 row">
                            <label for="formrow-inputState" class="form-label">Marketing Manager</label>
                            <div class="col-md-12">
                                <select class="form-control" name="parent" id="parent"
                                    placeholder="Marketing Manager">
                            <option value=""></option>

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="mb-3 row">
                            <label for="formrow-inputState" class="form-label">Responsible</label>
                            <div class="col-md-12">
                                <select class="form-control" name="vendor_r" id="resposible"
                                    placeholder="Customer Required">
                            <option value=""></option>
                                    

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-4" id="storediv">
                        <div class="mb-3 row">
                            <label for="formrow-inputState" class="form-label">Store Manager</label>
                            <div class="col-md-12">
                                <select class="form-control" name="store" id="store"
                                    placeholder="Store Manager">
                            <option value=""></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="mb-3 row">
                            <label for="formrow-inputState" class="form-label">Vendor Required</label>
                            <div class="col-md-12">
                                <select class="form-control" name="vendor_r" id="vendor_r"
                                    placeholder="Vendor Required">
                                    <option value=""></option>


                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="mb-3 row">
                            <label for="formrow-inputState" class="form-label">Account Required</label>
                            <div class="col-md-12">
                                <select class="form-control" name="vendor_r" id="customer_r"
                                    placeholder="Customer Required">
                                    <option value=""></option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3 row">
                                <label for="formrow-inputState" class="form-label">Parent BU</label>
                                <div class="col-md-12">
                                    <select class="form-control" name="vendor_r" id="parent_bu"
                                        placeholder="Vendor Required">
                                        <option value=""></option>


                                    </select>
                                </div>
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
                    <div class="col-12">
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-6 col-form-label">Additional
                                Fields</label>
                            <div class="col-md-6 p-1">

                                <button type="button" id="addfield"
                                    class="btn btn-outline-warning waves-effect waves-light"><i
                                        class="fas fa-plus-square"></i> Add More</button>

                            </div>
                        </div>
                        <div class="mb-3 row">
                            {{-- <label for="example-text-input" class="col-md-2 col-form-label">Domain Members</label> --}}
                            <div class="col-md-12">
                                <div id="fields">

                                    <input class="form-control" type="hidden" id="hidden" name="hidden"
                                        value="0">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="newfields">

                    </div>
                    <div class="col-12">
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-10 col-form-label"></label>
                            <div class="col-md-2">

                                {{-- <button type="button" onclick="getDynamicFieldValues()" class="btn btn-primary waves-effect waves-light">Check</button> --}}
                            </div>
                            <div class="col-md-2">
                                {{-- <button type="button" class="btn btn-primary" onclick="getDynamicFieldValues(2)">click</button> --}}

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
    var table;
    var parent;
    var store;
    var vendor, parent_bu;

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
                $('#ad2').val(localAddress);
                $('#ad1').val(houseNumber);
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
        parent_bu = new Choices("#parent_bu", {
            removeItemButton: !0,
        });

        store = new Choices("#store", {
                    removeItemButton: !0,
                })
        vendor = new Choices("#vendor_r", {
            removeItemButton: !0,
        });
        customer_r = new Choices("#customer_r", {
            removeItemButton: !0,
        });
        responsible_u = new Choices("#resposible", {
            removeItemButton: !0,
        });
         parent = new Choices("#parent", {
                    removeItemButton: !0,
                })
        $.ajax({
            url: ("{{ Auth::user()->company_id == 0 }}" ? "/api/users/super_admin_users" :
                "api/users/company/{{ Auth::user()->company_id }}"),
            type: 'GET',
            dataType: 'json',
            success: function(response) {
               
                console.log(response);
                
                parent.setChoices(response,
                    'id',
                    'name',
                    false, );
            }
        });
        
         $.ajax({
            url:  "api/dm_eligible/{{ Auth::user()->company_id }}",
            type: 'GET',
            dataType: 'json',
            success: function(response) {

              if(response[0]['eligible']== 1){
                $('#marketingdiv').css('display','block');
                $('#storediv').css('display','block');

              }
              else{
                $('#marketingdiv').css('display','none');
                $('#storediv').css('display','none');

              }
            }
        });
        $.ajax({
            url: ("{{ Auth::user()->company_id == 0 }}" ? "api/business_units" :
                "api/business_units/company/{{ Auth::user()->company_id }}"),
            type: 'GET',
            dataType: 'json',
            success: function(response) {

                // parent_bu.clearChoices();
                // parent_bu.passedElement.element.appendChild(new Option('', ''));
                console.log(response);
                parent_bu.setChoices(response,
                    'id',
                    'name',
                    false, );
            }
        });
        $.ajax({
            url: ("{{ Auth::user()->company_id == 0 }}" ? "api/users/super_admin_users" :
                "api/users/company/{{ Auth::user()->company_id }}"),
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                
                console.log(response);
                
                store.setChoices(response,
                    'id',
                    'name',
                    false, );
            }
        });
        $.ajax({
            url: ("{{ Auth::user()->company_id == 0 }}" ? "api/users/super_admin_users" :
                "api/users/company/{{ Auth::user()->company_id }}"),
            type: 'GET',
            dataType: 'json',
            success: function(response) {

                console.log(response);
                
                
                responsible_u.setChoices(response,
                    'id',
                    'name',
                    false, );
            }
        });
        clearChoices()

        var k = "The respective values are :";
        $("#addfield").click(function() {
            var newRowAdd =
                '<div id="row" class="row"><div class="input-group m-3">' +
                '<div class="col-6"><div class="input-group-prepend m-1">' +
                '<input name="name2[]" class="form-control" type="text" placeholder="Additional Field"></div> </div>' +
                '<div class="col-4 mt-1"><select name="type[]" class="form-control " data-trigger name="choices-single-default" id="choices-single-default" placeholder=""><option>String</option><option>Number</option><option>Text</option><option>Boolean</option></select> </div>' +
                '<div class="col-2"><div class="input-group-prepend">' +
                '<button type="button" id="DeleteRow" class="btn btn-outline-danger waves-effect waves-light m-1">Delete</button>' +
                '<i class="bi bi-trash"></i></button></div> </div></div>' +
                '';

            $('#fields').append(newRowAdd);

            // alert("The paragraph was clicked.");
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

                }
            ]
        });
        fetchtable();
    });

    function fetchtable() {
        // alert({{ Auth::user()->company_id }})
        var settings = {
            // ("Auth::user->company_id == 0" ?"api/business_units":"api/business_units/company/{{ Auth::user()->company_id }}")
            "url": ("{{ Auth::user()->company_id }}" == 0 ? "api/business_units" :
                "api/business_units/company/{{ Auth::user()->company_id }}"),
            "method": "GET",
            "timeout": 0,
        };

        $.ajax(settings).done(function(response) {
            console.log(response);
            table.clear().draw();
            $.each(response, function(index, data) {
                table.row.add([
                    index + 1,
                    data.company,
                    data.name,
                    data.email,
                    data.created_at,
                    '<button type="button"id="edit" name="edit" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"  onclick="editData(' +
                    data.id +
                    ')"  class="btn btn-soft-warning waves-effect waves-light"><i class="bx bx-edit-alt font-size-16 align-middle"></i></button>',
                    // '<button type="button" id="delete" name="delete" onclick="deleteData(' +
                    // data.id +
                    // ')" class="btn btn-soft-danger waves-effect waves-light"><i class="bx bx-trash-alt font-size-16 align-middle"></i></button>'
                ]).draw(false);
            });
        });
    }


    function submit() {
        var update_id = document.getElementById("hidden").value;
        // console.log(update_id);
        if (update_id == 0) {
            var parent_id = $('#parent').find(":selected").val() ;
            var store_id = $('#store').find(":selected").val();
            var vendor_r = $('#vendor_r').find(":selected").val();
            var customer_r = $('#customer_r').find(":selected").val();
            var parent_bu_id = $('#parent_bu').find(":selected").val();
            var responsible_u = $('#resposible').find(":selected").val();

            console.log(parent_id)

            var form = new FormData();
            form.append("company_id", '{{ Auth::user()->company_id }}');
            form.append("marketing_manager", parent_id==""?'0':parent_id);
            form.append("store_manager", store_id==""?'0':store_id);
            form.append("bu_user", "1");
            form.append("name", document.getElementById("name").value);
            form.append("email", document.getElementById("email").value);
            form.append("phone", document.getElementById("phone").value);
            form.append("address_1", document.getElementById("ad1").value);
            form.append("address_2", document.getElementById("ad2").value);
            form.append("alternate_phone", document.getElementById("aphone").value);
            form.append("latitude", document.getElementById("lat").value);
            form.append("longitude", document.getElementById("lng").value);
            form.append("city", document.getElementById("city").value);
            form.append("state", document.getElementById("state").value);
            form.append("country", document.getElementById("country").value);
            form.append("zipcode", '0000');
            form.append("customer_r", customer_r);
            form.append("responsible", responsible_u);
            form.append("vendor_r", vendor_r);
            form.append("parent_bu_id", parent_bu_id)
            form.append("status", "1");
            form.append("properties", "[]");

            var settings = {
                "url": "api/business_units",
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
                        response = JSON.parse(response);
                        var inserted_id = response['inserted_id'];
                        // alert(inserted_id);
                        getDynamicFieldValues(inserted_id);
                        $('#offcanvasRight').offcanvas('hide');

                        console.log("Request was successful");
                        $("#offcanvasRight :input").val("");
                        clearChoices()
                     


                        // document.getElementById('example-text-input-title').value = "";
                        // $('#fetch_results').find('input:text').val('');
                        
                        fetchtable();

                        var k;
                        // var name = document.getElementsByName('name2[]');
                        // var type = document.getElementsByName('type[]');




                        Swal.fire(
                            'Success!',
                            'BU Created Successfully',
                            'success'
                        )

                    },
                    // Add more status code handlers as needed
                },
                success: function(data) {
                    // $('#myModal').reset();
                    // Additional success handling if needed
                },
                error: function(xhr, textStatus, errorThrown) {
                console.log(xhr)
                console.log(textStatus)
                console.log(errorThrown)
                    Swal.fire(
                        'Server Error!',
                        'Business Unit Not Created',
                        'error'
                    )

                    // console.log("Request failed with status code: " + xhr.status);
                }
            });

        } else {
            var market = $('#parent').find(":selected").val();
            var store = $('#store').find(":selected").val();
            var vendor_r = $('#vendor_r').find(":selected").val();
            var customer_r = $('#customer_r').find(":selected").val();
            var parent_bu_id = $('#parent_bu').find(":selected").val();
            var responsible_u = $('#resposible').find(":selected").val();

            var settings = {
                "url": "api/business_units/" + update_id + "",
                "method": "PUT",
                "timeout": 0,
                "headers": {
                    "Content-Type": "application/json"
                },
                "data": JSON.stringify({
                    "company_id": '{{ Auth::user()->company_id }}',
                    "marketing_manager": market,
                    "store_manager": store,
                    "bu_user": null,
                    "name": document.getElementById("name").value,
                    "email": document.getElementById("email").value,
                    "phone": document.getElementById("phone").value,
                    "alternate_phone": document.getElementById("aphone").value,
                    "address_1": document.getElementById("ad1").value,
                    "address_2": document.getElementById("ad2").value,
                    "latitude": document.getElementById("lat").value,
                    "longitude": document.getElementById("lng").value,
                    "city": document.getElementById("city").value,
                    "state": document.getElementById("state").value,
                    "country": document.getElementById("country").value,
                    "zipcode": '0000',
                    "customer_r": customer_r,
                    "responsible": responsible_u,
                    "vendor_r": vendor_r,
                    "parent_bu_id": parent_bu_id,
                    "status": 0,
                    "created_by": 1,
                    "updated_by": 1,
                    "created_at": "2023-05-09 13:24:52",
                    "updated_at": "2023-05-09 13:25:17",
                    "deleted_at": null,
                    "properties": "[]"
                }),
            };

            $.ajax({
                ...settings,
                statusCode: {
                    200: function(response) {
                        console.log(response);
                        $('#myModal').modal('hide');
                        // document.getElementById('example-text-input-title').value = "";
                        $("#offcanvasRight :input").val("");
                    

                        
        //                 $.ajax({
        //             url: "api/deletebufields/" + update_id,
        //             type: 'delete',
        //             dataType: 'json',
        //             success: function(response) {
        //                 console.log("fields delete")
        // //                 getDynamicFieldValues(update_id)
        // // $('#newfields').empty()

                       
        //             },
        //             error: function(xhr, status, error) {
        //                 console.log(xhr);
        //                 console.log("fields not delete")
                       
                    
        //             }
        //         });
                        clearChoices()
                        
                        // console.log("Request was successful");
                        fetchtable();

                        Swal.fire(
                            'Success!',
                            'Business Unit updated Successfully',
                            'success'
                        )
                    },
                    // Add more status code handlers as needed
                },
                success: function(data) {
                    // Additional success handling if needed
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log(xhr);
                    console.log(textStatus);
                    console.log(errorThrown);
                    Swal.fire(
                        'Server Error!',
                        'Business Unit Not updated',
                        'error'
                    )

                    // console.log("Request failed with status code: " + xhr.status);
                }
            });



            // alert("Update Records Here");

        }

    }

    function getDynamicFieldValues(bu_id) {
        var nameValues = [];
        var typeValues = [];
        // alert(bu_id);
        // console.log(bu_id)

        var inputElements = document.getElementsByName('name2[]');
        var inputElements2 = document.querySelectorAll('select[name="type[]"]');

        // alert(inputElements)
        // alert(inputElements2)
        // console.log(inputElements)
        // console.log(inputElements2)



        for (var i = 0; i < inputElements.length; i++) {
            nameValues.push(inputElements[i].value);

            typeValues.push(inputElements2[i].value);
            console.log('Name Values:', nameValues);
            var form = new FormData();
            form.append("name", inputElements[i].value);
            form.append("type", inputElements2[i].value);
            form.append("bu_id", bu_id);
            // alert(inputElements[i].value)
            // alert(inputElements2[i].value)

            // console.log(inputElements[i].value)
            // console.log(inputElements2[i].value)

            var settings = {
                "url": "/api/bu_fields",
                "method": "POST",
                "timeout": 0,
                "processData": false,
                "mimeType": "multipart/form-data",
                "contentType": false,
                "data": form
            };

            $.ajax(settings).done(function(response) {
                console.log(response);
            });
        }



        // Now you have arrays containing the values of the 'name2[]' and 'type[]' fields
        // console.log('Name Values:', nameValues);
        // console.log('Type Values:', typeValues);
    }


    function editData(id) {
        // alert(id);
        $('#fields').empty()

        var settings = {
            "url": "api/business_units/" + id + "",
            "method": "GET",
            "timeout": 0,
        };

        $.ajax({
            ...settings,
            statusCode: {
                200: function(response) {
                    // console.log(response[0]['title']);
                    document.getElementById('name').value = response[0]['name'];
                    document.getElementById('email').value = response[0]['email'];
                    document.getElementById('phone').value = response[0]['phone'];
                    document.getElementById('aphone').value = response[0]['alternate_phone'];
                    document.getElementById('ad1').value = response[0]['address_1'];
                    document.getElementById('ad2').value = response[0]['address_2'];
                    document.getElementById('lat').value = response[0]['latitude'];
                    document.getElementById('lng').value = response[0]['longitude'];
                    document.getElementById('city').value = response[0]['city'];
                    document.getElementById('state').value = response[0]['state'];
                    document.getElementById('country').value = response[0]['country'];
                    // document.getElementById('zip').value = response[0]['zipcode'];
                    $('#hidden').val(response[0]['id']);
                    // document.getElementById('hidden').value = response[0]['id'];
                    parent.setChoiceByValue(response[0]['marketing_manager']);
                    store.setChoiceByValue(response[0]['store_manager']);
                    vendor.setChoiceByValue(response[0]['vendor_r']);
                    parent_bu.setChoiceByValue(response[0]['parent_bu_id']);
                    customer_r.setChoiceByValue(response[0]['customer_r']);
                    responsible_u.setChoiceByValue(response[0]['reponsible_user']);

                    // $("#parent").val(response[0]['marketing_manager']);
                    // $("#store").val(response[0]['store_manager']);
                    // $('#myModal').modal('show');
                    // document.getElementById("labelc").innerHTML = 'Update'




                },
                // Add more status code handlers as needed
            },
            success: function(data) {
                // Additional success handling if needed

                //  /alert(document.getElementById('hidden').value)

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
            "url": "api/business_units/" + id + "",
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
                        'Business Unit Deleted Successfully',
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
                    'Business Unit Not Deleted',
                    'error'
                )

                // console.log("Request failed with status code: " + xhr.status);
            }
        });
    };


    

    function clearChoices() {
    // Get all elements with the class 'choices'
                    vendor.setChoiceByValue("");
                    parent_bu.setChoiceByValue("");
                    parent.setChoiceByValue("");
                    customer_r.setChoiceByValue("");
                    responsible_u.setChoiceByValue("");
                    store.setChoiceByValue("");
                    
}


function addtional_fields(id) {
       
        $('#newfields').empty()
        console.log("id" + id);
 
    var settings = {
        "url": "api/tickets/bu_fields/" + id,
        "method": "GET",
        "timeout": 0,
    };

    $.ajax(settings).done(function(response) {
        for (var i = 0; i < response.length; i++) {
            var newrow =
                '<div id="row" class="row"><div class="input-group m-3">' +
                '<div class="col-6"><div class="input-group-prepend m-1">' +
                '<input name="name2[]" class="form-control" value="' + response[i]['name'] + '" type="text" placeholder="Additional Field"></div> </div>' +
                '<div class="col-4 mt-1"><select name="type[]" class="form-control choices-single-default" placeholder=""><option >String</option><option >Number</option><option >Text</option><option>Boolean</option></select></div>' +
                '<div class="col-2"><div class="input-group-prepend">' +
                '<button type="button" id="DeleteRow" class="btn btn-outline-danger waves-effect waves-light m-1">Delete</button>' +
                '<i class="bi bi-trash"></i></button></div> </div></div>' +
                '';

            // Append the new row
            $('#newfields').append(newrow);

            // Set the default value of the select element
            $('[name="type[]"]:last').val(response[i]['type']);
        }
    });


    }

</script>

</html>
