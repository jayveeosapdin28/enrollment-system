<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\EnrollmentApplication;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EnrollSubjectController extends Controller
{
    public function show($id){
        if (!auth()->user()->can('view registration')) {
            return abort(401);
        }
        $student = EnrollmentApplication::with(['user:id,name','program'])
            ->where('user_id',$id)->firstOrFail();
        return Inertia::render('Admin/EnrollmentApplication/EnrollSubject',[
            'student' => $student
        ]);
    }
}
