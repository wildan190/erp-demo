@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Fixed Assets</h3>
            <div class="card-tools">
                <a href="{{ route('finance.fixed-assets.create') }}" class="btn btn-primary btn-sm">Add New Asset</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Asset Number</th>
                        <th>Asset Name</th>
                        <th>Acquisition Date</th>
                        <th>Cost</th>
                        <th>Useful Life (Years)</th>
                        <th>Current Value</th>
                        <th>Depreciation Method</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assets as $asset)
                    <tr>
                        <td>{{ $asset->asset_number }}</td>
                        <td>{{ $asset->asset_name }}</td>
                        <td>{{ $asset->acquisition_date->format('Y-m-d') }}</td>
                        <td>{{ number_format($asset->cost, 2) }}</td>
                        <td>{{ $asset->useful_life_years }}</td>
                        <td>{{ number_format($asset->current_value, 2) }}</td>
                        <td>{{ $asset->depreciation_method }}</td>
                        <td>
                            <a href="{{ route('finance.fixed-assets.show', $asset->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('finance.fixed-assets.edit', $asset->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('finance.fixed-assets.destroy', $asset->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No fixed assets found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $assets->links() }}
        </div>
    </div>
</div>
@endsection
