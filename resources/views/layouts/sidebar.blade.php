<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true"
            data-slide-speed="200" style="padding-top: 20px">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler">
                    <span></span>
                </div>
            </li>
            <!-- END SIDEBAR TOGGLER BUTTON -->
            <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
            <li class="nav-item start {{ setActiveClass('home') }}">
                <a href="{{ route('home') }}" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">{{ __('homepage.title') }}</span>
                    {{-- <span class="selected"></span> --}}
                    {{-- <span class="arrow open"></span> --}}
                </a>
                {{-- <ul class="sub-menu">
                    <li class="nav-item start active open">
                        <a href="index.html" class="nav-link ">
                            <i class="icon-bar-chart"></i>
                            <span class="title">Dashboard 1</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="nav-item start ">
                        <a href="dashboard_2.html" class="nav-link ">
                            <i class="icon-bulb"></i>
                            <span class="title">Dashboard 2</span>
                            <span class="badge badge-success">1</span>
                        </a>
                    </li>
                </ul> --}}
            </li>
            {{-- <li class="heading">
                <h3 class="uppercase">Dashboard</h3>
            </li> --}}

            @can('view patients')
            <li class="nav-item {{ setActiveClass('patient.*') }}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-users"></i>
                    <span class="title">{{ __('patients.patients') }}</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item {{ setActiveClass('patient.index') }}">
                        <a href="{{ route('patient.index') }}" class="nav-link">
                            <i class="glyphicon glyphicon-align-justify"></i>
                            <span class="title">{{ __('sidebar.show') }}</span>
                        </a>
                    </li>
                    @can('create patients')
                    <li class="nav-item {{ setActiveClass('patient.create') }}">
                        <a href="{{ route('patient.create') }}" class="nav-link ">
                            <i class="icon-plus"></i>
                            <span class="title">{{ __('sidebar.register') }}</span>
                        </a>
                    </li>
                    @endcan
                    @can('view blocked patients')
                    <li class="nav-item {{ setActiveClass('patient.blockedPatients') }}">
                        <a href="{{ route('patient.blockedPatients') }}" class="nav-link ">
                            <i class="glyphicon glyphicon-ban-circle"></i>
                            <span class="title">{{ __('patients.blockedPatients') }}</span>
                        </a>
                    </li>
                    @endcan
                    <li class="nav-item {{ setActiveClass('patient.emergencyPatients') }}">
                        <a href="{{ route('patient.emergencyPatients') }}" class="nav-link ">
                            <i class="glyphicon glyphicon-plus-sign"></i>
                            <span class="title">{{ __('patients.emergencyPatients') }}</span>
                        </a>
                    </li>
                    {{-- <li class="nav-item  ">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <span class="title">Page Progress Bar</span>
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item ">
                                <a href="ui_page_progress_style_1.html" class="nav-link "> Flash </a>
                            </li>
                            <li class="nav-item ">
                                <a href="ui_page_progress_style_2.html" class="nav-link "> Big Counter </a>
                            </li>
                        </ul>
                    </li> --}}
                </ul>
            </li>
           @endcan

           @if(auth()->check() && auth()->user()->isDoctor())
            <li class="nav-item {{ setActiveClass('doctor.*') }}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-stethoscope"></i>
                    <span class="title">{{ __('doctor.title') }}</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item {{ setActiveClass('user.profile') }}">
                        <a href="{{ route('user.profile') }}" class="nav-link">
                            <i class="glyphicon glyphicon-user"></i>
                            <span class="title">{{ __('doctor.myData') }}</span>
                        </a>
                    </li>
                    <li class="nav-item {{ setActiveClass('doctor.waitingList') }}">
                        <a href="{{ route('doctor.waitingList') }}" class="nav-link ">
                            <i class="glyphicon glyphicon-list-alt"></i>
                            <span class="title">{{ __('doctor.waitingList') }}</span>
                        </a>
                    </li>

                    <li class="nav-item {{ setActiveClass('doctor.raysRequests') }}">
                        <a href="{{ route('doctor.raysRequests') }}" class="nav-link ">
                            <i class="fa fa-heartbeat"></i>
                            <span class="title">{{ __('raysRequests.title') }}</span>
                        </a>
                    </li>

                    <li class="nav-item {{ setActiveClass('doctor.testsRequests') }}">
                        <a href="{{ route('doctor.testsRequests') }}" class="nav-link ">
                            <i class="icon-chemistry"></i>
                            <span class="title">{{ __('medicalTestsRequests.title') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
           @endif

           @technician
            <li class="nav-item {{ setActiveClass('raysRequest.*') }}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-heartbeat"></i>
                    <span class="title">{{ __('raysRequests.title') }}</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item {{ setActiveClass('raysRequest.show') }}">
                        <a href="{{ route('raysRequest.index') }}" class="nav-link">
                            <i class="glyphicon glyphicon-align-justify"></i>
                            <span class="title">{{ __('sidebar.show') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
           @endtechnician

           @testResponsible
            <li class="nav-item {{ setActiveClass('testRequest.*') }}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-chemistry"></i>
                    <span class="title">{{ __('medicalTestsRequests.title') }}</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item {{ setActiveClass('testRequest.show') }}">
                        <a href="{{ route('testRequest.index') }}" class="nav-link">
                            <i class="glyphicon glyphicon-align-justify"></i>
                            <span class="title">{{ __('sidebar.show') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
           @endtestResponsible
        </ul>
        <!-- END SIDEBAR MENU -->
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
<!-- END SIDEBAR -->
