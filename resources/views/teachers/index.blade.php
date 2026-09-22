@extends('layouts.master')

@section('title', 'គ្រូបង្រៀន | LMS')

@section('content')

<style>
    /* ==========================================================
       Teacher Management — PREMIUM LMS UI (View-only styling)
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
        --tp-success: #0f9d63;
        --tp-success-soft: #e6f7ef;
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

    .alert-modern {
        border: none;
        border-radius: 14px;
        padding: 0.95rem 1.2rem;
        font-size: 0.9rem;
        background: var(--tp-success-soft);
        color: #0b6b46;
        box-shadow: 0 4px 14px rgba(15, 157, 99, 0.08);
        border-left: 4px solid var(--tp-success);
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

    .teachers-card .card-title .count-pill {
        background: var(--tp-accent-soft);
        color: var(--tp-accent);
        font-size: 0.72rem;
        font-weight: 800;
        padding: 0.22rem 0.7rem;
        border-radius: 999px;
        letter-spacing: 0.02em;
    }

    .teachers-card .card-body {
        padding: 0;
    }

    /* ---------- Buttons ---------- */
    .btn-add-teacher {
        background: linear-gradient(135deg, var(--tp-accent), var(--tp-accent-2));
        border: none;
        color: #fff;
        font-weight: 700;
        font-size: 0.85rem;
        padding: 0.65rem 1.35rem;
        border-radius: 12px;
        box-shadow: 0 10px 22px -8px rgba(67, 56, 202, 0.5);
        transition: transform 0.15s ease, box-shadow 0.15s ease;
        letter-spacing: 0.01em;
    }

    .btn-add-teacher:hover {
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 14px 26px -8px rgba(67, 56, 202, 0.55);
    }

    .btn-icon-action {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        border: 1px solid transparent;
        font-size: 0.8rem;
        transition: all 0.18s ease;
    }

    .btn-icon-edit {
        background: #fdf6ec;
        color: #b4740a;
        border-color: #f3e2c2;
    }

    .btn-icon-edit:hover {
        background: #b4740a;
        color: #fff;
        border-color: #b4740a;
        transform: translateY(-1px);
    }

    .btn-icon-delete {
        background: #fdf1f1;
        color: #c62839;
        border-color: #f4d3d6;
    }

    .btn-icon-delete:hover {
        background: #c62839;
        color: #fff;
        border-color: #c62839;
        transform: translateY(-1px);
    }

    /* ---------- Table ---------- */
    .table-responsive-teachers {
        overflow-x: auto;
    }

    table.teachers-table {
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
        min-width: 920px;
    }

    table.teachers-table thead th {
        background: #fafbfd;
        color: #7c8598;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        border: none;
        border-bottom: 1px solid var(--tp-border);
        padding: 1rem 1.2rem;
        white-space: nowrap;
    }

    table.teachers-table tbody td {
        border: none;
        border-bottom: 1px solid #f2f3f7;
        padding: 1rem 1.2rem;
        vertical-align: middle;
        font-size: 0.875rem;
        color: #334155;
    }

    table.teachers-table tbody tr {
        transition: background 0.18s ease;
    }

    table.teachers-table tbody tr:last-child td {
        border-bottom: none;
    }

    table.teachers-table tbody tr:hover {
        background: linear-gradient(90deg, #f8f8ff, #fafbff);
    }

    .row-index {
        color: var(--tp-muted);
        font-weight: 700;
        font-size: 0.78rem;
    }

    .teacher-code-pill {
        background: #f4f5f9;
        color: #475569;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 0.25rem 0.65rem;
        border-radius: 7px;
        display: inline-block;
        letter-spacing: 0.03em;
        border: 1px solid #eceef3;
    }

    .teacher-identity {
        display: flex;
        align-items: center;
        gap: 0.85rem;
    }

    .teacher-avatar {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: linear-gradient(150deg, var(--tp-accent), var(--tp-accent-2));
        color: #fff;
        font-weight: 800;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 6px 14px -5px rgba(67, 56, 202, 0.45);
        position: relative;
    }

    .teacher-avatar::after {
        content: "";
        position: absolute;
        inset: -3px;
        border-radius: 14px;
        border: 1.5px solid rgba(67, 56, 202, 0.18);
    }

    .teacher-names .khmer-name {
        font-weight: 700;
        color: var(--tp-ink);
        font-size: 0.92rem;
        line-height: 1.3;
        letter-spacing: -0.005em;
    }

    .teacher-names .latin-name {
        color: #8a93a6;
        font-size: 0.78rem;
        line-height: 1.3;
    }

    .gender-tag {
        font-size: 0.76rem;
        font-weight: 600;
        color: #56607a;
        background: #f4f5f9;
        padding: 0.25rem 0.65rem;
        border-radius: 7px;
        display: inline-block;
        border: 1px solid #eceef3;
    }

    .phone-cell {
        font-size: 0.85rem;
        color: #334155;
        white-space: nowrap;
        font-variant-numeric: tabular-nums;
    }

    .phone-cell i {
        color: #b7bfcf;
        margin-right: 0.4rem;
    }

    /* ---------- Status badges ---------- */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.74rem;
        font-weight: 700;
        padding: 0.32rem 0.75rem;
        border-radius: 999px;
        line-height: 1;
        letter-spacing: 0.01em;
    }

    .status-badge .dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        display: inline-block;
        box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.03);
    }

    .status-active {
        background: var(--tp-success-soft);
        color: #0b6b46;
    }

    .status-active .dot {
        background: #10b981;
    }

    .status-inactive {
        background: #f1f2f6;
        color: #6b7280;
    }

    .status-inactive .dot {
        background: #9ca3af;
    }

    .actions-cell {
        display: flex;
        align-items: center;
        gap: 0.45rem;
    }

    /* ---------- Empty state ---------- */
    .teachers-empty {
        text-align: center;
        padding: 4rem 1.5rem;
        color: var(--tp-muted);
    }

    .teachers-empty .empty-icon {
        width: 64px;
        height: 64px;
        border-radius: 18px;
        background: var(--tp-accent-soft);
        color: var(--tp-accent);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        margin-bottom: 1rem;
    }

    .teachers-empty p {
        font-size: 0.9rem;
        font-weight: 500;
        color: #8a93a6;
    }

    /* ---------- Responsive ---------- */
    @media (max-width: 576px) {
        .teachers-card .card-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .btn-add-teacher {
            width: 100%;
            text-align: center;
        }
    }
</style>

<section class="content-header px-0">
    <div class="container-fluid px-0">
        <div class="row mb-2 align-items-center teachers-page-header">
            <div class="col-sm-7 d-flex align-items-center">
                <span class="page-icon"><i class="fas fa-chalkboard-teacher"></i></span>
                <div>
                    <h1 class="mb-1">គ្រូបង្រៀន</h1>
                    <p class="text-muted mb-0">គ្រប់គ្រងបញ្ជីគ្រូបង្រៀនសម្រាប់ប្រព័ន្ធ LMS។</p>
                </div>
            </div>
            <div class="col-sm-5">
                <ol class="breadcrumb float-sm-right mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">ផ្ទាំងគ្រប់គ្រង</a></li>
                    <li class="breadcrumb-item active">គ្រូបង្រៀន</li>
                </ol>
            </div>
        </div>
    </div>
</section>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show alert-modern" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="card teachers-card">
    <div class="card-header">
        <h3 class="card-title mb-0">
            បញ្ជីគ្រូបង្រៀន
            <span class="count-pill">{{ $teachers->count() }}</span>
        </h3>
        <a href="{{ route('teachers.create') }}" class="btn btn-add-teacher ml-auto">
            <i class="fas fa-plus mr-1"></i>
            បង្កើតថ្មី
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive-teachers">
            <table class="table teachers-table datatable">
                <thead>
                    <tr>
                        <th>ល.រ</th>
                        <th>កូដ</th>
                        <th>គ្រូបង្រៀន</th>
                        <th>ភេទ</th>
                        <th>លេខទូរស័ព្ទ</th>
                        <th>ស្ថានភាព</th>
                        <th class="text-center">សកម្មភាព</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($teachers as $teacher)
                        <tr>
                            <td class="row-index">{{ $loop->iteration }}</td>
                            <td><span class="teacher-code-pill">{{ $teacher->teacher_code }}</span></td>
                            <td>
                                <div class="teacher-identity">
                                    <div class="teacher-avatar">
                                        {{ mb_strtoupper(mb_substr($teacher->khmer_name ?: $teacher->latin_name ?: '?', 0, 1)) }}
                                    </div>
                                    <div class="teacher-names">
                                        <div class="khmer-name">{{ $teacher->khmer_name ?: '-' }}</div>
                                        <div class="latin-name">{{ $teacher->latin_name ?: '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="gender-tag">{{ $teacher->gender }}</span></td>
                            <td class="phone-cell"><i class="fas fa-phone-alt"></i>{{ $teacher->phone }}</td>
                            <td>
                                @if($teacher->status == 'active')
                                    <span class="status-badge status-active"><span class="dot"></span>សកម្ម</span>
                                @else
                                    <span class="status-badge status-inactive"><span class="dot"></span>ផ្អាក</span>
                                @endif
                            </td>
                            <td>
                                <div class="actions-cell justify-content-center">
                                    <a href="{{ route('teachers.edit', $teacher) }}" class="btn-icon-action btn-icon-edit" title="កែសម្រួល">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('teachers.destroy', $teacher) }}" method="POST" class="d-inline" onsubmit="return confirm('តើអ្នកពិតជាចង់លុបមែនទេ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon-action btn-icon-delete" title="លុប">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    @if ($teachers->count() === 0)
                        <tr>
                            <td colspan="7">
                                <div class="teachers-empty">
                                    <div class="empty-icon"><i class="fas fa-chalkboard"></i></div>
                                    <p class="mb-0">មិនទាន់មានទិន្នន័យគ្រូបង្រៀននៅឡើយទេ</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection