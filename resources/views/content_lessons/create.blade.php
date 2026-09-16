@extends('layouts.master')

@section('title', 'បង្កើតមាតិកាសិក្សាថ្មី | LMS')

@push('styles')
<link rel="stylesheet" href="{{ asset('backend/plugins/summernote/summernote-bs4.min.css') }}">
<style>
    /* ===================================================
       SENIOR UI DESIGN SYSTEM - LMS CONTENT STUDIO
       =================================================== */
    :root {
        --studio-primary: #2563eb;
        --studio-primary-hover: #1d4ed8;
        --studio-primary-soft: #eff6ff;
        --studio-success: #10b981;
        --studio-success-soft: #ecfdf5;
        --studio-warning: #f59e0b;
        --studio-warning-soft: #fffbeb;
        --studio-purple: #8b5cf6;
        --studio-purple-soft: #f5f3ff;
        --studio-rose: #f43f5e;
        --studio-rose-soft: #fff1f2;
        --studio-cyan: #06b6d4;
        --studio-cyan-soft: #ecfeff;
        --studio-card-border: #e2e8f0;
        --studio-card-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05), 0 2px 6px -1px rgba(15, 23, 42, 0.03);
        --studio-radius-lg: 14px;
        --studio-radius-md: 10px;
    }

    .content-builder-page {
        color: #1e293b;
        padding-bottom: 90px;
    }

    /* Top Context & Hero Bar */
    .builder-hero-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 1px solid var(--studio-card-border);
        border-radius: var(--studio-radius-lg);
        box-shadow: var(--studio-card-shadow);
        padding: 22px 26px;
        margin-bottom: 22px;
        position: relative;
        overflow: hidden;
    }
    .builder-hero-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 6px;
        height: 100%;
        background: linear-gradient(180deg, var(--studio-primary) 0%, #60a5fa 100%);
    }
    .builder-hero-title {
        font-size: 24px;
        font-weight: 800;
        margin: 0 0 6px;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .builder-hero-subtitle {
        color: #64748b;
        margin: 0;
        font-size: 14.5px;
    }
    .context-pill-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        padding: 6px 14px;
        border-radius: 9999px;
        font-size: 13.5px;
        color: #334155;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .context-pill-badge strong {
        color: var(--studio-primary);
    }

    /* Main Two-Column Layout */
    .builder-layout {
        display: grid;
        grid-template-columns: 280px minmax(0, 1fr);
        gap: 24px;
        align-items: start;
    }

    /* Left Stepper / Nav */
    .builder-nav-sidebar {
        position: sticky;
        top: 86px;
        background: #ffffff;
        border: 1px solid var(--studio-card-border);
        border-radius: var(--studio-radius-lg);
        padding: 12px;
        box-shadow: var(--studio-card-shadow);
    }
    .builder-nav-header {
        padding: 10px 14px 14px;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 8px;
    }
    .builder-nav-header span {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #94a3b8;
    }
    .nav-step-item {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 14px;
        border: 0;
        background: transparent;
        color: #475569;
        text-align: left;
        padding: 11px 14px;
        border-radius: var(--studio-radius-md);
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s ease;
        position: relative;
        margin-bottom: 4px;
        cursor: pointer;
    }
    .nav-step-item:hover {
        background: #f8fafc;
        color: #0f172a;
    }
    .nav-step-item.active {
        background: var(--studio-primary-soft);
        color: var(--studio-primary);
        font-weight: 700;
    }
    .nav-step-item.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 20%;
        height: 60%;
        width: 3.5px;
        background: var(--studio-primary);
        border-radius: 0 4px 4px 0;
    }
    .nav-step-icon {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f1f5f9;
        color: #64748b;
        font-size: 14px;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }
    .nav-step-item.active .nav-step-icon {
        background: var(--studio-primary);
        color: #ffffff;
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3);
    }
    .nav-step-info {
        display: flex;
        flex-direction: column;
        line-height: 1.3;
        overflow: hidden;
    }
    .nav-step-title {
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }
    .nav-step-sub {
        font-size: 11.5px;
        color: #94a3b8;
        font-weight: 500;
    }
    .nav-step-item.active .nav-step-sub {
        color: #60a5fa;
    }
    .type-pill-indicator {
        margin-left: auto;
        font-size: 10.5px;
        padding: 2px 7px;
        border-radius: 999px;
        background: #e2e8f0;
        color: #475569;
        font-weight: 700;
    }
    .nav-step-item.active .type-pill-indicator {
        background: #dbeafe;
        color: var(--studio-primary);
    }

    /* Cards & Panels */
    .studio-card {
        background: #ffffff;
        border: 1px solid var(--studio-card-border);
        border-radius: var(--studio-radius-lg);
        box-shadow: var(--studio-card-shadow);
        margin-bottom: 22px;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .studio-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 18px 24px;
        background: #ffffff;
        border-bottom: 1px solid #f1f5f9;
    }
    .studio-card-header h2 {
        font-size: 17.5px;
        font-weight: 800;
        margin: 0;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .studio-card-header p {
        color: #64748b;
        margin: 4px 0 0;
        font-size: 13px;
    }
    .studio-card-body {
        padding: 24px;
    }

    /* Visual Content Type Selector Grid */
    .content-type-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 20px;
    }
    .type-radio-card {
        position: relative;
        border: 2px solid #e2e8f0;
        background: #ffffff;
        border-radius: var(--studio-radius-md);
        padding: 16px 14px;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        gap: 14px;
        user-select: none;
    }
    .type-radio-card:hover {
        border-color: #cbd5e1;
        background: #f8fafc;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
    }
    .type-radio-card.active {
        border-color: var(--studio-primary);
        background: #f0f7ff;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12), 0 4px 12px rgba(37, 99, 235, 0.08);
    }
    .type-radio-card input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }
    .type-card-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
        transition: all 0.2s ease;
    }
    .type-card-icon.video { background: #e0e7ff; color: #4338ca; }
    .type-card-icon.lesson { background: #dcfce7; color: #15803d; }
    .type-card-icon.file { background: #fef3c7; color: #b45309; }
    .type-card-icon.quiz { background: #f3e8ff; color: #7e22ce; }
    .type-card-icon.assignment { background: #ffe4e6; color: #be123c; }
    .type-card-icon.url { background: #cffafe; color: #0e7490; }

    .type-radio-card.active .type-card-icon {
        transform: scale(1.08);
    }
    .type-card-text {
        line-height: 1.25;
    }
    .type-card-text strong {
        display: block;
        font-size: 14.5px;
        color: #0f172a;
        margin-bottom: 2px;
    }
    .type-card-text span {
        font-size: 12px;
        color: #64748b;
    }
    .type-checked-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: var(--studio-primary);
        color: #ffffff;
        font-size: 10px;
        display: none;
        align-items: center;
        justify-content: center;
    }
    .type-radio-card.active .type-checked-badge {
        display: flex;
    }

    /* Form Fields & Labels */
    .form-group label {
        font-weight: 700;
        font-size: 13.5px;
        color: #334155;
        margin-bottom: 6px;
    }
    .form-control {
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 9px 13px;
        font-size: 14px;
        height: auto;
        color: #0f172a;
        transition: all 0.15s ease;
    }
    .form-control:focus {
        border-color: var(--studio-primary);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }

    /* Live Slug Preview Widget */
    .slug-preview-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 12.5px;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 8px;
        overflow-x: auto;
    }
    .slug-preview-link {
        color: #0f172a;
        font-family: monospace;
        font-weight: 600;
    }
    .slug-status-badge {
        margin-left: auto;
        font-size: 11px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 999px;
    }
    .slug-status-badge.valid {
        background: #dcfce7;
        color: #166534;
    }
    .slug-status-badge.duplicate {
        background: #fee2e2;
        color: #991b1b;
    }

    /* Toggle Switch Cards */
    .toggle-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }
    .toggle-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 16px;
        border: 1px solid #e2e8f0;
        border-radius: var(--studio-radius-md);
        background: #ffffff;
        transition: all 0.15s ease;
    }
    .toggle-card:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }
    .toggle-card-label {
        font-weight: 700;
        font-size: 14px;
        color: #1e293b;
        margin-bottom: 2px;
        display: block;
    }
    .toggle-card-desc {
        font-size: 12px;
        color: #64748b;
        display: block;
    }
    .custom-switch .custom-control-input:checked ~ .custom-control-label::before {
        background-color: var(--studio-primary);
        border-color: var(--studio-primary);
    }

    /* Drop Zone / Upload Area */
    .modern-dropzone {
        border: 2px dashed #93c5fd;
        background: #f8fbff;
        border-radius: var(--studio-radius-md);
        padding: 28px 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
    }
    .modern-dropzone:hover, .modern-dropzone.dragover {
        border-color: var(--studio-primary);
        background: #eff6ff;
        transform: scale(1.005);
    }
    .dropzone-icon-circle {
        width: 54px;
        height: 54px;
        border-radius: 50%;
        background: #dbeafe;
        color: var(--studio-primary);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin-bottom: 12px;
    }

    /* Question Row in Quiz Builder */
    .quiz-question-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: var(--studio-radius-md);
        padding: 18px;
        margin-bottom: 14px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        transition: all 0.2s ease;
        cursor: grab;
    }
    .quiz-question-card:active {
        cursor: grabbing;
    }
    .quiz-question-card.dragging {
        opacity: 0.5;
        border-color: var(--studio-primary);
    }
    .question-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
        padding-bottom: 10px;
        border-bottom: 1px solid #f1f5f9;
    }

    /* Sticky Bottom Actions Bar */
    .studio-sticky-bar {
        position: fixed;
        bottom: 0;
        left: var(--lms-sidebar-width, 270px);
        right: 0;
        background: rgba(255, 255, 255, 0.94);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-top: 1px solid #e2e8f0;
        padding: 14px 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        z-index: 1030;
        box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.05);
        transition: left 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .sidebar-collapse .studio-sticky-bar {
        left: var(--lms-sidebar-collapsed-width, 74px);
    }
    .btn-publish-gradient {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        border: none;
        color: #ffffff;
        font-weight: 700;
        padding: 10px 22px;
        border-radius: 8px;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
        transition: all 0.2s ease;
    }
    .btn-publish-gradient:hover {
        background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
        box-shadow: 0 6px 18px rgba(37, 99, 235, 0.45);
        color: #ffffff;
        transform: translateY(-1px);
    }
    .btn-draft-pill {
        background: #f1f5f9;
        color: #334155;
        border: 1px solid #cbd5e1;
        font-weight: 700;
        padding: 10px 20px;
        border-radius: 8px;
        transition: all 0.2s ease;
    }
    .btn-draft-pill:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .section-panel { display: none; }
    .section-panel.active { display: block; animation: fadeIn 0.25s ease; }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(6px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 991.98px) {
        .studio-sticky-bar { left: 0 !important; }
        .builder-layout { grid-template-columns: 1fr; }
        .builder-nav-sidebar { position: static; margin-bottom: 20px; }
        .content-type-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .toggle-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 575.98px) {
        .content-type-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<div class="content-builder-page">

    <!-- Top Context & Hero Banner -->
    <div class="builder-hero-card">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge badge-primary px-2.5 py-1 font-weight-bold" style="letter-spacing: 0.5px;">
                        <i class="fas fa-magic mr-1"></i> LMS CONTENT STUDIO
                    </span>
                    @if($selectedCourse)
                        <span class="badge badge-info px-2.5 py-1">
                            {{ $selectedCourse->course_code }}
                        </span>
                    @endif
                </div>
                <h1 class="builder-hero-title">
                    <i class="fas fa-pen-nib text-primary"></i>
                    បង្កើតមាតិកាសិក្សាថ្មី
                    <small class="text-muted font-weight-normal" style="font-size: 16px;">(Create Learning Content)</small>
                </h1>
                <p class="builder-hero-subtitle">
                    @if($selectedCourse && $selectedModule)
                        កំពុងបង្កើតមាតិកាសម្រាប់វគ្គ <strong>«{{ $selectedCourse->course_name }}»</strong> ក្នុងម៉ូឌុល <strong>«{{ $selectedModule->title }}»</strong>
                    @else
                        បង្កើតមេរៀន វីដេអូ កម្រងសំណួរ កិច្ចការ ឬឯកសារសិក្សាសម្រាប់និស្សិតប្រកបដោយវិជ្ជាជីវៈ។
                    @endif
                </p>
            </div>

            <div class="d-flex align-items-center gap-2 mt-3 mt-md-0">
                @if($selectedCourse)
                    <a href="{{ route('courses.modules.index', $selectedCourse) }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-layer-group mr-1"></i> មើលម៉ូឌុលទាំងអស់
                    </a>
                @endif
                <a href="{{ route('courses.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left mr-1"></i> វគ្គសិក្សា
                </a>
            </div>
        </div>

        @if($selectedCourse && $selectedModule)
            <div class="mt-3 pt-3 border-top d-flex flex-wrap align-items-center gap-2">
                <span class="context-pill-badge">
                    <i class="fas fa-book-reader text-primary"></i>
                    វគ្គសិក្សា: <strong>{{ $selectedCourse->course_name }}</strong>
                </span>
                <span class="context-pill-badge">
                    <i class="fas fa-bookmark text-success"></i>
                    ម៉ូឌុលទី {{ $selectedModule->module_number }}: <strong>{{ $selectedModule->title }}</strong>
                </span>
                @if($selectedCourse->category)
                    <span class="context-pill-badge">
                        <i class="fas fa-tag text-info"></i>
                        ប្រភេទ: <strong>{{ $selectedCourse->category->category_name }}</strong>
                    </span>
                @endif
            </div>
        @endif
    </div>

    <!-- Alert Notifications -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (isset($errors) && $errors->any())
        <div class="alert alert-danger shadow-sm alert-dismissible fade show" role="alert">
            <div class="font-weight-bold mb-1"><i class="fas fa-exclamation-triangle mr-2"></i>សូមពិនិត្យព័ត៌មានដែលមិនទាន់ត្រឹមត្រូវ៖</div>
            <ul class="mb-0 pl-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <form id="contentForm" action="{{ route('lessons.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        <input type="hidden" name="status" id="statusField" value="{{ old('status', 'draft') }}">

        <div class="builder-layout">

            <!-- Left Navigation Stepper Sidebar -->
            <aside class="builder-nav-sidebar">
                <div class="builder-nav-header">
                    <span>ជំហានរៀបចំ (Studio Steps)</span>
                </div>

                <nav role="tablist">
                    <button class="nav-step-item active" type="button" data-tab="basic">
                        <div class="nav-step-icon"><i class="fas fa-sliders-h"></i></div>
                        <div class="nav-step-info">
                            <span class="nav-step-title">១. ព័ត៌មានទូទៅ</span>
                            <span class="nav-step-sub">Basic Information</span>
                        </div>
                    </button>

                    <button class="nav-step-item" type="button" data-tab="content">
                        <div class="nav-step-icon"><i class="fas fa-file-alt"></i></div>
                        <div class="nav-step-info">
                            <span class="nav-step-title">២. មាតិកាមេរៀន</span>
                            <span class="nav-step-sub">Article & Summary</span>
                        </div>
                    </button>

                    <button class="nav-step-item type-step-btn" type="button" data-tab="type_specific">
                        <div class="nav-step-icon"><i class="fas fa-cubes"></i></div>
                        <div class="nav-step-info">
                            <span class="nav-step-title" id="typeStepTitle">៣. ការកំណត់មាតិកា</span>
                            <span class="nav-step-sub" id="typeStepSub">Type Specific Settings</span>
                        </div>
                        <span class="type-pill-indicator" id="typePillBadge">Video</span>
                    </button>

                    <button class="nav-step-item" type="button" data-tab="learning">
                        <div class="nav-step-icon"><i class="fas fa-tasks"></i></div>
                        <div class="nav-step-info">
                            <span class="nav-step-title">៤. លក្ខខណ្ឌសិក្សា</span>
                            <span class="nav-step-sub">Rules & Progress</span>
                        </div>
                    </button>

                    <button class="nav-step-item" type="button" data-tab="attachments">
                        <div class="nav-step-icon"><i class="fas fa-paperclip"></i></div>
                        <div class="nav-step-info">
                            <span class="nav-step-title">៥. ឯកសារភ្ជាប់</span>
                            <span class="nav-step-sub">Attachments & Files</span>
                        </div>
                    </button>

                    <button class="nav-step-item" type="button" data-tab="access_publishing">
                        <div class="nav-step-icon"><i class="fas fa-paper-plane"></i></div>
                        <div class="nav-step-info">
                            <span class="nav-step-title">៦. សិទ្ធិ & បោះពុម្ព</span>
                            <span class="nav-step-sub">Publish & Access</span>
                        </div>
                    </button>
                </nav>

                <div class="mt-4 pt-3 border-top px-2 text-center text-muted small">
                    <i class="fas fa-info-circle mr-1 text-primary"></i> ព័ត៌មាននឹងត្រូវរក្សាទុកដោយស្វ័យប្រវត្តិកាលណាអ្នកចុចបោះពុម្ព។
                </div>
            </aside>

            <!-- Right Workspace Sections -->
            <main class="builder-content-area">

                <!-- ==============================================
                     PANEL 1: BASIC INFORMATION
                     ============================================== -->
                <section class="section-panel active" data-panel="basic">
                    <div class="studio-card">
                        <div class="studio-card-header">
                            <div>
                                <h2><i class="fas fa-layer-group text-primary"></i> ជ្រើសរើសប្រភេទមាតិកា (Content Type)</h2>
                                <p>ជ្រើសរើសទម្រង់មាតិកាដែលអ្នកចង់បង្កើតដើម្បីកំណត់រចនាសម្ព័ន្ធឱ្យត្រូវនឹងតម្រូវការ។</p>
                            </div>
                        </div>
                        <div class="studio-card-body">
                            <!-- Interactive Visual Type Cards Grid -->
                            <div class="content-type-grid">
                                <div class="type-radio-card active" data-type="video">
                                    <input type="radio" name="type_selector" value="video" checked>
                                    <div class="type-card-icon video"><i class="fas fa-play-circle"></i></div>
                                    <div class="type-card-text">
                                        <strong>វីដេអូសិក្សា</strong>
                                        <span>Video (MP4 / YT)</span>
                                    </div>
                                    <div class="type-checked-badge"><i class="fas fa-check"></i></div>
                                </div>

                                <div class="type-radio-card" data-type="lesson">
                                    <input type="radio" name="type_selector" value="lesson">
                                    <div class="type-card-icon lesson"><i class="fas fa-book-open"></i></div>
                                    <div class="type-card-text">
                                        <strong>អត្ថបទមេរៀន</strong>
                                        <span>Text / Article</span>
                                    </div>
                                    <div class="type-checked-badge"><i class="fas fa-check"></i></div>
                                </div>

                                <div class="type-radio-card" data-type="file">
                                    <input type="radio" name="type_selector" value="file">
                                    <div class="type-card-icon file"><i class="fas fa-file-pdf"></i></div>
                                    <div class="type-card-text">
                                        <strong>ឯកសារជំនួយ</strong>
                                        <span>Document / PDF</span>
                                    </div>
                                    <div class="type-checked-badge"><i class="fas fa-check"></i></div>
                                </div>

                                <div class="type-radio-card" data-type="quiz">
                                    <input type="radio" name="type_selector" value="quiz">
                                    <div class="type-card-icon quiz"><i class="fas fa-question-circle"></i></div>
                                    <div class="type-card-text">
                                        <strong>កម្រងសំណួរ</strong>
                                        <span>Interactive Quiz</span>
                                    </div>
                                    <div class="type-checked-badge"><i class="fas fa-check"></i></div>
                                </div>

                                <div class="type-radio-card" data-type="assignment">
                                    <input type="radio" name="type_selector" value="assignment">
                                    <div class="type-card-icon assignment"><i class="fas fa-clipboard-check"></i></div>
                                    <div class="type-card-text">
                                        <strong>កិច្ចការស្វ័យសិក្សា</strong>
                                        <span>Assignment</span>
                                    </div>
                                    <div class="type-checked-badge"><i class="fas fa-check"></i></div>
                                </div>

                                <div class="type-radio-card" data-type="url">
                                    <input type="radio" name="type_selector" value="url">
                                    <div class="type-card-icon url"><i class="fas fa-link"></i></div>
                                    <div class="type-card-text">
                                        <strong>តំណភ្ជាប់ / Live</strong>
                                        <span>External / Meeting</span>
                                    </div>
                                    <div class="type-checked-badge"><i class="fas fa-check"></i></div>
                                </div>
                            </div>

                            <!-- Hidden select for form submission sync -->
                            <select name="content_type" id="contentType" class="d-none" required>
                                <option value="video" @selected(old('content_type', 'video') === 'video')>video</option>
                                <option value="lesson" @selected(old('content_type') === 'lesson')>lesson</option>
                                <option value="file" @selected(old('content_type') === 'file')>file</option>
                                <option value="quiz" @selected(old('content_type') === 'quiz')>quiz</option>
                                <option value="assignment" @selected(old('content_type') === 'assignment')>assignment</option>
                                <option value="url" @selected(old('content_type') === 'url')>url</option>
                            </select>

                            <hr class="my-4">

                            <!-- General Course, Module & Lesson Identity -->
                            <div class="row">
                                <div class="col-lg-6 form-group">
                                    <label>វគ្គសិក្សា (Course) <span class="text-danger">*</span></label>
                                    <select name="course_id" id="courseSelect" class="form-control select2bs4" required>
                                        <option value="">-- ជ្រើសរើសវគ្គសិក្សា --</option>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->course_id }}" @selected(old('course_id', request('course_id')) == $course->course_id)>
                                                {{ $course->course_name }} ({{ $course->course_code }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-6 form-group">
                                    <label>ជំពូក ឬ ម៉ូឌុល (Chapter / Module) <span class="text-danger">*</span></label>
                                    <select name="course_module_id" id="moduleSelect" class="form-control select2bs4" required>
                                        <option value="">-- ជ្រើសរើសម៉ូឌុល --</option>
                                        @foreach($modules as $module)
                                            <option value="{{ $module->course_module_id }}" data-course="{{ $module->course_id }}" @selected(old('course_module_id', request('course_module_id')) == $module->course_module_id)>
                                                ម៉ូឌុល {{ $module->module_number }}: {{ $module->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-8 form-group">
                                    <label>ចំណងជើងមាតិកា (Title) <span class="text-danger">*</span></label>
                                    <input type="text" name="title" id="titleInput" class="form-control form-control-lg font-weight-bold" placeholder="ឧ. ការអនុវត្តជាក់ស្តែងលើ Figma Auto Layout & Design System" minlength="3" maxlength="180" value="{{ old('title') }}" required>
                                </div>

                                <div class="col-lg-4 form-group">
                                    <label>លំដាប់បង្ហាញ (Display Order) <span class="text-danger">*</span></label>
                                    <input type="number" name="position" class="form-control form-control-lg" min="1" value="{{ old('position', 1) }}" required>
                                </div>

                                <div class="col-12 form-group">
                                    <label>ស្លាកតំណសម្គាល់ (URL Slug)</label>
                                    <input type="text" name="slug" id="slugInput" class="form-control" placeholder="auto-generated-slug" value="{{ old('slug') }}">
                                    <div class="slug-preview-box mt-2">
                                        <i class="fas fa-link text-primary"></i>
                                        <span class="text-muted">តំណភ្ជាប់មេរៀន:</span>
                                        <span class="slug-preview-link">https://lms.spi.edu.kh/lessons/<span id="slugDisplay">your-slug-here</span></span>
                                        <span class="slug-status-badge valid" id="slugStatus"><i class="fas fa-check-circle"></i> Unique</span>
                                    </div>
                                </div>

                                <div class="col-12 form-group mb-0">
                                    <label>សេចក្តីសង្ខេបខ្លី (Short Summary)</label>
                                    <textarea name="summary" class="form-control" rows="3" placeholder="ពិពណ៌នាខ្លីៗអំពីអ្វីដែលនិស្សិតនឹងទទួលបានពីមេរៀននេះ..." maxlength="1000">{{ old('summary') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- ==============================================
                     PANEL 2: LESSON CONTENT (SUMMERNOTE & THUMBNAIL)
                     ============================================== -->
                <section class="section-panel" data-panel="content">
                    <div class="studio-card">
                        <div class="studio-card-header">
                            <div>
                                <h2><i class="fas fa-align-left text-primary"></i> មាតិកាលម្អិតនៃមេរៀន (Lesson Material)</h2>
                                <p>សរសេរខ្លឹមសារមេរៀន អត្ថបទ បញ្ចូលរូបភាព តារាង ឬកូដគំរូជាមួយកម្មវិធីនិពន្ធកម្រិតខ្ពស់។</p>
                            </div>
                        </div>
                        <div class="studio-card-body">
                            <div class="form-group">
                                <label>ខ្លឹមសារអត្ថបទមេរៀន <span class="text-danger">*</span></label>
                                <textarea name="body" id="bodyEditor" class="rich-editor" required>{{ old('body', '<h3>គោលបំណងនៃមេរៀន (Lesson Objectives)</h3><p>បន្ទាប់ពីបញ្ចប់មេរៀននេះ និស្សិតនឹងអាច៖</p><ul><li>ស្វែងយល់ និងប្រើប្រាស់ឧបករណ៍ Figma យ៉ាងស្ទាត់ជំនាញ</li><li>អនុវត្តការរចនាប្រព័ន្ធ UI Design System</li></ul>') }}</textarea>
                            </div>

                            <div class="form-group mb-0 pt-2">
                                <label>រូបភាពតំណាងមាតិកា (Cover Thumbnail)</label>
                                <label class="modern-dropzone w-100 mb-0">
                                    <div class="dropzone-icon-circle">
                                        <i class="fas fa-image"></i>
                                    </div>
                                    <strong class="d-block text-dark font-weight-bold">អូសទម្លាក់រូបភាព ឬចុចដើម្បីជ្រើសរើស</strong>
                                    <span class="text-muted small">គាំទ្រប្រភេទ PNG, JPG, WEBP (ទំហំអតិបរមា 4 MB)</span>
                                    <input type="file" name="thumbnail" class="d-none" accept="image/*">
                                    <div class="mt-2 file-name-display text-primary font-weight-bold small"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- ==============================================
                     PANEL 3: TYPE-SPECIFIC CONFIGURATION
                     ============================================== -->
                <section class="section-panel" data-panel="type_specific">

                    <!-- TYPE 1: VIDEO SETTINGS -->
                    <div class="studio-card type-section" id="section-video">
                        <div class="studio-card-header">
                            <div>
                                <h2><i class="fas fa-video text-primary"></i> ការកំណត់វីដេអូ (Video Stream Settings)</h2>
                                <p>ជ្រើសរើសប្រភពវីដេអូ YouTube, Vimeo, ឯកសារផ្ទាល់ខ្លួន ឬតំណភ្ជាប់ខាងក្រៅ។</p>
                            </div>
                        </div>
                        <div class="studio-card-body">
                            <div class="row">
                                <div class="col-lg-4 form-group">
                                    <label>ប្រភពវីដេអូ (Video Source)</label>
                                    <select name="video_source" id="videoSource" class="form-control">
                                        <option value="youtube" selected>YouTube</option>
                                        <option value="vimeo">Vimeo</option>
                                        <option value="upload">Upload Video File</option>
                                        <option value="external">External Direct URL</option>
                                    </select>
                                </div>

                                <div class="col-lg-5 form-group video-url-field">
                                    <label>តំណភ្ជាប់វីដេអូ (Video URL)</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-link"></i></span>
                                        </div>
                                        <input type="url" name="video_url" class="form-control" placeholder="https://www.youtube.com/watch?v=...">
                                    </div>
                                </div>

                                <div class="col-lg-3 form-group">
                                    <label>រយៈពេលវីដេអូ (Duration - នាទី)</label>
                                    <div class="input-group">
                                        <input type="number" name="video_duration" class="form-control" min="0" placeholder="15" value="{{ old('video_duration', 15) }}">
                                        <div class="input-group-append"><span class="input-group-text">នាទី</span></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group video-upload-field d-none">
                                <label>ផ្ទុកឡើងឯកសារវីដេអូ (Video File)</label>
                                <label class="modern-dropzone w-100 mb-0">
                                    <div class="dropzone-icon-circle">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                    </div>
                                    <strong class="d-block text-dark font-weight-bold">អូសទម្លាក់វីដេអូ ឬចុចដើម្បីជ្រើសរើស</strong>
                                    <span class="text-muted small">គាំទ្រ MP4, MOV, WEBM (ទំហំរហូតដល់ 500 MB)</span>
                                    <input type="file" name="video_upload" class="d-none" accept="video/mp4,video/quicktime,video/x-msvideo,video/webm">
                                    <div class="mt-2 file-name-display text-primary font-weight-bold small"></div>
                                </label>
                            </div>

                            <div class="form-group mt-3">
                                <label>រូបភាពតំណាងវីដេអូ (Video Custom Thumbnail)</label>
                                <input type="file" name="video_thumbnail" class="form-control" accept="image/*">
                            </div>

                            <div class="form-group mb-0">
                                <label>អត្ថបទចម្លងនៃវីដេអូ (Video Transcript / Subtitles)</label>
                                <textarea name="video_transcript" class="form-control" rows="4" placeholder="បញ្ចូលអត្ថបទសន្ទនា ឬខ្លឹមសារសង្ខេបនៃវីដេអូ...">{{ old('video_transcript') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- TYPE 2: QUIZ BUILDER -->
                    <div class="studio-card type-section d-none" id="section-quiz">
                        <div class="studio-card-header">
                            <div>
                                <h2><i class="fas fa-question-circle text-purple"></i> បង្កើតកម្រងសំណួរ (Quiz & Assessment)</h2>
                                <p>កំណត់លក្ខខណ្ឌដាក់ពិន្ទុ កំណត់ពេលវេលា និងបង្កើតសំណួរអន្តរកម្ម។</p>
                            </div>
                            <button type="button" class="btn btn-primary btn-sm" id="addQuestion">
                                <i class="fas fa-plus mr-1"></i> បន្ថែមសំណួរ
                            </button>
                        </div>
                        <div class="studio-card-body">
                            <div class="row mb-3">
                                <div class="col-lg-6 form-group">
                                    <label>ចំណងជើងតេស្ត (Quiz Title)</label>
                                    <input name="quiz[title]" class="form-control" placeholder="ឧ. តេស្តវាយតម្លៃការយល់ដឹងលើ Figma Components">
                                </div>
                                <div class="col-lg-2 form-group">
                                    <label>ពិន្ទុជាប់ (%)</label>
                                    <input type="number" name="quiz[passing_score]" class="form-control" min="0" max="100" value="70">
                                </div>
                                <div class="col-lg-2 form-group">
                                    <label>ចំនួនលើកប្រឡង</label>
                                    <input type="number" name="quiz[attempts_allowed]" class="form-control" min="1" value="2">
                                </div>
                                <div class="col-lg-2 form-group">
                                    <label>ពេលវេលា (នាទី)</label>
                                    <input type="number" name="quiz[time_limit]" class="form-control" min="0" placeholder="30" value="30">
                                </div>
                                <div class="col-12 form-group">
                                    <label>ការណែនាំអំពីការធ្វើតេស្ត</label>
                                    <textarea name="quiz[description]" class="form-control" rows="2" placeholder="សូមឆ្លើយសំណួរទាំងអស់ឱ្យបានត្រឹមត្រូវដើម្បីទទួលបានពិន្ទុ..."></textarea>
                                </div>
                            </div>

                            <div class="toggle-grid mb-4">
                                <div class="toggle-card">
                                    <div>
                                        <span class="toggle-card-label">ច្របល់លំដាប់សំណួរ</span>
                                        <span class="toggle-card-desc">Randomize Question Order</span>
                                    </div>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="quiz_randomize_questions" name="quiz[randomize_questions]" value="1" checked>
                                        <label class="custom-control-label" for="quiz_randomize_questions"></label>
                                    </div>
                                </div>
                                <div class="toggle-card">
                                    <div>
                                        <span class="toggle-card-label">បង្ហាញលទ្ធផលភ្លាមៗ</span>
                                        <span class="toggle-card-desc">Show Immediate Results</span>
                                    </div>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="quiz_show_result" name="quiz[show_result]" value="1" checked>
                                        <label class="custom-control-label" for="quiz_show_result"></label>
                                    </div>
                                </div>
                                <div class="toggle-card">
                                    <div>
                                        <span class="toggle-card-label">បង្ហាញចម្លើយត្រឹមត្រូវ</span>
                                        <span class="toggle-card-desc">Show Correct Answers</span>
                                    </div>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="quiz_show_correct_answers" name="quiz[show_correct_answers]" value="1">
                                        <label class="custom-control-label" for="quiz_show_correct_answers"></label>
                                    </div>
                                </div>
                                <div class="toggle-card">
                                    <div>
                                        <span class="toggle-card-label">ទាមទារពិន្ទុជាប់</span>
                                        <span class="toggle-card-desc">Require Passing Score</span>
                                    </div>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="quiz_require_passing_score" name="quiz[require_passing_score]" value="1" checked>
                                        <label class="custom-control-label" for="quiz_require_passing_score"></label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h4 class="font-weight-bold text-dark mb-0" style="font-size: 15px;">
                                    <i class="fas fa-list-ol mr-1 text-primary"></i> បញ្ជីសំណួរ (Questions List)
                                </h4>
                                <span class="badge badge-light border" id="questionCount">1 សំណួរ</span>
                            </div>

                            <div id="questionList"></div>
                        </div>
                    </div>

                    <!-- TYPE 3: ASSIGNMENT BUILDER -->
                    <div class="studio-card type-section d-none" id="section-assignment">
                        <div class="studio-card-header">
                            <div>
                                <h2><i class="fas fa-tasks text-rose"></i> ការកំណត់កិច្ចការស្វ័យសិក្សា (Assignment)</h2>
                                <p>កំណត់វិធីប្រគល់កិច្ចការ ពិន្ទុអតិបរមា និងកាលបរិច្ឆេទផុតកំណត់។</p>
                            </div>
                        </div>
                        <div class="studio-card-body">
                            <div class="row">
                                <div class="col-lg-6 form-group">
                                    <label>ចំណងជើងកិច្ចការ (Assignment Title)</label>
                                    <input name="assignment[title]" class="form-control" placeholder="ឧ. រចនា Mobile Screen ចំនួន ៣ ដោយប្រើ Figma">
                                </div>
                                <div class="col-lg-3 form-group">
                                    <label>ទម្រង់ប្រគល់កិច្ចការ</label>
                                    <select name="assignment[submission_type]" class="form-control">
                                        <option value="file">ផ្ទុកឡើងឯកសារ (File Upload)</option>
                                        <option value="text">សរសេរអត្ថបទ (Text Entry)</option>
                                        <option value="file_text">ឯកសារ + អត្ថបទ (Both)</option>
                                    </select>
                                </div>
                                <div class="col-lg-3 form-group">
                                    <label>ពិន្ទុអតិបរមា (Max Score)</label>
                                    <input type="number" name="assignment[maximum_score]" class="form-control" min="0" value="100">
                                </div>
                                <div class="col-lg-4 form-group">
                                    <label>កាលបរិច្ឆេទផុតកំណត់ (Due Date)</label>
                                    <input type="date" name="assignment[due_date]" class="form-control">
                                </div>
                                <div class="col-12 form-group">
                                    <label>សេចក្តីណែនាំអំពីកិច្ចការ (Assignment Instructions)</label>
                                    <textarea name="assignment[instructions]" class="form-control" rows="4" placeholder="សូមពន្យល់លម្អិតអំពីលក្ខខណ្ឌ និងតម្រូវការដែលនិស្សិតត្រូវបំពេញ..."></textarea>
                                </div>
                            </div>
                            <div class="toggle-grid">
                                <div class="toggle-card">
                                    <div>
                                        <span class="toggle-card-label">អនុញ្ញាតឱ្យកែសម្រួលឡើងវិញ</span>
                                        <span class="toggle-card-desc">Allow Resubmission</span>
                                    </div>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="assignment_allow_resubmission" name="assignment[allow_resubmission]" value="1" checked>
                                        <label class="custom-control-label" for="assignment_allow_resubmission"></label>
                                    </div>
                                </div>
                                <div class="toggle-card">
                                    <div>
                                        <span class="toggle-card-label">កិច្ចការជាកំហិត</span>
                                        <span class="toggle-card-desc">Mandatory Assignment</span>
                                    </div>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="assignment_required" name="assignment[required]" value="1" checked>
                                        <label class="custom-control-label" for="assignment_required"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TYPE 4: DOCUMENT SETTINGS -->
                    <div class="studio-card type-section d-none" id="section-file">
                        <div class="studio-card-header">
                            <div>
                                <h2><i class="fas fa-file-pdf text-amber"></i> ការកំណត់ឯកសារជំនួយ (Document Settings)</h2>
                                <p>គាំទ្រឯកសារស្លាយ PDF, Word, Excel, PowerPoint ឬ ZIP។</p>
                            </div>
                        </div>
                        <div class="studio-card-body">
                            <div class="row">
                                <div class="col-lg-6 form-group">
                                    <label>ជ្រើសរើសឯកសារ (Document File)</label>
                                    <input type="file" name="document[document_file]" class="form-control" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip">
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label>ឈ្មោះបង្ហាញ (Display Name)</label>
                                    <input name="document[file_name]" class="form-control" placeholder="ឧ. Figma_CheatSheet_v2.pdf">
                                </div>
                                <div class="col-lg-4 form-group">
                                    <label>ប្រភេទឯកសារ</label>
                                    <input name="document[file_type]" class="form-control" placeholder="PDF, DOCX, PPTX">
                                </div>
                                <div class="col-lg-4 form-group">
                                    <label>ទំហំឯកសារ (Size)</label>
                                    <input name="document[file_size]" class="form-control" placeholder="Auto ឬបញ្ចូលផ្ទាល់">
                                </div>
                                <div class="col-lg-4 form-group">
                                    <label>អនុញ្ញាតឱ្យទាញយក (Download)</label>
                                    <select name="document[allow_download]" class="form-control">
                                        <option value="1">អនុញ្ញាត (Allowed)</option>
                                        <option value="0">មើលលើប្រព័ន្ធប៉ុណ្ណោះ (View Only)</option>
                                    </select>
                                </div>
                                <div class="col-12 form-group mb-0">
                                    <label>ការពិពណ៌នាអំពីឯកសារ</label>
                                    <textarea name="document[description]" class="form-control" rows="3" placeholder="ពិពណ៌នាអំពីខ្លឹមសារដែលមាននៅក្នុងឯកសារនេះ..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TYPE 5: URL / LIVE SESSION -->
                    <div class="studio-card type-section d-none" id="section-url">
                        <div class="studio-card-header">
                            <div>
                                <h2><i class="fas fa-link text-cyan"></i> តំណភ្ជាប់ខាងក្រៅ ឬ Live Session</h2>
                                <p>ភ្ជាប់ទៅកាន់ Zoom, Google Meet, Teams ឬគេហទំព័រឯកសារយោង។</p>
                            </div>
                        </div>
                        <div class="studio-card-body">
                            <div class="form-group">
                                <label>តំណភ្ជាប់ (External / Live URL)</label>
                                <input type="url" name="external_url" class="form-control" placeholder="https://meet.google.com/xyz-abcd-efg">
                            </div>
                        </div>
                    </div>
                </section>

                <!-- ==============================================
                     PANEL 4: LEARNING & PROGRESS RULES
                     ============================================== -->
                <section class="section-panel" data-panel="learning">
                    <div class="studio-card">
                        <div class="studio-card-header">
                            <div>
                                <h2><i class="fas fa-sliders-h text-primary"></i> លក្ខខណ្ឌបញ្ចប់ និងវឌ្ឍនភាព (Learning Rules)</h2>
                                <p>កំណត់របៀបវាស់ស្ទង់វឌ្ឍនភាពរបស់និស្សិត និងការដោះសោរមេរៀនបន្ទាប់។</p>
                            </div>
                        </div>
                        <div class="studio-card-body">
                            <div class="toggle-grid mb-4">
                                <div class="toggle-card">
                                    <div>
                                        <span class="toggle-card-label">មេរៀនជាកំហិត (Required)</span>
                                        <span class="toggle-card-desc">Student must complete this</span>
                                    </div>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="is_required" name="is_required" value="1" checked>
                                        <label class="custom-control-label" for="is_required"></label>
                                    </div>
                                </div>

                                <div class="toggle-card">
                                    <div>
                                        <span class="toggle-card-label">តាមដានវឌ្ឍនភាព (Track Progress)</span>
                                        <span class="toggle-card-desc">Calculate course percentage</span>
                                    </div>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="track_progress" name="track_progress" value="1" checked>
                                        <label class="custom-control-label" for="track_progress"></label>
                                    </div>
                                </div>

                                <div class="toggle-card">
                                    <div>
                                        <span class="toggle-card-label">បញ្ចប់ស្វ័យប្រវត្តិ (Auto Complete)</span>
                                        <span class="toggle-card-desc">Mark done upon conditions</span>
                                    </div>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="auto_complete" name="auto_complete" value="1">
                                        <label class="custom-control-label" for="auto_complete"></label>
                                    </div>
                                </div>

                                <div class="toggle-card">
                                    <div>
                                        <span class="toggle-card-label">ដោះសោរមេរៀនបន្ទាប់</span>
                                        <span class="toggle-card-desc">Unlock Next Lesson when done</span>
                                    </div>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="unlock_next" name="unlock_next" value="1" checked>
                                        <label class="custom-control-label" for="unlock_next"></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 form-group">
                                    <label>វិធីសាស្ត្រផ្ទៀងផ្ទាត់ការបញ្ចប់ (Completion Method)</label>
                                    <select name="completion_type" class="form-control">
                                        <option value="manual">និស្សិតចុចបញ្ជាក់ដោយដៃ (Manual Click)</option>
                                        <option value="video_watched">បានទស្សនាវីដេអូគ្រប់ចំនួន (Video Watched)</option>
                                        <option value="quiz_passed">បានប្រឡងតេស្តជាប់ (Quiz Passed)</option>
                                        <option value="assignment_submitted">បានប្រគល់កិច្ចការ (Assignment Submitted)</option>
                                        <option value="all_requirements">បំពេញគ្រប់លក្ខខណ្ឌទាំងអស់ (All Requirements)</option>
                                    </select>
                                </div>

                                <div class="col-lg-6 form-group video-only-rule">
                                    <label>ភាគរយវីដេអូអប្បបរមាដែលត្រូវមើល (%)</label>
                                    <div class="input-group">
                                        <input type="number" name="minimum_watch_percentage" class="form-control" min="0" max="100" value="{{ old('minimum_watch_percentage', 80) }}">
                                        <div class="input-group-append"><span class="input-group-text">%</span></div>
                                    </div>
                                </div>
                            </div>

                            <div class="toggle-grid video-only-rule mt-2">
                                <div class="toggle-card">
                                    <div>
                                        <span class="toggle-card-label">ទាមទារមើលចប់ទើបចាត់ទុកថាបានបញ្ចប់</span>
                                        <span class="toggle-card-desc">Require watching before completion</span>
                                    </div>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="require_watch_before_completion" name="require_watch_before_completion" value="1">
                                        <label class="custom-control-label" for="require_watch_before_completion"></label>
                                    </div>
                                </div>

                                <div class="toggle-card">
                                    <div>
                                        <span class="toggle-card-label">ហាមឃាត់ការចុចរំលងវីដេអូ</span>
                                        <span class="toggle-card-desc">Prevent Video Scrubbing / Skipping</span>
                                    </div>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="prevent_skipping" name="prevent_skipping" value="1">
                                        <label class="custom-control-label" for="prevent_skipping"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- ==============================================
                     PANEL 5: ATTACHMENTS
                     ============================================== -->
                <section class="section-panel" data-panel="attachments">
                    <div class="studio-card">
                        <div class="studio-card-header">
                            <div>
                                <h2><i class="fas fa-paperclip text-primary"></i> ឯកសារភ្ជាប់បន្ថែម (Attachments)</h2>
                                <p>ផ្តល់ឯកសារកូដគំរូ ឯកសារយោង ឬ Template សម្រាប់និស្សិតទាញយក។</p>
                            </div>
                            <button type="button" class="btn btn-primary btn-sm" id="addAttachment">
                                <i class="fas fa-plus mr-1"></i> បន្ថែមឯកសារ
                            </button>
                        </div>
                        <div class="studio-card-body">
                            <label class="modern-dropzone w-100 mb-4">
                                <div class="dropzone-icon-circle">
                                    <i class="fas fa-file-export"></i>
                                </div>
                                <strong class="d-block text-dark font-weight-bold">អូសទម្លាក់ឯកសារជាច្រើននៅទីនេះ</strong>
                                <span class="text-muted small">គាំទ្រគ្រប់ប្រភេទឯកសារ ZIP, PDF, FIG, CODE (ទំហំរហូតដល់ 100 MB ក្នុងមួយឯកសារ)</span>
                                <input type="file" id="attachmentInput" name="attachments[]" class="d-none" multiple>
                            </label>

                            <div class="border rounded" id="attachmentWrapper">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0" id="attachmentTable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>ឈ្មោះឯកសារ</th>
                                                <th>ប្រភេទ</th>
                                                <th>ទំហំ</th>
                                                <th class="text-right" style="width: 80px;">សកម្មភាព</th>
                                            </tr>
                                        </thead>
                                        <tbody id="attachmentList">
                                            <tr id="emptyAttachmentRow">
                                                <td colspan="4" class="text-center text-muted py-4">
                                                    <i class="fas fa-folder-open mr-1"></i> មិនទាន់មានឯកសារភ្ជាប់នៅឡើយទេ។
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- ==============================================
                     PANEL 6: ACCESS & PUBLISHING
                     ============================================== -->
                <section class="section-panel" data-panel="access_publishing">
                    <div class="studio-card mb-4">
                        <div class="studio-card-header">
                            <div>
                                <h2><i class="fas fa-shield-alt text-primary"></i> សិទ្ធិចូលរៀន & លក្ខខណ្ឌមុន (Access & Prerequisites)</h2>
                                <p>គ្រប់គ្រងការចូលមើល និងចាក់សោរមាតិកា។</p>
                            </div>
                        </div>
                        <div class="studio-card-body">
                            <div class="row">
                                <div class="col-lg-6 form-group">
                                    <label>ក្រុមអ្នកអាចចូលរៀនបាន (Access Group)</label>
                                    <select name="access[type]" class="form-control">
                                        <option value="enrolled">និស្សិតដែលបានចុះឈ្មោះក្នុងវគ្គ (Enrolled Only)</option>
                                        <option value="everyone">សាធារណៈ (Everyone / Public Preview)</option>
                                        <option value="specific_group">ក្រុមជាក់លាក់ (Specific Group)</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label>លក្ខខណ្ឌត្រូវរៀនមុន (Prerequisite)</label>
                                    <select name="access[prerequisite]" id="prerequisiteSelect" class="form-control">
                                        <option value="none">គ្មាន (None - Free Access)</option>
                                        <option value="previous_content">ត្រូវបញ្ចប់មេរៀនមុន (Previous Content)</option>
                                        <option value="quiz_passed">ត្រូវប្រឡងតេស្តមុនជាប់ (Pass Quiz First)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="toggle-card mt-2">
                                <div>
                                    <span class="toggle-card-label">អនុញ្ញាតឱ្យមើលសាកល្បងដោយឥតគិតថ្លៃ (Free Preview)</span>
                                    <span class="toggle-card-desc">Allow guest or unenrolled students to watch this lesson</span>
                                </div>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="allowPreview" name="access[allow_preview]" value="1">
                                    <label class="custom-control-label" for="allowPreview"></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="studio-card">
                        <div class="studio-card-header">
                            <div>
                                <h2><i class="fas fa-paper-plane text-success"></i> កាលវិភាគបោះពុម្ពផ្សាយ (Publishing Workflow)</h2>
                                <p>ជ្រើសរើសបោះពុម្ពផ្សាយភ្លាមៗ ឬកំណត់ពេលវេលាស្វ័យប្រវត្តិ។</p>
                            </div>
                        </div>
                        <div class="studio-card-body">
                            <div class="row">
                                <div class="col-lg-4 form-group">
                                    <label>ស្ថានភាពមាតិកា (Status)</label>
                                    <select id="statusSelect" class="form-control font-weight-bold">
                                        <option value="draft" selected>📝 សេចក្តីព្រាង (Draft)</option>
                                        <option value="published">🚀 បោះពុម្ពផ្សាយភ្លាមៗ (Published)</option>
                                        <option value="archived">📦 ប័ណ្ណសារ (Archived)</option>
                                    </select>
                                </div>
                                <div class="col-lg-4 form-group">
                                    <label>កាលបរិច្ឆេទបោះពុម្ព (Publish Date)</label>
                                    <input type="date" name="publish_date" class="form-control" value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-lg-4 form-group">
                                    <label>ពេលវេលា (Time)</label>
                                    <input type="time" name="publish_time" class="form-control" value="{{ date('H:i') }}">
                                </div>
                                <div class="col-12 form-group mb-0">
                                    <label>អ្នកបង្កើត ឬបោះពុម្ព (Publisher)</label>
                                    <input name="published_by" class="form-control" value="{{ Auth::user()->name ?? 'Admin' }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </main>
        </div>

        <!-- Sticky Floating Action Footer Bar -->
        <div class="studio-sticky-bar">
            <div class="d-flex align-items-center gap-2">
                <span class="badge badge-light border px-3 py-2 text-muted">
                    <i class="fas fa-circle text-warning mr-1" style="font-size: 8px;"></i>
                    ស្ថានភាព: <strong id="footerStatusText" class="text-dark">សេចក្តីព្រាង (Draft)</strong>
                </span>
                @if($selectedCourse)
                    <span class="d-none d-md-inline text-muted small ml-2">
                        <i class="fas fa-book text-primary mr-1"></i>{{ $selectedCourse->course_name }}
                    </span>
                @endif
            </div>

            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('courses.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times mr-1"></i> បោះបង់
                </a>
                <button type="submit" class="btn btn-draft-pill" data-submit-status="draft">
                    <i class="fas fa-save mr-1"></i> រក្សាទុកជាព្រាង (Save Draft)
                </button>
                <button type="submit" class="btn btn-publish-gradient" data-submit-status="published">
                    <i class="fas fa-paper-plane mr-1"></i> បោះពុម្ពផ្សាយមាតិកា (Publish)
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="{{ asset('backend/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script>
$(function () {
    const modules = @json($modules->map(fn($module) => ['id' => $module->course_module_id, 'course_id' => $module->course_id]));
    const existingSlugs = new Set(@json($existingSlugs));
    let slugEdited = Boolean($('#slugInput').val());
    let questionIndex = 0;
    let isDirty = false;

    // Initialize Summernote with clean modern settings
    $('.rich-editor').summernote({
        height: 320,
        placeholder: 'សរសេរខ្លឹមសារមេរៀននៅទីនេះ...',
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'hr']],
            ['view', ['codeview', 'fullscreen']],
            ['help', ['help']]
        ]
    });

    // Content Type definitions & mapping
    const typeMeta = {
        'video': { title: '៣. ការកំណត់វីដេអូ', sub: 'Video Stream Settings', pill: 'Video', section: '#section-video' },
        'lesson': { title: '៣. ការកំណត់អត្ថបទ', sub: 'Text Lesson Settings', pill: 'Text', section: '' },
        'file': { title: '៣. ការកំណត់ឯកសារ', sub: 'Document File Settings', pill: 'Document', section: '#section-file' },
        'quiz': { title: '៣. បង្កើតកម្រងសំណួរ', sub: 'Quiz Assessment Builder', pill: 'Quiz', section: '#section-quiz' },
        'assignment': { title: '៣. ការកំណត់កិច្ចការ', sub: 'Assignment Settings', pill: 'Assignment', section: '#section-assignment' },
        'url': { title: '៣. តំណភ្ជាប់ / Live', sub: 'External Meeting / URL', pill: 'Live URL', section: '#section-url' }
    };

    function slugify(value) {
        return value.toString().toLowerCase().trim()
            .replace(/[^a-z0-9\u1780-\u17ff\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .replace(/^-|-$/g, '');
    }

    function setActiveTab(name) {
        $('.nav-step-item').removeClass('active');
        $('.nav-step-item[data-tab="' + name + '"]').addClass('active');
        $('.section-panel').removeClass('active');
        $('.section-panel[data-panel="' + name + '"]').addClass('active');
        window.scrollTo({ top: 100, behavior: 'smooth' });
    }

    function applyContentType(type) {
        $('#contentType').val(type);
        $('.type-radio-card').removeClass('active');
        $('.type-radio-card[data-type="' + type + '"]').addClass('active');

        const meta = typeMeta[type] || typeMeta['video'];
        $('#typeStepTitle').text(meta.title);
        $('#typeStepSub').text(meta.sub);
        $('#typePillBadge').text(meta.pill);

        $('.type-section').addClass('d-none');
        if (meta.section) {
            $(meta.section).removeClass('d-none');
            $('.type-step-btn').show();
        } else {
            // If text lesson, type specific settings merged into content panel
            $('.type-step-btn').hide();
        }

        // Show/hide video-only rules
        $('.video-only-rule').toggle(type === 'video');
    }

    function updateSlugDisplay() {
        const val = $('#slugInput').val() || 'your-slug-here';
        $('#slugDisplay').text(val);
        const isDuplicate = $('#slugInput').val() && existingSlugs.has($('#slugInput').val());
        if (isDuplicate) {
            $('#slugStatus').removeClass('valid').addClass('duplicate').html('<i class="fas fa-times-circle"></i> Duplicate');
        } else {
            $('#slugStatus').removeClass('duplicate').addClass('valid').html('<i class="fas fa-check-circle"></i> Unique');
        }
    }

    function refreshVideoSource() {
        const source = $('#videoSource').val();
        $('.video-url-field').toggle(source !== 'upload');
        $('.video-upload-field').toggleClass('d-none', source !== 'upload');
    }

    function filterModules() {
        const courseId = $('#courseSelect').val();
        $('#moduleSelect option').each(function () {
            const optionCourse = $(this).data('course');
            if (!optionCourse) {
                $(this).prop('disabled', false);
            } else if (String(optionCourse) === String(courseId)) {
                $(this).prop('disabled', false);
            } else {
                $(this).prop('disabled', true);
            }
        });
        if ($('#moduleSelect option:selected').is(':disabled')) {
            $('#moduleSelect').val('').trigger('change');
        } else {
            $('#moduleSelect').trigger('change.select2');
        }
    }

    function addQuestion() {
        const index = questionIndex++;
        const cardHtml = `
            <div class="quiz-question-card" draggable="true">
                <div class="question-card-header">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-grip-vertical text-muted mr-2" style="cursor: grab;"></i>
                        <span class="badge badge-primary">សំណួរទី ${index + 1}</span>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger delete-question" title="លុបសំណួរ">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
                <div class="row">
                    <div class="col-md-8 form-group">
                        <label>ខ្លឹមសារសំណួរ <span class="text-danger">*</span></label>
                        <input name="quiz[questions][${index}][question]" class="form-control" placeholder="ឧ. តើ Auto Layout ក្នុង Figma ប្រើសម្រាប់គោលបំណងអ្វី?" required>
                    </div>
                    <div class="col-md-2 form-group">
                        <label>ប្រភេទសំណួរ</label>
                        <select name="quiz[questions][${index}][type]" class="form-control">
                            <option>Multiple Choice</option>
                            <option>Single Choice</option>
                            <option>True / False</option>
                            <option>Short Answer</option>
                        </select>
                    </div>
                    <div class="col-md-2 form-group">
                        <label>ពិន្ទុ (Points)</label>
                        <input type="number" name="quiz[questions][${index}][points]" class="form-control" min="1" value="1">
                    </div>
                    <div class="col-12 form-group">
                        <label>ជម្រើសចម្លើយ (ខណ្ឌគ្នាដោយសញ្ញា |)</label>
                        <input name="quiz[questions][${index}][answers]" class="form-control" placeholder="ជម្រើស A | ជម្រើស B | ជម្រើស C | ជម្រើស D">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>ចម្លើយត្រឹមត្រូវ (Correct Answer)</label>
                        <input name="quiz[questions][${index}][correct_answer]" class="form-control" placeholder="បញ្ចូលចម្លើយត្រឹមត្រូវ">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>ការពន្យល់បន្ថែម (Explanation)</label>
                        <input name="quiz[questions][${index}][explanation]" class="form-control" placeholder="ពន្យល់ហេតុផលនៅពេលនិស្សិតឆ្លើយខុស">
                    </div>
                </div>
            </div>`;
        $('#questionList').append(cardHtml);
        $('#questionCount').text($('#questionList .quiz-question-card').length + ' សំណួរ');
    }

    // Event Handlers
    $('.nav-step-item').on('click', function () {
        setActiveTab($(this).data('tab'));
    });

    $('.type-radio-card').on('click', function () {
        const type = $(this).data('type');
        applyContentType(type);
    });

    $('#titleInput').on('input', function () {
        if (!slugEdited) {
            $('#slugInput').val(slugify(this.value));
            updateSlugDisplay();
        }
    });

    $('#slugInput').on('input', function () {
        slugEdited = true;
        updateSlugDisplay();
    });

    $('#videoSource').on('change', refreshVideoSource);
    $('#courseSelect').on('change', filterModules);

    $('#statusSelect').on('change', function () {
        const val = $(this).val();
        $('#statusField').val(val);
        $('#footerStatusText').text(val === 'published' ? 'បោះពុម្ពផ្សាយ (Published)' : (val === 'archived' ? 'ប័ណ្ណសារ (Archived)' : 'សេចក្តីព្រាង (Draft)'));
    });

    $('#addQuestion').on('click', addQuestion);
    $(document).on('click', '.delete-question', function () {
        if (confirm('តើអ្នកពិតជាចង់លុបសំណួរនេះមែនទេ?')) {
            $(this).closest('.quiz-question-card').remove();
            $('#questionCount').text($('#questionList .quiz-question-card').length + ' សំណួរ');
        }
    });

    $('#addAttachment').on('click', function () {
        $('#attachmentInput').trigger('click');
    });

    $('#attachmentInput').on('change', function () {
        if (this.files && this.files.length) {
            $('#emptyAttachmentRow').remove();
            Array.from(this.files).forEach((file) => {
                const sizeKb = Math.round(file.size / 1024);
                const sizeStr = sizeKb > 1024 ? (sizeKb / 1024).toFixed(1) + ' MB' : sizeKb + ' KB';
                const row = `
                    <tr>
                        <td><strong>${file.name}</strong></td>
                        <td><span class="badge badge-light border">${file.type || 'ឯកសារ'}</span></td>
                        <td>${sizeStr}</td>
                        <td class="text-right">
                            <button type="button" class="btn btn-sm btn-outline-danger remove-attachment-row"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>`;
                $('#attachmentList').append(row);
            });
        }
    });

    $(document).on('click', '.remove-attachment-row', function () {
        $(this).closest('tr').remove();
        if ($('#attachmentList tr').length === 0) {
            $('#attachmentList').html('<tr id="emptyAttachmentRow"><td colspan="4" class="text-center text-muted py-4"><i class="fas fa-folder-open mr-1"></i> មិនទាន់មានឯកសារភ្ជាប់នៅឡើយទេ។</td></tr>');
        }
    });

    // Dropzone Visual Feedback
    $('input[type=file]').on('change', function () {
        if (this.files && this.files[0]) {
            const fileName = this.files[0].name;
            $(this).closest('.modern-dropzone').find('.file-name-display').html('<i class="fas fa-check-circle text-success mr-1"></i> ' + fileName);
        }
    });

    // Form Submission Actions
    $('#contentForm button[type=submit]').on('click', function () {
        const targetStatus = $(this).data('submit-status');
        $('#statusField').val(targetStatus);
        $('#statusSelect').val(targetStatus);
    });

    $('#contentForm').on('submit', function () {
        $(this).find('button[type=submit]').prop('disabled', true);
        $(document.activeElement).html('<i class="fas fa-spinner fa-spin mr-1"></i> កំពុងរក្សាទុក...');
    });

    // Initial setups
    applyContentType($('#contentType').val() || 'video');
    refreshVideoSource();
    updateSlugDisplay();
    filterModules();
    addQuestion(); // Initial question for convenience
});
</script>
@endpush
