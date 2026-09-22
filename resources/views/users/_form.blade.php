@csrf

<style>
    /* =========================================================
       User / Student Form
       School LMS Premium Green UI
       UI ONLY — Backend & Functionality unchanged
    ========================================================= */

    .user-form {
        --primary: #2e8b57;
        --primary-dark: #256f46;
        --primary-soft: #edf8f1;
        --border: #e2e9e5;
        --text: #26352c;
        --muted: #748078;
        --soft-bg: #f8faf9;
    }

    /* Section */
    .user-form .form-section {
        margin-bottom: 1.5rem;
    }

    .user-form .form-section:last-child {
        margin-bottom: 0;
    }

    /* Section heading */
    .user-form .form-section-title {
        display: flex;
        align-items: center;
        gap: .65rem;
        margin-bottom: 1.2rem;
        padding-bottom: .75rem;
        border-bottom: 1px solid #edf1ee;
    }

    .user-form .form-section-title .icon {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        background: var(--primary-soft);
        color: var(--primary);
        font-size: .85rem;
    }

    .user-form .form-section-title h6 {
        margin: 0;
        color: var(--text);
        font-size: .92rem;
        font-weight: 700;
    }

    .user-form .form-section-title small {
        display: block;
        margin-top: 2px;
        color: var(--muted);
        font-size: .74rem;
        font-weight: 400;
    }

    /* Labels */
    .user-form label {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: .45rem;
        color: var(--text);
        font-size: .88rem;
        font-weight: 600;
    }

    .user-form label small {
        margin-left: .35rem;
        font-weight: 400;
    }

    .user-form .required-mark {
        color: #dc3545;
        margin-left: 3px;
    }

    /* Inputs */
    .user-form .form-control {
        min-height: 44px;
        padding: .65rem .85rem;
        border: 1px solid var(--border);
        border-radius: 9px;
        background: #fff;
        color: var(--text);
        font-size: .9rem;
        box-shadow: none;
        transition:
            border-color .18s ease,
            box-shadow .18s ease,
            background-color .18s ease;
    }

    .user-form .form-control::placeholder {
        color: #a1aaa5;
    }

    .user-form .form-control:focus {
        border-color: var(--primary);
        background: #fff;
        box-shadow: 0 0 0 3px rgba(46, 139, 87, .10);
    }

    /* Password inputs */
    .user-form input[type="password"] {
        letter-spacing: .04em;
    }

    /* Optional helper */
    .user-form .field-hint {
        margin-top: .4rem;
        color: var(--muted);
        font-size: .77rem;
    }

    /* Divider */
    .user-form .form-divider {
        height: 1px;
        margin: 1.5rem 0;
        background: #edf1ee;
        border: 0;
    }

    /* Validation */
    .user-form .form-control.is-invalid {
        border-color: #dc3545;
    }

    .user-form .form-control.is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(220, 53, 69, .08);
    }

    .user-form .invalid-feedback {
        margin-top: .4rem;
        font-size: .78rem;
    }

    /* Actions */
    .user-form .form-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: .65rem;
        padding-top: 1.25rem;
        margin-top: .5rem;
        border-top: 1px solid #edf1ee;
    }

    .user-form .btn {
        min-height: 42px;
        padding: .55rem 1rem;
        border-radius: 8px;
        font-size: .86rem;
        font-weight: 600;
        transition:
            transform .15s ease,
            box-shadow .15s ease,
            background-color .15s ease;
    }

    .user-form .btn:hover {
        transform: translateY(-1px);
    }

    /* Back */
    .user-form .btn-secondary {
        background: #f1f4f2;
        border-color: #e1e7e3;
        color: #526158;
    }

    .user-form .btn-secondary:hover {
        background: #e7ece9;
        border-color: #d8e0db;
        color: #35433b;
    }

    /* Save */
    .user-form .btn-primary {
        background: var(--primary);
        border-color: var(--primary);
        box-shadow: 0 3px 8px rgba(46, 139, 87, .16);
    }

    .user-form .btn-primary:hover {
        background: var(--primary-dark);
        border-color: var(--primary-dark);
        box-shadow: 0 5px 12px rgba(46, 139, 87, .20);
    }

    /* Mobile */
    @media (max-width: 575.98px) {

        .user-form .form-actions {
            flex-direction: column-reverse;
            align-items: stretch;
        }

        .user-form .form-actions .btn {
            width: 100%;
        }

        .user-form .form-control {
            min-height: 42px;
        }
    }
</style>


<div class="user-form">

    {{-- =====================================================
         Personal Information
    ====================================================== --}}
    <div class="form-section">

        <div class="form-section-title">
            <span class="icon">
                <i class="fas fa-user"></i>
            </span>

            <div>
                <h6>ព័ត៌មានផ្ទាល់ខ្លួន</h6>
                <small>Personal Information</small>
            </div>
        </div>


        {{-- Khmer Name --}}
        <div class="row">

            {{-- First Name --}}
            <div class="col-md-6 form-group">

                <label for="first_name">
                    នាមខ្លួន (First Name)
                    <span class="required-mark">*</span>
                </label>

                <input
                    type="text"
                    name="first_name"
                    id="first_name"
                    class="form-control @error('first_name') is-invalid @enderror"
                    value="{{ old('first_name', $user->first_name ?? '') }}"
                    placeholder="ឧ. វណ្ណៈ"
                    maxlength="100"
                    required
                >

                @error('first_name')
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                @enderror

            </div>


            {{-- Last Name --}}
            <div class="col-md-6 form-group">

                <label for="last_name">
                    នាមត្រកូល (Last Name)
                </label>

                <input
                    type="text"
                    name="last_name"
                    id="last_name"
                    class="form-control @error('last_name') is-invalid @enderror"
                    value="{{ old('last_name', $user->last_name ?? '') }}"
                    placeholder="ឧ. សុខ"
                    maxlength="100"
                >

                @error('last_name')
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                @enderror

            </div>

        </div>


        {{-- Latin Name --}}
        <div class="row">

            {{-- First Name Latin --}}
            <div class="col-md-6 form-group">

                <label for="first_name_latin">
                    First Name (Latin)
                    <span class="required-mark">*</span>
                </label>

                <input
                    type="text"
                    name="first_name_latin"
                    id="first_name_latin"
                    class="form-control @error('first_name_latin') is-invalid @enderror"
                    value="{{ old('first_name_latin', $user->first_name_latin ?? '') }}"
                    placeholder="e.g. Vannak"
                    maxlength="100"
                    required
                >

                @error('first_name_latin')
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                @enderror

            </div>


            {{-- Last Name Latin --}}
            <div class="col-md-6 form-group">

                <label for="last_name_latin">
                    Last Name (Latin)
                </label>

                <input
                    type="text"
                    name="last_name_latin"
                    id="last_name_latin"
                    class="form-control @error('last_name_latin') is-invalid @enderror"
                    value="{{ old('last_name_latin', $user->last_name_latin ?? '') }}"
                    placeholder="e.g. Sok"
                    maxlength="100"
                >

                @error('last_name_latin')
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                @enderror

            </div>

        </div>

    </div>


    {{-- =====================================================
         Account Information
    ====================================================== --}}
    <div class="form-section">

        <div class="form-section-title">
            <span class="icon">
                <i class="fas fa-user-shield"></i>
            </span>

            <div>
                <h6>ព័ត៌មានគណនី</h6>
                <small>Account Information</small>
            </div>
        </div>


        {{-- Email --}}
        <div class="form-group">

            <label for="email">
                អ៊ីមែល
                <span class="required-mark">*</span>
            </label>

            <input
                type="email"
                name="email"
                id="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', $user->email ?? '') }}"
                placeholder="example@email.com"
                required
            >

            @error('email')
                <span class="invalid-feedback">
                    {{ $message }}
                </span>
            @enderror

        </div>


        {{-- Password --}}
        <div class="form-group">

            <label for="password">
                ពាក្យសម្ងាត់

                @isset($user)
                    <small class="text-muted">
                        (ទុកឲ្យនៅទទេបើមិនចង់ដូរ)
                    </small>
                @endisset
            </label>

            <input
                type="password"
                name="password"
                id="password"
                class="form-control @error('password') is-invalid @enderror"
                @empty($user) required @endempty
                placeholder="បញ្ចូលពាក្យសម្ងាត់"
            >

            @error('password')
                <span class="invalid-feedback">
                    {{ $message }}
                </span>
            @enderror

        </div>


        {{-- Confirm Password --}}
        <div class="form-group mb-0">

            <label for="password_confirmation">
                បញ្ជាក់ពាក្យសម្ងាត់
            </label>

            <input
                type="password"
                name="password_confirmation"
                id="password_confirmation"
                class="form-control"
                @empty($user) required @endempty
                placeholder="បញ្ចូលពាក្យសម្ងាត់ម្ដងទៀត"
            >

        </div>

    </div>


    {{-- =====================================================
         Form Actions
    ====================================================== --}}
    <div class="form-actions">

        <a
            href="{{ route('users.index') }}"
            class="btn btn-secondary"
        >
            <i class="fas fa-arrow-left mr-1"></i>
            ត្រឡប់ក្រោយ
        </a>

        <button
            type="submit"
            class="btn btn-primary"
        >
            <i class="fas fa-save mr-1"></i>
            រក្សាទុក
        </button>

    </div>

</div>