@extends('layouts.master')

@section('title', 'ការចុះឈ្មោះ | LMS')

@section('content')
<section class="content-header px-0">
    <div class="container-fluid px-0">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-7">
                <h1 class="mb-1">ការចុះឈ្មោះ</h1>
                <p class="text-muted mb-0">គ្រប់គ្រងបញ្ជីការចុះឈ្មោះសម្រាប់ប្រព័ន្ធ LMS។</p>
            </div>
            <div class="col-sm-5">
                <ol class="breadcrumb float-sm-right mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">ផ្ទាំងគ្រប់គ្រង</a></li>
                    <li class="breadcrumb-item active">ការចុះឈ្មោះ</li>
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
        <h3 class="card-title mb-0">បញ្ជីការចុះឈ្មោះ</h3>
        <button type="button" class="btn btn-primary btn-sm ml-auto" data-toggle="modal" data-target="#createModal">
            <i class="fas fa-plus mr-1"></i>
            បង្កើតថ្មី
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped datatable">
                <thead>
                    <tr>
                        <th>ល.រ</th>
                        <th>និស្សិត</th>
                        <th>វគ្គសិក្សា</th>
                        <th>កាលបរិច្ឆេទចុះឈ្មោះ</th>
                        <th>ស្ថានភាព</th>
                        <th>សកម្មភាព</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($enrollments as $enrollment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $enrollment->student ? $enrollment->student->first_name . ' ' . $enrollment->student->last_name : 'N/A' }}</td>
                            <td>{{ $enrollment->course ? $enrollment->course->course_name : 'N/A' }}</td>
                            <td>{{ $enrollment->enrollment_date }}</td>
                            <td>
                                @if($enrollment->status == 'studying')
                                    <span class="badge badge-success">កំពុងសិក្សា</span>
                                @elseif($enrollment->status == 'completed')
                                    <span class="badge badge-primary">បញ្ចប់</span>
                                @else
                                    <span class="badge badge-secondary">{{ $enrollment->status }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('enrollments.edit', $enrollment) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('enrollments.destroy', $enrollment) }}" method="POST" class="d-inline" onsubmit="return confirm('តើអ្នកពិតជាចង់លុបមែនទេ?');">
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
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('enrollments.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">ការចុះឈ្មោះថ្មី</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        <label>និស្សិត <span class="text-danger">*</span></label>
                        <select name="student_id" id="student_id" class="form-control select2" style="width: 100%;" required>
                            <option value="">-- ជ្រើសរើសនិស្សិត --</option>
                            @foreach($students as $student)
                                <option value="{{ $student->student_id }}" {{ old('student_id') == $student->student_id ? 'selected' : '' }}>
                                    {{ $student->first_name }} {{ $student->last_name }} ({{ $student->student_code }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>វគ្គសិក្សា <span class="text-danger">*</span></label>
                        <select name="course_id" id="course_id" class="form-control select2" style="width: 100%;" required>
                            <option value="">-- ជ្រើសរើសវគ្គសិក្សា --</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->course_id }}" {{ old('course_id') == $course->course_id ? 'selected' : '' }}>
                                    {{ $course->course_name }} ({{ $course->course_code }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>កាលបរិច្ឆេទចុះឈ្មោះ <span class="text-danger">*</span></label>
                        <input type="date" name="enrollment_date" class="form-control" value="{{ old('enrollment_date', date('Y-m-d')) }}" required>
                    </div>

                    <div class="form-group">
                        <label>ស្ថានភាព <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required>
                            <option value="studying" {{ old('status') == 'studying' ? 'selected' : '' }}>កំពុងសិក្សា</option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>បញ្ចប់</option>
                            <option value="dropped" {{ old('status') == 'dropped' ? 'selected' : '' }}>បោះបង់</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>កំណត់សម្គាល់</label>
                        <textarea name="note" class="form-control" rows="3">{{ old('note') }}</textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">បិទ</button>
                    <button type="submit" class="btn btn-primary">រក្សាទុក</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%',
                dropdownParent: $('#createModal') // Fix for Select2 search input focus in Bootstrap modals
            });

            @if ($errors->any())
                $('#createModal').modal('show');
            @endif

            const enrolledStudentsMap = @json($enrolledStudentsMap);
            
            $('#course_id').on('change', function() {
                const courseId = $(this).val();
                const enrolledStudentIds = enrolledStudentsMap[courseId] || [];

                $('#student_id option').each(function() {
                    const studentId = $(this).val();
                    if (studentId === "") return;

                    if (enrolledStudentIds.includes(parseInt(studentId))) {
                        $(this).prop('disabled', true);
                        if ($(this).is(':selected')) {
                            $('#student_id').val(null).trigger('change');
                        }
                    } else {
                        $(this).prop('disabled', false);
                    }
                });

                // Tell Select2 to update the dropdown based on new disabled properties
                $('#student_id').select2('destroy').select2({
                    theme: 'bootstrap4',
                    width: '100%',
                    dropdownParent: $('#createModal')
                });
            });

            // Trigger change on load if a course is already selected (e.g. from old input)
            if ($('#course_id').val()) {
                $('#course_id').trigger('change');
            }
        });
    </script>
@endpush

@endsection
