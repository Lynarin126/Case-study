@csrf

<div class="row">
    <div class="col-md-6 form-group">
        <label for="first_name">នាមខ្លួន (First Name) <span class="text-danger">*</span></label>
        <input type="text"
            name="first_name"
            id="first_name"
            class="form-control @error('first_name') is-invalid @enderror"
            value="{{ old('first_name', $user->first_name ?? '') }}"
            placeholder="ឧ. វណ្ណៈ"
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
            value="{{ old('last_name', $user->last_name ?? '') }}"
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
            value="{{ old('first_name_latin', $user->first_name_latin ?? '') }}"
            placeholder="e.g. Vannak"
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
            value="{{ old('last_name_latin', $user->last_name_latin ?? '') }}"
            placeholder="e.g. Sok"
            maxlength="100">
        @error('last_name_latin')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>

<hr class="my-4">

<div class="form-group">
    <label for="email">អ៊ីមែល <span class="text-danger">*</span></label>
    <input type="email"
        name="email"
        id="email"
        class="form-control @error('email') is-invalid @enderror"
        value="{{ old('email', $user->email ?? '') }}"
        required>
    @error('email')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <label for="password">ពាក្យសម្ងាត់ @isset($user) <small class="text-muted">(ទុកឲ្យនៅទទេបើមិនចង់ដូរ)</small> @endisset</label>
    <input type="password"
        name="password"
        id="password"
        class="form-control @error('password') is-invalid @enderror"
        @empty($user) required @endempty>
    @error('password')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <label for="password_confirmation">បញ្ជាក់ពាក្យសម្ងាត់</label>
    <input type="password"
        name="password_confirmation"
        id="password_confirmation"
        class="form-control"
        @empty($user) required @endempty>
</div>

<div class="d-flex justify-content-end mt-4">
    <a href="{{ route('users.index') }}" class="btn btn-secondary mr-2">
        <i class="fas fa-arrow-left mr-1"></i>
        ត្រឡប់ក្រោយ
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save mr-1"></i>
        រក្សាទុក
    </button>
</div>
