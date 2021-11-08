<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFamilyInformationRequest;
use App\Http\Requests\UpdateFamilyInformationRequest;
use App\Models\FamilyInformation;
use Illuminate\Http\Request;
use App\Http\Resources\FamilyInformation as FamilyInformationResources;

class FamilyInformationController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('view student-info')) {
            return abort(401);
        }

        $perPage = $request->has('perPage') ? $request->input('perPage') : 10;
        $family_informations = FamilyInformation::with([])
            ->where(function($query) use ($request){
                if($request->has('query'))
                {
                    $query_string = $request->input('query');
                    $query->where('name', 'like', '%' . $query_string . '%');
                }
            })
            ->paginate($perPage);
        return new FamilyInformationResources($family_informations);
    }

    public function store(StoreFamilyInformationRequest $request)
    {

        if (!auth()->user()->can('insert student-info')) {
            return abort(401);
        }
        $family_informationArr = array_merge($request->validated(),['user_id'=>auth()->user()->id]);
        $family_information =FamilyInformation::create($family_informationArr);

        return (new FamilyInformationResources($family_information))
            ->response()
            ->setStatusCode(201);
    }

    public function show($id)
    {
        if (!auth()->user()->can('view student-info')) {
            return abort(401);
        }
        $family_information = FamilyInformation::where('user_id',$id)->first();
        return $family_information ? new FamilyInformationResources($family_information) :null;
    }

    public function update(UpdateFamilyInformationRequest $request, $id)
    {
        if (!auth()->user()->can('update student-info')) {
            return abort(401);
        }
        $family_information =FamilyInformation::findOrFail($id);
        $family_information->update($request->validated());
        return (new FamilyInformationResources($family_information))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (!auth()->user()->can('delete student-info')) {
            return abort(401);
        }
        $family_information =FamilyInformation::findOrFail($id);
        $family_information->delete();

        return response(null, 204);
    }
}
