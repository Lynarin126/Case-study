@extends('layouts.master')

@section('title', 'ប្រវត្តិរូបអ្នកប្រើប្រាស់ | LMS')

@section('content')
@php
    /*
     | Presentation-only values built from the existing $user model data.
     | No controller / model / route logic is changed by this view.
     */
    $khmerName   = $user->khmer_name ?: '';
    $latinName   = $user->latin_name ?: '';
    $displayName = $khmerName ?: ($latinName ?: ($user->name ?? ''));

    $initialsSource = trim($latinName !== '' ? $latinName : ($khmerName !== '' ? $khmerName : ($user->email ?? '')));
    $initials = '';
    if ($initialsSource !== '') {
        $initials = \Illuminate\Support\Str::upper(
            collect(preg_split('/[\s._-]+/u', $initialsSource))
                ->filter()
                ->map(fn ($part) => mb_substr($part, 0, 1))
                ->take(2)
                ->implode('')
        );
    }

    $roleStyles = [
        'super-admin'    => ['badge' => 'badge-danger',    'icon' => 'fa-user-shield'],
        'admin'          => ['badge' => 'badge-primary',   'icon' => 'fa-user-shield'],
        'instructor'     => ['badge' => 'badge-info',      'icon' => 'fa-chalkboard-teacher'],
        'teacher'        => ['badge' => 'badge-info',      'icon' => 'fa-chalkboard-teacher'],
        'course-manager' => ['badge' => 'badge-warning',   'icon' => 'fa-layer-group'],
        'student'        => ['badge' => 'badge-success',   'icon' => 'fa-user-graduate'],
        'reviewer'       => ['badge' => 'badge-secondary', 'icon' => 'fa-clipboard-check'],
        'support'        => ['badge' => 'badge-dark',      'icon' => 'fa-headset'],
    ];

    $resolveRoleStyle = function ($slug) use ($roleStyles) {
        $slug = (string) $slug;
        foreach ($roleStyles as $key => $style) {
            if ($slug !== '' && str_contains($slug, $key)) {
                return $style;
            }
        }

        return ['badge' => 'badge-light border text-dark', 'icon' => 'fa-user-tag'];
    };

    $userRoles  = $user->roles;
    $isVerified = ! is_null($user->email_verified_at);
    $rolesText  = $userRoles->pluck('name')->implode(', ');

    /*
     | Personal information boxes.
     | Only fields that really exist on the users table are listed. When the
     | structured Khmer / Latin name columns hold no value yet (they are
     | nullable), the existing display name is shown instead of an empty row.
     */
    $personalFields = [];

    if ($khmerName !== '') {
        $personalFields[] = [
            'icon'  => 'fas fa-signature',
            'label' => 'នាមខ្លួនខ្មែរ (Khmer Name)',
            'value' => $khmerName,
        ];
    }

    if ($latinName !== '') {
        $personalFields[] = [
            'icon'  => 'fas fa-font',
            'label' => 'ឈ្មោះឡាតាំង (Latin Name)',
            'value' => $latinName,
        ];
    }

    if ($khmerName === '' && $latinName === '') {
        $personalFields[] = [
            'icon'  => 'fas fa-user',
            'label' => 'ឈ្មោះបង្ហាញ (Display Name)',
            'value' => ($user->name ?? ''),
        ];
    }

    $personalFields[] = [
        'icon'     => 'far fa-envelope',
        'label'    => 'អ៊ីមែល (Email)',
        'value'    => $user->email,
        'verified' => $isVerified,
    ];

    $personalFields[] = [
        'icon'  => 'fas fa-user-tag',
        'label' => 'តួនាទី (Role)',
        'value' => $rolesText,
        'empty' => 'មិនទាន់កំណត់តួនាទី',
    ];

    $lastFieldFullWidth = count($personalFields) % 2 === 1;
@endphp

<section class="content-header px-0">
    <div class="container-fluid px-0">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-7">
                <h1 class="mb-1">ប្រវត្តិរូបរបស់ខ្ញុំ (My Profile)</h1>
                <p class="text-muted mb-0">ព័ត៌មានផ្ទាល់ខ្លួន តួនាទី និងការកំណត់គណនីរបស់អ្នក។</p>
            </div>
            <div class="col-sm-5">
                <ol class="breadcrumb float-sm-right mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">ផ្ទាំងគ្រប់គ្រង</a></li>
                    <li class="breadcrumb-item active">ប្រវត្តិរូប</li>
                </ol>
            </div>
        </div>
    </div>
</section>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h2 class="h6 font-weight-bold mb-2">
            <i class="fas fa-exclamation-triangle mr-2"></i>សូមពិនិត្យព័ត៌មានខាងក្រោមម្តងទៀត
        </h2>
        <ul class="mb-0 pl-4">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="row">
    <div class="col-xl-4 col-lg-5">
        {{-- ============ PROFILE HEADER ============ --}}
        <div class="card profile-card mb-4">
            <div class="profile-hero">
                <div class="profile-avatar">
                    @if($initials !== '')
                        <span class="profile-avatar-initials" aria-hidden="true">{{ $initials }}</span>
                    @else
                        <img src="{{ asset('backend/dist/img/avatar.png') }}" alt="រូបភាពប្រវត្តិរូប">
                    @endif
                </div>
                <h2 class="profile-name">{{ $displayName !== '' ? $displayName : '—' }}</h2>
                @if($latinName !== '' && $latinName !== $khmerName)
                    <p class="profile-subname mb-0">{{ $latinName }}</p>
                @endif
            </div>

            <div class="card-body text-center">
                <p class="profile-email mb-3">
                    <i class="far fa-envelope mr-1"></i>
                    <span>{{ $user->email }}</span>
                    @if($isVerified)
                        <i class="fas fa-check-circle text-success ml-1" title="បានផ្ទៀងផ្ទាត់អ៊ីមែល"></i>
                    @endif
                </p>

                <div class="profile-badge-list mb-3">
                    @forelse($userRoles as $role)
                        @php $roleStyle = $resolveRoleStyle($role->slug ?? $role->name); @endphp
                        <span class="badge {{ $roleStyle['badge'] }} profile-role-badge">
                            <i class="fas {{ $roleStyle['icon'] }} mr-1"></i>{{ $role->name }}
                        </span>
                    @empty
                        <span class="badge badge-light border text-muted profile-role-badge">
                            <i class="fas fa-user-tag mr-1"></i>មិនទាន់កំណត់តួនាទី
                        </span>
                    @endforelse
                </div>

                <div class="profile-badge-list mb-3">
                    @if($isVerified)
                        <span class="badge badge-success-soft profile-role-badge">
                            <i class="fas fa-shield-alt mr-1"></i>គណនីសកម្ម (Verified)
                        </span>
                    @else
                        <span class="badge badge-warning-soft profile-role-badge">
                            <i class="fas fa-exclamation-circle mr-1"></i>មិនបានផ្ទៀងផ្ទាត់ (Unverified)
                        </span>
                    @endif
                </div>

                <a href="#edit-profile" class="btn btn-primary btn-block">
                    <i class="fas fa-user-edit mr-1"></i>កែប្រែប្រវត្តិរូប
                </a>

                <p class="profile-note mb-0 mt-3">
                    <i class="fas fa-info-circle mr-1"></i>រូបភាពបង្ហាញត្រូវបានបង្កើតដោយស្វ័យប្រវត្តិពីឈ្មោះរបស់អ្នក។
                </p>
            </div>
        </div>

        {{-- ============ ACCOUNT INFORMATION ============ --}}
        <div class="card profile-card mb-4">
            <div class="card-header profile-card-header">
                <h3 class="card-title">
                    <i class="fas fa-shield-alt mr-2 text-primary"></i>ព័ត៌មានគណនី (Account Information)
                </h3>
            </div>
            <div class="card-body py-2">
                <div class="account-row">
                    <span class="account-label">លេខសម្គាល់ (User ID)</span>
                    <span class="account-value">#{{ $user->id }}</span>
                </div>
                <div class="account-row">
                    <span class="account-label">តួនាទី (Role)</span>
                    <span class="account-value">
                        @if($rolesText !== '')
                            {{ $rolesText }}
                        @else
                            <span class="text-muted font-weight-normal">មិនមាន</span>
                        @endif
                    </span>
                </div>
                <div class="account-row">
                    <span class="account-label">ស្ថានភាពគណនី (Status)</span>
                    <span class="account-value">
                        @if($isVerified)
                            <span class="text-success"><i class="fas fa-check-circle mr-1"></i>បានផ្ទៀងផ្ទាត់</span>
                        @else
                            <span class="text-warning"><i class="fas fa-exclamation-circle mr-1"></i>មិនបានផ្ទៀងផ្ទាត់</span>
                        @endif
                    </span>
                </div>
                <div class="account-row">
                    <span class="account-label">ថ្ងៃបង្កើតគណនី (Created)</span>
                    <span class="account-value">{{ $user->created_at ? $user->created_at->format('d/m/Y') : '—' }}</span>
                </div>
                <div class="account-row">
                    <span class="account-label">ធ្វើបច្ចុប្បន្នភាពចុងក្រោយ (Updated)</span>
                    <span class="account-value">{{ $user->updated_at ? $user->updated_at->format('d/m/Y') : '—' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= PERSONAL INFORMATION + EDIT FORM ================= --}}
    <div class="col-xl-8 col-lg-7">
        {{-- ============ PERSONAL INFORMATION ============ --}}
        <div class="card profile-card mb-4">
            <div class="card-header profile-card-header">
                <h3 class="card-title">
                    <i class="fas fa-id-card mr-2 text-primary"></i>ព័ត៌មានផ្ទាល់ខ្លួន (Personal Information)
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($personalFields as $index => $field)
                        @php
                            $isLastField = $index === count($personalFields) - 1;
                            $columnClass = ($isLastField && $lastFieldFullWidth) ? 'col-12' : 'col-md-6';
                        @endphp
                        <div class="{{ $columnClass }} {{ $isLastField ? 'mb-md-0' : 'mb-3' }}">
                            <div class="profile-info-box h-100">
                                <div class="profile-info-icon"><i class="{{ $field['icon'] }}"></i></div>
                                <div class="profile-info-text">
                                    <div class="profile-info-label">{{ $field['label'] }}</div>
                                    <div class="profile-info-value">
                                        @if(($field['value'] ?? '') !== '')
                                            {{ $field['value'] }}
                                        @else
                                            <span class="text-muted font-weight-normal">{{ $field['empty'] ?? '—' }}</span>
                                        @endif
                                        @if(! empty($field['verified']))
                                            <i class="fas fa-check-circle text-success ml-1" title="បានផ្ទៀងផ្ទាត់អ៊ីមែល"></i>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ============ EDIT PROFILE FORM ============ --}}
        <div class="card profile-card mb-4" id="edit-profile">
            <div class="card-header profile-card-header">
                <h3 class="card-title">
                    <i class="fas fa-user-edit mr-2 text-primary"></i>កែប្រែព័ត៌មាន (Edit Profile)
                </h3>
            </div>

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <h4 class="profile-section-title">
                        <i class="fas fa-user mr-2 text-primary"></i>ព័ត៌មានផ្ទាល់ខ្លួន (Personal Details)
                    </h4>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="first_name">នាមខ្លួនខ្មែរ (First Name) <span class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control @error('first_name') is-invalid @enderror"
                                id="first_name"
                                name="first_name"
                                value="{{ old('first_name', $user->first_name) }}"
                                placeholder="ឧ. សុវណ្ណ"
                                maxlength="100"
                                required>
                            @error('first_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="last_name">នាមត្រកូលខ្មែរ (Last Name)</label>
                            <input type="text"
                                class="form-control @error('last_name') is-invalid @enderror"
                                id="last_name"
                                name="last_name"
                                value="{{ old('last_name', $user->last_name) }}"
                                placeholder="ឧ. សុខ"
                                maxlength="100">
                            @error('last_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="first_name_latin">First Name (Latin) <span class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control @error('first_name_latin') is-invalid @enderror"
                                id="first_name_latin"
                                name="first_name_latin"
                                value="{{ old('first_name_latin', $user->first_name_latin) }}"
                                placeholder="e.g. Sovann"
                                maxlength="100"
                                required>
                            @error('first_name_latin')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="last_name_latin">Last Name (Latin)</label>
                            <input type="text"
                                class="form-control @error('last_name_latin') is-invalid @enderror"
                                id="last_name_latin"
                                name="last_name_latin"
                                value="{{ old('last_name_latin', $user->last_name_latin) }}"
                                placeholder="e.g. Sok"
                                maxlength="100">
                            @error('last_name_latin')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-12 form-group mb-md-0">
                            <label for="email">អ៊ីមែល (Email) <span class="text-danger">*</span></label>
                            <input type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                id="email"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                                placeholder="name@example.com"
                                autocomplete="email"
                                maxlength="255"
                                required>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">
                                @if($isVerified)
                                    <i class="fas fa-check-circle text-success mr-1"></i>អ៊ីមែលនេះបានផ្ទៀងផ្ទាត់រួចហើយ។
                                @else
                                    <i class="fas fa-exclamation-circle text-warning mr-1"></i>អ៊ីមែលនេះមិនទាន់បានផ្ទៀងផ្ទាត់ទេ។
                                @endif
                            </small>
                        </div>
                    </div>

                    <hr class="profile-divider">

                    <h4 class="profile-section-title">
                        <i class="fas fa-lock mr-2 text-primary"></i>ផ្លាស់ប្តូរលេខសម្ងាត់ (Change Password)
                    </h4>
                    <p class="profile-note mb-4">
                        <i class="fas fa-info-circle mr-1"></i>ទុកប្រអប់លេខសម្ងាត់ឲ្យនៅទទេ ប្រសិនបើអ្នកមិនចង់ផ្លាស់ប្តូរវា។
                    </p>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="password">លេខសម្ងាត់ថ្មី (New Password)</label>
                            <div class="input-group">
                                <input type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    id="password"
                                    name="password"
                                    autocomplete="new-password"
                                    minlength="8">
                                <div class="input-group-append">
                                    <button type="button"
                                        class="btn btn-light border js-toggle-password"
                                        data-target="#password"
                                        aria-pressed="false"
                                        title="បង្ហាញ/លាក់លេខសម្ងាត់">
                                        <i class="fas fa-eye" aria-hidden="true"></i>
                                        <span class="sr-only">បង្ហាញ/លាក់លេខសម្ងាត់</span>
                                    </button>
                                </div>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">យ៉ាងតិច ៨ តួអក្សរ។</small>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="password_confirmation">បញ្ជាក់លេខសម្ងាត់ថ្មី (Confirm Password)</label>
                            <div class="input-group">
                                <input type="password"
                                    class="form-control"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    autocomplete="new-password"
                                    minlength="8">
                                <div class="input-group-append">
                                    <button type="button"
                                        class="btn btn-light border js-toggle-password"
                                        data-target="#password_confirmation"
                                        aria-pressed="false"
                                        title="បង្ហាញ/លាក់លេខសម្ងាត់">
                                        <i class="fas fa-eye" aria-hidden="true"></i>
                                        <span class="sr-only">បង្ហាញ/លាក់លេខសម្ងាត់</span>
                                    </button>
                                </div>
                            </div>
                            <small class="form-text text-muted">ត្រូវដូចគ្នានឹងលេខសម្ងាត់ថ្មីខាងលើ។</small>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white profile-card-footer">
                    <div class="d-flex flex-column flex-sm-row justify-content-sm-end align-items-stretch align-items-sm-center">
                        <button type="reset" class="btn btn-light border mb-2 mb-sm-0 mr-sm-2">
                            <i class="fas fa-undo mr-1"></i>បោះបង់ការកែប្រែ
                        </button>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save mr-1"></i>រក្សាទុកការផ្លាស់ប្តូរ
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* ---------- Profile page (presentation only) ---------- */
    .profile-card {
        background: #fff;
        border: 1px solid #eef1f6;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(16, 24, 40, .06);
        overflow: hidden;
    }

    .profile-card-header {
        background: #fff;
        border-bottom: 1px solid #eef1f6;
        padding: 14px 18px;
    }

    .profile-card-header .card-title {
        font-size: 1rem;
        font-weight: 600;
        color: #22303f;
    }

    .profile-card-footer {
        border-top: 1px solid #eef1f6;
        padding: 14px 18px;
    }

    .profile-hero {
        background: linear-gradient(135deg, #f4f8fd 0%, #e9f1fb 100%);
        border-bottom: 1px solid #eef1f6;
        padding: 28px 20px 22px;
        text-align: center;
    }

    .profile-avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 118px;
        height: 118px;
        margin: 0 auto 14px;
        overflow: hidden;
        background: #fff;
        border: 4px solid #fff;
        border-radius: 50%;
        box-shadow: 0 8px 20px rgba(16, 24, 40, .12);
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-avatar-initials {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        background: #e8f0fe;
        color: #1a73e8;
        font-size: 40px;
        font-weight: 600;
        letter-spacing: 1px;
    }

    .profile-name {
        margin-bottom: 4px;
        color: #1f2b3a;
        font-size: 1.2rem;
        font-weight: 600;
        word-break: break-word;
    }

    .profile-subname {
        color: #6b7688;
        font-size: .95rem;
        word-break: break-word;
    }

    .profile-email {
        margin-bottom: 0;
        color: #5b6577;
        font-size: .93rem;
        word-break: break-word;
    }

    .profile-role-badge {
        margin: 0 2px 6px;
        padding: 7px 11px;
        border-radius: 999px;
        font-size: .8rem;
        font-weight: 600;
    }

    .profile-note {
        color: #8a94a6;
        font-size: .82rem;
        line-height: 1.6;
    }

    .badge-success-soft {
        background: #e7f6ed;
        color: #1e7e45;
    }

    .badge-warning-soft {
        background: #fdf3e3;
        color: #a26a09;
    }

    .account-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 10px;
        padding: 11px 0;
        border-bottom: 1px dashed #edf1f7;
    }

    .account-row:last-child {
        border-bottom: 0;
    }

    .account-label {
        flex: 0 0 auto;
        color: #7b8698;
        font-size: .85rem;
    }

    .account-value {
        max-width: 62%;
        color: #2b3646;
        font-size: .9rem;
        font-weight: 600;
        text-align: right;
        word-break: break-word;
    }

    .profile-info-box {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        height: 100%;
        padding: 14px 16px;
        background: #fbfcfe;
        border: 1px solid #eef1f6;
        border-radius: 10px;
    }

    .profile-info-icon {
        display: flex;
        flex: 0 0 40px;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: #e8f0fe;
        color: #1a73e8;
        border-radius: 10px;
        font-size: 15px;
    }

    .profile-info-text {
        min-width: 0;
    }

    .profile-info-label {
        margin-bottom: 2px;
        color: #8a94a6;
        font-size: .82rem;
    }

    .profile-info-value {
        color: #2b3646;
        font-size: .95rem;
        font-weight: 600;
        word-break: break-word;
    }

    .profile-section-title {
        margin-bottom: 16px;
        color: #22303f;
        font-size: .98rem;
        font-weight: 600;
    }

    .profile-divider {
        margin: 8px 0 24px;
        border-top: 1px solid #eef1f6;
    }

    /* Roomier, clearly readable form fields inside the edit card */
    #edit-profile {
        /* keeps the card title visible under the fixed AdminLTE top bar */
        scroll-margin-top: 80px;
    }

    #edit-profile .form-group {
        margin-bottom: 1.25rem;
    }

    #edit-profile label {
        margin-bottom: 6px;
        color: #334155;
        font-size: .9rem;
        font-weight: 600;
    }

    #edit-profile .form-control {
        height: auto;
        min-height: 46px;
        padding: .55rem .8rem;
        border-radius: 8px;
        font-size: .95rem;
    }

    #edit-profile .form-control.is-invalid {
        border-color: #dc3545;
    }

    #edit-profile .input-group .btn {
        min-height: 46px;
        border-radius: 0 8px 8px 0;
        color: #6b7688;
    }

    #edit-profile .input-group .form-control {
        border-radius: 8px 0 0 8px;
    }

    #edit-profile .invalid-feedback {
        font-size: .85rem;
        font-weight: 600;
    }

    #edit-profile .form-text {
        font-size: .8rem;
        line-height: 1.6;
    }

    @media (max-width: 575.98px) {
        .profile-hero {
            padding: 22px 16px 18px;
        }

        .profile-avatar {
            width: 92px;
            height: 92px;
        }

        .profile-avatar-initials {
            font-size: 32px;
        }

        .profile-name {
            font-size: 1.08rem;
        }

        .profile-card-header,
        .profile-card-footer {
            padding: 12px 14px;
        }

        .account-value {
            max-width: 58%;
            font-size: .85rem;
        }

        #edit-profile .card-body {
            padding: 16px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.js-toggle-password').forEach(function (button) {
            button.addEventListener('click', function () {
                var input = document.querySelector(button.getAttribute('data-target'));

                if (!input) {
                    return;
                }

                var reveal = input.getAttribute('type') === 'password';
                input.setAttribute('type', reveal ? 'text' : 'password');
                button.setAttribute('aria-pressed', reveal ? 'true' : 'false');

                var icon = button.querySelector('i');

                if (icon) {
                    icon.classList.toggle('fa-eye', !reveal);
                    icon.classList.toggle('fa-eye-slash', reveal);
                }
            });
        });
    });
</script>
@endpush

