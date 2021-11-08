<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMedicalInformationRequest;
use App\Models\MedicalAnswer;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use App\Http\Resources\MedicalInformation as MedicalInformationResources;
use Illuminate\Support\Facades\DB;

class MedicalInformationController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('view student-info')) {
            return abort(401);
        }

        $contacts = MedicalAnswer::where('user_id',auth()->user()->id)->get();
        return new MedicalInformationResources($contacts);
    }
    public function store(StoreMedicalInformationRequest $request)
    {
       // return $request;
        if (!auth()->user()->can('insert student-info')) {
            return abort(401);
        }
        DB::beginTransaction();
        try{
            $user_id = auth()->user()->id;
            MedicalAnswer::where('user_id',$user_id)->delete();
            if($request->has('medical_answers')){
                if(count($request->medical_answers) < 47){
                    return response()->json([
                        'message' => 'Incomplete answer. Please complete your answer and try again'], 406);
                }
                foreach($request['medical_answers'] as $answers=>$answer){
                    $medical_answer = MedicalAnswer::create(array_merge($answer,['user_id'=>$user_id,'quid'=>$answer['quid']]));
                }
            }
            DB::commit();
        }catch (QueryException $ex){
            return response()->json([
                'message' => 'Error found. Please try again'], 406);
            DB::rollBack();
        }
        return (new MedicalInformationResources($medical_answer))
            ->response()
            ->setStatusCode(201);
    }
}
