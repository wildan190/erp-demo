@extends('layouts.admin')

@section('title','Edit Product')

@section('content')
    <div class="card">
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('products.update', $product) }}">
                @csrf
                @method('PUT')
                @include('products._form')
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
