@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Accounts Payable Bills</h3>
            <div class="card-tools">
                <a href="{{ route('finance.ap.bills.create') }}" class="btn btn-primary btn-sm">Create New Bill</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Bill Number</th>
                        <th>Supplier</th>
                        <th>Bill Date</th>
                        <th>Due Date</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bills as $bill)
                    <tr>
                        <td>{{ $bill->bill_number }}</td>
                        <td>{{ $bill->supplier->name ?? 'N/A' }}</td>
                        <td>{{ $bill->bill_date->format('Y-m-d') }}</td>
                        <td>{{ $bill->due_date->format('Y-m-d') }}</td>
                        <td>{{ number_format($bill->total_amount, 2) }}</td>
                        <td>{{ ucfirst($bill->status) }}</td>
                        <td>
                            <a href="{{ route('finance.ap.bills.show', $bill->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('finance.ap.bills.edit', $bill->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('finance.ap.bills.destroy', $bill->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No AP bills found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $bills->links() }}
        </div>
    </div>
</div>
@endsection
