<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; }
        .container { max-width: 800px; margin: auto; padding: 20px; border: 1px solid #eee; }
        .header, .footer { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; }
        .details, .customer-details { margin-bottom: 20px; }
        .details table, .items table { width: 100%; border-collapse: collapse; }
        .details th, .details td, .items th, .items td { padding: 8px; }
        .items th, .items td { border-bottom: 1px solid #eee; }
        .items th { background-color: #f7f7f7; }
        .items .total td { border-top: 2px solid #333; font-weight: bold; }
        .terms { margin-top: 30px; font-size: 0.9em; color: #666; }
        @media print {
            body { -webkit-print-color-adjust: exact; }
            .no-print { display: none; }
            .container { border: none; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>INVOICE</h1>
            <p>{{ config('app.name', 'ERP Demo') }}</p>
        </div>

        <div class="details">
            <table>
                <tr>
                    <td>
                        <strong>Invoice #:</strong> {{ $invoice->invoice_number }}<br>
                        <strong>Issued Date:</strong> {{ \Carbon\Carbon::parse($invoice->issued_at)->format('Y-m-d') }}<br>
                        <strong>Status:</strong> {{ ucfirst($invoice->status) }}
                    </td>
                    <td>
                        <strong>Billed To:</strong><br>
                        {{ $invoice->order->customer->name ?? 'Guest' }}<br>
                        {{ $invoice->order->customer->email ?? '' }}<br>
                        {{ $invoice->order->customer->phone ?? '' }}<br>
                        {{ $invoice->order->customer->address ?? '' }}
                    </td>
                </tr>
            </table>
        </div>

        <div class="items">
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->order->items as $item)
                    <tr>
                        <td>{{ $item->product->name ?? '-' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->price, 2) }}</td>
                        <td>{{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                    @endforeach
                    <tr class="total">
                        <td colspan="3" style="text-align: right;"><strong>Total</strong></td>
                        <td><strong>{{ number_format($invoice->amount, 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="terms">
            <strong>Terms & Conditions:</strong>
            <p>Payment is due within 30 days. Late payments are subject to a fee of 5%.</p>
        </div>

        <div class="footer">
            <p>Thank you for your business!</p>
            <button class="no-print" onclick="window.print()">Print Invoice</button>
        </div>
    </div>
</body>
</html>
