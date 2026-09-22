@extends('layouts.master')

@section('title', 'កែប្រែគ្រូបង្រៀន | LMS')

@section('content')

<style>
    /* ==========================================================
       Teacher Edit Page — PREMIUM LMS UI (View-only styling)
       ========================================================== */

    :root {
        --tp-ink: #0f172a;
        --tp-slate: #475569;
        --tp-muted: #94a3b8;
        --tp-border: #e9ecf2;
        --tp-surface: #ffffff;
        --tp-accent: #4338ca;
        --tp-accent-soft: #eef0ff;
        --tp-accent-2: #7c3aed;
    }

    .teachers-page-header {
        margin-bottom: 1.75rem;
    }

    .teachers-page-header .page-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        background: linear-gradient(145deg, var(--tp-accent), var(--tp-accent-2));
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        margin-right: 0.95rem;
        flex-shrink: 0;
        box-shadow: 0 8px 20px -6px rgba(67, 56, 202, 0.45);
    }

    .teachers-page-header h1 {
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--tp-ink);
        margin-bottom: 0.15rem;
        letter-spacing: -0.02em;
    }

    .teachers-page-header .text-muted {
        font-size: 0.875rem;
        color: var(--tp-muted) !important;
        letter-spacing: 0.01em;
    }

    .teachers-page-header .breadcrumb {
        background: transparent;
        padding: 0;
        margin: 0;
        font-size: 0.8rem;
    }

    .teachers-page-header .breadcrumb-item a {
        color: var(--tp-slate);
        text-decoration: none;
        font-weight: 500;
    }

    .teachers-page-header .breadcrumb-item.active {
        color: var(--tp-accent);
        font-weight: 700;
    }

    /* ---------- Card ---------- */
    .teachers-card {
        border: none;
        border-radius: 20px;
        background: var(--tp-surface);
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04), 0 20px 40px -24px rgba(15, 23, 42, 0.18);
        overflow: hidden;
        position: relative;
    }

    .teachers-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--tp-accent), var(--tp-accent-2), var(--tp-accent));
    }

    .teachers-card .card-header {
        background: #fff;
        border-bottom: 1px solid var(--tp-border);
        padding: 1.4rem 1.75rem;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.85rem;
    }

    .teachers-card .card-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--tp-ink);
        display: flex;
        align-items: center;
        gap: 0.6rem;
        letter-spacing: -0.01em;
    }

    .teachers-card .card-body {
        padding: 2rem;
    }

    /* ---------- Form styling (wraps whatever _form partial outputs) ---------- */
    .teachers-card .card-body label {
        font-weight: 700;
        font-size: 0.85rem;
        color: #334155;
        margin-bottom: 0.45rem;
        letter-spacing: 0.005em;
    }

    .teachers-card .card-body .form-control,
    .teachers-card .card-body select.form-control,
    .teachers-card .card-body textarea.form-control {
        border: 1.5px solid var(--tp-border);
        border-radius: 12px;
        padding: 0.65rem 1rem;
        font-size: 0.875rem;
        color: var(--tp-ink);
        background: #fff;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }

    .teachers-card .card-body .form-control:focus {
        border-color: var(--tp-accent);
        box-shadow: 0 0 0 4px rgba(67, 56, 202, 0.1);
        outline: none;
    }

    .teachers-card .card-body .form-control-readonly {
        background: #f6f7fb;
        color: #94a3b8;
        cursor: not-allowed;
    }

    .teachers-card .card-body select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='12' height='8'><path d='M1 1l5 5 5-5' stroke='%236b7280' stroke-width='1.5' fill='none' fill-rule='evenodd'/></svg>");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        padding-right: 2.4rem;
    }

    .teachers-card .card-body .form-group {
        margin-bottom: 1.35rem;
    }

    .teachers-card .card-body .invalid-feedback,
    .teachers-card .card-body .text-danger {
        font-size: 0.78rem;
        font-weight: 500;
    }

    .teachers-card .card-body small.form-text {
        font-size: 0.78rem;
        color: #9ca3af;
    }

    .teachers-card .card-body .form-divider {
        border-top: 1px solid var(--tp-border);
        margin: 2rem 0;
    }

    .teachers-card .card-body .form-actions-bar {
        padding-top: 1.5rem;
        border-top: 1px solid var(--tp-border);
        margin-top: 2rem !important;
    }

    .teachers-card .card-body .btn-secondary {
        background: #fff;
        border: 1.5px solid var(--tp-border);
        color: #475569;
        font-weight: 700;
        font-size: 0.85rem;
        padding: 0.65rem 1.5rem;
        border-radius: 12px;
        transition: all 0.15s ease;
    }
    .teachers-card .card-body .btn-secondary:hover {
        background: #f8f9fc;
        color: var(--tp-ink);
        border-color: #d8dbe3;
    }

    .teachers-card .card-body .btn-primary {
        background: linear-gradient(135deg, var(--tp-accent), var(--tp-accent-2));
        border: none;
        color: #fff;
        font-weight: 700;
        font-size: 0.85rem;
        padding: 0.65rem 1.6rem;
        border-radius: 12px;
        box-shadow: 0 10px 22px -8px rgba(67, 56, 202, 0.5);
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    .teachers-card .card-body .btn-primary:hover {
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 14px 26px -8px rgba(67, 56, 202, 0.55);
    }

    /* ---------- Responsive ---------- */
    @media (max-width: 576px) {
        .teachers-card .card-body {
            padding: 1.4rem;
        }
    }
</style>

<section class="content-header px-0">
    <div class="container-fluid px-0">
        <div class="row mb-2 align-items-center teachers-page-header">
            <div class="col-sm-7 d-flex align-items-center">
                <span class="page-icon"><i class="fas fa-user-edit"></i></span>
                <div>
                    <h1 class="mb-1">កែប្រែគ្រូបង្រៀន</h1>
                    <p class="text-muted mb-0">កែប្រែព័ត៌មានគ្រូបង្រៀន។</p>
                </div>
            </div>
            <div class="col-sm-5">
                <ol class="breadcrumb float-sm-right mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">ផ្ទាំងគ្រប់គ្រង</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('teachers.index') }}">គ្រូបង្រៀន</a></li>
                    <li class="breadcrumb-item active">កែប្រែ</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="card teachers-card">
    <div class="card-header">
        <h3 class="card-title mb-0">
            <i class="fas fa-id-card" style="color:#4338ca;"></i>
            ព័ត៌មានគ្រូបង្រៀន
        </h3>
    </div>
    <form action="{{ route('teachers.update', $teacher) }}" method="POST">
        @method('PUT')
        <div class="card-body">
            @include('teachers._form')
        </div>
    </form>
</div>
@endsection