@php
    // The $level variable controls the indentation. Default to 0 if not set.
    $level = $level ?? 0;
    // Calculate the indentation in pixels.
    $indentation = $level * 20;
@endphp

<tr @if($level > 0) class="child-row child-of-{{ $account->parent_account_id }}" style="display: none;" @endif>
    <td>{{ $account->account_number }}</td>
    <td style="padding-left: {{ $indentation }}px;">
        @if($account->childrenRecursive->isNotEmpty())
            <i class="fa fa-plus-square-o toggle-children" style="cursor: pointer;" data-account-id="{{ $account->id }}"></i>
        @else
            <i class="fa fa-square-o" style="visibility: hidden;"></i>
        @endif
        {{ $account->account_name }}
    </td>
    <td>{{ $account->account_type }}</td>
    <td>{{ $account->parentAccount->account_name ?? 'N/A' }}</td>
    <td>{{ $account->is_contra ? 'Yes' : 'No' }}</td>
    <td>
        <a href="{{ route('finance.gl.accounts.show', $account->id) }}" class="btn btn-info btn-sm">View</a>
        <a href="{{ route('finance.gl.accounts.edit', $account->id) }}" class="btn btn-warning btn-sm">Edit</a>
        <form action="{{ route('finance.gl.accounts.destroy', $account->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this account and all its children?')">Delete</button>
        </form>
    </td>
</tr>

{{-- If the account has children, recursively include this partial for each child --}}
@if($account->childrenRecursive->isNotEmpty())
    @foreach($account->childrenRecursive as $childAccount)
        @include('general_ledger.accounts._account_row', ['account' => $childAccount, 'level' => $level + 1])
    @endforeach
@endif