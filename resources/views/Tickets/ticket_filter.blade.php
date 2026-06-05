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
                                <div class="col-12" id="static_fields" style="margin-left: 0px; padding-left: 0px;">

                                    <!-- <option value="${field}">ABC</option>
                                    <option value="ABC">BC</option>    -->
                                    <!-- </select> -->

                                </div>
                                <hr style="margin-top:3px">
                                <div class="col-12" id="group_fields" style="height: 250px; overflow-y:scroll;">

                                </div>
                                <button type="button" id="group_button" class="btn btn-dark btn-sm" style="margin-bottm: 3px; margin-left: 75px; 
    margin-bottom: 3px; width: 50%; display:none">Create
                                    Group</button>
                                <hr style="margin-top:3px">
                                <div class="col-12" id="groups_overlay" style="height: 250px; overflow-y: scroll">


                                </div>



                            </div>
                        </div>
                        <div class="col-10">
                            <div class="col-12" style="margin-left:20px">
                                <h6 class="">Filter Fields</h6>
                                <div class="row" id="filter_fields">

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
                                            </thead>

                                            <tbody>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="3" id="summary-cell">
                                                        <div>Count: <span id="total_count"></span></div>
                                                        <div>Sum: <span id="total_sum"></span></div>
                                                        <div>Average: <span id="average"></span></div>
                                                        <div>Max: <span id="max"></span></div>
                                                    </td>
                                                </tr>
                                            </tfoot>

                                        </table>
                                    </div>

                                </div>
                            </div>
                            <hr>

                            <div id="myPieChart" class = "d-none"></div>

                        </div>



                    </div>


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
                    @include('partials.script')
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

        };
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
        let line_chart;
        let groups = []
        var count_array = {}
        let group_no = 1
        $(document).ready(function() {


            $.ajax({
                url: "api/totalticketscompany_wise/{{Auth::user()->company_id}}",
                method: "GET",
                timeout: 0,
            }).done(function(response) {
                // console.table(response);
                data = response;

                const static_fields = document.getElementById('static_fields');

                let ul_list = document.createElement('ul')
                let items = ""



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
                });
                // generating fields
                const table_rec = document.querySelector('#table_records');
                distinctValues.bu_field_name.forEach((field) => {
                    const th = document.createElement('th'); // Create a new <th> element
                    th.textContent = field; // Set the header text
                    table_rec.appendChild(th);
                });

                table = $('#myTable').DataTable({
                    dom: 'Bfrtip',
                    colReorder: true,
                    scrollX: true,
                    columnDefs: [{
                        targets: '_all',
                        visible: false
                    }],
                    buttons: [{
                            extend: 'colvis',
                            text: 'Column Visibility',
                            // //postfixButtons: ['colvisRestore'],
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
                                        $('.dt-button-collection div[role="menu"] li')
                                            .each(function() {
                                                var $li = $(this).parent();
                                                var text = $(this).text()
                                                    .toLowerCase();
                                                if (text.indexOf(query) !==
                                                    -1) {
                                                    $li.show();
                                                } else {
                                                    $li.hide();
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
                    "customer",
                    "resolved_name",
                    "reported_by_name",
                    "title",
                    "completed_date",
                    "due_date",
                    "type_title",
                    "status_title",
                    "bu_field_name",
                    "field_type",
                    "field_data"
                ];
                // let select = document.createElement('static_dropdown');
                let opt =
                    `<select class="selectpicker" id = "static_dropdown" multiple aria-label="Default select example" data-live-search="true">`
                inputFields.forEach(field => {
                    // opt = document.createElement('option')
                    opt += `<option value="${field}">${field}</option>`
                    // select.appendChild(opt)

                })

                static_fields.innerHTML = opt
                $('#static_dropdown').selectpicker('refresh');

                update_table(data, table);
            });
        });

        $(document).on('change', '#filter_fields select', function() {
            let fieldLabel = $(this).closest('.filter-field-container').find('label').text().trim();
            let field = fieldLabel.toLowerCase().replace(/ /g, "_"); // Convert to camel_case if needed

            // Get the selected option's value
            selectedValues[field] = $(this).val() || []; // Gets an array of all selected options

            //     console.log(selectedValues); // D
            applyFilters(); // Call filter function
            update_record_box(field);
        });

        // colun rename 

        $('#myTable tbody').on('click', 'td', function() {
            var idx = table.cell(this).index().column;
            var data_value = table.column(idx).data().toArray();
            // console.log(title)
            let total = data_value.length;
            let num_array = data_value.filter((Number))
            let sum = num_array.reduce((a, b) => a + b, 0)
            let average = sum / total;
            let max = Math.max(...num_array);
            $('#total_count').text(total.toFixed(1));
            $('#total_sum').text(sum.toFixed(1));
            $('#average').text(average.toFixed(1));
            $('#max').text(max.toFixed(1));


            // alert('Column title clicked on: ' + $(title).text());
            // console.log(num_array)
            // console.log(sum)
            // console.log(total)
            // console.log(average)
        });

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


        let selected_values = []
        // !!!!!!1!!!!!!!!!!!!!!!!!!!!!!!!!!!!1!!!
        // change the event binding in accrodance with the dropdown
        // -----------------------------------------------------------------------------
        $(document).on('change', '#static_dropdown', function() {
            // Get all currently selected options
            const selectedFields = $(this).find('option:selected').map(function() {
                return $(this).val().replace(/ /g, "_");
            }).get();

            // Add fields that are newly selected
            selectedFields.forEach(field => {
                if (!selected_values.includes(field)) {
                    selected_values.push(field);
                    add_field_filter(field); // Add the field to the filter container
                }
            });

            // Remove fields that are no longer selected
            selected_values = selected_values.filter(field => {
                if (!selectedFields.includes(field)) {
                    remove_field_filter(field); // Remove the field from the filter container
                    return false;
                }
                return true;
            });
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

        function grouping_table(ind_arr) {
            table.destroy()
            count_array = {};
            table = $('#myTable').DataTable({
                dom: 'Bfrtip', // Include 'B' for buttons
                scrollX: true,
                colReorder: true,
                // pageLength: 10,
                buttons: ['colvis'], // Enable column visibility button
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
                            .append('<td colspan="' + rows.columns().length + '">Group: ' + group +
                                ' | Total Tickets: ' + totalRows + '</td>'
                            ); // Optionally add a class for styling                    
                    }
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

                    // div
                    div_child_2.innerHTML = `<button type="button" 
            class="btn btn-danger waves-effect waves-light" 
            id="container_${num}" 
            onclick="remove_group('group_container_${num}', '${groupName}')" 
             style="height:30px; font-size: 10px">
        <i class="mdi mdi-trash-can"></i>
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
            const selectedItems = selectedValues[ref];

            // Check if selectedValues[ref] has items
            if (selectedItems.length > 0) {
                let div = document.querySelector(`.${ref}Container`);

                // Create the div if it doesn't exist
                if (!div) {
                    div = document.createElement('div');
                    div.className = `${ref}Container`;
                    group_field.appendChild(div);
                }

                // Prepare content for the div
                let content = `<input type="checkbox" style="margin-right: 3px"><label>${ref}</label><br>`;
                selectedItems.forEach(item => {
                    content +=
                        `<label style="margin-left: 3px;">${item}</label>`;
                });

                // Update the div's inner HTML with the content
                div.innerHTML = content + `<hr>`;
                $('#group_button').show()
            } else {
                // If there are no selected items, remove the div
                let divToRemove = document.querySelector(`.${ref}Container`);
                if (divToRemove) {
                    divToRemove.remove();
                }
            }
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

            console.log(fil_group_obj);
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


        function applyFilters() {
            let filteredData = data.filter(item => {
                return Object.keys(selectedValues).every(field => {
                    // If no filters selected for this field, ignore it
                    if (selectedValues[field].length === 0) return true;
                    return selectedValues[field].includes(item[field]);
                });
            });

            // console.table(filteredData)
            update_table(filteredData, table); // Update table with the filtered data
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


            console.log("X selected: " + XField.getValue(true));
            console.log("Y selected: " + YField.getValue(true));
            const groupFields = Object.values(group_obj[0])[0]; 

            let fieldCounts = {};

            groupFields.forEach(field => {
                fieldCounts[field] = {};

                let values = distinctValues[field] || [];

                values.forEach(value => {
                    if (count_array[value] !== undefined) {
                        fieldCounts[field][value] = count_array[value];
                    } else {
                        fieldCounts[field][value] = 0;
                    }
                });
            });

            // Output the result
            console.log("Field Counts:", fieldCounts);
            let x_axis_obj = fieldCounts[XField.getValue(true)];
            let y_axis_obj = fieldCounts[YField.getValue(true)];
            console.log("X axis obj ", x_axis_obj)
            console.log("Y axis obj ", y_axis_obj)
            display_chart(x_axis_obj, y_axis_obj, groupFields[0], groupFields[1])
        }

        function display_chart(x_axis, y_axis, x_label, y_label) {
            const categories = Object.keys(x_axis);
            const buNameData = Object.values(x_axis); // Example data for bu_name
            const companyNameData = Object.values(y_axis); // Example data for company_name
            // chart.destroy();
            // Chart Options
            if (line_chart) {
                line_chart.destroy() 
            }
            var options = {
                chart: {
                    type: 'line',
                    height: 350
                },
                series: [{
                        name: x_label, // First line
                        data: buNameData
                    },
                    {
                        name: y_label, // Second line
                        data: companyNameData
                    }
                ],
                xaxis: {
                    categories: categories, // Pass X-axis categories (e.g., dates)
                    title: {
                        text: x_label
                    }
                },
                yaxis: {
                    title: {
                        text: y_label
                    }
                },
                title: {
                    text: 'Group Chart',
                    align: 'center'
                },
                stroke: {
                    width: 2,
                    curve: 'smooth' // Smooth curves
                },
                markers: {
                    size: 5,
                    colors: ['#FFA500', '#00BFFF'], // Optional marker colors
                    hover: {
                        size: 7
                    }
                }
            };

            // Render the Chart
            line_chart = new ApexCharts(document.querySelector("#myPieChart"), options);
            line_chart.render();

            $("#myPieChart").removeClass("d-none");        
         }
        </script>

        <script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js'>
        </script>



</body>

</html>