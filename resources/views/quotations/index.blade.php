@extends('layouts.admin')

@section('title', 'Quotations')

@section('content')
    <div class="d-flex justify-content-end align-items-center mb-3">
        <a href="{{ route('quotations.create') }}" class="btn btn-primary btn-sm">Create Quotation</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Quotation Number</th>
                        <th>Customer</th>
                        <th>Quotation Date</th>
                        <th>Valid Until</th>
                        <th>Status</th>
                        <th>Total Amount</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($quotations as $quotation)
                        <tr>
                            <td>{{ $quotation->quotation_number }}</td>
                            <td>{{ $quotation->customer->name ?? 'N/A' }}</td>
                            <td>{{ $quotation->quotation_date->format('Y-m-d') }}</td>
                            <td>{{ $quotation->valid_until->format('Y-m-d') }}</td>
                            <td>{{ ucfirst($quotation->status) }}</td>
                            <td>{{ number_format($quotation->total_amount, 2) }}</td>
                            <td class="text-right">
                                <a href="{{ route('quotations.show', $quotation) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                <a href="{{ route('quotations.edit', $quotation) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('quotations.destroy', $quotation) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this quotation?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No quotations found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($quotations->hasPages())
            <div class="card-footer clearfix">
                {{ $quotations->links() }}
            </div>
        @endif
    </div>
@endsection
