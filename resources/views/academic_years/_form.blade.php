@csrf

<div class="form-group">
    <label for="year_name">ឈ្មោះឆ្នាំសិក្សា</label>
    <input type="text"
        name="year_name"
        id="year_name"
        class="form-control @error('year_name') is-invalid @enderror"
        value="{{ old('year_name', $academicYear->year_name ?? '') }}"
        required>
    @error('year_name')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="row">
    <div class="col-md-6 form-group">
        <label for="start_date">ថ្ងៃចាប់ផ្តើម</label>
        <input type="date"
            name="start_date"
            id="start_date"
            class="form-control @error('start_date') is-invalid @enderror"
            value="{{ old('start_date', $academicYear->start_date ?? '') }}">
        @error('start_date')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-md-6 form-group">
        <label for="end_date">ថ្ងៃបញ្ចប់</label>
        <input type="date"
            name="end_date"
            id="end_date"
            class="form-control @error('end_date') is-invalid @enderror"
            value="{{ old('end_date', $academicYear->end_date ?? '') }}">
        @error('end_date')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="form-group form-check">
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox"
        name="is_active"
        id="is_active"
        class="form-check-input"
        value="1"
        {{ old('is_active', $academicYear->is_active ?? false) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">សកម្ម</label>
</div>

<div class="d-flex justify-content-end">
    <a href="{{ route('academic-years.index') }}" class="btn btn-secondary mr-2">
        <i class="fas fa-arrow-left mr-1"></i>
        ត្រឡប់ក្រោយ
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save mr-1"></i>
        រក្សាទុក
    </button>
</div>
