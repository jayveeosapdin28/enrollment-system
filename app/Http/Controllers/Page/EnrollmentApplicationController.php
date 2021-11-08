<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\EnrollmentApplication;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EnrollmentApplicationController extends Controller
{
    public function index(){
        return Inertia::render('Admin/EnrollmentApplication/Index');
    }
    public function qualifiers(){
        return Inertia::render('Admin/EnrollmentApplication/Qualifiers');
    }

}
