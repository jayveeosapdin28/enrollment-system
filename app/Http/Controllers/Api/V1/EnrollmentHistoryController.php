<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\EnrollmentApplication as EnrollmentApplicationResources;
use App\Models\EnrollmentApplication;
use Illuminate\Http\Request;

class EnrollmentHistoryController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('view student-info')) {
            return abort(401);
        }

        $perPage = $request->has('perPage') ? $request->input('perPage') : 10;
        $enrollment_histories = EnrollmentApplication::with(['program'])
            ->where('user_id',auth()->user()->id)
            ->where(function($query) use ($request){
                if($request->has('query'))
                {
                    $query_string = $request->input('query');
                }
            })
            ->paginate($perPage);
        return new EnrollmentApplicationResources($enrollment_histories);
    }
}
