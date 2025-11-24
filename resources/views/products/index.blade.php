@extends('layouts.admin')

@section('title','Products')

@section('content')
    <div class="d-flex justify-content-end align-items-center mb-3">
        <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">Create Product</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $p)
                        <tr>
                            <td>{{ $p->sku }}</td>
                            <td>{{ $p->name }}</td>
                            <td>{{ number_format($p->price,2) }}</td>
                            <td>{{ $p->stock }}</td>
                            <td class="text-right">
                                <a href="{{ route('products.show', $p) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                <a href="{{ route('products.edit', $p) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('products.destroy', $p) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">No products found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $products->links() }}
        </div>
    </div>

@endsection
