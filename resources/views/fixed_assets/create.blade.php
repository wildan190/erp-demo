@extends('layouts.admin')

@section('title', 'Create Fixed Asset')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Create New Fixed Asset</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('finance.fixed-assets.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="asset_name">Asset Name</label>
                            <input type="text" class="form-control @error('asset_name') is-invalid @enderror" id="asset_name" name="asset_name" value="{{ old('asset_name') }}" placeholder="Enter asset name" required>
                            @error('asset_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Enter asset description">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="asset_number">Asset Number</label>
                            <input type="text" class="form-control @error('asset_number') is-invalid @enderror" id="asset_number" name="asset_number" value="{{ old('asset_number') }}" placeholder="Enter asset number">
                            @error('asset_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="acquisition_date">Acquisition Date</label>
                            <input type="date" class="form-control @error('acquisition_date') is-invalid @enderror" id="acquisition_date" name="acquisition_date" value="{{ old('acquisition_date') }}" required>
                            @error('acquisition_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="cost">Cost</label>
                            <input type="number" step="0.01" class="form-control @error('cost') is-invalid @enderror" id="cost" name="cost" value="{{ old('cost') }}" placeholder="Enter cost" required>
                            @error('cost')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="salvage_value">Salvage Value</label>
                            <input type="number" step="0.01" class="form-control @error('salvage_value') is-invalid @enderror" id="salvage_value" name="salvage_value" value="{{ old('salvage_value') }}" placeholder="Enter salvage value">
                            @error('salvage_value')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="useful_life_years">Useful Life (Years)</label>
                            <input type="number" class="form-control @error('useful_life_years') is-invalid @enderror" id="useful_life_years" name="useful_life_years" value="{{ old('useful_life_years') }}" placeholder="Enter useful life in years" required>
                            @error('useful_life_years')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="depreciation_method">Depreciation Method</label>
                            <select class="form-control @error('depreciation_method') is-invalid @enderror" id="depreciation_method" name="depreciation_method" required>
                                <option value="">Select Depreciation Method</option>
                                <option value="Straight-line" {{ old('depreciation_method') == 'Straight-line' ? 'selected' : '' }}>Straight-line</option>
                                <option value="Declining Balance" {{ old('depreciation_method') == 'Declining Balance' ? 'selected' : '' }}>Declining Balance</option>
                                <option value="Sum-of-the-years'-digits" {{ old('depreciation_method') == "Sum-of-the-years'-digits" ? 'selected' : '' }}>Sum-of-the-years'-digits</option>
                                <option value="Units of production" {{ old('depreciation_method') == 'Units of production' ? 'selected' : '' }}>Units of production</option>
                            </select>
                            @error('depreciation_method')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="current_value">Current Value</label>
                            <input type="number" step="0.01" class="form-control @error('current_value') is-invalid @enderror" id="current_value" name="current_value" value="{{ old('current_value') }}" placeholder="Calculated automatically" readonly required>
                            @error('current_value')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="disposal_date">Disposal Date</label>
                            <input type="date" class="form-control @error('disposal_date') is-invalid @enderror" id="disposal_date" name="disposal_date" value="{{ old('disposal_date') }}">
                            @error('disposal_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const costInput = document.getElementById('cost');
        const currentValueInput = document.getElementById('current_value');

        function updateCurrentValue() {
            // Ensure costInput.value is a valid number before setting it
            const cost = parseFloat(costInput.value);
            if (!isNaN(cost)) {
                currentValueInput.value = cost.toFixed(2);
            } else {
                currentValueInput.value = ''; // Or '0.00' if you prefer a default
            }
        }

        // Update when cost input changes
        costInput.addEventListener('input', updateCurrentValue);

        // Initial update in case there's an old value for cost
        if (costInput.value) {
            updateCurrentValue();
        }
    });
</script>
@endpush
