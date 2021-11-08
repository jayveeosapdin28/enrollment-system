<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Religion;
use Illuminate\Http\Request;
use App\Http\Resources\Religion as ReligionResources;

class ReligionController extends Controller
{
    public function index(){
        return new ReligionResources(Religion::select('id','name')->get());
    }
}
