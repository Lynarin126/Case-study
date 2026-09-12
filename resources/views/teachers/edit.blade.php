@extends('layouts.master')

@section('title', 'កែប្រែគ្រូបង្រៀន | LMS')

@section('content')
<section class="content-header px-0">
    <div class="container-fluid px-0">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-7">
                <h1 class="mb-1">កែប្រែគ្រូបង្រៀន</h1>
                <p class="text-muted mb-0">កែប្រែព័ត៌មានគ្រូបង្រៀន។</p>
            </div>
            <div class="col-sm-5">
                <ol class="breadcrumb float-sm-right mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">ផ្ទាំងគ្រប់គ្រង</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('teachers.index') }}">គ្រូបង្រៀន</a></li>
                    <li class="breadcrumb-item active">កែប្រែ</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="card-title mb-0">ព័ត៌មានគ្រូបង្រៀន</h3>
    </div>
    <form action="{{ route('teachers.update', $teacher) }}" method="POST">
        @method('PUT')
        <div class="card-body">
            @include('teachers._form')
        </div>
    </form>
</div>
@endsection
