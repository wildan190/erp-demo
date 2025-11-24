@extends('layouts.admin')

@section('title','Invoices')

@section('content')


    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-sm table-hover mb-0">
                <thead>
                    <tr><th>Invoice #</th><th>Order</th><th>Amount</th><th>Status</th><th class="text-right">Actions</th></tr>
                </thead>
                <tbody>
                    @forelse($invoices as $inv)
                        <tr>
                            <td>{{ $inv->invoice_number }}</td>
                            <td>{{ $inv->order->id ?? '-' }}</td>
                            <td>{{ number_format($inv->amount,2) }}</td>
                            <td>{{ ucfirst($inv->status) }}</td>
                            <td class="text-right">
                                <a href="{{ route('invoices.show', $inv) }}" class="btn btn-sm btn-outline-secondary">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">No invoices yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">{{ $invoices->links() }}</div>
    </div>

@endsection
