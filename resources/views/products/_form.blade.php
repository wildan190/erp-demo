<div class="form-group">
    <label for="sku">SKU</label>
    <input id="sku" class="form-control" type="text" name="sku" value="{{ old('sku', $product->sku ?? '') }}">
    @error('sku') <small class="text-danger">{{ $message }}</small> @enderror
</div>
<div class="form-group">
    <label for="name">Name</label>
    <input id="name" class="form-control" type="text" name="name" value="{{ old('name', $product->name ?? '') }}" required>
    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
</div>
<div class="form-group">
    <label for="description">Description</label>
    <textarea id="description" class="form-control" name="description">{{ old('description', $product->description ?? '') }}</textarea>
    @error('description') <small class="text-danger">{{ $message }}</small> @enderror
</div>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="price">Price</label>
        <input id="price" class="form-control" type="number" step="0.01" name="price" value="{{ old('price', $product->price ?? '0.00') }}" required>
        @error('price') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
    <div class="form-group col-md-6">
        @if(isset($product))
            <label>Current Stock</label>
            <div class="form-control-plaintext"><strong>{{ $product->stock }}</strong></div>
        @else
            <label for="stock">Initial Stock</label>
            <input id="stock" class="form-control" type="number" name="stock" value="{{ old('stock', 0) }}">
        @endif
    </div>
</div>
@if(isset($product))
    <div class="form-group">
        <label for="adjust_quantity">Adjust Quantity</label>
        <div class="input-group">
            <input id="adjust_quantity" class="form-control" type="number" name="adjust_quantity" value="0">
            <div class="input-group-append">
                <select name="adjust_type" class="custom-select">
                    <option value="in">Add (in)</option>
                    <option value="out">Remove (out)</option>
                    <option value="adjustment">Adjustment</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="adjust_note">Note</label>
        <input id="adjust_note" class="form-control" type="text" name="adjust_note" value="">
    </div>
@endif
