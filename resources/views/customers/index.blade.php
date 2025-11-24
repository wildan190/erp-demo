@extends('layouts.admin')

@section('title', 'Customers')

@section('content')
    <div class="d-flex justify-content-end align-items-center mb-3">
        <a href="{{ route('customers.create') }}" class="btn btn-primary btn-sm">Create Customer</a>
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
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $c)
                        <tr>
                            <td>{{ $c->name }}</td>
                            <td>{{ $c->email }}</td>
                            <td>{{ $c->phone }}</td>
                            <td class="text-right">
                                <a href="{{ route('customers.show', $c) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                <a href="{{ route('customers.edit', $c) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('customers.destroy', $c) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this customer?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No customers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($customers->hasPages())
            <div class="card-footer clearfix">
                {{ $customers->links() }}
            </div>
        @endif
    </div>
@endsection
