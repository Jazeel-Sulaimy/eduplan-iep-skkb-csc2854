<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.system_title') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>
    <div class="app">
        <aside class="sidebar">
            <div class="school-brand">
                <img src="{{ asset('assets/images/logo-sekolah.jpg') }}" alt="School Logo" onerror="this.style.display='none'">
                <h2>EduPlan</h2>
                <p>Sekolah Kebangsaan<br>Kuala Berang</p>
            </div>

            <div class="profile-mini">
                @if(auth()->user()->profile_picture)
                    <img class="profile-img" src="{{ asset(auth()->user()->profile_picture) }}" alt="{{ __('messages.profile_picture') }}">
                @else
                    <div class="profile-placeholder">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                @endif

                <strong>{{ auth()->user()->name }}</strong>
                <small>{{ auth()->user()->roleLabel() }}</small>

                <form method="POST" action="{{ route('profile.picture') }}" enctype="multipart/form-data" class="profile-upload">
                    @csrf
                    <label class="upload-btn">
                        {{ __('messages.change_photo') }}
                        <input type="file" name="profile_picture" accept="image/png,image/jpeg" onchange="this.form.submit()">
                    </label>
                </form>
            </div>

            @php
                $role = auth()->user()->role;
                $menus = [
                    'school_admin' => [
                        ['label' => __('messages.dashboard'), 'route' => 'dashboard', 'active' => 'dashboard'],
                        ['label' => __('messages.register_student'), 'route' => 'students.create', 'active' => 'students.create'],
                        ['label' => __('messages.student_list'), 'route' => 'students.index', 'active' => 'students.*'],
                        ['label' => __('messages.manage_users'), 'route' => 'users.index', 'active' => 'users.*'],
                        ['label' => __('messages.assign_staff'), 'route' => 'assign.staff', 'active' => 'assign.staff*'],
                        ['label' => __('messages.behaviour_status'), 'route' => 'behaviours.index', 'active' => 'behaviours.*'],
                        ['label' => __('messages.automated_reward_calculation'), 'route' => 'rewards.index', 'active' => 'rewards.*'],
                        ['label' => __('messages.iep_status'), 'route' => 'reviews.index', 'active' => 'reviews.*'],
                        ['label' => __('messages.generate_report'), 'route' => 'reports.index', 'active' => 'reports.*'],
                    ],
                    'teacher' => [
                        ['label' => __('messages.dashboard'), 'route' => 'dashboard', 'active' => 'dashboard'],
                        ['label' => __('messages.my_students'), 'route' => 'teacher.students.index', 'active' => 'teacher.students.*'],
                        ['label' => __('messages.behaviour_status'), 'route' => 'behaviours.index', 'active' => 'behaviours.*'],
                        ['label' => __('messages.automated_reward_calculation'), 'route' => 'rewards.index', 'active' => 'rewards.*'],
                        ['label' => __('messages.pre_meeting_form'), 'route' => 'goals.index', 'active' => 'goals.index'],
                        ['label' => __('messages.iep_form'), 'route' => 'goals.create', 'active' => 'goals.create'],
                        ['label' => __('messages.intervention_plan'), 'route' => 'intervention.plan', 'active' => 'intervention.plan'],
                        ['label' => __('messages.progress_status'), 'route' => 'progress.index', 'active' => 'progress.*'],
                        ['label' => __('messages.generate_report'), 'route' => 'reports.index', 'active' => 'reports.*'],
                    ],
                    'counsellor' => [
                        ['label' => __('messages.dashboard'), 'route' => 'dashboard', 'active' => 'dashboard'],
                        ['label' => __('messages.student_case'), 'route' => 'consultations.index', 'active' => 'consultations.*'],
                        ['label' => __('messages.reward_summary'), 'route' => 'rewards.index', 'active' => 'rewards.*'],
                        ['label' => __('messages.notes'), 'route' => 'consultations.create', 'active' => 'consultations.create'],
                        ['label' => __('messages.support_plan'), 'route' => 'support.plan', 'active' => 'support.plan'],
                        ['label' => __('messages.review'), 'route' => 'reviews.index', 'active' => 'reviews.*'],
                    ],
                    'parent' => [
                        ['label' => __('messages.dashboard'), 'route' => 'dashboard', 'active' => 'dashboard'],
                        ['label' => __('messages.my_children'), 'route' => 'parent.students.index', 'active' => 'parent.students.*'],
                        ['label' => __('messages.iep'), 'route' => 'parent.iep', 'active' => 'parent.iep'],
                        ['label' => __('messages.progress_summary'), 'route' => 'parent.progress', 'active' => 'parent.progress'],
                        ['label' => __('messages.behaviour_summary'), 'route' => 'parent.behaviour', 'active' => 'parent.behaviour'],
                        ['label' => __('messages.reward_summary'), 'route' => 'rewards.index', 'active' => 'rewards.*'],
                        ['label' => __('messages.consent_letter'), 'route' => 'consents.index', 'active' => 'consents.*'],
                        ['label' => __('messages.report'), 'route' => 'reports.index', 'active' => 'reports.*'],
                    ],
                    'system_admin' => [
                        ['label' => __('messages.dashboard'), 'route' => 'dashboard', 'active' => 'dashboard'],
                        ['label' => __('messages.system_users'), 'route' => 'users.index', 'active' => 'users.*'],
                        ['label' => __('messages.roles'), 'route' => 'roles.index', 'active' => 'roles.index'],
                        ['label' => __('messages.backup'), 'route' => 'backup.index', 'active' => 'backup.*'],
                        ['label' => __('messages.epkb_system'), 'route' => 'system.settings', 'active' => 'system.settings'],
                    ],
                ];
            @endphp

            <nav>
                @foreach($menus[$role] ?? [] as $menu)
                    <a href="{{ route($menu['route']) }}" class="{{ request()->routeIs($menu['active']) ? 'active' : '' }}">
                        {{ $menu['label'] }}
                    </a>
                @endforeach
            </nav>

            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit">{{ strtoupper(__('messages.logout')) }}</button>
            </form>
        </aside>

        <main class="main">
            <div class="content">
                @if(session('success'))
                    <div class="success">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="error-box">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
    @include('partials.auto-translator')
</body>
</html>
