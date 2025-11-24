<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GLAccount;
use App\Models\GLTransaction;
use App\Models\GLTransactionItem;

class GeneralLedgerController extends Controller
{
    /**
     * Display a listing of the General Ledger Account Statement report.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $glAccounts = GLAccount::all();
        $selectedAccount = null;
        $transactions = collect();
        $balance = 0;

        if ($request->has('account_id')) {
            $selectedAccount = GLAccount::find($request->input('account_id'));
            if ($selectedAccount) {
                // Fetch transaction items related to this GL account
                $transactions = GLTransactionItem::where('gl_account_id', $selectedAccount->id)
                                                ->with('glTransaction')
                                                ->orderBy('created_at', 'asc')
                                                ->get();

                // Calculate balance
                $balance = $transactions->sum(function($item) {
                    return $item->debit - $item->credit;
                });
            }
        }

        return view('reports.general-ledger-account-statement', compact('glAccounts', 'selectedAccount', 'transactions', 'balance'));
    }
}
