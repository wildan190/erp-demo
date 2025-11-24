<?php

namespace App\Http\Controllers;

use App\Models\APBill;
use App\Models\APPayment;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class APBillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bills = APBill::with('supplier')->paginate(10);
        return view('accounts_payable.bills.index', compact('bills'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('accounts_payable.bills.create', compact('suppliers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            // 'bill_number' removed from validation as it will be auto-generated
            'bill_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:bill_date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'nullable|exists:products,id',
            'items.*.description' => 'nullable|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            // Auto-generate bill number
            $lastBill = APBill::latest()->first();
            $lastBillNumber = $lastBill ? $lastBill->bill_number : 'APB-000000';
            $number = intval(substr($lastBillNumber, 4)) + 1;
            $billNumber = 'APB-' . str_pad($number, 6, '0', STR_PAD_LEFT);

            $totalAmount = 0;
            foreach ($request->items as $itemData) {
                $totalAmount += $itemData['quantity'] * $itemData['unit_price'];
            }

            $bill = APBill::create([
                'supplier_id' => $request->supplier_id,
                'bill_number' => $billNumber, // Use auto-generated bill number
                'bill_date' => $request->bill_date,
                'due_date' => $request->due_date,
                'total_amount' => $totalAmount,
                'status' => 'unpaid',
                'notes' => $request->notes,
            ]);

            foreach ($request->items as $itemData) {
                $bill->items()->create([
                    'product_id' => $itemData['product_id'],
                    'description' => $itemData['description'] ?? null,
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'total' => $itemData['quantity'] * $itemData['unit_price'],
                ]);
            }
        });

        return redirect()->route('finance.ap.bills.index')->with('success', 'AP Bill created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(APBill $bill)
    {
        $bill->load('supplier', 'items.product', 'payments');
        $bankAccounts = BankAccount::all();
        return view('accounts_payable.bills.show', compact('bill', 'bankAccounts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(APBill $bill)
    {
        $bill->load('items');
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('accounts_payable.bills.edit', compact('bill', 'suppliers', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, APBill $bill)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'bill_number' => 'required|string|unique:ap_bills,bill_number,' . $bill->id . '|max:255',
            'bill_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:bill_date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'nullable|exists:products,id',
            'items.*.description' => 'nullable|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $bill) {
            $totalAmount = 0;
            foreach ($request->items as $itemData) {
                $totalAmount += $itemData['quantity'] * $itemData['unit_price'];
            }

            $bill->update([
                'supplier_id' => $request->supplier_id,
                'bill_number' => $request->bill_number,
                'bill_date' => $request->bill_date,
                'due_date' => $request->due_date,
                'total_amount' => $totalAmount,
                'notes' => $request->notes,
            ]);

            $bill->items()->delete(); // Clear old items
            foreach ($request->items as $itemData) {
                $bill->items()->create([
                    'product_id' => $itemData['product_id'],
                    'description' => $itemData['description'] ?? null,
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'total' => $itemData['quantity'] * $itemData['unit_price'],
                ]);
            }
        });

        return redirect()->route('finance.ap.bills.index')->with('success', 'AP Bill updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(APBill $bill)
    {
        $bill->delete();

        return redirect()->route('finance.ap.bills.index')->with('success', 'AP Bill deleted successfully.');
    }

    /**
     * Record a payment for the given AP Bill.
     */
    public function pay(Request $request, APBill $bill)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'nullable|date',
            'bank_account_id' => 'nullable|exists:bank_accounts,id',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $bill) {
            $last = APPayment::latest()->first();
            $lastNumber = $last ? $last->payment_number : 'APP-000000';
            $number = intval(substr($lastNumber, 4)) + 1;
            $paymentNumber = 'APP-' . str_pad($number, 6, '0', STR_PAD_LEFT);

            $payment = APPayment::create([
                'ap_bill_id' => $bill->id,
                'payment_number' => $paymentNumber,
                'amount' => $request->amount,
                'payment_date' => $request->payment_date ?? now(),
                'bank_account_id' => $request->bank_account_id,
                'notes' => $request->notes,
            ]);

            // If a bank account is provided, deduct the amount and create a bank transaction
            if ($request->bank_account_id) {
                $bankAccount = BankAccount::find($request->bank_account_id);
                if ($bankAccount) {
                    // Subtract from current balance
                    $bankAccount->current_balance = $bankAccount->current_balance - $payment->amount;
                    $bankAccount->save();

                    // Create bank transaction record
                    \App\Models\BankTransaction::create([
                        'bank_account_id' => $bankAccount->id,
                        'transaction_date' => $payment->payment_date,
                        'description' => 'AP Bill Payment: ' . $bill->bill_number,
                        'amount' => -1 * $payment->amount,
                        'type' => 'debit',
                        'is_reconciled' => false,
                        'gl_transaction_id' => null,
                    ]);
                }
            }

            // Refresh AP Bill status based on payments
            $bill->refreshPaymentStatus();
        });

        return redirect()->route('finance.ap.bills.show', $bill)->with('success', 'Payment recorded successfully.');
    }
}
