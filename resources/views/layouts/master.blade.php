<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@lang('app.app_name')">
    <meta name="author" content="">

    <title>@yield('title', __('app.app_name'))</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    @yield('styles')
</head>

<body id="page-top">

    <div id="wrapper">
        @auth
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">@lang('app.app_name')</div>
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>@lang('app.dashboard')</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">@lang('app.assets')</div>

            <li class="nav-item {{ request()->routeIs('hardware-assets.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('hardware-assets.index') }}">
                    <i class="fas fa-fw fa-desktop"></i>
                    <span>@lang('app.hardware_assets')</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('software-licenses.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('software-licenses.index') }}">
                    <i class="fas fa-fw fa-key"></i>
                    <span>@lang('app.software_licenses')</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('license-assignments.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('license-assignments.index') }}">
                    <i class="fas fa-fw fa-user-check"></i>
                    <span>@lang('app.license_assignments')</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">@lang('app.management')</div>

            <li class="nav-item {{ request()->routeIs('employees.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('employees.index') }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>@lang('app.employees')</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('departments.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('departments.index') }}">
                    <i class="fas fa-fw fa-building"></i>
                    <span>@lang('app.departments')</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('vendors.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('vendors.index') }}">
                    <i class="fas fa-fw fa-truck"></i>
                    <span>@lang('app.vendors')</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('asset-categories.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('asset-categories.index') }}">
                    <i class="fas fa-fw fa-tags"></i>
                    <span>@lang('app.asset_categories')</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('maintenance-records.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('maintenance-records.index') }}">
                    <i class="fas fa-fw fa-tools"></i>
                    <span>@lang('app.maintenance_records')</span>
                </a>
            </li>

            @role('Admin')
            <hr class="sidebar-divider">

            <div class="sidebar-heading">@lang('app.administration')</div>

            <li class="nav-item {{ request()->routeIs('roles.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('roles.index') }}">
                    <i class="fas fa-fw fa-user-tag"></i>
                    <span>@lang('app.roles')</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('permissions.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('permissions.index') }}">
                    <i class="fas fa-fw fa-shield-alt"></i>
                    <span>@lang('app.permissions')</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('users.index') }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>@lang('app.users')</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('audit-logs.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('audit-logs.index') }}">
                    <i class="fas fa-fw fa-history"></i>
                    <span>@lang('app.audit_logs')</span>
                </a>
            </li>
            @endrole

            <hr class="sidebar-divider">

            <div class="sidebar-heading">@lang('app.reports')</div>

            <li class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('reports.index') }}">
                    <i class="fas fa-fw fa-chart-bar"></i>
                    <span>@lang('app.reports')</span>
                </a>
            </li>

            <hr class="sidebar-divider d-md-none">

            @role('Admin')
            <div class="sidebar-heading d-md-none">@lang('app.admin')</div>

            <li class="nav-item d-md-none {{ request()->routeIs('roles.*') || request()->routeIs('permissions.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('roles.index') }}">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>@lang('app.user_management')</span>
                </a>
            </li>
            @endrole

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="@lang('app.search_for')" aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-globe"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="languageDropdown">
                                <a class="dropdown-item" href="?lang=fr">
                                    <i class="fas fa-check fa-sm mr-2 {{ app()->getLocale() == 'fr' ? '' : 'text-gray-400' }}"></i> Français
                                </a>
                                <a class="dropdown-item" href="?lang=en">
                                    <i class="fas fa-check fa-sm mr-2 {{ app()->getLocale() == 'en' ? '' : 'text-gray-400' }}"></i> @lang('app.english')
                                </a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                            </a>
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">@lang('app.alerts_center')</h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">@lang('app.show_all_alerts')</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->name }}</span>
                                <img class="img-profile rounded-circle" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=4e73df&color=fff">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    @lang('app.profile')
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    @lang('app.logout')
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>

                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; @lang('app.app_name') {{ date('Y') }}</span>
                    </div>
                </div>
            </footer>
        </div>
        @else
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>
        @endauth
    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('app.ready_to_leave')</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">@lang('app.logout_session')</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">@lang('app.cancel')</button>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-primary" type="submit">@lang('app.logout')</button>
                    </form>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-primary" type="submit">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @yield('scripts')

    @if(session('success'))
    <script>
        $(document).ready(function() {
            toastr.success('{{ session('success') }}');
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        $(document).ready(function() {
            toastr.error('{{ session('error') }}');
        });
    </script>
    @endif
</body>
</html>
