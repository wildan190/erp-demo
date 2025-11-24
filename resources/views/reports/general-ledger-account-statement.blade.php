@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('General Ledger Account Statement') }}</div>

                <div class="card-body">
                    <form action="{{ route('reports.general-ledger-account-statement') }}" method="GET" class="mb-4">
                        <div class="form-group">
                            <label for="account_id">Select GL Account:</label>
                            <select name="account_id" id="account_id" class="form-control" onchange="this.form.submit()">
                                <option value="">-- Select an Account --</option>
                                @foreach($glAccounts as $account)
                                    <option value="{{ $account->id }}" {{ $selectedAccount && $selectedAccount->id == $account->id ? 'selected' : '' }}>
                                        {{ $account->account_name }} ({{ $account->account_code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    @if($selectedAccount)
                        <h5 class="mb-4">Account: {{ $selectedAccount->account_name }} ({{ $selectedAccount->account_code }})</h5>
                        <h6 class="mb-4">Current Balance: <strong>{{ number_format($balance, 2) }}</strong></h6>

                        @if($transactions->isEmpty())
                            <p>No transactions found for this account.</p>
                        @else
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>GL Transaction</th>
                                        <th>Description</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transactions as $item)
                                        <tr>
                                            <td>{{ $item->created_at->format('Y-m-d') }}</td>
                                            <td>{{ $item->glTransaction->transaction_number ?? 'N/A' }}</td>
                                            <td>{{ $item->description }}</td>
                                            <td>{{ $item->type === 'debit' ? number_format($item->amount, 2) : '' }}</td>
                                            <td>{{ $item->type === 'credit' ? number_format($item->amount, 2) : '' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    @else
                        <p>Please select a GL account to view its statement.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
