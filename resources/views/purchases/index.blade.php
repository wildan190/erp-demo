@extends('layouts.admin')

@section('title','Purchases')

@section('content')
    <div class="d-flex justify-content-end align-items-center mb-3">
        <a href="{{ route('purchases.create') }}" class="btn btn-primary btn-sm">Create Purchase</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover mb-0">
                <thead><tr><th>ID</th><th>Supplier</th><th>Total</th><th>Status</th><th class="text-right">Actions</th></tr></thead>
                <tbody>
                    @forelse($purchases as $p)
                        <tr>
                            <td>{{ $p->id }}</td>
                            <td>{{ $p->supplier->name ?? '-' }}</td>
                            <td>{{ number_format($p->total_amount,2) }}</td>
                            <td>{{ ucfirst($p->status) }}</td>
                            <td class="text-right">
                                <a href="{{ route('purchases.show', $p) }}" class="btn btn-sm btn-outline-secondary">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">No purchases yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">{{ $purchases->links() }}</div>
    </div>

@endsection
