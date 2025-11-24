<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accounts = BankAccount::paginate(10);
        return view('bank_reconciliation.accounts.index', compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bank_reconciliation.accounts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|unique:bank_accounts,account_number|max:255',
            'currency' => 'required|string|max:3',
            'opening_balance' => 'required|numeric|min:0',
            // 'current_balance' is usually calculated automatically and should not be required on creation
        ]);

        try {
            $bankAccount = BankAccount::create([
                'bank_name' => $request->bank_name,
                'account_name' => $request->account_name,
                'account_number' => $request->account_number,
                'currency' => $request->currency,
                'opening_balance' => $request->opening_balance,
                'current_balance' => $request->opening_balance, // Set current balance to opening balance on creation
            ]);
            return redirect()->route('finance.bank-accounts.index')->with('success', 'Bank Account created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to create bank account: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(BankAccount $bankAccount)
    {
        return view('bank_reconciliation.accounts.show', compact('bankAccount'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BankAccount $bankAccount)
    {
        return view('bank_reconciliation.accounts.edit', compact('bankAccount'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BankAccount $bankAccount)
    {
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|unique:bank_accounts,account_number,' . $bankAccount->id . '|max:255',
            'currency' => 'required|string|max:3',
            'opening_balance' => 'required|numeric|min:0',
            'current_balance' => 'required|numeric|min:0',
        ]);

        $bankAccount->update($request->all());

        return redirect()->route('finance.bank-accounts.index')->with('success', 'Bank Account updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BankAccount $bankAccount)
    {
        $bankAccount->delete();

        return redirect()->route('finance.bank-accounts.index')->with('success', 'Bank Account deleted successfully.');
    }
}
