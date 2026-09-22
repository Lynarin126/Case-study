@extends('layouts.master')

@section('title', 'បង្កើតមហាវិទ្យាល័យ | LMS')

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

    .form-card-premium {
        position: relative;
        border: 1px solid #eef0f4;
        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(17, 24, 39, 0.05);
        overflow: hidden;
    }
    .form-card-premium::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #4f46e5, #818cf8);
    }
    .form-card-premium .card-header {
        padding: 1.1rem 1.75rem;
        border-bottom: 1px solid #f1f2f6;
        background: #fafbfc;
    }
    .form-card-premium .card-title {
        font-size: 1rem;
        font-weight: 600;
        color: #1e2432;
    }
    .form-card-premium .card-body {
        padding: 2rem;
    }

    @media (max-width: 576px) {
        .form-card-premium .card-header {
            padding: 1rem 1.25rem;
        }
        .form-card-premium .card-body {
            padding: 1.25rem;
        }
        .page-header-premium h1 {
            font-size: 1.25rem;
        }
    }
</style>
@endpush

@section('content')
<section class="content-header px-0">
    <div class="container-fluid px-0">
        <div class="row mb-2 align-items-center page-header-premium">
            <div class="col-sm-7">
                <h1 class="mb-1"><i class="fas fa-university"></i> បង្កើតមហាវិទ្យាល័យ</h1>
                <p class="text-muted mb-0">បញ្ចូលព័ត៌មានមហាវិទ្យាល័យថ្មី។</p>
            </div>
            <div class="col-sm-5">
                <ol class="breadcrumb float-sm-right mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">ផ្ទាំងគ្រប់គ្រង</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('faculties.index') }}">មហាវិទ្យាល័យ</a></li>
                    <li class="breadcrumb-item active">បង្កើតថ្មី</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="card form-card-premium">
    <div class="card-header">
        <h3 class="card-title mb-0">ព័ត៌មានមហាវិទ្យាល័យ</h3>
    </div>
    <form action="{{ route('faculties.store') }}" method="POST">
        <div class="card-body">
            @include('faculties._form')
        </div>
    </form>
</div>
@endsection