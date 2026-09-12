@extends('layouts.master')

@section('title', 'ម៉ូឌុល និងមេរៀន | LMS')

@section('content')
<section class="content-header px-0">
    <div class="container-fluid px-0">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-7">
                <h1 class="mb-1">ម៉ូឌុល និងមេរៀន</h1>
                <p class="text-muted mb-0">វគ្គសិក្សា៖ <strong>{{ $course->course_name }}</strong></p>
            </div>
            <div class="col-sm-5">
                <ol class="breadcrumb float-sm-right mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">ផ្ទាំងគ្រប់គ្រង</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">វគ្គសិក្សា</a></li>
                    <li class="breadcrumb-item active">ម៉ូឌុល</li>
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

<div class="card shadow-sm mb-4">
    <div class="card-header d-flex align-items-center">
        <h3 class="card-title mb-0">បញ្ជីម៉ូឌុល</h3>
        <button class="btn btn-primary btn-sm ml-auto" data-toggle="modal" data-target="#createModuleModal">
            <i class="fas fa-plus mr-1"></i> បង្កើតម៉ូឌុលថ្មី
        </button>
    </div>
    <div class="card-body">
        @if($modules->isEmpty())
            <div class="alert alert-info mb-0">មិនទាន់មានម៉ូឌុលនៅឡើយទេ។ សូមបង្កើតម៉ូឌុលថ្មីដើម្បីបន្ថែមមេរៀន។</div>
        @else
            <div class="accordion" id="modulesAccordion">
                @foreach($modules as $module)
                    <div class="card mb-2">
                        <div class="card-header d-flex align-items-center justify-content-between" id="heading{{ $module->course_module_id }}" style="background-color: #f8f9fa;">
                            <h5 class="mb-0">
                                <button class="btn btn-link text-dark font-weight-bold" type="button" data-toggle="collapse" data-target="#collapse{{ $module->course_module_id }}" aria-expanded="true" aria-controls="collapse{{ $module->course_module_id }}">
                                    ម៉ូឌុលទី {{ $module->module_number }}: {{ $module->title }}
                                </button>
                            </h5>
                            <div>
                                <a href="{{ route('lessons.create', ['course_id' => $course->course_id, 'course_module_id' => $module->course_module_id]) }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-plus mr-1"></i> បន្ថែមមេរៀន
                                </a>
                            </div>
                        </div>

                        <div id="collapse{{ $module->course_module_id }}" class="collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="heading{{ $module->course_module_id }}" data-parent="#modulesAccordion">
                            <div class="card-body p-0">
                                @if($module->lessons->isEmpty())
                                    <div class="p-3 text-muted text-center border-top">មិនទាន់មានមាតិកានៅក្នុងម៉ូឌុលនេះទេ។</div>
                                @else
                                    <ul class="list-group list-group-flush">
                                        @foreach($module->lessons as $lesson)
                                            <li class="list-group-item d-flex align-items-center">
                                                <div class="mr-3 text-secondary">
                                                    @if($lesson->content_type == 'video')
                                                        <i class="fas fa-video"></i>
                                                    @elseif($lesson->content_type == 'document' || $lesson->content_type == 'file')
                                                        <i class="fas fa-file-pdf"></i>
                                                    @elseif($lesson->content_type == 'assignment')
                                                        <i class="fas fa-tasks"></i>
                                                    @else
                                                        <i class="fas fa-book-open"></i>
                                                    @endif
                                                </div>
                                                <div class="flex-grow-1">
                                                    <strong>{{ $lesson->title }}</strong>
                                                    @if($lesson->summary)
                                                        <p class="mb-0 text-muted small">{{ Str::limit($lesson->summary, 100) }}</p>
                                                    @endif
                                                </div>
                                                <div>
                                                    <span class="badge badge-secondary">{{ ucfirst($lesson->content_type) }}</span>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<!-- Create Module Modal -->
<div class="modal fade" id="createModuleModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('courses.modules.store', $course) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">បង្កើតម៉ូឌុលថ្មី</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>លេខរៀងម៉ូឌុល <span class="text-danger">*</span></label>
                        <input type="number" name="module_number" class="form-control" value="{{ $modules->max('module_number') + 1 }}" required min="1">
                    </div>
                    <div class="form-group">
                        <label>ចំណងជើង <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>ការពិពណ៌នា</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
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

<!-- Create Lesson Modal -->
<div class="modal fade" id="createLessonModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form id="createLessonForm" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">បង្កើតមាតិកាថ្មី</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>ចំណងជើងមាតិកា <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>ប្រភេទ <span class="text-danger">*</span></label>
                                <select name="content_type" class="form-control" required>
                                    <option value="lesson">មេរៀន (Lesson)</option>
                                    <option value="video">វីដេអូ (Video)</option>
                                    <option value="file">ឯកសារ (File)</option>
                                    <option value="assignment">កិច្ចការ (Assignment)</option>
                                    <option value="quiz">កម្រងសំណួរ (Quiz)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>សេចក្តីសង្ខេប</label>
                        <textarea name="summary" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="form-group">
                        <label>ខ្លឹមសារលម្អិត</label>
                        <textarea name="body" class="form-control" rows="5" placeholder="អាចដាក់ជាអត្ថបទ ឬតំណភ្ជាប់..."></textarea>
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
        $('.btn-add-lesson').click(function() {
            const moduleId = $(this).data('module-id');
            // The route expects module ID
            const formAction = "{{ url('modules') }}/" + moduleId + "/lessons";
            $('#createLessonForm').attr('action', formAction);
            
            $('#createLessonModal').modal('show');
        });

        @if ($errors->any())
            alert('មានបញ្ហាក្នុងការរក្សាទុក។ សូមពិនិត្យមើលទិន្នន័យរបស់អ្នក។\n\n{{ implode('\n', $errors->all()) }}');
        @endif
    });
</script>
@endpush

@endsection
