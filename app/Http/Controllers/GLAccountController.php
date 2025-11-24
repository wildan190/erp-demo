<?php

namespace App\Http\Controllers;

use App\Models\GLAccount;
use Illuminate\Http\Request;

class GLAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accounts = GLAccount::whereNull('parent_account_id')
                                ->with('childrenRecursive')
                                ->get();
        return view('general_ledger.accounts.index', compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentAccounts = GLAccount::all();
        return view('general_ledger.accounts.create', compact('parentAccounts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'account_number' => 'required|string|unique:gl_accounts,account_number|max:255',
            'account_name' => 'required|string|max:255',
            'account_type' => 'required|string|max:255',
            'parent_account_id' => 'nullable|exists:gl_accounts,id',
            'is_contra' => 'boolean',
        ]);

        GLAccount::create($request->all());

        return redirect()->route('finance.gl.accounts.index')->with('success', 'GL Account created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(GLAccount $account)
    {
        return view('general_ledger.accounts.show', compact('account'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GLAccount $account)
    {
        $parentAccounts = GLAccount::where('id', '!=', $account->id)->get();
        return view('general_ledger.accounts.edit', compact('account', 'parentAccounts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GLAccount $account)
    {
        $request->validate([
            'account_number' => 'required|string|unique:gl_accounts,account_number,' . $account->id . '|max:255',
            'account_name' => 'required|string|max:255',
            'account_type' => 'required|string|max:255',
            'parent_account_id' => 'nullable|exists:gl_accounts,id',
            'is_contra' => 'boolean',
        ]);

        $account->update($request->all());

        return redirect()->route('finance.gl.accounts.index')->with('success', 'GL Account updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GLAccount $account)
    {
        $account->delete();

        return redirect()->route('finance.gl.accounts.index')->with('success', 'GL Account deleted successfully.');
    }
}
