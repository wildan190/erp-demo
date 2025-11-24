@extends('layouts.admin')

@section('title', 'Edit Opportunity')

@section('content')
    <div class="card">
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('opportunities.update', $opportunity) }}">
                @csrf
                @method('PUT')
                @include('opportunities._form') {{-- This file will be created later --}}
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('opportunities.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
