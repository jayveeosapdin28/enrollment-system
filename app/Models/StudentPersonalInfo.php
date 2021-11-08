<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPersonalInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'studnam3',
        'studnam2',
        'studnam1',
        'studnam4',
        'studbday',
        'studcivilstat',
        'nationality',
        'religion_id',
        'gender',
        'user_id',
    ];
    public static function validate(){
        return [
            'studnam3' =>'required|max:30',
            'studnam2' =>'nullable|max:30',
            'studnam1' =>'required|max:30',
            'studnam4' =>'max:5',
            'studbday' =>'required',
            'studcivilstat' =>'required',
            'nationality' =>'required|max:50',
            'religion_id' =>'required',
            'gender' =>'required',
        ];
    }
    public static function attributes()
    {
        return [
            'studnam3' => 'first name',
            'studnam2' =>'middle name',
            'studnam1' =>'last name',
            'studnam4' =>'extension name',
            'studbday' =>'birthday',
            'studcivilstat' =>'marital status',
            'nationality' =>'nationality',
            'religion_id' =>'religion',
            'gender' =>'gender',
        ];
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
