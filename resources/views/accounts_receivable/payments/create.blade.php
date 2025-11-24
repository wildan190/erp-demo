@extends('layouts.admin')

@section('title', 'Record AR Payment')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Record New AR Payment</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('finance.ar.payments.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="invoice_id">Invoice</label>
                            <select class="form-control" id="invoice_id" name="invoice_id">
                                <option value="">Select Invoice (Optional)</option>
                                @if($invoices->isEmpty())
                                    <option disabled>No invoices with outstanding balance</option>
                                @else
                                    @foreach($invoices as $invoice)
                                        <option value="{{ $invoice->id }}"
                                            data-invoice-number="{{ $invoice->invoice_number }}"
                                            data-invoice-amount="{{ $invoice->amount }}"
                                            data-invoice-remaining="{{ $invoice->remaining_amount }}"
                                            data-customer-id="{{ $invoice->customer_id }}"
                                            data-invoice-items='@json($invoice->order->items ?? [])'
                                        >INV-{{ $invoice->invoice_number }} (Remaining: {{ number_format($invoice->remaining_amount, 2) }})</option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="mt-2">
                                <button type="button" id="preview-invoice-btn" class="btn btn-sm btn-outline-secondary" disabled>Preview Invoice</button>
                            </div>
                            {{-- TODO: Replace with a select dropdown of existing Invoices --}}
                        </div>
                        <div class="form-group">
                            <label for="customer_id">Customer</label>
                            <select class="form-control" id="customer_id" name="customer_id" required>
                                <option value="">Select Customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                            <div id="customer-display" class="form-control-plaintext d-none" style="padding-top: .375rem;"></div>
                        </div>
                        <div class="form-group">
                            <label>Payment Number</label>
                            <div class="form-control-plaintext">(will be generated)</div>
                            <input type="hidden" id="payment_number" name="payment_number" value="">
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" step="0.01" class="form-control" id="amount" name="amount" placeholder="Enter amount" required>
                            <small class="form-text text-muted">Remaining amount: <span id="invoice-remaining-display">-</span></small>
                        </div>
                        <div class="form-group">
                            <label for="payment_date">Payment Date</label>
                            <input type="date" class="form-control" id="payment_date" name="payment_date" required>
                        </div>
                        <div class="form-group">
                            <label for="payment_method">Payment Method</label>
                            <select class="form-control" id="payment_method" name="payment_method" required>
                                <option value="">Select Payment Method</option>
                                <option value="Cash">Cash</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                                <option value="Card">Card</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Enter any notes"></textarea>
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
document.addEventListener('DOMContentLoaded', function () {
    const invoiceSelect = document.getElementById('invoice_id');
    const customerSelect = document.getElementById('customer_id');
    const amountInput = document.getElementById('amount');
    const paymentNumberInput = document.getElementById('payment_number');
    const paymentDateInput = document.getElementById('payment_date');
    const paymentMethodSelect = document.getElementById('payment_method');

    // Auto-generate a default payment number if empty
    function generatePaymentNumber() {
        const ts = Date.now().toString().slice(-6);
        return 'ARP-' + ts;
    }

    // Set defaults on load
    if (!paymentNumberInput.value) paymentNumberInput.value = generatePaymentNumber();
    if (!paymentDateInput.value) paymentDateInput.value = new Date().toISOString().slice(0,10);
    if (!paymentMethodSelect.value) paymentMethodSelect.value = 'Bank Transfer';

    function onInvoiceChange() {
        const opt = invoiceSelect.options[invoiceSelect.selectedIndex];
        if (!opt || !opt.value) {
            // Clear automated fields and restore customer select to editable
            amountInput.value = '';
            document.getElementById('invoice-remaining-display').textContent = '-';
            amountInput.removeAttribute('max');
            if (customerSelect) {
                customerSelect.disabled = false;
            }
            // remove hidden customer input if exists
            const hiddenRemove = document.querySelector('input[name="customer_id"]');
            if (hiddenRemove) hiddenRemove.remove();
            const previewBtnLocal = document.getElementById('preview-invoice-btn');
            if (previewBtnLocal) previewBtnLocal.disabled = true;
            return;
        }
        const invoiceNumber = opt.getAttribute('data-invoice-number');
        const invoiceAmount = opt.getAttribute('data-invoice-amount');
        const invoiceRemaining = opt.getAttribute('data-invoice-remaining');
        const customerId = opt.getAttribute('data-customer-id');

        // Set amount to remaining amount (if >0) otherwise full invoice
        if (invoiceRemaining && parseFloat(invoiceRemaining) > 0) {
            amountInput.value = parseFloat(invoiceRemaining).toFixed(2);
        } else if (invoiceAmount) {
            amountInput.value = parseFloat(invoiceAmount).toFixed(2);
        }

        // Set customer select and make it read-only when coming from an invoice
        if (customerId && customerSelect) {
            customerSelect.value = customerId;
            // disable the select so user cannot change it when invoice is chosen
            customerSelect.disabled = true;
            // ensure a hidden input exists so the customer_id is submitted
            let hidden = document.querySelector('input[name="customer_id"]');
            if (!hidden) {
                hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'customer_id';
                document.querySelector('form').appendChild(hidden);
            }
            hidden.value = customerId;
        }
        const previewBtnLocal = document.getElementById('preview-invoice-btn');
        if (previewBtnLocal) previewBtnLocal.disabled = false;

        // Update remaining display and clamp amount
        const rem = invoiceRemaining ? parseFloat(invoiceRemaining) : 0;
        document.getElementById('invoice-remaining-display').textContent = rem.toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2});
        amountInput.setAttribute('max', rem);
        // Ensure amount does not exceed remaining
        if (amountInput.value && parseFloat(amountInput.value) > rem) {
            amountInput.value = rem.toFixed(2);
        }
        // payment_number is server-generated; we keep hidden input empty (server will set)
    }

    if (invoiceSelect) {
        invoiceSelect.addEventListener('change', onInvoiceChange);
        // If an invoice is preselected (e.g., from old input), trigger autofill
        onInvoiceChange();
    }
    // Prevent client from typing more than max
    amountInput.addEventListener('input', function(e){
        const max = parseFloat(this.getAttribute('max')) || null;
        if (max !== null && this.value !== '' && parseFloat(this.value) > max) {
            this.value = max.toFixed(2);
        }
    });
        // Preview button logic
        const previewBtn = document.getElementById('preview-invoice-btn');
        const modalHtml = `
                <div class="modal fade" id="invoicePreviewModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Invoice Preview</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div id="invoice-preview-body"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>`;

        if (previewBtn) {
                document.body.insertAdjacentHTML('beforeend', modalHtml);
                previewBtn.addEventListener('click', function() {
                        const opt = invoiceSelect.options[invoiceSelect.selectedIndex];
                        if (!opt || !opt.value) return;
                        const invoiceNumber = opt.getAttribute('data-invoice-number');
                        const invoiceAmount = opt.getAttribute('data-invoice-amount');
                        const invoiceRemaining = opt.getAttribute('data-invoice-remaining');
                        const itemsJson = opt.getAttribute('data-invoice-items') || '[]';
                        let items = [];
                        try { items = JSON.parse(itemsJson); } catch(e) { items = []; }

                        const body = document.getElementById('invoice-preview-body');
                        let html = `<p><strong>Invoice:</strong> INV-${invoiceNumber}</p>`;
                        html += `<p><strong>Total:</strong> ${parseFloat(invoiceAmount).toFixed(2)} &nbsp; <strong>Remaining:</strong> ${parseFloat(invoiceRemaining).toFixed(2)}</p>`;
                        html += '<div class="table-responsive"><table class="table table-sm"><thead><tr><th>Product</th><th>Qty</th><th>Unit Price</th><th>Total</th></tr></thead><tbody>';
                        if (items.length === 0) {
                                html += '<tr><td colspan="4">No items available</td></tr>';
                        } else {
                                items.forEach(function(it){
                                        const name = it.name || it.description || '(item)';
                                        const qty = it.quantity || it.qty || 1;
                                        const price = parseFloat(it.unit_price || it.price || 0).toFixed(2);
                                        const total = (qty * parseFloat(price)).toFixed(2);
                                        html += `<tr><td>${name}</td><td>${qty}</td><td class="text-right">${price}</td><td class="text-right">${total}</td></tr>`;
                                });
                        }
                        html += '</tbody></table></div>';
                        body.innerHTML = html;

                        // show bootstrap modal
                        $('#invoicePreviewModal').modal('show');
                });
        }
});
</script>
@endpush
