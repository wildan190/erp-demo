@extends('layouts.admin')

@section('title','Create Order')

@section('content')
    <div class="card">
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('orders.store') }}">
                @csrf

                <div class="form-group">
                    <label for="customer_id">Customer</label>
                    <select id="customer_id" class="form-control" name="customer_id">
                        <option value="">-- Guest --</option>
                        @foreach($customers as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Items</h3>
                    </div>
                    <div class="card-body">
                        <table id="items-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 60%">Product</th>
                                    <th style="width: 20%">Quantity</th>
                                    <th style="width: 20%">Action</th>
                                </tr>
                            </thead>
                            <tbody id="items-tbody">
                            </tbody>
                        </table>
                        <button type="button" id="add-item" class="btn btn-primary mt-3">Add Item</button>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-success">Create Order</button>
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const itemsTbody = document.getElementById('items-tbody');
        const addItemButton = document.getElementById('add-item');
        let itemIndex = 0;

        const createItemRow = () => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>
                    <select name="items[${itemIndex}][product_id]" class="form-control">
                        <option value="">-- select --</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->price }})</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input class="form-control" type="number" name="items[${itemIndex}][quantity]" value="1" min="1">
                </td>
                <td>
                    <button type="button" class="btn btn-danger remove-item">Remove</button>
                </td>
            `;
            itemsTbody.appendChild(row);
            itemIndex++;
        };

        addItemButton.addEventListener('click', createItemRow);

        itemsTbody.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-item')) {
                e.target.closest('tr').remove();
            }
        });

        // Add one item row by default
        createItemRow();
    });
</script>
@endpush
