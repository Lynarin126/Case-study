@extends('layouts.master')

@section('title', 'តួនាទី និងសិទ្ធិ | LMS')

@section('content')
<section class="content-header px-0">
    <div class="container-fluid px-0">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-7">
                <h1 class="mb-1">តួនាទី និងសិទ្ធិអនុញ្ញាត</h1>
                <p class="text-muted mb-0">គ្រប់គ្រងការកំណត់សិទ្ធិអនុញ្ញាតតាមតួនាទី និងគោលការណ៍ធនធាននីមួយៗក្នុងប្រព័ន្ធ។</p>
            </div>
            <div class="col-sm-5 text-sm-right mt-2 mt-sm-0">
                <ol class="breadcrumb float-sm-right mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">ផ្ទាំងគ្រប់គ្រង</a></li>
                    <li class="breadcrumb-item active">តួនាទី</li>
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

<!-- Dynamic Roles DataTable (matches Courses style) -->
<div class="card shadow-sm mb-4">
    <div class="card-header d-flex align-items-center">
        <h3 class="card-title mb-0 font-weight-bold">បញ្ជីតួនាទី</h3>
        @can('roles.create')
            <a href="{{ route('admin.roles.create') }}" class="btn btn-primary btn-sm ml-auto">
                <i class="fas fa-plus mr-1"></i>
                បង្កើតថ្មី
            </a>
        @endcan
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped datatable">
            <thead>
                <tr>
                    <th style="width: 60px;">ល.រ</th>
                    <th>ឈ្មោះតួនាទី</th>
                    <th>កូដសម្គាល់ (Slug)</th>
                    <th>ការពិពណ៌នា</th>
                    <th>ប្រភេទ</th>
                    <th style="width: 110px;">សកម្មភាព</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="font-weight-bold">{{ $role->name }}</td>
                        <td><code>{{ $role->slug }}</code></td>
                        <td>{{ $role->description ?? '-' }}</td>
                        <td>
                            @if($role->is_system)
                                <span class="badge badge-info"><i class="fas fa-shield-alt mr-1"></i>ប្រព័ន្ធ (System)</span>
                            @else
                                <span class="badge badge-secondary">ទូទៅ (Custom)</span>
                            @endif
                        </td>
                        <td>
                            @can('roles.update')
                                <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-warning btn-sm" title="កែប្រែ">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @endcan
                            @can('roles.delete')
                                @unless($role->is_system)
                                    <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="d-inline" onsubmit="return confirm('តើអ្នកពិតជាចង់លុបតួនាទីនេះមែនទេ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="លុប">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endunless
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Permission Matrix Card -->
<div class="card shadow-sm">
    <div class="card-header bg-white d-flex align-items-center">
        <h3 class="card-title mb-0 font-weight-bold">
            <i class="fas fa-th mr-2 text-primary"></i>ម៉ាទ្រីសសិទ្ធិអនុញ្ញាត (Permission Matrix)
        </h3>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover table-sm mb-0">
            <thead class="thead-light">
                <tr>
                    <th style="min-width:260px;">សិទ្ធិអនុញ្ញាត (Permission Slug)</th>
                    @foreach($roles as $role)
                        <th class="text-center" style="min-width:130px;">{{ $role->name }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($permissions as $module => $group)
                    <tr class="table-secondary">
                        <td colspan="{{ $roles->count() + 1 }}" class="font-weight-bold py-2">
                            <i class="fas fa-folder-open text-primary mr-2"></i>{{ \App\Helpers\PermissionHelper::module($module) }}
                            <small class="text-muted">({{ $module }})</small>
                        </td>
                    </tr>
                    @foreach($group as $permission)
                        <tr>
                            <td class="pl-4"><code>{{ $permission->slug }}</code></td>
                            @foreach($roles as $role)
                                <td class="text-center">
                                    @if($role->permissions->contains('id', $permission->id))
                                        <span class="badge badge-success"><i class="fas fa-check"></i></span>
                                    @else
                                        <span class="badge badge-light border text-muted"><i class="fas fa-times"></i></span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
