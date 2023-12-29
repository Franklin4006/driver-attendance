<?php
$url_segments = request()->segments();

$home = '';
$drivers = '';
$attendance = '';
$advance = '';

if (isset($url_segments[0]) && ($url_segments[0] == 'home')) {
    $home = 'active';
}
if (isset($url_segments[0]) && ($url_segments[0] == 'drivers')) {
    $drivers = 'active';
}
if (isset($url_segments[0]) && ($url_segments[0] == 'attendance')) {
    $attendance = 'active';
}
if (isset($url_segments[0]) && ($url_segments[0] == 'advance')) {
    $advance = 'active';
}

?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-success elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/home') }}" class="brand-link text-center">
        {{-- <img src="{{ asset('template/AdminLTE3/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
        <span class="brand-text">{{ env('APP_NAME') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('images/user-icon.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">
                    {{ auth()->user()->name }}
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <li class="nav-item">
                    <a href="{{ url('home') }}" class="nav-link {{ $home }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Home
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('drivers') }}" class="nav-link {{ $drivers }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Drivers
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('attendance') }}" class="nav-link {{ $attendance }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Attendance
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('advance') }}" class="nav-link {{ $advance }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Advance
                        </p>
                    </a>
                </li>



            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
