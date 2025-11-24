@extends('layouts.admin')

@section('title','Create Supplier')

@section('content')
    <div class="card">
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('suppliers.store') }}">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}">
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input id="phone" class="form-control" type="text" name="phone" value="{{ old('phone') }}">
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" class="form-control" name="address">{{ old('address') }}</textarea>
                </div>
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-success">Create</button>
                    <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
