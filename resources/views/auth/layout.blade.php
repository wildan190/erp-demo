<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ERP - @yield('title')</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.0/css/all.min.css">
    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/css/adminlte.min.css">
    <style>
        .app-shell { min-height:100vh; }
        .app-sidebar { width: 250px; }
        .content { margin-left: 0; }
        @media (min-width: 768px) { .content { margin-left: 250px; } }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="app-shell">
        <aside id="appSidebar" class="main-sidebar sidebar-dark-primary elevation-4 d-none d-md-block">
            <a href="/" class="brand-link text-decoration-none">
                <span class="brand-text font-weight-light pl-3">{{ config('app.name', 'ERP Demo') }}</span>
            </a>
            <div class="sidebar p-2">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item"><a href="/dashboard" class="nav-link text-white"> <i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p></a></li>
                        <li class="nav-item"><a href="/customers" class="nav-link text-white"><i class="nav-icon fas fa-users"></i><p>Customers</p></a></li>
                        <li class="nav-item"><a href="/products" class="nav-link text-white"><i class="nav-icon fas fa-boxes"></i><p>Products</p></a></li>
                        <li class="nav-item"><a href="/orders" class="nav-link text-white"><i class="nav-icon fas fa-shopping-cart"></i><p>Sales Orders</p></a></li>
                        <li class="nav-item"><a href="/invoices" class="nav-link text-white"><i class="nav-icon fas fa-file-invoice"></i><p>Invoices</p></a></li>
                        <li class="nav-item"><a href="/suppliers" class="nav-link text-white"><i class="nav-icon fas fa-truck"></i><p>Suppliers</p></a></li>
                        <li class="nav-item"><a href="/purchases" class="nav-link text-white"><i class="nav-icon fas fa-receipt"></i><p>Purchases</p></a></li>
                        <li class="nav-item"><a href="/admin/users" class="nav-link text-white"><i class="nav-icon fas fa-user-shield"></i><p>Admin</p></a></li>
                    </ul>
                </nav>
                <div class="mt-3">
                    @php $prefix = request()->segment(1) ?? 'dashboard'; @endphp
                    @if (View::exists('sidebars.' . $prefix))
                        @include('sidebars.' . $prefix)
                    @else
                        @include('sidebars.default')
                    @endif
                </div>
            </div>
        </aside>
            <div class="p-2 text-xs text-slate-400">Module Menu</div>
            {{-- include module-specific sidebar if exists --}}
            @php
                $prefix = request()->segment(1) ?? 'dashboard';
            @endphp
            @if (View::exists('sidebars.' . $prefix))
                @include('sidebars.' . $prefix)
            @else
                @include('sidebars.default')
            @endif
        </aside>

        <div class="content p-3">
            <div class="d-flex justify-content-between align-items-center mb-3 d-md-none">
                <button id="sidebarToggle" class="btn btn-secondary">Menu</button>
                <div>
                    @auth
                        <span class="me-3">{{ auth()->user()->name }}</span>
                    @endauth
                </div>
            </div>

            @yield('content')
        </div>
    </div>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/js/adminlte.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var btn = document.getElementById('sidebarToggle');
            var sidebar = document.getElementById('appSidebar');
            if (btn && sidebar) {
                btn.addEventListener('click', function () {
                    sidebar.classList.toggle('d-none');
                });
            }
        });
    </script>
</body>
</html>
