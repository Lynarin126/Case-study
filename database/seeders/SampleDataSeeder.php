<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\ContentLesson;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseModule;
use App\Models\Department;
use App\Models\Enrollment;
use App\Models\Faculty;
use App\Models\Role;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the comprehensive sample data seeders for e-learning testing.
     */
    public function run(): void
    {
        // ---------------------------------------------------------------------
        // 1. Roles & Permissions Check
        // ---------------------------------------------------------------------
        $superAdminRole = Role::firstOrCreate(
            ['slug' => 'super-admin'],
            ['name' => 'Super Admin', 'description' => 'Full system access.', 'is_system' => true]
        );
        $instructorRole = Role::firstOrCreate(
            ['slug' => 'instructor'],
            ['name' => 'Instructor / Teacher', 'description' => 'Instructor access to courses.', 'is_system' => true]
        );
        $studentRole = Role::firstOrCreate(
            ['slug' => 'student'],
            ['name' => 'Student', 'description' => 'Learner access.', 'is_system' => true]
        );

        // ---------------------------------------------------------------------
        // 2. Faculties & Departments
        // ---------------------------------------------------------------------
        $faculties = [
            'FAC-001' => 'Faculty of Science and Information Technology (មហាវិទ្យាល័យវិទ្យាសាស្ត្រ និងបច្ចេកវិទ្យា)',
            'FAC-002' => 'Faculty of Digital Media & Creative Design (មហាវិទ្យាល័យប្រព័ន្ធផ្សព្វផ្សាយ និងការរចនា)',
            'FAC-003' => 'Faculty of Engineering & Telecommunications (មហាវិទ្យាល័យវិស្វកម្ម និងទូរគមនាគមន៍)',
        ];

        $facultyModels = [];
        foreach ($faculties as $code => $name) {
            $facultyModels[$code] = Faculty::updateOrCreate(
                ['faculty_code' => $code],
                ['faculty_name' => $name]
            );
        }

        $departments = [
            [
                'code' => 'DEP-001',
                'faculty_id' => $facultyModels['FAC-001']->faculty_id,
                'name' => 'Computer Science & Software Engineering',
                'dean' => 'Dr. Sarin Vuthy',
            ],
            [
                'code' => 'DEP-002',
                'faculty_id' => $facultyModels['FAC-001']->faculty_id,
                'name' => 'Cloud Infrastructure & Database Systems',
                'dean' => 'Prof. Kim Sreang',
            ],
            [
                'code' => 'DEP-003',
                'faculty_id' => $facultyModels['FAC-003']->faculty_id,
                'name' => 'Cybersecurity & Network Defense',
                'dean' => 'Dr. Samnang Heng',
            ],
            [
                'code' => 'DEP-004',
                'faculty_id' => $facultyModels['FAC-002']->faculty_id,
                'name' => 'UI/UX & Interactive Product Design',
                'dean' => 'Dr. Long Phearith',
            ],
            [
                'code' => 'DEP-005',
                'faculty_id' => $facultyModels['FAC-001']->faculty_id,
                'name' => 'Applied Artificial Intelligence & Data Science',
                'dean' => 'Prof. Chan Vathana',
            ],
        ];

        foreach ($departments as $d) {
            Department::updateOrCreate(
                ['department_code' => $d['code']],
                [
                    'faculty_id' => $d['faculty_id'],
                    'department_name' => $d['name'],
                    'deans' => $d['dean'],
                ]
            );
        }

        // ---------------------------------------------------------------------
        // 3. Academic Years, Semesters & Classrooms
        // ---------------------------------------------------------------------
        $ay2024 = AcademicYear::updateOrCreate(
            ['year_name' => '2024-2025'],
            ['start_date' => '2024-10-01', 'end_date' => '2025-07-31', 'is_active' => false]
        );

        $ay2025 = AcademicYear::updateOrCreate(
            ['year_name' => '2025-2026'],
            ['start_date' => '2025-10-01', 'end_date' => '2026-07-31', 'is_active' => true]
        );

        $ay2026 = AcademicYear::updateOrCreate(
            ['year_name' => '2026-2027'],
            ['start_date' => '2026-10-01', 'end_date' => '2027-07-31', 'is_active' => false]
        );

        $sem1 = DB::table('semesters')->where('academic_year_id', $ay2025->academic_year_id)->where('semester_name', 'Semester 1')->first();
        if (!$sem1) {
            $sem1Id = DB::table('semesters')->insertGetId([
                'academic_year_id' => $ay2025->academic_year_id,
                'semester_name' => 'Semester 1',
                'start_date' => '2025-10-01',
                'end_date' => '2026-02-28',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ], 'semester_id');
        } else {
            $sem1Id = $sem1->semester_id;
        }

        $sem2 = DB::table('semesters')->where('academic_year_id', $ay2025->academic_year_id)->where('semester_name', 'Semester 2')->first();
        if (!$sem2) {
            $sem2Id = DB::table('semesters')->insertGetId([
                'academic_year_id' => $ay2025->academic_year_id,
                'semester_name' => 'Semester 2',
                'start_date' => '2026-03-01',
                'end_date' => '2026-07-31',
                'is_active' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ], 'semester_id');
        } else {
            $sem2Id = $sem2->semester_id;
        }

        $classRoomsData = [
            ['room_code' => 'LAB-101', 'room_name' => 'Software Engineering & AI Innovation Lab'],
            ['room_code' => 'LAB-204', 'room_name' => 'Cloud & High-Speed Network Systems Lab'],
            ['room_code' => 'ROOM-302', 'room_name' => 'Interactive Design & Prototyping Studio'],
            ['room_code' => 'ONLINE-01', 'room_name' => 'E-Learning Virtual Interactive Lecture Room'],
        ];

        $classRoomIds = [];
        foreach ($classRoomsData as $crd) {
            $existing = DB::table('class_rooms')->where('room_code', $crd['room_code'])->first();
            if ($existing) {
                $classRoomIds[$crd['room_code']] = $existing->class_room_id;
            } else {
                $classRoomIds[$crd['room_code']] = DB::table('class_rooms')->insertGetId([
                    'room_code' => $crd['room_code'],
                    'room_name' => $crd['room_name'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ], 'class_room_id');
            }
        }

        // ---------------------------------------------------------------------
        // 4. Course Categories
        // ---------------------------------------------------------------------
        $categoriesData = [
            [
                'code' => 'CAT-001',
                'name' => 'Web Development',
                'desc' => 'Frontend, Backend, and Full-Stack web application engineering with Vue.js, React, Node.js, and Laravel.',
            ],
            [
                'code' => 'CAT-002',
                'name' => 'Database Systems',
                'desc' => 'Relational database schema modeling, PostgreSQL, MySQL, Redis caching, indexing, and clustering.',
            ],
            [
                'code' => 'CAT-003',
                'name' => 'Networking & Cloud',
                'desc' => 'Computer network infrastructure, CCNA, IP routing, packet inspection, cloud security policies, and AWS.',
            ],
            [
                'code' => 'CAT-004',
                'name' => 'UI/UX & Design',
                'desc' => 'Modern user experience research, Figma component systems, wireframing, auto-layouts, and prototyping.',
            ],
            [
                'code' => 'CAT-005',
                'name' => 'Mobile Development',
                'desc' => 'Cross-platform native mobile engineering using Flutter, Dart, state management, and offline sync architectures.',
            ],
            [
                'code' => 'CAT-006',
                'name' => 'DevOps & Architecture',
                'desc' => 'Docker containerization, Kubernetes orchestration, CI/CD automated pipelines, and Linux server hardening.',
            ],
            [
                'code' => 'CAT-007',
                'name' => 'AI & Data Science',
                'desc' => 'Python data analytics, machine learning algorithms, deep neural networks, and computer vision pipelines.',
            ],
        ];

        $categoryModels = [];
        foreach ($categoriesData as $c) {
            $categoryModels[$c['code']] = CourseCategory::updateOrCreate(
                ['category_code' => $c['code']],
                [
                    'category_name' => $c['name'],
                    'description' => $c['desc'],
                ]
            );
        }

        // ---------------------------------------------------------------------
        // 5. Teachers (Instructors)
        // ---------------------------------------------------------------------
        $teachersData = [
            [
                'code' => 'TCH-001',
                'first_name' => 'សុវណ្ណ',
                'last_name' => 'សុខ',
                'first_name_latin' => 'Sovann',
                'last_name_latin' => 'Sok',
                'gender' => 'Male',
                'email' => 'sovann.sok@lms.edu.kh',
                'phone' => '012 345 678',
                'specialization' => 'Full-Stack Architecture & Laravel Sanctum',
                'address' => 'Phnom Penh, Cambodia',
            ],
            [
                'code' => 'TCH-002',
                'first_name' => 'វិច្ឆិកា',
                'last_name' => 'ចាន់',
                'first_name_latin' => 'Vicheka',
                'last_name_latin' => 'Chan',
                'gender' => 'Female',
                'email' => 'vicheka.chan@lms.edu.kh',
                'phone' => '098 765 432',
                'specialization' => 'Database Administration & PostgreSQL Cluster',
                'address' => 'Kandal, Cambodia',
            ],
            [
                'code' => 'TCH-003',
                'first_name' => 'រតនា',
                'last_name' => 'កែវ',
                'first_name_latin' => 'Rattana',
                'last_name_latin' => 'Keo',
                'gender' => 'Male',
                'email' => 'rattana.keo@lms.edu.kh',
                'phone' => '077 112 233',
                'specialization' => 'Network Infrastructure, CCNA & Cyber Security',
                'address' => 'Phnom Penh, Cambodia',
            ],
            [
                'code' => 'TCH-004',
                'first_name' => 'ស្រីមុំ',
                'last_name' => 'អ៊ុក',
                'first_name_latin' => 'Sreymom',
                'last_name_latin' => 'Ouk',
                'gender' => 'Female',
                'email' => 'sreymom.ouk@lms.edu.kh',
                'phone' => '086 443 221',
                'specialization' => 'UI/UX Design Systems & Figma Prototyping',
                'address' => 'Siem Reap, Cambodia',
            ],
            [
                'code' => 'TCH-005',
                'first_name' => 'តារា',
                'last_name' => 'ជ្រុន',
                'first_name_latin' => 'Dara',
                'last_name_latin' => 'Chrun',
                'gender' => 'Male',
                'email' => 'dara.chrun@lms.edu.kh',
                'phone' => '010 889 977',
                'specialization' => 'Mobile App Systems (Flutter) & AI Machine Learning',
                'address' => 'Battambang, Cambodia',
            ],
        ];

        $teacherModels = [];
        foreach ($teachersData as $t) {
            $teacherModels[$t['code']] = Teacher::updateOrCreate(
                ['teacher_code' => $t['code']],
                [
                    'first_name' => $t['first_name'],
                    'last_name' => $t['last_name'],
                    'first_name_latin' => $t['first_name_latin'],
                    'last_name_latin' => $t['last_name_latin'],
                    'gender' => $t['gender'],
                    'email' => $t['email'],
                    'phone' => $t['phone'],
                    'specialization' => $t['specialization'],
                    'address' => $t['address'],
                    'status' => 'active',
                    'hire_date' => '2023-01-15',
                ]
            );

            // Create corresponding User account for each teacher
            $teacherUser = User::updateOrCreate(
                ['email' => $t['email']],
                [
                    'first_name' => $t['first_name'],
                    'last_name' => $t['last_name'],
                    'first_name_latin' => $t['first_name_latin'],
                    'last_name_latin' => $t['last_name_latin'],
                    'name' => trim($t['first_name'] . ' ' . $t['last_name']),
                    'password' => 'password',
                    'email_verified_at' => now(),
                ]
            );
            $teacherUser->roles()->syncWithoutDetaching([$instructorRole->id]);
        }

        // ---------------------------------------------------------------------
        // 6. Students
        // ---------------------------------------------------------------------
        $studentsData = [
            ['code' => 'STU-1001', 'first' => 'ពិសិដ្ឋ', 'last' => 'ហេង', 'first_latin' => 'Piseth', 'last_latin' => 'Heng', 'gender' => 'Male', 'email' => 'piseth.heng@student.edu.kh', 'phone' => '092 112 334', 'dob' => '2004-03-12'],
            ['code' => 'STU-1002', 'first' => 'សុភា', 'last' => 'ជា', 'first_latin' => 'Sophea', 'last_latin' => 'Chea', 'gender' => 'Female', 'email' => 'sophea.chea@student.edu.kh', 'phone' => '093 223 445', 'dob' => '2003-08-25'],
            ['code' => 'STU-1003', 'first' => 'បុនរិទ្ធ', 'last' => 'ឈុំ', 'first_latin' => 'Bunrith', 'last_latin' => 'Chhom', 'gender' => 'Male', 'email' => 'bunrith.chhom@student.edu.kh', 'phone' => '096 334 556', 'dob' => '2004-11-05'],
            ['code' => 'STU-1004', 'first' => 'ស្រីពៅ', 'last' => 'ជា', 'first_latin' => 'Sreypov', 'last_latin' => 'Chea', 'gender' => 'Female', 'email' => 'sreypov.chea@student.edu.kh', 'phone' => '088 445 667', 'dob' => '2005-01-18'],
            ['code' => 'STU-1005', 'first' => 'សុវណ្ណារិទ្ធ', 'last' => 'លី', 'first_latin' => 'Sovannarith', 'last_latin' => 'Ly', 'gender' => 'Male', 'email' => 'sovannarith.ly@student.edu.kh', 'phone' => '070 556 778', 'dob' => '2003-05-30'],
            ['code' => 'STU-1006', 'first' => 'សុធា', 'last' => 'នួន', 'first_latin' => 'Sothea', 'last_latin' => 'Noun', 'gender' => 'Female', 'email' => 'sothea.noun@student.edu.kh', 'phone' => '089 667 889', 'dob' => '2004-09-14'],
            ['code' => 'STU-1007', 'first' => 'វណ្ណៈ', 'last' => 'ស៊ិន', 'first_latin' => 'Vannak', 'last_latin' => 'Sin', 'gender' => 'Male', 'email' => 'vannak.sin@student.edu.kh', 'phone' => '017 334 990', 'dob' => '2003-12-04'],
            ['code' => 'STU-1008', 'first' => 'ចិន្តា', 'last' => 'ម៉ៅ', 'first_latin' => 'Chinda', 'last_latin' => 'Mao', 'gender' => 'Female', 'email' => 'chinda.mao@student.edu.kh', 'phone' => '097 554 112', 'dob' => '2004-07-22'],
        ];

        $studentModels = [];
        foreach ($studentsData as $s) {
            $studentModels[$s['code']] = Student::updateOrCreate(
                ['student_code' => $s['code']],
                [
                    'first_name' => $s['first'],
                    'last_name' => $s['last'],
                    'first_name_latin' => $s['first_latin'],
                    'last_name_latin' => $s['last_latin'],
                    'gender' => $s['gender'],
                    'email' => $s['email'],
                    'phone' => $s['phone'],
                    'date_of_birth' => $s['dob'],
                    'address' => 'Phnom Penh, Cambodia',
                    'status' => 'active',
                ]
            );

            // Create corresponding Student User account
            $studentUser = User::updateOrCreate(
                ['email' => $s['email']],
                [
                    'first_name' => $s['first'],
                    'last_name' => $s['last'],
                    'first_name_latin' => $s['first_latin'],
                    'last_name_latin' => $s['last_latin'],
                    'name' => trim($s['first'] . ' ' . $s['last']),
                    'password' => 'password',
                    'email_verified_at' => now(),
                ]
            );
            $studentUser->roles()->syncWithoutDetaching([$studentRole->id]);
        }

        // ---------------------------------------------------------------------
        // 7. General Testing User Accounts (All password: 'password')
        // ---------------------------------------------------------------------
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'first_name' => 'អភិបាល',
                'last_name' => 'ប្រព័ន្ធ',
                'first_name_latin' => 'System',
                'last_name_latin' => 'Admin',
                'name' => 'អភិបាល ប្រព័ន្ធ',
                'password' => 'password',
                'email_verified_at' => now()
            ]
        );
        $adminUser->roles()->syncWithoutDetaching([$superAdminRole->id]);

        $testUser = User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'first_name' => 'តេស្ត',
                'last_name' => 'អភិបាល',
                'first_name_latin' => 'Test',
                'last_name_latin' => 'Admin',
                'name' => 'តេស្ត អភិបាល',
                'password' => 'password',
                'email_verified_at' => now()
            ]
        );
        $testUser->roles()->syncWithoutDetaching([$superAdminRole->id]);

        $demoTeacher = User::updateOrCreate(
            ['email' => 'teacher@example.com'],
            [
                'first_name' => 'សុវណ្ណ',
                'last_name' => 'សុខ',
                'first_name_latin' => 'Sovann',
                'last_name_latin' => 'Sok',
                'name' => 'សុវណ្ណ សុខ',
                'password' => 'password',
                'email_verified_at' => now()
            ]
        );
        $demoTeacher->roles()->syncWithoutDetaching([$instructorRole->id]);

        $demoStudent = User::updateOrCreate(
            ['email' => 'student@example.com'],
            [
                'first_name' => 'ពិសិដ្ឋ',
                'last_name' => 'ហេង',
                'first_name_latin' => 'Piseth',
                'last_name_latin' => 'Heng',
                'name' => 'ពិសិដ្ឋ ហេង',
                'password' => 'password',
                'email_verified_at' => now()
            ]
        );
        $demoStudent->roles()->syncWithoutDetaching([$studentRole->id]);

        // ---------------------------------------------------------------------
        // 8. Courses & Teachers Assignment
        // ---------------------------------------------------------------------
        $coursesConfig = [
            'CRS-101' => [
                'name' => 'Full-Stack Web Development with Vue 3 & Laravel',
                'category_code' => 'CAT-001',
                'visibility' => 'public',
                'teacher_codes' => ['TCH-001'],
                'desc' => 'Comprehensive masterclass on modern full-stack engineering. Learn Vue 3 Composition API, Pinia reactivity, Tailwind CSS styling, Laravel REST APIs, and Docker deployment.',
            ],
            'CRS-102' => [
                'name' => 'Relational Database Architecture & PostgreSQL Optimization',
                'category_code' => 'CAT-002',
                'visibility' => 'public',
                'teacher_codes' => ['TCH-002'],
                'desc' => 'Hands-on training in relational database schema architecture, SQL indexing strategies, B-tree query execution plans, transactions, and high availability replication.',
            ],
            'CRS-103' => [
                'name' => 'Computer Networking Fundamentals & CCNA Cyber Infrastructure',
                'category_code' => 'CAT-003',
                'visibility' => 'public',
                'teacher_codes' => ['TCH-003'],
                'desc' => 'In-depth exploration of OSI 7-layer architecture, IPv4/IPv6 subnetting, VLAN switches, OSPF routing protocols, and firewall security configurations.',
            ],
            'CRS-104' => [
                'name' => 'Modern UI/UX Design & Design Systems with Figma',
                'category_code' => 'CAT-004',
                'visibility' => 'public',
                'teacher_codes' => ['TCH-004'],
                'desc' => 'Master user research heuristics, wireframing, Figma Auto-Layout 5.0, responsive components, typography scale design tokens, and developer handoffs.',
            ],
            'CRS-105' => [
                'name' => 'RESTful API Engineering & Microservices with Laravel Sanctum',
                'category_code' => 'CAT-001',
                'visibility' => 'university_students',
                'teacher_codes' => ['TCH-001'],
                'desc' => 'Building enterprise-grade, secure REST APIs with token authorization, role-based permission policies, rate limiting, and API Resource transformations.',
            ],
            'CRS-106' => [
                'name' => 'Cross-Platform Mobile App Engineering with Flutter & Dart',
                'category_code' => 'CAT-005',
                'visibility' => 'public',
                'teacher_codes' => ['TCH-005'],
                'desc' => 'Develop high-performance iOS and Android apps with a unified Dart codebase, reactive BLoC/Provider state trees, and offline SQLite caching.',
            ],
            'CRS-107' => [
                'name' => 'Cloud DevOps, Docker Containerization & CI/CD Pipelines',
                'category_code' => 'CAT-006',
                'visibility' => 'public',
                'teacher_codes' => ['TCH-002', 'TCH-003'],
                'desc' => 'Master containerization with Docker multi-stage builds, compose clusters, automated GitHub Actions CI/CD pipelines, and secure Linux server deployments.',
            ],
        ];

        $courseModels = [];
        foreach ($coursesConfig as $code => $cfg) {
            $cat = $categoryModels[$cfg['category_code']];
            $course = Course::updateOrCreate(
                ['course_code' => $code],
                [
                    'course_name' => $cfg['name'],
                    'course_category_id' => $cat->course_category_id,
                    'description' => $cfg['desc'],
                    'visibility' => $cfg['visibility'],
                ]
            );
            $courseModels[$code] = $course;

            // Sync teachers
            $teacherIds = [];
            foreach ($cfg['teacher_codes'] as $tCode) {
                if (isset($teacherModels[$tCode])) {
                    $teacherIds[] = $teacherModels[$tCode]->teacher_id;
                }
            }
            if (!empty($teacherIds)) {
                $course->teachers()->syncWithoutDetaching($teacherIds);
            }
        }

        // ---------------------------------------------------------------------
        // 9. Full Course Modules & Comprehensive Lessons
        // ---------------------------------------------------------------------
        $sampleVideos = [
            'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4',
            'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4',
            'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4',
            'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerEscapes.mp4',
            'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerFun.mp4',
        ];

        $curriculumMap = [
            'CRS-101' => [
                [
                    'module_number' => 1,
                    'title' => 'Module 1: Architecture, Environment & Tooling Setup (ស្ថាបត្យកម្ម និងការរៀបចំបរិស្ថាន)',
                    'desc' => 'Deep dive into full-stack ecosystem tooling: Node.js 20+, PHP 8.3+, Composer, Vite 6, and IDE productivity.',
                    'lessons' => [
                        [
                            'title' => 'Lesson 1.1: Modern Full-Stack Web Architecture Overview',
                            'type' => 'video',
                            'duration' => 25,
                            'summary' => 'Understand decoupled SPA architectures, Client vs Server boundaries, and modern API communication protocols.',
                            'body' => '<h3>Architectural Foundations</h3><p>In this lecture, we examine modern web application decoupling: a responsive Vue.js Single-Page Application (SPA) interacting through an asynchronous REST API backend built with Laravel.</p><h4>Key Concepts:</h4><ul><li>Client-Side Rendering (CSR) vs Server-Side Rendering (SSR)</li><li>Stateless Bearer Token Authentication (Laravel Sanctum)</li><li>Single Responsibility Principle (SRP) in API controller design</li></ul><pre><code>// Typical API Controller Pipeline&#10;Route::middleware("auth:sanctum")->get("/user", [ProfileController::class, "me"]);</code></pre>',
                            'is_required' => true,
                        ],
                        [
                            'title' => 'Lesson 1.2: Development Environment Setup (Vite, Tailwind CSS & Docker)',
                            'type' => 'lesson',
                            'duration' => 35,
                            'summary' => 'Step-by-step setup of your developer workstation with Node.js, PHP, Composer, and Tailwind styling system.',
                            'body' => '<h3>Development Toolchain</h3><p>This hands-on lesson walks through initializing Vite 6 with Vue 3 and modern Tailwind CSS configuration.</p><h4>Steps:</h4><ol><li>Initialize Vite repository: <code>npm create vite@latest frontend -- --template vue</code></li><li>Install Pinia and Vue Router: <code>npm install pinia vue-router lucide-vue-next</code></li><li>Configure Tailwind CSS and PostCSS configuration tokens</li></ol><div class="alert">Ensure you have Node.js version 20 LTS or higher installed.</div>',
                            'is_required' => true,
                        ],
                        [
                            'title' => 'Lesson 1.3: Architecture Assessment Quiz #1',
                            'type' => 'quiz',
                            'duration' => 20,
                            'summary' => 'Knowledge check covering client-server boundaries, HTTP status codes, and SPA state paradigms.',
                            'body' => '<h3>Module 1 Checkpoint Quiz</h3><p>Test your conceptual understanding of modern full-stack web architectures and request-response lifecycles.</p><p>Passing score: <strong>80%</strong>. Maximum score: <strong>100 points</strong>.</p>',
                            'is_required' => true,
                            'max_score' => 100,
                            'passing_score' => 80,
                        ],
                    ],
                ],
                [
                    'module_number' => 2,
                    'title' => 'Module 2: Frontend Engineering with Vue 3 & Pinia (ការអភិវឌ្ឍ Frontend ជាមួយ Vue 3)',
                    'desc' => 'Master Composition API, script setup syntax, reactive state primitives, and centralized Pinia store architectures.',
                    'lessons' => [
                        [
                            'title' => 'Lesson 2.1: Vue 3 Composition API & Reactivity Essentials',
                            'type' => 'video',
                            'duration' => 45,
                            'summary' => 'Master ref, reactive, computed, watch, and watchEffect primitives for dynamic reactive UI components.',
                            'body' => '<h3>Vue 3 Composition API Deep Dive</h3><p>Learn how the Vue 3 Proxy-based reactivity system eliminates Options API boilerplate and enhances code reuse with composables.</p><pre><code>import { ref, computed } from "vue"&#10;&#10;const count = ref(0)&#10;const doubleCount = computed(() => count.value * 2)&#10;&#10;function increment() {&#10;  count.value++&#10;}</code></pre>',
                            'is_required' => true,
                        ],
                        [
                            'title' => 'Lesson 2.2: Global State Management with Pinia Stores',
                            'type' => 'lesson',
                            'duration' => 40,
                            'summary' => 'Build modular Pinia stores for user authentication tokens, course catalogs, and cached API responses.',
                            'body' => '<h3>Pinia Global State Architecture</h3><p>Pinia is the official Vue state management solution. It provides lightweight modular stores with full TypeScript and IDE autocomplete support.</p><h4>Store Best Practices:</h4><ul><li>Separate UI local state from persistent domain state</li><li>Use getters for derived cached statistics</li><li>Keep asynchronous network dispatches inside store actions</li></ul>',
                            'is_required' => true,
                        ],
                        [
                            'title' => 'Lesson 2.3: Lab Assignment: Interactive Filterable Course Directory',
                            'type' => 'assignment',
                            'duration' => 60,
                            'summary' => 'Build a responsive Vue 3 search and category filter component using Tailwind CSS and Pinia state.',
                            'body' => '<h3>Lab Assignment Instructions</h3><p>Implement a reactive Course Directory interface with:</p><ol><li>Real-time search debouncing with Vue watch primitives</li><li>Multi-category pill filter buttons with active cyber-glow accents</li><li>Empty state component with fallback reset triggers</li></ol><p>Submit your GitHub repository link along with a screen demonstration.</p>',
                            'is_required' => true,
                            'max_score' => 100,
                            'passing_score' => 70,
                        ],
                    ],
                ],
                [
                    'module_number' => 3,
                    'title' => 'Module 3: Backend REST APIs with Laravel & Sanctum (ការកសាង REST API)',
                    'desc' => 'Develop scalable REST controllers, Form Request validation, Eloquent relationships, and bearer token authentication.',
                    'lessons' => [
                        [
                            'title' => 'Lesson 3.1: RESTful Resource Routing & Form Request Validation',
                            'type' => 'video',
                            'duration' => 50,
                            'summary' => 'Structure secure Laravel controllers, strict validation rules, and unified JsonResource formatting.',
                            'body' => '<h3>Secure Laravel Controller Engineering</h3><p>Learn how to separate HTTP concerns using dedicated Form Request classes for validation and API Resource wrappers for JSON response consistency.</p><pre><code>public function store(StoreCourseRequest $request): CourseResource&#10;{&#10;    $course = $this->courseService->create($request->validated());&#10;    return new CourseResource($course);&#10;}</code></pre>',
                            'is_required' => true,
                        ],
                        [
                            'title' => 'Lesson 3.2: Sanctum Bearer Token Authentication & RBAC Gates',
                            'type' => 'lesson',
                            'duration' => 45,
                            'summary' => 'Implement secure multi-role authorization with Personal Access Tokens and custom gate middleware.',
                            'body' => '<h3>Token Security Architecture</h3><p>Laravel Sanctum issues cryptographically signed SHA-256 tokens stored securely in MySQL/PostgreSQL. We combine Sanctum with custom role permissions to protect sensitive admin actions.</p>',
                            'is_required' => true,
                        ],
                        [
                            'title' => 'Lesson 3.3: API Design Reference Guide & Postman Collection',
                            'type' => 'file',
                            'duration' => 30,
                            'summary' => 'Downloadable OpenAPI/Swagger reference specification and Postman environment collection.',
                            'body' => '<h3>Comprehensive API Documentation</h3><p>Review the standard endpoints for Courses, Lessons, Enrollments, and Progress Tracking. Includes sample curl commands and status code explanations.</p>',
                            'is_required' => false,
                        ],
                    ],
                ],
                [
                    'module_number' => 4,
                    'title' => 'Module 4: Full-Stack Integration, Testing & CI/CD Deployment',
                    'desc' => 'Connect frontend Axios interceptors to backend Sanctum endpoints, handle errors gracefully, and deploy with Docker.',
                    'lessons' => [
                        [
                            'title' => 'Lesson 4.1: Axios Bearer Interceptors & Auto-Logout Logic',
                            'type' => 'video',
                            'duration' => 40,
                            'summary' => 'Wire frontend networking pipelines with automatic 401 unauthenticated redirect handlers.',
                            'body' => '<h3>Seamless HTTP Pipeline</h3><p>Learn to configure an Axios instance with request authorization headers and response interceptors that gracefully detect expired sessions.</p>',
                            'is_required' => true,
                        ],
                        [
                            'title' => 'Lesson 4.2: Final Capstone Project: Full-Stack LMS Platform',
                            'type' => 'assignment',
                            'duration' => 90,
                            'summary' => 'Deliver a complete, production-grade E-Learning application with video player, course catalog, and quiz assessment.',
                            'body' => '<h3>Capstone Project Requirements</h3><p>Assemble all skills acquired across the course to submit a complete full-stack web application.</p><h4>Criteria:</h4><ul><li>Responsive Dark Cyber/Glassmorphism interface</li><li>Secure Role-Based Access Control</li><li>Interactive video lesson player with persistent completion state</li></ul>',
                            'is_required' => true,
                            'max_score' => 100,
                            'passing_score' => 85,
                        ],
                    ],
                ],
            ],

            'CRS-102' => [
                [
                    'module_number' => 1,
                    'title' => 'Module 1: Relational Schema Design & Normalization (ការរចនា Schema)',
                    'desc' => 'Master Entity Relationship Diagrams (ERD), 1NF to 3NF normalization, foreign key constraints, and cascading integrity.',
                    'lessons' => [
                        [
                            'title' => 'Lesson 1.1: Database Modeling, Cardinality & Foreign Keys',
                            'type' => 'video',
                            'duration' => 30,
                            'summary' => 'Design robust relational architectures with primary keys, unique constraints, and referential integrity.',
                            'body' => '<h3>Relational Schema Fundamentals</h3><p>Explore entity modeling, relationship cardinality (1:1, 1:N, N:M), composite keys, and how cascade deletes prevent orphan database records.</p>',
                            'is_required' => true,
                        ],
                        [
                            'title' => 'Lesson 1.2: 3rd Normal Form (3NF) & Schema Denormalization Strategies',
                            'type' => 'lesson',
                            'duration' => 40,
                            'summary' => 'Eliminate update anomalies through functional dependencies, and discover when to intentionally denormalize for read speed.',
                            'body' => '<h3>Normalization vs Performance</h3><p>Learn the principles of 1st, 2nd, and 3rd normal forms, identifying transitive dependencies and managing read-heavy database architectures.</p>',
                            'is_required' => true,
                        ],
                    ],
                ],
                [
                    'module_number' => 2,
                    'title' => 'Module 2: Advanced SQL Querying & Indexing (SQL និង Indexing)',
                    'desc' => 'B-Tree indexes, Composite indexes, EXPLAIN ANALYZE execution plans, and subquery optimization.',
                    'lessons' => [
                        [
                            'title' => 'Lesson 2.1: PostgreSQL Index Structures & Query Performance',
                            'type' => 'video',
                            'duration' => 45,
                            'summary' => 'Learn how PostgreSQL B-Tree, GIN, and GiST indexes accelerate lookups and prevent costly Sequential Table Scans.',
                            'body' => '<h3>Execution Plan Analysis</h3><pre><code>EXPLAIN ANALYZE&#10;SELECT * FROM content_lessons&#10;WHERE course_id = 1 AND visibility = "visible"&#10;ORDER BY position ASC;</code></pre>',
                            'is_required' => true,
                        ],
                        [
                            'title' => 'Lesson 2.2: Comprehensive SQL Query Optimization Quiz',
                            'type' => 'quiz',
                            'duration' => 25,
                            'summary' => 'Test your understanding of index selectivity, window functions, and join algorithms.',
                            'body' => '<h3>Database Performance Exam</h3><p>Score at least 80% to demonstrate proficiency in query tuning and index strategies.</p>',
                            'is_required' => true,
                            'max_score' => 100,
                            'passing_score' => 80,
                        ],
                    ],
                ],
            ],

            'CRS-103' => [
                [
                    'module_number' => 1,
                    'title' => 'Module 1: OSI Architecture & TCP/IP Networking (ស្ថាបត្យកម្មបណ្តាញ)',
                    'desc' => 'Foundations of computer networks: Layer 1 to 7 models, packet encapsulation, and IP subnetting.',
                    'lessons' => [
                        [
                            'title' => 'Lesson 1.1: The 7-Layer OSI Model Explained in Detail',
                            'type' => 'video',
                            'duration' => 35,
                            'summary' => 'Physical cables to Application protocols: understand headers, frames, packets, and data segments.',
                            'body' => '<h3>OSI vs TCP/IP Suite</h3><p>Explore Physical, Data Link, Network, Transport, Session, Presentation, and Application layers with real-world Wireshark packet captures.</p>',
                            'is_required' => true,
                        ],
                        [
                            'title' => 'Lesson 1.2: IPv4 Variable Length Subnet Masking (VLSM) Lab',
                            'type' => 'assignment',
                            'duration' => 50,
                            'summary' => 'Calculate network ranges, broadcast addresses, and assign optimal subnet blocks for corporate branches.',
                            'body' => '<h3>VLSM Network Design Problem</h3><p>Given the block 192.168.10.0/24, calculate subnets for Sales (50 hosts), Engineering (30 hosts), and Server Cluster (14 hosts).</p>',
                            'is_required' => true,
                            'max_score' => 100,
                            'passing_score' => 75,
                        ],
                    ],
                ],
                [
                    'module_number' => 2,
                    'title' => 'Module 2: Cisco Routers, Switches & Firewall Policies',
                    'desc' => 'Configure Cisco IOS commands, VLAN trunks with 802.1Q, Inter-VLAN routing, and Access Control Lists (ACL).',
                    'lessons' => [
                        [
                            'title' => 'Lesson 2.1: VLAN Configuration & 802.1Q Trunking',
                            'type' => 'video',
                            'duration' => 45,
                            'summary' => 'Isolate broadcast domains using virtual local area networks on Cisco catalyst switches.',
                            'body' => '<h3>Cisco IOS Switch Commands</h3><pre><code>Switch# configure terminal&#10;Switch(config)# vlan 10&#10;Switch(config-vlan)# name ENGINEERING&#10;Switch(config-vlan)# exit&#10;Switch(config)# interface gigabitethernet0/1&#10;Switch(config-if)# switchport mode access&#10;Switch(config-if)# switchport access vlan 10</code></pre>',
                            'is_required' => true,
                        ],
                        [
                            'title' => 'Lesson 2.2: CCNA Network Architecture Guidebook',
                            'type' => 'file',
                            'duration' => 30,
                            'summary' => 'Comprehensive reference manual covering Cisco CLI commands, routing tables, and troubleshooting steps.',
                            'body' => '<h3>Reference Blueprint</h3><p>Download the standardized configuration cheat sheet for OSPF, BGP, and Access Control Lists.</p>',
                            'is_required' => false,
                        ],
                    ],
                ],
            ],

            'CRS-104' => [
                [
                    'module_number' => 1,
                    'title' => 'Module 1: User Research & Visual Design Systems (ការរចនា UI/UX)',
                    'desc' => 'User personas, accessibility heuristics (WCAG 2.1), color palettes, and typographic scale systems.',
                    'lessons' => [
                        [
                            'title' => 'Lesson 1.1: Design Systems Foundations & Design Tokens',
                            'type' => 'video',
                            'duration' => 30,
                            'summary' => 'Understand design tokens: color spaces, spacing units, border radiuses, and typographic hierarchies.',
                            'body' => '<h3>Building Systematic Interfaces</h3><p>Explore why global tech companies rely on strict design systems to scale user experience across web and mobile products.</p>',
                            'is_required' => true,
                        ],
                        [
                            'title' => 'Lesson 1.2: Figma Auto-Layout 5.0 & Responsive Component Design',
                            'type' => 'lesson',
                            'duration' => 45,
                            'summary' => 'Master nested Auto-Layout containers, min/max constraints, component variants, and interactive states.',
                            'body' => '<h3>Figma Component Architecture</h3><p>Learn how to create reusable button sets, input fields, cards, and navigation bars that adapt fluidly to any screen width.</p>',
                            'is_required' => true,
                        ],
                    ],
                ],
                [
                    'module_number' => 2,
                    'title' => 'Module 2: Interactive Prototyping & Developer Handoff',
                    'desc' => 'Micro-interactions, smart animate transitions, Figma variables, and developer inspection documentation.',
                    'lessons' => [
                        [
                            'title' => 'Lesson 2.1: Advanced Figma Variables & Micro-Interactions',
                            'type' => 'video',
                            'duration' => 40,
                            'summary' => 'Build high-fidelity prototypes with conditional logic, variable state switches, and fluid transitions.',
                            'body' => '<h3>High-Fidelity Interaction Design</h3><p>Bring mockups to life using realistic click events, modal animations, and dynamic state switching with Figma variables.</p>',
                            'is_required' => true,
                        ],
                        [
                            'title' => 'Lesson 2.2: Capstone Design Challenge: Dark Cyber E-Learning UI',
                            'type' => 'assignment',
                            'duration' => 60,
                            'summary' => 'Design an interactive e-learning student dashboard in Figma featuring dark glassmorphism styling.',
                            'body' => '<h3>Design Challenge Guidelines</h3><p>Design a 3-screen prototype (Dashboard, Course Catalog, Video Lesson Player) applying modern dark mode aesthetics and accessible typography.</p>',
                            'is_required' => true,
                            'max_score' => 100,
                            'passing_score' => 80,
                        ],
                    ],
                ],
            ],

            'CRS-105' => [
                [
                    'module_number' => 1,
                    'title' => 'Module 1: REST API Protocols & Request Lifecycle',
                    'desc' => 'HTTP request lifecycle, status codes, idempotent verbs (GET/PUT/DELETE), and JSON payloads.',
                    'lessons' => [
                        [
                            'title' => 'Lesson 1.1: REST Architectural Constraints & Clean URL Design',
                            'type' => 'video',
                            'duration' => 30,
                            'summary' => 'Master REST principles: statelessness, resource identification, representation, and HATEOAS.',
                            'body' => '<h3>REST Architectural Patterns</h3><p>Explore standard REST URL naming conventions, query parameter filtering, and payload structures.</p>',
                            'is_required' => true,
                        ],
                        [
                            'title' => 'Lesson 1.2: Error Handling Middleware & Standard HTTP Status Codes',
                            'type' => 'lesson',
                            'duration' => 35,
                            'summary' => 'Handle 400, 401, 403, 404, 422, and 500 exceptions with consistent JSON error response schemas.',
                            'body' => '<h3>Predictable API Error Handling</h3><p>Prevent sensitive stack traces from leaking to clients. Wrap exceptions in unified error envelopes.</p>',
                            'is_required' => true,
                        ],
                    ],
                ],
                [
                    'module_number' => 2,
                    'title' => 'Module 2: Token Authentication, Rate Limiting & OpenAPI',
                    'desc' => 'Token authentication with Laravel Sanctum, throttle middleware, and Swagger documentation generation.',
                    'lessons' => [
                        [
                            'title' => 'Lesson 2.1: Rate Limiting & Throttling Defense Against DDoS',
                            'type' => 'video',
                            'duration' => 35,
                            'summary' => 'Configure Redis-backed rate limiting algorithms (Token Bucket / Leaky Bucket) to protect APIs.',
                            'body' => '<h3>API Traffic Control</h3><p>Implement rate limit headers: <code>X-RateLimit-Limit</code> and <code>X-RateLimit-Remaining</code> to protect resources from abuse.</p>',
                            'is_required' => true,
                        ],
                    ],
                ],
            ],

            'CRS-106' => [
                [
                    'module_number' => 1,
                    'title' => 'Module 1: Flutter Framework & Dart Language Fundamentals',
                    'desc' => 'Widget tree architecture, Stateless vs Stateful widgets, layout composition, and Dart async/await.',
                    'lessons' => [
                        [
                            'title' => 'Lesson 1.1: The Flutter Rendering Engine & Widget Tree',
                            'type' => 'video',
                            'duration' => 40,
                            'summary' => 'Discover how Flutter compiles directly to ARM native code using the Skia/Impeller graphics engine.',
                            'body' => '<h3>Flutter Architecture</h3><p>In Flutter, everything is a widget. Learn how the RenderObject pipeline achieves 60fps/120fps smooth animations.</p>',
                            'is_required' => true,
                        ],
                        [
                            'title' => 'Lesson 1.2: Reactive State Management with Provider & BLoC',
                            'type' => 'lesson',
                            'duration' => 45,
                            'summary' => 'Separate business logic from presentation UI using reactive streams and immutable states.',
                            'body' => '<h3>State Management Patterns</h3><p>Compare Provider, Riverpod, and BLoC for production mobile architectures.</p>',
                            'is_required' => true,
                        ],
                    ],
                ],
            ],

            'CRS-107' => [
                [
                    'module_number' => 1,
                    'title' => 'Module 1: Docker Containers & Multi-Stage Production Builds',
                    'desc' => 'Dockerfiles, layer caching, alpine base images, docker-compose networking, and volume persistence.',
                    'lessons' => [
                        [
                            'title' => 'Lesson 1.1: Docker Containerization for Full-Stack Applications',
                            'type' => 'video',
                            'duration' => 45,
                            'summary' => 'Package PHP-FPM, Nginx, and Node build environments into immutable Docker containers.',
                            'body' => '<h3>Multi-Stage Dockerfile Optimization</h3><p>Drastically reduce container size from 1.2GB down to 65MB using multi-stage alpine builds.</p><pre><code>FROM node:20-alpine AS builder&#10;WORKDIR /app&#10;COPY package*.json ./&#10;RUN npm ci&#10;COPY . .&#10;RUN npm run build&#10;&#10;FROM nginx:alpine&#10;COPY --from=builder /app/dist /usr/share/nginx/html</code></pre>',
                            'is_required' => true,
                        ],
                        [
                            'title' => 'Lesson 1.2: Automated CI/CD Pipelines with GitHub Actions',
                            'type' => 'lesson',
                            'duration' => 50,
                            'summary' => 'Build automated continuous integration workflows that test, lint, and deploy upon git push.',
                            'body' => '<h3>Continuous Deployment Pipeline</h3><p>Learn to write GitHub Actions YAML configuration files that run PHPUnit, ESLint, and deploy to cloud VPS instances.</p>',
                            'is_required' => true,
                        ],
                    ],
                ],
            ],
        ];

        $totalLessonsCreated = 0;
        $videoIndex = 0;

        foreach ($curriculumMap as $courseCode => $modulesData) {
            $course = $courseModels[$courseCode] ?? null;
            if (!$course) {
                continue;
            }

            foreach ($modulesData as $mIndex => $m) {
                $module = CourseModule::updateOrCreate(
                    [
                        'course_id' => $course->course_id,
                        'module_number' => $m['module_number'],
                    ],
                    [
                        'title' => $m['title'],
                        'description' => $m['desc'],
                    ]
                );

                foreach ($m['lessons'] as $lIndex => $l) {
                    $position = $lIndex + 1;
                    $slug = Str::slug($courseCode . '-m' . $m['module_number'] . '-l' . $position . '-' . Str::limit($l['title'], 40, ''));
                    $chosenVideoUrl = $l['type'] === 'video' ? $sampleVideos[$videoIndex % count($sampleVideos)] : null;
                    if ($l['type'] === 'video') {
                        $videoIndex++;
                    }

                    $metadata = [
                        'thumbnail' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&q=80',
                        'learning' => [
                            'is_required' => $l['is_required'] ?? false,
                            'track_progress' => true,
                            'auto_complete' => false,
                            'unlock_next' => true,
                            'completion_type' => $l['type'] === 'video' ? 'watch_minimum' : 'manual_button',
                            'minimum_watch_percentage' => 85,
                        ],
                        'video' => [
                            'source' => 'html5',
                            'url' => $chosenVideoUrl,
                            'transcript' => 'Welcome to this in-depth engineering session. Today we cover critical concepts and practical workflows.',
                        ],
                        'quiz' => isset($l['max_score']) ? [
                            'maximum_score' => $l['max_score'],
                            'passing_score' => $l['passing_score'] ?? 70,
                            'shuffle_questions' => true,
                            'allow_retake' => true,
                        ] : [],
                        'assignment' => $l['type'] === 'assignment' ? [
                            'maximum_score' => $l['max_score'] ?? 100,
                            'passing_score' => $l['passing_score'] ?? 70,
                            'allow_late_submission' => true,
                        ] : [],
                        'publishing' => [
                            'status' => 'published',
                            'publish_date' => now()->subDays(10)->toDateString(),
                            'publish_time' => '08:00',
                            'published_by' => 'System Admin',
                        ],
                    ];

                    $validTypes = ['lesson', 'page', 'video', 'file', 'url', 'assignment', 'quiz', 'forum'];
                    $contentType = in_array($l['type'], $validTypes, true) ? $l['type'] : ($l['type'] === 'document' ? 'file' : 'lesson');

                    $lesson = ContentLesson::updateOrCreate(
                        [
                            'course_id' => $course->course_id,
                            'slug' => $slug,
                        ],
                        [
                            'course_module_id' => $module->course_module_id,
                            'module_number' => $module->module_number,
                            'module_title' => $module->title,
                            'title' => $l['title'],
                            'content_type' => $contentType,
                            'summary' => $l['summary'],
                            'body' => $l['body'],
                            'video_url' => $chosenVideoUrl,
                            'duration_minutes' => $l['duration'],
                            'position' => $position,
                            'completion_required' => $l['is_required'] ?? false,
                            'visibility' => 'visible', // Valid values: 'visible', 'hidden', 'scheduled'
                            'max_score' => $l['max_score'] ?? null,
                            'passing_score' => $l['passing_score'] ?? null,
                            'allow_comments' => true,
                            'metadata' => $metadata,
                            'is_published' => true,
                            'available_from' => now()->subDays(30),
                        ]
                    );

                    $totalLessonsCreated++;

                    // Seed auxiliary tables for rich testing
                    // 1. Content Chapters
                    DB::table('content_chapters')->updateOrInsert(
                        ['content_lesson_id' => $lesson->content_lesson_id, 'sort_order' => 1],
                        [
                            'title' => 'Part 1: Theoretical Overview & Principles',
                            'summary' => 'Introduction to core concepts and background analysis.',
                            'content' => '<p>Detailed lecture notes covering the underlying science and operational mechanisms.</p>',
                            'is_published' => true,
                            'updated_at' => now(),
                            'created_at' => now(),
                        ]
                    );
                    DB::table('content_chapters')->updateOrInsert(
                        ['content_lesson_id' => $lesson->content_lesson_id, 'sort_order' => 2],
                        [
                            'title' => 'Part 2: Practical Walkthrough & Verification',
                            'summary' => 'Hands-on console demonstrations and error mitigation steps.',
                            'content' => '<p>Step-by-step practical implementation guidelines with code review highlights.</p>',
                            'is_published' => true,
                            'updated_at' => now(),
                            'created_at' => now(),
                        ]
                    );

                    // 2. Content Video (if video type)
                    if ($chosenVideoUrl) {
                        DB::table('content_videos')->updateOrInsert(
                            ['content_lesson_id' => $lesson->content_lesson_id],
                            [
                                'title' => $lesson->title,
                                'description' => $lesson->summary,
                                'video_url' => $chosenVideoUrl,
                                'duration_seconds' => $lesson->duration_minutes * 60,
                                'sort_order' => 1,
                                'is_published' => true,
                                'updated_at' => now(),
                                'created_at' => now(),
                            ]
                        );
                    }

                    // 3. Content Documents & Cheat Sheets
                    DB::table('content_documents')->updateOrInsert(
                        ['content_lesson_id' => $lesson->content_lesson_id, 'title' => 'Lecture Slide Deck (PDF)'],
                        [
                            'description' => 'Comprehensive visual slides and architecture diagrams for ' . $lesson->title,
                            'file_path' => 'content/documents/lecture_notes_' . $lesson->content_lesson_id . '.pdf',
                            'sort_order' => 1,
                            'is_published' => true,
                            'updated_at' => now(),
                            'created_at' => now(),
                        ]
                    );

                    // 4. Content Resources (Documentation links)
                    DB::table('content_resources')->updateOrInsert(
                        ['content_lesson_id' => $lesson->content_lesson_id, 'title' => 'Official Framework Documentation'],
                        [
                            'description' => 'Authoritative references and community guidelines.',
                            'external_url' => 'https://vuejs.org/guide/introduction.html',
                            'sort_order' => 1,
                            'is_published' => true,
                            'updated_at' => now(),
                            'created_at' => now(),
                        ]
                    );
                }
            }
        }

        // ---------------------------------------------------------------------
        // 10. Student Enrollments
        // ---------------------------------------------------------------------
        $enrollmentPlan = [
            ['stu' => 'STU-1001', 'crs' => 'CRS-101', 'status' => 'studying', 'days' => 3],
            ['stu' => 'STU-1001', 'crs' => 'CRS-102', 'status' => 'studying', 'days' => 12],
            ['stu' => 'STU-1001', 'crs' => 'CRS-104', 'status' => 'completed', 'days' => 45],
            ['stu' => 'STU-1002', 'crs' => 'CRS-101', 'status' => 'studying', 'days' => 5],
            ['stu' => 'STU-1002', 'crs' => 'CRS-103', 'status' => 'studying', 'days' => 18],
            ['stu' => 'STU-1003', 'crs' => 'CRS-101', 'status' => 'completed', 'days' => 60],
            ['stu' => 'STU-1003', 'crs' => 'CRS-105', 'status' => 'studying', 'days' => 8],
            ['stu' => 'STU-1004', 'crs' => 'CRS-102', 'status' => 'studying', 'days' => 14],
            ['stu' => 'STU-1004', 'crs' => 'CRS-104', 'status' => 'studying', 'days' => 4],
            ['stu' => 'STU-1005', 'crs' => 'CRS-103', 'status' => 'studying', 'days' => 9],
            ['stu' => 'STU-1005', 'crs' => 'CRS-107', 'status' => 'studying', 'days' => 2],
            ['stu' => 'STU-1006', 'crs' => 'CRS-106', 'status' => 'studying', 'days' => 10],
            ['stu' => 'STU-1006', 'crs' => 'CRS-101', 'status' => 'studying', 'days' => 1],
            ['stu' => 'STU-1007', 'crs' => 'CRS-102', 'status' => 'completed', 'days' => 30],
            ['stu' => 'STU-1008', 'crs' => 'CRS-104', 'status' => 'studying', 'days' => 7],
        ];

        foreach ($enrollmentPlan as $ep) {
            $student = $studentModels[$ep['stu']] ?? null;
            $course = $courseModels[$ep['crs']] ?? null;

            if ($student && $course) {
                Enrollment::updateOrCreate(
                    [
                        'student_id' => $student->student_id,
                        'course_id' => $course->course_id,
                    ],
                    [
                        'class_room_id' => $classRoomIds['LAB-101'] ?? null,
                        'academic_year_id' => $ay2025->academic_year_id,
                        'semester_id' => $sem1Id,
                        'enrollment_date' => now()->subDays($ep['days'])->toDateString(),
                        'status' => $ep['status'],
                        'note' => 'Enrolled via LMS student self-service portal.',
                    ]
                );
            }
        }

        // ---------------------------------------------------------------------
        // 11. Discussion Forum Posts & Interactive Replies
        // ---------------------------------------------------------------------
        $primaryCourse = $courseModels['CRS-101'] ?? null;
        if ($primaryCourse) {
            $firstLesson = ContentLesson::where('course_id', $primaryCourse->course_id)->first();
            $demoStudentUser = User::where('email', 'student@example.com')->first() ?? $adminUser;
            $demoTeacherUser = User::where('email', 'teacher@example.com')->first() ?? $adminUser;

            $post1 = DB::table('discussion_posts')->where('course_id', $primaryCourse->course_id)->where('title', 'Handling Token Expiry in Axios Interceptor')->first();
            if (!$post1) {
                $post1Id = DB::table('discussion_posts')->insertGetId([
                    'course_id' => $primaryCourse->course_id,
                    'content_lesson_id' => $firstLesson?->content_lesson_id,
                    'user_id' => $demoStudentUser->id,
                    'title' => 'Handling Token Expiry in Axios Interceptor',
                    'body' => 'Hi instructor, what is the best practice for detecting 401 unauthenticated errors and clearing Pinia auth state when a Sanctum token expires?',
                    'status' => 'published',
                    'is_pinned' => true,
                    'created_at' => now()->subDays(2),
                    'updated_at' => now()->subDays(2),
                ], 'discussion_post_id');

                DB::table('discussion_comments')->insert([
                    [
                        'discussion_post_id' => $post1Id,
                        'parent_comment_id' => null,
                        'user_id' => $demoTeacherUser->id,
                        'body' => 'Great question! In your axios response interceptor, intercept 401 errors, call authStore.logout(), and use router.push("/login?redirect=" + currentPath) to direct the student back after re-authenticating.',
                        'status' => 'published',
                        'created_at' => now()->subDays(1),
                        'updated_at' => now()->subDays(1),
                    ],
                    [
                        'discussion_post_id' => $post1Id,
                        'parent_comment_id' => null,
                        'user_id' => $demoStudentUser->id,
                        'body' => 'Thank you teacher Sovann! That makes total sense and works seamlessly now in our Vue router guards.',
                        'status' => 'published',
                        'created_at' => now()->subHours(8),
                        'updated_at' => now()->subHours(8),
                    ],
                ]);
            }
        }
    }
}
