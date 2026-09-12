@extends('layouts.master')

@section('title', 'កែប្រែឆ្នាំសិក្សា | LMS')

@section('content')
<section class="content-header px-0">
    <div class="container-fluid px-0">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-7">
                <h1 class="mb-1">កែប្រែឆ្នាំសិក្សា</h1>
            </div>
            <div class="col-sm-5">
                <ol class="breadcrumb float-sm-right mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">ផ្ទាំងគ្រប់គ្រង</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('academic-years.index') }}">ឆ្នាំសិក្សា</a></li>
                    <li class="breadcrumb-item active">កែប្រែ</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="card shadow-sm">
    <form action="{{ route('academic-years.update', $academicYear) }}" method="POST">
        @method('PUT')
        <div class="card-body">
            @include('academic_years._form')
        </div>
    </form>
</div>
@endsection
