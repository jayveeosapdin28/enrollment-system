<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Region as RegionResources;
use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function index($code){
        return new RegionResources(Region::select('id','desc')
            ->where('reg_code',$code)
            ->get());
    }
}
