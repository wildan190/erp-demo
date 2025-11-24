@extends('layouts.admin')

@section('title', 'Leads')

@section('content')
    <div class="d-flex justify-content-end align-items-center mb-3">
        <a href="{{ route('leads.create') }}" class="btn btn-primary btn-sm">Create Lead</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Company</th>
                        <th>Status</th>
                        <th>Assigned To</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leads as $lead)
                        <tr>
                            <td>{{ $lead->name }}</td>
                            <td>{{ $lead->email ?? 'N/A' }}</td>
                            <td>{{ $lead->phone ?? 'N/A' }}</td>
                            <td>{{ $lead->company ?? 'N/A' }}</td>
                            <td>{{ ucfirst($lead->status) }}</td>
                            <td>{{ $lead->user->name ?? 'N/A' }}</td>
                            <td class="text-right">
                                <a href="{{ route('leads.show', $lead) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                <a href="{{ route('leads.edit', $lead) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('leads.destroy', $lead) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this lead?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No leads found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($leads->hasPages())
            <div class="card-footer clearfix">
                {{ $leads->links() }}
            </div>
        @endif
    </div>
@endsection
