<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFeeRequest;
use App\Models\Assessment;
use App\Models\EnrollmentApplication;
use App\Models\Fee;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Resources\Fee as FeeResources;
use Illuminate\Support\Facades\DB;

class FeeController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('view fee')) {
            return abort(401);
        }

        $perPage = 50;
        $contacts = Fee::with([])
            ->select('id','feename','feeamount1','feeclass','feecat','feecatno','feeclass')
            ->where(function($query) use ($request){
                if($request->has('query'))
                {
                    $query_string = $request->input('query');
                }
            })
            ->orderBy('feecatno','ASC')
            ->paginate($perPage);
        return new FeeResources($contacts);
    }
    public function store(StoreFeeRequest $request)
    {

        if (!auth()->user()->can('insert fee')) {
            return abort(401);
        }
        DB::beginTransaction();
        try{
            $assessment = Assessment::where('enrollment_application_id',$request->enrollment_id)->first();
            Assessment::where('enrollment_application_id',$request->enrollment_id)->delete();
            if(!empty($assessment)){
                $asstransno = $assessment->asstransno;
            }
            else{
                $asstransno  = IdGenerator::generate([
                    'table' => 'assessments',
                    'field' => 'asstransno' ,
                    'length' => 15,
                    'reset_on_prefix_change'=> true,
                    'prefix' => 'MMC2021'
                ]);
            }

            if($request->has('selected_fees')){
                foreach($request['selected_fees'] as $fees=>$fee){
                    $assessment = new Assessment();
                    $assessment->enrollment_application_id = $request->enrollment_id;
                    $assessment->feeid = $fee['id'];
                    $assessment->feename = $fee['feename'];
                    $assessment->feeamount1 = $fee['feeamount1'];
                    $assessment->feeclass = $fee['feeclass'];
                    $assessment->asstransno = $asstransno;
                    $assessment->save();
                }
            }
            $application = EnrollmentApplication::find($request->enrollment_id);
            $application->update(['step'=>4]);
            DB::commit();
        }
        catch (QueryException $e){
            DB::rollBack();
        }

        return (new FeeResources($assessment))
            ->response()
            ->setStatusCode(201);
    }
}
