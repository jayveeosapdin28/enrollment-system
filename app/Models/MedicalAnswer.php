<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalAnswer extends Model
{
    use HasFactory;
//    protected $casts = [
//        'date'  => 'date:Y-m-d',
//        'joined_at' => 'datetime:Y-m-d H:00',
//    ];
    protected $fillable =[
      'quid',
      'user_id',
      'answer',
      'sub_answer',
      'date',
    ];

}
