@extends('layouts.master')

@section('title', 'បង្កើតវគ្គសិក្សា | LMS')

@section('content')

<style>
    .course-form-page {
        --cp-surface: #ffffff;
        --cp-soft: #f4f6f9;
        --cp-border: #e3e8ef;
        --cp-text: #1f2937;
        --cp-muted: #64748b;
        --cp-radius: .75rem;
        --cp-shadow: 0 1px 2px rgba(16, 24, 40, .05), 0 1px 3px rgba(16, 24, 40, .06);
    }

    .dark-mode .course-form-page {
        --cp-surface: #343a40;
        --cp-soft: #3d444b;
        --cp-border: #4b545c;
        --cp-text: #f1f3f5;
        --cp-muted: #adb5bd;
        --cp-shadow: none;
    }

    /* ---------- Page header ---------- */
    .course-form-page .content-header {
        padding-top: .25rem;
        padding-bottom: 1.25rem;
    }

    .course-form-page .course-page-header {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        justify-content: space-between;
        gap: 1rem;
    }

    .course-form-page .course-page-heading {
        flex: 1 1 20rem;
        min-width: 0;
    }

    .course-form-page .course-breadcrumb {
        margin: 0 0 .5rem;
        padding: 0;
        background: transparent;
        font-size: .8125rem;
    }

    .course-form-page .course-page-title {
        margin: 0 0 .25rem;
        font-size: 1.65rem;
        font-weight: 700;
        line-height: 1.45;
        color: var(--cp-text);
    }

    .course-form-page .course-page-subtitle {
        margin: 0;
        font-size: .9rem;
        line-height: 1.6;
        color: var(--cp-muted);
    }

    .course-form-page .course-page-header-actions {
        flex: 0 0 auto;
    }

    .course-form-page .course-page-header-actions .btn {
        height: 2.5rem;
        padding: 0 1.1rem;
        border-radius: .5rem;
        font-weight: 500;
    }

    /* ---------- Form card ---------- */
    .course-form-page .course-form-card {
        max-width: 60rem;
        margin-bottom: 1.5rem;
        background: var(--cp-surface);
        border: 1px solid var(--cp-border);
        border-radius: var(--cp-radius);
        box-shadow: var(--cp-shadow);
    }

    .course-form-page .course-form-card .card-header {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: 1rem 1.25rem;
        background: transparent;
        border-bottom: 1px solid var(--cp-border);
    }

    .course-form-page .course-form-card-icon {
        display: inline-flex;
        flex: 0 0 auto;
        align-items: center;
        justify-content: center;
        width: 2.25rem;
        height: 2.25rem;
        border-radius: .6rem;
        background: rgba(0, 123, 255, .1);
        font-size: .95rem;
        color: var(--primary, #007bff);
    }

    .course-form-page .course-form-card .card-title {
        float: none;
        margin: 0;
        font-size: 1.05rem;
        font-weight: 600;
        line-height: 1.6;
        color: var(--cp-text);
    }

    .course-form-page .course-form-card .card-body {
        padding: 1.5rem 1.25rem;
    }

    /* ---------- Fields rendered by courses._form ---------- */
    .course-form-page .course-form-card .form-group {
        margin-bottom: 1.1rem;
    }

    .course-form-page .course-form-card label {
        margin-bottom: .35rem;
        font-size: .875rem;
        font-weight: 600;
        color: var(--cp-text);
    }

    .course-form-page .course-form-card .form-control,
    .course-form-page .course-form-card .custom-select {
        border-color: var(--cp-border);
        border-radius: .5rem;
        font-size: .9rem;
        box-shadow: none;
    }

    .course-form-page .course-form-card .form-control:focus,
    .course-form-page .course-form-card .custom-select:focus {
        border-color: var(--primary, #007bff);
        box-shadow: 0 0 0 .2rem rgba(0, 123, 255, .15);
    }

    .course-form-page .course-form-card .form-control.is-invalid,
    .course-form-page .course-form-card .custom-select.is-invalid {
        border-color: #dc3545;
    }

    .course-form-page .course-form-card .invalid-feedback,
    .course-form-page .course-form-card .text-danger {
        font-size: .8125rem;
    }

    .course-form-page .course-form-card .btn {
        height: 2.5rem;
        padding: 0 1.1rem;
        border-radius: .5rem;
        font-weight: 500;
    }

    /* ---------- Responsive ---------- */
    @media (max-width: 575.98px) {
        .course-form-page .course-page-title { font-size: 1.4rem; }
        .course-form-page .course-page-header-actions { width: 100%; }
        .course-form-page .course-page-header-actions .btn { width: 100%; }
        .course-form-page .course-form-card .card-body { padding: 1.1rem 1rem; }
        .course-form-page .course-form-card .btn { height: 2.6rem; }
    }
</style>

<div class="course-form-page">

<section class="content-header px-0">
    <div class="container-fluid px-0">
        <div class="course-page-header">
            <div class="course-page-heading">
                <ol class="breadcrumb course-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">ផ្ទាំងគ្រប់គ្រង</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">វគ្គសិក្សា</a></li>
                    <li class="breadcrumb-item active">បង្កើតថ្មី</li>
                </ol>
                <h1 class="course-page-title">បង្កើតវគ្គសិក្សា</h1>
                <p class="course-page-subtitle">បញ្ចូលព័ត៌មានវគ្គសិក្សាថ្មី។</p>
            </div>
            <div class="course-page-header-actions">
                <a href="{{ route('courses.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left mr-1" aria-hidden="true"></i>ត្រឡប់ក្រោយ (Back)
                </a>
            </div>
        </div>
    </div>
</section>

<div class="card course-form-card">
    <div class="card-header">
        <span class="course-form-card-icon"><i class="fas fa-book-open" aria-hidden="true"></i></span>
        <h3 class="card-title">ព័ត៌មានវគ្គសិក្សា</h3>
    </div>
    <form action="{{ route('courses.store') }}" method="POST">
        <div class="card-body">
            @include('courses._form')
        </div>
    </form>
</div>

</div>{{-- /.course-form-page --}}
@endsection