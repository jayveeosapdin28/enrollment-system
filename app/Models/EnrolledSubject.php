<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrolledSubject extends Model
{
    use HasFactory;
    protected $fillable =[
      'status',
      'enrollment_application_id',
      'subjects_id'
    ];

    protected $appends = [''];

    public function subject(){
        return $this->belongsTo(Subject::class,'subjects_id');
    }
    public function enrollmenApplication(){
        return $this->belongsTo(EnrollmentApplication::class,'enrollment_application_id');
    }
}
