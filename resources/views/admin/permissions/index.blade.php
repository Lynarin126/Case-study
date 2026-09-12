@extends('layouts.master')

@section('title', 'សិទ្ធិអនុញ្ញាត | LMS')

@section('content')
<section class="content-header px-0">
    <div class="container-fluid px-0">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-7">
                <h1 class="mb-1">សិទ្ធិអនុញ្ញាត</h1>
                <p class="text-muted mb-0">ពិនិត្យ និងស្វែងរកសិទ្ធិអនុញ្ញាតតាមម៉ូឌុល និងសកម្មភាពនីមួយៗក្នុងប្រព័ន្ធ។</p>
            </div>
            <div class="col-sm-5 text-sm-right mt-2 mt-sm-0">
                <ol class="breadcrumb float-sm-right mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">ផ្ទាំងគ្រប់គ្រង</a></li>
                    <li class="breadcrumb-item active">សិទ្ធិអនុញ្ញាត</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Dynamic Permissions DataTable (matches Courses layout) -->
<div class="card shadow-sm mb-4">
    <div class="card-header d-flex align-items-center">
        <h3 class="card-title mb-0 font-weight-bold">បញ្ជីសិទ្ធិអនុញ្ញាត</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped datatable">
            <thead>
                <tr>
                    <th style="width: 60px;">ល.រ</th>
                    <th>ម៉ូឌុល (Module)</th>
                    <th>ឈ្មោះសិទ្ធិ</th>
                    <th>កូដសម្គាល់ (Slug)</th>
                    <th>ការពិពណ៌នា</th>
                    <th style="width: 120px;">ប្រភេទសកម្មភាព</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allPermissions as $perm)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <span class="font-weight-bold">{{ \App\Helpers\PermissionHelper::module($perm->module) }}</span>
                            <small class="text-muted d-block font-weight-normal">({{ $perm->module }})</small>
                        </td>
                        <td>{{ $perm->name }}</td>
                        <td><code>{{ $perm->slug }}</code></td>
                        <td>{{ $perm->description ?? '-' }}</td>
                        <td>
                            <span class="badge badge-info">
                                {{ \App\Helpers\PermissionHelper::action(str($perm->slug)->after('.')->value()) }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Module Overview Matrix -->
<div class="card shadow-sm">
    <div class="card-header bg-white d-flex align-items-center">
        <h3 class="card-title mb-0 font-weight-bold">
            <i class="fas fa-table mr-2 text-primary"></i>តារាងសង្ខេបសិទ្ធិអនុញ្ញាតតាមម៉ូឌុល
        </h3>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover mb-0">
            <thead class="thead-light">
                <tr>
                    <th style="min-width: 220px;">ម៉ូឌុល (Module)</th>
                    <th class="text-center" style="min-width: 90px;">មើល<br><small class="text-muted">(View)</small></th>
                    <th class="text-center" style="min-width: 90px;">បង្កើត<br><small class="text-muted">(Create)</small></th>
                    <th class="text-center" style="min-width: 90px;">កែប្រែ<br><small class="text-muted">(Update)</small></th>
                    <th class="text-center" style="min-width: 90px;">លុប<br><small class="text-muted">(Delete)</small></th>
                    <th class="text-center" style="min-width: 100px;">បោះពុម្ព<br><small class="text-muted">(Publish)</small></th>
                    <th class="text-center" style="min-width: 100px;">នាំចេញ<br><small class="text-muted">(Export)</small></th>
                    <th style="min-width: 140px;">សកម្មភាពផ្សេងៗ<br><small class="text-muted">(Other Actions)</small></th>
                </tr>
            </thead>
            <tbody>
                @foreach($permissions as $module => $group)
                    @php
                        $actions = $group->mapWithKeys(fn($permission) => [str($permission->slug)->after('.')->value() => $permission->slug]);
                        $standard = ['view', 'create', 'update', 'delete', 'publish', 'export'];
                    @endphp
                    <tr>
                        <td class="font-weight-bold align-middle">
                            <i class="fas fa-layer-group text-primary mr-2"></i>{{ \App\Helpers\PermissionHelper::module($module) }}
                            <small class="text-muted d-block font-weight-normal pl-4">({{ $module }})</small>
                        </td>
                        @foreach($standard as $action)
                            <td class="text-center align-middle">
                                {!! $actions->has($action) ? '<span class="badge badge-success" title="'.$actions->get($action).'"><i class="fas fa-check"></i></span>' : '<span class="text-muted">-</span>' !!}
                            </td>
                        @endforeach
                        <td class="align-middle">
                            @foreach($actions->keys()->diff($standard) as $action)
                                <span class="badge badge-light border mb-1" title="{{ $actions->get($action) }}">
                                    {{ \App\Helpers\PermissionHelper::action($action) }}
                                    <small class="text-muted">({{ $action }})</small>
                                </span>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
