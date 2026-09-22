@extends('layouts.master')

@section('title', 'ការចុះឈ្មោះ | LMS')

@push('styles')
<style>
    .page-header-premium {
        margin-bottom: 1.75rem;
    }
    .page-header-premium h1 {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e2432;
        letter-spacing: -0.01em;
    }
    .page-header-premium h1 i {
        font-size: 1.15rem;
        color: #4f46e5;
        background: #eef0ff;
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
    }
    .page-header-premium p {
        font-size: 0.88rem;
        color: #8a8f98;
        margin: 0.15rem 0 0 48px;
    }
    .page-header-premium .breadcrumb {
        background: transparent;
        padding: 0;
        font-size: 0.85rem;
    }
    .page-header-premium .breadcrumb-item a {
        color: #6b7280;
        text-decoration: none;
        transition: color 0.15s ease;
    }
    .page-header-premium .breadcrumb-item a:hover {
        color: #4f46e5;
    }
    .page-header-premium .breadcrumb-item.active {
        color: #1e2432;
        font-weight: 500;
    }

    .alert-premium {
        border: none;
        border-radius: 12px;
        border-left: 4px solid #16a34a;
        background: #f0fdf4;
        color: #15803d;
        font-size: 0.9rem;
        padding: 0.9rem 1.1rem;
    }

    .card-premium {
        position: relative;
        border: 1px solid #eef0f4;
        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(17, 24, 39, 0.05);
        overflow: hidden;
    }
    .card-premium::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #4f46e5, #818cf8);
    }
    .card-premium .card-header {
        padding: 1.1rem 1.75rem;
        border-bottom: 1px solid #f1f2f6;
        background: #fafbfc;
    }
    .card-premium .card-title {
        font-size: 1rem;
        font-weight: 600;
        color: #1e2432;
    }
    .card-premium .card-body {
        padding: 1.5rem 1.75rem 1.75rem;
    }

    .btn-premium-primary {
        background: #4f46e5;
        border: none;
        border-radius: 10px;
        font-size: 0.83rem;
        font-weight: 500;
        padding: 0.5rem 1rem;
        transition: background 0.15s ease, transform 0.1s ease;
    }
    .btn-premium-primary:hover {
        background: #4338ca;
        color: #fff;
    }

    .table-premium {
        margin-bottom: 0;
    }
    .table-premium thead th {
        background: #f8f9fb;
        color: #6b7280;
        font-size: 0.76rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        border: none;
        border-bottom: 1px solid #eef0f4;
        padding: 0.85rem 1rem;
        white-space: nowrap;
    }
    .table-premium tbody td {
        border: none;
        border-bottom: 1px solid #f4f5f8;
        padding: 0.85rem 1rem;
        font-size: 0.88rem;
        color: #374151;
        vertical-align: middle;
    }
    .table-premium tbody tr {
        transition: background 0.12s ease;
    }
    .table-premium tbody tr:hover {
        background: #fafbff;
    }
    .table-premium tbody tr:last-child td {
        border-bottom: none;
    }

    .badge-pill-premium {
        display: inline-block;
        padding: 0.32rem 0.75rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .badge-pill-studying {
        background: #dcfce7;
        color: #15803d;
    }
    .badge-pill-completed {
        background: #dbeafe;
        color: #1d4ed8;
    }
    .badge-pill-dropped {
        background: #f3f4f6;
        color: #4b5563;
    }

    .action-btn-premium {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        border: none;
        font-size: 0.8rem;
        transition: opacity 0.15s ease;
        padding: 0;
    }
    .action-btn-premium:hover {
        opacity: 0.85;
        color: #fff;
    }
    .action-edit-premium {
        background: #fef3c7;
        color: #b45309;
    }
    .action-edit-premium:hover {
        background: #f59e0b;
        color: #fff;
    }
    .action-delete-premium {
        background: #fee2e2;
        color: #b91c1c;
    }
    .action-delete-premium:hover {
        background: #ef4444;
        color: #fff;
    }

    /* Modal */
    .modal-premium .modal-content {
        border: none;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(17, 24, 39, 0.15);
    }
    .modal-premium .modal-header {
        border-bottom: 1px solid #f1f2f6;
        padding: 1.25rem 1.75rem;
        background: #fafbfc;
    }
    .modal-premium .modal-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #1e2432;
    }
    .modal-premium .modal-body {
        padding: 1.75rem;
    }
    .modal-premium .modal-footer {
        border-top: 1px solid #f1f2f6;
        padding: 1rem 1.75rem;
    }
    .modal-premium .form-group label {
        font-size: 0.83rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.4rem;
    }
    .modal-premium .form-control,
    .modal-premium .select2-container--bootstrap4 .select2-selection {
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        font-size: 0.88rem;
    }
    .modal-premium .form-control:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
    }
    .modal-premium .btn-secondary {
        border-radius: 10px;
        font-size: 0.83rem;
        padding: 0.5rem 1.1rem;
    }
</style>
@endpush

@section('content')
<section class="content-header px-0">
    <div class="container-fluid px-0">
        <div class="row mb-2 align-items-center page-header-premium">
            <div class="col-sm-7">
                <h1 class="mb-1"><i class="fas fa-clipboard-list"></i> ការចុះឈ្មោះ</h1>
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
    <div class="alert alert-premium alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="card card-premium">
    <div class="card-header d-flex align-items-center">
        <h3 class="card-title mb-0">បញ្ជីការចុះឈ្មោះ</h3>
        <button type="button" class="btn btn-premium-primary text-white ml-auto" data-toggle="modal" data-target="#createModal">
            <i class="fas fa-plus mr-1"></i>
            បង្កើតថ្មី
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-premium datatable">
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
                                    <span class="badge-pill-premium badge-pill-studying">កំពុងសិក្សា</span>
                                @elseif($enrollment->status == 'completed')
                                    <span class="badge-pill-premium badge-pill-completed">បញ្ចប់</span>
                                @else
                                    <span class="badge-pill-premium badge-pill-dropped">{{ $enrollment->status }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('enrollments.edit', $enrollment) }}" class="action-btn-premium action-edit-premium" title="កែប្រែ">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('enrollments.destroy', $enrollment) }}" method="POST" class="d-inline" onsubmit="return confirm('តើអ្នកពិតជាចង់លុបមែនទេ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn-premium action-delete-premium" title="លុប">
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
<div class="modal fade modal-premium" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
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
                    <button type="submit" class="btn btn-premium-primary text-white">រក្សាទុក</button>
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