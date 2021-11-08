<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    public function prospectus(){
        return $this->belongsTo(Prospectus::class,'prospectus_id');
    }
}
