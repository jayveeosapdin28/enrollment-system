<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\EnrollmentApplication;
use Illuminate\Http\Request;
use App\Http\Resources\Assessment as AssessmentResources;

class AssessmentController extends Controller
{
    public function index(Request $request){
        if (!auth()->user()->can('view assessment')) {
            return abort(401);
        }
       // return $request;
        $perPage = $request->has('perPage') ? $request->input('perPage') : 10;

        $enrollment_applications = EnrollmentApplication::with(['user:id,name','program'])
            ->where(function($query) use ($request){

                if($request->has('query'))
                {
                    $query_string = $request->input('query');
                    if($query_string != '' || $query_string != null){
                        $query->where('idnumber','like', '%' . $query_string . '%');
                    }
                }
            })
            ->where(function ($query) use ($request) {
                if($request->has('status'))
                {
                    $query_string = $request->input('status');
                    if($request->input('status') == '4'){
                        $query->where('step','>=',$query_string);
                    }
                    else{
                        $query->where('step','=',$query_string);
                    }
                }
                //$query->where('status','=','ON PROCESS');
            })
            ->paginate($perPage);
        return new AssessmentResources($enrollment_applications);
    }
    public function getAssessment($id){
        return new AssessmentResources(
            Assessment::where('enrollment_application_id',$id)->get()
        );
    }
}
