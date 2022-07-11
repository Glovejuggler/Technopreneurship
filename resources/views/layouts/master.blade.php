<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $application->app_name }}</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"></script> --}}
    @yield('fullcalendar')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        {{-- Header/Navbar --}}
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button" data-enable-remember="true"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->first_name.' '.Auth::user()->middle_name.' '.Auth::user()->last_name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a href="{{ route('user.profile') }}" class="dropdown-item">Profile</a>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </nav>

        {{-- Sidebar --}}
        <aside class="main-sidebar sidebar-dark-primary elevation-4">

            <a href="#" class="brand-link" style="text-decoration: none">
                <img src="{{ url('/favicon.ico') }}" alt="App Logo" class="brand-image img-circle elevation-3"
                    style="opacity: 1">
                <span class="brand-text font-weight-light">{{ $application->company_name }}</span>
            </a>

            <div class="sidebar">

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-gauge"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        @can('do-admin-stuff')
                        <li
                            class="nav-item {{ Request::is('users') || Request::is('roles') ? 'menu-open' : 'menu-close' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    User Management
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('user.index') }}"
                                        class="nav-link {{ Request::is('users') ? 'active' : '' }}">
                                        <i class="fas fa-user-group nav-icon"></i>
                                        <p>Users</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('role.index') }}"
                                        class="nav-link {{ Request::is('roles') ? 'active' : '' }}">
                                        <i class="fas fa-briefcase nav-icon"></i>
                                        <p>Roles</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endcan
                        <li
                            class="nav-item {{ Request::is('files') || Request::is('folders') || Request::is('shared_files') ? 'menu-open' : 'menu-close' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-folder-tree"></i>
                                <p>
                                    File Management
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('folder.index') }}"
                                        class="nav-link {{ Request::is('folders') ? 'active' : '' }}">
                                        <i class="fas fa-folder nav-icon"></i>
                                        <p>Folders</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('file.index') }}"
                                        class="nav-link {{ Request::is('files') ? 'active' : '' }}">
                                        <i class="fas fa-file nav-icon"></i>
                                        <p>Files</p>
                                    </a>
                                </li>
                                @cannot('do-admin-stuff')
                                <li class="nav-item">
                                    <a href="{{ route('share.index') }}"
                                        class="nav-link {{ Request::is('shared_files') ? 'active' : '' }}">
                                        <i class="fas fa-square-share-nodes nav-icon"></i>
                                        <p>Shared Files</p>
                                    </a>
                                </li>
                                @endcannot
                            </ul>
                        </li>
                        @can('do-admin-stuff')
                        <li class="nav-item">
                            <a href="{{ route('app.settings') }}"
                                class="nav-link {{ Request::is('settings') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-cog"></i>
                                <p>
                                    Settings
                                </p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </nav>
            </div>
        </aside>

        {{-- Content --}}
        <div class="content-wrapper pt-2">

            @yield('content')

        </div>
        {{-- Footer --}}
        {{-- <footer class="main-footer">

            <div class="float-right d-none d-sm-inline">
                Digitalized Document Storage System
            </div>

            <strong>Copyright &copy; <a href="https://adminlte.io">PUP Calauan, Laguna Campus</a>.</strong> All rights
            reserved.
        </footer> --}}
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        $(document).ready( function () {
            $('#myTable').DataTable();
        } );
    </script>
    @include('sweetalert::alert')
    @yield('scripts')
</body>

</html>