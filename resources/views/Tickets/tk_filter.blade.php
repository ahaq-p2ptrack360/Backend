<!doctype html>
<html lang="en">


<!-- Mirrored from themesdesign.in/webadmin/layouts/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 23 Jul 2023 18:04:41 GMT -->

<head>

    <meta charset="utf-8" />
    <title>Tickets | Service Manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" /> --}}
    <meta content="Themesdesign" name="author" />
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"
        integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- App favicon -->
    <link rel='stylesheet'
        href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css'>

    <link href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/3.2.0/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/colreorder/2.0.4/css/colReorder.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/rowgroup/1.5.1/css/rowGroup.dataTables.min.css" rel="stylesheet">



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
        object-fit: cover;
        /* Optional: maintain aspect ratio and cover the container */
    }

    .sidebar {
        display: block;
        float: left;
        width: 250px;
        background: #333;

    }

    .content {
        display: block;
        overflow: hidden;
        width: auto;
    }

    .choices__inner {
        height: 45px;
    }

    .btn.dropdown-toggle {
        /* overflow: hidden; Cuts off overflow */
        background: #8a8781 !important;
        color: #fff !important;
    }

    .btn.dropdown-toggle.btn-light {
        width: 160px !important;
    }

    table.dataTable tr.dtrg-group.dtrg-end th {
        text-align: right;
        font-weight: bold;
    }

    .group_count {
        line-height: 15px;
        font-size: 12px;
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
                <div class="container-fluid">
                    <div class="row">


                        <div class="col-2">
                            <div class="row">

                                <div class="col-12" id="group_static_fields"
                                    style="margin-left: 0px; padding-left: 0px;">

                                    <!-- <option value="${field}">ABC</option>
<option value="ABC">BC</option>    -->
                                    </select>

                                </div>
                                <hr style="margin-top:3px">
                                <!-- group fields -->


                                <div class="col-12" id="group_fields" style="height: 250px; overflow-y:auto;">

                                </div>
                                <button type="button" id="group_button" class="btn btn-dark btn-sm" style="margin-bottm: 3px; margin-left: 75px;
                           margin-bottom: 3px; width: 50%; display:none">Create
                                    Group</button>
                                <hr style="margin-top:3px">
                                <div class="col-12" id="groups_overlay" style="height: 250px; overflow-y: auto">


                                </div>



                            </div>
                        </div>

                        <div class="col-10">

                            <div class="col-12" id="static_fields" style="margin-left: 0px; padding-left: 0px;">

                                <!-- <option value="${field}">ABC</option>
<option value="ABC">BC</option>    -->
                                </select>

                            </div>


                            <div class="col-2" id="filter_div" style="display:none;">
                                <select class="form-select" aria-label="Default select example" id="table_filter">
                                    <!-- <option selected="">Filter</option> -->
                                    <option value="{{Auth::user()->id}}" name="assigned_to">Assigned To Me</option>
                                    <option value="{{Auth::user()->id}}" name="created_by">created By Me</option>
                                    <option value="all">All</option>

                                </select>

                            </div>
                            <div id="myPieChart" class="d-none"></div>
                            <hr style="margin: 8px 0px;">

                            <div class="col-12" style="margin-left:20px">
                                <h6 class="">Filter Fields</h6>
                                <div class="row" id="filter_fields">



                                    <!-- <div class="col-3">
                                        <label class="form-label">Range</label>
                                        <input type="text" class="form-control flatpickr-input" id="datepicker-range"
                                            readonly="readonly">
                                    </div> -->

                                </div>
                                <div class="d-flex justify-content-start">

                                    <button type="button" id="save_view_btn"
                                        class="btn btn-soft-primary waves-effect waves-light"
                                        style=" display: none; margin-top: 7px">
                                        Save
                                    </button>

                                    <button type="button" id="find_view_btn"
                                        class="btn btn-soft-primary waves-effect waves-light"
                                        style=" margin-top: 7px; margin-left: 3px;">
                                        Views
                                    </button>
                                </div>


                            </div>
                            <hr>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table id="myTable" class="display" style="width: 100%;">
                                            <thead style="width: 100%;">
                                                <tr id="table_records">
                                                    <th>S.No</th>
                                                    <th>Ticket No</th>
                                                    <th>Title</th>
                                                    <th>Company</th>
                                                    <th>Completed Date</th>
                                                    <th>Due Date</th>
                                                    <th>Bussiness Units</th>
                                                    <th>Reported By Name</th>
                                                    <th>Type</th>
                                                    <th>Status</th>
                                                    <th>Priority</th>
                                                    <th>Impact</th>
                                                    <th>Description</th>
                                                    <th>Complaint Mode</th>
                                                    <th>Store Contact</th>
                                                    <th>Remarks</th>


                                                </tr>
                                                <!-- <tr>
                                                                                                    <th>S.No</th>
                                                    <th>Ticket No</th>
                                                    <th>Title</th>
                                                    <th>Company</th>
                                                    <th>Completed Date</th>
                                                    <th>Due Date</th>
                                                    <th>Bussiness Units</th>
                                                    <th>Reported By Name</th>
                                                    <th>Type</th>
                                                    <th>Status</th>
                                                    <th>Priority</th>
                                                    <th>Impact</th>
                                                    <th>Description</th>
                                                    <th>Complaint Mode</th>
                                                    <th>Store Contact</th>
                                                    <th>Remarks</th>
                                                    <th>Remarks</th>
                                                    <th>Remarks</th>
                                                    <th>Remarks</th>


                                               </tr>  -->
                                            </thead>

                                            <tbody>

                                            </tbody>
                                            <!-- <tfoot>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Ticket No</th>
                                                    <th>Title</th>
                                                    <th>Company</th>
                                                    <th>Completed Date</th>
                                                    <th>Due Date</th>
                                                    <th>Bussiness Units</th>
                                                    <th>Reported By Name</th>
                                                    <th>Type</th>
                                                    <th>Status</th>
                                                    <th>Priority</th>
                                                    <th>Impact</th>
                                                    <th>Description</th>
                                                    <th>Complaint Mode</th>
                                                    <th>Store Contact</th>
                                                    <th>Remarks</th>
                                                    <th>Import</th>
                                                    <th>Produced</th>
                                                    <th>F1</th>


                                                </tr>

                                            </tfoot> -->

                                        </table>
                                    </div>

                                </div>
                            </div>



                        </div>



                    </div>

                    <!-- Edit chart Modal -->

                    <div class="modal fade" id="edit_chart_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Graph</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <div id="chart_div">

                                            <label for="chart_select" style="font-size:13px; margin-top: 4px">
                                                Chart Type
                                            </label>
                                            <select class="form-select" aria-label="Default select example">
                                                <option selected>Open this select menu</option>
                                                <option value="0">Pie</option>
                                                <option value="1">Bar</option>
                                                <option value="2">Line</option>
                                            </select>
                                        </div>

                                        <div id="x_field" class=" d-none">

                                            <label for="XSelect" style="font-size:13px; margin-top: 4px">
                                                X-Axis
                                            </label>
                                            <select id="XXSelect" class="form-select form-select-lg mb-3"
                                                aria-label=".form-select-lg example">
                                            </select>
                                        </div>
                                        <div id="y_field" class=" d-none">
                                            <label for="YSelect" style="font-size:13px; margin-top: 4px">
                                                Y-Axis
                                            </label>
                                            <select id="YYSelect" class="form-select form-select-sm"
                                                aria-label=".form-select-sm example">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="modal_btn_2" class="btn btn-secondary"
                                        data-bs-dismiss="modal" onclick="get_field()">Save</button>
                                    <!-- <button type="button" class="btn btn-primary">Send message</button> -->
                                </div>
                            </div>
                        </div>
                    </div><!--  -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Graph</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">

                                        <label for="XSelect" style="font-size:13px; margin-top: 4px">
                                            X-Axis
                                        </label>
                                        <select id="XSelect" class="form-select form-select-lg mb-3"
                                            aria-label=".form-select-lg example">
                                        </select>
                                        <label for="YSelect" style="font-size:13px; margin-top: 4px">
                                            Y-Axis
                                        </label>
                                        <select id="YSelect" class="form-select form-select-sm"
                                            aria-label=".form-select-sm example">
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="modal_btn" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Save</button>
                                    <!-- <button type="button" class="btn btn-primary">Send message</button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--  -->
                    <div class="modal fade" id="ticket_filter_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <!-- <h5 class="modal-title" id="myModalLabel">Create Permit Type</h5> -->
                                    <h5 class="modal-title" id="myModalLabel">
                                    </h5>
                                    <h5 id="label">Save View</h5>

                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">


                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row">
                                                <label for="example-text-input" class="col-auto form-label">View
                                                    Name</label>

                                                <input type="text" class="col-auto form-control" id="filter_name">


                                            </div>

                                        </div>

                                        <div class="col-12 mt-3" style="text-align: right;">

                                            <button type="button" class="btn btn-secondary waves-effect"
                                                data-bs-dismiss="modal">Close</button>
                                            <input class="btn btn-primary waves-effect waves-light" type="submit"
                                                name="app_btn" id="view_btn" onclick="save_filters()" value="Save">
                                        </div>
                                    </div>


                                </div>

                            </div><!-- /.modal-content -->
                        </div>
                    </div>

                    <!--  -->
                    <div class="modal fade" id="ticket_view_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <!-- <h5 class="modal-title" id="myModalLabel">Create Permit Type</h5> -->
                                    <h5 class="modal-title" id="myModalLabel">
                                    </h5>
                                    <h5 id="label">Views</h5>

                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">


                                    <div class="row">
                                        <div class="col-12">
                                            <ul style="list-style: none;" id="view_list">
                                            </ul>

                                        </div>

                                        <div class="col-12 mt-3" style="text-align: right;">

                                            <!-- <button type="button" class="btn btn-secondary waves-effect"
                                                data-bs-dismiss="modal">Close</button>
                                            <input class="btn btn-primary waves-effect waves-light" type="submit"
                                                name="app_btn" id="view_btn" onclick="save_filters()" value="Save"> -->
                                        </div>
                                    </div>


                                </div>

                            </div><!-- /.modal-content -->
                        </div>
                    </div>

                    @include('partials.footer')
                    @include('partials.right_bar')

                    <script src="{{ asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>


                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
                        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
                        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
                    <script src="https://cdn.datatables.net/buttons/3.2.0/js/dataTables.buttons.min.js"></script>
                    <script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.colVis.min.js"></script>
                    <script src="https://cdn.datatables.net/colreorder/2.0.4/js/dataTables.colReorder.min.js"></script>
                    <script src="https://cdn.datatables.net/rowgroup/1.5.1/js/dataTables.rowGroup.min.js"></script>
                    <script src="https://cdn.datatables.net/buttons/3.2.0/js/dataTables.buttons.js"></script>
                    <script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.html5.js"></script>

                    <script src="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/3.0.7/metisMenu.min.js"
                        integrity="sha512-o36qZrjup13zLM13tqxvZTaXMXs+5i4TL5UWaDCsmbp5qUcijtdCFuW9a/3qnHGfWzFHBAln8ODjf7AnUNebVg=="
                        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
                    <!-- col re order -->
                    <script src="https://cdn.datatables.net/colreorder/2.0.4/js/dataTables.colReorder.min.js"></script>
                    <!--  -->
                    @include('partials.script2')

                </div>
            </div>
        </div>


        <script>
        let distinctValues = {
            resolved_name: [],
            company_name: [],
            title: [],
            completed_date: [],
            due_date: [],
            assigned_to: [],
            bu_name: [],
            reported_by_name: [],
            type_title: [],
            status_title: [],
            priority_title: [],
            impact_title: [],
            customer: [],
            bu_field_name: [],
            created_at: []
            // ,
            // month: [],
            // day: [],
            // year: []

        };
        let date_fields = ["created_at", "completed_date", "due_date"];
        let selected_groups = [];
        var col_index = {
            "title": 2,
            "company_name": 3,
            "completed_date": 4,
            "due_date": 5,
            "bu_name": 6,
            "resolved_name": 7,
            "reported_by_name": 7,
            "type_title": 8,
            "status_title": 9,
            "priority_title": 10,
            "impact_title": 11
        }
        let XField;
        let YField;
        let fil_group_obj;
        let created_at_max = 0;
        let created_at_min = 0;
        let completed_date_max = 0;
        let completed_date_min = 0;
        let due_date_max = 0;
        let due_date_min = 0;



        let line_chart;
        let pie_chart;
        let bar_chart;
        let chart_val = "1";
        let groups = []
        var count_array = {}
        let group_no = 1
        let filtered_data_filter;
        $(document).ready(function() {

            $("#datepicker-range").flatpickr({
                mode: 'range',
                dateFormat: "Y-m-d"
            });
            fetch('api/retrieve_views/{{Auth::user()->id}}', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer your-token'
                    }
                })
                .then(response => response.json()) // or response.text() for non-JSON responses
                .then(response => {
                    console.log("Fetch", response);
                    let ul = document.getElementById('view_list');
                    response.forEach((value) => {
                        let li = document.createElement('li'); // Corrected typo
                        li.innerHTML =
                            `<input type="radio" name = "view_radio" id="${value["view_id"]}"> ${value["view_name"]}`;
                        ul.appendChild(li);
                    });
                })
                .catch(error => console.error('Error:', error));







            $.ajax({
                url: "api/totalticketscompany_wise/{{Auth::user()->company_id}}",
                method: "GET",
                timeout: 0,
            }).done(function(response) {
                // console.table(response);

                data = response;
                console.log(response)
                const static_fields = document.getElementById('static_fields');
                const g_static_fields = document.getElementById('group_static_fields');

                let ul_list = document.createElement('ul')
                let items = ""

                created_at_max = response[0]["created_at"];
                created_at_min = response[0]["created_at"];
                completed_date_max = response[0]["completed_date"];
                completed_date_min = response[0]["completed_date"];
                due_date_max = response[0]["due_date"];
                due_date_min = response[0]["due_date"];


                // Loop through the API result and extract distinct values
                response.forEach(item => {

                    if (item.resolved_name && !distinctValues.resolved_name.includes(item
                            .resolved_name)) {
                        distinctValues.resolved_name.push(item.resolved_name);
                    }
                    if (item.company_name && !distinctValues.company_name.includes(item
                            .company_name)) {
                        distinctValues.company_name.push(item.company_name);
                    }
                    if (item.title && !distinctValues.title.includes(item.title)) {
                        distinctValues.title.push(item.title);
                    }
                    if (item.completed_date && !distinctValues.completed_date.includes(item
                            .completed_date)) {
                        distinctValues.completed_date.push(item.completed_date);
                    }
                    if (item.due_date && !distinctValues.due_date.includes(item.due_date)) {
                        distinctValues.due_date.push(item.due_date);
                    }
                    /*                                        if (item.assigned_to && !distinctValues.assigned_to.includes(String(item.assigned_to))) {
                                                                distinctValues.assigned_to.push(String(item.assigned_to));
                                                            }
                                                                */
                    if (item.bu_name && !distinctValues.bu_name.includes(item.bu_name)) {
                        distinctValues.bu_name.push(item.bu_name);
                    }
                    if (item.reported_by_name && !distinctValues.reported_by_name.includes(item
                            .reported_by_name)) {
                        distinctValues.reported_by_name.push(item.reported_by_name);
                    }
                    if (item.type_title && !distinctValues.type_title.includes(item
                            .type_title)) {
                        distinctValues.type_title.push(item.type_title);
                    }
                    if (item.status_title && !distinctValues.status_title.includes(item
                            .status_title)) {
                        distinctValues.status_title.push(item.status_title);
                    }
                    if (item.priority_title && !distinctValues.priority_title.includes(item
                            .priority_title)) {
                        distinctValues.priority_title.push(item.priority_title);
                    }
                    if (item.impact_title && !distinctValues.impact_title.includes(item
                            .impact_title)) {
                        distinctValues.impact_title.push(item.impact_title);
                    }
                    if (item.customer && !distinctValues.customer.includes(item.customer)) {
                        distinctValues.customer.push(item.customer);
                    }

                    if (item.customer && !distinctValues.customer.includes(item.customer)) {
                        distinctValues.customer.push(item.customer);
                    }

                    if (item.bu_field_name && !distinctValues.bu_field_name.includes(item
                            .bu_field_name)) {
                        distinctValues.bu_field_name.push(item.bu_field_name);
                    }
                    if (item.created_at && !distinctValues.created_at.includes(item
                            .created_at)) {
                        distinctValues.created_at.push(item.created_at);
                    }

                    if (item.created_at > created_at_max) {
                        created_at_max = item.created_at
                    }
                    if (item.created_at < created_at_min) {
                        created_at_min = item.created_at
                    }
                    // 
                    if (item.completed_date > completed_date_max) {
                        completed_date_max = item.completed_date
                    }
                    if (item.completed_date < completed_date_min) {
                        completed_date_min = item.completed_date
                    }
                    // 
                    if (item.due_date > due_date_max) {
                        due_date_max = item.due_date
                    }
                    if (item.due_date < due_date_min) {
                        due_date_min = item.due_date
                    }


                });
                console.log("created_at_max ", created_at_max)
                console.log("created_at_min ", created_at_min)
                // 
                console.log("completed_date_max ", completed_date_max)
                console.log("completed_date_min ", completed_date_min)
                // 
                console.log("due_date_max ", due_date_max)
                console.log("due_date_min ", due_date_min)



                // generating fields
                const table_rec = document.querySelector('#table_records');
                distinctValues.bu_field_name.forEach((field) => {
                    const th = document.createElement('th'); // Create a new <th> element
                    th.textContent = field; // Set the header text
                    table_rec.appendChild(th);
                });
                // console.log("User id =>", {{Auth::user()->id}})
                table = $('#myTable').DataTable({
                    dom: 'Bfrtip',
                    scrollX: true,


                    columnDefs: [{
                        targets: '_all',
                        visible: false
                    }],
                    buttons: [{
                            extend: 'colvis',
                            text: 'Column Visibility',
                            //postfixButtons: ['colvisRestore'],
                            action: function(e, dt, button, config) {
                                // Use the generic collection action
                                $.fn.dataTable.ext.buttons.collection.action.call(this,
                                    e, dt, button, config);

                                // Check if the search bar is already appended
                                if (!$('.colvis-search').length) {
                                    // Append a search bar to the dropdown
                                    var $searchInput = $('<input>', {
                                        type: 'text',
                                        class: 'colvis-search',
                                        placeholder: 'Search columns...',
                                        style: 'width: 100%; margin: 5px 0; padding: 5px; box-sizing: border-box;'
                                    }).on('keyup', function() {
                                        var query = $(this).val().toLowerCase();
                                        $('.dt-button-collection div[role="menu"] button')
                                            .each(function() {
                                                var buttonText = $(this)
                                                    .text().toLowerCase();
                                                var $button = $(
                                                    this
                                                ); // Cache the button element

                                                if (buttonText.includes(
                                                        query
                                                    )) { // Use .includes() for simpler check
                                                    $button.show();
                                                } else {
                                                    $button.hide();
                                                }
                                            });
                                    });

                                    // Stop propagation of click events on the search input
                                    $searchInput.on('click', function(e) {
                                        e.stopPropagation();
                                    });

                                    // Append the search bar to the dropdown menu
                                    $('.dt-button-collection').prepend($searchInput);
                                }
                            }
                        },
                        'copy', 'csv', 'excel', 'pdf', 'print'

                    ]
                });





                console.log("Distinct values:", distinctValues);

                const inputFields = [
                    "company_name",
                    "bu_name",
                    "priority_title",
                    "impact_title",
                    // "customer",
                    "resolved_name",
                    "reported_by_name",
                    "title",
                    "completed_date",
                    "due_date",
                    "type_title",
                    "status_title",
                    "bu_field_name",
                    "field_type",
                    "field_data",
                    "created_at"
                    // ,
                    // "year",
                    // "month",
                    // "day"
                ];
                // let select = document.createElement('static_dropdown');
                let opt = `<select class="selectpicker" 
                id="static_dropdown" 
                multiple 
                title="No Filter Selected"
                data-selected-text-format="count > 999" 
                data-live-search="true">`;

                let g_opt = `<select class="selectpicker" 
                id="g_static_dropdown" 
                multiple 
                title="No Group Selected"
                data-selected-text-format="count > 999" 
                data-live-search="true">`;

                inputFields.forEach(field => {
                    opt += `<option value="${field}">${field}</option>`;
                    g_opt += `<option value="${field}">${field}</option>`;
                });

                opt += `</select>`;
                g_opt += `</select>`;

                static_fields.innerHTML = opt;
                g_static_fields.innerHTML = g_opt;

                $('#static_dropdown').selectpicker('render');
                $('#g_static_dropdown').selectpicker('render');


                update_table(data, table);
            });
        });

        $(document).on('change', '#chart_div select', function() {
            let chart = $(this).val();
            let group_no = $(this)
            chart_val = $(this).val();
            // let field = fieldLabel.toLowerCase().replace(/ /g, "_");
            // console.log(fieldLabel)
            if (chart == 0) {
                $('#x_field').removeClass("d-none");
                $('#y_field').addClass("d-none");
                if (YField) {
                    YField.destroy()
                }
            } else if (chart == 1 || chart == 2) {
                $('#x_field').removeClass("d-none");
                $('#y_field').removeClass("d-none");

            }


            // selectedValues[field] = $(this).val() || [];

            // console.log(selectedValues);
            // applyFilters();
            // update_record_box(field);
        });
        $(document).on('change', '#filter_fields select', function() {
            let fieldLabel = $(this).closest('.filter-field-container').find('label').text().trim();
            let field = fieldLabel.toLowerCase().replace(/ /g, "_");

            selectedValues[field] = $(this).val() || [];

            console.log(selectedValues);
            applyFilters();
            // update_record_box(field);
        });

        // colun rename
        $('#view_list').on('change', 'input[type = "radio"]', function() {
            // console.log("hell")
            let v_id = $(this).attr('id')
            var settings = {
                "url": `api/retrieve_view/${v_id}`,
                "method": "GET",
                "timeout": 0,
                "processData": false,
                "mimeType": "multipart/form-data",
                "contentType": "application/json"
            };
            // console.log("Object before sending ", filtered_data_filter)



            $.ajax({
                ...settings,
                statusCode: {
                    200: function(response) {
                        // response = response.json();
                        let data = typeof response === "string" ? JSON.parse(response) : response;
                        let tickets = JSON.parse(data[0]["data"]);
                        console.log("Response:", tickets);
                        draw_table(tickets, table);
                        $('#ticket_view_modal').modal('hide');


                        Swal.fire(
                            'Success!',
                            'View Retrieved Successfully',
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
                    Swal.fire(
                        'Server Error!',
                        'Filter Not Created',
                        'error'
                    )

                    // console.log("Request failed with status code: " + xhr.status);
                }
            });
        })



        $(document).on('change', '#table_filter', function() {
            let chart_val = $(this).find(':selected').val();
            let group_no = $(this).find(':selected').text();
            let field_name = $(this).find(':selected').attr('name');
            if (chart_val == "all") {
                update_table(data, table);
            } else {
                let ft_data = table_filter(chart_val, field_name)
                update_table(ft_data, table);
            }



            console.log(chart_val, group_no)
        });

        // $('#myTable tbody').on('click', 'td', function() {
        //     var idx = table.cell(this).index().column;
        //     var title = table.column(idx).header();
        //     /*
        //     initComplete: function () {
        //             this.api()
        //                 .columns()
        //                 .every(function () {
        //                     let column = this;
        //                     let column_header = column.header();
        //                     let title = column.footer().textContent;

        //                     // Create input element
        //                     let input = document.createElement('input');
        //                     input.placeholder = title;
        //                     column.footer().replaceChildren(input);

        //                     // Event listener for user input
        //                     input.addEventListener('keyup', () => {
        //                         let col_name = this.value;
        //                         $(column_header).text(col_name);
        //                     });
        //                 });
        //         }
        //     */
        //     alert('Column title clicked on: ' + $(title).html());
        //     $(title).text("hell!")
        // });

        // $('#myTable tbody').on('click', 'td', function() {
        //     var idx = table.cell(this).index().column;
        //     var data_value = table.column(idx).data().toArray();
        //     // console.log(title)
        //     let total = data_value.length;
        //     let num_array = data_value.filter((Number))
        //     let sum = num_array.reduce((a, b) => a + b, 0)
        //     let average = sum / total;
        //     let max = Math.max(...num_array);
        //     $('#total_count').text(total.toFixed(1));
        //     $('#total_sum').text(sum.toFixed(1));
        //     $('#average').text(average.toFixed(1));
        //     $('#max').text(max.toFixed(1));


        //     // alert('Column title clicked on: ' + $(title).text());
        //     // console.log(num_array)
        //     // console.log(sum)
        //     // console.log(total)
        //     // console.log(average)
        // });

        $('#group_button').on('click', function() {
            const selectedLabels = [];
            let groups_con = $('#group_fields input[type="checkbox"]:checked');
            // Find all checkboxes within #group_fields that are checked
            if (groups_con.length > 0) {
                groups_con.each(function() {
                    // Get the label text next to each checked checkbox
                    const labelText = $(this).next('label').text();
                    selectedLabels.push(labelText);
                });
                groups.push({
                    ["group_" + group_no]: selectedLabels
                })


                display_groups()
                group_no += 1
                // update_table(data)
                // order_table()
            }
            // console.log(groups)
        });

        $(document).on('click', '#modal_btn', function() {

            seprate_array(fil_group_obj);
        });

        $('#groups_overlay').on('change', 'input[type="radio"]', function() {

            let div = this.closest('div')
            let group = div.querySelector('label'); // Find the <label> inside the div
            let labelText = group ? group.textContent : null; // Get the label's text content
            console.log(labelText);
            order_table(labelText)
            // display_chart(x-axis, y_axis)
            append_xy(labelText)
        });


        $('#save_view_btn').on('click', function() {
            $('#ticket_filter_modal').modal("show");
        })
        $('#save_view_btn').on('click', function() {
            $('#ticket_filter_modal').modal("show");
        })
        $('#find_view_btn').on('click', function() {
            $('#ticket_view_modal').modal("show");
        })

        let selected_values = []
        // !!!!!!1!!!!!!!!!!!!!!!!!!!!!!!!!!!!1!!!
        // change the event binding in accrodance with the dropdown
        // -----------------------------------------------------------------------------
        $(document).on('change', '#static_dropdown', function() {
            const selectedFields = $(this).find('option:selected').map(function() {
                return $(this).val().replace(/ /g, "_");
            }).get();

            selectedFields.forEach(field => {
                if (!selected_values.includes(field)) {
                    selected_values.push(field);
                    if (date_fields.includes(field)) {
                        date_field_filter(field);
                    } else {
                        add_field_filter(field);
                    }
                }
            });

            selected_values = selected_values.filter(field => {
                if (!selectedFields.includes(field)) {
                    remove_field_filter(field);
                    return false;
                }
                return true;
            });

            $('#save_view_btn').css('display', 'block');

            // ✅ Force update display text
            const button = $('#static_dropdown').parent().find('button.dropdown-toggle');
            if (selectedFields.length > 0) {
                button.attr('title', 'Filter Selected').find('.filter-option-inner-inner').text(
                    'Filter Selected');
            } else {
                button.attr('title', 'No Filter Selected').find('.filter-option-inner-inner').text(
                    'No Filter Selected');
            }
        });


        // group static dropdown
        $(document).on('change', '#g_static_dropdown', function() {
            const selectedFields = $(this).find('option:selected').map(function() {
                return $(this).val().replace(/ /g, "_");
            }).get();

            selectedFields.forEach(field => {
                if (!selected_groups.includes(field)) {
                    selected_groups.push(field);
                    update_record_box(field);
                }
            });

            selected_groups = selected_groups.filter(field => {
                if (!selectedFields.includes(field)) {
                    let id = `.${field}Container`;
                    let elem = document.querySelector(id);
                    if (elem) elem.remove();
                    return false;
                }
                return true;
            });

            // ✅ Force update display text
            const button = $('#g_static_dropdown').parent().find('button.dropdown-toggle');
            if (selectedFields.length > 0) {
                button.attr('title', 'Group Selected').find('.filter-option-inner-inner').text(
                'Group Selected');
            } else {
                button.attr('title', 'No Group Selected').find('.filter-option-inner-inner').text(
                    'No Group Selected');
            }
        });



        function order_table(group_no) {
            update_table(data, table)

            groups.forEach(group => {

                if (Object.keys(group).includes(group_no)) {

                    let group_obj = group[group_no];
                    let order_array = []
                    let col = group_obj.map(elem => {
                        if (col_index[elem] !== undefined) {

                            return col_index[elem];
                        }
                        return null;
                    }).filter(item => item !== null);
                    // g_group = col[0]

                    grouping_table(col);
                    // order_array.push(...col); // Use spread to flatten
                    // table.order(order_array).draw();
                }

            });


        }


        function table_filter(value, field) {
            value = parseInt(value)
            let result = data.filter(item => item[field] == value);
            return result;
            // console.log("filtered results len ", result.length);
            // response.filter(item => item["assigned_to"] === 61);
        }

        function save_filters() {

            let v_id = (Math.random() * 1000);
            let v_name = document.getElementById("filter_name").value;
            // filtered_data_filter["view_id"] = (Math.random() * 1000);
            filtered_data_filter.forEach((value) => {

                delete value["number"];
                value["view_id"] = v_id;
                value["view_name"] = v_name;
            })
            var settings = {
                "url": "api/save_view/{{Auth::user()->id}}",
                "method": "POST",
                "timeout": 0,
                "processData": false,
                "mimeType": "multipart/form-data",
                "contentType": "application/json",
                "data": JSON.stringify(filtered_data_filter)
            };
            console.log("Object before sending ", filtered_data_filter)

            $.ajax({
                ...settings,
                statusCode: {
                    200: function(response) {
                        console.log(response);

                        $('#ticket_filter_modal').modal('hide');


                        Swal.fire(
                            'Success!',
                            'View Saved Successfully',
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
                    Swal.fire(
                        'Server Error!',
                        'Filter Not Created',
                        'error'
                    )

                    // console.log("Request failed with status code: " + xhr.status);
                }
            });

        }

        function grouping_table(ind_arr) {

            table.destroy()
            count_array = {};
            table = $('#myTable').DataTable({
                dom: 'Bfrtip', // Include 'B' for buttons
                scrollX: true,
                colReorder: true,
                // pageLength: 10,
                buttons: ['colvis', 'copy', 'csv', 'excel', 'pdf', 'print'], // Enable column visibility button
                columnDefs: [{
                        targets: [0],
                        visible: true
                    },
                    {
                        targets: [1, 2],
                        visible: false
                    },
                ],
                rowGroup: {
                    dataSrc: ind_arr, // Initial grouping column
                    startRender: function(rows, group) {
                        // console.log("Rows:", rows);

                        var totalRows = rows.count();
                        // console.log("Total Rows:", totalRows);
                        // count_array.push(totalRows);
                        count_array[group] = rows.count();
                        // console.log(group);
                        // console.log(rows.count());

                        return $('<tr/>')
                            .append('<td colspan="' + rows.columns().length +
                                '" class = "group_count">Group: ' + group +
                                ' | Total Tickets: ' + totalRows + '</td>'
                                // <td colspan="' + rows.columns().length + '">' | Total Tickets: ' + totalRows + '</td>'
                            ); // Optionally add a class for styling
                    }
                    // <td colspan="1">Group: HQ Yahya Garments | Total Tickets: 6</td>
                },




            });
            console.log(count_array);

        }

        function display_groups() {
            const group_overlay = document.getElementById('groups_overlay');
            group_overlay.innerHTML = "";
            let num = 1;
            groups.forEach(function(group) {
                // let group_key = Object.keys(group)[0]
                let div = document.createElement('div');
                div.id = `group_container_${num}`;
                div.className = "d-flex justify-content-between"
                let hr = document.createElement('hr')
                console.log(groups)
                Object.entries(group).forEach(([groupName, values]) => {
                    let div_child = document.createElement('div');
                    let div_child_2 = document.createElement('div');
                    div_child_2.classList.add('d-flex', 'justify-content-center');
                    // div
                    div_child_2.innerHTML = `<button type="button"
            class="btn btn-danger waves-effect waves-light"
            id="container_${num}"
            onclick="remove_group('group_container_${num}', '${groupName}')"
             style="height:30px; font-size: 10px">
        <i class="mdi mdi-trash-can"></i>
    </button>
    <button type="button"
            class="btn btn-success waves-effect waves-light"
            id="edit_chart_${num}"
             onclick="edit_chart_xy('group_${num}')"
             style="height:30px; font-size: 10px">
       <i class="mdi mdi-pencil"></i></i>
    </button>
`
                    const radioInput = document.createElement('input');

                    // Set attributes for the radio button
                    radioInput.setAttribute('type', 'radio'); // Set type as 'radio'
                    radioInput.setAttribute('name',
                        'group1'); // Set the name to group the radio buttons
                    radioInput.setAttribute('id', `radio_${num}`); // Set an ID
                    radioInput.setAttribute('value', 'option1'); // Set the value

                    // Optionally add a label for the radio button
                    const label = document.createElement('label');
                    label.style.marginLeft = "3px";
                    label.setAttribute('for', `radio_${num}`); // Match the ID of the radio input
                    label.setAttribute('id',
                        `radio_label_${num}`); // Match the ID of the radio input

                    label.textContent = `${groupName}`;
                    // label.style.margin-left = '5px';
                    div_child.appendChild(radioInput);
                    div_child.appendChild(label);

                    values.forEach(val => {
                        let itemDiv = document.createElement('label');
                        itemDiv.textContent = val;
                        itemDiv.style.margin = "3px";
                        div_child.appendChild(itemDiv);
                        div_child.appendChild(hr);

                    });
                    div.appendChild(div_child)
                    div.appendChild(div_child_2)

                });
                num++;

                group_overlay.appendChild(div);
                // filterDataByGroups(data, groups)
            });
        }

        function remove_group(elem, g_k) {

            // console.log(table);
            table.destroy();
            table = $('#myTable').DataTable({
                colReorder: true

            });
            // Find the specific container to remove
            const div = $(`#${elem}`);
            // console.log(group)

            div.remove(); // Remove the specific div
            groups = groups.filter(group => {
                const groupKey = Object.keys(group)[0]; // Get the key of the current object
                return groupKey !== g_k; // Only keep groups where the key does not match
            });
            // console.log(`Removed group_container_${idNumber} updated array = ${groups   }`);
            console.log(groups)
            // console.log(`Div with id group_copxntainer_${idNumber} not found`);
        }


        function date_field_filter(field) {
            const filter_cont = document.getElementById('filter_fields');
            let div = document.createElement('div');
            let id = `${field}Range`
            let min = new Date(eval(`${field}_min`));
            let max = new Date(eval(`${field}_max`));
            div.className = "filter-field-container col-3";
            div.setAttribute("data-field", field); // Add an identifier for easy removal


            div.innerHTML = `
        <label for="${field}Select" style="font-size:13px; margin-top: 4px">
            ${field.charAt(0).toUpperCase() + field.slice(1).toLowerCase().replace(/_/g, " ")}
        </label>
        <input type="text" class="form-control flatpickr-input" id="${id}"
                                            readonly="readonly">    `;
            filter_cont.appendChild(div);
            // append_choices(field);
            $(`#${id}`).flatpickr({
                mode: "range",
                dateFormat: "YYYY-MM-DD HH:MM",
                minDate: min,
                maxDate: max, // 14 days from now
                onClose: function(selectedDates) {
                    if (selectedDates.length === 2) {
                        // const formattedDate = yourDate.toISOString().split('T')[0];
                        const fromDate = selectedDates[0].toISOString().split('T')[0];
                        const toDate = selectedDates[1].toISOString().split('T')[0];

                        selectedValues[field] = [fromDate, toDate];
                        update_record_box(field);
                        filter_date(field, fromDate, toDate); // Pass dates to function

                    }
                }
            });

        }


        function add_field_filter(field) {
            const filter_cont = document.getElementById('filter_fields');
            let div = document.createElement('div');
            div.className = "filter-field-container col-3";
            div.setAttribute("data-field", field); // Add an identifier for easy removal
            div.innerHTML = `
        <label for="${field}Select" style="font-size:13px; margin-top: 4px">
            ${field.charAt(0).toUpperCase() + field.slice(1).toLowerCase().replace(/_/g, " ")}
        </label>
        <select id="${field}Select" name="${field}Select" class="form-select" multiple></select>
    `;
            filter_cont.appendChild(div);
            append_choices(field);
        }

        function remove_field_filter(field) {
            const filter_cont = document.getElementById('filter_fields');
            const fieldElement = filter_cont.querySelector(`[data-field="${field}"]`);
            if (fieldElement) {
                filter_cont.removeChild(fieldElement);
            }
            const div = document.querySelector(`.${field}Container`);
            if (div) {
                const cont = document.getElementById('group_fields');
                cont.removeChild(div)
                selectedValues[field] = []
                console.log(selectedValues)
            }
        }

        function update_record_box(ref) {
            const group_field = document.getElementById('group_fields');
            // const selectedItems = selectedValues[ref];

            // Check if selectedValues[ref] has items
            let div = document.querySelector(`.${ref}Container`);

            // Create the div if it doesn't exist
            if (!div) {
                div = document.createElement('div');
                div.className = `${ref}Container`;
                group_field.appendChild(div);
            }

            // Prepare content for the div
            let content = `<input type="checkbox" style="margin-right: 3px"><label>${ref}</label><br>`;

            // Update the div's inner HTML with the content
            div.innerHTML = content + `<hr style = "margin: 5px 0px">`;
            $('#group_button').show()
            // else {
            //     // If there are no selected items, remove the div
            //     let divToRemove = document.querySelector(`.${ref}Container`);
            //     if (divToRemove) {
            //         divToRemove.remove();
            //     }
            // }
        }


        function append_choices(field) {
            let choicesField = new Choices(`#${field}Select`, {
                removeItemButton: true,
            });

            // Clear existing choices before setting new ones
            choicesField.clearChoices();

            // Map the array from distinctValues to create an array of objects with 'value' and 'label'
            let formattedChoices = distinctValues[field].map(item => ({
                value: item,
                label: item
            }));

            // Set the new choices in the dropdown
            choicesField.setChoices(formattedChoices, 'value', 'label', false);



        }

        function edit_chart_xy(group_no) {
            if (XField) {
                XField.destroy()
            }
            if (YField) {
                YField.destroy()
            }

            XField = new Choices(`#XXSelect`, {
                removeItemButton: true,
            });

            // Clear existing choices before setting new ones
            XField.clearChoices();

            if (YField) {
                YField.destroy()
            }

            YField = new Choices(`#YYSelect`, {
                removeItemButton: true,
            });

            // Clear existing choices before setting new ones
            YField.clearChoices();
            console.log(typeof(group_no))
            //  group_no = "group_1"; // Example value
            fil_group_obj = groups.filter((group) => {
                return Object.keys(group)[0] === group_no;
            });

            // console.log("Group Obj ", fil_group_obj);
            // Map the array from distinctValues to create an array of objects with 'value' and 'label'
            let formattedChoices = fil_group_obj[0][group_no].map(item => ({
                value: item,
                label: item
            }));

            // Set the new choices in the dropdown
            XField.setChoices(formattedChoices, 'value', 'label', false);
            YField.setChoices(formattedChoices, 'value', 'label', false);
            // $('#modal_btn').attr('onclick', `seprate_array(${group_obj})`);
            // $('#exampleModal').modal("show")
            $('#edit_chart_modal').modal('show')
        };



        function draw_pie_chart(field) {
            let labels = distinctValues[field];
            let count = {};

            distinctValues[field].forEach((value) => {
                let field_results = data.filter((item) => {
                    return item[field] == value;
                })

                count[value] = field_results.length;
            })

            console.log("Pie x ccounts ", count);
            // chart part
            if (line_chart) {
                line_chart.destroy()
            } else if (pie_chart) {
                pie_chart.destroy();
            } else if (bar_chart) {
                bar_chart.destroy();
            }


            var options = {
                series: Object.values(count),
                chart: {
                    width: 450,
                    type: 'pie',
                },
                labels: Object.keys(count),
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 400
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };
            pie_chart = new ApexCharts(document.querySelector("#myPieChart"), options);
            pie_chart.render();
            $("#myPieChart").removeClass("d-none");
        }

        function get_field() {
            if (typeof(XField.getValue(true)) == typeof(YField.getValue(true))) {
                let val = XField.getValue(true)
                let val_y = YField.getValue(true)
                seprate_array(val_y);
                // console.log(typeof(XField))
                // console.log(typeof(YField))
                // draw_line_chart(val);
            } else {
                let val = XField.getValue(true)
                draw_pie_chart(val);
            }

        }



        function append_xy(group_no) {
            if (XField) {
                XField.destroy()
            }

            XField = new Choices(`#XSelect`, {
                removeItemButton: true,
            });

            // Clear existing choices before setting new ones
            XField.clearChoices();

            if (YField) {
                YField.destroy()
            }

            YField = new Choices(`#YSelect`, {
                removeItemButton: true,
            });

            // Clear existing choices before setting new ones
            YField.clearChoices();
            console.log(typeof(group_no))
            //  group_no = "group_1"; // Example value
            fil_group_obj = groups.filter((group) => {
                return Object.keys(group)[0] === group_no;
            });

            // console.log("Group Obj ", fil_group_obj);
            // Map the array from distinctValues to create an array of objects with 'value' and 'label'
            let formattedChoices = fil_group_obj[0][group_no].map(item => ({
                value: item,
                label: item
            }));

            // Set the new choices in the dropdown
            XField.setChoices(formattedChoices, 'value', 'label', false);
            YField.setChoices(formattedChoices, 'value', 'label', false);
            // $('#modal_btn').attr('onclick', `seprate_array(${group_obj})`);
            $('#exampleModal').modal("show")

        }



        var selectedValues = {
            resolved_name: [],
            company_name: [],
            title: [],
            completed_date: [],
            due_date: [],
            assigned_to: [],
            bu_name: [],
            reported_by_name: [],
            type_title: [],
            status_title: [],
            priority_title: [],
            impact_title: [],
            customer: []
        };

        function filter_date(field, from, to) {
            filtered_data_filter = data.filter(function(tick) { // Correcting the syntax
                if (tick[field] >= from && tick[field] <= to) {
                    return true; // Properly returning a boolean
                }
                return false;
            });
            update_table(filtered_data_filter, table);
        }

        function applyFilters() {

            filtered_data_filter = data.filter(item => {
                return Object.keys(selectedValues).every(field => {
                    // If no filters selected for this field, ignore it
                    if (selectedValues[field].length === 0) return true;
                    return selectedValues[field].includes(item[field]);
                });
            });

            console.table("Filtered Data ", filtered_data_filter)
            update_table(filtered_data_filter, table);
        }

        function filterDataByGroups(data_l, groups) {
            const filteredDataByGroups = [];
            groups.forEach(group => {
                const [groupName, groupValues] = Object.entries(group)[0];

                const filteredData = data_l.filter(ticket => {
                    return groupValues.some(groupValue =>
                        Object.values(ticket).includes(
                            groupValue)
                    );
                });

                update_table(filteredData, table)
            });



            // return filteredDataByGroups; // Return the result as an object containing filtered data for each group
        }
        // let result = filterDataByGroups(data, groups)
        // console.log("Filtered by group " + result)

        function update_table(tdata, table_t) {


            table_t.clear().draw();
            $.each(tdata, function(index, data) {
                let dynamicValues = [];

                // Step 2.1: Loop through distinct `bu_field_name` and get corresponding values
                distinctValues.bu_field_name.forEach(field => {
                    // Use `field` as a key to get the value dynamically from the item
                    const fieldValue = data[field] ||
                        'N/A'; // Fallback to 'N/A' if the field is missing
                    dynamicValues.push(fieldValue);
                });

                table_t.row.add([
                    index + 1,
                    '000' + data.company_id + '-000' + data.business_unit_id + '-' + data.id,
                    data.title,
                    data.company_name,
                    data.id,
                    data.due_date,
                    data.bu_name,
                    data.reported_by_name,
                    data.type_title,
                    data.status_title,
                    data.priority_title,
                    data.impact_title,
                    data.description,
                    data.mode_of_complaint,
                    data.store_contact,
                    data.vendor_r,
                    ...dynamicValues

                    /*   <th>Description</th>
                    <th>Complaint Mode</th>
                                                    <th>Store Contact</th>
                                                    <th>Remarks</th>
                                                    */
                    // Uncomment if you want to include impact_title
                ]).draw(false);
            });
        }

        function draw_table(tdata, table_t) {


            table_t.clear().draw();
            $.each(tdata, function(index, data) {
                table_t.row.add([
                    index + 1,
                    '000' + data.company_id + '-000' + data.business_unit_id + '-' + data.id,
                    data.title,
                    data.company_name,
                    data.id,
                    data.due_date,
                    data.bu_name,
                    data.reported_by_name,
                    data.type_title,
                    data.status_title,
                    data.priority_title,
                    data.impact_title,
                    data.description,
                    data.mode_of_complaint,
                    data.store_contact,
                    data.vendor_r,
                    data.Import,
                    data.F1,
                    data.Produced,

                ]).draw(false);
            });
        }



        function update_filter_box() {

            const filter_field = document.getElementById('filter_box')
            const tr = filter_field.querySelector('tr') || document.createElement('tr')
            tr.innerHTML = ""
            selected_values.forEach(field => {
                let td = document.createElement('td')
                td.innerHTML =
                    `<td>${field.charAt(0).toUpperCase() + field.slice(1).toLowerCase().replace(/_/g, " ")},</td>`
                tr.appendChild(td)
            });
            filter_field.appendChild(tr)
        }






        function seprate_array(group_obj) {
            if (!XField || !YField) {
                console.error("XField or YField is not initialized.");
                return;
            }


            // console.log("X selected: " + XField.getValue(true));
            // console.log("Y selected: " + YField.getValue(true));
            let x_field_obj = filterByDistinctValues(data, XField.getValue(true));

            let y_field_obj = countByPriority(x_field_obj, YField.getValue(true));
            console.log("y count  count", y_field_obj)
            let array = {};
            distinctValues[YField.getValue(true)].forEach((field) => {
                let arr = extractPriorityCounts(y_field_obj, field);
                array[field] = arr;
            });

            // let lowPriorityCounts = extractPriorityCounts(y_field_obj, "Low");
            // let highPriorityCounts = extractPriorityCounts(y_field_obj, "High");
            console.log("x response ", x_field_obj);
            let x_cat = Object.keys(x_field_obj);
            console.log("Counts for indi Y : ", array);
            // console.log("High Priority Counts:", highPriorityCounts);
            console.log("X categories", Object.keys(x_field_obj));
            if (chart_val === "1") {
                display_chart(x_cat, array, YField.getValue(true));
            } else if (chart_val === "2") {
                display_chart_line(x_cat, array, YField.getValue(true));
            }
            // array obj include the count for y-axis fields

        }




        // graph data manipulation
        function filterByDistinctValues(data, key) {
            let filteredData = {};
            console.log("Key : ", key)
            let arr = distinctValues[key];
            console.log("Dist Values ", distinctValues);
            distinctValues[key].forEach((value) => {
                filteredData[value] = data.filter((item) => item[key] === value);
            });

            return filteredData;
        }


        // let filtered_data = filterByDistinctValues(response, "bu_name", distinct_values);

        function countByPriority(filteredData, priorityKey) {
            let counts = {};

            for (let bu in filteredData) {
                // Initialize counts for this BU
                counts[bu] = {
                    total: filteredData[bu].length,
                    priorityCounts: {}
                };

                // Initialize priority counts
                distinctValues[priorityKey].forEach((priority) => {
                    counts[bu].priorityCounts[priority] = 0;
                });

                // Count occurrences of each priority
                filteredData[bu].forEach((item) => {
                    let priority = item[priorityKey];
                    if (priority in counts[bu].priorityCounts) {
                        counts[bu].priorityCounts[priority]++;
                    }
                });
            }

            return counts;
        }


        // let count = countByPriority(filtered_data, distinct_values, "priority_title")
        // console.log(filterByDistinctValues(response, "bu_name", distinct_values));

        // console.log(count);

        function extractPriorityCounts(counts, priorityTitle) {
            let result = [];

            for (let bu in counts) {
                let buData = counts[bu];
                let priorityCount = buData.priorityCounts[priorityTitle] || 0;
                result.push(priorityCount);
            }

            return result;
        }

        // Example Usage



        function display_chart(x_cat, y_counts, y_field) {
            // const categories = Object.keys(x_axis);
            // const buNameData = Object.values(x_axis);
            // const companyNameData = Object.values(x_axis);
            let series_s = [];
            distinctValues[y_field].forEach(field => {
                let obj = {
                    name: field,
                    data: y_counts[field]
                };
                series_s.push(obj);
            })
            console.log("Series : ", series_s);
            if (line_chart) {
                line_chart.destroy()
            } else if (pie_chart) {
                pie_chart.destroy();
            } else if (bar_chart) {
                bar_chart.destroy();
            }
            var options = {
                series: series_s,
                chart: {
                    type: 'bar',
                    height: 350,
                    stacked: true,
                    toolbar: {
                        show: true
                    },
                    zoom: {
                        enabled: true
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        legend: {
                            position: 'bottom',
                            offsetX: -10,
                            offsetY: 0
                        }
                    }
                }],
                plotOptions: {
                    bar: {
                        horizontal: false,
                        borderRadius: 10,
                        borderRadiusApplication: 'end', // 'around', 'end'
                        borderRadiusWhenStacked: 'last', // 'all', 'last'
                        columnWidth: '40%',
                        dataLabels: {
                            total: {
                                enabled: true,
                                style: {
                                    fontSize: '13px',
                                    fontWeight: 900
                                }
                            }
                        }
                    },
                },

                xaxis: {
                    categories: x_cat,
                },
                legend: {
                    position: 'right',
                    offsetY: 40
                },
                fill: {
                    opacity: 1
                }
            };

            // Render the Chart
            line_chart = new ApexCharts(document.querySelector("#myPieChart"), options);
            line_chart.render();

            $("#myPieChart").removeClass("d-none");
        }

        //
        function display_chart_line(x_cat, y_counts, y_field) {
            // const categories = Object.keys(x_axis);
            // const buNameData = Object.values(x_axis);
            // const companyNameData = Object.values(x_axis);
            let series_s = [];
            let colors_s = ["#FF1654", "#247BA0", "#f58002"];
            // colors:
            let y_axis = [];
            let i = 0;
            distinctValues[y_field].forEach(field => {
                let obj = {
                    name: field,
                    data: y_counts[field]
                };
                series_s.push(obj);
                let axis_bool = i > 0 ? true : false;
                let clr = colors_s[i];

                let ind_axis = {
                    opposite: axis_bool,
                    axisTicks: {
                        show: true
                    },
                    axisBorder: {
                        show: true,
                        color: clr
                    },
                    labels: {
                        style: {
                            colors: clr
                        }
                    },
                    title: {
                        text: field,
                        style: {
                            color: clr
                        }
                    }
                }

                y_axis.push(ind_axis);




                i++;
            })
            console.log("Series : ", series_s);
            console.log("Y axes  : ", y_axis);

            if (line_chart) {
                line_chart.destroy()
            } else if (pie_chart) {
                pie_chart.destroy();
            } else if (bar_chart) {
                bar_chart.destroy();
            }

            var options = {
                series: series_s,
                chart: {
                    height: 350,
                    type: "line",
                    stacked: false
                },
                dataLabels: {
                    enabled: false
                },
                colors: colors_s,
                stroke: {
                    width: [4, 4]
                },
                markers: {
                    size: [4, 5]
                },
                plotOptions: {
                    bar: {
                        columnWidth: "20%"
                    }
                },
                xaxis: {
                    categories: x_cat
                },
                yaxis: y_axis,
                tooltip: {
                    shared: false,
                    intersect: true,
                    x: {
                        show: false
                    }
                },
                legend: {
                    horizontalAlign: "left",
                    offsetX: 40
                }
            };
            // Render the Chart
            bar_chart = new ApexCharts(document.querySelector("#myPieChart"), options);
            bar_chart.render();

            $("#myPieChart").removeClass("d-none");
        }
        </script>

        <script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js'>
        </script>
        <script>

        </script>


</body>

</html>