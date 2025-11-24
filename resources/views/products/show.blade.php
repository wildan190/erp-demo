@extends('layouts.admin')

@section('title', 'Product Details')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Product: {{ $product->name }}</h3>
        </div>
        <div class="card-body">
            <p><strong>SKU:</strong> {{ $product->sku }}</p>
            <p><strong>Price:</strong> {{ number_format($product->price,2) }}</p>
            <p><strong>Stock:</strong> {{ $product->stock }}</p>
            <p><strong>Description:</strong><br>{{ nl2br(e($product->description)) }}</p>

            <h3 class="mt-4">Inventory Movements</h3>
            @if($movements->isEmpty())
                <p>No movements</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr><th>When</th><th>Qty</th><th>Type</th><th>Note</th></tr>
                    </thead>
                    <tbody>
                        @foreach($movements as $m)
                            <tr>
                                <td>{{ $m->created_at }}</td>
                                <td>{{ $m->quantity }}</td>
                                <td>{{ $m->type }}</td>
                                <td>{{ $m->note }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <p class="mt-3">
                <a href="{{ route('products.edit', $product) }}" class="btn btn-primary">Edit</a>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
            </p>
        </div>
    </div>
@endsection
