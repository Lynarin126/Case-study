@extends('layouts.master')

@section('title', 'បង្កើតអ្នកប្រើប្រាស់ | LMS')

@section('content')
<section class="content-header px-0">
    <div class="container-fluid px-0">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-7">
                <h1 class="mb-1">បង្កើតអ្នកប្រើប្រាស់</h1>
            </div>
            <div class="col-sm-5">
                <ol class="breadcrumb float-sm-right mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">ផ្ទាំងគ្រប់គ្រង</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">អ្នកប្រើប្រាស់</a></li>
                    <li class="breadcrumb-item active">បង្កើតថ្មី</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="card shadow-sm">
    <form action="{{ route('users.store') }}" method="POST">
        <div class="card-body">
            @include('users._form')
        </div>
    </form>
</div>
@endsection
