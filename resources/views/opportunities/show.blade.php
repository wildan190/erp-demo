@extends('layouts.admin')

@section('title', 'Opportunity Details')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Opportunity: {{ $opportunity->name }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Lead:</strong> {{ $opportunity->lead->name ?? 'N/A' }}</p>
            <p><strong>Stage:</strong> {{ $opportunity->stage }}</p>
            <p><strong>Amount:</strong> {{ $opportunity->amount }}</p>
            <p><strong>Close Date:</strong> {{ $opportunity->close_date ? $opportunity->close_date->format('Y-m-d') : 'N/A' }}</p>
            <p><strong>Notes:</strong><br>{{ nl2br(e($opportunity->notes)) }}</p>

            <p class="mt-3">
                <a href="{{ route('opportunities.edit', $opportunity) }}" class="btn btn-primary">Edit</a>
                <a href="{{ route('opportunities.index') }}" class="btn btn-secondary">Back</a>
            </p>
        </div>
    </div>
@endsection
