<!doctype html>
<html lang="en">


<!-- Mirrored from themesdesign.in/webadmin/layouts/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 23 Jul 2023 18:04:41 GMT -->

<head>

    <meta charset="utf-8" />
    <title>Tickets | Service Manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" /> --}}
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    @include('partials.style')
    <Style>
        input[switch]:checked+label:after {
            left: 70px;
            background-color: #f5f6f8;
        }

        .add-read-more.show-less-content .second-section,
        .add-read-more.show-less-content .read-less {
            display: none;
        }

        .add-read-more.show-more-content .read-more {
            display: none;
        }

        .add-read-more .read-more,
        .add-read-more .read-less {
            font-weight: bold;
            margin-left: 2px;
            color: blue;
            cursor: pointer;
        }
        #doc img {
            width: 350px;
            height: 380px;
            object-fit: cover; /* Optional: maintain aspect ratio and cover the container */
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

                    <div class="container-fluid">
                        <div class="col-md-2">
                            <h4 class="card-title mb-0 pt-3">Show Tickets</h4>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <div class="product-detail mt-3" dir="ltr">
                                                    <div class="row">
                                                        <div class="col-auto">
                                                            .
                                                        <input type="hidden" name="" id="status_hidden">
                                                            <button
                                                                class="btn btn-soft-primary waves-effect waves-light"
                                                                type="button" id="email" data-bs-toggle="modal"
                                                                data-bs-target="#myModal"></i>Email</button>

                                                        </div>

                                                        <div class="col-auto">
                                                            
                                                        <button
                                                                class="btn btn-soft-primary waves-effect waves-light"
                                                                type="button" id="upstbtn" data-bs-toggle="modal"
                                                                data-bs-target="#updatestatuss"></i>Update Status</button>
                                                        </div>

                                                    </div>
                                                    <div id="ifram-div"class="col-12 p-3">

                                                        <iframe id="doc"
                                                            src=""
                                                            style="width:370px; height:400px;" frameborder="0"></iframe>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="ticket-col" class="col-xl-8">
                                                <div class="mt-3 mt-xl-3 ps-xl-5">
                                                    <h4 class="font-size-20 mb-3" id="ticket-number">Ticket #
                                                        00-0{{ request()->segment(2) }}
                                                    </h4>
                                                    <div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mt-3">
                                                                    <h4 class="font-size-14">Specification</h4>
                                                                    <ul class="list-unstyled ps-0 mb-0 mt-3">
                                                                        <li>
                                                                            <p class="text-muted mb-1 text-truncate"
                                                                                id="assigned"><i
                                                                                    class="mdi mdi-circle-medium align-middle text-primary me-2"></i>
                                                                                Task Assigned : Admin</p>
                                                                        </li>
                                                                        <li>
                                                                            <p class="text-muted mb-1 text-truncate"
                                                                                id="status1"><i
                                                                                    class="mdi mdi-circle-medium align-middle text-primary me-2"></i>
                                                                                Status : Admin</p>
                                                                        </li>
                                                                        <li>
                                                                            <p class="text-muted mb-1 text-truncate"
                                                                                id="problem"><i
                                                                                    class="mdi mdi-circle-medium align-middle text-primary me-1"></i>
                                                                                Problem : test</p>
                                                                        </li>

                                                                        <li>
                                                                            <p class="text-muted mb-0 text-truncate"
                                                                                id="subtype"><i
                                                                                    class="mdi mdi-circle-medium align-middle text-primary me-1"></i>
                                                                                Issue Sub Type : Vendor Type 2</p>
                                                                        </li>

                                                                        <li>
                                                                            <p class="text-muted mb-1 text-truncate"
                                                                                id="bu"><i
                                                                                    class="mdi mdi-circle-medium align-middle text-primary me-2"></i>
                                                                                BU/Store Name : </p>
                                                                        </li>
                                                                        <li>
                                                                            <p class="text-muted mb-1 text-truncate"
                                                                                id="store"><i
                                                                                    class="mdi mdi-circle-medium align-middle text-primary me-1"></i>
                                                                                Store Info :</p>
                                                                        </li>


                                                                        <li>
                                                                            <p class="text-muted mb-0 text-truncate"
                                                                                id="vendor"><i
                                                                                    class="mdi mdi-circle-medium align-middle text-primary me-1"></i>
                                                                                Vendor :</p>
                                                                        </li>


                                                                    </ul>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="mt-3">
                                                                    <!-- <h5 class="font-size-14">Ticket #  000-0002</h5> -->
                                                                    <ul class="list-unstyled ps-0 mb-0 mt-3">
                                                                        <li>
                                                                            <p class="text-muted mb-1 text-truncate"
                                                                                id="created_by"><i
                                                                                    class="mdi mdi-circle-medium align-middle text-primary me-2"></i>
                                                                                Ticket Created By : Admin</p>
                                                                        </li>
                                                                        <li>
                                                                            <p class="text-muted mb-1 text-truncate"
                                                                                id="reported_by"><i
                                                                                    class="mdi mdi-circle-medium align-middle text-primary me-2"></i>
                                                                                Ticket Reported By : Admin</p>
                                                                        </li>
                                                                        <li>
                                                                            <p class="text-muted mb-1 text-truncate"
                                                                                id="moc"><i
                                                                                    class="mdi mdi-circle-medium align-middle text-primary me-1"></i>
                                                                                Mode of Complaint : High</p>
                                                                        </li>
                                                                        <li>
                                                                            <p class="text-muted mb-1 text-truncate"
                                                                                id="resolved"><i
                                                                                    class="mdi mdi-circle-medium align-middle text-primary me-1"></i>
                                                                                Ticket Resolved By </p>
                                                                        </li>
                                                                        <li>
                                                                            <p class="text-muted mb-0 text-truncate"
                                                                                id="resolved_date"><i
                                                                                    class="mdi mdi-circle-medium align-middle text-primary me-1"></i>
                                                                                Ticket Ressolved Date :</p>
                                                                        </li>
                                                                        <li>
                                                                            <p class="text-muted mb-1 text-truncate"
                                                                                id="priority"><i
                                                                                    class="mdi mdi-circle-medium align-middle text-primary me-2"></i>
                                                                                Priority :</p>
                                                                        </li>
                                                                        <li>
                                                                            <p class="text-muted mb-1 text-truncate"
                                                                                id="due_date"><i
                                                                                    class="mdi mdi-circle-medium align-middle text-primary me-2"></i>
                                                                                Ticket Due Date : 2023-08-27</p>
                                                                        </li>

                                                                        <li>
                                                                            <p class="text-muted mb-1 add-read-more show-less-content"
                                                                                id="description"><i
                                                                                    class="mdi mdi-circle-medium align-middle text-primary me-1 "></i>
                                                                                Description :</p>
                                                                        </li>
                                                                        <li>
                                                                            <p class="text-muted mb-0 text-truncate"
                                                                                id="impact"><i
                                                                                    class="mdi mdi-circle-medium align-middle text-primary me-1"></i>
                                                                                Impact :</p>
                                                                        </li>

                                                                    </ul>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <br>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <!-- ////////// -->
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-6 col-form-label">
                                            </label>

                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3 row">
                                            {{-- <label for="example-text-input" class="col-md-2 col-form-label">Domain Members</label> --}}
                                            <div class="col-md-10">
                                                <div id="fields">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-6 col-form-label">
                                            </label>

                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3 row">
                                            {{-- <label for="example-text-input" class="col-md-2 col-form-label">Domain Members</label> --}}
                                            <div class="col-md-10">
                                                <div id="fields">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end row -->
                                    <ul class="nav nav-tabs nav-tabs-custom" role="">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#home1"
                                                role="tab" aria-selected="true">
                                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                <span class="d-none d-sm-block">Activity</span>
                                            </a>
                                        </li>
                                        <li class="nav-item" id="vendor_tab">
                                            <a class="nav-link" data-bs-toggle="tab" href="#profile1" role="tab"
                                                aria-selected="false">
                                                <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                                <span class="d-none d-sm-block">Vendor</span>
                                            </a>
                                        </li>

                                        <li class="nav-item" id="quote_tab">
                                            <a class="nav-link" data-bs-toggle="tab" href="#settings1"
                                                role="tab" aria-selected="false">
                                                <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                                <span class="d-none d-sm-block">Quotation</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content p-3 text-muted">
                                        <div class="tab-pane active" id="home1" role="tabpanel">
                                            <button class="btn btn-soft-primary waves-effect waves-light"
                                                type="button" id="email" data-bs-toggle="modal"
                                                data-bs-target="#myModals"></i>Activity</button>
                                            <div>
                                                No Activity Found
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="profile1" role="tabpanel">
                                            <div class="col-4">
                                                <div class="col-md-10">
                                                    <select class="form-control" data-trigger id="vendor_upd"
                                                        placeholder="This is a search placeholder">

                                                    </select>
                                                </div>
                                                <br>
                                                <button class="btn btn-soft-primary waves-effect waves-light"
                                                    type="button" onclick="updatevendor({{ request()->segment(2) }})"
                                                    id="email">Update</button>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="settings1" role="tabpanel">
                                            <div class="tab-pane active" id="home1" role="tabpanel">
                                                <button class="btn btn-soft-primary waves-effect waves-light"
                                                    type="button" id="email" data-bs-toggle="modal"
                                                    data-bs-target="#myModales"></i>Quotation</button>
                                                <div>
                                                    <div class="card-body">
                                                        <table id="myTables">
                                                            <thead>
                                                                <tr>
                                                                    <th>Vendor Name</th>
                                                                    <th>Quoted Amount</th>
                                                                    <th>Approved Amount</th>
                                                                    <th>Actual Amount</th>
                                                                    <th>Description</th>
                                                                    <th>Edit</th>
                                                                    <th>DELETE</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- end row -->

                        </div>

                        @include('partials.footer')
                        @include('partials.right_bar')

                        <script src="{{ asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
                        <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel"
                            aria-hidden="true" data-bs-scroll="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myModalLabel">Email</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-3 row">
                                                    <label for="example-text-input"
                                                        class="col-md-2 col-form-label">To</label>
                                                    <div class="col-md-10">
                                                        <select class="form-control" name="vendors1" id="vendors1"
                                                            placeholder="This is a search placeholder">

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-12">
                                                <div class="mb-3 row">
                                                    <label for="example-text-input"
                                                        class="col-md-2 col-form-label">Remarks</label>
                                                    <div class="col-md-10">
                                                        <textarea class="form-control" name="remarks" spellcheck="false" id="remarks">
                                                        </textarea>
                                                    </div>
                                                    <input class="form-control" type="hidden" id="hidden"
                                                        name="hidden" value="0">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary waves-effect"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" onclick=""
                                            class="btn btn-primary waves-effect waves-light">Save
                                            changes</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->

                        <div id="myModals" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel"
                            aria-hidden="true" data-bs-scroll="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myModalLabel">Add Activity</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-3 row">
                                                    <label for="example-text-input"
                                                        class="col-md-2 col-form-label">Remarks</label>
                                                    <div class="col-md-10">
                                                        <textarea class="form-control" name="remarks" spellcheck="false" id="remarks_act">

                                                        </textarea>
                                                    </div>
                                                    <input class="form-control" type="hidden" id="hidden"
                                                        name="hidden" value="0">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary waves-effect"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" onclick="saveActivity({{ request()->segment(2) }})"
                                            class="btn btn-primary waves-effect waves-light">Save
                                            changes</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div>

                        <div id="myModales" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel"
                            aria-hidden="true" data-bs-scroll="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myModalLabel">Create Quotation</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <!-- <div class="col-12">
                                                <div class="mb-3 row">
                                                    <label for="example-text-input"
                                                        class="col-md-2 col-form-label">Ticket</label>
                                                    <div class="col-md-10">
                                                        <select class="form-control" data-trigger
                                                            id="ticket_reported_by"
                                                            placeholder="This is a search placeholder">
                                                        </select>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <div class="col-12">
                                                <div class="mb-3 row">
                                                    <label for="example-text-input"
                                                        class="col-md-2 col-form-label">Vendor</label>
                                                    <div class="col-md-10">
                                                        <select class="form-control" name="vendors" id="vendors"
                                                            placeholder="This is a search placeholder">

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3 row">
                                                    <label for="example-text-input"
                                                        class="col-md-2 col-form-label">Amount</label>
                                                    <div class="col-md-10">
                                                        <input class="form-control" type="text" placeholder=""
                                                            id="en_amount">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3 row">
                                                    <label for="example-text-input"
                                                        class="col-md-2 col-form-label">Remarks</label>
                                                    <div class="col-md-10">

                                                        <textarea class="form-control" name="remarks" spellcheck="false" id="remix">
                                                        </textarea>
                                                    </div>
                                                    <input class="form-control" type="hidden" id="hidden"
                                                        name="hidden" value="0">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary waves-effect"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" onclick="savequotation({{ request()->segment(2) }})"
                                            class="btn btn-primary waves-effect waves-light">Save
                                            changes</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div>
                        <div id="myModdal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel"
                            aria-hidden="true" data-bs-scroll="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myModalLabel">
                                            <h5 id="labelc">Update</h5>
                                            <h5>Type</h5>
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-3 row">
                                                    <label for="example-text-input"
                                                        class="col-md-4 col-form-label">Approved Amount</label>
                                                    <div class="col-md-8">
                                                        <input class="form-control" type="text" required
                                                            placeholder="" id="app_amount1">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3 row">
                                                    <label for="example-text-input"
                                                        class="col-md-4 col-form-label">Actual Amount</label>
                                                    <div class="col-md-8">
                                                        <input class="form-control" type="text" required
                                                            placeholder="" id="actual_amount1">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3 row">
                                                    <div class="col-md-10">

                                                        <input type="hidden" id="qid" value="0" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary waves-effect"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" id="button" onclick="updateamount()"
                                            name="button" class="btn btn-primary waves-effect waves-light">Save
                                            changes</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->


                        
    <div class="modal fade" id="updatestatuss">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <div class="col-4">
                    <h3 class="card-title" >
                        Update Status
                    </h3>

                </div>
                <div class="col-8" style="display: flex;justify-content: end !important;">
                 
                    <button type="button" class="btn btn-icon btn-primary m-1"><i class="fa fa-times" style="font-size: 15px" aria-label="Close" class="btn-close" data-bs-dismiss="modal"></i>
                    </button>
                </div>


            </div>
            <div class="modal-body">
            <div class="col-12">
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Status</label>
                                <div class="col-md-10">
                                    <select class="form-control" id="upstatus" name="parent" placeholder="Select Parent">
                                    </select>

                                </div>
                            </div>
                        </div>


            </div>
            <div class="modal-footer" style="justify-content: center;">
                <div class="row">
                    <button type="button" class="btn btn-primary" onclick="updatestatus()">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>
                        @include('partials.script')
                        <!-- </div> -->
                        <script>
                            var vendor_upd, vendors, vendors1, table,upstatus;
                            $(document).ready(function() {

                                $.ajax({
                                url: "http://demo.p2ptrack360.com/api/status/company/{{ Auth::user()->company_id }}",
                                type: 'GET',
                                dataType: 'json',
                                success: function(response) {
                                    console.log(response+"Check")
                                            upstatus= new Choices("#upstatus", {
                                                        removeItemButton: !0,
                                                    })

                                                    upstatus.clearChoices();
                                                    console.log(response);
                                                    upstatus.setChoices(response,
                                                        'id',
                                                        'title',
                                                        false, );
                                                }
                                            })



                                table = $('#myTable').DataTable({
                                    dom: 'Bfrtip',
                                    buttons: [
                                        'colvis',
                                        {
                                            extend: 'csv',
                                            // Add the custom class to the CSV button
                                        },
                                        {
                                            extend: 'excel', // Add the custom class to the Excel button
                                        },
                                        {
                                            extend: 'pdf', // Add the custom class to the Excel button
                                        },
                                        {
                                            extend: 'print', // Add the custom class to the Excel button
                                        }
                                        // Add more buttons and classes as needed
                                    ]
                                });
                                table = $('#myTables').DataTable({
                                    dom: 'Bfrtip',
                                    buttons: [
                                        'colvis',
                                        {
                                            extend: 'csv',
                                            // Add the custom class to the CSV button
                                        },
                                        {
                                            extend: 'excel', // Add the custom class to the Excel button
                                        },
                                        {
                                            extend: 'pdf', // Add the custom class to the Excel button
                                        },
                                        {
                                            extend: 'print', // Add the custom class to the Excel button
                                        }
                                        // Add more buttons and classes as needed
                                    ]
                                });
                                fetchtable();
                                editData({{ request()->segment(2) }});
                            });

                            function AddReadMore() {
                                //This limit you can set after how much characters you want to show Read More.
                                var carLmt = 80;
                                // Text to show when text is collapsed
                                var readMoreTxt = " ...read more";
                                // Text to show when text is expanded
                                var readLessTxt = " read less";


                                //Traverse all selectors with this class and manipulate HTML part to show Read More
                                $(".add-read-more").each(function() {
                                    if ($(this).find(".first-section").length)
                                        return;

                                    var allstr = $(this).text();
                                    if (allstr.length > carLmt) {
                                        var firstSet = allstr.substring(0, carLmt);
                                        var secdHalf = allstr.substring(carLmt, allstr.length);
                                        var strtoadd = '<i class="mdi mdi-circle-medium align-middle text-primary me-2 add-read-more show-less-content"></i>'+firstSet + "<span class='second-section'>" + secdHalf +
                                            "</span><span class='read-more'  title='Click to Show More'>" + readMoreTxt +
                                            "</span><span class='read-less' title='Click to Show Less'>" + readLessTxt + "</span>";
                                        $(this).html(strtoadd);
                                    }
                                });

                                //Read More and Read Less Click Event binding
                                $(document).on("click", ".read-more,.read-less", function() {
                                    $(this).closest(".add-read-more").toggleClass("show-less-content show-more-content");
                                });
                            }


                            function editData(id) {
                                var settings = {
                                    "url": "http://demo.p2ptrack360.com/api/tickets/" + id + "",
                                    "method": "GET",
                                    "timeout": 0,
                                };
                                $.ajax({
                                    ...settings,
                                    statusCode: {
                                        200: function(response) {
                                            

                                            var id = response[0]['id'];
                                            var com_id = response[0]['company_id'];
                                            var bu_id = response[0]['business_unit_id'];

                                            upstatus.setChoiceByValue(response[0]['status_id'])

                                            // alert("id"+id+"com_id"+com_id+"bu"+bu_id);
                                            // console.log(response[0]['title']);
                                            $("#status_hidden").val(response[0]['id']);
                                            document.getElementById('ticket-number').textContent = 'Ticket # 000' + com_id +
                                                '-000' + bu_id + '-' + id + '';
                                            document.getElementById('problem').innerHTML =
                                                '<i class="mdi mdi-circle-medium align-middle text-primary me-2"></i> Problem : ' +
                                                response[0]['title'] + '';
                                            document.getElementById('status1').innerHTML =
                                                '<i class="mdi mdi-circle-medium align-middle text-primary me-2"></i> Status : ' +
                                                response[0]['status_title'] + '';
                                            document.getElementById('subtype').innerHTML =
                                                '<i class="mdi mdi-circle-medium align-middle text-primary me-2"></i> Issue Sub Type : ' +
                                                response[0]['type_title'] + '';
                                            document.getElementById('bu').innerHTML =
                                                '<i class="mdi mdi-circle-medium align-middle text-primary me-2"></i>   BU/Store Name : ' +
                                                response[0]['bu_name'] + '';
                                            document.getElementById('store').innerHTML =
                                                '<i class="mdi mdi-circle-medium align-middle text-primary me-2"></i>  Store Info : ' +
                                                response[0]['store_contact'] + '';
                                            document.getElementById('vendor').innerHTML =
                                                '<i class="mdi mdi-circle-medium align-middle text-primary me-2"></i>  Vendor : ' +
                                                response[0]['vname'] + '';
                                            document.getElementById('reported_by').innerHTML =
                                                '<i class="mdi mdi-circle-medium align-middle text-primary me-2"></i>  Ticket Reported By : ' +
                                                response[0]['reported_by_name'] + '';
                                            document.getElementById('moc').innerHTML =
                                                '<i class="mdi mdi-circle-medium align-middle text-primary me-2"></i>  Mode of Complaint : ' +
                                                response[0]['mode_of_complaint'] + '';
                                            document.getElementById('resolved').innerHTML =
                                                '<i class="mdi mdi-circle-medium align-middle text-primary me-2"></i>  Ticket Resolved By : ' +
                                                response[0]['resolved_name'] + '';
                                            document.getElementById('resolved_date').innerHTML =
                                                '<i class="mdi mdi-circle-medium align-middle text-primary me-2"></i>  Ticket Resolved Date : ' +
                                                response[0]['completed_date'] + '';

                                            document.getElementById('priority').innerHTML =
                                                '<i class="mdi mdi-circle-medium align-middle text-primary me-2"></i>  Priority : ' +
                                                response[0]['priority_title'] + '';
                                            document.getElementById('impact').innerHTML =
                                                '<i class="mdi mdi-circle-medium align-middle text-primary me-2"></i>  Impact : ' +
                                                response[0]['impact_title'] + '';

                                            document.getElementById('description').innerHTML =
                                                '<i class="mdi mdi-circle-medium align-middle text-primary me-2 add-read-more show-less-content"></i>  Description : ' +
                                                response[0]['description'] + '';
                                                AddReadMore();

                                            var tc = document.getElementById('ticket-col');
                                            var ret = response[0]['file'];

                                            if (ret == null) {
                                                document.getElementById("ifram-div").style.display = "none";
                                                tc.className = "col-12"
                                            } else {
                                                document.getElementById("ifram-div").style.display = "block";
                                                link=response[0]['file'].replace('documents/', '')
                                                console.log(link);
                                                document.getElementById('doc').src = "http://demo.p2ptrack360.com/api/profile/" + link;
                                            }



                                            // alert(response[0]['vendor_r']);
                                            if (response[0]['vendor_r'] != 'yes') {
                                                document.getElementById("vendor_tab").style.display = "none";
                                                document.getElementById("quote_tab").style.display = "none";
                                                document.getElementById("email").style.display = "none";
                                            }

                                        },
                                        // Add more status code handlers as needed
                                    },
                                    success: function(data) {
                                        // Additional success handling if needed
                                    },
                                    error: function(xhr, textStatus, errorThrown) {


                                        // console.log("Request failed with status code: " + xhr.status);
                                    }
                                });

                                $.ajax({
                                    url: "http://demo.p2ptrack360.com/api/vendors/company/{{ Auth::user()->company_id }}",
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function(response) {
                                        console.log(response);
                                        vendor_upd = new Choices("#vendor_upd", {
                                            removeItemButton: !0,
                                        })
                                        vendor_upd.setChoices(response,
                                            'id',
                                            'name',
                                            false, );
                                        vendors = new Choices("#vendors", {
                                            removeItemButton: !0,
                                        })
                                        vendors.setChoices(response,
                                            'id',
                                            'name',
                                            false, );
                                        vendors1 = new Choices("#vendors1", {
                                            removeItemButton: !0,
                                        })
                                        vendors1.setChoices(response,
                                            'id',
                                            'name',
                                            false, );
                                    }
                                });

                                console.log("api/tickets/" + id + "");

                            }

                            function saveActivity(id) {
                                // alert(id);
                                var remarks = document.getElementById("remarks_act").value;
                                var form = new FormData();
                                form.append("remarks", remarks);
                                form.append("ticket_id", id);
                                form.append("created_by", "1");

                                var settings = {
                                    "url": "http://demo.p2ptrack360.com/api/tickets/activity",
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
                                            document.getElementById('remarks_act').value = "";
                                            Swal.fire(
                                                'Success!',
                                                'Activity Created Successfully',
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
                                            'Activity Not Created',
                                            'error'
                                        )

                                        // console.log("Request failed with status code: " + xhr.status);
                                    }
                                });
                            }

                            function savequotation(id) {
                                alert(id);
                                var remarks = document.getElementById("remix").value;
                                var en_amount = document.getElementById("en_amount").value;
                                var form = new FormData();
                                form.append("remarks", remarks);
                                form.append("ticket_id", {{ request()->segment(2) }});
                                form.append("created_at", "2023-08-12");
                                form.append("company_id", {{ Auth::user()->company_id }});
                                form.append("amount", en_amount);
                                form.append("vendor_id", $('#vendors').find(":selected").val());

                                var settings = {
                                    "url": "http://demo.p2ptrack360.com/api/tickets/qoutations",
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
                                            document.getElementById('remix').value = "";
                                            Swal.fire(
                                                'Success!',
                                                'Quotation Created Successfully',
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
                                            'Quotation Not Created',
                                            'error'
                                        )

                                        // console.log("Request failed with status code: " + xhr.status);
                                    }
                                });
                            }

                            function updatevendor(id) {
                                var sel_vendor = $('#vendor_upd').find(":selected").val();
                                var settings = {
                                    "url": "http://demo.p2ptrack360.com/api/tickets/vendor/" + id + "",
                                    "method": "PUT",
                                    "timeout": 0,
                                    "headers": {
                                        "Content-Type": "application/json"
                                    },
                                    "data": JSON.stringify({
                                        "vendor_id": sel_vendor,
                                    }),
                                };

                                $.ajax({
                                    ...settings,
                                    statusCode: {
                                        200: function(response) {
                                            vendor_upd.removeHighlightedItems();
                                            Swal.fire(
                                                'Success!',
                                                'Activity Created Successfully',
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
                                            'Activity Not Created',
                                            'error'
                                        )

                                        // console.log("Request failed with status code: " + xhr.status);
                                    }
                                });
                            }

                            function updateamount() {
                                var id = document.getElementById("qid").value;
                                // alert(id);
                                var settings5 = {
                                    "url": "http://demo.p2ptrack360.com/api/tickets/qoutations/"+id+"",
                                    "method": "PUT",
                                    "timeout": 0,
                                    "headers": {
                                        "Content-Type": "application/json"
                                    },
                                    "data": JSON.stringify({
                                        "approved_amount": document.getElementById("app_amount1").value,
                                        "actual_amount": document.getElementById("actual_amount1").value
                                    }),
                                };

                                console.log(settings5);
                                $.ajax({
                                    ...settings5,
                                    statusCode: {
                                        200: function(response) {
                                            Swal.fire(
                                                'SUCCESS!',
                                                'Amount Updated Successfully',
                                                'success'
                                            )
                                            fetchtable()

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

                            function fetchtable() {
                                var settings = {
                                    "url": "http://demo.p2ptrack360.com/api/tickets/quote/{{ request()->segment(2) }}",
                                    "method": "GET",
                                    "timeout": 0,
                                };
                                $.ajax(settings).done(function(response) {
                                    console.log(response);
                                    table.clear().draw();
                                    $.each(response, function(index, data) {
                                        table.row.add([
                                            data.name,
                                            data.amount,
                                            data.approved_amount,
                                            data.actual_amount,
                                            data.description,
                                            '<button type="button"id="edit" name="edit"  onclick="openmodal(' +
                                            data.id +
                                            ')"  class="btn btn-soft-warning waves-effect waves-light"><i class="bx bx-edit-alt font-size-16 align-middle"></i></button>',
                                            '<button type="button" id="delete" name="delete" onclick="deleteData(' +
                                            data.id +
                                            ')" class="btn btn-soft-danger waves-effect waves-light"><i class="bx bx-trash-alt font-size-16 align-middle"></i></button>'
                                        ]).draw(false);
                                    });
                                });
                            }

                            function openmodal(id) {
                                $('#myModdal').modal('show');
                                document.getElementById("qid").value = id;

                            }
                            function updatestatus(){
                            id=$('#status_hidden').val()
                            status= $('#upstatus').find(":selected").val()
                            var form = new FormData();
                                form.append("status", status);
                                form.append("id", id);
                              

                                var settings = {
                                    "url": "http://demo.p2ptrack360.com/api/updatestatus",
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
                                                'Status Updated Successfully',
                                                'success'
                                            )
                                            $('#updatestatuss').modal('hide')
                                            editData({{ request()->segment(2) }})
                                        },
                                    },
                                    success: function(data) {
                                        // Additional success handling if needed
                                    },
                                    error: function(xhr, textStatus, errorThrown) {
                                    console.log(xhr)
                                        Swal.fire(
                                            'Server Error!',
                                            'Status Not Updated',
                                            'error'
                                        )

                                        // console.log("Request failed with status code: " + xhr.status);
                                    }
                                });
                            }
                        </script>


</body>

</html>
