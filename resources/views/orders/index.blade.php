@extends('layouts.admin')

@section('title','Orders')

@section('content')
    <div class="d-flex justify-content-end align-items-center mb-3">
        <a href="{{ route('orders.create') }}" class="btn btn-primary btn-sm">Create Order</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr><th>ID</th><th>Customer</th><th>Total</th><th>Status</th><th class="text-right">Actions</th></tr>
                </thead>
                <tbody>
                    @forelse($orders as $o)
                        <tr>
                            <td>{{ $o->id }}</td>
                            <td>{{ $o->customer->name ?? '-' }}</td>
                            <td>{{ number_format($o->total_amount,2) }}</td>
                            <td>{{ ucfirst($o->status) }}</td>
                            <td class="text-right">
                                <a href="{{ route('orders.show', $o) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                <a href="{{ route('orders.edit', $o) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">No orders found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $orders->links() }}
        </div>
    </div>

@endsection
