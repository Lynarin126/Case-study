@extends('layouts.master')

@section('title', 'គ្រូបង្រៀន | LMS')

@section('content')
<section class="content-header px-0">
    <div class="container-fluid px-0">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-7">
                <h1 class="mb-1">គ្រូបង្រៀន</h1>
                <p class="text-muted mb-0">គ្រប់គ្រងបញ្ជីគ្រូបង្រៀនសម្រាប់ប្រព័ន្ធ LMS។</p>
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
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-header d-flex align-items-center">
        <h3 class="card-title mb-0">បញ្ជីគ្រូបង្រៀន</h3>
        <a href="{{ route('teachers.create') }}" class="btn btn-primary btn-sm ml-auto">
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
                    <th>នាមខ្លួន</th>
                    <th>នាមត្រកូល</th>
                    <th>ភេទ</th>
                    <th>លេខទូរស័ព្ទ</th>
                    <th>ស្ថានភាព</th>
                    <th>សកម្មភាព</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($teachers as $teacher)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $teacher->teacher_code }}</td>
                        <td>{{ $teacher->first_name }}</td>
                        <td>{{ $teacher->last_name }}</td>
                        <td>{{ $teacher->gender }}</td>
                        <td>{{ $teacher->phone }}</td>
                        <td>
                            @if($teacher->status == 'active')
                                <span class="badge badge-success">សកម្ម</span>
                            @else
                                <span class="badge badge-secondary">ផ្អាក</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('teachers.destroy', $teacher) }}" method="POST" class="d-inline" onsubmit="return confirm('តើអ្នកពិតជាចង់លុបមែនទេ?');">
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
