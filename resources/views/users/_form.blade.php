@csrf

<div class="form-group">
    <label for="name">ឈ្មោះ</label>
    <input type="text"
        name="name"
        id="name"
        class="form-control @error('name') is-invalid @enderror"
        value="{{ old('name', $user->name ?? '') }}"
        required>
    @error('name')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <label for="email">អ៊ីមែល</label>
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
    <label for="password">ពាក្យសម្ងាត់ @isset($user) <small>(ទុកឲ្យនៅទទេបើមិនចង់ដូរ)</small> @endisset</label>
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

<div class="d-flex justify-content-end">
    <a href="{{ route('users.index') }}" class="btn btn-secondary mr-2">
        <i class="fas fa-arrow-left mr-1"></i>
        ត្រឡប់ក្រោយ
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save mr-1"></i>
        រក្សាទុក
    </button>
</div>
