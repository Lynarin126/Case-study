@extends('layouts.master')

@section('title', 'និស្សិត | LMS')

@section('content')

<style>
    /* ==========================================================
       Student Management — Modern LMS UI (View-only styling)
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

    .alert-modern {
        border: none;
        border-radius: 12px;
        padding: 0.9rem 1.1rem;
        font-size: 0.9rem;
        box-shadow: 0 2px 6px rgba(16, 24, 40, 0.06);
        border-left: 4px solid #16a34a;
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

    .students-card .card-title .count-pill {
        background: #f3f4f6;
        color: #4b5563;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.15rem 0.6rem;
        border-radius: 999px;
    }

    .students-card .card-body {
        padding: 0;
    }

    /* ---------- Buttons ---------- */
    .btn-add-student {
        background: #4f46e5;
        border: none;
        color: #fff;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 0.55rem 1.1rem;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(79, 70, 229, 0.25);
        transition: background 0.15s ease, transform 0.1s ease;
    }

    .btn-add-student:hover {
        background: #4338ca;
        color: #fff;
        transform: translateY(-1px);
    }

    .btn-icon-action {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        border: 1px solid transparent;
        font-size: 0.8rem;
        transition: all 0.15s ease;
    }

    .btn-icon-edit {
        background: #fff7ed;
        color: #c2760a;
        border-color: #fde3c0;
    }

    .btn-icon-edit:hover {
        background: #ffedd5;
        color: #9a5b08;
    }

    .btn-icon-delete {
        background: #fef2f2;
        color: #dc2626;
        border-color: #fecaca;
    }

    .btn-icon-delete:hover {
        background: #fee2e2;
        color: #b91c1c;
    }

    /* ---------- Table ---------- */
    .table-responsive-students {
        overflow-x: auto;
    }

    table.students-table {
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
        min-width: 900px;
    }

    table.students-table thead th {
        background: #f9fafb;
        color: #6b7280;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        border: none;
        border-bottom: 1px solid #eef0f3;
        padding: 0.85rem 1.1rem;
        white-space: nowrap;
    }

    table.students-table tbody td {
        border: none;
        border-bottom: 1px solid #f1f2f5;
        padding: 0.9rem 1.1rem;
        vertical-align: middle;
        font-size: 0.875rem;
        color: #374151;
    }

    table.students-table tbody tr {
        transition: background 0.15s ease;
    }

    table.students-table tbody tr:last-child td {
        border-bottom: none;
    }

    table.students-table tbody tr:hover {
        background: #f8f9fc;
    }

    .row-index {
        color: #9ca3af;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .student-code-pill {
        background: #f3f4f6;
        color: #4b5563;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.2rem 0.6rem;
        border-radius: 6px;
        display: inline-block;
        letter-spacing: 0.02em;
    }

    .student-identity {
        display: flex;
        align-items: center;
        gap: 0.7rem;
    }

    .student-avatar {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: linear-gradient(135deg, #eef2ff, #e0e7ff);
        color: #4f46e5;
        font-weight: 700;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .student-names .khmer-name {
        font-weight: 700;
        color: #1f2937;
        font-size: 0.9rem;
        line-height: 1.25;
    }

    .student-names .latin-name {
        color: #6b7280;
        font-size: 0.78rem;
        line-height: 1.25;
    }

    .gender-tag {
        font-size: 0.78rem;
        color: #4b5563;
        background: #f3f4f6;
        padding: 0.2rem 0.55rem;
        border-radius: 6px;
        display: inline-block;
    }

    .phone-cell {
        font-size: 0.85rem;
        color: #374151;
        white-space: nowrap;
    }

    .phone-cell i {
        color: #9ca3af;
        margin-right: 0.35rem;
    }

    /* ---------- Status badges ---------- */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.3rem 0.7rem;
        border-radius: 999px;
        line-height: 1;
    }

    .status-badge .dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        display: inline-block;
    }

    .status-active {
        background: #ecfdf5;
        color: #059669;
    }

    .status-active .dot {
        background: #10b981;
    }

    .status-inactive {
        background: #f3f4f6;
        color: #6b7280;
    }

    .status-inactive .dot {
        background: #9ca3af;
    }

    .actions-cell {
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    /* ---------- Empty state ---------- */
    .students-empty {
        text-align: center;
        padding: 3.5rem 1.5rem;
        color: #9ca3af;
    }

    .students-empty i {
        font-size: 2.25rem;
        margin-bottom: 0.75rem;
        color: #d1d5db;
    }

    /* ---------- Responsive ---------- */
    @media (max-width: 576px) {
        .students-card .card-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .btn-add-student {
            width: 100%;
            text-align: center;
        }
    }
</style>

<section class="content-header px-0">
    <div class="container-fluid px-0">
        <div class="row mb-2 align-items-center students-page-header">
            <div class="col-sm-7 d-flex align-items-center">
                <span class="page-icon"><i class="fas fa-user-graduate"></i></span>
                <div>
                    <h1 class="mb-1">និស្សិត</h1>
                    <p class="text-muted mb-0">គ្រប់គ្រងបញ្ជីនិស្សិតសម្រាប់ប្រព័ន្ធ LMS។</p>
                </div>
            </div>
            <div class="col-sm-5">
                <ol class="breadcrumb float-sm-right mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">ផ្ទាំងគ្រប់គ្រង</a></li>
                    <li class="breadcrumb-item active">និស្សិត</li>
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

<div class="card students-card">
    <div class="card-header">
        <h3 class="card-title mb-0">
            បញ្ជីនិស្សិត
            <span class="count-pill">{{ $students->count() }}</span>
        </h3>
        <a href="{{ route('students.create') }}" class="btn btn-add-student ml-auto">
            <i class="fas fa-plus mr-1"></i>
            បង្កើតថ្មី
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive-students">
            <table class="table students-table datatable">
                <thead>
                    <tr>
                        <th>ល.រ</th>
                        <th>កូដ</th>
                        <th>និស្សិត</th>
                        <th>ភេទ</th>
                        <th>លេខទូរស័ព្ទ</th>
                        <th>ស្ថានភាព</th>
                        <th class="text-center">សកម្មភាព</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td class="row-index">{{ $loop->iteration }}</td>
                            <td><span class="student-code-pill">{{ $student->student_code }}</span></td>
                            <td>
                                <div class="student-identity">
                                    <div class="student-avatar">
                                        {{ mb_strtoupper(mb_substr($student->khmer_name ?: $student->latin_name ?: '?', 0, 1)) }}
                                    </div>
                                    <div class="student-names">
                                        <div class="khmer-name">{{ $student->khmer_name ?: '-' }}</div>
                                        <div class="latin-name">{{ $student->latin_name ?: '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="gender-tag">{{ $student->gender }}</span></td>
                            <td class="phone-cell"><i class="fas fa-phone-alt"></i>{{ $student->phone }}</td>
                            <td>
                                @if($student->status == 'active')
                                    <span class="status-badge status-active"><span class="dot"></span>សកម្ម</span>
                                @else
                                    <span class="status-badge status-inactive"><span class="dot"></span>ផ្អាក</span>
                                @endif
                            </td>
                            <td>
                                <div class="actions-cell justify-content-center">
                                    <a href="{{ route('students.edit', $student) }}" class="btn-icon-action btn-icon-edit" title="កែសម្រួល">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline" onsubmit="return confirm('តើអ្នកពិតជាចង់លុបមែនទេ?');">
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

                    @if ($students->count() === 0)
                        <tr>
                            <td colspan="7">
                                <div class="students-empty">
                                    <i class="fas fa-user-slash"></i>
                                    <p class="mb-0">មិនទាន់មានទិន្នន័យនិស្សិតនៅឡើយទេ</p>
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