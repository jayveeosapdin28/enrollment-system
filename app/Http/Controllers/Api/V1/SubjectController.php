<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Resources\Subject as SubjectResources;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('view student-info')) {
            return abort(401);
        }

        $perPage = $request->has('perPage') ? $request->input('perPage') : 10;
        $subjects = Subject::with(['prospectus:id,corid'])
            ->where(function ($query) use ($request) {
                if ($request->has('query')) {
                    $query_string = $request->input('query');
                }
            })
            ->orWhereHas('prospectus', function ($query) use ($request) {
                if ($request->has('program')) {
                    $query_string = $request->input('program');
                    $query->where('corid', $query_string);
                }
            })
            ->paginate($perPage);
        return new SubjectResources($subjects);
    }
}
