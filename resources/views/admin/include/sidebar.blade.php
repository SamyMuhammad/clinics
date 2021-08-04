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
            <li class="nav-item start {{ setActiveClass('admin.dashboard') }}">
                <a href="{{ route('admin.dashboard') }}" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">لوحة التحكم</span>
                    {{-- <span class="selected"></span> --}}
                    {{-- <span class="arrow open"></span> --}}
                </a>
            </li>

            @can('control settings')
            <li class="nav-item start {{ setActiveClass('admin.settings.*') }}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">الإعدادات</span>
                    {{-- <span class="selected"></span> --}}
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item start {{ setActiveClass('admin.settings.translations') }}">
                        <a href="{{ route('admin.settings.translations') }}" class="nav-link ">
                            <i class="icon-bar-chart"></i>
                            <span class="title">الترجمة</span>
                            {{-- <span class="selected"></span> --}}
                        </a>
                    </li>
                </ul>
            </li>
            @endcan

            @can('view roles')
            <li class="nav-item {{ setActiveClass('admin.role.*') }}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-graduation"></i>
                    <span class="title">الأدوار والصلاحيات</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item {{ setActiveClass('admin.role.admins') }}">
                        <a href="{{ route('admin.role.admins') }}" class="nav-link">
                            <i class="glyphicon glyphicon-list-alt"></i>
                            <span class="title">أدوار المديرين</span>
                        </a>
                    </li>
                    @can('create roles')
                    <li class="nav-item {{ setActiveClass('admin.role.users') }}">
                        <a href="{{ route('admin.role.users') }}" class="nav-link ">
                            <i class="glyphicon glyphicon-list-alt"></i>
                            <span class="title">أدوار المستخدمين</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan

            @can('view admins')
            <li class="nav-item {{ setActiveClass('admin.admin.*') }}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class=" icon-briefcase"></i>
                    <span class="title">المديرين</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item {{ setActiveClass('admin.admin.index') }}">
                        <a href="{{ route('admin.admin.index') }}" class="nav-link">
                            <i class="glyphicon glyphicon-align-justify"></i>
                            <span class="title">عرض</span>
                        </a>
                    </li>
                    @can('create admins')
                    <li class="nav-item {{ setActiveClass('admin.admin.create') }}">
                        <a href="{{ route('admin.admin.create') }}" class="nav-link ">
                            <i class="icon-plus"></i>
                            <span class="title">إضافة</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan

            @can('view users')
            <li class="nav-item {{ setActiveClass('admin.user.*') }}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-user"></i>
                    <span class="title">الأعضاء</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    @can('create users')
                    <li class="nav-item {{ setActiveClass('admin.user.create') }}">
                        <a href="{{ route('admin.user.create') }}" class="nav-link ">
                            <i class="icon-plus"></i>
                            <span class="title">إضافة</span>
                        </a>
                    </li>
                    @endcan
                    <li class="nav-item {{ setActiveClass('admin.user.index') }}">
                        <a href="{{ route('admin.user.index') }}" class="nav-link">
                            <i class="glyphicon glyphicon-align-justify"></i>
                            <span class="title">عرض الكل</span>
                        </a>
                    </li>

                    <li class="nav-item {{ setActiveClass(['admin.user.usersByJob', 'doctors']) }}">
                        <a href="{{ route('admin.user.usersByJob', 'doctors') }}" class="nav-link">
                            <i class="fa fa-user-md"></i>
                            <span class="title">عرض الأطباء</span>
                        </a>
                    </li>

                    <li class="nav-item {{ setActiveClass(['admin.user.usersByJob', 'technicians']) }}">
                        <a href="{{ route('admin.user.usersByJob', 'technicians') }}" class="nav-link">
                            <i class="fa fa-user"></i>
                            <span class="title">عرض فنيين الآشعة</span>
                        </a>
                    </li>

                    <li class="nav-item {{ setActiveClass(['admin.user.usersByJob', 'tests-doctors']) }}">
                        <a href="{{ route('admin.user.usersByJob', 'tests-doctors') }}" class="nav-link">
                            <i class="fa fa-user-md"></i>
                            <span class="title">عرض أطباء التحاليل</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endcan

            @can('view patients')
            <li class="nav-item {{ setActiveClass('admin.patient.*') }}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-users"></i>
                    <span class="title">المرضى</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item {{ setActiveClass('admin.patient.index') }}">
                        <a href="{{ route('admin.patient.index') }}" class="nav-link">
                            <i class="glyphicon glyphicon-align-justify"></i>
                            <span class="title">عرض</span>
                        </a>
                    </li>
                    @can('create patients')
                    <li class="nav-item {{ setActiveClass('admin.patient.create') }}">
                        <a href="{{ route('admin.patient.create') }}" class="nav-link ">
                            <i class="icon-plus"></i>
                            <span class="title">إضافة</span>
                        </a>
                    </li>
                    @endcan
                    @can('view blocked patients')
                    <li class="nav-item {{ setActiveClass('admin.patient.blockedPatients') }}">
                        <a href="{{ route('admin.patient.blockedPatients') }}" class="nav-link ">
                            <i class="glyphicon glyphicon-ban-circle"></i>
                            <span class="title">{{ __('patients.blockedPatients') }}</span>
                        </a>
                    </li>
                    @endcan
                    <li class="nav-item {{ setActiveClass('admin.patient.emergencyPatients') }}">
                        <a href="{{ route('admin.patient.emergencyPatients') }}" class="nav-link ">
                            <i class="glyphicon glyphicon-plus-sign"></i>
                            <span class="title">{{ __('patients.emergencyPatients') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endcan

            @can('view clinics')
            <li class="nav-item {{ setActiveClass('admin.clinic.*') }}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-medkit"></i>
                    <span class="title">العيادات</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item {{ setActiveClass('admin.clinic.index') }}">
                        <a href="{{ route('admin.clinic.index') }}" class="nav-link">
                            <i class="glyphicon glyphicon-align-justify"></i>
                            <span class="title">عرض</span>
                        </a>
                    </li>
                    @can('create clinics')
                    <li class="nav-item {{ setActiveClass('admin.clinic.create') }}">
                        <a href="{{ route('admin.clinic.create') }}" class="nav-link ">
                            <i class="icon-plus"></i>
                            <span class="title">إضافة</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan

            @can('view rays')
            <li class="nav-item {{ setActiveClass('admin.rays.*') }} {{ setActiveClass('admin.rays-requests.*') }}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-heartbeat"></i>
                    <span class="title">الآشعة</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item {{ setActiveClass('admin.rays.index') }}">
                        <a href="{{ route('admin.rays.index') }}" class="nav-link">
                            <i class="glyphicon glyphicon-align-justify"></i>
                            <span class="title">عرض أنواع الآشعة</span>
                        </a>
                    </li>
                    @can('create rays')
                    <li class="nav-item {{ setActiveClass('admin.rays.create') }}">
                        <a href="{{ route('admin.rays.create') }}" class="nav-link ">
                            <i class="icon-plus"></i>
                            <span class="title">إضافة</span>
                        </a>
                    </li>
                    @endcan

                    @can('view raysRequests')
                    <li class="nav-item {{ setActiveClass('admin.rays-requests.index') }}">
                        <a href="{{ route('admin.rays-requests.index') }}" class="nav-link ">
                            <i class="fa fa-object-group"></i>
                            <span class="title">عرض طلبات الآشعة</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan

            @can('view medical tests')
            <li class="nav-item {{ setActiveClass('admin.medical-test.*') }}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-chemistry"></i>
                    <span class="title">التحاليل الطبية</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item {{ setActiveClass('admin.medical-test.index') }}">
                        <a href="{{ route('admin.medical-test.index') }}" class="nav-link">
                            <i class="glyphicon glyphicon-align-justify"></i>
                            <span class="title">عرض أنواع التحاليل</span>
                        </a>
                    </li>
                    @can('create medical tests')
                    <li class="nav-item {{ setActiveClass('admin.medical-test.create') }}">
                        <a href="{{ route('admin.medical-test.create') }}" class="nav-link ">
                            <i class="icon-plus"></i>
                            <span class="title">إضافة</span>
                        </a>
                    </li>
                    @endcan

                    @can('view medical tests requests')
                    <li class="nav-item {{ setActiveClass('admin.medical-test.requests') }}">
                        <a href="{{ route('admin.medical-test.requests') }}" class="nav-link ">
                            <i class="fa fa-object-group"></i>
                            <span class="title">عرض طلبات التحاليل</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan

            @can('view reservations')
            <li class="nav-item {{ setActiveClass('admin.reservation.*') }}">
                <a href="{{ route('admin.reservation.index') }}" class="nav-link nav-toggle">
                    <i class="fa fa-clock-o"></i>
                    <span class="title">الحجوزات</span>
                </a>
            </li>
            @endcan

            @can('view companies')
            <li class="nav-item {{ setActiveClass('admin.company.*') }}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-building-o"></i>
                    <span class="title">الشركات</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item {{ setActiveClass('admin.company.index') }}">
                        <a href="{{ route('admin.company.index') }}" class="nav-link">
                            <i class="glyphicon glyphicon-align-justify"></i>
                            <span class="title">عرض</span>
                        </a>
                    </li>
                    @can('create companies')
                    <li class="nav-item {{ setActiveClass('admin.company.create') }}">
                        <a href="{{ route('admin.company.create') }}" class="nav-link ">
                            <i class="icon-plus"></i>
                            <span class="title">إضافة</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan

            @can('view discounts')
            <li class="nav-item {{ setActiveClass('admin.discount.*') }}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-tag"></i>
                    <span class="title">التخفيضات</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item {{ setActiveClass('admin.discount.index') }}">
                        <a href="{{ route('admin.discount.index') }}" class="nav-link">
                            <i class="glyphicon glyphicon-align-justify"></i>
                            <span class="title">عرض</span>
                        </a>
                    </li>
                    @can('create discounts')
                    <li class="nav-item {{ setActiveClass('admin.discount.create') }}">
                        <a href="{{ route('admin.discount.create') }}" class="nav-link ">
                            <i class="icon-plus"></i>
                            <span class="title">إضافة</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan

            @can('view rooms')
            <li class="nav-item {{ setActiveClass('admin.room.*') }}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">غرف الإقامة</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item {{ setActiveClass('admin.room.index') }}">
                        <a href="{{ route('admin.room.index') }}" class="nav-link">
                            <i class="glyphicon glyphicon-align-justify"></i>
                            <span class="title">عرض</span>
                        </a>
                    </li>
                    @can('create rooms')
                    <li class="nav-item {{ setActiveClass('admin.room.create') }}">
                        <a href="{{ route('admin.room.create') }}" class="nav-link ">
                            <i class="icon-plus"></i>
                            <span class="title">إضافة</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan
        </ul>
        <!-- END SIDEBAR MENU -->
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
<!-- END SIDEBAR -->