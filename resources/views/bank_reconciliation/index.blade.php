@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Bank Reconciliation Overview</h3>
        </div>
        <div class="card-body">
            <p>Welcome to the Bank Reconciliation module. Manage your bank accounts and reconcile bank statements with your general ledger.</p>
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title">Bank Accounts</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Set up and manage all bank accounts associated with your company.</p>
                            <a href="{{ route('finance.bank-accounts.index') }}" class="btn btn-primary">View Bank Accounts</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h5 class="card-title">Bank Transactions</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Import and manage bank statement transactions for reconciliation.</p>
                            <a href="{{ route('finance.bank-transactions.index') }}" class="btn btn-info">View Bank Transactions</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
