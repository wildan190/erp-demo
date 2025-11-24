<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title') - {{ config('app.name', 'Laravel') }} Admin</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.0/css/all.min.css">
        <!-- Bootstrap 4 CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        <!-- Ionicons (optional) -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- AdminLTE -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/css/adminlte.min.css">

        <style>
                .content-wrapper { min-height: 80vh; }
        </style>

        @stack('head')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/" class="nav-link">Home</a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">

            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                    <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim(Auth::user()->email ?? '')) ) }}?s=32&d=identicon" class="user-image img-circle elevation-2" alt="User Image">
                    <span class="d-none d-md-inline">{{ Auth::user()->name ?? 'Guest' }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <li class="user-header bg-primary">
                        <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim(Auth::user()->email ?? '')) ) }}?s=90&d=identicon" class="img-circle elevation-2" alt="User Image">
                        <p>
                            {{ Auth::user()->name ?? 'Guest' }} - {{ Auth::user()->role ?? 'User' }}
                        </p>
                    </li>
                    <li class="user-footer">
                        <a href="{{ route('profile.edit') }}" class="btn btn-default btn-flat">Profile</a>
                        <form method="POST" action="{{ route('logout') }}" style="display:inline">@csrf<button class="btn btn-default float-end">Logout</button></form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="/" class="brand-link">
            <i class="fab fa-laravel brand-image img-circle elevation-3" style="opacity: .8"></i>
            <span class="brand-text font-weight-light">ERP Demo</span>
        </a>

        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim(Auth::user()->email ?? '')) ) }}?s=48&d=identicon" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ Auth::user()->name ?? 'Guest' }}</a>
                </div>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    @foreach(config('sidebar.items', []) as $item)
                        @php
                            $hasChildren = isset($item['children']) && is_array($item['children']);
                            // determine active state: check route patterns or exact route name
                            $isActive = false;
                            if (!empty($item['active'])) {
                                foreach ((array) $item['active'] as $pattern) {
                                    if (\Illuminate\Support\Str::is($pattern, request()->path()) || request()->routeIs($pattern)) { $isActive = true; break; }
                                }
                            } elseif (!empty($item['route'])) {
                                $isActive = request()->routeIs($item['route']);
                            }
                        @endphp
                        @if($hasChildren)
                            <li class="nav-item has-treeview {{ $isActive ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ $isActive ? 'active' : '' }}">
                                    <i class="nav-icon {{ $item['icon'] ?? 'fas fa-circle' }}"></i>
                                    <p>
                                        {{ $item['title'] }}
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @foreach($item['children'] as $child)
                                        <li class="nav-item">
                                            <a href="{{ isset($child['route']) ? route($child['route']) : (isset($child['url']) ? $child['url'] : '#') }}" class="nav-link {{ request()->routeIs($child['active'] ?? $child['route'] ?? '') ? 'active' : '' }}">
                                                <i class="nav-icon {{ $child['icon'] ?? 'far fa-circle' }}"></i>
                                                <p>{{ $child['title'] }}</p>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                                <li class="nav-item">
                                <a href="{{ isset($item['route']) ? (\Illuminate\Support\Facades\Route::has($item['route']) ? route($item['route']) : '#') : (isset($item['url']) ? $item['url'] : '#') }}" class="nav-link {{ $isActive ? 'active' : '' }}">
                                    <i class="nav-icon {{ $item['icon'] ?? 'fas fa-circle' }}"></i>
                                    <p>{{ $item['title'] }}</p>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </nav>
            {{-- module-specific submenu slot (keeps backward compatibility) --}}
            <div class="mt-3 px-2">
                @php $prefix = request()->segment(1) ?? 'dashboard'; @endphp
                @if (\Illuminate\Support\Facades\View::exists('sidebars.' . $prefix))
                    @include('sidebars.' . $prefix)
                @endif
            </div>
        </div>
    </aside>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>@yield('title', 'Dashboard')</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>
    </div>

    <footer class="main-footer">
        <div class="float-end d-none d-sm-inline">ERP Demo</div>
        <strong>&copy; {{ date('Y') }} <a href="#">{{ config('app.name', 'ERP Demo') }}</a>.</strong> All rights reserved.
    </footer>

</div>

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/js/adminlte.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>

@stack('scripts')
</body>
</html>
