@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Accounts Payable Overview</h3>
        </div>
        <div class="card-body">
            <p>Welcome to the Accounts Payable module. Manage all outstanding bills from your suppliers.</p>
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title">Supplier Bills</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">View and manage all bills received from suppliers, track due dates, and payment statuses.</p>
                            <a href="{{ route('finance.ap.bills.index') }}" class="btn btn-primary">View Bills</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
