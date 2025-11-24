<?php

namespace App\Http\Controllers;

use App\Models\GLTransaction;
use App\Models\GLAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GLTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = GLTransaction::with('items.glAccount')->paginate(10);
        return view('general_ledger.transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $glAccounts = GLAccount::all();
        return view('general_ledger.transactions.create', compact('glAccounts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'transaction_date' => 'required|date',
            'reference' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.gl_account_id' => 'required|exists:gl_accounts,id',
            'items.*.debit' => 'nullable|numeric|min:0',
            'items.*.credit' => 'nullable|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $transaction = GLTransaction::create([
                'transaction_date' => $request->transaction_date,
                'reference' => $request->reference,
                'description' => $request->description,
            ]);

            foreach ($request->items as $itemData) {
                $transaction->items()->create($itemData);
            }
        });

        return redirect()->route('finance.gl.transactions.index')->with('success', 'GL Transaction created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(GLTransaction $transaction)
    {
        $transaction->load('items.glAccount');
        return view('general_ledger.transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GLTransaction $transaction)
    {
        $transaction->load('items');
        $glAccounts = GLAccount::all();
        return view('general_ledger.transactions.edit', compact('transaction', 'glAccounts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GLTransaction $transaction)
    {
        $request->validate([
            'transaction_date' => 'required|date',
            'reference' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.gl_account_id' => 'required|exists:gl_accounts,id',
            'items.*.debit' => 'nullable|numeric|min:0',
            'items.*.credit' => 'nullable|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $transaction) {
            $transaction->update([
                'transaction_date' => $request->transaction_date,
                'reference' => $request->reference,
                'description' => $request->description,
            ]);

            $transaction->items()->delete(); // Clear old items
            foreach ($request->items as $itemData) {
                $transaction->items()->create($itemData);
            }
        });

        return redirect()->route('finance.gl.transactions.index')->with('success', 'GL Transaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GLTransaction $transaction)
    {
        $transaction->delete();

        return redirect()->route('finance.gl.transactions.index')->with('success', 'GL Transaction deleted successfully.');
    }
}
