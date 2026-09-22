```blade
@extends('layouts.master')

@section('title', 'វគ្គសិក្សា | Courses | LMS')

@php
    /*
     | Presentation-only helpers.
     | No backend / controller / model / route changes.
     */

    $teacherNames = $teachers->keyBy('teacher_id')->map(function ($teacher) {
        $fullName = trim((string) $teacher->full_name);

        return $fullName !== '' ? $fullName : trim($teacher->first_name . ' ' . $teacher->last_name);
    });

    $courseTeacherNames = function ($course) use ($assignedTeachersMap, $teacherNames) {
        return collect($assignedTeachersMap[$course->course_id] ?? [])
            ->map(fn ($teacherId) => $teacherNames[$teacherId] ?? null)
            ->filter()
            ->values();
    };

    $courseEnrollmentCount = fn ($course) =>
        (int) collect($enrolledStudentsMap[$course->course_id] ?? [])->count();

    $statusStyles = [
        'public'    => ['badge' => 'badge-success', 'icon' => 'fa-globe', 'label' => 'សាធារណៈ (Public)'],
        'published' => ['badge' => 'badge-success', 'icon' => 'fa-check-circle', 'label' => 'បានផ្សព្វផ្សាយ (Published)'],
        'private'   => ['badge' => 'badge-warning', 'icon' => 'fa-lock', 'label' => 'ឯកជន (Private)'],
        'draft'     => ['badge' => 'badge-secondary', 'icon' => 'fa-pencil-alt', 'label' => 'ព្រាង (Draft)'],
    ];

    $courseStatus = function ($visibility) use ($statusStyles) {
        $visibility = is_string($visibility) ? trim($visibility) : '';

        if ($visibility === '') {
            return [
                'badge' => 'badge-light border text-muted',
                'icon' => 'fa-circle',
                'label' => 'មិនបានកំណត់ (Not set)'
            ];
        }

        return $statusStyles[strtolower($visibility)]
            ?? [
                'badge' => 'badge-info',
                'icon' => 'fa-circle',
                'label' => \Illuminate\Support\Str::headline($visibility)
            ];
    };

    $thumbnailStyles = [
        'course-thumb-green',
        'course-thumb-teal',
        'course-thumb-blue',
        'course-thumb-emerald',
        'course-thumb-sage',
        'course-thumb-darkgreen'
    ];

    $courseThumbnail = fn ($course) =>
        $thumbnailStyles[abs((int) $course->course_id) % count($thumbnailStyles)];

    $initialsOf = function ($value) {
        $value = trim((string) $value);

        if ($value === '') {
            return '?';
        }

        return \Illuminate\Support\Str::upper(
            collect(preg_split('/[\s._-]+/u', $value))
                ->filter()
                ->map(fn ($part) => mb_substr($part, 0, 1))
                ->take(2)
                ->implode('')
        );
    };

    $categoryOptions = $courses->pluck('category')
        ->filter()
        ->unique('course_category_id')
        ->sortBy('category_name')
        ->values();

    $statusOptions = $courses->pluck('visibility')
        ->map(fn ($visibility) => trim((string) $visibility))
        ->filter()
        ->unique()
        ->sort()
        ->values();
@endphp

@section('content')

<style>
    /* =========================================================
       SCHOOL LMS - COURSE MANAGEMENT
       Clean / Modern / Professional / Light Green
       ========================================================= */

    .course-page {
        --green: #10b981;
        --green-dark: #047857;
        --green-deep: #065f46;
        --green-soft: #ecfdf5;
        --green-light: #d1fae5;

        --surface: #ffffff;
        --background: #f8fafc;
        --border: #e5e7eb;

        --text: #1f2937;
        --text-secondary: #4b5563;
        --muted: #6b7280;

        --danger: #dc2626;
        --warning: #d97706;

        --radius: 10px;

        color: var(--text);
    }

    /* =========================================================
       PAGE HEADER
       ========================================================= */

    .course-page .content-header {
        padding: 0 0 20px;
    }

    .course-page-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 20px;
    }

    .course-page-heading {
        min-width: 0;
        flex: 1;
    }

    .course-breadcrumb {
        padding: 0;
        margin: 0 0 7px;
        background: transparent;
        font-size: 12.5px;
    }

    .course-breadcrumb a {
        color: var(--green-dark);
        text-decoration: none;
    }

    .course-breadcrumb a:hover {
        color: var(--green);
    }

    .course-breadcrumb .active {
        color: var(--muted);
    }

    .course-page-title {
        margin: 0 0 4px;
        color: var(--text);
        font-size: 1.55rem;
        font-weight: 650;
        line-height: 1.45;
    }

    .course-page-subtitle {
        margin: 0;
        color: var(--muted);
        font-size: 13.5px;
        line-height: 1.6;
    }

    .course-page-header-actions .btn {
        height: 40px;
        padding: 0 17px;
        border: 0;
        border-radius: 8px;
        background: var(--green);
        font-size: 13.5px;
        font-weight: 600;
        box-shadow: 0 2px 5px rgba(16, 185, 129, .18);
    }

    .course-page-header-actions .btn:hover {
        background: var(--green-dark);
        box-shadow: 0 4px 10px rgba(16, 185, 129, .20);
    }

    /* =========================================================
       ALERTS
       ========================================================= */

    .course-page .alert {
        border-radius: 8px;
        border: 1px solid transparent;
        font-size: 13px;
    }

    .course-page .alert-success {
        color: #166534;
        background: #f0fdf4;
        border-color: #bbf7d0;
    }

    .course-page .alert-danger {
        color: #991b1b;
        background: #fef2f2;
        border-color: #fecaca;
    }

    /* =========================================================
       TOOLBAR
       ========================================================= */

    .course-toolbar {
        margin-bottom: 22px;
        padding: 18px 20px 14px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: 0 1px 3px rgba(15, 23, 42, .04);
    }

    .course-filter-label {
        display: block;
        margin-bottom: 6px;
        color: var(--text-secondary);
        font-size: 12px;
        font-weight: 600;
    }

    .course-filter-label i {
        width: 14px;
        color: var(--green-dark);
        opacity: .85;
    }

    .course-toolbar .form-control,
    .course-toolbar .custom-select {
        height: 40px;
        border: 1px solid #d1d5db;
        border-radius: 7px;
        color: var(--text);
        background-color: #fff;
        font-size: 13px;
        box-shadow: none;
    }

    .course-toolbar .form-control::placeholder {
        color: #9ca3af;
    }

    .course-toolbar .form-control:focus,
    .course-toolbar .custom-select:focus {
        border-color: var(--green);
        box-shadow: 0 0 0 3px rgba(16, 185, 129, .10);
    }

    .course-toolbar .input-group .form-control {
        border-radius: 7px 0 0 7px;
    }

    .course-toolbar .input-group-append .btn {
        height: 40px;
        min-width: 42px;
        border: 1px solid #d1d5db;
        border-left: 0;
        border-radius: 0 7px 7px 0;
        color: var(--muted);
        background: #f9fafb;
    }

    .course-toolbar .input-group-append .btn:hover {
        color: var(--green-dark);
        background: var(--green-soft);
    }

    .course-toolbar-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        min-height: 30px;
        padding-top: 10px;
        border-top: 1px solid #f0f1f3;
    }

    #courseResultCount {
        color: var(--muted);
        font-size: 12.5px;
        font-weight: 500;
    }

    /* =========================================================
       COURSE CARD
       ========================================================= */

    #courseCardGrid {
        margin-right: -10px;
        margin-left: -10px;
    }

    #courseCardGrid > [data-course-card] {
        padding-right: 10px;
        padding-left: 10px;
        margin-bottom: 20px;
    }

    .course-card {
        display: flex;
        flex-direction: column;
        height: 100%;
        overflow: hidden;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: 0 1px 3px rgba(15, 23, 42, .045);
        transition: box-shadow .18s ease, transform .18s ease;
    }

    .course-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 18px rgba(15, 23, 42, .08);
    }

    /* =========================================================
       COURSE THUMBNAIL
       ========================================================= */

    .course-thumb {
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 132px;
        padding: 12px;
        overflow: hidden;
        color: #fff;
    }

    .course-thumb-green {
        background: linear-gradient(135deg, #34d399, #059669);
    }

    .course-thumb-teal {
        background: linear-gradient(135deg, #2dd4bf, #0f766e);
    }

    .course-thumb-blue {
        background: linear-gradient(135deg, #60a5fa, #2563eb);
    }

    .course-thumb-emerald {
        background: linear-gradient(135deg, #6ee7b7, #047857);
    }

    .course-thumb-sage {
        background: linear-gradient(135deg, #86efac, #15803d);
    }

    .course-thumb-darkgreen {
        background: linear-gradient(135deg, #34d399, #065f46);
    }

    .course-thumb::after {
        content: "";
        position: absolute;
        right: -35px;
        bottom: -55px;
        width: 145px;
        height: 145px;
        border-radius: 50%;
        background: rgba(255,255,255,.09);
    }

    .course-thumb-top {
        position: relative;
        z-index: 2;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 8px;
    }

    .course-thumb-code {
        max-width: 55%;
        padding: 4px 9px;
        overflow: hidden;
        border-radius: 20px;
        background: rgba(255,255,255,.18);
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .course-thumb-code:empty {
        display: none;
    }

    .course-status-badge {
        max-width: 62%;
        padding: 4px 8px;
        border-radius: 20px;
        background: rgba(255,255,255,.95) !important;
        font-size: 10.5px;
        font-weight: 600;
        line-height: 1.4;
        white-space: normal;
    }

    .course-status-badge.badge-success {
        color: #166534;
    }

    .course-status-badge.badge-warning {
        color: #92400e;
    }

    .course-status-badge.badge-secondary {
        color: #4b5563;
    }

    .course-status-badge.badge-info {
        color: #075985;
    }

    .course-thumb-initials {
        position: relative;
        z-index: 2;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 46px;
        height: 46px;
        border-radius: 10px;
        background: rgba(255,255,255,.18);
        font-size: 16px;
        font-weight: 700;
        letter-spacing: .04em;
    }

    .course-thumb-icon {
        position: absolute;
        right: 5px;
        bottom: -18px;
        z-index: 1;
        font-size: 90px;
        color: #fff;
        opacity: .10;
    }

    /* =========================================================
       CARD CONTENT
       ========================================================= */

    .course-card-body {
        display: flex;
        flex: 1;
        flex-direction: column;
        padding: 16px 16px 0;
    }

    .course-card-title {
        display: -webkit-box;
        min-height: 48px;
        margin: 0 0 10px;
        overflow: hidden;
        color: var(--text);
        font-size: 16px;
        font-weight: 650;
        line-height: 1.5;
        overflow-wrap: anywhere;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        line-clamp: 2;
    }

    /* =========================================================
       COURSE META
       ========================================================= */

    .course-card-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 12px;
    }

    .course-meta-item {
        display: inline-flex;
        align-items: center;
        max-width: 100%;
        min-width: 0;
        padding: 4px 8px;
        border-radius: 5px;
        background: #f3f4f6;
        color: var(--muted);
        font-size: 11.5px;
    }

    .course-meta-item i {
        margin-right: 5px;
        color: var(--green-dark);
        font-size: 10px;
    }

    .course-meta-text {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* =========================================================
       TEACHER
       ========================================================= */

    .course-card-teacher {
        display: flex;
        align-items: center;
        min-width: 0;
        gap: 8px;
        margin-bottom: 10px;
    }

    .course-teacher-avatars {
        display: inline-flex;
        flex: 0 0 auto;
    }

    .course-teacher-avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border: 2px solid #fff;
        border-radius: 50%;
        background: var(--green-light);
        color: var(--green-deep);
        font-size: 9px;
        font-weight: 700;
    }

    .course-teacher-avatar + .course-teacher-avatar {
        margin-left: -7px;
    }

    .course-teacher-avatar-empty {
        border-color: var(--border);
        background: #f9fafb;
        color: var(--muted);
    }

    .course-teacher-names {
        min-width: 0;
        overflow: hidden;
        color: var(--text-secondary);
        font-size: 12.5px;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .course-teacher-names.is-empty {
        color: var(--muted);
    }

    /* =========================================================
       DESCRIPTION
       ========================================================= */

    .course-card-description {
        display: -webkit-box;
        min-height: 54px;
        margin: 0 0 10px;
        overflow: hidden;
        color: var(--muted);
        font-size: 12.5px;
        line-height: 1.7;
        overflow-wrap: anywhere;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
        line-clamp: 3;
    }

    /* =========================================================
       STATS
       ========================================================= */

    .course-card-stats {
        display: flex;
        flex-wrap: wrap;
        gap: 10px 18px;
        margin-top: auto;
        padding: 8px 0 13px;
        color: var(--muted);
        font-size: 11.5px;
    }

    .course-stat i {
        margin-right: 4px;
        color: var(--green-dark);
    }

    .course-stat strong {
        color: var(--text);
        font-weight: 650;
    }

    /* =========================================================
       CARD ACTIONS
       ========================================================= */

    .course-card-actions {
        display: flex;
        align-items: center;
        gap: 5px;
        padding: 9px 10px;
        border-top: 1px solid #eef0f2;
        background: #fcfdfd;
    }

    .course-card-actions form {
        display: flex;
        margin: 0;
    }

    .course-card-actions .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 34px;
        border-radius: 6px;
        font-size: 12px;
        transition: all .15s ease;
    }

    .course-action-primary {
        flex: 1;
        min-width: 0;
        padding: 0 10px;
        border: 0;
        background: var(--green);
        font-weight: 600;
    }

    .course-action-primary:hover {
        background: var(--green-dark);
    }

    .course-action-icon {
        flex: 0 0 34px;
        width: 34px;
        padding: 0;
    }

    .course-card-actions .btn-outline-primary {
        color: #047857;
        border-color: #a7f3d0;
        background: #fff;
    }

    .course-card-actions .btn-outline-primary:hover {
        color: #fff;
        border-color: var(--green);
        background: var(--green);
    }

    .course-card-actions .btn-outline-info {
        color: #0f766e;
        border-color: #99f6e4;
        background: #fff;
    }

    .course-card-actions .btn-outline-info:hover {
        color: #fff;
        border-color: #0d9488;
        background: #0d9488;
    }

    .course-card-actions .btn-outline-success {
        color: #15803d;
        border-color: #bbf7d0;
        background: #fff;
    }

    .course-card-actions .btn-outline-success:hover {
        color: #fff;
        border-color: #16a34a;
        background: #16a34a;
    }

    .course-card-actions .btn-outline-danger {
        color: #dc2626;
        border-color: #fecaca;
        background: #fff;
    }

    .course-card-actions .btn-outline-danger:hover {
        color: #fff;
        border-color: #dc2626;
        background: #dc2626;
    }

    /* =========================================================
       EMPTY STATE
       ========================================================= */

    .course-empty-state {
        padding: 55px 20px;
        text-align: center;
    }

    .course-empty-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 64px;
        height: 64px;
        margin-bottom: 15px;
        border-radius: 50%;
        background: var(--green-soft);
        color: var(--green-dark);
        font-size: 22px;
    }

    .course-empty-state h2,
    .course-no-results h2 {
        color: var(--text);
    }

    .course-empty-state p,
    .course-no-results p {
        color: var(--muted);
        font-size: 13px;
    }

    .course-empty-state .btn,
    .course-no-results .btn {
        border-radius: 7px;
        font-size: 13px;
    }

    /* =========================================================
       NO RESULTS
       ========================================================= */

    .course-no-results {
        margin-bottom: 20px;
        padding: 45px 20px;
        text-align: center;
        background: var(--surface);
        border: 1px dashed #d1d5db;
        border-radius: var(--radius);
    }

    /* =========================================================
       PAGINATION
       ========================================================= */

    .course-pager {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        margin: 8px 0 25px;
    }

    .course-page-numbers {
        display: inline-flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 5px;
    }

    .course-page-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
        padding: 0 9px;
        border: 1px solid var(--border);
        border-radius: 7px;
        background: #fff;
        color: var(--text-secondary);
        font-size: 12px;
        font-weight: 500;
    }

    .course-page-btn:hover:not(:disabled):not(.is-active) {
        border-color: #a7f3d0;
        color: var(--green-dark);
        background: var(--green-soft);
    }

    .course-page-btn.is-active {
        border-color: var(--green);
        background: var(--green);
        color: #fff;
    }

    .course-page-btn:disabled {
        opacity: .4;
        cursor: not-allowed;
    }

    /* =========================================================
       MODALS
       ========================================================= */

    #assignTeacherModal .modal-content,
    #enrollStudentModal .modal-content {
        overflow: hidden;
        border: 1px solid var(--border);
        border-radius: 10px;
        box-shadow: 0 15px 35px rgba(15, 23, 42, .15);
    }

    #assignTeacherModal .modal-header,
    #enrollStudentModal .modal-header {
        padding: 15px 18px;
        background: #fff;
        border-bottom: 1px solid var(--border);
    }

    #assignTeacherModal .modal-title,
    #enrollStudentModal .modal-title {
        color: var(--text);
        font-size: 15px;
        font-weight: 650;
    }

    #assignTeacherModal .modal-body,
    #enrollStudentModal .modal-body {
        padding: 20px 18px;
    }

    #assignTeacherModal label,
    #enrollStudentModal label {
        color: var(--text-secondary);
        font-size: 13px;
        font-weight: 600;
    }

    #assignTeacherModal .form-control,
    #enrollStudentModal .form-control {
        min-height: 40px;
        border-color: #d1d5db;
        border-radius: 7px;
        font-size: 13px;
        box-shadow: none;
    }

    #assignTeacherModal .form-control:focus,
    #enrollStudentModal .form-control:focus {
        border-color: var(--green);
        box-shadow: 0 0 0 3px rgba(16, 185, 129, .10);
    }

    #assignTeacherModal .modal-footer,
    #enrollStudentModal .modal-footer {
        padding: 12px 18px;
        border-top: 1px solid var(--border);
    }

    #assignTeacherModal .modal-footer .btn,
    #enrollStudentModal .modal-footer .btn {
        border-radius: 7px;
        font-size: 13px;
        font-weight: 500;
    }

    /* =========================================================
       RESPONSIVE
       ========================================================= */

    @media (max-width: 991.98px) {
        .course-page-header {
            align-items: flex-start;
        }

        .course-page-title {
            font-size: 1.4rem;
        }
    }

    @media (max-width: 767.98px) {
        .course-page .content-header {
            padding-bottom: 16px;
        }

        .course-page-header {
            flex-direction: column;
            align-items: stretch;
        }

        .course-page-header-actions {
            width: 100%;
        }

        .course-page-header-actions .btn {
            width: 100%;
        }

        .course-toolbar {
            padding: 15px;
        }

        .course-card:hover {
            transform: none;
        }

        .course-card-actions .btn {
            height: 38px;
        }

        .course-action-icon {
            flex-basis: 38px;
            width: 38px;
        }
    }

    @media (max-width: 575.98px) {
        .course-page-title {
            font-size: 1.3rem;
        }

        .course-page-subtitle {
            font-size: 12.5px;
        }

        .course-toolbar {
            border-radius: 8px;
        }

        .course-thumb {
            height: 125px;
        }

        .course-card-body {
            padding: 14px 14px 0;
        }

        .course-card-actions {
            gap: 4px;
            padding: 8px;
        }

        .course-action-primary {
            padding: 0 7px;
        }

        .course-card-actions .btn {
            font-size: 11px;
        }
    }

    @media (max-width: 380px) {
        .course-card-actions {
            flex-wrap: wrap;
        }

        .course-action-primary {
            flex: 1 1 100%;
        }

        .course-action-icon {
            flex: 1 1 0;
            width: auto;
        }

        .course-card-actions form {
            flex: 1 1 0;
        }

        .course-card-actions form .btn {
            width: 100%;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .course-card {
            transition: none;
        }

        .course-card:hover {
            transform: none;
        }
    }
</style>

<div class="course-page">

    {{-- =========================================================
         PAGE HEADER
         ========================================================= --}}
    <section class="content-header px-0">

        <div class="container-fluid px-0">

            <div class="course-page-header">

                <div class="course-page-heading">

                    <ol class="breadcrumb course-breadcrumb">

                        <li class="breadcrumb-item">
                            <a href="{{ auth()->check() ? route('dashboard') : route('login') }}">
                                Dashboard
                            </a>
                        </li>

                        <li class="breadcrumb-item active">
                            Courses
                        </li>

                    </ol>

                    <h1 class="course-page-title">
                        វគ្គសិក្សា (Courses)
                    </h1>

                    <p class="course-page-subtitle">
                        គ្រប់គ្រងព័ត៌មានវគ្គសិក្សា គ្រូបង្រៀន និងសិស្សដែលបានចុះឈ្មោះ។
                    </p>

                </div>

                @auth
                    <div class="course-page-header-actions">

                        <a
                            href="{{ route('courses.create') }}"
                            class="btn btn-primary"
                        >
                            <i class="fas fa-plus mr-1" aria-hidden="true"></i>
                            បង្កើតវគ្គសិក្សា
                        </a>

                    </div>
                @endauth

            </div>

        </div>

    </section>


    {{-- =========================================================
         SUCCESS MESSAGE
         ========================================================= --}}
    @if (session('success'))

        <div
            class="alert alert-success alert-dismissible fade show"
            role="alert"
        >
            <i class="fas fa-check-circle mr-2" aria-hidden="true"></i>
            {{ session('success') }}

            <button
                type="button"
                class="close"
                data-dismiss="alert"
                aria-label="Close"
            >
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

    @endif


    {{-- =========================================================
         VALIDATION ERROR
         ========================================================= --}}
    @if ($errors->any())

        <div
            class="alert alert-danger alert-dismissible fade show"
            role="alert"
        >

            <i
                class="fas fa-exclamation-triangle mr-2"
                aria-hidden="true"
            ></i>

            សូមពិនិត្យព័ត៌មានខាងក្រោមម្តងទៀត។

            <ul class="mb-0 pl-4 mt-2">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

            <button
                type="button"
                class="close"
                data-dismiss="alert"
                aria-label="Close"
            >
                <span aria-hidden="true">&times;</span>
            </button>

        </div>

    @endif


    {{-- =========================================================
         EMPTY STATE
         ========================================================= --}}
    @if ($courses->isEmpty())

        <div class="card course-toolbar">

            <div class="card-body p-0">

                <div class="course-empty-state">

                    <span class="course-empty-icon">
                        <i class="fas fa-book-open" aria-hidden="true"></i>
                    </span>

                    <h2 class="h5 font-weight-bold mb-2">
                        មិនទាន់មានវគ្គសិក្សានៅឡើយទេ
                    </h2>

                    <p class="mb-4">
                        ចាប់ផ្តើមដោយបង្កើតវគ្គសិក្សាដំបូងរបស់អ្នក។
                    </p>

                    @auth

                        <a
                            href="{{ route('courses.create') }}"
                            class="btn btn-primary"
                        >
                            <i class="fas fa-plus mr-1" aria-hidden="true"></i>
                            បង្កើតវគ្គសិក្សា
                        </a>

                    @else

                        <a
                            href="{{ route('login') }}"
                            class="btn btn-primary"
                        >
                            <i class="fas fa-sign-in-alt mr-1" aria-hidden="true"></i>
                            ចូលប្រើប្រាស់
                        </a>

                    @endauth

                </div>

            </div>

        </div>

    @else


        {{-- =====================================================
             SEARCH / FILTER
             ===================================================== --}}
        <div class="course-toolbar">

            <div class="row align-items-end">

                {{-- Search --}}
                <div class="col-xl-4 col-md-6 mb-3">

                    <label
                        class="course-filter-label"
                        for="courseSearchInput"
                    >
                        <i class="fas fa-search mr-1" aria-hidden="true"></i>
                        ស្វែងរកវគ្គសិក្សា
                    </label>

                    <div class="input-group">

                        <input
                            type="search"
                            id="courseSearchInput"
                            class="form-control"
                            placeholder="ឈ្មោះវគ្គ / កូដ / គ្រូ / ប្រភេទ..."
                            autocomplete="off"
                        >

                        <div class="input-group-append">

                            <button
                                type="button"
                                class="btn"
                                id="courseSearchClear"
                                title="សម្អាត"
                                aria-label="Clear search"
                            >
                                <i class="fas fa-times" aria-hidden="true"></i>
                            </button>

                        </div>

                    </div>

                </div>


                {{-- Category --}}
                <div class="col-xl-2 col-md-6 col-6 mb-3">

                    <label
                        class="course-filter-label"
                        for="courseCategoryFilter"
                    >
                        <i class="fas fa-tags mr-1" aria-hidden="true"></i>
                        ប្រភេទ
                    </label>

                    <select
                        id="courseCategoryFilter"
                        class="custom-select"
                    >

                        <option value="">
                            ទាំងអស់ (All)
                        </option>

                        @foreach ($categoryOptions as $category)

                            <option value="{{ $category->course_category_id }}">
                                {{ $category->category_name }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Status --}}
                <div class="col-xl-2 col-md-4 col-6 mb-3">

                    <label
                        class="course-filter-label"
                        for="courseStatusFilter"
                    >
                        <i class="fas fa-toggle-on mr-1" aria-hidden="true"></i>
                        ស្ថានភាព
                    </label>

                    <select
                        id="courseStatusFilter"
                        class="custom-select"
                    >

                        <option value="">
                            ទាំងអស់ (All)
                        </option>

                        @foreach ($statusOptions as $statusOption)

                            <option value="{{ strtolower($statusOption) }}">
                                {{ $courseStatus($statusOption)['label'] }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Sort --}}
                <div class="col-xl-2 col-md-4 col-6 mb-3">

                    <label
                        class="course-filter-label"
                        for="courseSort"
                    >
                        <i class="fas fa-sort mr-1" aria-hidden="true"></i>
                        តម្រៀប
                    </label>

                    <select
                        id="courseSort"
                        class="custom-select"
                    >

                        <option value="newest">
                            ថ្មីបំផុត (Newest)
                        </option>

                        <option value="name">
                            ឈ្មោះ A → Z (Name)
                        </option>

                        <option value="code">
                            កូដ (Code)
                        </option>

                        <option value="enrollments">
                            ចុះឈ្មោះច្រើន
                        </option>

                        <option value="lessons">
                            មេរៀនច្រើន
                        </option>

                    </select>

                </div>


                {{-- Page Size --}}
                <div class="col-xl-2 col-md-4 col-6 mb-3">

                    <label
                        class="course-filter-label"
                        for="coursePageSize"
                    >
                        <i class="fas fa-th-large mr-1" aria-hidden="true"></i>
                        បង្ហាញ
                    </label>

                    <select
                        id="coursePageSize"
                        class="custom-select"
                    >

                        <option value="6">6</option>
                        <option value="9" selected>9</option>
                        <option value="12">12</option>
                        <option value="24">24</option>
                        <option value="all">ទាំងអស់ (All)</option>

                    </select>

                </div>

            </div>


            <div class="course-toolbar-footer">

                <span
                    id="courseResultCount"
                    aria-live="polite"
                ></span>

            </div>

        </div>


        {{-- =====================================================
             COURSE CARDS
             ===================================================== --}}
        <div class="row" id="courseCardGrid">

            @foreach ($courses as $course)

                @php

                    $courseTeachers = $courseTeacherNames($course);

                    $enrollments = $courseEnrollmentCount($course);

                    $lessonTotal = $course->lessons->count();

                    $courseStatusStyle = $courseStatus($course->visibility);

                    $categoryName = $course->category?->category_name;

                    $departmentName = $course->department?->department_name;

                    $searchIndex = \Illuminate\Support\Str::lower(
                        trim(
                            implode(
                                ' ',
                                array_filter([
                                    $course->course_name,
                                    $course->course_code,
                                    $categoryName,
                                    $departmentName,
                                    $courseTeachers->implode(' '),
                                ])
                            )
                        )
                    );

                @endphp


                <div
                    class="col-xl-4 col-md-6"
                    data-course-card
                    data-search="{{ $searchIndex }}"
                    data-category="{{ $course->course_category_id }}"
                    data-status="{{ strtolower(trim((string) $course->visibility)) }}"
                    data-order="{{ (int) $course->course_id }}"
                    data-name="{{ \Illuminate\Support\Str::lower((string) $course->course_name) }}"
                    data-code="{{ \Illuminate\Support\Str::lower((string) $course->course_code) }}"
                    data-enrollments="{{ $enrollments }}"
                    data-lessons="{{ $lessonTotal }}"
                >

                    <article class="course-card">

                        {{-- Course Thumbnail --}}
                        <div class="course-thumb {{ $courseThumbnail($course) }}">

                            <div class="course-thumb-top">

                                <span class="course-thumb-code">
                                    {{ $course->course_code }}
                                </span>

                                <span class="badge {{ $courseStatusStyle['badge'] }} course-status-badge">

                                    <i
                                        class="fas {{ $courseStatusStyle['icon'] }} mr-1"
                                        aria-hidden="true"
                                    ></i>

                                    {{ $courseStatusStyle['label'] }}

                                </span>

                            </div>

                            <i
                                class="fas fa-book-open course-thumb-icon"
                                aria-hidden="true"
                            ></i>

                            <span
                                class="course-thumb-initials"
                                aria-hidden="true"
                            >
                                {{ $initialsOf($course->course_name) }}
                            </span>

                        </div>


                        {{-- Card Body --}}
                        <div class="course-card-body">

                            <h3
                                class="course-card-title"
                                title="{{ $course->course_name }}"
                            >
                                {{ $course->course_name }}
                            </h3>


                            {{-- Category / Department --}}
                            <div class="course-card-meta">

                                <span
                                    class="course-meta-item"
                                    title="{{ $categoryName ?: '—' }}"
                                >
                                    <i
                                        class="fas fa-tags"
                                        aria-hidden="true"
                                    ></i>

                                    <span class="course-meta-text">
                                        {{ $categoryName ?: '—' }}
                                    </span>
                                </span>


                                <span
                                    class="course-meta-item"
                                    title="{{ $departmentName ?: '—' }}"
                                >
                                    <i
                                        class="fas fa-building"
                                        aria-hidden="true"
                                    ></i>

                                    <span class="course-meta-text">
                                        {{ $departmentName ?: '—' }}
                                    </span>
                                </span>

                            </div>


                            {{-- Teacher --}}
                            <div class="course-card-teacher">

                                <span class="course-teacher-avatars">

                                    @forelse ($courseTeachers->take(3) as $courseTeacherName)

                                        <span
                                            class="course-teacher-avatar"
                                            title="{{ $courseTeacherName }}"
                                        >
                                            {{ $initialsOf($courseTeacherName) }}
                                        </span>

                                    @empty

                                        <span
                                            class="course-teacher-avatar course-teacher-avatar-empty"
                                            title="មិនទាន់ចាត់តាំងគ្រូ"
                                        >
                                            <i
                                                class="fas fa-user-slash"
                                                aria-hidden="true"
                                            ></i>
                                        </span>

                                    @endforelse

                                </span>

                                <span
                                    class="course-teacher-names {{ $courseTeachers->isEmpty() ? 'is-empty' : '' }}"
                                    title="{{ $courseTeachers->implode(', ') }}"
                                >

                                    {{ $courseTeachers->isNotEmpty()
                                        ? $courseTeachers->implode(', ')
                                        : 'មិនទាន់ចាត់តាំងគ្រូ'
                                    }}

                                </span>

                            </div>


                            {{-- Description --}}
                            <p class="course-card-description">

                                {{ \Illuminate\Support\Str::limit(
                                    (string) $course->description,
                                    110
                                ) ?: 'មិនមានការពិពណ៌នា'
                                }}

                            </p>


                            {{-- Statistics --}}
                            <div class="course-card-stats">

                                <span class="course-stat">

                                    <i
                                        class="fas fa-users"
                                        aria-hidden="true"
                                    ></i>

                                    <strong>
                                        {{ number_format($enrollments) }}
                                    </strong>

                                    សិស្ស

                                </span>


                                <span class="course-stat">

                                    <i
                                        class="fas fa-play-circle"
                                        aria-hidden="true"
                                    ></i>

                                    <strong>
                                        {{ number_format($lessonTotal) }}
                                    </strong>

                                    មេរៀន

                                </span>

                            </div>

                        </div>


                        {{-- =================================================
                             ACTIONS
                             ================================================= --}}
                        @auth

                            <div class="course-card-actions">

                                {{-- View --}}
                                <a
                                    href="{{ route('courses.modules.index', $course) }}"
                                    class="btn btn-sm btn-primary course-action-primary"
                                    title="មើលមាតិកាវគ្គសិក្សា"
                                >
                                    <i
                                        class="fas fa-eye mr-1"
                                        aria-hidden="true"
                                    ></i>

                                    មើល

                                </a>


                                {{-- Edit --}}
                                <a
                                    href="{{ route('courses.edit', $course) }}"
                                    class="btn btn-sm btn-outline-primary course-action-icon"
                                    title="កែប្រែវគ្គសិក្សា"
                                    aria-label="Edit course"
                                >
                                    <i
                                        class="fas fa-edit"
                                        aria-hidden="true"
                                    ></i>
                                </a>


                                {{-- Assign Teacher --}}
                                <button
                                    type="button"
                                    class="btn btn-sm btn-outline-info course-action-icon btn-assign-teacher"
                                    data-course-id="{{ $course->course_id }}"
                                    title="ចាត់តាំងគ្រូ"
                                    aria-label="Assign teacher"
                                >
                                    <i
                                        class="fas fa-chalkboard-teacher"
                                        aria-hidden="true"
                                    ></i>
                                </button>


                                {{-- Enroll Student --}}
                                <button
                                    type="button"
                                    class="btn btn-sm btn-outline-success course-action-icon btn-enroll-student"
                                    data-course-id="{{ $course->course_id }}"
                                    title="ចុះឈ្មោះសិស្ស"
                                    aria-label="Enroll student"
                                >
                                    <i
                                        class="fas fa-user-plus"
                                        aria-hidden="true"
                                    ></i>
                                </button>


                                {{-- Delete --}}
                                <form
                                    action="{{ route('courses.destroy', $course) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this course?');"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-outline-danger course-action-icon"
                                        title="លុបវគ្គសិក្សា"
                                        aria-label="Delete course"
                                    >
                                        <i
                                            class="fas fa-trash"
                                            aria-hidden="true"
                                        ></i>
                                    </button>

                                </form>

                            </div>

                        @endauth

                    </article>

                </div>

            @endforeach

        </div>


        {{-- =====================================================
             NO SEARCH RESULTS
             ===================================================== --}}
        <div
            class="course-no-results d-none"
            id="courseNoResults"
        >

            <span class="course-empty-icon">
                <i class="fas fa-search" aria-hidden="true"></i>
            </span>

            <h2 class="h6 font-weight-bold mb-2">
                រកមិនឃើញវគ្គសិក្សា
            </h2>

            <p class="mb-3">
                សូមព្យាយាមផ្លាស់ប្តូរពាក្យស្វែងរក ឬតម្រងរបស់អ្នក។
            </p>

            <button
                type="button"
                class="btn btn-outline-primary btn-sm"
                id="courseResetFilters"
            >
                <i
                    class="fas fa-undo mr-1"
                    aria-hidden="true"
                ></i>

                កំណត់តម្រងឡើងវិញ

            </button>

        </div>


        {{-- =====================================================
             PAGINATION
             ===================================================== --}}
        <nav
            class="course-pager d-none"
            id="coursePager"
            aria-label="Course pages"
        >

            <button
                type="button"
                class="course-page-btn"
                data-page="prev"
                aria-label="Previous page"
            >
                <i
                    class="fas fa-chevron-left"
                    aria-hidden="true"
                ></i>
            </button>

            <span
                class="course-page-numbers"
                id="coursePageNumbers"
            ></span>

            <button
                type="button"
                class="course-page-btn"
                data-page="next"
                aria-label="Next page"
            >
                <i
                    class="fas fa-chevron-right"
                    aria-hidden="true"
                ></i>
            </button>

        </nav>

    @endif

</div>


{{-- =============================================================
     ASSIGN TEACHER MODAL
     ============================================================= --}}
@auth

<div
    class="modal fade"
    id="assignTeacherModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="assignTeacherModalLabel"
    aria-hidden="true"
>

    <div
        class="modal-dialog modal-dialog-centered"
        role="document"
    >

        <form
            action="{{ route('courses.assign_teacher') }}"
            method="POST"
        >

            @csrf

            <input
                type="hidden"
                name="course_id"
                id="assign_teacher_course_id"
            >

            <div class="modal-content">

                <div class="modal-header">

                    <h5
                        class="modal-title"
                        id="assignTeacherModalLabel"
                    >
                        ចាត់តាំងគ្រូបង្រៀន
                    </h5>

                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>


                <div class="modal-body">

                    <div class="form-group mb-0">

                        <label>
                            គ្រូបង្រៀន
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            name="teacher_id"
                            id="assign_teacher_id"
                            class="form-control select2"
                            style="width: 100%;"
                            required
                        >

                            <option value="">
                                -- ជ្រើសរើសគ្រូ --
                            </option>

                            @foreach($teachers as $teacher)

                                <option value="{{ $teacher->teacher_id }}">
                                    {{ $teacher->full_name }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal"
                    >
                        បិទ
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        <i class="fas fa-save mr-1"></i>
                        រក្សាទុក
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>


{{-- =============================================================
     ENROLL STUDENT MODAL
     ============================================================= --}}
<div
    class="modal fade"
    id="enrollStudentModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="enrollStudentModalLabel"
    aria-hidden="true"
>

    <div
        class="modal-dialog modal-dialog-centered"
        role="document"
    >

        <form
            action="{{ route('enrollments.store') }}"
            method="POST"
        >

            @csrf

            <input
                type="hidden"
                name="course_id"
                id="enroll_student_course_id"
            >

            <div class="modal-content">

                <div class="modal-header">

                    <h5
                        class="modal-title"
                        id="enrollStudentModalLabel"
                    >
                        ចុះឈ្មោះសិស្ស
                    </h5>

                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>


                <div class="modal-body">

                    <div class="form-group">

                        <label>
                            សិស្ស
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            name="student_id"
                            id="enroll_student_id"
                            class="form-control select2"
                            style="width: 100%;"
                            required
                        >

                            <option value="">
                                -- ជ្រើសរើសសិស្ស --
                            </option>

                            @foreach($students as $student)

                                <option value="{{ $student->student_id }}">
                                    {{ $student->full_name }}
                                    ({{ $student->student_code }})
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="form-group">

                        <label>
                            កាលបរិច្ឆេទចុះឈ្មោះ
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="date"
                            name="enrollment_date"
                            class="form-control"
                            value="{{ date('Y-m-d') }}"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            ស្ថានភាព
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            name="status"
                            class="form-control"
                            required
                        >

                            <option value="studying">
                                កំពុងសិក្សា (Studying)
                            </option>

                            <option value="completed">
                                បានបញ្ចប់ (Completed)
                            </option>

                            <option value="dropped">
                                បោះបង់ (Dropped)
                            </option>

                        </select>

                    </div>


                    <div class="form-group mb-0">

                        <label>
                            កំណត់ចំណាំ
                        </label>

                        <textarea
                            name="note"
                            class="form-control"
                            rows="3"
                        ></textarea>

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal"
                    >
                        បិទ
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        <i class="fas fa-save mr-1"></i>
                        រក្សាទុក
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>


@push('scripts')

<script>
    $(document).ready(function() {

        const assignedTeachersMap = @json($assignedTeachersMap);
        const enrolledStudentsMap = @json($enrolledStudentsMap);

        function initSelect2(selector, modalId) {
            $(selector).select2({
                theme: 'bootstrap4',
                width: '100%',
                dropdownParent: $(modalId)
            });
        }

        $('.btn-assign-teacher').click(function() {

            const courseId = $(this).data('course-id');

            $('#assign_teacher_course_id').val(courseId);

            const assignedIds = assignedTeachersMap[courseId] || [];

            $('#assign_teacher_id option').each(function() {

                const teacherId = $(this).val();

                if (teacherId === "") {
                    return;
                }

                if (assignedIds.includes(parseInt(teacherId))) {
                    $(this).prop('disabled', true);
                } else {
                    $(this).prop('disabled', false);
                }

            });

            $('#assign_teacher_id').val(null);

            $('#assignTeacherModal').modal('show');

            initSelect2(
                '#assign_teacher_id',
                '#assignTeacherModal'
            );

        });


        $('.btn-enroll-student').click(function() {

            const courseId = $(this).data('course-id');

            $('#enroll_student_course_id').val(courseId);

            const enrolledIds = enrolledStudentsMap[courseId] || [];

            $('#enroll_student_id option').each(function() {

                const studentId = $(this).val();

                if (studentId === "") {
                    return;
                }

                if (enrolledIds.includes(parseInt(studentId))) {
                    $(this).prop('disabled', true);
                } else {
                    $(this).prop('disabled', false);
                }

            });

            $('#enroll_student_id').val(null);

            $('#enrollStudentModal').modal('show');

            initSelect2(
                '#enroll_student_id',
                '#enrollStudentModal'
            );

        });


        @if ($errors->any())

            alert('Please check the form and try again.');

        @endif

    });
</script>

@endpush

@endauth


@push('scripts')

<script>

    (function () {

        var grid = document.getElementById('courseCardGrid');

        if (!grid) {
            return;
        }

        var cards = Array.prototype.slice.call(
            grid.querySelectorAll('[data-course-card]')
        );

        var searchInput =
            document.getElementById('courseSearchInput');

        var searchClear =
            document.getElementById('courseSearchClear');

        var categoryFilter =
            document.getElementById('courseCategoryFilter');

        var statusFilter =
            document.getElementById('courseStatusFilter');

        var sortSelect =
            document.getElementById('courseSort');

        var pageSizeSelect =
            document.getElementById('coursePageSize');

        var counter =
            document.getElementById('courseResultCount');

        var noResults =
            document.getElementById('courseNoResults');

        var resetButton =
            document.getElementById('courseResetFilters');

        var pager =
            document.getElementById('coursePager');

        var pageNumbers =
            document.getElementById('coursePageNumbers');

        var debounceTimer = null;

        var currentPage = 1;

        var totalCourses = cards.length;


        if (totalCourses === 0) {
            return;
        }


        function fieldValue(element) {

            return element
                ? String(element.value || '')
                : '';

        }


        function perPageCount(listLength) {

            var size =
                fieldValue(pageSizeSelect) || '9';

            if (size === 'all') {

                return listLength > 0
                    ? listLength
                    : 1;

            }

            return parseInt(size, 10) || 9;

        }


        function sortCards() {

            var mode =
                fieldValue(sortSelect) || 'newest';

            var sorted =
                cards.slice().sort(function(first, second) {

                    var firstNumber;
                    var secondNumber;

                    switch (mode) {

                        case 'name':

                            return (
                                first.dataset.name || ''
                            ).localeCompare(
                                second.dataset.name || ''
                            );

                        case 'code':

                            return (
                                first.dataset.code || ''
                            ).localeCompare(
                                second.dataset.code || ''
                            );

                        case 'enrollments':

                            firstNumber =
                                parseInt(
                                    first.dataset.enrollments || '0',
                                    10
                                ) || 0;

                            secondNumber =
                                parseInt(
                                    second.dataset.enrollments || '0',
                                    10
                                ) || 0;

                            return secondNumber - firstNumber;

                        case 'lessons':

                            firstNumber =
                                parseInt(
                                    first.dataset.lessons || '0',
                                    10
                                ) || 0;

                            secondNumber =
                                parseInt(
                                    second.dataset.lessons || '0',
                                    10
                                ) || 0;

                            return secondNumber - firstNumber;

                        default:

                            firstNumber =
                                parseInt(
                                    first.dataset.order || '0',
                                    10
                                ) || 0;

                            secondNumber =
                                parseInt(
                                    second.dataset.order || '0',
                                    10
                                ) || 0;

                            return secondNumber - firstNumber;
                    }

                });


            sorted.forEach(function(card) {

                grid.appendChild(card);

            });

        }


        function matchingCards() {

            var term =
                fieldValue(searchInput)
                    .trim()
                    .toLowerCase();

            var category =
                fieldValue(categoryFilter);

            var status =
                fieldValue(statusFilter);


            return cards.filter(function(card) {

                if (
                    term !== '' &&
                    (card.dataset.search || '')
                        .indexOf(term) === -1
                ) {
                    return false;
                }


                if (
                    category !== '' &&
                    card.dataset.category !== category
                ) {
                    return false;
                }


                if (
                    status !== '' &&
                    card.dataset.status !== status
                ) {
                    return false;
                }


                return true;

            });

        }


        function buildPager(totalPages) {

            if (!pager || !pageNumbers) {
                return;
            }

            pageNumbers.innerHTML = '';


            if (totalPages <= 1) {

                pager.classList.add('d-none');

                return;
            }


            pager.classList.remove('d-none');


            for (
                var page = 1;
                page <= totalPages;
                page++
            ) {

                var button =
                    document.createElement('button');

                button.type = 'button';

                button.className =
                    'course-page-btn' +
                    (
                        page === currentPage
                            ? ' is-active'
                            : ''
                    );

                button.setAttribute(
                    'data-page',
                    String(page)
                );

                button.textContent =
                    String(page);


                if (page === currentPage) {

                    button.setAttribute(
                        'aria-current',
                        'page'
                    );

                }


                pageNumbers.appendChild(button);

            }


            var previous =
                pager.querySelector(
                    '[data-page="prev"]'
                );

            var next =
                pager.querySelector(
                    '[data-page="next"]'
                );


            if (previous) {

                previous.disabled =
                    currentPage === 1;

            }


            if (next) {

                next.disabled =
                    currentPage >= totalPages;

            }

        }


        function render() {

            var list =
                matchingCards();

            var perPage =
                perPageCount(list.length);

            var totalPages =
                Math.max(
                    1,
                    Math.ceil(
                        list.length / perPage
                    )
                );

            var from;
            var to;


            if (currentPage > totalPages) {

                currentPage =
                    totalPages;

            }


            cards.forEach(function(card) {

                card.classList.add('d-none');

            });


            var visible =
                list.slice(
                    (currentPage - 1) * perPage,
                    currentPage * perPage
                );


            visible.forEach(function(card) {

                card.classList.remove('d-none');

            });


            if (noResults) {

                noResults.classList.toggle(
                    'd-none',
                    list.length !== 0
                );

            }


            if (counter) {

                if (list.length === 0) {

                    counter.textContent =
                        'មិនមានលទ្ធផល (No results)';

                } else {

                    from =
                        (currentPage - 1) *
                        perPage + 1;

                    to =
                        from +
                        visible.length - 1;


                    counter.textContent =
                        'បង្ហាញ ' +
                        from +
                        '–' +
                        to +
                        ' នៃ ' +
                        list.length +
                        ' វគ្គសិក្សា' +
                        (
                            list.length === totalCourses
                                ? ''
                                : ' (ចម្រាញ់ពី ' +
                                  totalCourses +
                                  ')'
                        );

                }

            }


            buildPager(totalPages);

        }


        function refresh() {

            currentPage = 1;

            render();

        }


        if (searchInput) {

            searchInput.addEventListener(
                'input',
                function() {

                    window.clearTimeout(
                        debounceTimer
                    );

                    debounceTimer =
                        window.setTimeout(
                            refresh,
                            150
                        );

                }
            );

        }


        if (searchClear) {

            searchClear.addEventListener(
                'click',
                function() {

                    if (searchInput) {

                        searchInput.value = '';

                        searchInput.focus();

                    }

                    refresh();

                }
            );

        }


        [
            categoryFilter,
            statusFilter,
            pageSizeSelect
        ].forEach(function(element) {

            if (element) {

                element.addEventListener(
                    'change',
                    refresh
                );

            }

        });


        if (sortSelect) {

            sortSelect.addEventListener(
                'change',
                function() {

                    sortCards();

                    refresh();

                }
            );

        }


        if (pager) {

            pager.addEventListener(
                'click',
                function(event) {

                    var button =
                        event.target.closest(
                            '[data-page]'
                        );


                    if (!button || button.disabled) {
                        return;
                    }


                    var target =
                        button.getAttribute(
                            'data-page'
                        );

                    var list =
                        matchingCards();

                    var totalPages =
                        Math.max(
                            1,
                            Math.ceil(
                                list.length /
                                perPageCount(list.length)
                            )
                        );


                    if (target === 'prev') {

                        currentPage =
                            Math.max(
                                1,
                                currentPage - 1
                            );

                    } else if (target === 'next') {

                        currentPage =
                            Math.min(
                                totalPages,
                                currentPage + 1
                            );

                    } else {

                        currentPage =
                            parseInt(
                                target,
                                10
                            ) || 1;

                    }


                    render();


                    window.scrollTo(
                        0,
                        Math.max(
                            0,
                            grid.getBoundingClientRect().top +
                            window.pageYOffset -
                            90
                        )
                    );

                }
            );

        }


        if (resetButton) {

            resetButton.addEventListener(
                'click',
                function() {

                    if (searchInput) {
                        searchInput.value = '';
                    }

                    if (categoryFilter) {
                        categoryFilter.value = '';
                    }

                    if (statusFilter) {
                        statusFilter.value = '';
                    }

                    if (sortSelect) {
                        sortSelect.value = 'newest';
                    }

                    if (pageSizeSelect) {
                        pageSizeSelect.value = '9';
                    }


                    sortCards();

                    refresh();

                }
            );

        }


        sortCards();

        render();

    })();

</script>

@endpush

@endsection
```
