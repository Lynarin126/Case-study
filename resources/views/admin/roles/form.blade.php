@extends('layouts.master')

@section('title', ($role->exists ? 'កែប្រែតួនាទី' : 'បង្កើតតួនាទីថ្មី') . ' | LMS')

@section('content')
<section class="content-header px-0">
    <div class="container-fluid px-0">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-7">
                <h1 class="mb-1">{{ $role->exists ? 'កែប្រែតួនាទី' : 'បង្កើតតួនាទីថ្មី' }}</h1>
                <p class="text-muted mb-0">កំណត់ព័ត៌មាន និងចាត់ចែងសិទ្ធិអនុញ្ញាតតាមក្រុមសម្រាប់តួនាទីនេះ។</p>
            </div>
            <div class="col-sm-5 text-sm-right mt-2 mt-sm-0">
                <ol class="breadcrumb float-sm-right mb-2">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">ផ្ទាំងគ្រប់គ្រង</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">តួនាទី</a></li>
                    <li class="breadcrumb-item active">{{ $role->exists ? 'កែប្រែ' : 'បង្កើតថ្មី' }}</li>
                </ol>
                <div class="clearfix"></div>
                <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> ត្រឡប់ក្រោយ
                </a>
            </div>
        </div>
    </div>
</section>

@if (isset($errors) && $errors->any())
    <div class="alert alert-danger alert-dismissible fade show">
        <ul class="mb-0 pl-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
@endif

<form method="POST" action="{{ $role->exists ? route('admin.roles.update', $role) : route('admin.roles.store') }}">
    @csrf
    @if($role->exists)
        @method('PUT')
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h3 class="card-title mb-0 font-weight-bold">
                <i class="fas fa-info-circle mr-2 text-primary"></i>ព័ត៌មានលម្អិតអំពីតួនាទី
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 form-group">
                    <label class="font-weight-bold">ឈ្មោះតួនាទី <span class="text-danger">*</span></label>
                    <input name="name" id="roleName" class="form-control" placeholder="ឧ. Content Editor" value="{{ old('name', $role->name) }}" required>
                </div>
                <div class="col-md-4 form-group">
                    <label class="font-weight-bold">ស្លាកសម្គាល់ (Slug)</label>
                    <input name="slug" id="roleSlug" class="form-control" placeholder="ឧ. content-editor" value="{{ old('slug', $role->slug) }}">
                    <small class="text-muted">ទុកនៅទំនេរដើម្បីបង្កើតដោយស្វ័យប្រវត្តិតាមឈ្មោះតួនាទី</small>
                </div>
                <div class="col-md-4 form-group">
                    <label class="font-weight-bold">ប្រភេទតួនាទី</label>
                    <select name="is_system" class="form-control">
                        <option value="0" @selected(! old('is_system', $role->is_system))>ទូទៅ (Custom)</option>
                        <option value="1" @selected(old('is_system', $role->is_system))>ប្រព័ន្ធ (System)</option>
                    </select>
                </div>
                <div class="col-12 form-group mb-0">
                    <label class="font-weight-bold">ការពិពណ៌នា</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="ពិពណ៌នាអំពីមុខងារ ឬការទទួលខុសត្រូវរបស់តួនាទីនេះ...">{{ old('description', $role->description) }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex align-items-center">
            <h3 class="card-title mb-0 font-weight-bold">
                <i class="fas fa-key mr-2 text-primary"></i>ក្រុមសិទ្ធិអនុញ្ញាត (Permissions)
            </h3>
            <div class="ml-auto">
                <button type="button" class="btn btn-sm btn-outline-primary mr-1" id="selectAll">
                    <i class="fas fa-check-square mr-1"></i>ជ្រើសរើសទាំងអស់
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary" id="clearAll">
                    <i class="fas fa-square mr-1"></i>ដកការជ្រើសរើសទាំងអស់
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($permissionGroups as $module => $permissions)
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="border rounded h-100 shadow-none">
                            <div class="bg-light border-bottom px-3 py-2">
                                <label class="mb-0 font-weight-bold cursor-pointer" style="cursor: pointer;">
                                    <input type="checkbox" class="mr-1 group-toggle">
                                    {{ \App\Helpers\PermissionHelper::module($module) }}
                                    <span class="text-muted small">({{ $module }})</span>
                                </label>
                            </div>
                            <div class="p-3">
                                @foreach($permissions as $permission)
                                    <div class="custom-control custom-checkbox mb-2">
                                        <input type="checkbox" class="custom-control-input permission-check" id="permission{{ $permission->id }}" name="permissions[]" value="{{ $permission->id }}" @checked($selectedPermissions->contains($permission->id))>
                                        <label class="custom-control-label cursor-pointer font-weight-normal" for="permission{{ $permission->id }}" style="cursor: pointer;">
                                            <code>{{ $permission->slug }}</code>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="card-footer bg-white text-right">
            <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary mr-2">
                <i class="fas fa-times mr-1"></i> បោះបង់
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-1"></i> រក្សាទុកតួនាទី
            </button>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
$(function () {
    let slugEdited = Boolean($('#roleSlug').val());
    function slugify(value) {
        return value.toString().toLowerCase().trim().replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-').replace(/^-|-$/g, '');
    }
    $('#roleSlug').on('input', function () { slugEdited = true; });
    $('#roleName').on('input', function () { if (!slugEdited) $('#roleSlug').val(slugify(this.value)); });
    $('#selectAll').on('click', function () { $('.permission-check,.group-toggle').prop('checked', true); });
    $('#clearAll').on('click', function () { $('.permission-check,.group-toggle').prop('checked', false); });
    $('.group-toggle').on('change', function () { $(this).closest('.border').find('.permission-check').prop('checked', this.checked); });
});
</script>
@endpush
