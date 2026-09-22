<aside class="main-sidebar sidebar-dark-primary elevation-4 sidebar-fixed sidebar-premium">
<style>
    /* ========================================
       PREMIUM LIGHT GREEN SIDEBAR
       ======================================== */

    .sidebar-premium {
        background: #ecfdf5 !important;
        border-right: 1px solid #d1fae5;
    }

    /* Brand */
    .sidebar-premium .brand-link {
        border-bottom: 1px solid #d1fae5;
        padding: 0.9rem 1rem;
        background: #ecfdf5;
    }

    .sidebar-premium .brand-text {
        font-weight: 600 !important;
        font-size: 1rem;
        letter-spacing: 0.01em;
        color: #065f46 !important;
    }

    /* User Panel */
    .sidebar-premium .user-panel {
        border-bottom: 1px solid #d1fae5;
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .sidebar-premium .user-panel .image img {
        border: 2px solid #86efac;
    }

    .sidebar-premium .user-panel .info a.text-white {
        font-size: 0.9rem;
        color: #064e3b !important;
    }

    /* Info Button */
    .sidebar-premium .btn-info {
        background: #10b981;
        border-color: #10b981;
        color: #fff;
    }

    .sidebar-premium .btn-info:hover {
        background: #059669;
        border-color: #059669;
    }

    /* Section Header */
    .sidebar-premium .nav-header {
        color: #6b7280 !important;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        padding: 1rem 1rem 0.4rem;
    }

    /* Main Navigation */
    .sidebar-premium .nav-sidebar > .nav-item > .nav-link {
        border-radius: 8px;
        margin: 0.1rem 0.6rem;
        padding: 0.55rem 0.8rem;
        color: #374151;
        font-size: 0.87rem;
        transition: all 0.15s ease;
    }

    /* Hover */
    .sidebar-premium .nav-sidebar > .nav-item > .nav-link:hover {
        background: #d1fae5;
        color: #065f46;
    }

    /* Active */
    .sidebar-premium .nav-sidebar > .nav-item > .nav-link.active {
        background: #10b981 !important;
        color: #fff !important;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.30);
    }

    /* Sub Menu */
    .sidebar-premium .nav-treeview > .nav-item > .nav-link {
        border-radius: 8px;
        margin: 0.05rem 0.6rem 0.05rem 1.4rem;
        padding: 0.45rem 0.8rem;
        font-size: 0.83rem;
        color: #6b7280;
    }

    /* Sub Menu Hover */
    .sidebar-premium .nav-treeview > .nav-item > .nav-link:hover {
        background: #d1fae5;
        color: #047857;
    }

    /* Sub Menu Active */
    .sidebar-premium .nav-treeview > .nav-item > .nav-link.active {
        background: #a7f3d0 !important;
        color: #065f46 !important;
    }

    /* Icons */
    .sidebar-premium .nav-icon {
        font-size: 0.9rem;
        width: 1.4rem;
        color: #059669;
    }

    /* Active Icon */
    .sidebar-premium .nav-link.active .nav-icon {
        color: #fff !important;
    }
</style>

 <a href="{{ route('dashboard') }}" class="brand-link d-flex align-items-center">
    <img src="{{ asset('backend/dist/img/spilogo.png') }}"
        alt="SPI Logo"
        class="brand-image rounded elevation-3"
        style="opacity:.9;width:45px;height:45px;">
    <span class="brand-text font-weight-light ml-2">វិទ្យាស្ថាន សន្តប៉ូល</span>
</a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
            <div class="image">
                <img src="{{ asset('backend/dist/img/user.png') }}" class="img-circle elevation-2" style="width:40px;height:40px;">
            </div>
            <div class="info d-flex flex-column">
                <a href="{{ route('profile.edit') }}" class="d-block text-white mb-1 font-weight-bold">
                    {{ Auth::user()->name ?? 'Admin' }}
                </a>
                <div class="d-flex align-items-center mt-1">
                    <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-info py-0 px-2 mr-1" style="font-size: 0.8rem;" title="ប្រវត្តិរូប">
                        <i class="fas fa-user-circle"></i>
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline m-0">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger py-0 px-2" style="font-size: 0.8rem;" title="ចាកចេញ">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>ផ្ទាំងគ្រប់គ្រង</p>
                    </a>
                </li>

                <li class="nav-header">ប្រព័ន្ធ LMS</li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-laptop-house"></i>
                        <p>
                            ការសិក្សាអនឡាញ
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('lessons.index') }}" class="nav-link {{ request()->routeIs('lessons.*') ? 'active' : '' }}">
                                <i class="fas fa-book-open nav-icon"></i>
                                <p>មេរៀន</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('exams.index') }}" class="nav-link {{ request()->routeIs('exams.*') ? 'active' : '' }}">
                                <i class="fas fa-question-circle nav-icon"></i>
                                <p>តេស្ត និងប្រឡង</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('assignments.index') }}" class="nav-link {{ request()->routeIs('assignments.*') ? 'active' : '' }}">
                                <i class="fas fa-tasks nav-icon"></i>
                                <p>កិច្ចការ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('progress.index') }}" class="nav-link {{ request()->routeIs('progress.*') ? 'active' : '' }}">
                                <i class="fas fa-chart-line nav-icon"></i>
                                <p>វឌ្ឍនភាពសិក្សា</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('discussions.index') }}" class="nav-link {{ request()->routeIs('discussions.*') ? 'active' : '' }}">
                                <i class="fas fa-comments nav-icon"></i>
                                <p>វេទិកាពិភាក្សា</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header">រចនាសម្ព័ន្ធសិក្សា</li>

                <li class="nav-item">
                    <a href="{{ route('academic-years.index') }}" class="nav-link {{ request()->routeIs('academic-years.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>ឆ្នាំសិក្សា</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('faculties.index') }}" class="nav-link {{ request()->routeIs('faculties.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-university"></i>
                        <p>មហាវិទ្យាល័យ</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('departments.index') }}" class="nav-link {{ request()->routeIs('departments.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-building"></i>
                        <p>ដេប៉ាតឺម៉ង់</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('course-categories.index') }}" class="nav-link {{ request()->routeIs('course-categories.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>ប្រភេទវគ្គសិក្សា</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('courses.index') }}" class="nav-link {{ request()->routeIs('courses.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-layer-group"></i>
                        <p>វគ្គសិក្សា</p>
                    </a>
                </li>

                <li class="nav-header">គ្រប់គ្រងគ្រូបង្រៀន</li>

                <li class="nav-item">
                    <a href="{{ route('teachers.index') }}" class="nav-link {{ request()->routeIs('teachers.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chalkboard-teacher"></i>
                        <p>គ្រូបង្រៀន</p>
                    </a>
                </li>

                <li class="nav-header">គ្រប់គ្រងនិស្សិត</li>

                <li class="nav-item">
                    <a href="{{ route('students.index') }}" class="nav-link {{ request()->routeIs('students.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-graduate"></i>
                        <p>និស្សិត</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('enrollments.index') }}" class="nav-link {{ request()->routeIs('enrollments.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-plus"></i>
                        <p>ការចុះឈ្មោះ</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('scores.index') }}" class="nav-link {{ request()->routeIs('scores.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-graduation-cap"></i>
                        <p>ពិន្ទុ</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('attendances.index') }}" class="nav-link {{ request()->routeIs('attendances.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-clipboard-check"></i>
                        <p>វត្តមាន</p>
                    </a>
                </li>

                <li class="nav-header">ប្រព័ន្ធ</li>

                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>អ្នកប្រើប្រាស់</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('notifications.index') }}" class="nav-link {{ request()->routeIs('notifications.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-bell"></i>
                        <p>ការជូនដំណឹង</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.roles.index') }}" class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-shield"></i>
                        <p>តួនាទី</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.permissions.index') }}" class="nav-link {{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-key"></i>
                        <p>សិទ្ធិអនុញ្ញាត</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('settings.index') }}" class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>ការកំណត់</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>