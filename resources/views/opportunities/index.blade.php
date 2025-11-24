@extends('layouts.admin')

@section('title', 'Opportunities')

@section('content')
    <div class="d-flex justify-content-end align-items-center mb-3">
        <a href="{{ route('opportunities.create') }}" class="btn btn-primary btn-sm">Create Opportunity</a>
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
                        <th>Lead</th>
                        <th>Stage</th>
                        <th>Amount</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($opportunities as $opportunity)
                        <tr>
                            <td>{{ $opportunity->name }}</td>
                            <td>{{ $opportunity->lead->name ?? 'N/A' }}</td>
                            <td>{{ $opportunity->stage }}</td>
                            <td>{{ $opportunity->amount }}</td>
                            <td class="text-right">
                                <a href="{{ route('opportunities.show', $opportunity) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                <a href="{{ route('opportunities.edit', $opportunity) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('opportunities.destroy', $opportunity) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this opportunity?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No opportunities found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($opportunities->hasPages())
            <div class="card-footer clearfix">
                {{ $opportunities->links() }}
            </div>
        @endif
    </div>
@endsection
