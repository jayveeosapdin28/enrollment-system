<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentPersonalInfoRequest;
use App\Http\Requests\UpdateStudentPersonalInfoRequest;
use App\Http\Resources\StudentPersonalInfo as StudentPersonalInfoResources;
use App\Models\StudentPersonalInfo;
use App\Models\User;
use Illuminate\Http\Request;

class StudentPersonalInfoController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('view student-info')) {
            return abort(401);
        }

        $perPage = $request->has('perPage') ? $request->input('perPage') : 10;
        $studentPersonalInfos = StudentPersonalInfo::with([])
            ->where(function($query) use ($request){
                if($request->has('query'))
                {
                    $query_string = $request->input('query');
                    $query->where('name', 'like', '%' . $query_string . '%');
                }
            })
            ->paginate($perPage);
        return new StudentPersonalInfoResources($studentPersonalInfos);
    }

    public function store(StoreStudentPersonalInfoRequest $request)
    {

        if (!auth()->user()->can('insert student-info')) {
            return abort(401);
        }
        $this->updateUserName($request);
        $studentPersonalInfoArr = array_merge($request->validated(),['user_id'=>auth()->user()->id]);
        $studentPersonalInfo = StudentPersonalInfo::create($studentPersonalInfoArr);

        return (new StudentPersonalInfoResources($studentPersonalInfo))
            ->response()
            ->setStatusCode(201);
    }

    public function show($id)
    {
        if (!auth()->user()->can('view student-info')) {
            return abort(401);
        }
        $studentPersonalInfo = StudentPersonalInfo::where('user_id',$id)->first();
        return $studentPersonalInfo ? new StudentPersonalInfoResources($studentPersonalInfo) :null;
    }

    public function update(UpdateStudentPersonalInfoRequest $request, $id)
    {
        if (!auth()->user()->can('update student-info')) {
            return abort(401);
        }
        $this->updateUserName($request);
        $studentPersonalInfo = StudentPersonalInfo::findOrFail($id);
        $studentPersonalInfo->update($request->validated());
        return (new StudentPersonalInfoResources($studentPersonalInfo))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (!auth()->user()->can('delete student-info')) {
            return abort(401);
        }
        $studentPersonalInfo = StudentPersonalInfo::findOrFail($id);
        $studentPersonalInfo->delete();

        return response(null, 204);
    }

    public function updateUserName(Request $request){
        $user = User::findOrFail(auth()->user()->id);
        $user->update(
            ['name'=> $request->studnam3.' '.$request->studnam1]
        );
    }
}
