@extends('layouts.master')

@section('title', 'កែប្រែវគ្គសិក្សា | LMS')

@section('content')

<style>
    .course-edit-page {
        color: #374151;
    }
    .course-page-header {
        padding: 8px 0 18px;
    }

    .course-page-header h1 {
        font-size: 1.45rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 4px;
    }

    .course-page-header p {
        font-size: 13.5px;
        color: #6b7280;
    }
    .course-breadcrumb {
        background: transparent;
        padding: 0;
        margin: 0;
        font-size: 13px;
    }

    .course-breadcrumb .breadcrumb-item a {
        color: #047857;
        text-decoration: none;
    }

    .course-breadcrumb .breadcrumb-item a:hover {
        color: #059669;
    }

    .course-breadcrumb .breadcrumb-item.active {
        color: #6b7280;
    }

    .course-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
        color: #9ca3af;
    }
    .course-edit-card {
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.05) !important;
        overflow: hidden;
        background: #ffffff;
    }
    .course-edit-card .card-header {
        background: #ffffff;
        border-bottom: 1px solid #e5e7eb;
        padding: 15px 20px;
    }

    .course-edit-card .card-title {
        display: flex;
        align-items: center;
        font-size: 15px;
        font-weight: 600;
        color: #1f2937;
    }

    .course-edit-card .card-title::before {
        content: "";
        width: 4px;
        height: 18px;
        background: #10b981;
        border-radius: 3px;
        margin-right: 9px;
    }
    .course-edit-card .card-body {
        padding: 22px 20px;
    }
    .course-edit-card .form-group {
        margin-bottom: 18px;
    }

    .course-edit-card label {
        font-size: 13.5px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
    }

    .course-edit-card .form-control,
    .course-edit-card .custom-select,
    .course-edit-card select,
    .course-edit-card textarea {
        border: 1px solid #d1d5db;
        border-radius: 7px;
        font-size: 13.5px;
        color: #374151;
        min-height: 40px;
        box-shadow: none;
        transition: border-color 0.15s ease,
                    box-shadow 0.15s ease;
    }

    .course-edit-card .form-control:focus,
    .course-edit-card .custom-select:focus,
    .course-edit-card select:focus,
    .course-edit-card textarea:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.10);
    }

    .course-edit-card textarea {
        min-height: 100px;
        resize: vertical;
    }

    /* Placeholder */
    .course-edit-card .form-control::placeholder,
    .course-edit-card textarea::placeholder {
        color: #9ca3af;
    }

    /* Validation */
    .course-edit-card .is-invalid {
        border-color: #dc2626 !important;
    }

    .course-edit-card .invalid-feedback {
        font-size: 12px;
    }
    .course-edit-card .btn {
        border-radius: 7px;
        font-size: 13.5px;
        font-weight: 500;
        padding: 8px 16px;
    }

    .course-edit-card .btn-success {
        background: #10b981;
        border-color: #10b981;
    }

    .course-edit-card .btn-success:hover {
        background: #059669;
        border-color: #059669;
    }
    @media (max-width: 767.98px) {

        .course-page-header {
            padding-top: 4px;
        }

        .course-page-header h1 {
            font-size: 1.25rem;
        }

        .course-page-header p {
            font-size: 13px;
        }

        .course-breadcrumb {
            margin-top: 10px;
            font-size: 12px;
        }

        .course-edit-card .card-header {
            padding: 13px 15px;
        }

        .course-edit-card .card-body {
            padding: 18px 15px;
        }
    }

    @media (max-width: 575.98px) {

        .course-page-header {
            text-align: left;
        }

        .course-breadcrumb {
            float: none !important;
        }

        .course-edit-card {
            border-radius: 8px;
        }

        .course-edit-card .form-control,
        .course-edit-card .custom-select,
        .course-edit-card select {
            min-height: 42px;
        }
    }
</style>

<div class="course-edit-page">
    <section class="content-header px-0 course-page-header">

        <div class="container-fluid px-0">

            <div class="row mb-2 align-items-center">

                <div class="col-sm-7">

                    <h1>
                        កែប្រែវគ្គសិក្សា
                    </h1>

                    <p class="mb-0">
                        កែប្រែព័ត៌មានវគ្គសិក្សាដែលបានជ្រើសរើស។
                    </p>

                </div>

                <div class="col-sm-5">

                    <ol class="breadcrumb float-sm-right course-breadcrumb">

                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">
                                ផ្ទាំងគ្រប់គ្រង
                            </a>
                        </li>

                        <li class="breadcrumb-item">
                            <a href="{{ route('courses.index') }}">
                                វគ្គសិក្សា
                            </a>
                        </li>

                        <li class="breadcrumb-item active">
                            កែប្រែ
                        </li>

                    </ol>

                </div>

            </div>

        </div>

    </section>
    <div class="card course-edit-card">

        <div class="card-header">

            <h3 class="card-title mb-0">
                ព័ត៌មានវគ្គសិក្សា
            </h3>

        </div>

        <form
            action="{{ route('courses.update', $course) }}"
            method="POST"
        >

            @method('PUT')

            @csrf

            <div class="card-body">

                @include('courses._form')

            </div>

        </form>

    </div>

</div>

@endsection
