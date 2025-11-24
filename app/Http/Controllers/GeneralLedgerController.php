<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralLedgerController extends Controller
{
    public function index()
    {
        return view('general_ledger.index');
    }
}
