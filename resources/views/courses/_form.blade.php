@csrf

<div class="form-group">
    <label for="course_code">កូដវគ្គសិក្សា</label>
    <input type="text"
        id="course_code"
        class="form-control"
        value="{{ $course->course_code ?? $courseCode ?? '' }}"
        readonly>
    <small class="form-text text-muted">កូដនេះបង្កើតដោយស្វ័យប្រវត្តិ។</small>
</div>

<div class="form-group">
    <label for="course_name">ឈ្មោះវគ្គសិក្សា</label>
    <input type="text"
        name="course_name"
        id="course_name"
        class="form-control @error('course_name') is-invalid @enderror"
        value="{{ old('course_name', $course->course_name ?? '') }}"
        maxlength="150"
        required>
    @error('course_name')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="row">
    <div class="col-md-6 form-group">
        <label for="course_category_id">ប្រភេទវគ្គសិក្សា <span class="text-danger">*</span></label>
        <select name="course_category_id" id="course_category_id" class="form-control select2bs4 @error('course_category_id') is-invalid @enderror" required>
            <option value="">-- ជ្រើសរើសប្រភេទវគ្គសិក្សា --</option>
            @foreach ($courseCategories as $category)
                <option value="{{ $category->course_category_id }}" @selected((string) old('course_category_id', $course->course_category_id ?? '') === (string) $category->course_category_id)>
                    {{ $category->category_name }}
                </option>
            @endforeach
        </select>
        @error('course_category_id')
            <span class="invalid-feedback d-block">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-md-6 form-group">
        <label for="department_id">ដេប៉ាតឺម៉ង់ (Department)</label>
        <select name="department_id" id="department_id" class="form-control select2bs4 @error('department_id') is-invalid @enderror">
            <option value="">-- ជ្រើសរើសដេប៉ាតឺម៉ង់ --</option>
            @foreach ($departments ?? [] as $department)
                <option value="{{ $department->department_id }}" @selected((string) old('department_id', $course->department_id ?? '') === (string) $department->department_id)>
                    {{ $department->department_name }} ({{ $department->department_code }})
                </option>
            @endforeach
        </select>
        @error('department_id')
            <span class="invalid-feedback d-block">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="form-group">
    <label for="description">ការពិពណ៌នា</label>
    <textarea name="description"
        id="description"
        class="form-control @error('description') is-invalid @enderror"
        rows="4">{{ old('description', $course->description ?? '') }}</textarea>
    @error('description')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="d-flex justify-content-end">
    <a href="{{ route('courses.index') }}" class="btn btn-secondary mr-2">
        <i class="fas fa-arrow-left mr-1"></i>
        ត្រឡប់ក្រោយ
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save mr-1"></i>
        រក្សាទុក
    </button>
</div>
