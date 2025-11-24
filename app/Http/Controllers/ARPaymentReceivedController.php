<?php

namespace App\Http\Controllers;

use App\Models\ARPaymentReceived;
use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Http\Request;

class ARPaymentReceivedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = ARPaymentReceived::with('customer', 'invoice')->paginate(10);
        return view('accounts_receivable.payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();

        // Load invoices with payments and order->customer to compute remaining via model accessor
        $invoices = Invoice::with(['payments', 'order.customer'])->get()->filter(function ($invoice) {
            return $invoice->remaining_amount > 0;
        })->values();

        return view('accounts_receivable.payments.create', compact('customers', 'invoices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Always generate a server-side unique payment number
        $last = ARPaymentReceived::latest()->first();
        $lastNumber = $last ? $last->payment_number : 'ARP-000000';
        $num = intval(substr($lastNumber, 4)) + 1;
        $generated = 'ARP-' . str_pad($num, 6, '0', STR_PAD_LEFT);
        // ensure uniqueness (small loop in case of race)
        $tries = 0;
        while (ARPaymentReceived::where('payment_number', $generated)->exists() && $tries < 1000) {
            $num++;
            $generated = 'ARP-' . str_pad($num, 6, '0', STR_PAD_LEFT);
            $tries++;
        }
        $request->merge(['payment_number' => $generated]);

        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_id' => 'nullable|exists:invoices,id',
            'payment_number' => 'required|string|unique:ar_payments_received,payment_number|max:255',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        // If invoice selected, ensure not overpaying
        if ($request->filled('invoice_id')) {
            $invoice = Invoice::with('payments')->find($request->invoice_id);
            if (!$invoice) {
                return back()->withErrors(['invoice_id' => 'Selected invoice not found.'])->withInput();
            }
            if ($request->amount > $invoice->remaining_amount) {
                return back()->withErrors(['amount' => 'Payment amount exceeds invoice remaining balance ('.number_format($invoice->remaining_amount,2).').'])->withInput();
            }
        }

        ARPaymentReceived::create($request->all());

        // Optionally update invoice status (paid/partially_paid)
        if (isset($invoice)) {
            $paid = $invoice->payments()->sum('amount');
            if ($paid >= $invoice->amount) {
                $invoice->update(['status' => 'paid', 'paid_at' => now()]);
            } elseif ($paid > 0) {
                $invoice->update(['status' => 'partially_paid']);
            }
        }

        return redirect()->route('finance.ar.payments.index')->with('success', 'Payment received successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ARPaymentReceived $payment)
    {
        $payment->load('customer', 'invoice');
        return view('accounts_receivable.payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ARPaymentReceived $payment)
    {
        $customers = Customer::all();
        $invoices = Invoice::all();
        return view('accounts_receivable.payments.edit', compact('payment', 'customers', 'invoices'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ARPaymentReceived $payment)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_id' => 'nullable|exists:invoices,id',
            'payment_number' => 'required|string|unique:ar_payments_received,payment_number,' . $payment->id . '|max:255',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $payment->update($request->all());

        // Logic to update invoice status can be added here

        return redirect()->route('finance.ar.payments.index')->with('success', 'Payment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ARPaymentReceived $payment)
    {
        $payment->delete();

        // Logic to revert invoice status if necessary

        return redirect()->route('finance.ar.payments.index')->with('success', 'Payment deleted successfully.');
    }
}
