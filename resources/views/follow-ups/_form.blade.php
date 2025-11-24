<div class="form-group">
    <label for="type">Type</label>
    <input id="type" class="form-control" type="text" name="type" value="{{ old('type', (isset($followUp) ? $followUp->type : '') ?? '') }}" required>
    @error('type') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label for="notes">Notes</label>
    <textarea id="notes" class="form-control" name="notes">{{ old('notes', (isset($followUp) ? $followUp->notes : '') ?? '') }}</textarea>
    @error('notes') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label for="scheduled_date">Scheduled Date</label>
    <input id="scheduled_date" class="form-control" type="date" name="scheduled_date" value="{{ old('scheduled_date', (isset($followUp) && $followUp->scheduled_date ? $followUp->scheduled_date->format('Y-m-d') : '') ?? '') }}" required>
    @error('scheduled_date') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="form-group form-check">
    <input type="checkbox" class="form-check-input" id="is_completed" name="is_completed" value="1" {{ old('is_completed', (isset($followUp) ? $followUp->is_completed : false)) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_completed">Completed</label>
    @error('is_completed') <small class="text-danger">{{ $message }}</small> @enderror
</div>
