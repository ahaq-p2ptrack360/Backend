<style>
    .float-message {
      position: fixed;
      top: 100px;
      right:0;
      transform: translate(0%, 0%);
      z-index: 9999;
      border: 2px solid #ccc;
      background-color: #fff;
      resize: both;
      overflow: hidden;
    }

    .float-message-inner {
      padding: 10px;
    }

    .close-link {
      float: right;
      cursor: pointer;
    }

    #resizableIframe {
      width: 100%;
      height: 100%;
      border: none;
    }</style>
<div class="vertical-menu">

    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="/dashboard" class="logo logo-dark">
            <input type="hidden" id="designation_hide" name="">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/logo-dark-sm.png') }}" alt="" height="26">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="28">
            </span>
        </a>

        <a href="/dashboard" class="logo logo-light">
            <span class="logo-lg" style="justify-content: end">
                <img src="" id="lglogo" alt="" height="30">


                <h5 style="color:darkgray;display:inline;margin-left:10px;" id="lgtitle"></h5>
            </span>
            <span class="logo-sm" id="smlogospan">
                <img src="" id="smlogo" alt="" height="26">

            </span>
        </a>
    </div>

    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect vertical-menu-btn">
        <i class="bx bx-menu align-middle"></i>
    </button>

    <div data-simplebar class="sidebar-menu-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">Dashboard</li>

                <li>
                    <a href="/index">
                        <i class="bx bx-home-alt icon nav-icon"></i>
                        <span class="menu-item" data-key="t-dashboard">Dashboard</span>
                        {{-- <span class="badge rounded-pill bg-primary">1</span> --}}
                    </a>
                    {{-- <ul class="sub-menu" aria-expanded="false">
                        <li><a href="/index" data-key="t-ecommerce">Admin Dashboard</a></li>
                        <li><a href="dashboard-sales.html" data-key="t-sales">Sales</a></li>
                    </ul> --}}
                </li>

                <li class="menu-title" data-key="t-applications">Setup</li>



                <li>
                    <a href="/vendor-types">
                        <i class="mdi mdi-view-week icon nav-icon"></i>
                        <span class="menu-item" data-key="t-calendar">Types</span>
                    </a>
                </li>
                <li>
                    <a href="/status">
                        <i class="mdi mdi-list-status icon nav-icon"></i>
                        <span class="menu-item" data-key="t-calendar">Status</span>
                    </a>
                </li>
                <li>
                    <a href="/priority">
                        <i class="mdi mdi-priority-high icon nav-icon"></i>
                        <span class="menu-item" data-key="t-calendar">Priority</span>
                    </a>
                </li>
                <li>
                    <a href="/impact">
                        <i class="mdi mdi-shuriken icon nav-icon"></i>
                        <span class="menu-item" data-key="t-calendar">Impact</span>
                    </a>
                </li>

                <li>
                    <a href="/bu">
                        <i class="mdi mdi-hexagon-multiple icon nav-icon"></i>
                        <span class="menu-item" data-key="t-calendar">Business Unit</span>
                    </a>
                </li>
                <li>
                    <a href="/groups">
                        <i class="mdi mdi-account-group-outline icon nav-icon"></i>
                        <span class="menu-item" data-key="t-calendar">Group</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        {{-- <li><a href="/Permission"data-key="t-calendar">Permission</a></li>
                        <li><a href="/role" data-key="t-calendar">Role</a></li> --}}
                        <li><a href="/groups" data-key="t-calendar">Assign Group</a></li>
                        <li><a href="/group" data-key="t-calendar">Create Group</a></li>

                    </ul>
                </li>
                <li>
                    <a href="/vendor">
                        <i class="fas fa-cubes icon nav-icon"></i>
                        <span class="menu-item" data-key="t-calendar">Vendors</span>
                    </a>
                </li>
                @if (Auth::user()->company_id == 0)

                    <li>
                        <a href="/Subscription">
                            <i class="mdi mdi-package-variant icon nav-icon"></i>
                            <span class="menu-item" data-key="t-calendar">Subscription Packages</span>
                        </a>
                    </li>

                @endif

                <li>
                    <a href="/Tickets">
                        <i class="mdi mdi-ticket-confirmation icon nav-icon"></i>
                        <span class="menu-item" data-key="t-calendar">Tickets</span>
                    </a>
                </li>
                <li>
                    <a href="/ticket_filter">
                        <i class="mdi mdi-ticket-confirmation icon nav-icon"></i>
                        <span class="menu-item" data-key="t-calendar">Report</span>
                    </a>
                </li>
                @if (Auth::user()->company_id == 0)

                    <li>
                        <a href="/domain">
                            <i class="mdi mdi-chart-bubble icon nav-icon"></i>
                            <span class="menu-item" data-key="t-calendar">Domain</span>
                        </a>
                    </li>
                    <li>
                        <a href="/Company">
                            <i class="bx bxs-droplet icon nav-icon"></i>
                            <span class="menu-item" data-key="t-calendar">Company</span>
                        </a>
                    </li>



                @endif
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="mdi mdi-account-child-circle nav-icon"></i>
                        <span class="menu-item" data-key="t-ecommerce">User Management</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        {{-- <li><a href="/Permission"data-key="t-calendar">Permission</a></li>
                        <li><a href="/role" data-key="t-calendar">Role</a></li> --}}
                        <li><a href="/user" data-key="t-calendar">User</a></li>
                        <li><a href="/customer" data-key="t-calendar">Account</a></li>
                        <li><a href="/designation" data-key="t-calendar">Designation</a></li>
                    </ul>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>

<div class='float-message' id="resizableFloatMessage">
    <div class='float-message-inner' id="resizableFloatMessageInner">
       <a href="#!" onclick="hideFloatMessage();" class="close-link">X</a>
       <iframe id="resizableIframe" src="https://demo.p2ptrack360.com:8088/conversations" onmousedown="startResizing(event)" ></iframe>
    </div>
 </div>

{{-- <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script> --}}

<script>
    function openMessageBox() { document.getElementsByClassName('float-message')[0].style.display = 'block'; }
   function closeMessageBox() { document.getElementsByClassName('float-message')[0].style.display = 'none'; }
   let isResizing = false;
  let initialMouseX;
  let initialMouseY;
  let initialWidth;
  let initialHeight;

  const resizableFloatMessage = document.getElementById("resizableFloatMessage");
  const resizableFloatMessageInner = document.getElementById("resizableFloatMessageInner");

  resizableFloatMessageInner.addEventListener("mousedown", startResizing);

  function startResizing(e) {
    e.preventDefault();
    isResizing = true;
    initialMouseX = e.clientX;
    initialMouseY = e.clientY;
    initialWidth = resizableFloatMessage.offsetWidth;
    initialHeight = resizableFloatMessage.offsetHeight;

    document.addEventListener("mousemove", handleResizing);
    document.addEventListener("mouseup", stopResizing);
  }

  function handleResizing(e) {
    if (isResizing) {
      const width = initialWidth + (e.clientX - initialMouseX);
      const height = initialHeight + (e.clientY - initialMouseY);

      resizableFloatMessage.style.width = `${width}px`;
      resizableFloatMessage.style.height = `${height}px`;
    }
  }

  function stopResizing() {
    isResizing = false;
    document.removeEventListener("mousemove", handleResizing);
    document.removeEventListener("mouseup", stopResizing);
  }

  function hideFloatMessage() {
    resizableFloatMessage.style.display = "none";
  }

    // $('document').ready(function() {
    //     var settings = {
    //         "url": "api/companies/{{ Auth::user()->company_id }}",
    //         "method": "GET",
    //         "timeout": 0,
    //     };

    //     $.ajax(settings).done(function(response) {


    //         var ret = response[0]['profile'].replace("documents/", "");
    //         if(ret==""){
    //             $('#smlogo').css('display','none');

    //             var formappend='<h5 style="color:grey; margin-top:30px;"></h5>'
    //             $('#smlogospan').prepend(formappend);



    //         }
    //         else{
    //             var image_sm = document.getElementById('smlogo').src =
    //             "http://3.137.76.254:80/api/profile/" + ret;
    //              var image_lg = document.getElementById('lglogo').src =
    //             "http://3.137.76.254:80/api/profile/" + ret;
    //         }



    //     })
    //     var settings = {
    //         "url": "api/designations_t/{{ Auth::user()->designation_id }}",
    //         "method": "GET",
    //         "timeout": 0,
    //     };

    //     $.ajax(settings).done(function(response) {
    //         console.log(response);
    //         console.log('hello ' +response )
    //         alert(response[0]['title']);
    //         $('designation_hide').text(response[0]['title']);


    //     })
    // })
    $('document').ready(function() {

        var settings = {
            "url": "api/companies/{{ Auth::user()->company_id }}",
            "method": "GET",
            "timeout": 0,
        };

        $.ajax(settings).done(function(response) {

            var fullName = response[0]['name']; // Replace with your actual variable value

            // Split the full name into an array of words
            var words = fullName.split(' ');

            // Extract the first letter of the first word and the first letter after the space
            var firstLetter = words[0][0];

            var secondLetter = '';
            if (words.length > 1) {
            secondLetter = words[1][0];
            }
            // $('#smtitle').html(firstLetter+secondLetter)
            $('#lgtitle').text(response[0]['name'])
            var ret = response[0]['profile'].replace("documents/", "");
            if (ret == "") {
                $('#smlogo').css('display', 'none');
                var formappend =
                    '<h5 style="color:grey; margin-top:30px;">'+ firstLetter + secondLetter+'</h5>';
                $('#smlogospan').prepend(formappend);
            } else {
                var image_sm = document.getElementById('smlogo').src =
                    "http://demo.p2ptrack360.com/api/profile/" + ret;
                var image_lg = document.getElementById('lglogo').src =
                    "http://demo.p2ptrack360.com/api/profile/" + ret;
            }
        })
        if ("{{Auth::user()->company_id == 0}}") {
            $('.menu-item').each(function(index, element) {
                $(element).parent().css('display', 'block');
            });
        } else {
            var settings = {
                "url": "api/users/{{ Auth::user()->bu_id }}/{{ Auth::user()->designation_id }}",
                "method": "GET",
                "timeout": 0,
            };

            $.ajax(settings).done(function(response) {
                var g_id = response[0]['group_id'];
                var settings = {
                    "url": "api/users_bu_group/" + g_id,
                    "method": "GET",
                    "timeout": 0,
                };
                $.ajax(settings).done(function(response) {
                    var designationTitle = response[0]['title'];
                    if (designationTitle === 'Staff') {
                        // Hide menu items for Agent designation
                        $('.menu-item').each(function(index, element) {
                            var menuText = $(element).text().trim();
                            if (menuText !== 'Dashboard' && menuText !== 'Tickets') {
                                $(element).parent().css('display', 'none');
                            }
                        });
                    } else if (designationTitle === 'Manager') {
                        // Show all menu items for CEO designation
                        $('.menu-item').each(function(index, element) {
                            $(element).parent().css('display', 'block');
                        });
                    }
                })
            })

        }



    });
</script>
