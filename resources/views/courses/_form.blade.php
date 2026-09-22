@csrf

<style>
    /* =========================================================
       Course Form - School LMS Premium UI
       UI ONLY - No backend/functionality changes
    ========================================================= */

    .course-form {
        --course-primary: #2e8b57;
        --course-primary-dark: #256f46;
        --course-primary-soft: #edf8f1;
        --course-border: #e3e9e5;
        --course-text: #26352c;
        --course-muted: #718078;
        --course-bg: #f8faf9;
    }

    .course-form .form-section {
        margin-bottom: 1.5rem;
    }

    .course-form .form-section:last-child {
        margin-bottom: 0;
    }

    /* Labels */
    .course-form label {
        display: flex;
        align-items: center;
        gap: 4px;
        margin-bottom: .45rem;
        color: var(--course-text);
        font-size: .88rem;
        font-weight: 600;
    }

    .course-form label .text-danger {
        font-size: .9rem;
    }

    /* Inputs */
    .course-form .form-control {
        min-height: 44px;
        border: 1px solid var(--course-border);
        border-radius: 9px;
        background: #fff;
        color: var(--course-text);
        font-size: .9rem;
        padding: .65rem .85rem;
        box-shadow: none;
        transition:
            border-color .18s ease,
            box-shadow .18s ease,
            background-color .18s ease;
    }

    .course-form textarea.form-control {
        min-height: 115px;
        resize: vertical;
        line-height: 1.6;
    }

    .course-form .form-control::placeholder {
        color: #a0aaa4;
    }

    .course-form .form-control:focus {
        border-color: var(--course-primary);
        background: #fff;
        box-shadow: 0 0 0 3px rgba(46, 139, 87, .10);
    }

    /* Readonly course code */
    .course-form .course-code-wrapper {
        position: relative;
    }

    .course-form .course-code-wrapper .form-control {
        padding-right: 42px;
        background: var(--course-bg);
        color: #526158;
        font-weight: 600;
        letter-spacing: .02em;
    }

    .course-form .course-code-icon {
        position: absolute;
        right: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--course-primary);
        pointer-events: none;
    }

    /* Help text */
    .course-form .form-text {
        margin-top: .4rem;
        color: var(--course-muted) !important;
        font-size: .78rem;
    }

    /* Select2 Bootstrap4 */
    .course-form .select2-container--bootstrap4 .select2-selection {
        min-height: 44px;
        border: 1px solid var(--course-border);
        border-radius: 9px;
        box-shadow: none;
        transition:
            border-color .18s ease,
            box-shadow .18s ease;
    }

    .course-form .select2-container--bootstrap4 .select2-selection--single {
        height: 44px;
        padding: .55rem .85rem;
    }

    .course-form .select2-container--bootstrap4
    .select2-selection--single
    .select2-selection__rendered {
        color: var(--course-text);
        font-size: .9rem;
        line-height: 30px;
    }

    .course-form .select2-container--bootstrap4
    .select2-selection--single
    .select2-selection__placeholder {
        color: #9aa59e;
    }

    .course-form .select2-container--bootstrap4
    .select2-selection--single
    .select2-selection__arrow {
        height: 42px;
        right: 7px;
    }

    .course-form .select2-container--bootstrap4.select2-container--focus
    .select2-selection {
        border-color: var(--course-primary);
        box-shadow: 0 0 0 3px rgba(46, 139, 87, .10);
    }

    /* Invalid */
    .course-form .form-control.is-invalid {
        border-color: #dc3545;
    }

    .course-form .form-control.is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(220, 53, 69, .08);
    }

    .course-form .select2-container--bootstrap4
    .select2-selection.is-invalid {
        border-color: #dc3545;
    }

    .course-form .invalid-feedback {
        margin-top: .4rem;
        font-size: .78rem;
    }

    /* Required marker */
    .course-form .required-mark {
        color: #dc3545;
        margin-left: 2px;
    }

    /* Form action area */
    .course-form .form-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: .65rem;
        padding-top: 1.25rem;
        margin-top: .5rem;
        border-top: 1px solid #edf1ee;
    }

    .course-form .btn {
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

    .course-form .btn:hover {
        transform: translateY(-1px);
    }

    .course-form .btn-secondary {
        background: #f1f4f2;
        border-color: #e1e7e3;
        color: #526158;
    }

    .course-form .btn-secondary:hover {
        background: #e7ece9;
        border-color: #d8e0db;
        color: #35433b;
    }

    .course-form .btn-primary {
        background: var(--course-primary);
        border-color: var(--course-primary);
        box-shadow: 0 3px 8px rgba(46, 139, 87, .16);
    }

    .course-form .btn-primary:hover {
        background: var(--course-primary-dark);
        border-color: var(--course-primary-dark);
        box-shadow: 0 5px 12px rgba(46, 139, 87, .20);
    }

    /* Section heading */
    .course-form .form-section-title {
        display: flex;
        align-items: center;
        gap: .65rem;
        margin-bottom: 1.1rem;
        padding-bottom: .7rem;
        border-bottom: 1px solid #edf1ee;
    }

    .course-form .form-section-title .icon {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: var(--course-primary-soft);
        color: var(--course-primary);
        font-size: .82rem;
    }

    .course-form .form-section-title h6 {
        margin: 0;
        color: var(--course-text);
        font-size: .9rem;
        font-weight: 700;
    }

    /* Mobile */
    @media (max-width: 575.98px) {
        .course-form .form-actions {
            flex-direction: column-reverse;
            align-items: stretch;
        }

        .course-form .form-actions .btn {
            width: 100%;
        }

        .course-form .form-control {
            min-height: 42px;
        }
    }
</style>

<div class="course-form">

    {{-- =====================================================
         Basic Course Information
    ====================================================== --}}
    <div class="form-section">

        <div class="form-section-title">
            <span class="icon">
                <i class="fas fa-book"></i>
            </span>

            <h6>ព័ត៌មានវគ្គសិក្សា</h6>
        </div>

        {{-- Course Code --}}
        <div class="form-group">
            <label for="course_code">
                កូដវគ្គសិក្សា
            </label>

            <div class="course-code-wrapper">
                <input
                    type="text"
                    id="course_code"
                    class="form-control"
                    value="{{ $course->course_code ?? $courseCode ?? '' }}"
                    readonly
                >

                <span class="course-code-icon">
                    <i class="fas fa-lock"></i>
                </span>
            </div>

            <small class="form-text">
                <i class="fas fa-info-circle mr-1"></i>
                កូដនេះបង្កើតដោយស្វ័យប្រវត្តិ។
            </small>
        </div>

        {{-- Course Name --}}
        <div class="form-group">
            <label for="course_name">
                ឈ្មោះវគ្គសិក្សា
                <span class="required-mark">*</span>
            </label>

            <input
                type="text"
                name="course_name"
                id="course_name"
                class="form-control @error('course_name') is-invalid @enderror"
                value="{{ old('course_name', $course->course_name ?? '') }}"
                maxlength="150"
                required
                placeholder="បញ្ចូលឈ្មោះវគ្គសិក្សា"
            >

            @error('course_name')
                <span class="invalid-feedback">
                    {{ $message }}
                </span>
            @enderror
        </div>

        {{-- Category + Department --}}
        <div class="row">

            {{-- Category --}}
            <div class="col-md-6 form-group">

                <label for="course_category_id">
                    ប្រភេទវគ្គសិក្សា
                    <span class="required-mark">*</span>
                </label>

                <select
                    name="course_category_id"
                    id="course_category_id"
                    class="form-control select2bs4 @error('course_category_id') is-invalid @enderror"
                    required
                >
                    <option value="">
                        -- ជ្រើសរើសប្រភេទវគ្គសិក្សា --
                    </option>

                    @foreach ($courseCategories as $category)
                        <option
                            value="{{ $category->course_category_id }}"
                            @selected(
                                (string) old(
                                    'course_category_id',
                                    $course->course_category_id ?? ''
                                ) === (string) $category->course_category_id
                            )
                        >
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>

                @error('course_category_id')
                    <span class="invalid-feedback d-block">
                        {{ $message }}
                    </span>
                @enderror

            </div>

            {{-- Department --}}
            <div class="col-md-6 form-group">

                <label for="department_id">
                    ដេប៉ាតឺម៉ង់ (Department)
                </label>

                <select
                    name="department_id"
                    id="department_id"
                    class="form-control select2bs4 @error('department_id') is-invalid @enderror"
                >
                    <option value="">
                        -- ជ្រើសរើសដេប៉ាតឺម៉ង់ --
                    </option>

                    @foreach ($departments ?? [] as $department)
                        <option
                            value="{{ $department->department_id }}"
                            @selected(
                                (string) old(
                                    'department_id',
                                    $course->department_id ?? ''
                                ) === (string) $department->department_id
                            )
                        >
                            {{ $department->department_name }}
                            ({{ $department->department_code }})
                        </option>
                    @endforeach
                </select>

                @error('department_id')
                    <span class="invalid-feedback d-block">
                        {{ $message }}
                    </span>
                @enderror

            </div>

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
                placeholder="បញ្ចូលការពិពណ៌នាអំពីវគ្គសិក្សា..."
            >{{ old('description', $course->description ?? '') }}</textarea>

            @error('description')
                <span class="invalid-feedback">
                    {{ $message }}
                </span>
            @enderror

        </div>

    </div>
    <div class="form-actions">

        <a
            href="{{ route('courses.index') }}"
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