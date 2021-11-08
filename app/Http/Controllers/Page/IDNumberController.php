<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IDNumberController extends Controller
{
    public function index(){
        return Inertia::render('Admin/IDNumber/Index');
    }
}
