<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AccountController extends Controller
{
    public function index(){
        return Inertia::render('Student/Account/Index',[
            'sessions' => $this->sessions()->all(),
        ]);
    }
}
