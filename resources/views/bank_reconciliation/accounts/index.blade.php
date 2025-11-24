@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Bank Accounts</h3>
            <div class="card-tools">
                <a href="{{ route('finance.bank-accounts.create') }}" class="btn btn-primary btn-sm">Add New Bank Account</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Bank Name</th>
                        <th>Account Name</th>
                        <th>Account Number</th>
                        <th>Currency</th>
                        <th>Current Balance</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($accounts as $account)
                    <tr>
                        <td>{{ $account->bank_name }}</td>
                        <td>{{ $account->account_name }}</td>
                        <td>{{ $account->account_number }}</td>
                        <td>{{ $account->currency }}</td>
                        <td>{{ number_format($account->current_balance, 2) }}</td>
                        <td>
                            <a href="{{ route('finance.bank-accounts.show', $account->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('finance.bank-accounts.edit', $account->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('finance.bank-accounts.destroy', $account->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No bank accounts found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $accounts->links() }}
        </div>
    </div>
</div>
@endsection
