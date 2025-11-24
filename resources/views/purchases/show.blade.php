@extends('layouts.admin')

@section('title', 'Purchase Details')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Purchase #{{ $purchase->id }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Supplier:</strong> {{ $purchase->supplier->name ?? 'N/A' }}</p>
            <p><strong>Status:</strong> {{ $purchase->status }}</p>
            <p><strong>Total:</strong> {{ number_format($purchase->total_amount,2) }}</p>

            <h3>Items</h3>
            <table class="table table-bordered">
                <thead><tr><th>Product</th><th>Qty</th><th>Price</th><th>Total</th></tr></thead>
                <tbody>
                    @foreach($purchase->items as $it)
                        <tr>
                            <td>{{ $it->product->name ?? '-' }}</td>
                            <td>{{ $it->quantity }}</td>
                            <td>{{ number_format($it->price,2) }}</td>
                            <td>{{ number_format($it->total,2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <p class="mt-3"><a href="{{ route('purchases.index') }}" class="btn btn-secondary">Back</a></p>
        </div>
    </div>
@endsection
