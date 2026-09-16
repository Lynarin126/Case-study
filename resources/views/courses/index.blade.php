@extends('layouts.master')

@section('title', 'Courses | LMS')

@section('content')
<section class="content-header px-0">
    <div class="container-fluid px-0">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-7">
                <h1 class="mb-1">Courses</h1>
                <p class="text-muted mb-0">Manage course information by category.</p>
            </div>
            <div class="col-sm-5">
                <ol class="breadcrumb float-sm-right mb-0">
                    <li class="breadcrumb-item"><a href="{{ auth()->check() ? route('dashboard') : route('login') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Courses</li>
                </ol>
            </div>
        </div>
    </div>
</section>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-header d-flex align-items-center">
        <h3 class="card-title mb-0">Course List</h3>
        @auth
            <a href="{{ route('courses.create') }}" class="btn btn-primary btn-sm ml-auto">
                <i class="fas fa-plus mr-1"></i>
                Create New
            </a>
        @endauth
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped datatable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Code</th>
                    <th>Course Name</th>
                    <th>Category</th>
                    <th>Department</th>
                    <th>Description</th>
                    <th>Created Date</th>
                    @auth
                        <th>Actions</th>
                    @endauth
                </tr>
            </thead>
            <tbody>
                @foreach ($courses as $course)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $course->course_code }}</td>
                        <td>{{ $course->course_name }}</td>
                        <td>{{ $course->category?->category_name ?? '-' }}</td>
                        <td>{{ $course->department?->department_name ?? '-' }}</td>
                        <td>{{ $course->description ?? '-' }}</td>
                        <td>{{ $course->created_at?->format('Y-m-d') }}</td>
                        @auth
                            <td>
                                <button type="button" class="btn btn-info btn-sm btn-assign-teacher" data-course-id="{{ $course->course_id }}">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                </button>
                                <button type="button" class="btn btn-success btn-sm btn-enroll-student" data-course-id="{{ $course->course_id }}">
                                    <i class="fas fa-user-plus"></i>
                                </button>
                                <a href="{{ route('courses.modules.index', $course) }}" class="btn btn-secondary btn-sm" title="Modules and lessons">
                                    <i class="fas fa-book"></i>
                                </a>
                                <a href="{{ route('courses.edit', $course) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('courses.destroy', $course) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this course?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        @endauth
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@auth

<!-- Assign Teacher Modal -->
<div class="modal fade" id="assignTeacherModal" tabindex="-1" role="dialog" aria-labelledby="assignTeacherModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('courses.assign_teacher') }}" method="POST">
            @csrf
            <input type="hidden" name="course_id" id="assign_teacher_course_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignTeacherModalLabel">Assign Teacher</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Teacher <span class="text-danger">*</span></label>
                        <select name="teacher_id" id="assign_teacher_id" class="form-control select2" style="width: 100%;" required>
                            <option value="">-- Select teacher --</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->teacher_id }}">
                                    {{ $teacher->full_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Enroll Student Modal -->
<div class="modal fade" id="enrollStudentModal" tabindex="-1" role="dialog" aria-labelledby="enrollStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('enrollments.store') }}" method="POST">
            @csrf
            <input type="hidden" name="course_id" id="enroll_student_course_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="enrollStudentModalLabel">Enroll Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Student <span class="text-danger">*</span></label>
                        <select name="student_id" id="enroll_student_id" class="form-control select2" style="width: 100%;" required>
                            <option value="">-- Select student --</option>
                            @foreach($students as $student)
                                <option value="{{ $student->student_id }}">
                                    {{ $student->full_name }} ({{ $student->student_code }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Enrollment Date <span class="text-danger">*</span></label>
                        <input type="date" name="enrollment_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required>
                            <option value="studying">Studying</option>
                            <option value="completed">Completed</option>
                            <option value="dropped">Dropped</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Note</label>
                        <textarea name="note" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        const assignedTeachersMap = @json($assignedTeachersMap);
        const enrolledStudentsMap = @json($enrolledStudentsMap);

        function initSelect2(selector, modalId) {
            $(selector).select2({
                theme: 'bootstrap4',
                width: '100%',
                dropdownParent: $(modalId)
            });
        }

        $('.btn-assign-teacher').click(function() {
            const courseId = $(this).data('course-id');
            $('#assign_teacher_course_id').val(courseId);
            
            const assignedIds = assignedTeachersMap[courseId] || [];
            $('#assign_teacher_id option').each(function() {
                const teacherId = $(this).val();
                if (teacherId === "") return;
                
                if (assignedIds.includes(parseInt(teacherId))) {
                    $(this).prop('disabled', true);
                } else {
                    $(this).prop('disabled', false);
                }
            });
            
            $('#assign_teacher_id').val(null);
            $('#assignTeacherModal').modal('show');
            initSelect2('#assign_teacher_id', '#assignTeacherModal');
        });

        $('.btn-enroll-student').click(function() {
            const courseId = $(this).data('course-id');
            $('#enroll_student_course_id').val(courseId);
            
            const enrolledIds = enrolledStudentsMap[courseId] || [];
            $('#enroll_student_id option').each(function() {
                const studentId = $(this).val();
                if (studentId === "") return;
                
                if (enrolledIds.includes(parseInt(studentId))) {
                    $(this).prop('disabled', true);
                } else {
                    $(this).prop('disabled', false);
                }
            });
            
            $('#enroll_student_id').val(null);
            $('#enrollStudentModal').modal('show');
            initSelect2('#enroll_student_id', '#enrollStudentModal');
        });

        @if ($errors->any())
            alert('Please check the form and try again.');
        @endif
    });
</script>
@endpush
@endauth

@endsection


