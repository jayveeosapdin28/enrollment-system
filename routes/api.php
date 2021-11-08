<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ReligionController;
use App\Http\Controllers\Api\V1\BarangayController;
use App\Http\Controllers\Api\V1\CityController;
use App\Http\Controllers\Api\V1\ProvinceController;
use App\Http\Controllers\Api\V1\CourseController;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\StudentPersonalInfoController;
use App\Http\Controllers\Api\V1\ContactController;
use App\Http\Controllers\Api\V1\AddressDetailsController;
use App\Http\Controllers\Api\V1\EducationalBackgroundController;
use App\Http\Controllers\Api\V1\FamilyInformationController;
use App\Http\Controllers\Api\V1\AdditionalInformationController;
use App\Http\Controllers\Api\V1\EnrollmentApplicationController;
use App\Http\Controllers\Api\V1\EnrollmentHistoryController;
use App\Http\Controllers\Api\V1\PendingApplicationController;
use App\Http\Controllers\Api\V1\SubjectController;
use App\Http\Controllers\Api\V1\EnrollSubjectController;
use App\Http\Controllers\Api\V1\EnrolledSubjectController;
use App\Http\Controllers\Api\V1\AssessmentController;
use App\Http\Controllers\Api\V1\FeeController;
use App\Http\Controllers\Api\V1\RegistrationController;
use App\Http\Controllers\Api\V1\DashboardController;
use App\Http\Controllers\Api\V1\MedicalQuestionController;
use App\Http\Controllers\Api\V1\MedicalInformationController;
use App\Http\Controllers\Api\V1\SignatureController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('V1')->name('api.')->middleware(['auth:sanctum'])->group(function (){
    Route::post('auth', [AuthController::class, 'login'])->name('auth.login');
    Route::apiResources([
        'religions' => ReligionController::class,
        'courses' => CourseController::class,
    ]);
    Route::prefix('student')->name('student.')->group(function (){
        Route::apiResources(
            [
                'student-infos' => StudentPersonalInfoController::class,
                'contacts' => ContactController::class,
                'addresses' => AddressDetailsController::class,
                'educational-backgrounds' => EducationalBackgroundController::class,
                'family-information' => FamilyInformationController::class,
                'additional-informations' => AdditionalInformationController::class,
                'enrollment-applications' => EnrollmentApplicationController::class,
                'enrollment-history' => EnrollmentHistoryController::class,
                'subjects' => SubjectController::class,
                'medical-information' => MedicalInformationController::class,
                'medical-questions' => MedicalQuestionController::class,
                'signature' => SignatureController::class,
            ]
        );

        Route::get('enrollment-applications/destroy/{id}',[EnrollmentApplicationController::class,'destroy'])->name('enrollment-applications.destroy');
    });
    Route::prefix('admin')->name('admin.')->group(function (){
        Route::apiResources(
            [
                'dashboard' => DashboardController::class,
            ]
        );
        Route::prefix('enrollment-application')->name('enrollment-application.')->group(function (){
            Route::apiResources(
                [
                    'pending' => PendingApplicationController::class,
                    'assessment' => AssessmentController::class,
                    'fees' => FeeController::class,
                ]
            );
            Route::get('registration/generate-id-number/{id}',[RegistrationController::class,'generateIDNumber'])->name('registration.generate-id-number');
            Route::get('registration',[RegistrationController::class,'index'])->name('registration');
            Route::prefix('registration')->name('registration.')->group(function (){
                Route::get('assessments/get-assessment/{id}',[AssessmentController::class,'getAssessment'])->name('enrollment-application.registration.assessments.get-assessment');
                Route::get('on-process',[RegistrationController::class,'onProcess'])->name('on-process');
                Route::get('complete',[RegistrationController::class,'complete'])->name('complete');
                Route::get('confirm/{id}',[RegistrationController::class,'confirmRegistration'])->name('confirm');
                Route::get('cancel/{id}',[RegistrationController::class,'cancelRegistration'])->name('cancel');
            });
        });
        Route::apiResources(
            [
                'enroll-subjects' => EnrollSubjectController::class,
                'enrolled-subjects' => EnrolledSubjectController::class,
            ]
        );
        Route::get('enrolled-subject/destroy/{id}',[EnrolledSubjectController::class,'destroy'])->name('enrolled-subject.destroy');
    });
    Route::prefix('address')->name('address.')->group(function(){
        Route::apiResources([
            'barangays' => BarangayController::class,
            'cities' => CityController::class,
            'provinces' => ProvinceController::class,
        ]);
    });
});
