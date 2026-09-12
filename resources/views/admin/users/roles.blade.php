@extends('layouts.master')

@section('title', 'កំណត់តួនាទីអ្នកប្រើប្រាស់ | LMS')

@section('content')
<section class="content-header px-0">
    <div class="container-fluid px-0">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-7">
                <h1 class="mb-1">កំណត់តួនាទីអ្នកប្រើប្រាស់</h1>
                <p class="text-muted mb-0">
                    <i class="fas fa-user mr-1 text-primary"></i><strong>{{ $user->name }}</strong>
                    <span class="mx-1">·</span>
                    <span class="text-secondary">{{ $user->email }}</span>
                </p>
            </div>
            <div class="col-sm-5 text-sm-right mt-2 mt-sm-0">
                <ol class="breadcrumb float-sm-right mb-2">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">ផ្ទាំងគ្រប់គ្រង</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">អ្នកប្រើប្រាស់</a></li>
                    <li class="breadcrumb-item active">កំណត់តួនាទី</li>
                </ol>
                <div class="clearfix"></div>
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> បញ្ជីអ្នកប្រើប្រាស់
                </a>
            </div>
        </div>
    </div>
</section>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
@endif

<form method="POST" action="{{ route('admin.users.roles.update', $user) }}">
    @csrf
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h3 class="card-title mb-0 font-weight-bold">
                <i class="fas fa-user-shield mr-2 text-primary"></i>ជ្រើសរើសតួនាទី
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($roles as $role)
                    <div class="col-md-6 col-lg-4 mb-3">
                        <label class="border rounded p-3 d-block h-100 shadow-none cursor-pointer" style="cursor: pointer;">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="roles[]" value="{{ $role->id }}" id="role_{{ $role->id }}" class="custom-control-input" @checked($selectedRoles->contains($role->id))>
                                <label class="custom-control-label font-weight-bold" for="role_{{ $role->id }}" style="cursor: pointer;">
                                    {{ $role->name }}
                                </label>
                            </div>
                            <div class="mt-2 pl-4">
                                <span class="badge badge-light border">{{ $role->slug }}</span>
                                @if($role->is_system)
                                    <span class="badge badge-info ml-1">ប្រព័ន្ធ</span>
                                @endif
                                <p class="text-muted small mb-0 mt-2">{{ $role->description ?? 'មិនមានការពិពណ៌នា' }}</p>
                            </div>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="card-footer bg-white text-right">
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary mr-2">
                <i class="fas fa-times mr-1"></i> បោះបង់
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-1"></i> រក្សាទុកតួនាទី
            </button>
        </div>
    </div>
</form>
@endsection
