@extends('layouts.master')

@section('title', 'មហាវិទ្យាល័យ | LMS')

@section('content')
<section class="content-header px-0">
    <div class="container-fluid px-0">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-7">
                <h1 class="mb-1">មហាវិទ្យាល័យ</h1>
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
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-header d-flex align-items-center">
        <h3 class="card-title mb-0">បញ្ជីមហាវិទ្យាល័យ</h3>
        <a href="{{ route('faculties.create') }}" class="btn btn-primary btn-sm ml-auto">
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
                    <th>ឈ្មោះមហាវិទ្យាល័យ</th>
                    <th>ថ្ងៃបង្កើត</th>
                    <th>សកម្មភាព</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($faculties as $faculty)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $faculty->faculty_code }}</td>
                        <td>{{ $faculty->faculty_name }}</td>
                        <td>{{ $faculty->created_at?->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('faculties.edit', $faculty) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('faculties.destroy', $faculty) }}" method="POST" class="d-inline" onsubmit="return confirm('តើអ្នកពិតជាចង់លុបមហាវិទ្យាល័យនេះមែនទេ?');">
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
