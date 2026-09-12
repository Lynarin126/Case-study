@extends('layouts.master')

@section('title', 'ប្រវត្តិរូបអ្នកប្រើប្រាស់ | LMS')

@section('content')
<section class="content-header px-0">
    <div class="container-fluid px-0">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>ប្រវត្តិរូបរបស់ខ្ញុំ (My Profile)</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">ផ្ទាំងគ្រប់គ្រង</a></li>
                    <li class="breadcrumb-item active">ប្រវត្តិរូប</li>
                </ol>
            </div>
        </div>
    </div>
</section>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="row">
    <div class="col-md-4">
        <!-- Profile Image Card -->
        <div class="card card-primary card-outline shadow-sm">
            <div class="card-body box-profile">
                <div class="text-center mb-3">
                    <img class="profile-user-img img-fluid img-circle"
                         src="{{ asset('backend/dist/img/user.png') }}"
                         alt="User profile picture">
                </div>
                <h3 class="profile-username text-center font-weight-bold">{{ $user->name }}</h3>
                <p class="text-muted text-center">{{ $user->email }}</p>
                
                <ul class="list-group list-group-unbordered mb-3 mt-4">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <b>តួនាទី (Role)</b> <span class="badge badge-primary px-3 py-2">អ្នកគ្រប់គ្រង (Admin)</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <b>ថ្ងៃបង្កើតគណនី</b> <span>{{ $user->created_at->format('d/m/Y') }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <!-- Update Form Card -->
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title font-weight-bold text-primary">កែប្រែព័ត៌មាន (Update Information)</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">ឈ្មោះពេញ <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label">អ៊ីមែល <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3 text-secondary">ផ្លាស់ប្តូរលេខសម្ងាត់ (Change Password)</h5>
                    <p class="text-muted small mb-4"><i class="fas fa-info-circle"></i> ទុកប្រអប់លេខសម្ងាត់ឲ្យនៅទទេ ប្រសិនបើអ្នកមិនចង់ផ្លាស់ប្តូរវា។</p>

                    <div class="form-group row">
                        <label for="password" class="col-sm-3 col-form-label">លេខសម្ងាត់ថ្មី</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password_confirmation" class="col-sm-3 col-form-label">បញ្ជាក់លេខសម្ងាត់ថ្មី</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>
                    </div>

                    <div class="form-group row mt-4">
                        <div class="col-sm-9 offset-sm-3">
                            <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save mr-2"></i> រក្សាទុកការផ្លាស់ប្តូរ</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
