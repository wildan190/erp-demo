<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Modern ERP Solution</title>

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Font Awesome (AdminLTE's bundled version) -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/plugins/fontawesome-free/css/all.min.css">

    <!-- Font Awesome 6 (Latest version override for extended icons) -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1B1k0nnkQy7a2eG1H1u1Q7D1CqCmK1tGZib4AzEe7YQDdyCjTiMQuYzfoalGoVxkw=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- AdminLTE CSS -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    <!-- Bootstrap (included by AdminLTE, but added for safety) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .hero-section {
            padding: 80px 0;
        }
        .hero-title {
            font-size: 2.8rem;
            font-weight: 700;
        }
        .hero-subtitle {
            max-width: 720px;
        }
        .feature-card {
            border-radius: 12px;
        }
    </style>
</head>

<body class="hold-transition layout-top-nav">

<div class="wrapper">

    <!-- NAVBAR -->
    <nav class="main-header navbar navbar-expand-md navbar-light navbar-white shadow-sm">
        <div class="container">

            <!-- Logo -->
            <a href="/" class="navbar-brand d-flex align-items-center">
                <i class="fas fa-cubes fa-lg text-primary mr-2"></i>
                <span class="brand-text font-weight-bold">{{ config('app.name', 'ERP Demo') }}</span>
            </a>

            <!-- Mobile toggle -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu -->
            <div class="collapse navbar-collapse" id="navMenu">
                <!-- Left -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a href="#" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="#features" class="nav-link">Features</a></li>
                    <li class="nav-item"><a href="#pricing" class="nav-link">Pricing</a></li>
                    <li class="nav-item"><a href="#about" class="nav-link">About</a></li>
                </ul>

                <!-- Right Auth Buttons -->
                <ul class="navbar-nav ml-3">
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-sm">Dashboard</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="nav-link">Log in</a>
                            </li>

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm ml-2">Register</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>


    <!-- CONTENT WRAPPER -->
    <div class="content-wrapper">

        <!-- HERO SECTION -->
        <section class="hero-section bg-white text-center">
            <div class="container">
                <h1 class="hero-title">
                    Streamline Your Business with Our <span class="text-primary">Modern ERP</span>
                </h1>

                <p class="lead text-muted hero-subtitle mx-auto mt-3">
                    An all-in-one solution to manage your sales, inventory, customers, and much more.
                    Powerful, intuitive, and built for growth.
                </p>

                <div class="mt-4">
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Get Started</a>
                    <a href="#" class="btn btn-outline-secondary btn-lg ml-2">Live Demo</a>
                </div>
            </div>
        </section>


        <!-- FEATURES SECTION -->
        <section id="features" class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="font-weight-bold">Core Features</h2>
                    <p class="text-muted">Everything you need to run your business efficiently.</p>
                </div>

                <div class="row">
                    <!-- Feature 1 -->
                    <div class="col-md-4 mb-4">
                        <div class="card shadow feature-card">
                            <div class="card-body text-center">
                                <div class="p-3 rounded bg-primary text-white d-inline-block mb-3">
                                    <i class="fas fa-file-invoice fa-lg"></i>
                                </div>
                                <h5 class="font-weight-bold">Sales & Invoicing</h5>
                                <p>
                                    Create and manage orders, generate professional invoices, and track payments with ease.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="col-md-4 mb-4">
                        <div class="card shadow feature-card">
                            <div class="card-body text-center">
                                <div class="p-3 rounded bg-primary text-white d-inline-block mb-3">
                                    <i class="fas fa-boxes fa-lg"></i>
                                </div>
                                <h5 class="font-weight-bold">Inventory Management</h5>
                                <p>
                                    Keep track of stock levels, manage products, and automate inventory adjustments.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="col-md-4 mb-4">
                        <div class="card shadow feature-card">
                            <div class="card-body text-center">
                                <div class="p-3 rounded bg-primary text-white d-inline-block mb-3">
                                    <i class="fas fa-users fa-lg"></i>
                                </div>
                                <h5 class="font-weight-bold">Customer Relationship</h5>
                                <p>
                                    Maintain a comprehensive database of your customers and their interaction history.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </div>


    <!-- FOOTER -->
    <footer class="main-footer text-center small bg-white border-top py-3">
        <strong>&copy; {{ date('Y') }} {{ config('app.name', 'ERP Demo') }}.</strong>
        All rights reserved.
    </footer>

</div>

<!-- REQUIRED SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

</body>
</html>
