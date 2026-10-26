<style>
    #nav_user_icon {
        padding: 8px;
        border: 2px dotted grey;
        border-radius: 50%;
        font-size: 16px;
    }
</style>
<header id="page-topbar" class="isvertical-topbar">

    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo-dark-sm.png') }}" alt="" height="26">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/logo-dark-sm.png') }}" alt="" height="26">
                    </span>
                </a>

                <a href="index.html" class="logo logo-light">
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="30">
                    </span>
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo-light-sm.png') }}" alt="" height="26">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect vertical-menu-btn">
                <i class="bx bx-menu align-middle"></i>
            </button>

            <!-- start page title -->
            <div class="page-title-box align-self-center d-none d-md-block">
                <h4 class="page-title mb-0">Welcom to Ticket Management System</h4>

            </div>
            <!-- end page title -->

        </div>

        <div class="d-flex">

            <!-- Add d-inline-block class for inline display -->


            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-chat icon nav-icon align-middle" onclick="toggleMessageBox()" onmouseover="messagemi()" onmouseout="messagemo()"></i>
                </button>
                @php
                // Get the current URL path using Laravel's Request facade
                $url_path = request()->path();

                // Check if the URL path is '/index'
                if ($url_path === 'index') {
                @endphp
                <button type="button" class="btn btn-soft-secondary waves-effect waves-light" onclick="get_filters()" data-bs-toggle="modal" data-bs-target="#filterModal">
                    Save Views
                </button>
                @php
                }
                @endphp


                {{-- <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0">
                    <form class="p-2">
                        <div class="search-box">
                            <div class="position-relative">

                            </div>
                        </div>
                    </form>
                </div> --}}


                <div id="chat_message" style="position: fixed;
                padding: 15px 20px 0px 20px;
                background: white;
                border: 2px solid #C0C5CB;
                border-radius: 6px 10px 10px 9px;
                display:none;
            ">
                    <p>P2P Chat</p>
                </div>
            </div>

            {{-- <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon" id="page-header-notifications-dropdown-v"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bx bx-bell icon-sm align-middle"></i>
                    <span class="noti-dot bg-danger rounded-pill">4</span>
                </button>
                <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications-dropdown-v">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="m-0 font-size-15"> Notifications </h5>
                            </div>
                            <div class="col-auto">
                                <a href="#!" class="small fw-semibold text-decoration-underline"> Mark all as
                                    read</a>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 250px;">
                        <a href="#!" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <img src="{{ asset('assets/images/users/avatar-3.jpg') }}"
            class="rounded-circle avatar-sm" alt="user-pic">
        </div>
        <div class="flex-grow-1">
            <p class="text-muted font-size-13 mb-0 float-end">1 hour ago</p>
            <h6 class="mb-1">James Lemire</h6>
            <div>
                <p class="mb-0">It will seem like simplified English.</p>
            </div>
        </div>

    </div>
    </a>
    <a href="#!" class="text-reset notification-item">
        <div class="d-flex">
            <div class="flex-shrink-0 avatar-sm me-3">
                <span class="avatar-title bg-primary rounded-circle font-size-18">
                    <i class="bx bx-cart"></i>
                </span>
            </div>
            <div class="flex-grow-1">
                <p class="text-muted font-size-13 mb-0 float-end">3 min ago</p>
                <h6 class="mb-1">Your order is placed</h6>
                <div>
                    <p class="mb-0">If several languages coalesce the grammar</p>
                </div>
            </div>
        </div>
    </a>
    <a href="#!" class="text-reset notification-item">
        <div class="d-flex">
            <div class="flex-shrink-0 avatar-sm me-3">
                <span class="avatar-title bg-success rounded-circle font-size-18">
                    <i class="bx bx-badge-check"></i>
                </span>
            </div>
            <div class="flex-grow-1">
                <p class="text-muted font-size-13 mb-0 float-end">8 min ago</p>
                <h6 class="mb-1">Your item is shipped</h6>
                <div>
                    <p class="mb-0">If several languages coalesce the grammar</p>
                </div>
            </div>
        </div>
    </a>

    <a href="#!" class="text-reset notification-item">
        <div class="d-flex">
            <div class="flex-shrink-0 me-3">
                <img src="{{ asset('assets/images/users/avatar-6.jpg') }}" class="rounded-circle avatar-sm" alt="user-pic">
            </div>
            <div class="flex-grow-1">
                <p class="text-muted font-size-13 mb-0 float-end">1 hour ago</p>
                <h6 class="mb-1">Salena Layfield</h6>
                <div>
                    <p class="mb-1">As a skeptical Cambridge friend of mine occidental.</p>
                </div>
            </div>
        </div>
    </a>
    </div>
    <div class="p-2 border-top d-grid">
        <a class="btn btn-sm btn-link font-size-14 btn-block text-center" href="javascript:void(0)">
            <i class="uil-arrow-circle-right me-1"></i> <span>View More..</span>
        </a>
    </div>
    </div>
    </div> --}}

    <div class="dropdown d-inline-block">
        <button type="button" class="btn header-item user text-start d-flex align-items-center" id="page-header-user-dropdown-v" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-user" id="nav_user_icon" aria-hidden="true"></i>
            <!-- <img class="rounded-circle header-profile-user"
                        src="{{ asset('assets/images/users/avatar-3.jpg') }}" alt="Header Avatar"> -->
            <span class="d-none d-xl-inline-block ms-2 fw-medium font-size-15">{{ Auth::user()->first_name }}</span>
        </button>
        <div class="dropdown-menu dropdown-menu-end pt-0">
            <div class="p-3 border-bottom">
                <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                <p class="mb-0 font-size-11 text-muted">{{ Auth::user()->email }}</p>
            </div>

            <a class="dropdown-item" href="/profile"><i class="mdi mdi-account-circle text-muted font-size-16 align-middle me-2"></i> <span class="align-middle">Profile</span></a>

            <div class="dropdown-divider"></div>

            <div id="com_pro" style="display: none;">
                <a class="dropdown-item" href="/company_profile"><i class="mdi mdi-account-circle text-muted font-size-16 align-middle me-2"></i> <span class="align-middle">Company Profile</span></a>

                <div class="dropdown-divider"></div>
            </div>
            <a class="dropdown-item" href="api/logout/{{ Auth::user()->id }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();sessionStorage.clear();"><i class="mdi mdi-logout text-muted font-size-16 align-middle me-2"></i> <span class="align-middle">Logout</span></a>
            <form id="logout-form" action="api/logout/{{ Auth::user()->id }}" method="POST" class="d-none">
            <!-- <input type="hidden" name="_token" value="YOUR_CSRF_TOKEN_VALUE"> -->
    @csrf
</form>
        </div>
    </div>
    </div>
    </div>
    <div class='float-message'>
        <div class='float-message-inner'>
            <a href="#!" onclick="$('.float-message').hide();" class="close-link">X</a>
            <iframe src="https://demo.p2ptrack360.com:80/conversations" style="height:80vh; width:100%;"></iframe>
        </div>
    </div>

    {{-- <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script> --}}


</header>

<script>
    let isMessageBoxVisible = false;
    $(document).ready(function() {
        des();
    })

    function messagemi() {
        $('#chat_message').css('display', 'block')
    }

    function messagemo() {
        $('#chat_message').css('display', 'none')
    }

    function openMessageBox() {
        document.getElementsByClassName('float-message')[0].style.display = 'block';
    }

    function closeMessageBox() {
        document.getElementsByClassName('float-message')[0].style.display = 'none';
    }

    function toggleMessageBox() {
        if (isMessageBoxVisible) {
            $('.float-message').hide();
        } else {
            openMessageBox();
        }
        isMessageBoxVisible = !isMessageBoxVisible;
    }

    function des() {
        var settings = {
            "url": "api/user_des/" + '{{Auth::user()->id}}'+ "",
            "method": "GET",
            "timeout": 0,
        };

        $.ajax(settings).done(function(response) {
            if (response[0]['designations'] == ' Company Admin') {

                $('#com_pro').css('display', 'block');

            } else {

                $('#com_pro').css('display', 'none');

            }
        })
    }
    // alert(window.location.href);
    // var currentUrl = window.location.href;

    // // Check if the URL contains 'index'
    // if (currentUrl.indexOf('index') !== -1) {
    //     // Get the element with the id "left_flex_div"
    //     var leftFlexDiv = document.getElementById('left_flex_div');

    //     // HTML code to append
    //     var htmlCode =
    //         '<button id="getData2" style="margin-top: 4px;margin-right:10px;" type="button"' +
    //         'class="btn btn-soft-light waves-effect waves-light">' +
    //         '<i class="bx bx-camera font-size-16 align-middle"></i>' +
    //         '</button>' +
    //         '<button class="btn btn-soft-light" onclick="check_ticket_button()">Get Record </button>';

    //     // Append the HTML code to the "left_flex_div"
    //     leftFlexDiv.innerHTML = htmlCode;

    // } else {

    // }
</script>
