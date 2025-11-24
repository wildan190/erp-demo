@extends('layouts.admin')

@section('title', 'Edit Delivery Order')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Delivery Order: {{ $deliveryOrder->delivery_number }}</h3>
        </div>
        <form action="{{ route('delivery-orders.update', $deliveryOrder) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="order_id">Sales Order</label>
                    <select name="order_id" id="order_id" class="form-control @error('order_id') is-invalid @enderror" required>
                        <option value="">Select Sales Order</option>
                        @foreach($orders as $order)
                            <option value="{{ $order->id }}" {{ old('order_id', $deliveryOrder->order_id) == $order->id ? 'selected' : '' }}>Order #{{ $order->id }} (Customer: {{ $order->customer->name ?? 'N/A' }})</option>
                        @endforeach
                    </select>
                    @error('order_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="customer_id">Customer</label>
                    <select name="customer_id" id="customer_id" class="form-control @error('customer_id') is-invalid @enderror" required>
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('customer_id', $deliveryOrder->customer_id) == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                        @endforeach
                    </select>
                    @error('customer_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="delivery_number">Delivery Number</label>
                    <input type="text" name="delivery_number" id="delivery_number" class="form-control @error('delivery_number') is-invalid @enderror" value="{{ old('delivery_number', $deliveryOrder->delivery_number) }}" required>
                    @error('delivery_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="delivery_date">Delivery Date</label>
                    <input type="date" name="delivery_date" id="delivery_date" class="form-control @error('delivery_date') is-invalid @enderror" value="{{ old('delivery_date', $deliveryOrder->delivery_date->format('Y-m-d')) }}" required>
                    @error('delivery_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                        <option value="pending" {{ old('status', $deliveryOrder->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_transit" {{ old('status', $deliveryOrder->status) == 'in_transit' ? 'selected' : '' }}>In Transit</option>
                        <option value="delivered" {{ old('status', $deliveryOrder->status) == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ old('status', $deliveryOrder->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="shipping_address">Shipping Address</label>
                    <textarea name="shipping_address" id="shipping_address" class="form-control @error('shipping_address') is-invalid @enderror" rows="3" required>{{ old('shipping_address', $deliveryOrder->shipping_address) }}</textarea>
                    @error('shipping_address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes', $deliveryOrder->notes) }}</textarea>
                    @error('notes')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('delivery-orders.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
