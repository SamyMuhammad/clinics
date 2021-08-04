<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    {{-- Begin Metronic --}}
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
        type="text/css" />
    <link href="{{ custom_asset('metronic/assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ custom_asset('metronic/assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ custom_asset('metronic/assets/global/plugins/bootstrap/css/bootstrap-rtl.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ custom_asset('metronic/assets/global/plugins/bootstrap-switch/css/bootstrap-switch-rtl.min.css') }}"
        rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS --> 
    <link href="{{ custom_asset('metronic/assets/global/plugins/morris/morris.css') }}" rel="stylesheet" type="text/css" />
    @yield('page-style-plugins')
    <!-- END PAGE LEVEL PLUGINS -->

    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{ custom_asset('metronic/assets/global/css/components-rounded-rtl.min.css') }}" rel="stylesheet" id="style_components"
        type="text/css" />
    <link href="{{ custom_asset('metronic/assets/global/css/plugins-rtl.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    @yield('page-level-styles')
    <!-- END PAGE LEVEL SCRIPTS -->

    <!-- BEGIN THEME LAYOUT SCRIPTS -->
    <link href="{{ custom_asset('metronic/assets/layouts/layout/css/layout-rtl.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ custom_asset('metronic/assets/layouts/layout/css/themes/darkblue-rtl.min.css') }}" rel="stylesheet" type="text/css" id="style_color" />
    <link href="{{ custom_asset('metronic/assets/layouts/layout/css/custom-rtl.min.css') }}" rel="stylesheet" type="text/css" />
    @yield('theme-layout-styles')
    <!-- END THEME LAYOUT SCRIPTS -->

    {{-- End Metronic --}}
    <link href="{{ custom_asset('assets/css/style.css') }}" rel="stylesheet">
    @yield('extra-css')
</head>

<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-content-white">
    <div class="page-wrapper">
        @include('admin.include.header')
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            @include('admin.include.sidebar')
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    <!-- BEGIN PAGE BAR -->
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <a href="{{ route('admin.dashboard') }}">لوحة التحكم</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <span>@yield('bar-title')</span>
                            </li>
                        </ul>
                    </div>
                    <!-- END PAGE BAR -->

                    <!-- BEGIN PAGE TITLE-->
                    <h1 class="page-title">
                        @yield('page-title')
                    </h1>
                    {{-- <div class="mt-5"></div> --}}
                    <!-- END PAGE TITLE-->

                    <!-- END PAGE HEADER-->
                    @include('layouts.flashes')

                    @yield('content')
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->

        <div class="clearfix"> </div>
        <!-- BEGIN FOOTER -->
        <div class="page-footer text-center">
            <div class="page-footer-inner" style="float: none">
                حقوق البرمجة والتصميم {{ date("Y") }} &copy; <a target="_blank" href="https://ieasoft.net/">Ieasoft</a>
            </div>
            <div class="scroll-to-top">
                <i class="icon-arrow-up"></i>
            </div>
        </div>
        <!-- END FOOTER -->
    </div>
        <!--[if lt IE 9]>
            <script src="../assets/global/plugins/respond.min.js"></script>
            <script src="../assets/global/plugins/excanvas.min.js"></script> 
            <script src="../assets/global/plugins/ie8.fix.min.js"></script> 
        <![endif]-->

        <!-- BEGIN CORE PLUGINS -->
        <script src="{{ custom_asset('metronic/assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
        <script src="{{ custom_asset('metronic/assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ custom_asset('metronic/assets/global/plugins/js.cookie.min.js') }}" type="text/javascript"></script>
        <script src="{{ custom_asset('metronic/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
        <script src="{{ custom_asset('metronic/assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
        <script src="{{ custom_asset('metronic/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->

        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{ custom_asset('metronic/assets/global/plugins/morris/morris.min.js') }}" type="text/javascript"></script>
        <script src="{{ custom_asset('metronic/assets/global/plugins/morris/raphael-min.js') }}" type="text/javascript"></script>
        @yield('page-script-plugins')
        <!-- END PAGE LEVEL PLUGINS -->

        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="{{ custom_asset('metronic/assets/global/scripts/app.min.js') }}" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{ custom_asset('metronic/assets/pages/scripts/dashboard.min.js') }}" type="text/javascript"></script>
        @yield('page-level-scripts')
        <!-- END PAGE LEVEL SCRIPTS -->

        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="{{ custom_asset('metronic/assets/layouts/layout/scripts/layout.min.js') }}" type="text/javascript"></script>
        <script src="{{ custom_asset('metronic/assets/layouts/layout/scripts/demo.min.js') }}" type="text/javascript"></script>
        <script src="{{ custom_asset('metronic/assets/layouts/global/scripts/quick-sidebar.min.js') }}" type="text/javascript"></script>
        <script src="{{ custom_asset('metronic/assets/layouts/global/scripts/quick-nav.min.js') }}" type="text/javascript"></script>
        @yield('theme-layout-scripts')
        <!-- END THEME LAYOUT SCRIPTS -->

        <script src="{{ custom_asset('assets/js/main.js') }}"></script>
        <script>
            $(document).ready(function()
                {
                    $('#clickmewow').click(function()
                    {
                        $('#radio1003').attr('checked', 'checked');
                    });
                })
        </script>
        @yield('extra-js')
    </div>
</body>

</html>