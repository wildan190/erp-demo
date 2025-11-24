@extends('layouts.admin')

@section('title', 'Edit Quotation')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Quotation: {{ $quotation->quotation_number }}</h3>
        </div>
        <form action="{{ route('quotations.update', $quotation) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="customer_id">Customer</label>
                    <select name="customer_id" id="customer_id" class="form-control @error('customer_id') is-invalid @enderror" required>
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('customer_id', $quotation->customer_id) == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                        @endforeach
                    </select>
                    @error('customer_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="quotation_number">Quotation Number</label>
                    <input type="text" name="quotation_number" id="quotation_number" class="form-control @error('quotation_number') is-invalid @enderror" value="{{ old('quotation_number', $quotation->quotation_number) }}" required>
                    @error('quotation_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="quotation_date">Quotation Date</label>
                    <input type="date" name="quotation_date" id="quotation_date" class="form-control @error('quotation_date') is-invalid @enderror" value="{{ old('quotation_date', $quotation->quotation_date->format('Y-m-d')) }}" required>
                    @error('quotation_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="valid_until">Valid Until</label>
                    <input type="date" name="valid_until" id="valid_until" class="form-control @error('valid_until') is-invalid @enderror" value="{{ old('valid_until', $quotation->valid_until->format('Y-m-d')) }}" required>
                    @error('valid_until')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                        <option value="draft" {{ old('status', $quotation->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="sent" {{ old('status', $quotation->status) == 'sent' ? 'selected' : '' }}>Sent</option>
                        <option value="accepted" {{ old('status', $quotation->status) == 'accepted' ? 'selected' : '' }}>Accepted</option>
                        <option value="rejected" {{ old('status', $quotation->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    @error('status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="total_amount">Total Amount</label>
                    <input type="number" name="total_amount" id="total_amount" class="form-control @error('total_amount') is-invalid @enderror" value="{{ old('total_amount', $quotation->total_amount) }}" step="0.01" required>
                    @error('total_amount')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes', $quotation->notes) }}</textarea>
                    @error('notes')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('quotations.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
