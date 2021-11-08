<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationalBackground extends Model
{
    use HasFactory;

    protected $fillable = [
        'elemschool',
        'elemsy',
        'hsschool',
        'hssy',
        'college',
        'collegesy',
        'user_id'
    ];
    public static function validate(){
        return [
            'elemschool' =>'required|max:100',
            'elemsy' =>'required|max:10',
            'hsschool' =>'required|max:100',
            'hssy' =>'required|max:10',
            'college' =>'nullable|max:100',
            'collegesy' =>'nullable|max:10',
        ];
    }

    public static function attributes()
    {
        return [
            'elemschool' =>'elementary/primary school name',
            'elemsy' =>'year graduated',
            'hsschool' =>'high/secondary school name',
            'hssy' =>'year graduated',
            'college' =>'college/tertiary school name',
            'collegesy' =>'year graduated',
        ];
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
