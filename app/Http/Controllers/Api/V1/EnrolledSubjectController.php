<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateEnrolledSubjectRequest;
use App\Models\EnrolledSubject;
use Illuminate\Http\Request;
use App\Http\Resources\EnrolledSubject as EnrolledSubjectResources;

class EnrolledSubjectController extends Controller
{
    public function index(Request $request)
    {

        if (!auth()->user()->can('view registration')) {
            return abort(401);
        }

        $perPage = $request->has('perPage') ? $request->input('perPage') : 10;
        $subjects = EnrolledSubject::with([
            'subject:id,subcode,subdesc,subunit',
            'enrollmenApplication:id,studsem,yearlevel,cureffec,step'
        ])->where(function ($query) use ($request) {
            if ($request->has('query')) {
                $query_string = $request->input('query');
            }
            $query->where('enrollment_application_id',$request->input('app_id'));
//            $query->whereHas('subject', function ($query) use ($request) {
//                if ($request->has('year') && $request->input('year') != '') {
//                    $query_string = $request->input('year');
//                    $query->where('subyear','=', $query_string);
//                }
//                if ($request->has('semester') &&  $request->input('semester') != '') {
//                    $query_string = $request->input('semester');
//                    $query->where('subsem','=', $query_string);
//                }
//            });
        })


            ->paginate($perPage);
        return new EnrolledSubjectResources($subjects);
    }
    public function update(UpdateEnrolledSubjectRequest $request, $id)
    {
        if (!auth()->user()->can('update registration')) {
            return abort(401);
        }
        $subject = EnrolledSubject::findOrFail($id);
        $subject->update(["status"=>"DROPPED"]);
        return (new EnrolledSubjectResources($subject))
            ->response()
            ->setStatusCode(202);
    }
    public function destroy($id)
    {
        if (!auth()->user()->can('delete registration')) {
            return abort(401);
        }
        $subject = EnrolledSubject::findOrFail($id);
        $subject->delete();

        return response(null, 204);
    }
}
