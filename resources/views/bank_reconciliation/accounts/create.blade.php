@extends('layouts.admin')

@section('title', 'Create Bank Account')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Create New Bank Account</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('finance.bank-accounts.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="bank_name">Bank Name</label>
                            <input type="text" class="form-control @error('bank_name') is-invalid @enderror" id="bank_name" name="bank_name" placeholder="Enter bank name" value="{{ old('bank_name') }}" required>
                            @error('bank_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="account_name">Account Name</label>
                            <input type="text" class="form-control @error('account_name') is-invalid @enderror" id="account_name" name="account_name" placeholder="Enter account name" value="{{ old('account_name') }}" required>
                            @error('account_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="account_number">Account Number</label>
                            <input type="text" class="form-control @error('account_number') is-invalid @enderror" id="account_number" name="account_number" placeholder="Enter account number" value="{{ old('account_number') }}" required>
                            @error('account_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="currency">Currency</label>
                            <select class="form-control @error('currency') is-invalid @enderror" id="currency" name="currency" required>
                                <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD</option>
                                <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>EUR</option>
                                <option value="GBP" {{ old('currency') == 'GBP' ? 'selected' : '' }}>GBP</option>
                                <option value="JPY" {{ old('currency') == 'JPY' ? 'selected' : '' }}>JPY</option>
                                <option value="IDR" {{ old('currency') == 'IDR' ? 'selected' : '' }}>IDR</option>
                            </select>
                            @error('currency')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="opening_balance">Opening Balance</label>
                            <input type="number" step="0.01" class="form-control @error('opening_balance') is-invalid @enderror" id="opening_balance" name="opening_balance" placeholder="Enter opening balance" value="{{ old('opening_balance') }}" required>
                            @error('opening_balance')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="current_balance">Current Balance</label>
                            <input type="number" step="0.01" class="form-control @error('current_balance') is-invalid @enderror" id="current_balance" name="current_balance" placeholder="Enter current balance" value="{{ old('current_balance') }}" readonly>
                            @error('current_balance')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <small class="form-text text-muted">Current balance is usually calculated automatically.</small>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
@endsection
