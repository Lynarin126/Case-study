@extends('layouts.master')

@section('title', 'កែប្រែនិស្សិត | LMS')

@section('content')
<section class="content-header px-0">
    <div class="container-fluid px-0">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-7">
                <h1 class="mb-1">កែប្រែនិស្សិត</h1>
                <p class="text-muted mb-0">កែប្រែព័ត៌មាននិស្សិត។</p>
            </div>
            <div class="col-sm-5">
                <ol class="breadcrumb float-sm-right mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">ផ្ទាំងគ្រប់គ្រង</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('students.index') }}">និស្សិត</a></li>
                    <li class="breadcrumb-item active">កែប្រែ</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="card-title mb-0">ព័ត៌មាននិស្សិត</h3>
    </div>
    <form action="{{ route('students.update', $student) }}" method="POST">
        @method('PUT')
        <div class="card-body">
            @include('students._form')
        </div>
    </form>
</div>
@endsection
