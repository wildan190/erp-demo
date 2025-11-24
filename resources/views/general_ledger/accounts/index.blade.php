@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">General Ledger Accounts</h3>
            <div class="card-tools">
                <a href="{{ route('finance.gl.accounts.create') }}" class="btn btn-primary btn-sm">Add New Account</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Account Number</th>
                        <th>Account Name</th>
                        <th>Account Type</th>
                        <th>Parent Account</th>
                        <th>Is Contra</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($accounts as $account)
                        @include('general_ledger.accounts._account_row', ['account' => $account, 'level' => 0])
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No GL accounts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.toggle-children').forEach(function (element) {
        element.addEventListener('click', function () {
            const accountId = this.dataset.accountId;
            const childRows = document.querySelectorAll('.child-of-' + accountId);
            childRows.forEach(function (childRow) {
                if (childRow.style.display === 'none') {
                    childRow.style.display = ''; // Show the row
                } else {
                    childRow.style.display = 'none'; // Hide the row
                }
            });

            // Toggle icon
            if (this.classList.contains('fa-plus-square-o')) {
                this.classList.remove('fa-plus-square-o');
                this.classList.add('fa-minus-square-o');
            } else {
                this.classList.remove('fa-minus-square-o');
                this.classList.add('fa-plus-square-o');
            }
        });
    });
});
</script>
@endpush
