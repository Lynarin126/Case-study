@csrf

<div class="form-group">
    <label for="category_code">កូដប្រភេទវគ្គសិក្សា</label>
    <input type="text"
        id="category_code"
        class="form-control"
        value="{{ $courseCategory->category_code ?? $categoryCode ?? '' }}"
        readonly>
    <small class="form-text text-muted">កូដនេះបង្កើតដោយស្វ័យប្រវត្តិ។</small>
</div>

<div class="form-group">
    <label for="category_name">ឈ្មោះប្រភេទវគ្គសិក្សា</label>
    <input type="text"
        name="category_name"
        id="category_name"
        class="form-control @error('category_name') is-invalid @enderror"
        value="{{ old('category_name', $courseCategory->category_name ?? '') }}"
        maxlength="150"
        required>
    @error('category_name')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <label for="description">ការពិពណ៌នា</label>
    <textarea name="description"
        id="description"
        class="form-control @error('description') is-invalid @enderror"
        rows="4">{{ old('description', $courseCategory->description ?? '') }}</textarea>
    @error('description')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="d-flex justify-content-end">
    <a href="{{ route('course-categories.index') }}" class="btn btn-secondary mr-2">
        <i class="fas fa-arrow-left mr-1"></i>
        ត្រឡប់ក្រោយ
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save mr-1"></i>
        រក្សាទុក
    </button>
</div>
