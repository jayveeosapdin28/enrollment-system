<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AcademicsController extends Controller
{
    public function index(){
        return Inertia::render('Student/Academic/Index');
    }
}
