<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdditionalInformationRequest;
use App\Http\Requests\UpdateAdditionalInformationRequest;
use App\Models\AdditionalInformation;
use Illuminate\Http\Request;
use App\Http\Resources\AdditionalInformation as AdditionalInformationResources;

class AdditionalInformationController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('view student-info')) {
            return abort(401);
        }

        $perPage = $request->has('perPage') ? $request->input('perPage') : 10;
        $additional_informations = AdditionalInformation::with([])
            ->where(function($query) use ($request){
                if($request->has('query'))
                {
                    $query_string = $request->input('query');
                    $query->where('name', 'like', '%' . $query_string . '%');
                }
            })
            ->paginate($perPage);
        return new AdditionalInformationResources($additional_informations);
    }

    public function store(StoreAdditionalInformationRequest $request)
    {

        if (!auth()->user()->can('insert student-info')) {
            return abort(401);
        }
        $additional_informationArr = array_merge($request->validated(),['user_id'=>auth()->user()->id]);
        $additional_information = AdditionalInformation::create($additional_informationArr);

        return (new AdditionalInformationResources($additional_information))
            ->response()
            ->setStatusCode(201);
    }

    public function show($id)
    {
        if (!auth()->user()->can('view student-info')) {
            return abort(401);
        }
        $additional_information = AdditionalInformation::where('user_id',$id)->first();
        return $additional_information ? new AdditionalInformationResources($additional_information) :null;
    }

    public function update(UpdateAdditionalInformationRequest $request, $id)
    {
        if (!auth()->user()->can('update student-info')) {
            return abort(401);
        }
        $additional_information =AdditionalInformation::findOrFail($id);
        $additional_information->update($request->validated());
        return (new AdditionalInformationResources($additional_information))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (!auth()->user()->can('delete student-info')) {
            return abort(401);
        }
        $additional_information =AdditionalInformation::findOrFail($id);
        $additional_information->delete();

        return response(null, 204);
    }
}
