@extends('layouts.admin')

@section('title','Create Purchase')

@section('content')
    <div class="card">
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('purchases.store') }}">
                @csrf

                <div class="form-group">
                    <label for="supplier_id">Supplier</label>
                    <select id="supplier_id" class="form-control" name="supplier_id">
                        <option value="">-- select --</option>
                        @foreach($suppliers as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>

                <h5>Items</h5>
                <div id="items">
                    @for($i=0;$i<3;$i++)
                        <div class="border rounded p-2 mb-2">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Product</label>
                                    <select name="items[{{ $i }}][product_id]" class="form-control">
                                        <option value="">-- select --</option>
                                        @foreach($products as $p)
                                            <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->price }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Quantity</label>
                                    <input class="form-control" type="number" name="items[{{ $i }}][quantity]" value="1" min="1">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Price</label>
                                    <input class="form-control" type="number" step="0.01" name="items[{{ $i }}][price]" value="0">
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>

                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-success">Record Purchase</button>
                    <a href="{{ route('purchases.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
