@extends('layouts.admin')

@section('title', 'Follow Ups')

@section('content')
    <div class="d-flex justify-content-end align-items-center mb-3">
        <a href="{{ route('follow-ups.create') }}" class="btn btn-primary btn-sm">Create Follow Up</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Lead/Opportunity</th>
                        <th>Type</th>
                        <th>Schedule At</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($followUps as $followUp)
                        <tr>
                            <td>
                                @if ($followUp->lead)
                                    Lead: {{ $followUp->lead->name }}
                                @elseif ($followUp->opportunity)
                                    Opportunity: {{ $followUp->opportunity->name }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $followUp->type }}</td>
                            <td>{{ $followUp->schedule_at ? $followUp->schedule_at->format('Y-m-d H:i') : 'N/A' }}</td>
                            <td>{{ $followUp->status }}</td>
                            <td class="text-right">
                                <a href="{{ route('follow-ups.show', $followUp) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                <a href="{{ route('follow-ups.edit', $followUp) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('follow-ups.destroy', $followUp) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this follow up?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No follow ups found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($followUps->hasPages())
            <div class="card-footer clearfix">
                {{ $followUps->links() }}
            </div>
        @endif
    </div>
@endsection
