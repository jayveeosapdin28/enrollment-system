<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\EnrollmentApplication;
use Illuminate\Http\Request;
use App\Http\Resources\Dashboard as DashboardResources;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('view dashboard')) {
            return abort(401);
        }
        $applications = [];
        $perPage = $request->has('perPage') ? $request->input('perPage') : 10;
        $programs = Course::orderBy('cordesc','ASC')->get();
        foreach ($programs as $program){
            array_push($applications,[
                'name' =>  $program->cormajor === 'NONE' ?  $program->cordesc : $program->cordesc .' MAJOR IN '.$program->cormajor,
                'count' => EnrollmentApplication::where('corid',$program->id)->where('status','=','ENROLLED')->count()
            ]);
        }

        return new DashboardResources($applications);
    }

}
