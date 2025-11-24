@extends('layouts.admin')

@section('title', 'Create Quotation')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Create New Quotation</h3>
        </div>
        <form action="{{ route('quotations.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="customer_id">Customer</label>
                    <select name="customer_id" id="customer_id" class="form-control @error('customer_id') is-invalid @enderror" required>
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                        @endforeach
                    </select>
                    @error('customer_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="quotation_number">Quotation Number</label>
                    <input type="text" name="quotation_number" id="quotation_number" class="form-control @error('quotation_number') is-invalid @enderror" value="{{ old('quotation_number') }}" required>
                    @error('quotation_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="quotation_date">Quotation Date</label>
                    <input type="date" name="quotation_date" id="quotation_date" class="form-control @error('quotation_date') is-invalid @enderror" value="{{ old('quotation_date', date('Y-m-d')) }}" required>
                    @error('quotation_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="valid_until">Valid Until</label>
                    <input type="date" name="valid_until" id="valid_until" class="form-control @error('valid_until') is-invalid @enderror" value="{{ old('valid_until') }}" required>
                    @error('valid_until')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="sent" {{ old('status') == 'sent' ? 'selected' : '' }}>Sent</option>
                        <option value="accepted" {{ old('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                        <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    @error('status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Quotation Items</label>
                    <table class="table table-bordered" id="quotation-items-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th width="150px">Quantity</th>
                                <th width="150px">Price</th>
                                <th width="150px">Total</th>
                                <th width="50px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Item rows will be added here -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-right">Grand Total</th>
                                <th id="grand-total">0.00</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                    <button type="button" class="btn btn-success btn-sm" id="add-item-btn">Add Item</button>
                </div>

                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes') }}</textarea>
                    @error('notes')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                {{-- Hidden input for total_amount --}}
                <input type="hidden" name="total_amount" id="hidden_total_amount" value="0">
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('quotations.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let itemIndex = 0;
        const quotationItemsTable = document.getElementById('quotation-items-table').getElementsByTagName('tbody')[0];
        const addItemBtn = document.getElementById('add-item-btn');
        const grandTotalElement = document.getElementById('grand-total');
        const hiddenTotalAmount = document.getElementById('hidden_total_amount');
        const products = @json($products);

        function calculateRowTotal(row) {
            const quantity = parseFloat(row.querySelector('[name$="[quantity]"]').value) || 0;
            const price = parseFloat(row.querySelector('[name$="[price]"]').value) || 0;
            const total = quantity * price;
            row.querySelector('.item-total').textContent = total.toFixed(2);
            return total;
        }

        function calculateGrandTotal() {
            let grandTotal = 0;
            const itemTotalElements = document.querySelectorAll('.item-total');
            itemTotalElements.forEach(function(element) {
                grandTotal += parseFloat(element.textContent);
            });
            grandTotalElement.textContent = grandTotal.toFixed(2);
            hiddenTotalAmount.value = grandTotal.toFixed(2);
        }

        function addItem() {
            const row = quotationItemsTable.insertRow();
            row.innerHTML = `
                <td>
                    <select name="items[${itemIndex}][product_id]" class="form-control product-select" required>
                        <option value="">Select Product</option>
                        ${products.map(product => `<option value="${product.id}" data-price="${product.price}">${product.name}</option>`).join('')}
                    </select>
                </td>
                <td>
                    <input type="number" name="items[${itemIndex}][quantity]" class="form-control item-quantity" value="1" min="1" required>
                </td>
                <td>
                    <input type="number" name="items[${itemIndex}][price]" class="form-control item-price" value="0.00" step="0.01" min="0" required>
                </td>
                <td>
                    <span class="item-total">0.00</span>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-item-btn">Remove</button>
                </td>
            `;

            const newRow = quotationItemsTable.lastElementChild;
            const productSelect = newRow.querySelector('.product-select');
            const quantityInput = newRow.querySelector('.item-quantity');
            const priceInput = newRow.querySelector('.item-price');
            const removeBtn = newRow.querySelector('.remove-item-btn');

            productSelect.addEventListener('change', function() {
                const selectedOption = productSelect.options[productSelect.selectedIndex];
                const price = selectedOption.dataset.price || 0;
                priceInput.value = parseFloat(price).toFixed(2);
                calculateGrandTotalOnChange(newRow);
            });

            quantityInput.addEventListener('input', () => calculateGrandTotalOnChange(newRow));
            priceInput.addEventListener('input', () => calculateGrandTotalOnChange(newRow));
            removeBtn.addEventListener('click', function() {
                row.remove();
                calculateGrandTotal();
            });

            itemIndex++;
            calculateGrandTotal(); // Update total when a new item is added
        }

        function calculateGrandTotalOnChange(row) {
            calculateRowTotal(row);
            calculateGrandTotal();
        }

        addItemBtn.addEventListener('click', addItem);

        // Add one item row by default
        addItem();
    });
</script>
@endpush
