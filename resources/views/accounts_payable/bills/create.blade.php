@extends('layouts.admin')

@section('title', 'Create AP Bill')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Create New AP Bill</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('finance.ap.bills.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="supplier_id">Supplier</label>
                            <select class="form-control" id="supplier_id" name="supplier_id" required>
                                <option value="">Select Supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="bill_number">Bill Number</label>
                            <input type="text" class="form-control" id="bill_number" name="bill_number" value="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="bill_date">Bill Date</label>
                            <input type="date" class="form-control" id="bill_date" name="bill_date" required>
                        </div>
                        <div class="form-group">
                            <label for="due_date">Due Date</label>
                            <input type="date" class="form-control" id="due_date" name="due_date" required>
                        </div>
                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Enter any notes"></textarea>
                        </div>

                        <!-- Bill Items Section -->
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Bill Items</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered" id="items_table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Description</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Item rows will be added here -->
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-info mt-3" id="add_item">Add Item</button>
                            </div>
                        </div>
                        <!-- End Bill Items Section -->

                        <div class="form-group">
                            <label for="total_amount">Total Amount</label>
                            <input type="number" step="0.01" class="form-control" id="total_amount" name="total_amount" placeholder="Calculated automatically" readonly required>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        let itemRowCounter = 0; // Initialize counter inside ready function

        // Debugging: Check if products are passed
        console.log('Products:', @json($products));

        function calculateRowTotal(row) {
            const quantity = parseFloat(row.find('.item-quantity').val()) || 0;
            const unitPrice = parseFloat(row.find('.item-unit-price').val()) || 0;
            const total = quantity * unitPrice;
            row.find('.item-total').val(total.toFixed(2));
            return total;
        }

        function updateTotalAmount() {
            let grandTotal = 0;
            $('#items_table tbody tr').each(function() {
                grandTotal += calculateRowTotal($(this));
            });
            $('#total_amount').val(grandTotal.toFixed(2));
        }

        function addItemRow() {
            itemRowCounter++;
            const newRow = `
                <tr>
                    <td>
                        <select class="form-control item-product" name="items[${itemRowCounter}][product_id]">
                            <option value="">Select Product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control item-description" name="items[${itemRowCounter}][description]" placeholder="Description">
                    </td>
                    <td>
                        <input type="number" step="1" class="form-control item-quantity" name="items[${itemRowCounter}][quantity]" value="1" min="1" required>
                    </td>
                    <td>
                        <input type="number" step="0.01" class="form-control item-unit-price" name="items[${itemRowCounter}][unit_price]" value="0.00" min="0" required>
                    </td>
                    <td>
                        <input type="number" step="0.01" class="form-control item-total" name="items[${itemRowCounter}][total]" value="0.00" readonly>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-item">Remove</button>
                    </td>
                </tr>
            `;
            $('#items_table tbody').append(newRow);
            updateTotalAmount();
        }

        $('#add_item').click(function() {
            addItemRow();
        });

        $(document).on('change', '.item-product', function() {
            const selectedOption = $(this).find('option:selected');
            const unitPrice = selectedOption.data('price') || 0;
            const row = $(this).closest('tr');
            row.find('.item-unit-price').val(unitPrice.toFixed(2));
            calculateRowTotal(row);
            updateTotalAmount();
        });

        $(document).on('input', '.item-quantity, .item-unit-price', function() {
            const row = $(this).closest('tr');
            calculateRowTotal(row);
            updateTotalAmount();
        });

        $(document).on('click', '.remove-item', function() {
            $(this).closest('tr').remove();
            updateTotalAmount();
        });

        // Add one item row by default
        addItemRow();
    });
</script>
@endpush
