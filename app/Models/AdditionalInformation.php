<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'scholarship',
        'lgbt',
        'tribe',
        'learning_module',
        'internet_connectivity',
        'user_id',
        'student_type'
    ];

    public static function validate(){
        return [
            'lgbt' => 'required',
            'tribe' => 'nullable|max:50',
            'scholarship' => 'nullable|max:255',
            'learning_module' => 'required',
            'internet_connectivity' => 'required',
            'student_type' => 'required',
        ];
    }

    public static function attributes()
    {
        return [
            'lgbt' => 'lgbt',
            'tribe' => 'tribe',
            'scholarship' => 'scholarship',
            'learning_module' => 'prepared learning module',
            'internet_connectivity' => 'internet connectivity status',
            'student_type' => 'student type',
        ];
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
