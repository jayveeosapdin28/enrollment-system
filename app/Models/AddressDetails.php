<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddressDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'brthhouseno',
        'brthstreet',
        'brthbrgy',
        'brthtown',
        //'brthzipcode',
        'brthprovince',
        'brthcountry',
        'addhouseno',
        'addstreet',
        'addbrgy',
        'addtown',
        //'addzipcode',
        'addprovince',
        'addcountry',
        'user_id',
    ];

    public static function validate()
    {
        return [
            'brthhouseno' => 'nullable|max:10|numeric',
            'brthstreet' => 'nullable|max:50',
            'brthbrgy' => 'required',
            'brthtown' => 'required',
            'brthzipcode' => 'nullable',
            'brthprovince' => 'required',
            'brthcountry' => 'required',
            'addhouseno' => 'nullable|max:10|numeric',
            'addstreet' => 'nullable|max:50',
            'addbrgy' => 'required',
            'addtown' => 'required',
            'addzipcode' => 'nullable',
            'addprovince' => 'required',
            'addcountry' => 'required',
        ];
    }

    public static function attributes()
    {
        return [
            'brthhouseno' => 'house number',
            'brthstreet' => 'street',
            'brthbrgy' => 'barangay',
            'brthtown' => 'town/city',
            'brthzipcode' => 'zipcode',
            'brthprovince' => 'province',
            'brthcountry' => 'country',
            'addhouseno' => 'house number',
            'addstreet' => 'street',
            'addbrgy' => 'barangay',
            'addtown' => 'town/city',
            'addzipcode' => 'zipcode',
            'addprovince' => 'province',
            'addcountry' => 'country',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
