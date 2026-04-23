@include('backend.layouts.header_files')

<body data-sidebar="dark">

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

    <!-- Begin page -->
    <div id="layout-wrapper">

    @include('backend.layouts.top_bar')

        <!-- ========== Left Sidebar Start ========== -->
        @include('backend.layouts.side_navigation')
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->

                    <!-- end page title -->

                    @yield('contents')

                </div><!-- container-fluid -->

            </div><!-- End Page-content -->


            @include('backend.layouts.footer')

        </div><!-- end main content-->

    </div><!-- END layout-wrapper -->

    <!-- Right Sidebar -->

    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

@include('backend.layouts.footer_files')
