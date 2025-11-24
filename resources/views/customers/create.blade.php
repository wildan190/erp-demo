@extends('layouts.admin')

@section('title','Create Customer')

@section('content')
    <div class="card">
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('customers.store') }}">
                @csrf
                @include('customers._form')
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-success">Create</button>
                    <a href="{{ route('customers.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
