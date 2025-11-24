@extends('layouts.admin')

@section('title', 'Create Follow Up')

@section('content')
    <div class="card">
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('follow-ups.store') }}">
                @csrf
                @include('follow-ups._form') {{-- This file will be created later --}}
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-success">Create</button>
                    <a href="{{ route('follow-ups.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
