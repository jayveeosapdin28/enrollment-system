<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\City as CityResources;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function show($id){
        return new CityResources(City::select('id','desc')
            ->where('prov_id',$id)
            ->get());
    }
}
