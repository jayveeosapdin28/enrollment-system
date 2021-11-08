<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    protected $fillable =[
        'enrollment_application_id ',
        'asstransno',
        'feeid',
        'feeamount2',
        'asscat',
        'ornumber',
        'datapayment',
    ];
}
