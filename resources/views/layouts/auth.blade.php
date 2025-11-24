<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Auth - @yield('title')</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.0/css/all.min.css">
  <style>
    body {
      background: linear-gradient(to right, #ece9e6, #ffffff); /* Subtle gradient */
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh; /* Ensure it takes full viewport height */
      margin: 0;
    }
    .auth-card {
      max-width: 420px;
      width: 90%; /* Make it responsive */
      margin: 20px auto; /* Adjust margin for better spacing */
    }
    .auth-card .card {
      border-radius: 1rem; /* Rounded corners */
      overflow: hidden; /* Ensures content respects border-radius */
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1); /* Stronger shadow */
    }
    .auth-card .card-body {
      padding: 2.5rem; /* More padding inside the card */
    }
    .auth-card .card-title {
      font-weight: 600; /* Make title bolder */
      color: #343a40; /* Darker color for title */
    }
    /* Responsive adjustments */
    @media (max-width: 576px) {
      .auth-card {
        width: 95%;
        margin: 10px auto;
      }
      .auth-card .card-body {
        padding: 1.5rem;
      }
    }
  </style>
  @stack('head')
</head>
<body>
  <div class="container auth-card">
    <div class="card shadow-sm">
      <div class="card-body">
        <h3 class="card-title mb-4 text-center">{{ config('app.name', 'ERP Demo') }}</h3>
        @yield('content')
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
</body>
</html>
