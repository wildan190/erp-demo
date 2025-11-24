@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Bank Transactions</h3>
            <div class="card-tools">
                {{-- <a href="{{ route('finance.bank-transactions.create') }}" class="btn btn-primary btn-sm">Add New Transaction</a> --}}
                {{-- Bank transactions are typically imported, not manually created --}}
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Bank Account</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Type</th>
                        <th>Reconciled</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->bankAccount->account_name ?? 'N/A' }}</td>
                        <td>{{ $transaction->transaction_date->format('Y-m-d') }}</td>
                        <td>{{ $transaction->description }}</td>
                        <td>{{ number_format($transaction->amount, 2) }}</td>
                        <td>{{ ucfirst($transaction->type) }}</td>
                        <td>{{ $transaction->is_reconciled ? 'Yes' : 'No' }}</td>
                        <td>
                            <a href="{{ route('finance.bank-transactions.show', $transaction->id) }}" class="btn btn-info btn-sm">View</a>
                            {{-- <a href="{{ route('finance.bank-transactions.edit', $transaction->id) }}" class="btn btn-warning btn-sm">Edit</a> --}}
                            {{-- <form action="{{ route('finance.bank-transactions.destroy', $transaction->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form> --}}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No bank transactions found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection
