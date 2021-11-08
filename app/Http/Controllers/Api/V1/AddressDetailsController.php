<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddressDetailsRequest;
use App\Http\Requests\UpdateAddressDetailsRequest;
use App\Models\AddressDetails;
use Illuminate\Http\Request;
use App\Http\Resources\AddressDetails as AddressDetailsResources;

class AddressDetailsController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('view contact')) {
            return abort(401);
        }

        $perPage = $request->has('perPage') ? $request->input('perPage') : 10;
        $address_details = AddressDetails::with([])
            ->where(function($query) use ($request){
                if($request->has('query'))
                {
                    $query_string = $request->input('query');
                    $query->where('name', 'like', '%' . $query_string . '%');
                }
            })
            ->paginate($perPage);
        return new AddressDetailsResources($address_details);
    }

    public function store(StoreAddressDetailsRequest $request)
    {

        if (!auth()->user()->can('insert student-info')) {
            return abort(401);
        }
        $address_detailArr = array_merge($request->validated(),['user_id'=>auth()->user()->id]);
        $address_detail = AddressDetails::create($address_detailArr);

        return (new AddressDetailsResources($address_detail))
            ->response()
            ->setStatusCode(201);
    }

    public function show($id)
    {
        if (!auth()->user()->can('view student-info')) {
            return abort(401);
        }
        $address_detail = AddressDetails::where('user_id',$id)->first();
        return $address_detail ? new AddressDetailsResources($address_detail) :null;
    }

    public function update(UpdateAddressDetailsRequest $request, $id)
    {
        if (!auth()->user()->can('update student-info')) {
            return abort(401);
        }
        $address_detail = AddressDetails::findOrFail($id);
        $address_detail->update($request->validated());
        return (new AddressDetailsResources($address_detail))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (!auth()->user()->can('delete student-info')) {
            return abort(401);
        }
        $address_detail = AddressDetails::findOrFail($id);
        $address_detail->delete();

        return response(null, 204);
    }
}
