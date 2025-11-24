@extends('layouts.admin')

@section('title', 'Customer Details')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Customer: {{ $customer->name }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Email:</strong> {{ $customer->email }}</p>
            <p><strong>Phone:</strong> {{ $customer->phone }}</p>
            <p><strong>Address:</strong><br>{{ nl2br(e($customer->address)) }}</p>

            <p class="mt-3">
                <a href="{{ route('customers.edit', $customer) }}" class="btn btn-primary">Edit</a>
                <a href="{{ route('customers.index') }}" class="btn btn-secondary">Back</a>
            </p>
        </div>
    </div>
@endsection
