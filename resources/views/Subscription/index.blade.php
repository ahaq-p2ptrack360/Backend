<!doctype html>
<html lang="en">


<!-- Mirrored from themesdesign.in/webadmin/layouts/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 23 Jul 2023 18:04:41 GMT -->

<head>

    <meta charset="utf-8" />
    <title>Subscription | Service Manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" /> --}}
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    @include('partials.style')

</head>
<style>
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

                                            <h4 class="card-title mb-0 pt-3">Subscription</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-soft-primary waves-effect waves-light"
                                                data-bs-toggle="modal" data-bs-target="#myModal">
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
                                                    <th>Title</th>
                                                    <th>Price</th>
                                                    <!-- <th>No of Licence</th> -->
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


    <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
        data-bs-scroll="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Create Subscription</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Title</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" placeholder="Enter Title" id="title">
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-12">
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">No of Licence</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" placeholder="Enter Title" id="nolicence">
                                </div>
                            </div>
                        </div> -->
                        <div class="col-12">
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Price</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" placeholder="Enter Title" id="prices">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Description</label>
                                <div class="col-md-10">
                                    <textarea class="form-control" name="description" spellcheck="false"
                                        id="discription">
                                    </textarea>
                                </div>
                                <input class="form-control" type="hidden" id="hidden" name="hidden" value="0">
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
$(document).ready(function() {
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

            }

            // Add more buttons and classes as needed
        ]
    });

    fetchtable();
});

function fetchtable() {
    var settings = {
        "url": "api/subscription-packages",
        "method": "GET",
        "timeout": 0,
    };

    $.ajax(settings).done(function(response) {
        console.log(response);
        table.clear().draw();
        $.each(response, function(index, data) {
            const toggleSwitch = `
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" 
                        id="statusToggle_${data.id}" 
                        ${data.is_active == 1 ? 'checked' : ''} 
                        onchange="toggleStatus(${data.id}, this)">
                </div>
            `;

            table.row.add([
                index + 1,
                data.title,
                data.price,
                data.created_at,
                '<button type="button" id="edit" name="edit" onclick="editData(' + data.id + ')"  class="btn btn-soft-warning waves-effect waves-light"><i class="bx bx-edit-alt font-size-16 align-middle"></i></button>',
                `<label class="switch">
                    <input type="checkbox" ${data.active == 1 ? "checked" : ""} onchange="updatestatus(${data.id}, this)">
                    <span class="slider round"></span>
                </label>`,
            ]).draw(false);
        });
    });
}


function submit() {
    var update_id = document.getElementById("hidden").value;
    console.log(update_id);
    if (update_id == 0) {
        var form = new FormData();
        form.append("title", document.getElementById("title").value);
        form.append("price", document.getElementById("prices").value);
        form.append("no_of_licence", document.getElementById("nolicence").value);
        form.append("description", document.getElementById("discription").value);

        var settings = {
            "url": "api/subscription-packages",
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
                    document.getElementById('hidden').value = "";
                    // console.log("Request was successful");
                    fetchtable();

                    Swal.fire(
                        'Success!',
                        'Group Created Successfully',
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
                    'Group Members Not Assigned',
                    'error'
                )

                // console.log("Request failed with status code: " + xhr.status);
            }
        });
    } else {

        var settings = {
            "url": "api/subscription-packages/" + update_id + "",
            "method": "PUT",
            "timeout": 0,
            "headers": {
                "Content-Type": "application/json"
            },
            "data": JSON.stringify({
                "title": document.getElementById("title").value,
                "price": document.getElementById("nolicence").value,
                "no_of_licence": document.getElementById("prices").value,
                "description": document.getElementById("discription").value,
            }),
        };


        $.ajax({
            ...settings,
            statusCode: {
                200: function(response) {
                    console.log(response);
                    // $('#myModal').modal('hide');
                    document.getElementById('title').value = "";
                    document.getElementById('hidden').value = "";
                    document.getElementById("nolicence").value = "";
                    document.getElementById("prices").value = "";
                    document.getElementById("discription").value = "";
                    // console.log("Request was successful");
                    fetchtable();
                    Swal.fire(
                        'Success!',
                        'Package Updated Successfully',
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
                    'Package Not updated',
                    'error'
                )

                // console.log("Request failed with status code: " + xhr.status);
            }
        });
    }

}

function editData(id) {
    var settings = {
        "url": "api/subscription-packages/" + id + "",
        "method": "GET",
        "timeout": 0,
    };
    $.ajax({
        ...settings,
        statusCode: {
            200: function(response) {
                console.log(response[0]['title']);
                document.getElementById('title').value = response[0]['title'];
                // document.getElementById('nolicence').value = response[0]['no_of_licence'];
                document.getElementById('prices').value = response[0]['price'];
                document.getElementById('discription').value = response[0]['description'];
                document.getElementById('hidden').value = response[0]['id'];
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
        "url": "api/subscription-packages/" + id + "",
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
                    'Status Deleted Successfully',
                    'success'
                )
            },
            // Add more status code handlers as needed
        },
        success: function(data) {
            // Additional success handling if needed
        },
        error: function(xhr, textStatus, errorThrown) {
            // Swal.fire(444444
            //     'Server Error!',
            //     'Type Not Deleted',
            //     'error'
            // )

            // console.log("Request failed with status code: " + xhr.status);
        }
    });
};
function updatestatus(id, element) {
    var isChecked = $(element).prop('checked') ? 1 : 0;

    var form = new FormData();
    form.append("id", id);
    form.append("active", isChecked);

    $.ajax({
        url: "api/updatesubstatus",
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