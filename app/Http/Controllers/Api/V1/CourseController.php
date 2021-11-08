<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Resources\Course as CourseResources;

class CourseController extends Controller
{
    public function index(){
        return new CourseResources(Course::select('id','corcode','cordesc','cormajor','college_id')
            ->orderBy('cordesc', 'ASC')
            ->get());
    }
}
