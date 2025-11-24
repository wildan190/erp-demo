<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountsPayableController extends Controller
{
    public function index()
    {
        return view('accounts_payable.index');
    }
}
