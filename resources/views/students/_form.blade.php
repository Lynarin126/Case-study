@csrf

<div class="form-group">
    <label for="student_code">កូដនិស្សិត</label>
    <input type="text"
        id="student_code"
        class="form-control"
        value="{{ $student->student_code ?? $studentCode ?? '' }}"
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
            value="{{ old('first_name', $student->first_name ?? '') }}"
            placeholder="ឧ. ពិសិដ្ឋ"
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
            value="{{ old('last_name', $student->last_name ?? '') }}"
            placeholder="ឧ. ហេង"
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
            value="{{ old('first_name_latin', $student->first_name_latin ?? '') }}"
            placeholder="e.g. Piseth"
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
            value="{{ old('last_name_latin', $student->last_name_latin ?? '') }}"
            placeholder="e.g. Heng"
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
            <option value="Male" {{ old('gender', $student->gender ?? '') == 'Male' ? 'selected' : '' }}>ប្រុស</option>
            <option value="Female" {{ old('gender', $student->gender ?? '') == 'Female' ? 'selected' : '' }}>ស្រី</option>
        </select>
        @error('gender')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    
    <div class="col-md-6 form-group">
        <label for="date_of_birth">ថ្ងៃខែឆ្នាំកំណើត</label>
        <input type="date"
            name="date_of_birth"
            id="date_of_birth"
            class="form-control @error('date_of_birth') is-invalid @enderror"
            value="{{ old('date_of_birth', $student->date_of_birth ?? '') }}">
        @error('date_of_birth')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 form-group">
        <label for="phone">លេខទូរស័ព្ទ</label>
        <input type="text"
            name="phone"
            id="phone"
            class="form-control @error('phone') is-invalid @enderror"
            value="{{ old('phone', $student->phone ?? '') }}"
            maxlength="30">
        @error('phone')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-md-6 form-group">
        <label for="email">អ៊ីមែល</label>
        <input type="email"
            name="email"
            id="email"
            class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $student->email ?? '') }}"
            maxlength="150">
        @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-12 form-group">
        <label for="status">ស្ថានភាព</label>
        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
            <option value="active" {{ old('status', $student->status ?? '') == 'active' ? 'selected' : '' }}>សកម្ម</option>
            <option value="inactive" {{ old('status', $student->status ?? '') == 'inactive' ? 'selected' : '' }}>ផ្អាក</option>
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
        rows="3">{{ old('address', $student->address ?? '') }}</textarea>
    @error('address')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="d-flex justify-content-end mt-4">
    <a href="{{ route('students.index') }}" class="btn btn-secondary mr-2">
        <i class="fas fa-arrow-left mr-1"></i>
        ត្រឡប់ក្រោយ
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save mr-1"></i>
        រក្សាទុក
    </button>
</div>
