@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Accounts Receivable Overview</h3>
        </div>
        <div class="card-body">
            <p>Welcome to the Accounts Receivable module. Manage all payments received from your customers.</p>
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-success card-outline">
                        <div class="card-header">
                            <h5 class="card-title">Payments Received</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">View and record payments received from customers, linking them to outstanding invoices.</p>
                            <a href="{{ route('finance.ar.payments.index') }}" class="btn btn-success">View Payments</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
