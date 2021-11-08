<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Barangay as BarangayResources;
use App\Models\Barangay;
use Illuminate\Http\Request;

class BarangayController extends Controller
{
    public function show($code){
        return new BarangayResources(Barangay::select('id','desc')
            ->where('city_id',$code)
            ->get());
    }
}
