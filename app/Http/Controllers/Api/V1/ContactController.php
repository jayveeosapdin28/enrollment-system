<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Resources\Contact as ContactResources;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('view student-info')) {
            return abort(401);
        }

        $perPage = $request->has('perPage') ? $request->input('perPage') : 10;
       $contacts = Contact::with([])
            ->where(function($query) use ($request){
                if($request->has('query'))
                {
                    $query_string = $request->input('query');
                    $query->where('name', 'like', '%' . $query_string . '%');
                }
            })
            ->paginate($perPage);
        return new ContactResources($contacts);
    }

    public function store(StoreContactRequest $request)
    {

        if (!auth()->user()->can('insert student-info')) {
            return abort(401);
        }
        $contactArr = array_merge($request->validated(),['user_id'=>auth()->user()->id]);
        $contact = Contact::create($contactArr);

        return (new ContactResources($contact))
            ->response()
            ->setStatusCode(201);
    }

    public function show($id)
    {
        if (!auth()->user()->can('view student-info')) {
            return abort(401);
        }
        $contact = Contact::where('user_id',$id)->first();
        return $contact ? new ContactResources($contact) :null;
    }

    public function update(UpdateContactRequest $request, $id)
    {
        if (!auth()->user()->can('update student-info')) {
            return abort(401);
        }
        $contact = Contact::findOrFail($id);
        $contact->update($request->validated());
        return (new ContactResources($contact))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (!auth()->user()->can('delete student-info')) {
            return abort(401);
        }
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return response(null, 204);
    }

}
