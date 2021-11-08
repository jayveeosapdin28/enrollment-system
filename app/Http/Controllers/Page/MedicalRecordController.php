<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\EnrollmentApplication;
use App\Models\MedicalAnswer;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MedicalRecordController extends Controller
{
    public function index(){
        return Inertia::render('Student/MedicalRecord/Index');
    }
    public function show($id){
        if (!auth()->user()->can('view medical-record')) {
            return abort(401);
        }
        $medical_record = MedicalAnswer::where('user_id',$id)->get();
        $student = EnrollmentApplication::with(['user:id,name','program'])
            ->where('user_id',$id)->firstOrFail();

        return Inertia::render('Admin/EnrollmentApplication/Medical/MedicalRecord',[
            'student' => $student,
            'medical_record' => $medical_record
        ]);
    }
}
