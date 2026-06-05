<!doctype html>
<html lang="en">


<!-- Mirrored from themesdesign.in/webadmin/layouts/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 23 Jul 2023 18:04:41 GMT -->

<head>

    <meta charset="utf-8" />
    <title>Users | Service Manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" /> --}}
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    @include('partials.style')
</head>

<style>
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

                                            <h4 class="card-title mb-0 pt-3">Users</h4>
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
                                                <th>Company</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Designation</th>
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
                <h5 id="labelc">Create Users</h5>

            </h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <hr>
        <div class="offcanvas-body">
            <div class="row">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-firstname" class="form-label">Enter First Name</label>
                            <input type="text" class="form-control" placeholder="Enter First Name" id="name">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-email" class="form-label">Enter Last Name</label>
                            <input type="text" class="form-control" placeholder="Enter Last Name" id="last_name">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-email" class="form-label">Email</label>
                            <input type="email" class="form-control" placeholder="Enter Email" id="username" onblur="validateEmail()">
                            <p id="user_alert" style="color:red;"></p>

                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-email" class="form-label">Primay Email</label>
                            <input type="email" class="form-control" placeholder="Enter Primary Email" id="email">
                            <p id="p_user_alert" style="color:red;"></p>

                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-password" class="form-label">Password</label>
                            <input type="text" class="form-control" placeholder="Enter password" id="password">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-inputZip" class="form-label">Business Unit</label>
                            <div class="col-md-12">
                                <select class="form-control" id="bu" placeholder="Select Bussiness Unit">

                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">

                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-inputZip" class="form-label">Designation</label>
                            <div class="col-md-12">
                                <select class="form-control" id="type" placeholder="Select Designation">

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-inputCity" class="form-label">Company</label>
                            <div class="col-md-12">
                                <select class="form-control" disabled id="company"  placeholder="Select Company">
                                    <option selected value="{{ Auth::user()->company_id }}">{{ Auth::user()->name }}</option>
                                </select>
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
                                <input class="form-control" type="hidden" id="hidden" name="hidden" value="0">
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
<script>

     function validateEmail() {
            // Get the input value
            var emailInput = document.getElementById("username").value;

            // Regular expression for basic email validation
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            // Check if the email is valid
            if (emailRegex.test(emailInput)) {
                // Email is valid
                console.log("Email is valid");
                document.getElementById('user_alert').textContent=""

            } else {
                // Email is not valid, display an alert
                document.getElementById('user_alert').textContent="Invalid email address!"

            }
        }
var table;
var type;
var select_bu,subtype_s;
$(document).ready(function() {

    select_bu = new Choices("#bu", {
                removeItemButton: !0,
            })
    $.ajax({
        url: ("{{Auth::user()->company_id==0}}"?"api/designations":"api/designations/company/{{ Auth::user()->company_id }}"),
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            type = new Choices("#type", {
                removeItemButton: !0,
            })
            type.clearChoices();
            console.log(response);
            type.setChoices(response,
                'id',
                'title',
                false, );
        }
    });
    $.ajax({
        url: "{{Auth::user()->company_id==0}}"?"api/business_units":"api/business_units/company/{{ Auth::user()->company_id }}",
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

                }]

    });
    fetchtable();
});



function fetchtable() {


    var settings = {
        "url": ("{{Auth::user()->company_id == 0 }}" ? "api/users/super_admin_users" : "api/users/company/{{Auth::user()->company_id}}"),
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
                data.about,
                data.title,
                data.created_at,
                '<button type="button"id="edit" name="edit" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"  onclick="editData(' +
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


function submit() {
    var update_id = document.getElementById("hidden").value;
    var username=document.getElementById("username").value;
    console.log(update_id);
    if (update_id == 0) {
        var settings = {
        "url": "api/v_username/"+username,
        "method": "GET",
        "timeout": 0,
    };

    $.ajax(settings).done(function(response) {
        if(response.length != 0){
            alert("Username Already Exists! Try Another Username ")
        }
        else{
            var subtype_val = $('#type').find(":selected").val();
            var bu_val = $('#bu').find(":selected").val();


        var form = new FormData();
        form.append("first_name", document.getElementById("name").value);
        form.append("last_name", document.getElementById("last_name").value);
        form.append("company_id", {{ Auth::user()->company_id }});
        form.append("about", document.getElementById("email").value);
        form.append("username", document.getElementById("username").value);
        form.append("name", document.getElementById("name").value);
        form.append("designation_id", subtype_val);
        form.append("bu_id", bu_val);
        form.append("password", document.getElementById("password").value);
        form.append("two_factor_secret", document.getElementById("password").value);


        var settings = {
            "url": "api/users",
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
                        'User Created Successfully',
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
                    'User Not Created',
                    'error'
                )
            }
        });
        }

    })


    } else {
        var settings = {
        "url": "api/v_username/"+update_id+"/"+username,
        "method": "GET",
        "timeout": 0,
    };

    $.ajax(settings).done(function(response) {
        if(response.length != 0){
            alert("Username Already Exists! Try Another Username ")
        }else{
            var subtype_s = $('#type').find(":selected").val();
        var bu_val = $('#bu').find(":selected").val();
        var settings = {
            "url": "api/users/" + update_id + "",
            "method": "PUT",
            "timeout": 0,
            "headers": {
                "Content-Type": "application/json"
            },
            "data": JSON.stringify({
                "first_name": document.getElementById("name").value,
                "last_name": document.getElementById("last_name").value,
                "company_id": {{ Auth::user()->company_id }},
                "name": document.getElementById("name").value,
                "about": document.getElementById("email").value,
                "username": document.getElementById("username").value,
                "password": document.getElementById("password").value,
                "two_factor_secret": document.getElementById("password").value,
                "designation_id": subtype_s,
                "bu_id":bu_val
            }),
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
                        'User updated Successfully',
                        'success'
                    )
                },
            },
            success: function(data) {
                // Additional success handling if needed
            },
            error: function(xhr, textStatus, errorThrown) {
                Swal.fire(
                    'Server Error!',
                    'User Not updated',
                    'error'
                )
            }
        });

        }

    })



        // alert("Update Records Here");

    }
}

function editData(id) {
    // alert(id);
    var settings = {
        "url": "api/users/" + id + "",
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
                console.log();

                document.getElementById('hidden').value = response[0]['id'];
                document.getElementById("name").value = response[0]["first_name"];
                document.getElementById("username").value = response[0]["name"];
                document.getElementById("last_name").value = response[0]["last_name"];
                document.getElementById("email").value = response[0]["about"];
                document.getElementById("password").value = response[0]["two_factor_secret"];
                type.setChoiceByValue(response[0]['designation_id'] );
                select_bu.setChoiceByValue(response[0]['bu_id'] );
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
        url: "api/updateuserstatus",
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
