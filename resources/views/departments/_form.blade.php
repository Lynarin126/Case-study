@csrf

<div class="form-group">
    <label for="department_code">កូដដេប៉ាតឺម៉ង់</label>
    <input type="text"
        id="department_code"
        class="form-control"
        value="{{ $department->department_code ?? $departmentCode ?? '' }}"
        readonly>
    <small class="form-text text-muted">កូដនេះបង្កើតដោយស្វ័យប្រវត្តិ។</small>
</div>

<div class="form-group">
    <label for="department_name">ឈ្មោះដេប៉ាតឺម៉ង់</label>
    <input type="text"
        name="department_name"
        id="department_name"
        class="form-control @error('department_name') is-invalid @enderror"
        value="{{ old('department_name', $department->department_name ?? '') }}"
        maxlength="150"
        required>
    @error('department_name')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <label for="faculty_id">មហាវិទ្យាល័យ</label>
    <select name="faculty_id" id="faculty_id" class="form-control select2bs4 @error('faculty_id') is-invalid @enderror">
        <option value="">ជ្រើសរើសមហាវិទ្យាល័យ</option>
        @foreach ($faculties as $faculty)
            <option value="{{ $faculty->faculty_id }}" @selected((string) old('faculty_id', $department->faculty_id ?? '') === (string) $faculty->faculty_id)>
                {{ $faculty->faculty_name }}
            </option>
        @endforeach
    </select>
    @error('faculty_id')
        <span class="invalid-feedback d-block">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <label for="deans">ប្រធានដេប៉ាតឺម៉ង់</label>
    <input type="text"
        name="deans"
        id="deans"
        class="form-control @error('deans') is-invalid @enderror"
        value="{{ old('deans', $department->deans ?? '') }}"
        maxlength="255">
    @error('deans')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="d-flex justify-content-end">
    <a href="{{ route('departments.index') }}" class="btn btn-secondary mr-2">
        <i class="fas fa-arrow-left mr-1"></i>
        ត្រឡប់ក្រោយ
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save mr-1"></i>
        រក្សាទុក
    </button>
</div>
