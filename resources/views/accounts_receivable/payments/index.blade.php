@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Accounts Receivable Payments Received</h3>
            <div class="card-tools">
                <a href="{{ route('finance.ar.payments.create') }}" class="btn btn-primary btn-sm">Record New Payment</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Payment Number</th>
                        <th>Customer</th>
                        <th>Invoice</th>
                        <th>Amount</th>
                        <th>Payment Date</th>
                        <th>Method</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                    <tr>
                        <td>{{ $payment->payment_number }}</td>
                        <td>{{ $payment->customer->name ?? 'N/A' }}</td>
                        <td>{{ $payment->invoice->invoice_number ?? 'N/A' }}</td>
                        <td>{{ number_format($payment->amount, 2) }}</td>
                        <td>{{ $payment->payment_date->format('Y-m-d') }}</td>
                        <td>{{ $payment->payment_method }}</td>
                        <td>
                            <a href="{{ route('finance.ar.payments.show', $payment->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('finance.ar.payments.edit', $payment->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('finance.ar.payments.destroy', $payment->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No payments received found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $payments->links() }}
        </div>
    </div>
</div>
@endsection
