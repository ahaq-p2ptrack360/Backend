
<!doctype html>
<html lang="en">


<head>

    <meta charset="utf-8" />
    <title>Dashboard | webadmin - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{--
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" /> --}}
    <meta content="Themesdesign" name="author" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



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

        <style>
            #nav_user_icon{
                padding:5px;
                font-size: 32px;
                color:#c0c5cb
            }
        </style>
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content" style="height: 1000px;"   >
            <div class="page-content"   >
                <div id="liveAlertPlaceholder"></div>
                <div class="container-fluid">
                    @include('Chatify::layouts.headLinks')

            <div class="messenger">
                {{-- ----------------------Users/Groups lists side---------------------- --}}
                <div class="messenger-listView {{ !!$id ? 'conversation-active' : '' }}">
                    {{-- Header and search bar --}}
                    <div class="m-header">
                        <nav>
                            <div class="card" style="background:#F5F6F8;padding:10px;border-radius:10px;">
                                <div>
                                    <nav class="m-header-right">
                                        <a href="#"><i class="fas fa-cog settings-btn"></i></a>
                                        <a href="#" class="listView-x"><i class="fas fa-times"></i></a>

                                    </nav>
                                </div>

                                <a href="#">
                                    <div class="avatar av-l upload-avatar-preview chatify-d-flex" style="background-image: url('{{ Chatify::getUserWithAvatar(Auth::user())->avatar }}'); height:70px;width:70px">
                                    </div> <span class="messenger-headTitle" style="display:flex; justify-content: center;">{{ Auth::user()->first_name }}</span>
                                </a>
                                {{-- header buttons --}}

                            </div>
                        </nav>
                        {{-- Search input --}}
                        <input type="text" class="messenger-search" placeholder="Search" />
                        {{-- Tabs --}}
                        {{-- <div class="messenger-listView-tabs">
                <a href="#" class="active-tab" data-view="users">
                    <span class="far fa-user"></span> Contacts</a>
            </div> --}}
                    </div>
                    {{-- tabs and lists --}}
                    <div class="m-body contacts-container" style="padding-top:190px;">
                        {{-- Lists [Users/Group] --}}
                        {{-- ---------------- [ User Tab ] ---------------- --}}
                        <div class="show messenger-tab users-tab app-scroll" data-view="users" style="height:200px;">
                            {{-- Favorites --}}
                            <div class="favorites-section">
                                <p class="messenger-title"><span>Favorites</span></p>
                                <div class="messenger-favorites app-scroll-hidden"></div>
                            </div>
                            {{-- Saved Messages --}}
                            {{-- <p class="messenger-title"><span>Your Space</span></p> --}}
                            {!! view('Chatify::layouts.listItem', ['get' => 'saved']) !!}
                            {{-- Contact --}}
                            <p class="messenger-title"><span>All Messages</span></p>
                            <div class="listOfContacts" style="width: 100%;height: calc(100% - 272px);position: relative;">
                            </div>
                        </div>
                        {{-- ---------------- [ Search Tab ] ---------------- --}}
                        <div class="messenger-tab search-tab app-scroll" data-view="search">
                            {{-- items --}}
                            <p class="messenger-title"><span>Search</span></p>
                            <div class="search-records">
                                <p class="message-hint center-el"><span>Type to search..</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ----------------------Messaging side---------------------- --}}
                <div class="messenger-messagingView">
                    {{-- header title [conversation name] amd buttons --}}
                    <div class="m-header m-header-messaging">
                        <nav class="chatify-d-flex chatify-justify-content-between chatify-align-items-center">
                            {{-- header back button, avatar and user name --}}
                            <div class="chatify-d-flex chatify-justify-content-between chatify-align-items-center">
                                <a href="#" class="show-listView"><i class="fas fa-arrow-left"></i></a>
                                <div class="avatar av-s header-avatar" style="margin: 0px 10px; margin-top: -5px; margin-bottom: -5px;">
                                </div>
                                <a href="#" class="user-name"></a>
                            </div>
                            {{-- header buttons --}}
                            <nav class="m-header-right">
                                <a href="#" class="add-to-favorite"><i class="fas fa-star"></i></a>

                                <a href="#" class="show-infoSide"><i class="fas fa-info-circle"></i></a>
                            </nav>
                        </nav>
                        {{-- Internet connection --}}
                        <div class="internet-connection">
                            <span class="ic-connected">Connected</span>
                            <span class="ic-connecting">Connecting...</span>
                            <span class="ic-noInternet">No internet access</span>
                        </div>
                    </div>

                    {{-- Messaging area --}}
                    <div class="m-body messages-container app-scroll" style="height: 364px; overflow:auto">
                        <div class="messages">
                            <p class="message-hint center-el"><span>Please select a chat to start messaging</span></p>
                        </div>
                        {{-- Typing indicator --}}
                        <div class="typing-indicator">
                            <div class="message-card typing">
                                <div class="message">
                                    <span class="typing-dots">
                                        <span class="dot dot-1"></span>
                                        <span class="dot dot-2"></span>
                                        <span class="dot dot-3"></span>
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                    {{-- Send Message Form --}}
                    @include('Chatify::layouts.sendForm')
                </div>
                {{-- ---------------------- Info side ---------------------- --}}
                <div class="messenger-infoView app-scroll">
                    {{-- nav actions --}}
                    <nav>
                        <p>User Details</p>
                        <a href="#"><i class="fas fa-times"></i></a>
                    </nav>
                    {!! view('Chatify::layouts.info')->render() !!}
                </div>
            </div>

            @include('Chatify::layouts.modals')
            @include('Chatify::layouts.footerLinks')

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


        </div>
        <!-- end main content-->






    </div>

    <!-- Right Sidebar -->

    <!-- JAVASCRIPT -->

    @include('partials.script')
</body>
@include('partials.footer')
<!-- END layout-wrapper -->
@include('partials.right_bar')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>

</html>
{{-- <li>
    <div class="conversation-list">
        <div class="d-flex">
            <img src="assets/images/users/avatar-6.jpg"
                class="rounded-circle avatar" alt="">
            <div class="flex-1">
                <div class="ctext-wrap">
                    <div class="ctext-wrap-content">
                        <div class="conversation-name"><span
                                class="time">10:00</span></div>
                        <p class="mb-0">Hi Jordan! </br>
                            Feels like it's been a while! Home are you?
                            Do you
                            have ant time for the remainder of the week
                            to help me with an ongoing project?</p>

                    </div>
                    <div class="dropdown align-self-start">
                        <a class="dropdown-toggle" href="#"
                            role="button" data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item"
                                href="#">Copy</a>
                            <a class="dropdown-item"
                                href="#">Save</a>
                            <a class="dropdown-item"
                                href="#">Forward</a>
                            <a class="dropdown-item"
                                href="#">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</li> --}}
    