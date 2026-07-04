<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\BehaviourRecordController;
use App\Http\Controllers\ConsentLetterController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IEPGoalController;
use App\Http\Controllers\IEPReviewController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MockupPageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ParentRegistrationController;
use App\Http\Controllers\ParentStudentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgressRecordController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherStudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.submit');

Route::get('/parent/register', [ParentRegistrationController::class, 'create'])
    ->name('parent.register');

Route::post('/parent/register', [ParentRegistrationController::class, 'store'])
    ->name('parent.register.store');

Route::get('/language/{locale}', [LanguageController::class, 'change'])
    ->name('language.switch');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::post('/profile-picture', [DashboardController::class, 'updateProfilePicture'])
        ->name('profile.picture');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markRead'])
        ->name('notifications.read');

    /*
    |--------------------------------------------------------------------------
    | School Administrator and System Administrator
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:school_admin,system_admin')->group(function () {
        Route::resource('students', StudentController::class);
        Route::resource('users', UserController::class)->except('show');
    });

    /*
    |--------------------------------------------------------------------------
    | School Administrator
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:school_admin')->group(function () {
        Route::get('/assign-staff', [AssignmentController::class, 'index'])
            ->name('assign.staff');

        Route::post('/assign-staff', [AssignmentController::class, 'store'])
            ->name('assign.staff.store');
    });

    /*
    |--------------------------------------------------------------------------
    | Teacher
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:teacher')
        ->prefix('teacher')
        ->name('teacher.')
        ->group(function () {
            Route::get('/students', [TeacherStudentController::class, 'index'])
                ->name('students.index');

            Route::get('/students/{student}', [TeacherStudentController::class, 'show'])
                ->name('students.show');
        });

    /*
    |--------------------------------------------------------------------------
    | Counsellor
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:counsellor')
        ->prefix('counsellor')
        ->name('counsellor.')
        ->group(function () {
            Route::get('/students', [StudentController::class, 'index'])
                ->name('students.index');

            Route::get('/students/{student}', [StudentController::class, 'show'])
                ->name('students.show');
        });

    /*
    |--------------------------------------------------------------------------
    | Parent or Guardian
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:parent')
        ->prefix('parent')
        ->name('parent.')
        ->group(function () {
            Route::get('/students', [ParentStudentController::class, 'index'])
                ->name('students.index');

            Route::get('/students/{student}', [ParentStudentController::class, 'show'])
                ->name('students.show');

            Route::get('/iep', [ParentStudentController::class, 'iep'])
                ->name('iep');

            Route::get('/progress', [ParentStudentController::class, 'progress'])
                ->name('progress');

            Route::get('/behaviour', [ParentStudentController::class, 'behaviour'])
                ->name('behaviour');
        });

    /*
    |--------------------------------------------------------------------------
    | Teacher and School Administrator
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:teacher,school_admin')->group(function () {
        Route::resource('goals', IEPGoalController::class);
        Route::resource('behaviours', BehaviourRecordController::class);
        Route::resource('progress', ProgressRecordController::class);

        Route::get('/intervention-plan', [MockupPageController::class, 'interventionPlan'])
            ->name('intervention.plan');
    });

    /*
    |--------------------------------------------------------------------------
    | Counsellor and School Administrator
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:counsellor,school_admin')->group(function () {
        Route::resource('consultations', ConsultationController::class);
        Route::resource('reviews', IEPReviewController::class);

        Route::get('/support-plan', [MockupPageController::class, 'supportPlan'])
            ->name('support.plan');
    });

    /*
    |--------------------------------------------------------------------------
    | Parent Consent
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:parent')->group(function () {
        Route::resource('consents', ConsentLetterController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | Automated Reward Calculation (FR8)
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:school_admin,teacher,counsellor,parent')->group(function () {
        Route::get('/rewards', [RewardController::class, 'index'])
            ->name('rewards.index');
    });

    /*
    |--------------------------------------------------------------------------
    | Reports
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:school_admin,teacher,parent')->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])
            ->name('reports.index');

        Route::get('/reports/print', [ReportController::class, 'print'])
            ->name('reports.print');

        Route::get('/reports/consent-pdf', [ReportController::class, 'consentPdf'])
            ->name('reports.consent.pdf');
    });

    /*
    |--------------------------------------------------------------------------
    | System Administrator
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:system_admin')->group(function () {
        Route::get('/roles', [MockupPageController::class, 'roles'])
            ->name('roles.index');

        Route::get('/system-settings', [MockupPageController::class, 'systemSettings'])
            ->name('system.settings');

        Route::get('/backup', [BackupController::class, 'index'])
            ->name('backup.index');

        Route::post('/backup', [BackupController::class, 'store'])
            ->name('backup.store');
    });
});