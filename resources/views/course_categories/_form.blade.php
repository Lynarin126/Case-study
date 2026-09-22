@csrf

<style>
    /* =========================================================
       Course Category Form
       School LMS Premium Green UI
       UI ONLY — Backend & Functionality unchanged
    ========================================================= */

    .category-form {
        --primary: #2e8b57;
        --primary-dark: #256f46;
        --primary-soft: #edf8f1;
        --border: #e2e9e5;
        --text: #26352c;
        --muted: #748078;
        --surface: #ffffff;
        --soft-bg: #f8faf9;
    }

    /* Section */
    .category-form .form-section {
        margin-bottom: 1.5rem;
    }

    .category-form .form-section:last-child {
        margin-bottom: 0;
    }

    /* Section heading */
    .category-form .form-section-title {
        display: flex;
        align-items: center;
        gap: .65rem;
        margin-bottom: 1.2rem;
        padding-bottom: .75rem;
        border-bottom: 1px solid #edf1ee;
    }

    .category-form .form-section-title .icon {
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

    .category-form .form-section-title h6 {
        margin: 0;
        color: var(--text);
        font-size: .92rem;
        font-weight: 700;
    }

    /* Labels */
    .category-form label {
        display: flex;
        align-items: center;
        margin-bottom: .45rem;
        color: var(--text);
        font-size: .88rem;
        font-weight: 600;
    }

    .category-form .required-mark {
        color: #dc3545;
        margin-left: 3px;
    }

    /* Inputs */
    .category-form .form-control {
        min-height: 44px;
        padding: .65rem .85rem;
        border: 1px solid var(--border);
        border-radius: 9px;
        background: var(--surface);
        color: var(--text);
        font-size: .9rem;
        box-shadow: none;
        transition:
            border-color .18s ease,
            box-shadow .18s ease,
            background-color .18s ease;
    }

    .category-form .form-control::placeholder {
        color: #a1aaa5;
    }

    .category-form .form-control:focus {
        border-color: var(--primary);
        background: #fff;
        box-shadow: 0 0 0 3px rgba(46, 139, 87, .10);
    }

    /* Readonly code */
    .category-form .code-wrapper {
        position: relative;
    }

    .category-form .code-wrapper .form-control {
        padding-right: 42px;
        background: var(--soft-bg);
        color: #526158;
        font-weight: 600;
        letter-spacing: .02em;
    }

    .category-form .code-icon {
        position: absolute;
        top: 50%;
        right: 14px;
        transform: translateY(-50%);
        color: var(--primary);
        pointer-events: none;
    }

    /* Help text */
    .category-form .form-text {
        margin-top: .4rem;
        color: var(--muted) !important;
        font-size: .78rem;
    }

    /* Description */
    .category-form textarea.form-control {
        min-height: 120px;
        resize: vertical;
        line-height: 1.6;
    }

    /* Validation */
    .category-form .form-control.is-invalid {
        border-color: #dc3545;
    }

    .category-form .form-control.is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(220, 53, 69, .08);
    }

    .category-form .invalid-feedback {
        margin-top: .4rem;
        font-size: .78rem;
    }

    /* Actions */
    .category-form .form-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: .65rem;
        padding-top: 1.25rem;
        margin-top: .5rem;
        border-top: 1px solid #edf1ee;
    }

    .category-form .btn {
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

    .category-form .btn:hover {
        transform: translateY(-1px);
    }

    /* Back */
    .category-form .btn-secondary {
        background: #f1f4f2;
        border-color: #e1e7e3;
        color: #526158;
    }

    .category-form .btn-secondary:hover {
        background: #e7ece9;
        border-color: #d8e0db;
        color: #35433b;
    }

    /* Save */
    .category-form .btn-primary {
        background: var(--primary);
        border-color: var(--primary);
        box-shadow: 0 3px 8px rgba(46, 139, 87, .16);
    }

    .category-form .btn-primary:hover {
        background: var(--primary-dark);
        border-color: var(--primary-dark);
        box-shadow: 0 5px 12px rgba(46, 139, 87, .20);
    }

    /* Mobile */
    @media (max-width: 575.98px) {

        .category-form .form-actions {
            flex-direction: column-reverse;
            align-items: stretch;
        }

        .category-form .form-actions .btn {
            width: 100%;
        }

        .category-form .form-control {
            min-height: 42px;
        }
    }
</style>


<div class="category-form">

    {{-- =====================================================
         Category Information
    ====================================================== --}}
    <div class="form-section">

        <div class="form-section-title">
            <span class="icon">
                <i class="fas fa-layer-group"></i>
            </span>

            <h6>ព័ត៌មានប្រភេទវគ្គសិក្សា</h6>
        </div>


        {{-- Category Code --}}
        <div class="form-group">

            <label for="category_code">
                កូដប្រភេទវគ្គសិក្សា
            </label>

            <div class="code-wrapper">

                <input
                    type="text"
                    id="category_code"
                    class="form-control"
                    value="{{ $courseCategory->category_code ?? $categoryCode ?? '' }}"
                    readonly
                >

                <span class="code-icon">
                    <i class="fas fa-lock"></i>
                </span>

            </div>

            <small class="form-text">
                <i class="fas fa-info-circle mr-1"></i>
                កូដនេះបង្កើតដោយស្វ័យប្រវត្តិ។
            </small>

        </div>


        {{-- Category Name --}}
        <div class="form-group">

            <label for="category_name">
                ឈ្មោះប្រភេទវគ្គសិក្សា
                <span class="required-mark">*</span>
            </label>

            <input
                type="text"
                name="category_name"
                id="category_name"
                class="form-control @error('category_name') is-invalid @enderror"
                value="{{ old('category_name', $courseCategory->category_name ?? '') }}"
                maxlength="150"
                required
                placeholder="បញ្ចូលឈ្មោះប្រភេទវគ្គសិក្សា"
            >

            @error('category_name')
                <span class="invalid-feedback">
                    {{ $message }}
                </span>
            @enderror

        </div>


        {{-- Description --}}
        <div class="form-group mb-0">

            <label for="description">
                ការពិពណ៌នា
            </label>

            <textarea
                name="description"
                id="description"
                class="form-control @error('description') is-invalid @enderror"
                rows="4"
                placeholder="បញ្ចូលការពិពណ៌នាអំពីប្រភេទវគ្គសិក្សា..."
            >{{ old('description', $courseCategory->description ?? '') }}</textarea>

            @error('description')
                <span class="invalid-feedback">
                    {{ $message }}
                </span>
            @enderror

        </div>

    </div>


    {{-- =====================================================
         Form Actions
    ====================================================== --}}
    <div class="form-actions">

        <a
            href="{{ route('course-categories.index') }}"
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