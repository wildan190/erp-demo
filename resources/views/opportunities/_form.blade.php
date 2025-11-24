<div class="form-group">
    <label for="name">Opportunity Name</label>
    <input id="name" class="form-control" type="text" name="name" value="{{ old('name', (isset($opportunity) ? $opportunity->name : '') ?? '') }}" required>
    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label for="customer_id">Customer</label>
    <select id="customer_id" class="form-control" name="customer_id">
        <option value="">Select Customer</option>
        @foreach($customers as $customer)
            <option value="{{ $customer->id }}" {{ old('customer_id', (isset($opportunity) ? $opportunity->customer_id : '') ?? '') == $customer->id ? 'selected' : '' }}>
                {{ $customer->name }}
            </option>
        @endforeach
    </select>
    @error('customer_id') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label for="lead_id">Lead</label>
    <select id="lead_id" class="form-control" name="lead_id">
        <option value="">Select Lead</option>
        @foreach($leads as $lead)
            <option value="{{ $lead->id }}" {{ old('lead_id', (isset($opportunity) ? $opportunity->lead_id : '') ?? '') == $lead->id ? 'selected' : '' }}>
                {{ $lead->name }}
            </option>
        @endforeach
    </select>
    @error('lead_id') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label for="user_id">Assigned User</label>
    <select id="user_id" class="form-control" name="user_id">
        <option value="">Select User</option>
        @foreach($users as $user)
            <option value="{{ $user->id }}" {{ old('user_id', (isset($opportunity) ? $opportunity->user_id : '') ?? '') == $user->id ? 'selected' : '' }}>
                {{ $user->name }}
            </option>
        @endforeach
    </select>
    @error('user_id') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label for="expected_revenue">Expected Revenue</label>
    <input id="expected_revenue" class="form-control" type="number" step="0.01" name="expected_revenue" value="{{ old('expected_revenue', (isset($opportunity) ? $opportunity->expected_revenue : '0.00') ?? '0.00') }}">
    @error('expected_revenue') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label for="close_date">Close Date</label>
    <input id="close_date" class="form-control" type="date" name="close_date" value="{{ old('close_date', (isset($opportunity) && $opportunity->close_date ? $opportunity->close_date->format('Y-m-d') : '') ?? '') }}">
    @error('close_date') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label for="stage">Stage</label>
    <select id="stage" class="form-control" name="stage">
        @php
            $stages = ['Prospecting', 'Qualification', 'Proposal', 'Negotiation', 'Closed Won', 'Closed Lost'];
        @endphp
        <option value="">Select Stage</option>
        @foreach($stages as $stageOption)
            <option value="{{ $stageOption }}" {{ old('stage', (isset($opportunity) ? $opportunity->stage : '') ?? '') == $stageOption ? 'selected' : '' }}>
                {{ $stageOption }}
            </option>
        @endforeach
    </select>
    @error('stage') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label for="probability">Probability (%)</label>
    <input id="probability" class="form-control" type="number" step="1" min="0" max="100" name="probability" value="{{ old('probability', (isset($opportunity) ? $opportunity->probability : '0') ?? '0') }}">
    @error('probability') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label for="notes">Notes</label>
    <textarea id="notes" class="form-control" name="notes">{{ old('notes', (isset($opportunity) ? $opportunity->notes : '') ?? '') }}</textarea>
    @error('notes') <small class="text-danger">{{ $message }}</small> @enderror
</div>
