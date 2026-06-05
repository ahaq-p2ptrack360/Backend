<!doctype html>
<html lang="en">


<!-- Mirrored from themesdesign.in/webadmin/layouts/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 23 Jul 2023 18:04:41 GMT -->

<head>

    <meta charset="utf-8" />
    <title>Group | Service Manager</title>
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
                                        <div class="col-md-1">

                                            <h4 class="card-title mb-0 pt-3">Group</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-soft-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#myModal">
                                                <i class="bx bxs-add-to-queue font-size-16 align-middle me-2"></i> Add
                                                New
                                            </button>
                                            {{-- <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Add New</button> --}}
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
                                                <th>Title</th>
                                                <th>Business Unit</th>
                                                <th>Created At</th>
                                                <!-- <th>Edit</th> -->
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


    <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="labelc" aria-hidden="true" data-bs-scroll="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                    <h5 class="modal-title" id="labelc">Create Group</h5>
                    {{-- <h5 class="modal-title" id="myModalLabel">Create Group</h5> --}}
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        {{-- <div class="col-12">
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Title</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" placeholder="Enter Group Title"
                                        id="title">
                                </div>
                            </div>
                        </div> --}}

                        <div class="col-12">
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Business Unit</label>
                                <div class="col-md-10">

                                    <select onchange="bugroup(this.value)" class="form-control" name="choices-single-default" id="bu_s" placeholder="Select Business Unit">

                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Group</label>
                                <div class="col-md-10">

                                    <select class="form-control" name="choices-single-default" id="bu_dp" placeholder="Select Business Unit">


                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Designation</label>
                                <div class="col-md-10">

                                    <select class="form-control" name="members" id="designation" placeholder="Select Members in Group" multiple>

                                    </select>
                                    <input class="form-control" type="hidden" id="hidden" name="hidden" value="0">

                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="button" onclick="submit()" class="btn btn-primary waves-effect waves-light">Save
                        changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    @include('partials.script')
</body>
<script>
    var table;
    var members;
    var bu_s;
    var bugroup_dropdown, g_designation;

    $(document).ready(function() {
        $.ajax({
            url: ("{{Auth::user()->company_id == 0}}" ? "api/business_units" : "api/business_units/company/{{ Auth::user()->company_id }}"),
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                bu_s = new Choices("#bu_s", {
                    removeItemButton: !0,
                })
                console.log(response);
                bu_s.setChoices(response,
                    'id',
                    'name',
                    false, );
            }
        });
        bugroup_dropdown = new Choices("#bu_dp", {
            removeItemButton: !0,
        })
        $.ajax({
            url: ("{{Auth::user()->company_id == 0}}" ? "api/users/super_admin_users" : "api/users/company/{{ Auth::user()->company_id }}"),
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                members = new Choices("#members", {
                    removeItemButton: !0,
                })
                console.log(response);
                members.setChoices(response,
                    'id',
                    'name',
                    false, );
            }
        });
        $.ajax({
            url: ("{{Auth::user()->company_id == 0}}" ? "api/designations" : "api/designations/company/" + '{{ Auth::user()->company_id }}'),
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                g_designation = new Choices("#designation", {
                    removeItemButton: !0,
                })
                console.log(response);
                g_designation.setChoices(response,
                    'id',
                    'title',
                    false, );
            }
        });
        table = $('#myTable').DataTable({
            dom: 'Bfrtip',
            buttons: [

                {
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

                } // Add more buttons and classes as needed
            ]
        });
        fetchtable();

    });

    function fetchtable() {
        var settings = {
            "url": ("{{Auth::user()->company_id == 0}}" ? "api/bu_groups" : "api/bu_groups/company/{{ Auth::user()->company_id }}"),
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
                    data.title,
                    data.name,
                    data.created_at,
                    // '<button type="button"id="edit" name="edit"  onclick="editData(' +
                    // data.id +
                    // ')"  class="btn btn-soft-warning waves-effect waves-light"><i class="bx bx-edit-alt font-size-16 align-middle"></i></button>',
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
            var bu_id = $('#bu_s').find(":selected").val();
            var values = $('#designation').val();
            // console.log(values);
            for (i = 0; i < values.length; i++) {
                opt = values[i];
                var form = new FormData();
                form.append("group_id", document.getElementById("bu_dp").value);
                form.append("bu_id", bu_id);
                form.append("designation_id", opt);

                var settings = {
                    "url": "api/bu_groups/designation",
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
                            $('#myModal').modal('hide');
                            console.log("Request was successful");
                            // bu_s.setChoiceByValue("");
                            // members.setChoiceByValue("");
                            document.getElementById('hidden').value = "";
                            fetchtable();
                            Swal.fire(
                                'Success!',
                                'Designation Created Successfully',
                                'success'
                            )

                            // alert(inserted_id);
                            // for (var i = 0; i < values.length; i++) {
                            //
                            //     console.log(opt)
                            //     var form = new FormData();
                            //     form.append("group_id", inserted_id);
                            //     form.append("member_id", opt);

                            //     var settings = {
                            //         "url": "api/group-members",
                            //         "method": "POST",
                            //         "timeout": 0,
                            //         "processData": false,
                            //         "mimeType": "multipart/form-data",
                            //         "contentType": false,
                            //         "data": form
                            //     };
                            //     $.ajax({
                            //         ...settings,
                            //         statusCode: {
                            //             200: function(response) {
                            //                 console.log(response);
                            //                 $('#myModal').modal('hide');
                            //                 document.getElementById('title')
                            //                     .value = "";
                            //                 document.getElementById('hidden').value = "";
                            //                 // console.log("Request was successful");
                            //                 // fetchtable();

                            //                 Swal.fire(
                            //                     'Success!',
                            //                     'Group Created Successfully',
                            //                     'success'
                            //                 )

                            //             },
                            //             // Add more status code handlers as needed
                            //         },
                            //         success: function(data) {
                            //             // Additional success handling if needed
                            //         },
                            //         error: function(xhr, textStatus, errorThrown) {
                            //             Swal.fire(
                            //                 'Server Error!',
                            //                 'Group Members Not Assigned',
                            //                 'error'
                            //             )

                            //             // console.log("Request failed with status code: " + xhr.status);
                            //         }
                            //     });

                            // }



                        },
                        // Add more status code handlers as needed
                    },
                    success: function(data) {
                        // $('#myModal').reset();
                        // Additional success handling if needed
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        Swal.fire(
                            'Server Error!',
                            'Type Not Created',
                            'error'
                        )

                        // console.log("Request failed with status code: " + xhr.status);
                    }
                });
            }

        } else {
            var bu_id = $('#bu_s').find(":selected").val();
            var settings = {
                "url": "api/bu_groups/" + update_id + "",
                "method": "PUT",
                "timeout": 0,
                "headers": {
                    "Content-Type": "application/json"
                },
                "data": JSON.stringify({
                    "company_id": '{{ Auth::user()->company_id }}',
                    "title": document.getElementById("title").value,
                    "bu_id": bu_id,
                    "created_by": 3
                }),
            };


            $.ajax({
                ...settings,
                statusCode: {
                    200: function(response) {
                        console.log(response);
                        $('#myModal').modal('hide');
                        document.getElementById('title').value = "";
                        // document.getElementById('hidden').value = "";
                        // console.log("Request was successful");
                        var settings = {
                            "url": "api/group-members/group/" + update_id + "",
                            "method": "DELETE",
                            "timeout": 0,
                        };

                        $.ajax({
                            ...settings,
                            statusCode: {
                                200: function(response) {
                                    console.log(response);
                                    var values = $('#members').val();
                                    for (var i = 0; i < values.length; i++) {
                                        opt = values[i];
                                        console.log(opt)
                                        var form = new FormData();
                                        form.append("group_id", update_id);
                                        form.append("member_id", opt);

                                        var settings = {
                                            "url": "api/group-members",
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
                                                    document.getElementById('title')
                                                        .value = "";
                                                    document.getElementById(
                                                        'hidden').value = "";
                                                    // console.log("Request was successful");
                                                    // fetchtable();

                                                    Swal.fire(
                                                        'Success!',
                                                        'Group Updated Successfully',
                                                        'success'
                                                    )

                                                },
                                                // Add more status code handlers as needed
                                            },
                                            success: function(data) {
                                                // Additional success handling if needed
                                            },
                                            error: function(xhr, textStatus,
                                                errorThrown) {
                                                Swal.fire(
                                                    'Server Error!',
                                                    'Group Members Not Assigned',
                                                    'error'
                                                )

                                                // console.log("Request failed with status code: " + xhr.status);
                                            }
                                        });

                                    }



                                },
                                // Add more status code handlers as needed
                            },
                            success: function(data) {
                                // Additional success handling if needed
                            },
                            error: function(xhr, textStatus, errorThrown) {
                                Swal.fire(
                                    'Server Error!',
                                    'Members Not Updated',
                                    'error'
                                )

                                // console.log("Request failed with status code: " + xhr.status);
                            }
                        });
                        fetchtable();

                    },
                    // Add more status code handlers as needed
                },
                success: function(data) {
                    // Additional success handling if needed
                },
                error: function(xhr, textStatus, errorThrown) {
                    Swal.fire(
                        'Server Error!',
                        'Type Not updated',
                        'error'
                    )

                    // console.log("Request failed with status code: " + xhr.status);
                }
            });



            // alert("Update Records Here");

        }

    }


    function editData(id) {
        // alert(id);
        var settings = {
            "url": "api/bu_groups/" + id + "",
            "method": "GET",
            "timeout": 0,
        };

        $.ajax({
            ...settings,
            statusCode: {
                200: function(response) {
                    console.log(response[0]['title']);
                    document.getElementById('title').value = response[0]['title'];
                    document.getElementById('hidden').value = response[0]['id'];
                    $("#parent").val(response[0]['parent']);
                    bu_s.setChoiceByValue(response[0]['bu_id']);
                    // $('#myModal').modal('show');
                    document.getElementById("labelc").innerHTML = 'Update'


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
        var settings2 = {
            "url": "api/group-members/group/" + id + "",
            "method": "GET",
            "timeout": 0,
        };

        $.ajax({
            ...settings2,
            statusCode: {
                200: function(response) {
                    // console.log(response[0]['title']);
                    var val = [];
                    for (a = 0; a < response.length; a++) {
                        console.log(response[a]['member_id'])
                        val.push(response[a]['member_id']);

                    }
                    console.log(val);
                    members.setChoiceByValue(val);
                    $('#myModal').modal('show');
                    document.getElementById("labelc").innerHTML = 'Update'


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
            "url": "api/bu_groups/" + id + "",
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

    // designations/company/{id}
    function bugroup(id) {

        $.ajax({
            url: "api/bu_groups_dropdown/" + id,
            type: 'GET',
            dataType: 'json',
            success: function(response) {

                console.log(response);
                bugroup_dropdown.clearChoices();
                bugroup_dropdown.setChoices(response,
                    'id',
                    'title',
                    false, );
            }
        });
    }
</script>

</html>
