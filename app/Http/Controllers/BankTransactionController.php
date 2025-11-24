<?php

namespace App\Http\Controllers;

use App\Models\BankTransaction;
use Illuminate\Http\Request;

class BankTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = BankTransaction::with('bankAccount')->paginate(10);
        return view('bank_reconciliation.transactions.index', compact('transactions'));
    }

    /**
     * Display the specified resource.
     */
    public function show(BankTransaction $bankTransaction)
    {
        $bankTransaction->load('bankAccount', 'glTransaction');
        return view('bank_reconciliation.transactions.show', compact('bankTransaction'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BankTransaction $bankTransaction)
    {
        $bankTransaction->delete();

        return redirect()->route('finance.bank-transactions.index')->with('success', 'Bank Transaction deleted successfully.');
    }
}
