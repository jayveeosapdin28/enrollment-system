<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\EnrolledSubject;
use App\Models\EnrollmentApplication;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AssessmentController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('view fee')) {
            return abort(401);
        }
        return Inertia::render('Admin/EnrollmentApplication/StudentAssessment');
    }

    public function fees($id)
    {
        if (!auth()->user()->can('view fee')) {
            return abort(401);
        }

        $application = EnrollmentApplication::with(['user:id,name', 'program', 'subject_enrolled:id,subunit,subfee'])
            ->where('user_id', $id)
            ->firstOrFail();
        return Inertia::render('Admin/EnrollmentApplication/FeeAssessment', [
            'application' => $application
        ]);
    }

    public function pending()
    {
        if (!auth()->user()->can('view fee')) {
            return abort(401);
        }
        return Inertia::render('Admin/EnrollmentApplication/Assessment/Pending');
    }

    public function processed()
    {
        if (!auth()->user()->can('view fee')) {
            return abort(401);
        }
        return Inertia::render('Admin/EnrollmentApplication/Assessment/Processed');
    }
}
