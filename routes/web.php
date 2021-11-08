<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Page\ProfileController;
use App\Http\Controllers\Page\MedicalRecordController;
use App\Http\Controllers\Page\ScholarshipController;
use App\Http\Controllers\Page\AcademicsController;
use App\Http\Controllers\Page\EnrollmentController;
use App\Http\Controllers\Page\AccountController;
use App\Http\Controllers\Page\EnrollmentApplicationController;
use App\Http\Controllers\Page\EnrollSubjectController;
use App\Http\Controllers\Page\AssessmentController;
use App\Http\Controllers\Page\RegistrationController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');
Route::middleware(['auth:sanctum','verified'])->group(function (){
    Route::name('student.')->prefix('student')->group(function () {
        Route::resource('profile', ProfileController::class)->only('index');
        Route::resource('medical-record', MedicalRecordController::class)->only('index');
        Route::resource('scholarship', ScholarshipController::class)->only('index');
        Route::resource('academics', AcademicsController::class)->only('index');
        Route::resource('enrollment', EnrollmentController::class)->only('index');
        Route::resource('account', AccountController::class)->only('show');
    });
    Route::name('admin.')->prefix('admin')->group(function () {
        Route::name('enrollment-applications.')->prefix('enrollment-applications')->group(function () {
            Route::resource('pending', EnrollmentApplicationController::class)->only('index');
            Route::get('qualifiers', [EnrollmentApplicationController::class,'qualifiers'])->name('qualifiers');
            Route::resource('enroll-subjects', EnrollSubjectController::class)->only('index','show');

            Route::name('assessments.')->prefix('assessments')->group(function () {
                Route::get('pending', [AssessmentController::class,'pending'])->name('pending');
                Route::get('processed', [AssessmentController::class,'processed'])->name('processed');
                Route::get('fees/{id}', [AssessmentController::class,'fees'])->name('fees');
            });
            Route::name('registrations.')->prefix('registrations')->group(function () {
                Route::get('on-process', [RegistrationController::class,'onprocessed'])->name('on-process');
                Route::get('to-confirm', [RegistrationController::class,'toconfirm'])->name('to-confirm');
                Route::get('complete', [RegistrationController::class,'complete'])->name('complete');
                Route::get('pending', [RegistrationController::class,'pending'])->name('pending');
                Route::get('issue-id', [RegistrationController::class,'issueIDNumber'])->name('issue-id');
                Route::get('medical-record', [RegistrationController::class,'medicalRecord'])->name('medical-record');
                Route::get('id-information', [RegistrationController::class,'IDInformation'])->name('id-information');
            });
            Route::name('medical-record.')->prefix('medical-record')->group(function () {
                Route::get('show/{id}', [MedicalRecordController::class,'show'])->name('show');
            });
        });
    });
});
