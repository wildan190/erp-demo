@extends('layouts.admin')

@section('title', 'Create GL Account')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Create New GL Account</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('finance.gl.accounts.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="account_number">Account Number</label>
                            <input type="text" class="form-control @error('account_number') is-invalid @enderror" id="account_number" name="account_number" value="{{ old('account_number') }}" placeholder="Enter account number" required>
                            @error('account_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="account_name">Account Name</label>
                            <input type="text" class="form-control @error('account_name') is-invalid @enderror" id="account_name" name="account_name" value="{{ old('account_name') }}" placeholder="Enter account name" required>
                            @error('account_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="account_type">Account Type</label>
                            <input type="text" class="form-control @error('account_type') is-invalid @enderror" id="account_type" name="account_type" value="{{ old('account_type') }}" placeholder="Enter account type">
                            @error('account_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            {{-- TODO: Replace with a select dropdown with predefined options --}}
                        </div>
                        <div class="form-group">
                            <label for="parent_account_id">Parent Account</label>
                            <select class="form-control @error('parent_account_id') is-invalid @enderror" id="parent_account_id" name="parent_account_id">
                                <option value="">None</option>
                                @foreach($parentAccounts as $account)
                                    <option value="{{ $account->id }}" {{ old('parent_account_id') == $account->id ? 'selected' : '' }}>
                                        {{ $account->account_name }} ({{ $account->account_number }})
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_account_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group form-check">
                            <input type="hidden" name="is_contra" value="0"> {{-- Hidden field to ensure 0 is sent when checkbox is unchecked --}}
                            <input type="checkbox" class="form-check-input" id="is_contra" name="is_contra" value="1">
                            <label class="form-check-label" for="is_contra">Is Contra Account</label>
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
