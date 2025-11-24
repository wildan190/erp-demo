@extends('layouts.admin')

@section('title', 'Delivery Orders')

@section('content')
    <div class="d-flex justify-content-end align-items-center mb-3">
        <a href="{{ route('delivery-orders.create') }}" class="btn btn-primary btn-sm">Create Delivery Order</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Delivery Number</th>
                        <th>Order Number</th>
                        <th>Customer</th>
                        <th>Delivery Date</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($deliveryOrders as $deliveryOrder)
                        <tr>
                            <td>{{ $deliveryOrder->delivery_number }}</td>
                            <td>{{ $deliveryOrder->order->id ?? 'N/A' }}</td>
                            <td>{{ $deliveryOrder->customer->name ?? 'N/A' }}</td>
                            <td>{{ $deliveryOrder->delivery_date->format('Y-m-d') }}</td>
                            <td>{{ ucfirst($deliveryOrder->status) }}</td>
                            <td class="text-right">
                                <a href="{{ route('delivery-orders.show', $deliveryOrder) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                <a href="{{ route('delivery-orders.edit', $deliveryOrder) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('delivery-orders.destroy', $deliveryOrder) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this delivery order?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No delivery orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($deliveryOrders->hasPages())
            <div class="card-footer clearfix">
                {{ $deliveryOrders->links() }}
            </div>
        @endif
    </div>
@endsection
