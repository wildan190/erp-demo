@extends('layouts.admin')

@section('title','Invoice')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Invoice {{ $invoice->invoice_number }}</h3>
            <div>
                @if($invoice->status !== 'paid')
                    <form method="POST" action="{{ route('invoices.pay', $invoice) }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success">Mark as Paid</button>
                    </form>
                @endif
                <a href="{{ route('invoices.print', $invoice) }}" target="_blank" class="btn btn-sm btn-primary">Print</a>
                <a href="{{ route('invoices.index') }}" class="btn btn-sm btn-secondary">Back</a>
            </div>
        </div>
        <div class="card-body">
            <p><strong>Order:</strong> #{{ $invoice->order->id ?? '-' }}</p>
            <p><strong>Amount:</strong> {{ number_format($invoice->amount,2) }}</p>
            <p><strong>Status:</strong> {{ ucfirst($invoice->status) }}</p>
            <p><strong>Issued:</strong> {{ $invoice->issued_at }}</p>
            <p><strong>Paid:</strong> {{ $invoice->paid_at ?? '-' }}</p>
        </div>
    </div>
@endsection
