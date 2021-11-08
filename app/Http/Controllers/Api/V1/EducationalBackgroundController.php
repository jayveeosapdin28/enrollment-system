<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEducationalBackgroundRequest;
use App\Http\Requests\UpdateEducationalBackgroundRequest;
use App\Models\EducationalBackground;
use Illuminate\Http\Request;
use App\Http\Resources\EducationalBackground as EducationalBackgroundResources;

class EducationalBackgroundController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('view student-info')) {
            return abort(401);
        }

        $perPage = $request->has('perPage') ? $request->input('perPage') : 10;
        $educational_backgrounds = EducationalBackground::with([])
            ->where(function($query) use ($request){
                if($request->has('query'))
                {
                    $query_string = $request->input('query');
                    $query->where('name', 'like', '%' . $query_string . '%');
                }
            })
            ->paginate($perPage);
        return new EducationalBackgroundResources($educational_backgrounds);
    }

    public function store(StoreEducationalBackgroundRequest $request)
    {

        if (!auth()->user()->can('insert student-info')) {
            return abort(401);
        }
        $educational_backgroundArr = array_merge($request->validated(),['user_id'=>auth()->user()->id]);
        $educational_background = EducationalBackground::create($educational_backgroundArr);

        return (new EducationalBackgroundResources($educational_background))
            ->response()
            ->setStatusCode(201);
    }

    public function show($id)
    {
        if (!auth()->user()->can('view student-info')) {
            return abort(401);
        }
        $educational_background = EducationalBackground::where('user_id',$id)->first();
        return $educational_background ? new EducationalBackgroundResources($educational_background) :null;
    }

    public function update(UpdateEducationalBackgroundRequest $request, $id)
    {
        if (!auth()->user()->can('update student-info')) {
            return abort(401);
        }
        $educational_background = EducationalBackground::findOrFail($id);
        $educational_background->update($request->validated());
        return (new EducationalBackgroundResources($educational_background))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (!auth()->user()->can('delete student-info')) {
            return abort(401);
        }
        $educational_background = EducationalBackground::findOrFail($id);
        $educational_background->delete();

        return response(null, 204);
    }
}
