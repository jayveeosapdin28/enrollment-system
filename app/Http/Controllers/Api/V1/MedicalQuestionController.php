<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\MedicalQuestion;
use Illuminate\Http\Request;
use App\Http\Resources\MedicalQuestion as MedicalQuestionResources;

class MedicalQuestionController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('view student-info')) {
            return abort(401);
        }

        $perPage = $request->has('perPage') ? $request->input('perPage') : 10;
        $questions = MedicalQuestion::all()->groupBy('category');
        return new MedicalQuestionResources($questions);
    }
}
