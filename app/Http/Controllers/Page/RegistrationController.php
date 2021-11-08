<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RegistrationController extends Controller
{
    public function onprocessed(){
        if (!auth()->user()->can('view registration')) {
            return abort(401);
        }
        return Inertia::render('Admin/EnrollmentApplication/Registration/OnProcess');
    }
    public function issueIDNumber(){
        if (!auth()->user()->can('view registration')) {
            return abort(401);
        }
        return Inertia::render('Admin/EnrollmentApplication/Application/Pending');
    }
    public function IDInformation(){
        if (!auth()->user()->can('view registration')) {
            return abort(401);
        }
        return Inertia::render('Admin/EnrollmentApplication/StudentWelfare/IDInformation.vue');
    }
    public function toconfirm(){
        if (!auth()->user()->can('view registration')) {
            return abort(401);
        }
        return Inertia::render('Admin/EnrollmentApplication/Registration/ToConfirm');
    }
    public function complete(){
        if (!auth()->user()->can('view registration')) {
            return abort(401);
        }
        return Inertia::render('Admin/EnrollmentApplication/Registration/Complete');
    }
    public function pending(){
        if (!auth()->user()->can('view registration')) {
            return abort(401);
        }
        return Inertia::render('Admin/EnrollmentApplication/Registration/Pending');
    }
    public function medicalRecord(){
        if (!auth()->user()->can('view medical-record')) {
            return abort(401);
        }
        return Inertia::render('Admin/EnrollmentApplication/Medical/Pending');
    }
}
