@extends('layouts.admin')

@section('title','Suppliers')

@section('content')
    <div class="d-flex justify-content-end align-items-center mb-3">
        <a href="{{ route('suppliers.create') }}" class="btn btn-primary btn-sm">Create Supplier</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr><th>Name</th><th>Email</th><th>Phone</th><th class="text-right">Actions</th></tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $s)
                        <tr>
                            <td>{{ $s->name }}</td>
                            <td>{{ $s->email }}</td>
                            <td>{{ $s->phone }}</td>
                            <td class="text-right">
                                <a href="{{ route('suppliers.show', $s) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                <a href="{{ route('suppliers.edit', $s) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('suppliers.destroy', $s) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this supplier?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center">No suppliers yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">{{ $suppliers->links() }}</div>
    </div>

@endsection
