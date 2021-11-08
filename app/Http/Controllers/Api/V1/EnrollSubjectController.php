<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEnrollSubjectRequest;
use App\Models\EnrolledSubject;
use App\Models\EnrollmentApplication;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Resources\EnrollSubject as  EnrollSubjectResources;

class EnrollSubjectController extends Controller
{
    public function index(Request $request)
    {

        if (!auth()->user()->can('view registration')) {
            return abort(401);
        }

        $perPage = $request->has('perPage') ? $request->input('perPage') : 10;
        $subjects = Subject::with(['prospectus:id,corid'])
            ->where(function ($query) use ($request) {
                if ($request->has('query')) {
                    $query_string = $request->input('query');
                }
                if ($request->has('year') && $request->input('year') != '') {
                    $query_string = $request->input('year');
                    $query->where('subyear','=', $query_string);
                }
                if ($request->has('semester') &&  $request->input('semester') != '') {
                    $query_string = $request->input('semester');
                    $query->where('subsem','=', $query_string);
                }
            })
            ->whereHas('prospectus', function ($query) use ($request) {
                if ($request->has('program')) {
                    $query_string = $request->input('program');
                    $query->where('corid', $query_string);
                }
            })
            ->paginate($perPage);
        return new EnrollSubjectResources($subjects);
    }

    public function store(StoreEnrollSubjectRequest $request)
    {
        if (!auth()->user()->can('view registration')) {
            return abort(401);
        }

        $application = EnrollmentApplication::findOrFail($request->id);
        $application->update(['status'=> 'ON PROCESS','step' => 3]);
        foreach ($request->subjects as $subject){
            if(!EnrolledSubject::where('enrollment_application_id',$application->id)->where('subjects_id',$subject)->first()){
                EnrolledSubject::create([
                    'subjects_id'=>$subject,
                    'enrollment_application_id' => $application->id,
                    'status'=> 'ENROLLED'
                ]);
            }
        }

        return (new EnrollSubjectResources($application))
            ->response()
            ->setStatusCode(201);
    }
}
