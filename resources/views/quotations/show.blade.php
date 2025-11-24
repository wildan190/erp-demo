@extends('layouts.admin')

@section('title', 'Quotation Details')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Quotation Details: {{ $quotation->quotation_number }}</h3>
            <div class="card-tools">
                <a href="{{ route('quotations.edit', $quotation) }}" class="btn btn-sm btn-primary">Edit</a>
                <form action="{{ route('quotations.destroy', $quotation) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this quotation?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Quotation Number</dt>
                <dd class="col-sm-9">{{ $quotation->quotation_number }}</dd>

                <dt class="col-sm-3">Customer</dt>
                <dd class="col-sm-9">{{ $quotation->customer->name ?? 'N/A' }}</dd>

                <dt class="col-sm-3">Quotation Date</dt>
                <dd class="col-sm-9">{{ $quotation->quotation_date->format('Y-m-d') }}</dd>

                <dt class="col-sm-3">Valid Until</dt>
                <dd class="col-sm-9">{{ $quotation->valid_until->format('Y-m-d') }}</dd>

                <dt class="col-sm-3">Status</dt>
                <dd class="col-sm-9">{{ ucfirst($quotation->status) }}</dd>

                <dt class="col-sm-3">Notes</dt>
                <dd class="col-sm-9">{{ $quotation->notes ?? 'N/A' }}</dd>

                <dt class="col-sm-3">Created By</dt>
                <dd class="col-sm-9">{{ $quotation->user->name ?? 'N/A' }}</dd>

                <dt class="col-sm-3">Created At</dt>
                <dd class="col-sm-9">{{ $quotation->created_at->format('Y-m-d H:i:s') }}</dd>

                <dt class="col-sm-3">Last Updated</dt>
                <dd class="col-sm-9">{{ $quotation->updated_at->format('Y-m-d H:i:s') }}</dd>
            </dl>

            <h4 class="mt-4">Quotation Items</h4>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quotation->items as $item)
                        <tr>
                            <td>{{ $item->product->name ?? 'N/A' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price, 2) }}</td>
                            <td>{{ number_format($item->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-right">Grand Total</th>
                        <th>{{ number_format($quotation->total_amount, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
