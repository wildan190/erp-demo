@extends('layouts.auth')

@section('title','Register')

@section('content')
    <h3 class="text-center mb-4">Create Your Account</h3>

    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ url('/register') }}">
        @csrf
        <div class="form-group mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required class="form-control form-control-lg" placeholder="Enter your full name">
        </div>
        <div class="form-group mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required class="form-control form-control-lg" placeholder="Enter your email">
        </div>
        <div class="form-group mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" required class="form-control form-control-lg" placeholder="Choose a password">
        </div>
        <div class="form-group mb-4">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required class="form-control form-control-lg" placeholder="Confirm your password">
        </div>
        <div>
            <button type="submit" class="btn btn-primary btn-lg btn-block mt-3">Register</button>
        </div>
    </form>

    <div class="text-center mt-4">
        <p class="text-muted">Already have an account? <a href="{{ route('login') }}">Login Here</a></p>
    </div>
@endsection
