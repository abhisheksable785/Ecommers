@csrf
<div class="form-group">
    <label>Code</label>
    <input type="text" name="code" value="{{ old('code', $coupon->code ?? '') }}" class="form-control" required>
</div>
<div class="form-group">
    <label>Type</label>
    <select name="type" class="form-control" required>
        <option value="fixed" {{ (old('type', $coupon->type ?? '') == 'fixed') ? 'selected' : '' }}>Fixed</option>
        <option value="percent" {{ (old('type', $coupon->type ?? '') == 'percent') ? 'selected' : '' }}>Percentage</option>
    </select>
</div>
<div class="form-group">
    <label>Value</label>
    <input type="number" name="value" value="{{ old('value', $coupon->value ?? '') }}" class="form-control" required>
</div>
<button type="submit" class="btn btn-primary">Save</button>
<a href="{{ route('coupons.index') }}" class="btn btn-secondary">Back</a>
