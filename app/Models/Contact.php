<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = [
        'email1',
        'phone1',
        'user_id',
    ];
    public static function validate(){
        return [
            'email1' =>'nullable',
            'phone1' =>'required|numeric|unique:contacts',
        ];
    }

    public static function attributes()
    {
        return [
            'email1' => 'email address',
            'phone1' =>'contact number',
        ];
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
