@extends('layouts.master')

@section('title', 'Dashboard | LMS')

@section('content')
@php
    $totalCourses = $totalCourses ?? 0;
    $activeCourses = $activeCourses ?? 0;
    $totalStudents = $totalStudents ?? 0;
    $totalTeachers = $totalTeachers ?? 0;
    $totalEnrollments = $totalEnrollments ?? 0;
    $totalLessons = $totalLessons ?? 0;
    $totalModules = $totalModules ?? 0;
    $totalCategories = $totalCategories ?? 0;
    $totalDepartments = $totalDepartments ?? 0;
    $totalFaculties = $totalFaculties ?? 0;
    $completionRate = $completionRate ?? 0;
    $recentEnrollments = $recentEnrollments ?? collect();
    $popularCourses = $popularCourses ?? collect();
    $maxEnrollments = $maxEnrollments ?? 1;
    $recentCourses = $recentCourses ?? collect();
@endphp
<section class="content-header px-0">
    <div class="container-fluid px-0">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-7">
                <h1 class="mb-1 font-weight-bold">ផ្ទាំងគ្រប់គ្រង (Dashboard)</h1>
                <p class="text-muted mb-0">ទិដ្ឋភាពទូទៅជាក់ស្តែងនៃប្រព័ន្ធគ្រប់គ្រងការសិក្សា (Real-time system overview)</p>
            </div>
            <div class="col-sm-5">
                <ol class="breadcrumb float-sm-right mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Primary Stats -->
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info shadow-sm">
            <div class="inner">
                <h3>{{ number_format($totalCourses) }}</h3>
                <p class="font-weight-bold mb-0">វគ្គសិក្សាសរុប</p>
                <small class="text-white-50">Total Courses</small>
            </div>
            <div class="icon"><i class="fas fa-book-open"></i></div>
            <a href="{{ route('courses.index') }}" class="small-box-footer">មើលវគ្គសិក្សា (View Courses) <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success shadow-sm">
            <div class="inner">
                <h3>{{ number_format($activeCourses) }}</h3>
                <p class="font-weight-bold mb-0">វគ្គសិក្សាសកម្ម</p>
                <small class="text-white-50">Active Courses</small>
            </div>
            <div class="icon"><i class="fas fa-check-circle"></i></div>
            <a href="{{ route('courses.index') }}" class="small-box-footer">មើលវគ្គសកម្ម (View Active) <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning shadow-sm">
            <div class="inner">
                <h3 class="text-dark">{{ number_format($totalStudents) }}</h3>
                <p class="font-weight-bold text-dark mb-0">សិស្សសរុប</p>
                <small class="text-muted">Total Students</small>
            </div>
            <div class="icon"><i class="fas fa-user-graduate"></i></div>
            <a href="{{ route('students.index') }}" class="small-box-footer text-dark">មើលបញ្ជីសិស្ស (View Students) <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger shadow-sm">
            <div class="inner">
                <h3>{{ number_format($totalTeachers) }}</h3>
                <p class="font-weight-bold mb-0">គ្រូបង្រៀន</p>
                <small class="text-white-50">Total Teachers</small>
            </div>
            <div class="icon"><i class="fas fa-chalkboard-teacher"></i></div>
            <a href="{{ route('teachers.index') }}" class="small-box-footer">មើលបញ្ជីគ្រូ (View Teachers) <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<!-- Secondary Stats -->
<div class="row">
    <div class="col-lg-3 col-6">
        <a href="{{ route('enrollments.index') }}" class="text-dark">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-user-check"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">ការចុះឈ្មោះ (Enrollments)</span>
                    <span class="info-box-number text-primary h4 mb-0">{{ number_format($totalEnrollments) }}</span>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-6">
        <a href="{{ route('lessons.create') }}" class="text-dark">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-play-circle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">មេរៀន (Lessons)</span>
                    <span class="info-box-number text-success h4 mb-0">{{ number_format($totalLessons) }}</span>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-6">
        <a href="{{ route('courses.index') }}" class="text-dark">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-layer-group"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">ម៉ូឌុល (Modules)</span>
                    <span class="info-box-number text-info h4 mb-0">{{ number_format($totalModules) }}</span>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-6">
        <a href="{{ route('course-categories.index') }}" class="text-dark">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-tags text-white"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">ប្រភេទវគ្គសិក្សា (Categories)</span>
                    <span class="info-box-number text-warning h4 mb-0">{{ number_format($totalCategories) }}</span>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="row">
    <!-- Recent Enrollments -->
    <div class="col-lg-7">
        <div class="card card-outline card-primary shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title font-weight-bold mb-0">
                    <i class="fas fa-user-clock mr-1 text-primary"></i> ការចុះឈ្មោះថ្មីៗ (Recent Enrollments)
                </h3>
                <div class="card-tools ml-auto">
                    <a href="{{ route('enrollments.index') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-list mr-1"></i> មើលទាំងអស់ (View All)
                    </a>
                </div>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>សិស្ស (Student)</th>
                            <th>វគ្គសិក្សា (Course)</th>
                            <th>កាលបរិច្ឆេទ (Date)</th>
                            <th class="text-center">ស្ថានភាព (Status)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentEnrollments as $enrollment)
                            <tr>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle mr-2 bg-primary-soft text-primary font-weight-bold">
                                            {{ strtoupper(substr($enrollment->student->first_name ?? 'S', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-weight-bold text-dark">
                                                {{ $enrollment->student ? $enrollment->student->first_name . ' ' . $enrollment->student->last_name : 'N/A' }}
                                            </div>
                                            <small class="text-muted">{{ $enrollment->student->student_code ?? '' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="font-weight-600 text-dark">
                                        {{ $enrollment->course->course_name ?? 'N/A' }}
                                    </span>
                                    <br>
                                    <small class="badge badge-light border">{{ $enrollment->course->course_code ?? '' }}</small>
                                </td>
                                <td class="align-middle text-muted">
                                    <i class="far fa-calendar-alt mr-1"></i>
                                    {{ $enrollment->enrollment_date ? \Carbon\Carbon::parse($enrollment->enrollment_date)->format('d M Y') : $enrollment->created_at->format('d M Y') }}
                                </td>
                                <td class="align-middle text-center">
                                    @php
                                        $status = strtolower($enrollment->status ?? 'studying');
                                    @endphp
                                    @if($status === 'completed')
                                        <span class="badge badge-success px-2 py-1"><i class="fas fa-check mr-1"></i> Completed</span>
                                    @elseif($status === 'studying' || $status === 'active')
                                        <span class="badge badge-info px-2 py-1"><i class="fas fa-book-reader mr-1"></i> Studying</span>
                                    @elseif($status === 'dropped' || $status === 'cancelled')
                                        <span class="badge badge-danger px-2 py-1"><i class="fas fa-times mr-1"></i> Dropped</span>
                                    @else
                                        <span class="badge badge-warning px-2 py-1">{{ ucfirst($status) }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block text-gray-300"></i>
                                    មិនទាន់មានការចុះឈ្មោះនៅឡើយទេ (No enrollments recorded yet)
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if(count($recentEnrollments) > 0)
                <div class="card-footer bg-white text-center py-2 border-top">
                    <a href="{{ route('enrollments.index') }}" class="text-primary font-weight-bold small">
                        គ្រប់គ្រងការចុះឈ្មោះទាំងអស់ &rarr;
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Popular Courses -->
    <div class="col-lg-5">
        <div class="card card-outline card-success shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title font-weight-bold mb-0">
                    <i class="fas fa-fire mr-1 text-danger"></i> វគ្គសិក្សាពេញនិយម (Popular Courses)
                </h3>
                <div class="card-tools ml-auto">
                    <a href="{{ route('courses.index') }}" class="btn btn-sm btn-outline-success">
                        <i class="fas fa-eye mr-1"></i> ទាំងអស់ (All)
                    </a>
                </div>
            </div>
            <div class="card-body">
                @forelse($popularCourses as $course)
                    @php
                        $pct = $maxEnrollments > 0 ? round(($course->enrollments_count / $maxEnrollments) * 100) : 0;
                        $colors = ['bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger'];
                        $barColor = $colors[$loop->index % count($colors)];
                    @endphp
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <div>
                                <strong class="text-dark">{{ $course->course_name }}</strong>
                                <small class="text-muted ml-1">({{ $course->course_code }})</small>
                            </div>
                            <span class="badge badge-light border font-weight-bold px-2 py-1">
                                <i class="fas fa-users mr-1 text-muted"></i>
                                {{ $course->enrollments_count }} {{ Str::plural('enrollment', $course->enrollments_count) }}
                            </span>
                        </div>
                        <div class="progress progress-xs" style="height: 7px; border-radius: 4px;">
                            <div class="progress-bar {{ $barColor }}" role="progressbar" style="width: {{ max(5, $pct) }}%" aria-valuenow="{{ $pct }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-book-reader fa-2x mb-2 d-block text-gray-300"></i>
                        មិនទាន់មានវគ្គសិក្សានៅឡើយទេ (No courses found)
                    </div>
                @endforelse
            </div>
            <div class="card-footer bg-white text-center py-2 border-top">
                <a href="{{ route('courses.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus mr-1"></i> បង្កើតវគ្គសិក្សាថ្មី (Create Course)
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Courses & Quick Actions -->
<div class="row">
    <!-- Recent Courses -->
    <div class="col-lg-8">
        <div class="card card-outline card-info shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title font-weight-bold mb-0">
                    <i class="fas fa-book mr-1 text-info"></i> វគ្គសិក្សាថ្មីៗ (Recent Courses)
                </h3>
                <div class="card-tools ml-auto">
                    <a href="{{ route('courses.create') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-plus mr-1"></i> បន្ថែមវគ្គសិក្សា (Add Course)
                    </a>
                </div>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>កូដ (Code)</th>
                            <th>ឈ្មោះវគ្គសិក្សា (Course Name)</th>
                            <th>ប្រភេទ (Category)</th>
                            <th class="text-center">ម៉ូឌុល (Modules)</th>
                            <th class="text-center">សកម្មភាព (Actions)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentCourses as $course)
                            <tr>
                                <td class="align-middle font-weight-bold text-primary">
                                    {{ $course->course_code }}
                                </td>
                                <td class="align-middle">
                                    <span class="font-weight-600 text-dark">{{ $course->course_name }}</span>
                                    @if($course->visibility)
                                        <span class="badge badge-light border ml-1">{{ ucfirst($course->visibility) }}</span>
                                    @endif
                                </td>
                                <td class="align-middle text-muted">
                                    {{ $course->category->category_name ?? 'N/A' }}
                                </td>
                                <td class="align-middle text-center">
                                    <span class="badge badge-secondary px-2 py-1">
                                        {{ $course->course_modules_count ?? 0 }} ម៉ូឌុល
                                    </span>
                                </td>
                                <td class="align-middle text-center">
                                    <a href="{{ route('courses.modules.index', $course->course_id) }}" class="btn btn-xs btn-outline-info" title="Manage Modules">
                                        <i class="fas fa-folder-open"></i>
                                    </a>
                                    <a href="{{ route('courses.edit', $course->course_id) }}" class="btn btn-xs btn-outline-primary" title="Edit Course">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    មិនទាន់មានវគ្គសិក្សា (No courses available)
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-lg-4">
        <div class="card card-outline card-secondary shadow-sm">
            <div class="card-header">
                <h3 class="card-title font-weight-bold mb-0">
                    <i class="fas fa-bolt mr-1 text-warning"></i> សកម្មភាពរហ័ស (Quick Actions)
                </h3>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between">
                    <a href="{{ route('courses.create') }}" class="btn btn-app bg-info text-white shadow-sm mb-2" style="min-width: 47%; height: 68px;">
                        <i class="fas fa-plus-circle"></i> បន្ថែមវគ្គសិក្សា
                    </a>
                    <a href="{{ route('students.create') }}" class="btn btn-app bg-warning text-dark shadow-sm mb-2" style="min-width: 47%; height: 68px;">
                        <i class="fas fa-user-plus"></i> ចុះឈ្មោះសិស្ស
                    </a>
                    <a href="{{ route('enrollments.index') }}" class="btn btn-app bg-primary text-white shadow-sm mb-2" style="min-width: 47%; height: 68px;">
                        <i class="fas fa-user-graduate"></i> ការចុះឈ្មោះរៀន
                    </a>
                    <a href="{{ route('teachers.create') }}" class="btn btn-app bg-danger text-white shadow-sm mb-2" style="min-width: 47%; height: 68px;">
                        <i class="fas fa-chalkboard-teacher"></i> បន្ថែមគ្រូបង្រៀន
                    </a>
                    <a href="{{ route('lessons.create') }}" class="btn btn-app bg-success text-white shadow-sm mb-2" style="min-width: 47%; height: 68px;">
                        <i class="fas fa-video"></i> បង្កើតមេរៀន
                    </a>
                    <a href="{{ route('course-categories.index') }}" class="btn btn-app bg-secondary text-white shadow-sm mb-2" style="min-width: 47%; height: 68px;">
                        <i class="fas fa-tags"></i> ប្រភេទវគ្គ
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.avatar-circle {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
}
.bg-primary-soft {
    background-color: #e8f0fe;
    color: #1a73e8;
}
.font-weight-600 {
    font-weight: 600;
}
</style>
@endpush
