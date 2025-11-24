@extends('layouts.admin')

@section('title', 'Delivery Order Details')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Delivery Order Details: {{ $deliveryOrder->delivery_number }}</h3>
            <div class="card-tools">
                <a href="{{ route('delivery-orders.edit', $deliveryOrder) }}" class="btn btn-sm btn-primary">Edit</a>
                <form action="{{ route('delivery-orders.destroy', $deliveryOrder) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this delivery order?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Delivery Number</dt>
                <dd class="col-sm-9">{{ $deliveryOrder->delivery_number }}</dd>

                <dt class="col-sm-3">Sales Order ID</dt>
                <dd class="col-sm-9">{{ $deliveryOrder->order->id ?? 'N/A' }}</dd>

                <dt class="col-sm-3">Customer</dt>
                <dd class="col-sm-9">{{ $deliveryOrder->customer->name ?? 'N/A' }}</dd>

                <dt class="col-sm-3">Delivery Date</dt>
                <dd class="col-sm-9">{{ $deliveryOrder->delivery_date->format('Y-m-d') }}</dd>

                <dt class="col-sm-3">Status</dt>
                <dd class="col-sm-9">{{ ucfirst($deliveryOrder->status) }}</dd>

                <dt class="col-sm-3">Shipping Address</dt>
                <dd class="col-sm-9">{{ $deliveryOrder->shipping_address }}</dd>

                <dt class="col-sm-3">Notes</dt>
                <dd class="col-sm-9">{{ $deliveryOrder->notes ?? 'N/A' }}</dd>

                <dt class="col-sm-3">Created At</dt>
                <dd class="col-sm-9">{{ $deliveryOrder->created_at->format('Y-m-d H:i:s') }}</dd>

                <dt class="col-sm-3">Last Updated</dt>
                <dd class="col-sm-9">{{ $deliveryOrder->updated_at->format('Y-m-d H:i:s') }}</dd>
            </dl>
        </div>
    </div>
@endsection
