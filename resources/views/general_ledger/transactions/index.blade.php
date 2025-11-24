@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">General Ledger Transactions</h3>
            <div class="card-tools">
                <a href="{{ route('finance.gl.transactions.create') }}" class="btn btn-primary btn-sm">Add New Transaction</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Reference</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->transaction_date->format('Y-m-d') }}</td>
                        <td>{{ $transaction->reference }}</td>
                        <td>{{ $transaction->description }}</td>
                        <td>
                            <a href="{{ route('finance.gl.transactions.show', $transaction->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('finance.gl.transactions.edit', $transaction->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('finance.gl.transactions.destroy', $transaction->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">No GL transactions found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection
