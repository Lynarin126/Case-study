@extends('layouts.master')

@section('title', 'ដេប៉ាតឺម៉ង់ | LMS')

@section('content')
<section class="content-header px-0">
    <div class="container-fluid px-0">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-7">
                <h1 class="mb-1">ដេប៉ាតឺម៉ង់</h1>
                <p class="text-muted mb-0">គ្រប់គ្រងបញ្ជីដេប៉ាតឺម៉ង់តាមមហាវិទ្យាល័យ។</p>
            </div>
            <div class="col-sm-5">
                <ol class="breadcrumb float-sm-right mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">ផ្ទាំងគ្រប់គ្រង</a></li>
                    <li class="breadcrumb-item active">ដេប៉ាតឺម៉ង់</li>
                </ol>
            </div>
        </div>
    </div>
</section>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-header d-flex align-items-center">
        <h3 class="card-title mb-0">បញ្ជីដេប៉ាតឺម៉ង់</h3>
        <a href="{{ route('departments.create') }}" class="btn btn-primary btn-sm ml-auto">
            <i class="fas fa-plus mr-1"></i>
            បង្កើតថ្មី
        </a>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped datatable">
            <thead>
                <tr>
                    <th>ល.រ</th>
                    <th>កូដ</th>
                    <th>ឈ្មោះដេប៉ាតឺម៉ង់</th>
                    <th>មហាវិទ្យាល័យ</th>
                    <th>ប្រធាន</th>
                    <th>ថ្ងៃបង្កើត</th>
                    <th>សកម្មភាព</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($departments as $department)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $department->department_code }}</td>
                        <td>{{ $department->department_name }}</td>
                        <td>{{ $department->faculty?->faculty_name ?? '-' }}</td>
                        <td>{{ $department->deans ?? '-' }}</td>
                        <td>{{ $department->created_at?->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('departments.edit', $department) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('departments.destroy', $department) }}" method="POST" class="d-inline" onsubmit="return confirm('តើអ្នកពិតជាចង់លុបដេប៉ាតឺម៉ង់នេះមែនទេ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
