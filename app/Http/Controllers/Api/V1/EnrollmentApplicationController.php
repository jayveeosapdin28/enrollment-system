<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEnrollmentApplicationRequest;
use App\Http\Requests\UpdateEnrollmentApplicationRequest;
use App\Models\AdditionalInformation;
use App\Models\AddressDetails;
use App\Models\Contact;
use App\Models\EducationalBackground;
use App\Models\EnrollmentApplication;
use App\Models\FamilyInformation;
use App\Models\MedicalAnswer;
use App\Models\Signature;
use App\Models\StudentPersonalInfo;
use Illuminate\Http\Request;
use App\Http\Resources\EnrollmentApplication as EnrollmentApplicationResources;
use Illuminate\Validation\ValidationException;

class EnrollmentApplicationController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('view student-info')) {
            return abort(401);
        }

        $perPage = $request->has('perPage') ? $request->input('perPage') : 10;
        $enrollment_applications = EnrollmentApplication::with([])
            ->where(function($query) use ($request){
                if($request->has('query'))
                {
                    $query_string = $request->input('query');
                    $query->where('status', '=',  $query_string);
                }
            })
            ->paginate($perPage);
        return new EnrollmentApplicationResources($enrollment_applications);
    }

    public function store(StoreEnrollmentApplicationRequest $request)
    {
        $user_id = auth()->user()->id;
        if (!auth()->user()->can('insert student-info')) {
            return abort(401);
        }
        if(!Contact::where('user_id',$user_id)->first()){
            return response()->json([
                'message' => 'Please fill up contact information in your profile.'], 406);
        }
        if(!StudentPersonalInfo::where('user_id',$user_id)->first()){
            return response()->json([
                'message' => 'Please fill up profile information in your profile.'], 406);
        }
        if(!AddressDetails::where('user_id',$user_id)->first()){
            return response()->json([
                'message' => 'Please fill up address information in your profile.'], 406);
        }
        if(!EducationalBackground::where('user_id',$user_id)->first()){
            return response()->json([
                'message' => 'Please fill up educational background in your profile.'], 406);
        }
        if(!FamilyInformation::where('user_id',$user_id)->first()){
            return response()->json([
                'message' => 'Please fill up family information in your profile.'], 406);
        }
        if(!Signature::where('user_id',$user_id)->first()){
            return response()->json([
                'message' => 'Please provide your signature.'], 406);
        }
        if(!AdditionalInformation::where('user_id',$user_id)->first()){
            return response()->json([
                'message' => 'Please fill up additional information in your profile.'], 406);
        }
        if(!MedicalAnswer::where('user_id',$user_id)->first()){
            return response()->json([
                'message' => 'Please fill up your medical record.'], 406);
        }

        if(EnrollmentApplication::where([
            ['user_id',$user_id],
            ['status','=','PENDING'],
        ])
            ->first()){
            return response()->json([
                'message' => 'You still have  pending application.'], 406);
        }
        if(EnrollmentApplication::where([
            ['user_id',$user_id],
            ['status','=','ON PROCESS'],
        ])
            ->first()){
            return response()->json([
                'message' => 'You still have on process application.'], 406);
        }
        if(EnrollmentApplication::where([
            ['user_id',$user_id],
            ['cureffec',$request->cureffec],
            ['studsem',$request->studsem],
            ['status','=','ENROLLED'],
        ])
            ->first()){
            return response()->json([
                'message' => 'You are already enrolled'], 406);
        }
        $step = 1;
        if($request->enrollment_status == 'OLD'){
            $step = 2;
        }
        $enrollment_applicationArr = array_merge($request->validated(),['user_id'=>auth()->user()->id,'status'=> 'PENDING','step' => $step]);
        $enrollment_application = EnrollmentApplication::create($enrollment_applicationArr);

        return (new EnrollmentApplicationResources($enrollment_application))
            ->response()
            ->setStatusCode(201);
    }

    public function show($id)
    {
        if (!auth()->user()->can('view student-info')) {
            return abort(401);
        }
        $enrollment_application = EnrollmentApplication::where('user_id',$id)->first();
        return $enrollment_application ? new EnrollmentApplicationResources($enrollment_application) :null;
    }

    public function update(UpdateEnrollmentApplicationRequest $request, $id)
    {
        if (!auth()->user()->can('update student-info')) {
            return abort(401);
        }
        $enrollment_application = EnrollmentApplication::findOrFail($id);
        $enrollment_application->update($request->validated());
        return (new EnrollmentApplicationResources($enrollment_application))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (!auth()->user()->can('delete student-info')) {
            return abort(401);
        }
        $enrollment_application = EnrollmentApplication::findOrFail($id);
        $enrollment_application->delete();

        return response(null, 204);
    }
}
