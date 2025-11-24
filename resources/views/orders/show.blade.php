@extends('layouts.admin')

@section('title', 'Order Details')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Order #{{ $order->id }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Customer:</strong> {{ $order->customer->name ?? 'Guest' }}</p>
            <p><strong>Status:</strong> {{ $order->status }}</p>
            <p><strong>Total:</strong> {{ number_format($order->total_amount,2) }}</p>

            <h3>Items</h3>
            <table class="table table-bordered">
                <thead><tr><th>Product</th><th>Qty</th><th>Price</th><th>Total</th></tr></thead>
                <tbody>
                    @foreach($order->items as $it)
                        <tr>
                            <td>{{ $it->product->name ?? '-' }}</td>
                            <td>{{ $it->quantity }}</td>
                            <td>{{ number_format($it->price,2) }}</td>
                            <td>{{ number_format($it->total,2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <p class="mt-3">
                @if(!$order->invoice)
                    <form method="POST" action="{{ route('orders.invoice', $order) }}" style="display:inline">
                        @csrf
                        <button type="submit" class="btn btn-primary">Generate Invoice</button>
                    </form>
                @else
                    <a href="{{ route('invoices.show', $order->invoice) }}" class="btn btn-info">View Invoice</a>
                @endif
            </p>

            <p class="mt-3"><a href="{{ route('orders.index') }}" class="btn btn-secondary">Back</a></p>
        </div>
    </div>
@endsection
