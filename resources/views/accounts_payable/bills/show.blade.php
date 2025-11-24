@extends('layouts.admin')

@section('title', 'AP Bill Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">AP Bill #{{ $bill->bill_number }}</h3>
                    <div>
                        <a href="{{ route('finance.ap.bills.index') }}" class="btn btn-sm btn-secondary">Back to Bills</a>
                        <a href="{{ route('finance.ap.bills.edit', $bill) }}" class="btn btn-sm btn-primary">Edit</a>
                    </div>
                </div>
                <div class="card-body">
                    <h5>Payments</h5>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Total:</strong>
                            <div>{{ number_format($bill->total_amount, 2) }}</div>
                        </div>
                        <div class="col-md-4">
                            <strong>Paid:</strong>
                            <div>{{ number_format($bill->payments->sum('amount'), 2) }}</div>
                        </div>
                        <div class="col-md-4">
                            <strong>Remaining:</strong>
                            <div>{{ number_format($bill->total_amount - $bill->payments->sum('amount'), 2) }}</div>
                        </div>
                    </div>
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Payment #</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Bank Account</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bill->payments as $payment)
                                    <tr>
                                        <td>{{ $payment->payment_number }}</td>
                                        <td class="text-right">{{ number_format($payment->amount, 2) }}</td>
                                        <td>{{ optional($payment->payment_date)->format('Y-m-d') }}</td>
                                        <td>
                                            @if($payment->bankAccount)
                                                {{ $payment->bankAccount->bank_name }} - {{ $payment->bankAccount->account_name }} ({{ $payment->bankAccount->account_number }})
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $payment->notes }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">No payments recorded.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($bill->status !== 'paid')
                        <h5>Record a Payment</h5>
                        <form action="{{ route('finance.ap.bills.pay', $bill) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Amount</label>
                                        <input type="number" step="0.01" name="amount" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Payment Date</label>
                                        <input type="date" name="payment_date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Bank Account (optional)</label>
                                        <select name="bank_account_id" class="form-control">
                                            <option value="">-- Select --</option>
                                            @foreach($bankAccounts as $ba)
                                                <option value="{{ $ba->id }}">{{ $ba->bank_name }} - {{ $ba->account_name }} ({{ $ba->account_number }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Selected Account Balance</label>
                                        <div id="selected-account-balance">&mdash;</div>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <div class="form-group">
                                        <label>Notes</label>
                                        <textarea name="notes" class="form-control" rows="2"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-success">Record Payment</button>
                            </div>
                        </form>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Supplier:</strong>
                            <div>{{ $bill->supplier->name ?? '-' }}</div>
                        </div>
                        <div class="col-md-4">
                            <strong>Bill Date:</strong>
                            <div>{{ optional($bill->bill_date)->format('Y-m-d') }}</div>
                        </div>
                        <div class="col-md-4">
                            <strong>Due Date:</strong>
                            <div>{{ optional($bill->due_date)->format('Y-m-d') }}</div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <strong>Notes:</strong>
                            <div>{{ $bill->notes }}</div>
                        </div>
                    </div>

                    <h5>Items</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Description</th>
                                    <th class="text-right">Quantity</th>
                                    <th class="text-right">Unit Price</th>
                                    <th class="text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bill->items as $item)
                                    <tr>
                                        <td>{{ $item->product->name ?? '-' }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td class="text-right">{{ $item->quantity }}</td>
                                        <td class="text-right">{{ number_format($item->unit_price, 2) }}</td>
                                        <td class="text-right">{{ number_format($item->total, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">No items found for this bill.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-right">Total Amount</th>
                                    <th class="text-right">{{ number_format($bill->total_amount, 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const select = document.querySelector('select[name="bank_account_id"]');
    const balanceDiv = document.getElementById('selected-account-balance');
    const accounts = {
        @foreach($bankAccounts as $ba)
            '{{ $ba->id }}': {{ $ba->current_balance ?? 0 }},
        @endforeach
    };

    function updateBalance() {
        const id = select.value;
        if (!id) {
            balanceDiv.textContent = '—';
            return;
        }
        const bal = accounts[id] !== undefined ? accounts[id] : 0;
        balanceDiv.textContent = bal.toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2});
    }

    if (select) {
        select.addEventListener('change', updateBalance);
        updateBalance();
    }
});
</script>
@endpush
