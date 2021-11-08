<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSignatureRequest;
use App\Models\Signature;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use App\Http\Resources\Signature as SignatureResources;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SignatureController extends Controller
{
    public function store(StoreSignatureRequest $request)
    {
        if (!auth()->user()->can('insert student-info')) {
            return abort(401);
        }
        DB::beginTransaction();
        try{
            $user_id = auth()->user()->id;
            Signature::where('user_id',$user_id)->delete();
            Storage::delete(auth()->user()->id.".png");
            $signature = $request->signature;
            if (preg_match('/^data:image\/(\w+);base64,/', $signature)) {
                $data = substr($signature, strpos($signature, ',') + 1);
                $data = base64_decode($data);
                Storage::disk('public')->put("id_details/signature_".auth()->user()->id.".png", $data);
                $path = "public/id_details/signature_".auth()->user()->id.".png";
            }
            if( $request->has('signature_path')){
                $path = $request['signature']->storeAs('public', "id_details/signature_".auth()->user()->id.".png");
            }
            if($request->has('id_picture')){
                $id_picture = $request['id_picture']->storeAs('public', "id_details/id_picture_".auth()->user()->id.".png");
            }
            $signatures = Signature::create([
                'path' => $path,
                'user_id'=>$user_id,
                'id_picture'=>$id_picture
            ]);
            DB::commit();
        }catch (QueryException $e){
            DB::rollBack();
        }

        return (new SignatureResources($signatures))
            ->response()
            ->setStatusCode(201);
    }

}
