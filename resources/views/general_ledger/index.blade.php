@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">General Ledger Overview</h3>
        </div>
        <div class="card-body">
            <p>Welcome to the General Ledger module. Below are links to manage your Chart of Accounts and view Financial Transactions.</p>
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title">Chart of Accounts</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Manage your company's financial accounts, including assets, liabilities, equity, revenue, and expenses.</p>
                            <a href="{{ route('finance.gl.accounts.index') }}" class="btn btn-primary">View Accounts</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h5 class="card-title">Financial Transactions</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Record and view all journal entries and financial transactions affecting your general ledger.</p>
                            <a href="{{ route('finance.gl.transactions.index') }}" class="btn btn-info">View Transactions</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
