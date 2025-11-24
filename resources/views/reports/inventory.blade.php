@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Inventory Report') }}</div>

                <div class="card-body">
                    <h5 class="mb-4">Current Stock Levels</h5>
                    @if($products->isEmpty())
                        <p>No products found.</p>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>SKU</th>
                                    <th>Current Stock</th>
                                    <th>Unit Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->sku }}</td>
                                        <td>{{ $product->current_stock }}</td>
                                        <td>{{ number_format($product->price, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    <h5 class="mt-5 mb-4">Recent Inventory Movements</h5>
                    @if($inventoryMovements->isEmpty())
                        <p>No inventory movements found.</p>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Product</th>
                                    <th>Type</th>
                                    <th>Quantity Change</th>
                                    <th>Reference</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($inventoryMovements as $movement)
                                    <tr>
                                        <td>{{ $movement->movement_date }}</td>
                                        <td>{{ $movement->product->name ?? 'N/A' }}</td>
                                        <td>{{ $movement->movement_type }}</td>
                                        <td>{{ $movement->quantity_change }}</td>
                                        <td>{{ $movement->reference }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
