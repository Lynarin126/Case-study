@extends('layouts.master')

@section('title', 'អ្នកប្រើប្រាស់ | LMS')

@section('content')
<section class="content-header px-0">
    <div class="container-fluid px-0">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-7">
                <h1 class="mb-1">អ្នកប្រើប្រាស់</h1>
                <p class="text-muted mb-0">គ្រប់គ្រងអ្នកប្រើប្រាស់ប្រព័ន្ធ។</p>
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
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-header d-flex align-items-center">
        <h3 class="card-title mb-0">បញ្ជីអ្នកប្រើប្រាស់</h3>
        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm ml-auto">
            <i class="fas fa-plus mr-1"></i>
            បង្កើតថ្មី
        </a>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped datatable">
            <thead>
                <tr>
                    <th>ល.រ</th>
                    <th>ឈ្មោះខ្មែរ (Khmer Name)</th>
                    <th>ឈ្មោះឡាតាំង (Latin Name)</th>
                    <th>អ៊ីមែល</th>
                    <th>ថ្ងៃបង្កើត</th>
                    <th>សកម្មភាព</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="font-weight-bold text-dark">{{ $user->khmer_name ?: '-' }}</td>
                        <td class="text-primary">{{ $user->latin_name ?: '-' }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at?->format('Y-m-d') }}</td>
                        <td>
                            @can('roles.view')
                                <a href="{{ route('admin.users.roles.edit', $user) }}" class="btn btn-info btn-sm" title="កំណត់តួនាទី">
                                    <i class="fas fa-user-shield"></i>
                                </a>
                            @endcan
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm" title="កែប្រែ">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('តើអ្នកពិតជាចង់លុបមែនទេ?');">
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
