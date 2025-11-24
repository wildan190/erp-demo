@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Sales Report') }}</div>

                <div class="card-body">
                    <h5 class="mb-4">Summary</h5>
                    <p>Total Sales from Orders: <strong>{{ number_format($totalSalesOrders, 2) }}</strong></p>
                    <p>Total Sales from Invoices: <strong>{{ number_format($totalSalesInvoices, 2) }}</strong></p>

                    <h5 class="mt-5 mb-4">Orders Overview</h5>
                    @if($orders->isEmpty())
                        <p>No orders found.</p>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Order Date</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->customer->name ?? 'N/A' }}</td>
                                        <td>{{ $order->order_date }}</td>
                                        <td>{{ number_format($order->items->sum(function($item) { return $item->quantity * $item->unit_price; }), 2) }}</td>
                                        <td>{{ $order->status }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    <h5 class="mt-5 mb-4">Invoices Overview</h5>
                    @if($invoices->isEmpty())
                        <p>No invoices found.</p>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Invoice ID</th>
                                    <th>Customer</th>
                                    <th>Invoice Date</th>
                                    <th>Due Date</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoices as $invoice)
                                    <tr>
                                        <td>{{ $invoice->id }}</td>
                                        <td>{{ $invoice->customer->name ?? 'N/A' }}</td>
                                        <td>{{ $invoice->invoice_date }}</td>
                                        <td>{{ $invoice->due_date }}</td>
                                        <td>{{ number_format($invoice->total_amount, 2) }}</td>
                                        <td>{{ $invoice->status }}</td>
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
