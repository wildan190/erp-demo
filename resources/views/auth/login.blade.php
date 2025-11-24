@extends('layouts.auth')

@section('title','Login')

@section('content')
    <h3 class="text-center mb-4">Login to Your Account</h3>

    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ url('/login') }}">
        @csrf
        <div class="form-group mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required class="form-control form-control-lg" placeholder="Enter your email">
        </div>
        <div class="form-group mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" required class="form-control form-control-lg" placeholder="Enter your password">
        </div>
        <div class="form-group d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">Remember me</label>
            </div>
            {{-- Optional: Add a "Forgot Password" link here if applicable --}}
            {{-- <a href="{{ route('password.request') }}" class="text-muted">Forgot Password?</a> --}}
        </div>
        <div>
            <button type="submit" class="btn btn-primary btn-lg btn-block mt-3">Login</button>
        </div>
    </form>

    <div class="text-center mt-4">
        <p class="text-muted">Don't have an account? <a href="{{ route('register') }}">Register Here</a></p>
    </div>
@endsection
