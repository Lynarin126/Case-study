@csrf

<div class="form-group">
    <label for="faculty_code">កូដមហាវិទ្យាល័យ</label>
    <input type="text"
        id="faculty_code"
        class="form-control"
        value="{{ $faculty->faculty_code ?? $facultyCode ?? '' }}"
        readonly>
    <small class="form-text text-muted">កូដនេះបង្កើតដោយស្វ័យប្រវត្តិ។</small>
</div>

<div class="form-group">
    <label for="faculty_name">ឈ្មោះមហាវិទ្យាល័យ</label>
    <input type="text"
        name="faculty_name"
        id="faculty_name"
        class="form-control @error('faculty_name') is-invalid @enderror"
        value="{{ old('faculty_name', $faculty->faculty_name ?? '') }}"
        maxlength="150"
        required>
    @error('faculty_name')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="d-flex justify-content-end">
    <a href="{{ route('faculties.index') }}" class="btn btn-secondary mr-2">
        <i class="fas fa-arrow-left mr-1"></i>
        ត្រឡប់ក្រោយ
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save mr-1"></i>
        រក្សាទុក
    </button>
</div>
