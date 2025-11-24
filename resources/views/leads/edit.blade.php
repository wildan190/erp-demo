@extends('layouts.admin')

@section('title', 'Edit Lead')

@section('content')
    <div class="card">
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('leads.update', $lead) }}">
                @csrf
                @method('PUT')
                @include('leads._form') {{-- This file will be created later --}}
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('leads.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection