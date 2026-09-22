@extends('layouts.master')

@section('title', 'ផ្ទាំងគ្រប់គ្រង | LMS')

@php
    /*
     | Presentation-only helpers and defaults.
     | Every number below comes from the data DashboardController already
     | provides - no backend, model, route or database change is made here.
     */
    $totalCourses      = $totalCourses ?? 0;
    $activeCourses     = $activeCourses ?? 0;
    $totalStudents     = $totalStudents ?? 0;
    $totalTeachers     = $totalTeachers ?? 0;
    $totalEnrollments  = $totalEnrollments ?? 0;
    $totalLessons      = $totalLessons ?? 0;
    $totalModules      = $totalModules ?? 0;
    $totalCategories   = $totalCategories ?? 0;
    $totalDepartments  = $totalDepartments ?? 0;
    $totalFaculties    = $totalFaculties ?? 0;
    $completionRate    = (int) ($completionRate ?? 0);
    $recentEnrollments = $recentEnrollments ?? collect();
    $popularCourses    = $popularCourses ?? collect();
    $maxEnrollments    = $maxEnrollments ?? 1;
    $recentCourses     = $recentCourses ?? collect();
    $recentStudents    = $recentStudents ?? collect();

    /* Initials for avatar bubbles - multi-byte safe for Khmer names. */
    $initialsOf = function ($name) {
        $name = trim((string) $name);

        if ($name === '') {
            return '?';
        }

        return \Illuminate\Support\Str::upper(
            collect(preg_split('/[\s._-]+/u', $name))
                ->filter()
                ->map(fn ($part) => mb_substr($part, 0, 1))
                ->take(2)
                ->implode('')
        );
    };

    /* Friendly date label used by the activity feed. */
    $activityDate = function ($date) {
        if (empty($date)) {
            return '';
        }

        $moment = $date instanceof \Carbon\CarbonInterface ? $date : \Carbon\Carbon::parse($date);

        if ($moment->isToday()) {
            return 'ថ្ងៃនេះ ' . $moment->format('H:i');
        }

        if ($moment->isYesterday()) {
            return 'ម្សិលមិញ ' . $moment->format('H:i');
        }

        return $moment->format('d/m/Y');
    };

    $studentName = function ($student) {
        if (! $student) {
            return 'N/A';
        }

        return trim((string) $student->full_name) !== ''
            ? $student->full_name
            : (string) ($student->student_code ?? 'N/A');
    };
@endphp
@php
    /* "Recent activities": merged from the newest records the controller loaded. */
    $activities = collect();

    foreach ($recentEnrollments->take(3) as $enrollment) {
        $activities->push([
            'icon'    => 'fas fa-user-check',
            'tone'    => 'primary',
            'title'   => $studentName($enrollment->student),
            'message' => 'បានចុះឈ្មោះចូលវគ្គសិក្សា',
            'subject' => $enrollment->course->course_name ?? 'N/A',
            'at'      => $enrollment->enrollment_date
                ? \Carbon\Carbon::parse($enrollment->enrollment_date)
                : $enrollment->created_at,
            'url'     => route('enrollments.index'),
        ]);
    }

    foreach ($recentStudents->take(3) as $student) {
        $activities->push([
            'icon'    => 'fas fa-user-graduate',
            'tone'    => 'success',
            'title'   => $studentName($student),
            'message' => 'សិស្សថ្មីត្រូវបានចុះឈ្មោះក្នុងប្រព័ន្ធ',
            'subject' => $student->student_code ?? '',
            'at'      => $student->created_at,
            'url'     => route('students.index'),
        ]);
    }

    foreach ($recentCourses->take(3) as $course) {
        $activities->push([
            'icon'    => 'fas fa-book-open',
            'tone'    => 'info',
            'title'   => $course->course_name,
            'message' => 'វគ្គសិក្សាថ្មីត្រូវបានបង្កើត',
            'subject' => $course->course_code ?? '',
            'at'      => $course->created_at,
            'url'     => route('courses.index'),
        ]);
    }

    $activities = $activities
        ->filter(fn ($activity) => ! empty($activity['at']))
        ->sortByDesc(fn ($activity) => $activity['at'])
        ->take(6)
        ->values();

    /* Chart payloads - built only from values the controller provides. */
    $popularChartLabels = $popularCourses->pluck('course_name')->all();
    $popularChartValues = $popularCourses->pluck('enrollments_count')
        ->map(fn ($count) => (int) $count)
        ->all();
    $popularChartColors = array_slice(
        ['#1a73e8', '#17a2b8', '#28a745', '#ffc107', '#fd7e14', '#6f42c1'],
        0,
        max(count($popularChartLabels), 1)
    );
    $completedRate = min(100, max(0, $completionRate));
    $remainingRate = max(0, 100 - $completedRate);
@endphp

@section('content')
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
{{-- ======================= KEY STATISTICS ======================= --}}
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card dash-card kpi-card h-100">
            <div class="card-body">
                <div class="kpi-head">
                    <span class="kpi-icon kpi-icon-warning"><i class="fas fa-user-graduate" aria-hidden="true"></i></span>
                    <span class="kpi-titles">
                        <span class="kpi-label">សិស្សសរុប</span>
                        <span class="kpi-label-en">Total Students</span>
                    </span>
                </div>
                <p class="kpi-value">{{ number_format($totalStudents) }}</p>
            </div>
            <a href="{{ route('students.index') }}" class="kpi-footer">
                មើលបញ្ជីសិស្ស <i class="fas fa-arrow-right" aria-hidden="true"></i>
            </a>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card dash-card kpi-card h-100">
            <div class="card-body">
                <div class="kpi-head">
                    <span class="kpi-icon kpi-icon-danger"><i class="fas fa-chalkboard-teacher" aria-hidden="true"></i></span>
                    <span class="kpi-titles">
                        <span class="kpi-label">គ្រូបង្រៀនសរុប</span>
                        <span class="kpi-label-en">Total Teachers</span>
                    </span>
                </div>
                <p class="kpi-value">{{ number_format($totalTeachers) }}</p>
            </div>
            <a href="{{ route('teachers.index') }}" class="kpi-footer">
                មើលបញ្ជីគ្រូ <i class="fas fa-arrow-right" aria-hidden="true"></i>
            </a>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card dash-card kpi-card h-100">
            <div class="card-body">
                <div class="kpi-head">
                    <span class="kpi-icon kpi-icon-info"><i class="fas fa-book-open" aria-hidden="true"></i></span>
                    <span class="kpi-titles">
                        <span class="kpi-label">វគ្គសិក្សាសរុប</span>
                        <span class="kpi-label-en">Total Courses</span>
                    </span>
                </div>
                <p class="kpi-value">{{ number_format($totalCourses) }}</p>
            </div>
            <a href="{{ route('courses.index') }}" class="kpi-footer">
                មើលវគ្គសិក្សា <i class="fas fa-arrow-right" aria-hidden="true"></i>
            </a>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card dash-card kpi-card h-100">
            <div class="card-body">
                <div class="kpi-head">
                    <span class="kpi-icon kpi-icon-primary"><i class="fas fa-user-check" aria-hidden="true"></i></span>
                    <span class="kpi-titles">
                        <span class="kpi-label">ការចុះឈ្មោះរៀន</span>
                        <span class="kpi-label-en">Enrollments</span>
                    </span>
                </div>
                <p class="kpi-value">{{ number_format($totalEnrollments) }}</p>
            </div>
            <a href="{{ route('enrollments.index') }}" class="kpi-footer">
                គ្រប់គ្រងការចុះឈ្មោះ <i class="fas fa-arrow-right" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</div>
{{-- ======================= SECONDARY METRICS ======================= --}}
<div class="row">
    <div class="col-xl-2 col-md-4 col-6">
        <a href="{{ route('courses.index') }}" class="mini-stat h-100">
            <span class="mini-stat-icon text-success bg-success-soft"><i class="fas fa-check-circle" aria-hidden="true"></i></span>
            <span class="mini-stat-body">
                <span class="mini-stat-value">{{ number_format($activeCourses) }}</span>
                <span class="mini-stat-label">វគ្គសកម្ម <em>Active Courses</em></span>
            </span>
        </a>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <a href="{{ route('lessons.create') }}" class="mini-stat h-100">
            <span class="mini-stat-icon text-primary bg-primary-soft"><i class="fas fa-play-circle" aria-hidden="true"></i></span>
            <span class="mini-stat-body">
                <span class="mini-stat-value">{{ number_format($totalLessons) }}</span>
                <span class="mini-stat-label">មេរៀន <em>Lessons</em></span>
            </span>
        </a>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <a href="{{ route('courses.index') }}" class="mini-stat h-100">
            <span class="mini-stat-icon text-info bg-info-soft"><i class="fas fa-layer-group" aria-hidden="true"></i></span>
            <span class="mini-stat-body">
                <span class="mini-stat-value">{{ number_format($totalModules) }}</span>
                <span class="mini-stat-label">ម៉ូឌុល <em>Modules</em></span>
            </span>
        </a>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <a href="{{ route('course-categories.index') }}" class="mini-stat h-100">
            <span class="mini-stat-icon text-warning bg-warning-soft"><i class="fas fa-tags" aria-hidden="true"></i></span>
            <span class="mini-stat-body">
                <span class="mini-stat-value">{{ number_format($totalCategories) }}</span>
                <span class="mini-stat-label">ប្រភេទវគ្គ <em>Categories</em></span>
            </span>
        </a>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <a href="{{ route('faculties.index') }}" class="mini-stat h-100">
            <span class="mini-stat-icon text-secondary bg-secondary-soft"><i class="fas fa-university" aria-hidden="true"></i></span>
            <span class="mini-stat-body">
                <span class="mini-stat-value">{{ number_format($totalFaculties) }}</span>
                <span class="mini-stat-label">មហាវិទ្យាល័យ <em>Faculties</em></span>
            </span>
        </a>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <a href="{{ route('departments.index') }}" class="mini-stat h-100">
            <span class="mini-stat-icon text-danger bg-danger-soft"><i class="fas fa-sitemap" aria-hidden="true"></i></span>
            <span class="mini-stat-body">
                <span class="mini-stat-value">{{ number_format($totalDepartments) }}</span>
                <span class="mini-stat-label">ដេប៉ាតឺម៉ង់ <em>Departments</em></span>
            </span>
        </a>
    </div>
</div>
{{-- ======================= CHARTS ======================= --}}
<div class="row">
    <div class="col-xl-8">
        <div class="card dash-card h-100">
            <div class="dash-card-header">
                <h3 class="dash-card-title">
                    <i class="fas fa-chart-bar text-primary" aria-hidden="true"></i>
                    វគ្គសិក្សាពេញនិយម (Top Courses by Enrollments)
                </h3>
                <a href="{{ route('courses.index') }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-list mr-1" aria-hidden="true"></i>ទាំងអស់ (All)
                </a>
            </div>
            <div class="card-body">
                @if(count($popularCourses) > 0)
                    <div class="chart-box chart-box-lg">
                        <canvas id="popularCoursesChart" role="img" aria-label="ការចុះឈ្មោះតាមវគ្គសិក្សា"></canvas>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-chart-bar d-block mb-2"></i>
                        មិនទាន់មានទិន្នន័យវគ្គសិក្សាសម្រាប់បង្ហាញក្រាបទេ (No course data yet)
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card dash-card h-100">
            <div class="dash-card-header">
                <h3 class="dash-card-title">
                    <i class="fas fa-chart-pie text-success" aria-hidden="true"></i>
                    អត្រាបញ្ចប់ការសិក្សា (Completion Rate)
                </h3>
            </div>
            <div class="card-body d-flex flex-column">
                @if($totalEnrollments > 0)
                    <div class="chart-box chart-box-doughnut">
                        <canvas id="completionChart" role="img" aria-label="អត្រាបញ្ចប់ការសិក្សា"></canvas>
                        <div class="chart-center">
                            <span class="chart-center-value">{{ $completedRate }}%</span>
                            <span class="chart-center-label">បានបញ្ចប់</span>
                        </div>
                    </div>
                    <div class="chart-legend mt-3">
                        <span class="chart-legend-item">
                            <i class="fas fa-circle text-success" aria-hidden="true"></i>
                            បានបញ្ចប់ <strong>{{ $completedRate }}%</strong>
                        </span>
                        <span class="chart-legend-item">
                            <i class="fas fa-circle text-muted" aria-hidden="true"></i>
                            កំពុងសិក្សា <strong>{{ $remainingRate }}%</strong>
                        </span>
                    </div>
                    <p class="dash-note mb-0 mt-3">
                        គិតលើការចុះឈ្មោះសរុប {{ number_format($totalEnrollments) }} ក្នុងប្រព័ន្ធ។
                    </p>
                @else
                    <div class="empty-state">
                        <i class="fas fa-chart-pie d-block mb-2"></i>
                        មិនទាន់មានការចុះឈ្មោះសម្រាប់គណនាអត្រាបញ្ចប់ទេ (No enrollment data yet)
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
{{-- ======================= RECENT ENROLLMENTS + ACTIVITIES ======================= --}}
<div class="row">
    <div class="col-xl-7">
        <div class="card dash-card h-100">
            <div class="dash-card-header">
                <h3 class="dash-card-title">
                    <i class="fas fa-user-clock text-primary" aria-hidden="true"></i>
                    ការចុះឈ្មោះថ្មីៗ (Recent Enrollments)
                </h3>
                <a href="{{ route('enrollments.index') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-list mr-1" aria-hidden="true"></i>មើលទាំងអស់
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover dash-table mb-0">
                    <thead>
                        <tr>
                            <th>សិស្ស (Student)</th>
                            <th>វគ្គសិក្សា (Course)</th>
                            <th class="d-none d-lg-table-cell">កាលបរិច្ឆេទ (Date)</th>
                            <th class="text-center">ស្ថានភាព (Status)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentEnrollments as $enrollment)
                            @php
                                $status = strtolower($enrollment->status ?? 'studying');
                            @endphp
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="avatar-circle bg-primary-soft text-primary font-weight-bold">
                                            {{ $initialsOf($studentName($enrollment->student)) }}
                                        </span>
                                        <span class="ml-2">
                                            <span class="d-block font-weight-bold text-dark">
                                                {{ $studentName($enrollment->student) }}
                                            </span>
                                            <small class="text-muted">{{ $enrollment->student->student_code ?? '' }}</small>
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <span class="font-weight-600 text-dark">{{ $enrollment->course->course_name ?? 'N/A' }}</span>
                                    <br>
                                    <small class="badge badge-light border">{{ $enrollment->course->course_code ?? '' }}</small>
                                </td>
                                <td class="d-none d-lg-table-cell text-muted">
                                    <i class="far fa-calendar-alt mr-1" aria-hidden="true"></i>
                                    {{ $enrollment->enrollment_date
                                        ? \Carbon\Carbon::parse($enrollment->enrollment_date)->format('d/m/Y')
                                        : ($enrollment->created_at ? $enrollment->created_at->format('d/m/Y') : '—') }}
                                </td>
                                <td class="text-center">
                                    @if($status === 'completed')
                                        <span class="badge badge-success px-2 py-1"><i class="fas fa-check mr-1" aria-hidden="true"></i> Completed</span>
                                    @elseif($status === 'studying' || $status === 'active')
                                        <span class="badge badge-info px-2 py-1"><i class="fas fa-book-reader mr-1" aria-hidden="true"></i> Studying</span>
                                    @elseif($status === 'dropped' || $status === 'cancelled')
                                        <span class="badge badge-danger px-2 py-1"><i class="fas fa-times mr-1" aria-hidden="true"></i> Dropped</span>
                                    @else
                                        <span class="badge badge-warning px-2 py-1">{{ ucfirst($status) }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block text-gray-300" aria-hidden="true"></i>
                                    មិនទាន់មានការចុះឈ្មោះនៅឡើយទេ (No enrollments recorded yet)
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if(count($recentEnrollments) > 0)
                <div class="dash-card-footer">
                    <a href="{{ route('enrollments.index') }}" class="dash-link">
                        គ្រប់គ្រងការចុះឈ្មោះទាំងអស់ <i class="fas fa-arrow-right ml-1" aria-hidden="true"></i>
                    </a>
                </div>
            @endif
        </div>
    </div>
    <div class="col-xl-5">
        <div class="card dash-card h-100">
            <div class="dash-card-header">
                <h3 class="dash-card-title">
                    <i class="fas fa-stream text-info" aria-hidden="true"></i>
                    សកម្មភាពថ្មីៗ (Recent Activities)
                </h3>
                <span class="badge badge-light border">{{ $activities->count() }}</span>
            </div>
            <div class="card-body">
                @if($activities->count() > 0)
                    <div class="activity-list">
                        @foreach($activities as $activity)
                            <a href="{{ $activity['url'] }}" class="activity-item">
                                <span class="activity-dot activity-dot-{{ $activity['tone'] }}">
                                    <i class="{{ $activity['icon'] }}" aria-hidden="true"></i>
                                </span>
                                <span class="activity-body">
                                    <span class="activity-title">{{ $activity['title'] }}</span>
                                    <span class="activity-text">
                                        {{ $activity['message'] }}
                                        @if(! empty($activity['subject']))
                                            <strong>{{ $activity['subject'] }}</strong>
                                        @endif
                                    </span>
                                    <span class="activity-time">
                                        <i class="far fa-clock" aria-hidden="true"></i> {{ $activityDate($activity['at']) }}
                                    </span>
                                </span>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-stream d-block mb-2" aria-hidden="true"></i>
                        មិនទាន់មានសកម្មភាពថ្មីៗទេ (No recent activity)
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
{{-- ======================= RECENT COURSES + QUICK ACTIONS ======================= --}}
<div class="row">
    <div class="col-xl-8">
        <div class="card dash-card h-100">
            <div class="dash-card-header">
                <h3 class="dash-card-title">
                    <i class="fas fa-book text-info" aria-hidden="true"></i>
                    វគ្គសិក្សាថ្មីៗ (Recent Courses)
                </h3>
                <a href="{{ route('courses.create') }}" class="btn btn-sm btn-success">
                    <i class="fas fa-plus mr-1" aria-hidden="true"></i>បន្ថែមវគ្គសិក្សា
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover dash-table mb-0">
                    <thead>
                        <tr>
                            <th>កូដ (Code)</th>
                            <th>ឈ្មោះវគ្គសិក្សា (Course Name)</th>
                            <th class="d-none d-md-table-cell">ប្រភេទ (Category)</th>
                            <th class="d-none d-sm-table-cell text-center">ម៉ូឌុល</th>
                            <th class="d-none d-lg-table-cell text-center">ចុះឈ្មោះ</th>
                            <th class="text-center">សកម្មភាព (Actions)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentCourses as $course)
                            <tr>
                                <td class="font-weight-bold text-primary">{{ $course->course_code }}</td>
                                <td>
                                    <span class="font-weight-600 text-dark">{{ $course->course_name }}</span>
                                    @if($course->visibility)
                                        <span class="badge badge-light border ml-1">{{ ucfirst($course->visibility) }}</span>
                                    @endif
                                </td>
                                <td class="d-none d-md-table-cell text-muted">
                                    {{ $course->category->category_name ?? 'N/A' }}
                                </td>
                                <td class="d-none d-sm-table-cell text-center">
                                    <span class="badge badge-secondary px-2 py-1">
                                        {{ $course->course_modules_count ?? 0 }}
                                    </span>
                                </td>
                                <td class="d-none d-lg-table-cell text-center">
                                    <span class="badge badge-primary px-2 py-1">
                                        {{ $course->enrollments_count ?? 0 }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('courses.modules.index', $course->course_id) }}" class="btn btn-sm btn-outline-info" title="គ្រប់គ្រងម៉ូឌុល (Manage Modules)">
                                        <i class="fas fa-folder-open" aria-hidden="true"></i>
                                    </a>
                                    <a href="{{ route('courses.edit', $course->course_id) }}" class="btn btn-sm btn-outline-primary" title="កែប្រែវគ្គសិក្សា (Edit Course)">
                                        <i class="fas fa-edit" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-book-reader fa-2x mb-2 d-block text-gray-300" aria-hidden="true"></i>
                                    មិនទាន់មានវគ្គសិក្សានៅឡើយទេ (No courses available)
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="dash-card-footer">
                <a href="{{ route('courses.index') }}" class="dash-link">
                    មើលវគ្គសិក្សាទាំងអស់ <i class="fas fa-arrow-right ml-1" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card dash-card h-100">
            <div class="dash-card-header">
                <h3 class="dash-card-title">
                    <i class="fas fa-bolt text-warning" aria-hidden="true"></i>
                    សកម្មភាពរហ័ស (Quick Actions)
                </h3>
            </div>
            <div class="card-body">
                <div class="quick-action-grid">
                    <a href="{{ route('courses.create') }}" class="quick-action">
                        <span class="quick-action-icon qa-primary"><i class="fas fa-plus-circle" aria-hidden="true"></i></span>
                        <span class="quick-action-text">
                            <span class="quick-action-title">បន្ថែមវគ្គសិក្សា</span>
                            <span class="quick-action-sub">Add Course</span>
                        </span>
                    </a>
                    <a href="{{ route('students.create') }}" class="quick-action">
                        <span class="quick-action-icon qa-warning"><i class="fas fa-user-plus" aria-hidden="true"></i></span>
                        <span class="quick-action-text">
                            <span class="quick-action-title">ចុះឈ្មោះសិស្ស</span>
                            <span class="quick-action-sub">Add Student</span>
                        </span>
                    </a>
                    <a href="{{ route('enrollments.index') }}" class="quick-action">
                        <span class="quick-action-icon qa-info"><i class="fas fa-user-graduate" aria-hidden="true"></i></span>
                        <span class="quick-action-text">
                            <span class="quick-action-title">ការចុះឈ្មោះរៀន</span>
                            <span class="quick-action-sub">Enrollments</span>
                        </span>
                    </a>
                    <a href="{{ route('teachers.create') }}" class="quick-action">
                        <span class="quick-action-icon qa-danger"><i class="fas fa-chalkboard-teacher" aria-hidden="true"></i></span>
                        <span class="quick-action-text">
                            <span class="quick-action-title">បន្ថែមគ្រូបង្រៀន</span>
                            <span class="quick-action-sub">Add Teacher</span>
                        </span>
                    </a>
                    <a href="{{ route('lessons.create') }}" class="quick-action">
                        <span class="quick-action-icon qa-success"><i class="fas fa-video" aria-hidden="true"></i></span>
                        <span class="quick-action-text">
                            <span class="quick-action-title">បង្កើតមេរៀន</span>
                            <span class="quick-action-sub">Create Lesson</span>
                        </span>
                    </a>
                    <a href="{{ route('course-categories.index') }}" class="quick-action">
                        <span class="quick-action-icon qa-secondary"><i class="fas fa-tags" aria-hidden="true"></i></span>
                        <span class="quick-action-text">
                            <span class="quick-action-title">ប្រភេទវគ្គសិក្សា</span>
                            <span class="quick-action-sub">Course Categories</span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('styles')
<style>
    /* ================= Dashboard (presentation only) ================= */
    .dash-card {
        background: #fff;
        border: 1px solid #eef1f6;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(16, 24, 40, .06);
        overflow: hidden;
    }

    .dash-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        padding: 14px 18px;
        background: #fff;
        border-bottom: 1px solid #eef1f6;
    }

    .dash-card-title {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
        color: #22303f;
        font-size: 1rem;
        font-weight: 600;
    }

    .dash-card-footer {
        padding: 12px 18px;
        text-align: center;
        background: #fbfcfe;
        border-top: 1px solid #eef1f6;
    }

    .dash-link {
        color: #1a73e8;
        font-size: .88rem;
        font-weight: 600;
    }

    .dash-link:hover {
        color: #0b57d0;
        text-decoration: none;
    }

    .dash-note {
        color: #8a94a6;
        font-size: .82rem;
        line-height: 1.6;
    }

    /* ---------- KPI cards ---------- */
    .kpi-card {
        display: flex;
        flex-direction: column;
    }

    .kpi-card .card-body {
        flex: 1 1 auto;
        padding: 18px 18px 12px;
    }

    .kpi-head {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 14px;
    }

    .kpi-icon {
        display: flex;
        flex: 0 0 46px;
        align-items: center;
        justify-content: center;
        width: 46px;
        height: 46px;
        border-radius: 12px;
        font-size: 18px;
    }

    .kpi-icon-primary { background: #e8f0fe; color: #1a73e8; }
    .kpi-icon-info    { background: #e5f6fb; color: #0f7f9c; }
    .kpi-icon-success { background: #e7f6ed; color: #1e7e45; }
    .kpi-icon-warning { background: #fdf3e3; color: #a26a09; }
    .kpi-icon-danger  { background: #fdeaea; color: #b3261e; }

    .kpi-titles {
        display: flex;
        flex-direction: column;
        min-width: 0;
    }

    .kpi-label {
        color: #22303f;
        font-size: .95rem;
        font-weight: 600;
    }

    .kpi-label-en {
        color: #8a94a6;
        font-size: .78rem;
    }

    .kpi-value {
        margin: 0;
        color: #1f2b3a;
        font-size: 1.95rem;
        font-weight: 700;
        line-height: 1.1;
    }

    .kpi-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 18px;
        color: #5b6577;
        background: #fbfcfe;
        border-top: 1px solid #eef1f6;
        font-size: .84rem;
        font-weight: 600;
    }

    .kpi-footer:hover {
        color: #1a73e8;
        background: #f4f8fd;
        text-decoration: none;
    }

    /* ---------- Mini statistics ---------- */
    .mini-stat {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 15px;
        color: inherit;
        background: #fff;
        border: 1px solid #eef1f6;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(16, 24, 40, .05);
        transition: transform .12s ease, box-shadow .12s ease;
    }

    .mini-stat:hover {
        color: inherit;
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(16, 24, 40, .09);
    }

    .mini-stat-icon {
        display: flex;
        flex: 0 0 38px;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 10px;
        font-size: 15px;
    }

    .mini-stat-body {
        display: flex;
        flex-direction: column;
        min-width: 0;
    }

    .mini-stat-value {
        color: #1f2b3a;
        font-size: 1.25rem;
        font-weight: 700;
        line-height: 1.2;
    }

    .mini-stat-label {
        color: #5b6577;
        font-size: .82rem;
        font-weight: 600;
    }

    .mini-stat-label em {
        display: block;
        color: #98a2b3;
        font-size: .72rem;
        font-style: normal;
        font-weight: 500;
    }

    .bg-success-soft   { background: #e7f6ed; }
    .bg-info-soft      { background: #e5f6fb; }
    .bg-warning-soft   { background: #fdf3e3; }
    .bg-secondary-soft { background: #eef1f6; }
    .bg-danger-soft    { background: #fdeaea; }

    /* ---------- Charts ---------- */
    .chart-box {
        position: relative;
        width: 100%;
    }

    .chart-box-lg {
        height: 300px;
    }

    .chart-box-doughnut {
        height: 230px;
    }

    .chart-center {
        position: absolute;
        top: 50%;
        left: 50%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        pointer-events: none;
        text-align: center;
        transform: translate(-50%, -50%);
    }

    .chart-center-value {
        color: #1f2b3a;
        font-size: 1.6rem;
        font-weight: 700;
        line-height: 1.1;
    }

    .chart-center-label {
        color: #8a94a6;
        font-size: .78rem;
    }

    .chart-legend {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 8px;
    }

    .chart-legend-item {
        color: #5b6577;
        font-size: .84rem;
    }

    .chart-legend-item i {
        font-size: .6rem;
        vertical-align: middle;
    }

    /* ---------- Tables ---------- */
    .dash-table thead th {
        padding: 12px 16px;
        color: #7b8698;
        background: #f8fafc;
        border-top: 0;
        border-bottom: 1px solid #eef1f6;
        font-size: .8rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .dash-table tbody td {
        padding: 13px 16px;
        vertical-align: middle;
        border-top: 1px solid #f1f4f9;
    }

    .dash-table tbody tr:hover {
        background: #fafcff;
    }

    /* ---------- Recent activities ---------- */
    .activity-list {
        display: flex;
        flex-direction: column;
    }

    .activity-item {
        display: flex;
        gap: 12px;
        padding: 12px 0;
        color: inherit;
        border-bottom: 1px dashed #eef1f6;
    }

    .activity-item:last-child {
        padding-bottom: 0;
        border-bottom: 0;
    }

    .activity-item:hover {
        color: inherit;
        text-decoration: none;
    }

    .activity-item:hover .activity-title {
        color: #1a73e8;
    }

    .activity-dot {
        display: flex;
        flex: 0 0 36px;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        font-size: 14px;
    }

    .activity-dot-primary { background: #e8f0fe; color: #1a73e8; }
    .activity-dot-success { background: #e7f6ed; color: #1e7e45; }
    .activity-dot-info    { background: #e5f6fb; color: #0f7f9c; }

    .activity-body {
        display: flex;
        flex-direction: column;
        min-width: 0;
    }

    .activity-title {
        color: #22303f;
        font-size: .9rem;
        font-weight: 600;
        word-break: break-word;
    }

    .activity-text {
        color: #5b6577;
        font-size: .82rem;
        line-height: 1.6;
        word-break: break-word;
    }

    .activity-time {
        color: #98a2b3;
        font-size: .76rem;
    }

    /* ---------- Quick actions ---------- */
    .quick-action-grid {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .quick-action {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 11px 13px;
        color: inherit;
        background: #fbfcfe;
        border: 1px solid #eef1f6;
        border-radius: 10px;
    }

    .quick-action:hover {
        color: inherit;
        text-decoration: none;
        background: #f4f8fd;
        border-color: #d7e5fb;
    }

    .quick-action-icon {
        display: flex;
        flex: 0 0 36px;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 10px;
        font-size: 14px;
    }

    .qa-primary   { background: #e8f0fe; color: #1a73e8; }
    .qa-info      { background: #e5f6fb; color: #0f7f9c; }
    .qa-success   { background: #e7f6ed; color: #1e7e45; }
    .qa-warning   { background: #fdf3e3; color: #a26a09; }
    .qa-danger    { background: #fdeaea; color: #b3261e; }
    .qa-secondary { background: #eef1f6; color: #5b6577; }

    .quick-action-text {
        display: flex;
        flex-direction: column;
        min-width: 0;
    }

    .quick-action-title {
        color: #22303f;
        font-size: .88rem;
        font-weight: 600;
    }

    .quick-action-sub {
        color: #98a2b3;
        font-size: .74rem;
    }

    /* ---------- Shared bits ---------- */
    .avatar-circle {
        display: flex;
        flex: 0 0 38px;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        font-size: 13px;
    }

    .bg-primary-soft {
        background-color: #e8f0fe;
        color: #1a73e8;
    }

    .font-weight-600 {
        font-weight: 600;
    }

    .empty-state {
        padding: 28px 16px;
        color: #8a94a6;
        text-align: center;
        background: #fbfcfe;
        border: 1px dashed #dbe3ee;
        border-radius: 10px;
        font-size: .88rem;
    }

    .empty-state i {
        color: #c3ccda;
        font-size: 26px;
    }

    /* ---------- Responsive ---------- */
    @media (max-width: 1199.98px) {
        .mini-stat {
            margin-bottom: 0;
        }
    }

    @media (max-width: 991.98px) {
        .chart-box-lg {
            height: 320px;
        }
    }

    @media (max-width: 575.98px) {
        .kpi-card .card-body {
            padding: 14px 14px 10px;
        }

        .kpi-icon {
            flex: 0 0 40px;
            width: 40px;
            height: 40px;
            font-size: 16px;
        }

        .kpi-value {
            font-size: 1.5rem;
        }

        .kpi-label {
            font-size: .85rem;
        }

        .kpi-label-en,
        .mini-stat-label em {
            font-size: .7rem;
        }

        .kpi-footer {
            padding: 9px 14px;
            font-size: .78rem;
        }

        .mini-stat {
            gap: 9px;
            padding: 11px 12px;
        }

        .mini-stat-icon {
            flex: 0 0 32px;
            width: 32px;
            height: 32px;
            font-size: 13px;
        }

        .mini-stat-value {
            font-size: 1.05rem;
        }

        .mini-stat-label {
            font-size: .75rem;
        }

        .dash-card-header {
            padding: 12px 14px;
        }

        .dash-card-title {
            font-size: .92rem;
        }

        .chart-box-lg {
            height: 280px;
        }

        .chart-box-doughnut {
            height: 200px;
        }

        .dash-table thead th,
        .dash-table tbody td {
            padding: 10px 12px;
        }

        .dash-card-footer {
            padding: 10px 14px;
        }
    }
</style>
@endpush
@push('scripts')
<script src="{{ asset('backend/plugins/chart.js/Chart.min.js') }}"></script>
<script>
    (function () {
        if (typeof Chart === 'undefined') {
            return;
        }

        var tickColor = '#8a94a6';
        var gridColor = '#eef1f6';
        var tooltipStyle = {
            backgroundColor: 'rgba(33, 43, 54, .92)',
            displayColors: false,
            cornerRadius: 4
        };

        /* Top courses by enrollments (existing $popularCourses data) */
        var popularCanvas = document.getElementById('popularCoursesChart');

        if (popularCanvas) {
            new Chart(popularCanvas.getContext('2d'), {
                type: 'horizontalBar',
                data: {
                    labels: @json($popularChartLabels),
                    datasets: [{
                        label: 'ការចុះឈ្មោះ (Enrollments)',
                        data: @json($popularChartValues),
                        backgroundColor: @json($popularChartColors),
                        hoverBackgroundColor: @json($popularChartColors),
                        borderWidth: 0,
                        maxBarThickness: 22
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: { display: false },
                    scales: {
                        xAxes: [{
                            ticks: {
                                beginAtZero: true,
                                precision: 0,
                                fontColor: tickColor,
                                fontSize: 11
                            },
                            gridLines: { color: gridColor, drawBorder: false, zeroLineColor: gridColor }
                        }],
                        yAxes: [{
                            ticks: {
                                fontColor: '#5b6577',
                                fontSize: 11,
                                callback: function (value) {
                                    var label = String(value);

                                    return label.length > 26 ? label.substring(0, 26) + '…' : label;
                                }
                            },
                            gridLines: { display: false, drawBorder: false }
                        }]
                    },
                    tooltips: Object.assign({}, tooltipStyle, {
                        callbacks: {
                            title: function (items) {
                                return items[0].yLabel;
                            },
                            label: function (item, data) {
                                var value = data.datasets[item.datasetIndex].data[item.index] || 0;

                                return value + ' enrollments';
                            }
                        }
                    })
                }
            });
        }

        /* Completion rate split (existing $totalEnrollments + $completionRate) */
        var completionCanvas = document.getElementById('completionChart');

        if (completionCanvas) {
            new Chart(completionCanvas.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['បានបញ្ចប់ (Completed)', 'កំពុងសិក្សា (In progress)'],
                    datasets: [{
                        data: [{{ $completedRate }}, {{ $remainingRate }}],
                        backgroundColor: ['#28a745', '#e9edf3'],
                        hoverBackgroundColor: ['#218838', '#dde3ec'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutoutPercentage: 74,
                    legend: { display: false },
                    tooltips: Object.assign({}, tooltipStyle, {
                        callbacks: {
                            label: function (item, data) {
                                return data.labels[item.index] + ': ' + data.datasets[0].data[item.index] + '%';
                            }
                        }
                    })
                }
            });
        }
    })();
</script>
@endpush

