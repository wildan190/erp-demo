@extends('layouts.admin')

@section('title', 'Lead Details')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lead: {{ $lead->name }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Email:</strong> {{ $lead->email }}</p>
            <p><strong>Phone:</strong> {{ $lead->phone }}</p>
            <p><strong>Source:</strong> {{ $lead->source }}</p>
            <p><strong>Status:</strong> {{ $lead->status }}</p>
            <p><strong>Notes:</strong><br>{{ nl2br(e($lead->notes)) }}</p>

            <p class="mt-3">
                <a href="{{ route('leads.edit', $lead) }}" class="btn btn-primary">Edit</a>
                <a href="{{ route('leads.index') }}" class="btn btn-secondary">Back</a>
            </p>
        </div>
    </div>
@endsection
