@extends('layouts.master')

@section('title', 'កែប្រែនិស្សិត | LMS')

@section('content')

<style>
    /* ==========================================================
       Student Edit Page — Modern LMS UI (View-only styling)
       ========================================================== */

    .students-page-header {
        margin-bottom: 1.5rem;
    }

    .students-page-header .page-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        background: #eef2ff;
        color: #4f46e5;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        margin-right: 0.85rem;
        flex-shrink: 0;
    }

    .students-page-header h1 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.15rem;
        letter-spacing: -0.01em;
    }

    .students-page-header .text-muted {
        font-size: 0.875rem;
        color: #8a94a6 !important;
    }

    .students-page-header .breadcrumb {
        background: transparent;
        padding: 0;
        margin: 0;
        font-size: 0.8125rem;
    }

    .students-page-header .breadcrumb-item a {
        color: #6b7280;
        text-decoration: none;
    }

    .students-page-header .breadcrumb-item.active {
        color: #4f46e5;
        font-weight: 600;
    }

    /* ---------- Card ---------- */
    .students-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(16, 24, 40, 0.06), 0 8px 24px -12px rgba(16, 24, 40, 0.08);
        overflow: hidden;
    }

    .students-card .card-header {
        background: #fff;
        border-bottom: 1px solid #eef0f3;
        padding: 1.15rem 1.5rem;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .students-card .card-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #1f2937;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .students-card .card-body {
        padding: 1.75rem;
    }

    /* ---------- Form styling (wraps whatever _form partial outputs) ---------- */
    .students-card .card-body label {
        font-weight: 600;
        font-size: 0.85rem;
        color: #374151;
        margin-bottom: 0.4rem;
    }

    .students-card .card-body .form-control,
    .students-card .card-body select.form-control,
    .students-card .card-body textarea.form-control {
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 0.6rem 0.9rem;
        font-size: 0.875rem;
        color: #1f2937;
        background: #fff;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }

    .students-card .card-body .form-control:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
        outline: none;
    }

    .students-card .card-body .form-group {
        margin-bottom: 1.25rem;
    }

    .students-card .card-body .invalid-feedback,
    .students-card .card-body .text-danger {
        font-size: 0.78rem;
    }

    /* ---------- Footer / submit actions ---------- */
    .form-footer-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 0.6rem;
        padding: 1.1rem 1.75rem;
        background: #f9fafb;
        border-top: 1px solid #eef0f3;
    }

    .btn-save-student {
        background: #4f46e5;
        border: none;
        color: #fff;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 0.6rem 1.4rem;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(79, 70, 229, 0.25);
        transition: background 0.15s ease, transform 0.1s ease;
    }

    .btn-save-student:hover {
        background: #4338ca;
        color: #fff;
        transform: translateY(-1px);
    }

    .btn-cancel-student {
        background: #fff;
        border: 1px solid #e5e7eb;
        color: #4b5563;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 0.6rem 1.4rem;
        border-radius: 10px;
        transition: all 0.15s ease;
    }

    .btn-cancel-student:hover {
        background: #f9fafb;
        color: #1f2937;
        text-decoration: none;
    }

    /* ---------- Responsive ---------- */
    @media (max-width: 576px) {
        .students-card .card-body {
            padding: 1.25rem;
        }

        .form-footer-actions {
            flex-direction: column-reverse;
            align-items: stretch;
        }

        .btn-save-student,
        .btn-cancel-student {
            width: 100%;
            text-align: center;
        }
    }
</style>

<section class="content-header px-0">
    <div class="container-fluid px-0">
        <div class="row mb-2 align-items-center students-page-header">
            <div class="col-sm-7 d-flex align-items-center">
                <span class="page-icon"><i class="fas fa-user-edit"></i></span>
                <div>
                    <h1 class="mb-1">កែប្រែនិស្សិត</h1>
                    <p class="text-muted mb-0">កែប្រែព័ត៌មាននិស្សិត។</p>
                </div>
            </div>
            <div class="col-sm-5">
                <ol class="breadcrumb float-sm-right mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">ផ្ទាំងគ្រប់គ្រង</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('students.index') }}">និស្សិត</a></li>
                    <li class="breadcrumb-item active">កែប្រែ</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="card students-card">
    <div class="card-header">
        <h3 class="card-title mb-0">
            <i class="fas fa-id-card" style="color:#4f46e5;"></i>
            ព័ត៌មាននិស្សិត
        </h3>
    </div>
    <form action="{{ route('students.update', $student) }}" method="POST">
        @method('PUT')
        <div class="card-body">
            @include('students._form')
        </div>
        <div class="form-footer-actions">
            <a href="{{ route('students.index') }}" class="btn btn-cancel-student">
                <i class="fas fa-times mr-1"></i>
                បោះបង់
            </a>
            <button type="submit" class="btn btn-save-student">
                <i class="fas fa-save mr-1"></i>
                រក្សាទុក
            </button>
        </div>
    </form>
</div>
@endsection