@extends('layouts.master')

@section('title', 'មហាវិទ្យាល័យ | LMS')

@push('styles')
<style>
    .page-header-premium {
        margin-bottom: 1.75rem;
    }
    .page-header-premium h1 {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e2432;
        letter-spacing: -0.01em;
    }
    .page-header-premium h1 i {
        font-size: 1.15rem;
        color: #4f46e5;
        background: #eef0ff;
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
    }
    .page-header-premium p {
        font-size: 0.88rem;
        color: #8a8f98;
        margin: 0.15rem 0 0 48px;
    }
    .page-header-premium .breadcrumb {
        background: transparent;
        padding: 0;
        font-size: 0.85rem;
    }
    .page-header-premium .breadcrumb-item a {
        color: #6b7280;
        text-decoration: none;
        transition: color 0.15s ease;
    }
    .page-header-premium .breadcrumb-item a:hover {
        color: #4f46e5;
    }
    .page-header-premium .breadcrumb-item.active {
        color: #1e2432;
        font-weight: 500;
    }

    .alert-premium {
        border: none;
        border-radius: 12px;
        border-left: 4px solid #16a34a;
        background: #f0fdf4;
        color: #15803d;
        font-size: 0.9rem;
        padding: 0.9rem 1.1rem;
    }

    .card-premium {
        position: relative;
        border: 1px solid #eef0f4;
        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(17, 24, 39, 0.05);
        overflow: hidden;
    }
    .card-premium::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #4f46e5, #818cf8);
    }
    .card-premium .card-header {
        padding: 1.1rem 1.75rem;
        border-bottom: 1px solid #f1f2f6;
        background: #fafbfc;
    }
    .card-premium .card-title {
        font-size: 1rem;
        font-weight: 600;
        color: #1e2432;
    }
    .card-premium .card-body {
        padding: 1.5rem 1.75rem 1.75rem;
    }

    .btn-premium-primary {
        background: #4f46e5;
        border: none;
        border-radius: 10px;
        font-size: 0.83rem;
        font-weight: 500;
        padding: 0.55rem 1.1rem;
        transition: background 0.15s ease;
    }
    .btn-premium-primary:hover {
        background: #4338ca;
        color: #fff;
    }

    .table-premium {
        margin-bottom: 0;
    }
    .table-premium thead th {
        background: #f8f9fb;
        color: #6b7280;
        font-size: 0.76rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        border: none;
        border-bottom: 1px solid #eef0f4;
        padding: 0.9rem 1rem;
        white-space: nowrap;
    }
    .table-premium tbody td {
        border: none;
        border-bottom: 1px solid #f4f5f8;
        padding: 1rem;
        font-size: 0.9rem;
        color: #374151;
        vertical-align: middle;
    }
    .table-premium tbody tr {
        transition: background 0.12s ease;
    }
    .table-premium tbody tr:hover {
        background: #fafbff;
    }
    .table-premium tbody tr:last-child td {
        border-bottom: none;
    }

    .dept-cell {
        display: flex;
        align-items: center;
        gap: 0.7rem;
    }
    .dept-avatar {
        width: 36px;
        height: 36px;
        min-width: 36px;
        border-radius: 10px;
        background: #eef0ff;
        color: #4f46e5;
        font-size: 0.85rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .dept-name {
        font-weight: 600;
        color: #1e2432;
        line-height: 1.3;
    }
    .dept-code {
        display: inline-block;
        font-family: 'SFMono-Regular', Consolas, monospace;
        font-size: 0.72rem;
        color: #6b7280;
        background: #f3f4f6;
        border-radius: 6px;
        padding: 0.15rem 0.5rem;
    }
    .text-muted-soft {
        color: #9ca3af;
    }

    .action-cell {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        white-space: nowrap;
    }
    .action-btn-premium {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        border: none;
        font-size: 0.8rem;
        transition: opacity 0.15s ease;
        padding: 0;
    }
    .action-btn-premium:hover {
        opacity: 0.85;
        color: #fff;
    }
    .action-edit-premium {
        background: #fef3c7;
        color: #b45309;
    }
    .action-edit-premium:hover {
        background: #f59e0b;
        color: #fff;
    }
    .action-delete-premium {
        background: #fee2e2;
        color: #b91c1c;
    }
    .action-delete-premium:hover {
        background: #ef4444;
        color: #fff;
    }

    .empty-state-premium {
        text-align: center;
        padding: 3rem 1rem;
        color: #9ca3af;
    }
    .empty-state-premium i {
        font-size: 2rem;
        color: #d1d5db;
        margin-bottom: 0.75rem;
        display: block;
    }
    .empty-state-premium p {
        font-size: 0.9rem;
        margin: 0;
    }
</style>
@endpush

@section('content')
<section class="content-header px-0">
    <div class="container-fluid px-0">
        <div class="row mb-2 align-items-center page-header-premium">
            <div class="col-sm-7">
                <h1 class="mb-1"><i class="fas fa-university"></i> មហាវិទ្យាល័យ</h1>
                <p class="text-muted mb-0">គ្រប់គ្រងបញ្ជីមហាវិទ្យាល័យសម្រាប់ប្រព័ន្ធ LMS។</p>
            </div>
            <div class="col-sm-5">
                <ol class="breadcrumb float-sm-right mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">ផ្ទាំងគ្រប់គ្រង</a></li>
                    <li class="breadcrumb-item active">មហាវិទ្យាល័យ</li>
                </ol>
            </div>
        </div>
    </div>
</section>

@if (session('success'))
    <div class="alert alert-premium alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="card card-premium">
    <div class="card-header d-flex align-items-center">
        <h3 class="card-title mb-0">បញ្ជីមហាវិទ្យាល័យ</h3>
        <a href="{{ route('faculties.create') }}" class="btn btn-premium-primary text-white ml-auto">
            <i class="fas fa-plus mr-1"></i>
            បង្កើតថ្មី
        </a>
    </div>
    <div class="card-body">
        @if ($faculties->count() > 0)
            <div class="table-responsive">
                <table class="table table-premium datatable">
                    <thead>
                        <tr>
                            <th>ល.រ</th>
                            <th>មហាវិទ្យាល័យ</th>
                            <th>ថ្ងៃបង្កើត</th>
                            <th>សកម្មភាព</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($faculties as $faculty)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="dept-cell">
                                        <div class="dept-avatar">{{ strtoupper(substr($faculty->faculty_name, 0, 1)) }}</div>
                                        <div>
                                            <div class="dept-name">{{ $faculty->faculty_name }}</div>
                                            <span class="dept-code">{{ $faculty->faculty_code }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-muted-soft">{{ $faculty->created_at?->format('Y-m-d') }}</td>
                                <td>
                                    <div class="action-cell">
                                        <a href="{{ route('faculties.edit', $faculty) }}" class="action-btn-premium action-edit-premium" title="កែប្រែ">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('faculties.destroy', $faculty) }}" method="POST" onsubmit="return confirm('តើអ្នកពិតជាចង់លុបមហាវិទ្យាល័យនេះមែនទេ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn-premium action-delete-premium" title="លុប">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state-premium">
                <i class="fas fa-university"></i>
                <p>មិនទាន់មានមហាវិទ្យាល័យនៅឡើយទេ</p>
            </div>
        @endif
    </div>
</div>
@endsection