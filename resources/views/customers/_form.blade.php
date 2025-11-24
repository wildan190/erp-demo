<div class="form-group">
    <label for="name">Name</label>
    <input id="name" class="form-control" type="text" name="name" value="{{ old('name', $customer->name ?? '') }}" required>
    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
</div>
<div class="form-group">
    <label for="email">Email</label>
    <input id="email" class="form-control" type="email" name="email" value="{{ old('email', $customer->email ?? '') }}">
    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
</div>
<div class="form-group">
    <label for="phone">Phone</label>
    <input id="phone" class="form-control" type="text" name="phone" value="{{ old('phone', $customer->phone ?? '') }}">
    @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
</div>
<div class="form-group">
    <label for="address">Address</label>
    <textarea id="address" class="form-control" name="address">{{ old('address', $customer->address ?? '') }}</textarea>
    @error('address') <small class="text-danger">{{ $message }}</small> @enderror
</div>
