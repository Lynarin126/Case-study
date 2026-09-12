@extends('layouts.master')

@section('title', 'ឆ្នាំសិក្សា | LMS')

@section('content')
<section class="content-header px-0">
    <div class="container-fluid px-0">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-7">
                <h1 class="mb-1">ឆ្នាំសិក្សា</h1>
            </div>
            <div class="col-sm-5">
                <ol class="breadcrumb float-sm-right mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">ផ្ទាំងគ្រប់គ្រង</a></li>
                    <li class="breadcrumb-item active">ឆ្នាំសិក្សា</li>
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
        <h3 class="card-title mb-0">បញ្ជីឆ្នាំសិក្សា</h3>
        <a href="{{ route('academic-years.create') }}" class="btn btn-primary btn-sm ml-auto">
            <i class="fas fa-plus mr-1"></i>
            បង្កើតថ្មី
        </a>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped datatable">
            <thead>
                <tr>
                    <th>ល.រ</th>
                    <th>ឆ្នាំសិក្សា</th>
                    <th>ថ្ងៃចាប់ផ្តើម</th>
                    <th>ថ្ងៃបញ្ចប់</th>
                    <th>សកម្ម</th>
                    <th>សកម្មភាព</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($academicYears as $academicYear)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $academicYear->year_name }}</td>
                        <td>{{ $academicYear->start_date }}</td>
                        <td>{{ $academicYear->end_date }}</td>
                        <td>
                            @if($academicYear->is_active)
                                <span class="badge badge-success">បាទ/ចាស</span>
                            @else
                                <span class="badge badge-secondary">ទេ</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('academic-years.edit', $academicYear) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('academic-years.destroy', $academicYear) }}" method="POST" class="d-inline" onsubmit="return confirm('តើអ្នកពិតជាចង់លុបមែនទេ?');">
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
