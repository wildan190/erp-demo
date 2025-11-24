<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BankReconciliationController extends Controller
{
    public function index()
    {
        return view('bank_reconciliation.index');
    }
}
