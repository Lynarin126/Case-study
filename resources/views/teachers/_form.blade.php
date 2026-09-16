@csrf

<div class="form-group">
    <label for="teacher_code">កូដគ្រូបង្រៀន</label>
    <input type="text"
        id="teacher_code"
        class="form-control"
        value="{{ $teacher->teacher_code ?? $teacherCode ?? '' }}"
        readonly>
    <small class="form-text text-muted">កូដនេះបង្កើតដោយស្វ័យប្រវត្តិ។</small>
</div>

<div class="row">
    <div class="col-md-6 form-group">
        <label for="first_name">នាមខ្លួន (First Name) <span class="text-danger">*</span></label>
        <input type="text"
            name="first_name"
            id="first_name"
            class="form-control @error('first_name') is-invalid @enderror"
            value="{{ old('first_name', $teacher->first_name ?? '') }}"
            placeholder="ឧ. សុវណ្ណ"
            maxlength="100"
            required>
        @error('first_name')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    
    <div class="col-md-6 form-group">
        <label for="last_name">នាមត្រកូល (Last Name)</label>
        <input type="text"
            name="last_name"
            id="last_name"
            class="form-control @error('last_name') is-invalid @enderror"
            value="{{ old('last_name', $teacher->last_name ?? '') }}"
            placeholder="ឧ. សុខ"
            maxlength="100">
        @error('last_name')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 form-group">
        <label for="first_name_latin">First Name (Latin) <span class="text-danger">*</span></label>
        <input type="text"
            name="first_name_latin"
            id="first_name_latin"
            class="form-control @error('first_name_latin') is-invalid @enderror"
            value="{{ old('first_name_latin', $teacher->first_name_latin ?? '') }}"
            placeholder="e.g. Sovann"
            maxlength="100"
            required>
        @error('first_name_latin')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    
    <div class="col-md-6 form-group">
        <label for="last_name_latin">Last Name (Latin)</label>
        <input type="text"
            name="last_name_latin"
            id="last_name_latin"
            class="form-control @error('last_name_latin') is-invalid @enderror"
            value="{{ old('last_name_latin', $teacher->last_name_latin ?? '') }}"
            placeholder="e.g. Sok"
            maxlength="100">
        @error('last_name_latin')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>

<hr class="my-4">

<div class="row">
    <div class="col-md-6 form-group">
        <label for="gender">ភេទ</label>
        <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror">
            <option value="">-- ជ្រើសរើសភេទ --</option>
            <option value="Male" {{ old('gender', $teacher->gender ?? '') == 'Male' ? 'selected' : '' }}>ប្រុស</option>
            <option value="Female" {{ old('gender', $teacher->gender ?? '') == 'Female' ? 'selected' : '' }}>ស្រី</option>
        </select>
        @error('gender')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    
    <div class="col-md-6 form-group">
        <label for="phone">លេខទូរស័ព្ទ</label>
        <input type="text"
            name="phone"
            id="phone"
            class="form-control @error('phone') is-invalid @enderror"
            value="{{ old('phone', $teacher->phone ?? '') }}"
            maxlength="30">
        @error('phone')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 form-group">
        <label for="email">អ៊ីមែល</label>
        <input type="email"
            name="email"
            id="email"
            class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $teacher->email ?? '') }}"
            maxlength="150">
        @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    
    <div class="col-md-6 form-group">
        <label for="specialization">ជំនាញ</label>
        <input type="text"
            name="specialization"
            id="specialization"
            class="form-control @error('specialization') is-invalid @enderror"
            value="{{ old('specialization', $teacher->specialization ?? '') }}"
            maxlength="150">
        @error('specialization')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 form-group">
        <label for="hire_date">ថ្ងៃចូលធ្វើការ</label>
        <input type="date"
            name="hire_date"
            id="hire_date"
            class="form-control @error('hire_date') is-invalid @enderror"
            value="{{ old('hire_date', $teacher->hire_date ?? '') }}">
        @error('hire_date')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-md-6 form-group">
        <label for="status">ស្ថានភាព</label>
        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
            <option value="active" {{ old('status', $teacher->status ?? '') == 'active' ? 'selected' : '' }}>សកម្ម</option>
            <option value="inactive" {{ old('status', $teacher->status ?? '') == 'inactive' ? 'selected' : '' }}>ផ្អាក</option>
        </select>
        @error('status')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="form-group">
    <label for="address">អាសយដ្ឋាន</label>
    <textarea name="address"
        id="address"
        class="form-control @error('address') is-invalid @enderror"
        rows="3">{{ old('address', $teacher->address ?? '') }}</textarea>
    @error('address')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="d-flex justify-content-end mt-4">
    <a href="{{ route('teachers.index') }}" class="btn btn-secondary mr-2">
        <i class="fas fa-arrow-left mr-1"></i>
        ត្រឡប់ក្រោយ
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save mr-1"></i>
        រក្សាទុក
    </button>
</div>
