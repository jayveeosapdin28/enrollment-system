<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PendingStudentController extends Controller
{
    public function index(){
        if (!auth()->user()->can('view registration')) {
            return abort(401);
        }
        return Inertia::render('Admin/IDNumber/Index');
    }
}
