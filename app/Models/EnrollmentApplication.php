<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrollmentApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'corid',
        'yearlevel',
        'campcode',
        'cureffec',
        'studsem',
        'studsection',
        'user_id',
        'idnumber',
        'status',
        'step',
        'enrollment_status',
    ];
    public static function validate(){
        return [
            'corid' => 'required',
            'yearlevel' => 'required',
            'campcode' => 'required',
            'cureffec' => 'required',
            'studsem' => 'required',
            'studsection' => 'nullable',
            'idnumber' => 'required_if:enrollment_status,OLD|max:15',
            'enrollment_status' => 'required',
        ];
    }

    public static function attributes()
    {
        return [
            'corid' => 'program',
            'yearlevel' => 'year level',
            'campcode' => 'campus',
            'cureffec' => 'academic year',
            'studsem' => 'semester',
            'studsection' => 'section',
            'idnumber' => 'student ID number',
            'enrollment_status' => 'enrollment status',
        ];
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function program(){
        return $this->belongsTo(Course::class,'corid');
    }
    public function subject(){
        return $this->belongsToMany(Subject::class,
            'enrolled_subjects',
            'enrollment_application_id',
            'subjects_id')
            ->withTimestamps();
    }
    public function subject_enrolled(){
        return $this->belongsToMany(Subject::class,
            'enrolled_subjects',
            'enrollment_application_id',
            'subjects_id')
            ->withTimestamps()->withPivotValue('status','ENROLLED');
    }


}
