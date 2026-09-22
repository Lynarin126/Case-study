@extends('layouts.master')

@section('title', 'អ្នកប្រើប្រាស់ | LMS')

@section('content')

<style>
    /* ==========================================================
       User Management — PREMIUM LMS UI (View-only styling)
       ========================================================== */

    :root {
        --up-ink: #0f172a;
        --up-slate: #475569;
        --up-muted: #94a3b8;
        --up-border: #e9ecf2;
        --up-surface: #ffffff;
        --up-accent: #4338ca;
        --up-accent-soft: #eef0ff;
        --up-accent-2: #7c3aed;
        --up-success: #0f9d63;
        --up-success-soft: #e6f7ef;
    }

    .users-page-header {
        margin-bottom: 1.75rem;
    }

    .users-page-header .page-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        background: linear-gradient(145deg, var(--up-accent), var(--up-accent-2));
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        margin-right: 0.95rem;
        flex-shrink: 0;
        box-shadow: 0 8px 20px -6px rgba(67, 56, 202, 0.45);
    }

    .users-page-header h1 {
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--up-ink);
        margin-bottom: 0.15rem;
        letter-spacing: -0.02em;
    }

    .users-page-header .text-muted {
        font-size: 0.875rem;
        color: var(--up-muted) !important;
        letter-spacing: 0.01em;
    }

    .users-page-header .breadcrumb {
        background: transparent;
        padding: 0;
        margin: 0;
        font-size: 0.8rem;
    }

    .users-page-header .breadcrumb-item a {
        color: var(--up-slate);
        text-decoration: none;
        font-weight: 500;
    }

    .users-page-header .breadcrumb-item.active {
        color: var(--up-accent);
        font-weight: 700;
    }

    .alert-modern {
        border: none;
        border-radius: 14px;
        padding: 0.95rem 1.2rem;
        font-size: 0.9rem;
        background: var(--up-success-soft);
        color: #0b6b46;
        box-shadow: 0 4px 14px rgba(15, 157, 99, 0.08);
        border-left: 4px solid var(--up-success);
    }

    /* ---------- Card ---------- */
    .users-card {
        border: none;
        border-radius: 20px;
        background: var(--up-surface);
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04), 0 20px 40px -24px rgba(15, 23, 42, 0.18);
        overflow: hidden;
        position: relative;
    }

    .users-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--up-accent), var(--up-accent-2), var(--up-accent));
    }

    .users-card .card-header {
        background: #fff;
        border-bottom: 1px solid var(--up-border);
        padding: 1.4rem 1.75rem;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.85rem;
    }

    .users-card .card-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--up-ink);
        display: flex;
        align-items: center;
        gap: 0.6rem;
        letter-spacing: -0.01em;
    }

    .users-card .card-title .count-pill {
        background: var(--up-accent-soft);
        color: var(--up-accent);
        font-size: 0.72rem;
        font-weight: 800;
        padding: 0.22rem 0.7rem;
        border-radius: 999px;
        letter-spacing: 0.02em;
    }

    .users-card .card-body {
        padding: 0;
    }

    /* ---------- Buttons ---------- */
    .btn-add-user {
        background: linear-gradient(135deg, var(--up-accent), var(--up-accent-2));
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

    .btn-add-user:hover {
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

    .btn-icon-role {
        background: #eef6ff;
        color: #1d6fd8;
        border-color: #cfe5fb;
    }

    .btn-icon-role:hover {
        background: #1d6fd8;
        color: #fff;
        border-color: #1d6fd8;
        transform: translateY(-1px);
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
    .table-responsive-users {
        overflow-x: auto;
    }

    table.users-table {
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
        min-width: 800px;
    }

    table.users-table thead th {
        background: #fafbfd;
        color: #7c8598;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        border: none;
        border-bottom: 1px solid var(--up-border);
        padding: 1rem 1.2rem;
        white-space: nowrap;
    }

    table.users-table tbody td {
        border: none;
        border-bottom: 1px solid #f2f3f7;
        padding: 1rem 1.2rem;
        vertical-align: middle;
        font-size: 0.875rem;
        color: #334155;
    }

    table.users-table tbody tr {
        transition: background 0.18s ease;
    }

    table.users-table tbody tr:last-child td {
        border-bottom: none;
    }

    table.users-table tbody tr:hover {
        background: linear-gradient(90deg, #f8f8ff, #fafbff);
    }

    .row-index {
        color: var(--up-muted);
        font-weight: 700;
        font-size: 0.78rem;
    }

    .user-identity {
        display: flex;
        align-items: center;
        gap: 0.85rem;
    }

    .user-avatar {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: linear-gradient(150deg, var(--up-accent), var(--up-accent-2));
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

    .user-avatar::after {
        content: "";
        position: absolute;
        inset: -3px;
        border-radius: 14px;
        border: 1.5px solid rgba(67, 56, 202, 0.18);
    }

    .user-names .khmer-name {
        font-weight: 700;
        color: var(--up-ink);
        font-size: 0.92rem;
        line-height: 1.3;
        letter-spacing: -0.005em;
    }

    .user-names .latin-name {
        color: #8a93a6;
        font-size: 0.78rem;
        line-height: 1.3;
    }

    .email-cell {
        font-size: 0.85rem;
        color: #334155;
    }

    .email-cell i {
        color: #b7bfcf;
        margin-right: 0.4rem;
    }

    .date-cell {
        font-size: 0.82rem;
        color: #64748b;
        font-variant-numeric: tabular-nums;
    }

    .actions-cell {
        display: flex;
        align-items: center;
        gap: 0.45rem;
    }

    /* ---------- Empty state ---------- */
    .users-empty {
        text-align: center;
        padding: 4rem 1.5rem;
        color: var(--up-muted);
    }

    .users-empty .empty-icon {
        width: 64px;
        height: 64px;
        border-radius: 18px;
        background: var(--up-accent-soft);
        color: var(--up-accent);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        margin-bottom: 1rem;
    }

    .users-empty p {
        font-size: 0.9rem;
        font-weight: 500;
        color: #8a93a6;
    }

    /* ---------- Responsive ---------- */
    @media (max-width: 576px) {
        .users-card .card-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .btn-add-user {
            width: 100%;
            text-align: center;
        }
    }
</style>

<section class="content-header px-0">
    <div class="container-fluid px-0">
        <div class="row mb-2 align-items-center users-page-header">
            <div class="col-sm-7 d-flex align-items-center">
                <span class="page-icon"><i class="fas fa-users-cog"></i></span>
                <div>
                    <h1 class="mb-1">អ្នកប្រើប្រាស់</h1>
                    <p class="text-muted mb-0">គ្រប់គ្រងអ្នកប្រើប្រាស់ប្រព័ន្ធ។</p>
                </div>
            </div>
            <div class="col-sm-5">
                <ol class="breadcrumb float-sm-right mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">ផ្ទាំងគ្រប់គ្រង</a></li>
                    <li class="breadcrumb-item active">អ្នកប្រើប្រាស់</li>
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

<div class="card users-card">
    <div class="card-header">
        <h3 class="card-title mb-0">
            បញ្ជីអ្នកប្រើប្រាស់
            <span class="count-pill">{{ $users->count() }}</span>
        </h3>
        <a href="{{ route('users.create') }}" class="btn btn-add-user ml-auto">
            <i class="fas fa-plus mr-1"></i>
            បង្កើតថ្មី
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive-users">
            <table class="table users-table datatable">
                <thead>
                    <tr>
                        <th>ល.រ</th>
                        <th>អ្នកប្រើប្រាស់</th>
                        <th>អ៊ីមែល</th>
                        <th>ថ្ងៃបង្កើត</th>
                        <th class="text-center">សកម្មភាព</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td class="row-index">{{ $loop->iteration }}</td>
                            <td>
                                <div class="user-identity">
                                    <div class="user-avatar">
                                        {{ mb_strtoupper(mb_substr($user->khmer_name ?: $user->latin_name ?: '?', 0, 1)) }}
                                    </div>
                                    <div class="user-names">
                                        <div class="khmer-name">{{ $user->khmer_name ?: '-' }}</div>
                                        <div class="latin-name">{{ $user->latin_name ?: '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="email-cell"><i class="fas fa-envelope"></i>{{ $user->email }}</td>
                            <td class="date-cell">{{ $user->created_at?->format('Y-m-d') }}</td>
                            <td>
                                <div class="actions-cell justify-content-center">
                                    @can('roles.view')
                                        <a href="{{ route('admin.users.roles.edit', $user) }}" class="btn-icon-action btn-icon-role" title="កំណត់តួនាទី">
                                            <i class="fas fa-user-shield"></i>
                                        </a>
                                    @endcan
                                    <a href="{{ route('users.edit', $user) }}" class="btn-icon-action btn-icon-edit" title="កែប្រែ">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('តើអ្នកពិតជាចង់លុបមែនទេ?');">
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

                    @if ($users->count() === 0)
                        <tr>
                            <td colspan="5">
                                <div class="users-empty">
                                    <div class="empty-icon"><i class="fas fa-user-slash"></i></div>
                                    <p class="mb-0">មិនទាន់មានទិន្នន័យអ្នកប្រើប្រាស់នៅឡើយទេ</p>
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