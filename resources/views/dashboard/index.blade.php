<!doctype html>
<html lang="en">


<head>

    <meta charset="utf-8" />
    <title>Dashboard | webadmin - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" /> --}}
    <meta content="Themesdesign" name="author" />
    <link rel="stylesheet" href="cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- App favicon -->
    @include('partials.style')
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
                        <div class="col-12">
                            <div class="row">
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="formrow-inputState" class="form-label">From</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" placeholder="From" id="resolved">
                                        </div>
                                        <br>
                                        <button id="btn1" class="btn btn-soft-primary waves-effect waves-light" onclick="getdate()">GET RECORD</button>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="formrow-inputState" class="form-label">To</label>
                                        <div class="col-md-12">

                                            <input type="text" class="form-control" placeholder="To" id="to">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="formrow-inputState" class="form-label">TimeLine</label>
                                        <div class="col-md-12">
                                            <select class="form-control" id="ticketresolved" placeholder="This is a search placeholder">
                                                <option value="Today">Today</option>
                                                <option value="Weekly">Weekly</option>
                                                <option value="Monthly">Monthly</option>
                                                <option value="Yearly">Yearly</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body pb-0">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="row">
                                                <div class="col-6">

                                                    <h5 class="card-title mb-4">Tickets Overview</h5>
                                                </div>
                                                <div class="col-6 d-flex flex-row-reverse">

                                                    <i class="bx bxs-info-circle" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Ticket OverView Defines The Number of Tickets Recieved in a Complete Year">

                                                    </i>
                                                </div>
                                            </div>

                                        </div>
                                        {{-- <div class="flex-shrink-0">
                                                <div class="dropdown">
                                                    <a class="dropdown-toggle text-reset" href="#" data-bs-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        <span class="fw-semibold">Sort By:</span>
                                                        <span class="text-muted">Yearly<i class="mdi mdi-chevron-down ms-1"></i></span>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" href="#">Yearly</a>
                                                        <a class="dropdown-item" href="#">Monthly</a>
                                                        <a class="dropdown-item" href="#">Weekly</a>
                                                        <a class="dropdown-item" href="#">Today</a>
                                                    </div>
                                                </div>
                                            </div> --}}
                                    </div>

                                    <div>
                                        <div id="toverview" data-colors='["#e6ecf9", "#e6ecf9", "#e6ecf9","#e6ecf9", "#e6ecf9", "#e6ecf9","#e6ecf9","#e6ecf9","#e6ecf9","#1f58c7","#1f58c7", "#1f58c7   "]' class="apex-chart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar">
                                                        <div class="avatar-title rounded bg-soft-primary">
                                                            <i class="fas fa-ticket-alt font-size-24 mb-0 text-primary"></i>
                                                        </div>
                                                    </div>

                                                    <div class="flex-grow-1 ms-3">
                                                        <h6 class="mb-0 font-size-15">Total Tickets</h6>
                                                    </div>

                                                    <div class="flex-shrink-0">
                                                        <div class="dropdown">

                                                            <i class="bx bxs-info-circle" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Total Number of Tickets Compare to Previous Month">

                                                            </i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div>
                                                    <h4 class="mt-4 pt-1 mb-0 font-size-22" id="total_tickets">0<span class="text-success fw-medium font-size-13 align-middle"> <i class="mdi mdi-arrow-up"></i> 8.34% </span> </h4>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar">
                                                        <div class="avatar-title rounded bg-soft-primary">
                                                            <i class="fas fa-clock font-size-24 mb-0 text-primary"></i>
                                                        </div>
                                                    </div>

                                                    <div class="flex-grow-1 ms-3">
                                                        <h6 class="mb-0 font-size-15">Pending Tickets</h6>
                                                    </div>

                                                    <div class="flex-shrink-0">
                                                        <div class="dropdown">

                                                            <i class="bx bxs-info-circle" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Total Number of Pending Tickets Compare to Previous Month">

                                                            </i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div>
                                                    <h4 class="mt-4 pt-1 mb-0 font-size-22" id="pending_tickets">0 <span class="text-danger fw-medium font-size-13 align-middle"> <i class="mdi mdi-arrow-down"></i> 3.68% </span> </h4>
                                                    {{-- <div class="d-flex mt-1 align-items-end overflow-hidden">
                                                            <div class="flex-grow-1">
                                                                <p class="text-muted mb-0 text-truncate">Total Orders World Wide</p>
                                                            </div>
                                                            <div class="flex-shrink-0">
                                                                <div id="mini-2" data-colors='["#1f58c7"]' class="apex-charts"></div>
                                                            </div>
                                                        </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar">
                                                        <div class="avatar-title rounded bg-soft-primary">
                                                            <i class="fas fa-arrow-circle-down font-size-24 mb-0 text-primary"></i>
                                                        </div>
                                                    </div>

                                                    <div class="flex-grow-1 ms-3">
                                                        <h6 class="mb-0 font-size-15">InProgress Tickets</h6>
                                                    </div>

                                                    <div class="flex-shrink-0">
                                                        <div class="dropdown">

                                                            <i class="bx bxs-info-circle" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Total Number of In Progress Tickets Compare to Previous Month">

                                                            </i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div>
                                                    <h4 class="mt-4 pt-1 mb-0 font-size-22" id="inprogress">0 <span class="text-danger fw-medium font-size-13 align-middle"> <i class="mdi mdi-arrow-down"></i> 2.64% </span> </h4>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar">
                                                        <div class="avatar-title rounded bg-soft-primary">
                                                            <i class="fas fa-check-double font-size-24 mb-0 text-primary"></i>
                                                        </div>
                                                    </div>

                                                    <div class="flex-grow-1 ms-3">
                                                        <h6 class="mb-0 font-size-15">Completed Tickets</h6>
                                                    </div>

                                                    <div class="flex-shrink-0">
                                                        <div class="dropdown">

                                                            <i class="bx bxs-info-circle" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Total Number of Completed Tickets Compare to Previous Month">

                                                            </i>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div>
                                                    <h4 class="mt-4 pt-1 mb-0 font-size-22" id="closed">0<span class="text-success fw-medium font-size-13 align-middle">
                                                            <i class="mdi mdi-arrow-down"></i> 5.79% </span> </h4>
                                                    {{-- <div class="d-flex mt-1 align-items-end overflow-hidden">
                                                        <div class="flex-grow-1">
                                                            <p class="text-muted mb-0 text-truncate">Total Expense
                                                                World Wide</p>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <div id="mini-4" data-colors='["#1f58c7"]'
                                                                class="apex-charts"></div>
                                                        </div>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="row">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-grow-1">
                                                <h5 class="card-title mb-0">Resolved Tickets Ratio</h5>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div class="dropdown">

                                                    <i class="bx bxs-info-circle" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Resolved Tickets Defines The Number of Completed Tickets Compared to Not Completed Tickets">

                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div>
                                            <div id="chart-radialBar2" class="apex-charts" data-colors='["#1f58c7"]'>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar">
                                                        <div class="avatar-title rounded bg-soft-primary">
                                                            <i class="mdi mdi-hexagon-multiple font-size-24 mb-0 text-primary"></i>
                                                        </div>
                                                    </div>

                                                    <div class="flex-grow-1 ms-3">
                                                        <h6 class="mb-0 font-size-15">Total Business Units</h6>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <div class="dropdown">

                                                            <i class="bx bxs-info-circle" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Defines Total Number of Business Units">

                                                            </i>
                                                        </div>
                                                    </div>


                                                </div>

                                                <div>
                                                    <h4 class="mt-4 pt-1 mb-0 font-size-22">2</h4>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar">
                                                        <div class="avatar-title rounded bg-soft-primary">
                                                            <i class="fas fa-cubes font-size-24 mb-0 text-primary"></i>
                                                        </div>
                                                    </div>

                                                    <div class="flex-grow-1 ms-3">
                                                        <h6 class="mb-0 font-size-15">Total Vendors</h6>
                                                    </div>

                                                    <div class="flex-shrink-0">
                                                        <div class="dropdown">

                                                            <i class="bx bxs-info-circle" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Total Number of Vendors">

                                                            </i>
                                                        </div>
                                                    </div>



                                                </div>

                                                <div>
                                                    <h4 class="mt-4 pt-1 mb-0 font-size-22">3</h4>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-grow-1">
                                            <h5 class="card-title mb-0">Tickets TimeLine</h5>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="dropdown">

                                                <i class="bx bxs-info-circle" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Tickets According to Selected Timeline">

                                                </i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div>
                                        <div id="stacked" class="apex-charts" data-colors='["#1f58c7"]'>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-grow-1">
                                            <h5 class="card-title mb-0">Impact Wise Tickets</h5>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="dropdown">
                                                <a class="dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="bx bx-dots-horizontal text-muted font-size-22"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" onclick="changegraph2();">Pie Chart</a>
                                                    <a class="dropdown-item" onclick="changegraph();">Bar Chart</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div>
                                        <div id="impactbar" style="display: none" class="apex-charts">
                                        </div>
                                        <div id="impactpie" class="apex-charts">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-grow-1">
                                            <h5 class="card-title mb-0">Priority Wise Tickets</h5>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="dropdown">
                                                <a class="dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="bx bx-dots-horizontal text-muted font-size-22"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="#">Pie Chart</a>
                                                    <a class="dropdown-item" href="#">Bar Chart</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div>
                                        <div id="prioritypie" class="apex-charts">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="row">
                        <div class="col-xxl-5">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap align-items-center mb-3">
                                        <h5 class="card-title me-2">Ticket List</h5>

                                    </div>

                                    <div class="mx-n4 px-4" data-simplebar style="max-height: 332px;">
                                        <div class="table-responsive">
                                          <table class="table table-striped table-centered align-middle table-nowrap mb-0 table-check" id="mytable">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 30px;">
                                                            <div class="form-check font-size-16">
                                                                <input type="checkbox" name="check" class="form-check-input" id="checkAll">
                                                                <label class="form-check-label" for="checkAll"></label>
                                                            </div>
                                                        </th>
                                                        <th>#Ticket Number</th>
                                                        <th>Title</th>
                                                        <th style="width: 190px;">Assigned To</th>
                                                        <th>Reported Date</th>
                                                        <th>Due Date</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="form-check font-size-16">
                                                                <input type="checkbox" class="form-check-input">
                                                                <label class="form-check-label"></label>
                                                            </div>
                                                        </td>
                                                        <td class="fw-semibold">#562354</td>
                                                        <td class="fw-semibold">Ticket 1</td>
                                                        <td style="width: 190px;">
                                                            <div class="d-flex align-items-center">
                                                                <img class="rounded-circle avatar-sm" src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt="">
                                                                <div class="flex-grow-1 ms-3">
                                                                    Neal Matthews
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            10 Dec 2023
                                                        </td>
                                                        <td>
                                                            12 Dec 2023
                                                        </td>
                                                        <td>
                                                            <div class="badge badge-soft-success font-size-12">Completed
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="dropdown">
                                                                <a class="text-muted dropdown-toggle font-size-18" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                                    <i class="mdi mdi-dots-horizontal"></i>
                                                                </a>

                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <a class="dropdown-item" href="#">View</a>
                                                                    <a class="dropdown-item" href="#">Notify</a>

                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <div class="form-check font-size-16">
                                                                <input type="checkbox" class="form-check-input">
                                                                <label class="form-check-label"></label>
                                                            </div>
                                                        </td>
                                                        <td class="fw-semibold">#485625</td>
                                                        <td class="fw-semibold">Ticket 2</td>
                                                        <td style="width: 190px;">
                                                            <div class="d-flex align-items-center">
                                                                <img class="rounded-circle avatar-sm" src="{{ asset('assets/images/users/avatar-2.jpg') }}" alt="">
                                                                <div class="flex-grow-1 ms-3">
                                                                    Connie Franco
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            10 Dec 2023
                                                        </td>
                                                        <td>
                                                            12 Dec 2023
                                                        </td>
                                                        <td>
                                                            <div class="badge badge-soft-success font-size-12">In Progress
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="dropdown">
                                                                <a class="text-muted dropdown-toggle font-size-18" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                                    <i class="mdi mdi-dots-horizontal"></i>
                                                                </a>

                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <a class="dropdown-item" href="#">View</a>
                                                                    <a class="dropdown-item" href="#">Notify</a>

                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <div class="form-check font-size-16">
                                                                <input type="checkbox" class="form-check-input">
                                                                <label class="form-check-label"></label>
                                                            </div>
                                                        </td>
                                                        <td class="fw-semibold">#321458</td>
                                                        <td class="fw-semibold">Ticket 3</td>
                                                        <td style="width: 190px;">
                                                            <div class="d-flex align-items-center">
                                                                <img class="rounded-circle avatar-sm" src="{{ asset('assets/images/users/avatar-3.jpg') }}" alt="">
                                                                <div class="flex-grow-1 ms-3">
                                                                    Adella Perez
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            12 Dec 2023
                                                        </td>
                                                        <td>
                                                            12 Dec 2023
                                                        </td>
                                                        <td>
                                                            <div class="badge badge-soft-danger font-size-12">Pending
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="dropdown">
                                                                <a class="text-muted dropdown-toggle font-size-18" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                                    <i class="mdi mdi-dots-horizontal"></i>
                                                                </a>

                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <a class="dropdown-item" href="#">View</a>
                                                                    <a class="dropdown-item" href="#">Notify</a>

                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <div class="form-check font-size-16">
                                                                <input type="checkbox" class="form-check-input">
                                                                <label class="form-check-label"></label>
                                                            </div>
                                                        </td>
                                                        <td class="fw-semibold">#214569</td>
                                                        <td class="fw-semibold">Ticket 4</td>
                                                        <td style="width: 190px;">
                                                            <div class="d-flex align-items-center">
                                                                <img class="rounded-circle avatar-sm" src="{{ asset('assets/images/users/avatar-4.jpg') }}" alt="">
                                                                <div class="flex-grow-1 ms-3">
                                                                    Theresa Mayers
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            21 Dec 2023
                                                        </td>
                                                        <td>
                                                            21 Dec 2023
                                                        </td>
                                                        <td>
                                                            <div class="badge badge-soft-success font-size-12">Completed
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="dropdown">
                                                                <a class="text-muted dropdown-toggle font-size-18" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                                    <i class="mdi mdi-dots-horizontal"></i>
                                                                </a>

                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <a class="dropdown-item" href="#">View</a>
                                                                    <a class="dropdown-item" href="#">Notify</a>

                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <div class="form-check font-size-16">
                                                                <input type="checkbox" class="form-check-input">
                                                                <label class="form-check-label"></label>
                                                            </div>
                                                        </td>
                                                        <td class="fw-semibold">#565423</td>
                                                        <td class="fw-semibold">Ticket 5</td>
                                                        <td style="width: 190px;">
                                                            <div class="d-flex align-items-center">
                                                                <img class="rounded-circle avatar-sm" src="{{ asset('assets/images/users/avatar-5.jpg') }}" alt="">
                                                                <div class="flex-grow-1 ms-3">
                                                                    Oliver Gonzales
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            25 Dec 2023
                                                        </td>
                                                        <td>
                                                            30 Dec 2023
                                                        </td>
                                                        <td>
                                                            <div class="badge badge-soft-danger font-size-12">Pending
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="dropdown">
                                                                <a class="text-muted dropdown-toggle font-size-18" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                                    <i class="mdi mdi-dots-horizontal"></i>
                                                                </a>

                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <a class="dropdown-item" href="#">View</a>
                                                                    <a class="dropdown-item" href="#">Notify</a>

                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <div class="form-check font-size-16">
                                                                <input type="checkbox" class="form-check-input">
                                                                <label class="form-check-label"></label>
                                                            </div>
                                                        </td>
                                                        <td class="fw-semibold">#565423</td>
                                                        <td class="fw-semibold">Ticket 6</td>
                                                        <td style="width: 190px;">
                                                            <div class="d-flex align-items-center">
                                                                <img class="rounded-circle avatar-sm" src="{{ asset('assets/images/users/avatar-6.jpg') }}" alt="">
                                                                <div class="flex-grow-1 ms-3">
                                                                    Willie Verner
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            30 Dec 2023
                                                        </td>
                                                        <td>
                                                            30 Dec 2023
                                                        </td>
                                                        <td>
                                                            <div class="badge badge-soft-success font-size-12">Completed
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="dropdown">
                                                                <a class="text-muted dropdown-toggle font-size-18" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                                    <i class="mdi mdi-dots-horizontal"></i>
                                                                </a>

                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <a class="dropdown-item" href="#">View</a>
                                                                    <a class="dropdown-item" href="#">Notify</a>

                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                              <table id="myTable">
                                        <thead>
                                            <tr>

                                           <th>#Ticket Number</th>
                                            <th>Title</th>
                                            <th style="width: 190px;">Assigned To</th>
                                            <th>Reported Date</th>com[]
                                            <th>Due Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                            </tr>

                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                        </div>
                                    </div>

                                </div>
                            </div>

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
                                        {{-- </div>
                                    </div>

                                </div><!-- end card header -->

                                <!-- end card body -->
                            </div>
                        </div>
                    </div> --}}
                       <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-1">

                                            <h4 class="card-title mb-0 pt-3">Tickets</h4>
                                        </div>
                                        <!-- <div class="col-md-6">
                                            <button type="button" class="btn btn-soft-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#myModal">
                                                <i class="bx bxs-add-to-queue font-size-16 align-middle me-2"></i> Add
                                                New
                                            </button>
                                            {{-- <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Add New</button> --}}
                                            {{-- <button type="button" class="btn btn-primary waves-effect waves-light">Add New</button> --}}
                                        </div> -->
                                    </div>

                                </div><!-- end card header -->
                                <div class="card-body">
                                    <table id="myTable">
                                        <thead>
                                            <tr>
                                                        <th>Serial Number</th>
                                                        <th>Ticket Number</th>
                                                        <th>Title</th>
                                                        <th>Reported By</th>
                                                        <th>Reported Date</th>
                                                        <th>Due Date</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
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

    @include('partials.script')
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.jqueryui.min.js"></script>

<script>
    var from;
    var total;
    var total_ticket_compare;
    var compelete;
    var percentage=0
    var compeletecompare;
    var total_pendings;
    var pending_compare;
     var total_inprogress_compare;
     var total_inprogress;
    //table records
   var priority_title_array=[];
   var priority_tickets_array=[];
    var table;
    var parent;
    var impactarray=[];
    var impactarraytitle=[];
     const tickets = [];
    var yesterday = new Date();
    yesterday.setDate(yesterday.getDate() - 1);

var tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);

var today = new Date(); // You can also create a date from any valid date string
var tyear = today.getFullYear();
var tmonth = String(today.getMonth() + 1).padStart(2, '0'); // Months are zero-based
var tday = String(today.getDate()).padStart(2, '0');

var formattedtoday = `${tyear}-${tmonth}-${tday}`;
var yesterday = new Date(); // You can also create a date from any valid date string
var yyear = yesterday.getFullYear();
var ymonth = String(yesterday.getMonth() + 1).padStart(2, '0'); // Months are zero-based
var yday = String(yesterday.getDate()).padStart(2, '0');

var formattedyesterday = `${yyear}-${ymonth}-${yday}`;
        console.log("today"+formattedtoday);
        console.log("yesterday"+formattedyesterday);
    from = flatpickr('#resolved', {

        defaultDate: yesterday,

    });

    to = flatpickr('#to', {
        defaultDate: tomorrow,
    });
    new Choices("#ticketresolved", {
        removeItemButton: !0,
    })
    var options = {
        series: [{
            data: tickets
        }],
        chart: {
            toolbar: {
                show: !1
            },
            height: 250,
            type: "bar",
            events: {
                click: function(e, r, t) {}
            }
        },
        plotOptions: {
            bar: {
                columnWidth: "80%",
                distributed: !0,
                borderRadius: 8
            }
        },
        fill: {
            opacity: 1
        },
        stroke: {
            show: !1
        },
        dataLabels: {
            enabled: !1
        },
        legend: {
            show: !1
        },
        colors: barchartColors = getChartColorsArray("toverview"),
        xaxis: {
            categories: ["Jan", "Feb", "Mar", "Apr", "May", "jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
        },
    };
    var toverview = new ApexCharts(document.querySelector("#toverview"), options);
    toverview.render();
    var options2 = {
        series: [percentage],
        chart: {
            type: "radialBar",
            height: 370,
            sparkline: {
                enabled: true
            }
        },
        plotOptions: {
            radialBar: {
                startAngle: -90,
                endAngle: 90,
                track: {
                    background: "#e6ecf9",
                    strokeWidth: "97%",
                    margin: 5,
                    dropShadow: {
                        enabled: !1,
                        top: 2,
                        left: 0,
                        color: "#999",
                        opacity: 1,
                        blur: 2
                    }
                },
                hollow: {
                    margin: 15,
                    size: "65%"
                },
                dataLabels: {
                    name: {
                        show: !1
                    },
                    value: {
                        offsetY: -2,
                        fontSize: "22px"
                    }
                }
            }
        },
        grid: {
            padding: {
                top: -10
            }
        },
        fill: {
            opacity: 1
        },
        colors: barchartColors = getChartColorsArray("chart-radialBar2"),
        labels: ["Average Results"]
    };
    var chart2 = new ApexCharts(document.querySelector("#chart-radialBar2"), options2);
    chart2.render();



    var options = {
        series: [{
            name: 'Opened Tickets',
            data: [44, 55, 41, 37, 22, 43, 21]
        }, {
            name: 'InProgress Tickets',
            data: [53, 32, 33, 52, 13, 43, 32]
        }, {
            name: 'Completed Tickets',
            data: [12, 17, 11, 9, 15, 11, 20]
        }],
        chart: {
            type: 'bar',
            height: 350,
            stacked: true,
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    total: {
                        enabled: false,
                        offsetX: 0,
                        style: {
                            fontSize: '13px',
                            color: '#fff',
                            fontWeight: 900
                        }
                    }
                }
            },
        },
        stroke: {
            width: 1,
            colors: ['#fff']
        },
        // title: {
        //   text: 'Fiction Books Sales'
        // },
        xaxis: {
            categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        },
        yaxis: {
            title: {
                text: undefined
            },
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return val;
                }
            }
        },
        fill: {
            opacity: 1
        },
        legend: {
            position: 'top',
            horizontalAlign: 'left',
            offsetX: 40
        }
    };

    var chart = new ApexCharts(document.querySelector("#stacked"), options);
    chart.render();



     var options1 = {
          series: [42, 47, 52, 58, 65],
          chart: {
          width: 380,
          type: 'polarArea'
        },
        labels: ['Rose A', 'Rose B', 'Rose C', 'Rose D', 'Rose E'],
        fill: {
          opacity: 1
        },
        stroke: {
          width: 1,
          colors: undefined
        },
        yaxis: {
          show: false
        },
        legend: {
          position: 'bottom'
        },
        plotOptions: {
          polarArea: {
            rings: {
              strokeWidth: 0
            },
            spokes: {
              strokeWidth: 0
            },
          }
        },
        theme: {
          monochrome: {
            enabled: true,
            shadeTo: 'light',
            shadeIntensity: 0.6
          }
        }
        };



    var impactpie = new ApexCharts(document.querySelector("#impactpie"), options1);
    impactpie.render();


    var options = {
        series: [{
            data: [40, 43, 44, 47, 54]
        }],
        chart: {
            type: 'bar',
            height: 240
        },
        plotOptions: {
            bar: {
                borderRadius: 4,
                horizontal: true,
            }
        },
        dataLabels: {
            enabled: false
        },
        xaxis: {
            categories: [
                'Priority 1', 'Priority 2', 'Priority 3', 'Prioriy 4', 'Priority 5'
            ],
        }
    };

    var prioritypie = new ApexCharts(document.querySelector("#prioritypie"), options);
    prioritypie.render();

    var options = {
        series: [{
            data: impactarray
        }],
        chart: {
            type: 'bar',
            height: 240
        },
        plotOptions: {
            bar: {
                borderRadius: 4,
                horizontal: true,
            }
        },
        dataLabels: {
            enabled: false
        },
        xaxis: {
            categories:impactarraytitle,
        }
    };

    var impactbar = new ApexCharts(document.querySelector("#impactbar"), options);
    impactbar.render();



    function changegraph() {
        document.getElementById('impactpie').style.display = 'none';
        document.getElementById('impactbar').style.display = 'block';
    }

    function changegraph2() {
        document.getElementById('impactbar').style.display = 'none';
        document.getElementById('impactpie').style.display = 'block';
    }

    function ticket() {
        var from = document.getElementById("from");
        var to = document.getElementById("to");
        // alert(from);
        // alert(to);
    }
    
    function calculatePercentageChange(totaltickets, compare) {
        if (totaltickets === 0) {
          return '100%'; // Avoid division by zero
        }
        else if (compare === 0) {
            return '100%'; // Avoid division by zero
        }

        const percentageChange = ((compare - totaltickets) / totaltickets) * 100;
        return percentageChange.toFixed(2) + '%';
      }
{{--
      const percentageChange = calculatePercentageChange(totaltickets, compare);

      console.log(`Percentage Change: ${percentageChange}`);  --}}



    function getdate() {
        var resolved = $("#resolved").val();
        var to = $("#to").val();

        // alert("Hamza")
        var totaltickets = {
            "url": "api/dashboard/total/20/" + resolved + "/" + to,
            "method": "GET",
            "timeout": 0,
        };

        $.ajax(totaltickets).done(function(response) {
            console.log(response);
            total =response[0]['total_tickets'];
            $("#total_tickets").text(response[0]['total_tickets']);
        });

        var totaltickets_compare = {
            "url": "api/dashboard/total/20/" + formattedyesterday + "/" + formattedtoday,
            "method": "GET",
            "timeout": 0,
        };

        $.ajax(totaltickets_compare).done(function(response) {
            console.log(response);
            total_ticket_compare =response[0]['total_tickets'];
            console.log("try"+total_ticket_compare);

            var percentageChange = calculatePercentageChange(total, total_ticket_compare);
            if(total>total_ticket_compare){
            $("#total_tickets").html(total+'<span class="text-success fw-medium font-size-13 align-middle"><i class="mdi mdi-arrow-up"></i>'+percentageChange+'</span>');
    }else{
        $("#total_tickets").html(total+'<span class="text-danger fw-medium font-size-13 align-middle"><i class="mdi mdi-arrow-down"></i>'+percentageChange+'</span>');

    }
});


        var pending = {
            "url": "api/dashboard/pending/20/" + resolved + "/" + to,
            "method": "GET",
            "timeout": 0,
        };

        $.ajax(pending).done(function(response) {
            total_pendings=response[0]['pending_tickets'];
            console.log(response);
            $("#pending_tickets").text(response[0]['pending_tickets']);
        });

        var pendingcompare = {
            "url": "api/dashboard/pending/20/" + formattedyesterday + "/" + formattedtoday,
            "method": "GET",
            "timeout": 0,
        };

        $.ajax(pendingcompare).done(function(response) {
            console.log(response);
            pending_compare=response[0]['pending_tickets'];
            var pending_percentageChange = calculatePercentageChange(pending_compare, total_pendings);
            if(total_pendings>pending_compare){
            $("#pending_tickets").html(total_pendings+'<span class="text-success fw-medium font-size-13 align-middle"><i class="mdi mdi-arrow-up"></i>'+pending_percentageChange+'</span>');
        } else{
            $("#pending_tickets").html(total_pendings+'<span class="text-danger fw-medium font-size-13 align-middle"><i class="mdi mdi-arrow-down"></i>'+pending_percentageChange+'</span>');

        }

    });

        var inprogress = {
            "url": "api/dashboard/inprogress/20/" + resolved + "/" + to,
            "method": "GET",
            "timeout": 0,
        };

        $.ajax(inprogress).done(function(response) {
            total_inprogress=response[0]['inprogress'];
            console.log(response);

            $("#inprogress").text(response[0]['inprogress']);
        });

        var inprogresscompare = {
            "url": "api/dashboard/inprogress/20/" + formattedyesterday + "/" + formattedtoday,
            "method": "GET",
            "timeout": 0,
        };

        $.ajax(inprogresscompare).done(function(response) {
            total_inprogress_compare=response[0]['inprogress'];

            var inprogresspercentageChange = calculatePercentageChange(total_inprogress, total_inprogress_compare);
            console.log("inprogress"+inprogresspercentageChange);
            if(total_inprogress>total_inprogress_compare){
                $("#inprogress").html(total_inprogress+'<span class="text-success fw-medium font-size-13 align-middle"><i class="mdi mdi-arrow-up"></i>'+inprogresspercentageChange+'</span>');
            }else{
                $("#inprogress").html(total_inprogress+'<span class="text-danger fw-medium font-size-13 align-middle"><i class="mdi mdi-arrow-down"></i>'+inprogresspercentageChange+'</span>');

            }


        });

        var priority_graph = {
            "url": "api/dashboard/priority_graph/20/" + resolved + "/" + to,
            "method": "GET",
            "timeout": 0,
        };


         var alltickets = {
            "url": "api/dashboard/alltickets/20/" + resolved + "/" + to,
            "method": "GET",
            "timeout": 0,
        };

        $.ajax(alltickets).done(function(response) {
            console.log("Hamza");
            console.log(response);
            table.clear().draw();
               $.each(response, function(index, data) {
                table.row.add([
                    index + 1,
                    '000-'+data.id+'0',
                    data.title,
                    data.reported_by_name,
                    data.created_at,
                    data.due_date,
                    data.status_title,
                    '<div class="dropdown"><a class="text-muted dropdown-toggle font-size-18" role="button" data-bs-toggle="dropdown" aria-haspopup="true"><i class="mdi mdi-dots-horizontal"></i> </a><div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item" href="#">View</a><a class="dropdown-item" href="#">Notify</a></div></div>',
                         ]).draw(false);
            });


        });

        $.ajax(priority_graph).done(function(response)
        {
            priority_tickets_array = [];
            priority_title_array = [];
            for(i=0;i<response.length;i++){
            priority_title_array.push(response[i]['priority_title'])
            priority_tickets_array.push(response[i]['ticket']);
            }
            console.log(priority_title_array);
            console.log(priority_tickets_array);
                    prioritypie.updateSeries([{
                    data: priority_tickets_array
                    }]);
                    prioritypie.updateOptions({
                    xaxis: {
                        categories: priority_title_array,
                    },
                });
        });
        // var prioritypie = new ApexCharts(el, options);



        var impact_option = {
            "url": "api/dashboard/impactgraph/20/" + resolved + "/" + to,
            "method": "GET",
            "timeout": 0,
        };
        $.ajax(impact_option).done(function(response)
        {
            impactarraytitle = [];
            impactarray = [];
            for(i=0;i<response.length;i++){
            impactarraytitle.push(response[i]['impact_title'])
            impactarray.push(response[i]['ticket']);
            }
            console.log(impactarraytitle);
            console.log(impactarray);
            impactpie.updateSeries(impactarray);
                    // impactpie.updateSeries([{
                    // data: priority_tickets_array
                    // }]);

                    impactpie.updateOptions({
                    labels: impactarraytitle
                });

                impactbar.updateSeries([{
                    data: impactarray
                    }]);
                    impactbar.updateOptions({
                    xaxis: {
                        categories: impactarraytitle,
                    },
                });
        });




        var closed = {
            "url": "api/dashboard/closed/20/" + resolved + "/" + to,
            "method": "GET",
            "timeout": 0,
        };

        $.ajax(closed).done( function(response) {
            console.log(response);
            compelete = response[0]['closed'];

           $("#closed").text(response[0]['closed']);
             percentage = compelete / total *100;
             percentage= Math.round(percentage);     //  alert(compelete+"---"+total);

            chart2.updateSeries([percentage]);
            console.log("hello"+compelete)
        });


        var closed = {
            "url": "api/dashboard/closed/20/" + formattedyesterday + "/" + formattedtoday,
            "method": "GET",
            "timeout": 0,
        };

        $.ajax(closed).done( function(response) {
            compeletecompare = response[0]['closed'];

            var completepercentageChange = calculatePercentageChange(total_inprogress, total_inprogress_compare);
            if(compelete>compeletecompare){
                $("#closed").html(compelete+'<span class="text-success fw-medium font-size-13 align-middle"><i class="mdi mdi-arrow-up"></i>'+completepercentageChange+'</span>');
            }else{
                $("#closed").html(compelete+'<span class="text-danger fw-medium font-size-13 align-middle"><i class="mdi mdi-arrow-down"></i>'+completepercentageChange+'</span>');

            }



            console.log("complete compare"+compeletecompare)
            console.log("complete"+compelete)


        });

    };





    $(document).ready(function(){
        // towerchart();
         getdate();
          var monthlychart = {
            "url": " api/dashboard/yearly_graph/20",
            "method": "GET",
            "timeout": 0,
        };

        $.ajax(monthlychart).done(function(response) {
            console.log(response[0]['response']);

            // alert(response)
            console.log(response[8]['TicketCount'])
            for(i=0; i<response.length;i++){
                tickets.push(response[i]['TicketCount']);
            }
            console.log(tickets);
            toverview.updateSeries([{ data: tickets }]);

            $("#monthlychart").text(response[0]['inprogress']);
        });
         table = new DataTable('#myTable');
    });




</script>


</html>
